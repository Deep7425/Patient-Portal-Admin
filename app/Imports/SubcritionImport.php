<?php

namespace App\Imports;
use App\Models\User;
use App\Models\UsersSubscriptions;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\UserSubscriptionsTxn;
use App\Models\UserSubscribedPlans;
use App\Models\Plans;
use App\Models\ApptLink;
use App\Models\PlanPeriods;
use App\Models\ReferralMaster;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ShouldQueueWithoutChain;
class SubcritionImport implements WithHeadingRow,ToCollection,WithChunkReading,ShouldQueueWithoutChain
{
  use RemembersRowNumber;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)    
    {

      dd($rows);
    
      foreach($rows as $k=> $labdata) {  
        $userDAta=User::where('mobile_no', $labdata['mobile'])->select('id')->where('parent_id', 0)->first();
     
       if($userDAta){
        $labdata['user_id']=(isset($userDAta->id)) ? $userDAta->id : null;
        $this->Createsubcription($labdata,$k);	
      }
 }

    }


    public function Createsubcription($data,$roWcount) {
//dd($roWcount);
//dd( $data['corporate']);
      if($data['plan_id']==''){
        Session::flash('message', "Please Provide Plan Id");
        return back();
      }else{
        if($roWcount==0){
          $planData= getPlanDetails($data['plan_id']);
          $couponData= $this->ApplyReferralCodeAdmin($data);
          Session::put('discountPrice',$planData->discount_price);
          Session::put('price',$planData->price);

          Session::put('referral_user_id',$couponData['referral_user_id']);
          Session::put('coupon_discount',$couponData['coupon_discount']);
        }
      // dd(Session::get('coupon_discount'));
        if($data['referral_code']){
        
            $data['order_total']=Session::get('price')-Session::get('coupon_discount')-Session::get('discountPrice');	
              if(Session::get('referral_user_id')){
                $data['referral_user_id']=Session::get('referral_user_id');
              }

              if(Session::get('coupon_discount')){
                $data['coupon_discount']= Session::get('coupon_discount');
              }
           
           }else{
            $data['order_total']=Session::get('price')-Session::get('discountPrice');
            $data['referral_user_id']='';
            $data['coupon_discount']='';
           }
        
      }
     
        // $orderId = "SUBS"."1";
        // $userSubs = UsersSubscriptions::orderBy("id","DESC")->first();
        // if(!empty($userSubs)){
        //     $sid = $userSubs->id + 1;
        //     $orderId = "SUBS".$sid;
        // }
        // $data['subcribetime']=  Carbon::parse($data['subcribetime'])->format('Y-m-d');
        // dd($data['subcribetime']);
        if($data['subcribetime']){
          $subcribedate= Carbon\Carbon::parse($data['subcribetime'])->format('m/d/Y');
           
         
        }
       
    
      $subscription =  UsersSubscriptions::create([
        'login_id' => Session::get('id'),
         'user_id' => $data['user_id'],
       //  'order_id' => $orderId,
         'payment_mode' => $data['payment_mode'],
         'ref_code' => $data['referral_user_id'],
         // 'coupon_id' => null,
         // 'tax' => $data['tax'],
         'created_at' => $subcribedate,
         'coupon_discount' => $data['coupon_discount'],
         'order_subtotal' => $data['order_total'],
         'order_total' => $data['order_total'],
         'order_status' => ($data['payment_mode'] == '6') ? 0 : 1,
         'added_by' => $data['sale_by'],
         'remark' => $data['remarks'],
         'organization_id' => $data['corporate'],
         'meta_data' => json_encode($data),
      ]);
    
      $subs_id = @$subscription->id;
      $plan = Plans::where('id',$data['plan_id'])->first();
      $subscribedPlan = new UserSubscribedPlans;
      $subscribedPlan->plan_id = $plan->id;
      $subscribedPlan->plan_price = $plan->price;
      $subscribedPlan->discount_price =  $plan->discount_price;
      $subscribedPlan->plan_duration_type = $plan->plan_duration_type;
      $subscribedPlan->plan_duration = $plan->plan_duration;
      $subscribedPlan->appointment_cnt = $plan->appointment_cnt;
      $subscribedPlan->lab_pkg = $plan->lab_pkg;
      $subscribedPlan->meta_data = json_encode($plan);
      $subscription->UserSubscribedPlans()->save($subscribedPlan);
    
    //for the plan trail period
      $duration_type = $plan->plan_duration_type;
      if($duration_type=="d") {
        $duration_in_days = $plan->plan_duration;
      }
      elseif ($duration_type=="m") {
        $duration_in_days = (30*$plan->plan_duration);
      }
      elseif ($duration_type=="y") {
        $duration_in_days = (366*$plan->plan_duration);
      }
      $end_date = date('Y-m-d H:i:s', strtotime($subcribedate.'+'.$duration_in_days.' days'));
      $PlanPeriods =  PlanPeriods::create([
         'subscription_id' => $subs_id,
         'subscribed_plan_id' => $subscribedPlan->id,
         'user_plan_id' => $data['plan_id'],
         'user_id' => $data['user_id'],
         'start_trail' => $subcribedate,
         'end_trail'=> $end_date,
         'remaining_appointment' => $plan->appointment_cnt,
         'specialist_appointment_cnt' => $plan->specialist_appointment_cnt,
         'lab_pkg_remaining' => 0,
         'status' => 1
      ]);
      if($data['payment_mode'] == '2'){
          $tran_mode = "Cheque";
      }
      else if($data['payment_mode'] == '3'){
          $tran_mode = "Cash";
      }
      else if($data['payment_mode'] == '4'){
          $tran_mode = "Online Payment";
      }else if($data['payment_mode'] == '5'){
          $tran_mode = "Free";
      }
    
      // $tracking_id = rand(100000000000,999999999999);
      // $trackingIdExist =  UserSubscriptionsTxn::where("tracking_id",$tracking_id)->count();
      // if($trackingIdExist > 0){
          // $tracking_id = $tracking_id+1;
      // }
      $tracking_id = null;
      if(isset($data['tracking_id'])){
          $tracking_id = $data['tracking_id'];
      }
      UserSubscriptionsTxn::create([
          'subscription_id' => $subs_id,
          'tracking_id' => $tracking_id,
          'tran_mode'=> $tran_mode,
          'currency'=> "INR",
          'payed_amount'=>$data['order_total'],
          'tran_status' => "Success",
          'trans_date' => date('d-m-Y')
      ]);
    
    
        
    }
    
    
    function ApplyReferralCodeAdmin($data) {
    
      // $data = $request->all();
       $success = 0;
       $res = ["success"=>$success,"referral_user_id"=>"","coupon_discount"=>""];
      
         $refData = ReferralMaster::where('code', $data['referral_code'])->where(['status'=>1,'delete_status'=>1])->first();
         if(!empty($refData)){
           $dt = date('Y-m-d');
           if($refData->code_last_date < $dt){
             $success = 0;
           }
           if(!empty($refData->plan_ids)) {
             $plan_ids = explode(",",$refData->plan_ids);
             if(in_array($data['plan_id'],$plan_ids)) {
               $dis = getDiscount($refData->referral_discount_type,$refData->referral_discount,$data['plan_id']);
               $res['type'] =  2;
               $res['referral_user_id'] =  $refData->id;
               $res['coupon_discount'] =  $dis;
               $success = 1;
             }
           }
           else{
             $dis = getDiscount($refData->referral_discount_type,$refData->referral_discount,$data['plan_id']);
             $res['type'] =  2;
             $res['referral_user_id'] =  $refData->id;
             $res['coupon_discount'] =  $dis;
             $success = 1;
           }
         }
       // }
       $res['success'] =  $success;
       return $res;
     
      }
      public function batchSize(): int
      {
          return 1000;
      }
      
      public function chunkSize(): int
      {
          return 300;
      }

}
     

