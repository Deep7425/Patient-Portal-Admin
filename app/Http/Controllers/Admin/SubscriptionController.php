<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Plans;
use App\Models\PlanPeriods;
use App\Models\UserSubscribedPlans;
use App\Models\UsersSubscriptions;
use App\Models\OrganizationMaster;
use App\Models\UserSubscriptionsTxn;
use App\Models\ehr\Appointments;
use App\Models\ReferralMaster;
use App\Http\Controllers\PaytmChecksum;
use App\Imports\SubscriptionExport;
use App\Imports\SubcritionImport;
use Session;
use DB;
use URL;
use Mail;
use Auth;
use File;
use Hash;
use Route;
use App\Models\EmailTemplate;
use App\Models\Templates;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ehr\AppointmentOrder;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\ApptLink;
class SubscriptionController extends Controller
{
    /*
     * Create a new controller instance.
     *
     * @return void
     */
   public function planMaster(Request $request)  {
     $search = '';
     if ($request->isMethod('post')) {
       $params = array();
         if (!empty($request->input('search'))) {
             $params['search'] = base64_encode($request->input('search'));
         }
		 if (!empty($request->input('page_no'))) {
             $params['page_no'] = base64_encode($request->input('page_no'));
         }
         return redirect()->route('plans.planMaster',$params)->withInput();
       }
       else {
         $filters = array();
         $plans = Plans::Where("delete_status",'1')->orderBy('id', 'desc')->paginate(25);
		 $page = 25;
		 if(!empty($request->input('page_no'))) {
			$page = base64_decode($request->input('page_no'));
		 }
         if ($request->input('search')  != '') {
           $search = base64_decode($request->input('search'));
           $plans = Plans::where('plan_title','like','%'.$search.'%')->Where("delete_status",'1')->orderBy('id', 'desc')->paginate($page);
         }
       }
       return view('admin.subscription.planMaster',compact('plans'));
   }

   public function planMasterAdd(Request $request){
         if ($request->isMethod('post')) {
          $data = $request->all();
          $user =  Plans::create([
          'plan_title' => $data['plan_title'],
          'slug' => $data['slug'],
          'price' => $data['price'],
          'discount_price' => $data['discount_price'],
          'plan_duration_type' => $data['plan_duration_type'],
          'plan_duration' => $data['plan_duration'],
          'appointment_cnt' => $data['appointment_cnt'],
          'specialist_appointment_cnt' => $data['specialist_appointment_cnt'],
           'max_appointment_fee' => $data['max_appointment_fee'],
          'lab_pkg' => $data['lab_pkg'],
          'lab_pkg_title' => $data['lab_pkg_title'],
          'max_patient_count' => $data['max_patient_count'],
          'content' => $data['content'],
          'is_best' => $data['is_best'],
          'type' => $data['type'],
          ]);
          Session::flash('message', "Plan Added Successfully");
          return 1;
       }
	   else{
		    return view('admin.subscription.planMasterAdd');
	   }
   }
   public function editPlans(Request $request) {
	   $data = $request->all();
       $plan = Plans::Where( 'id', '=', $data['id'])->first();
       return view('admin.subscription.planMasterEdit',compact('plan'));
   }
   public function updatePlansMaster(Request $request) {
     if ($request->isMethod('post')) {
         $data = $request->all();
         $id = $data['id'];
         $user =  Plans::where('id', $id)->update(array(
           'plan_title' => $data['plan_title'],
           'slug' => $data['slug'],
           'price' => $data['price'],
           'discount_price' => $data['discount_price'],
           'plan_duration_type' => $data['plan_duration_type'],
           'plan_duration' => $data['plan_duration'],
           'max_appointment_fee' => $data['max_appointment_fee'],
           'appointment_cnt' => $data['appointment_cnt'],
		   'specialist_appointment_cnt' => $data['specialist_appointment_cnt'],
           'lab_pkg' => $data['lab_pkg'],
           'lab_pkg_title' => $data['lab_pkg_title'],
           'max_patient_count' => $data['max_patient_count'],
           'content' => $data['content'],
           'is_best' => $data['is_best'],
		   'type' => $data['type'],
         ));
        Session::flash('message', "Plan Updated Successfully");
        return 1;
       }
   }
   public function deletePlanMaster(Request $request) {
	  $data = $request->all();
     Plans::where('id',$data['id'])->update(array('delete_status' => '0'));
     Session::flash('message', "Plan Deleted Successfully");
     return 1;
   }
   public function updatePlanStatus(Request $request) {
     if($request->isMethod('post')) {
        $data = $request->all();
        if($data['status'] == 0){
          Plans::where('id',$data['id'])->update(['status' => 1]);
          return 1;
        }
        else{
          Plans::where('id',$data['id'])->update(['status' => 0]);
          return 2;
        }
     }
   }

     public function subscriptionMaster(Request $request)  {
     $search = '';
     if ($request->isMethod('post')) {
       $params = array();
         if (!empty($request->input('search'))) {
             $params['search'] = base64_encode($request->input('search'));
         }
		 if ($request->input('type') != "") {
             $params['type'] = base64_encode($request->input('type'));
         }
		 if (!empty($request->input('start_date'))) {
             $params['start_date'] = base64_encode($request->input('start_date'));
         }
		 if (!empty($request->input('end_date'))) {
             $params['end_date'] = base64_encode($request->input('end_date'));
         }
		 if ($request->input('payment_mode') != "") {
             $params['payment_mode'] = base64_encode($request->input('payment_mode'));
         }
		 if ($request->input('plan_id') != "") {
             $params['plan_id'] = base64_encode($request->input('plan_id'));
         }
		 if ($request->input('code') != "") {
             $params['code'] = base64_encode($request->input('code'));
         }
		 if ($request->input('name') != "") {
			$params['name'] = base64_encode($request->input('name'));
		 }
		 if ($request->input('status') != "") {
			$params['status'] = base64_encode($request->input('status'));
		 }
		 if (!empty($request->input('page_no'))) {
             $params['page_no'] = base64_encode($request->input('page_no'));
         }
		 if (!empty($request->input('file_type'))) {
			 $params['file_type'] = base64_encode($request->input('file_type'));
		 }
		 if (!empty($request->input('organization_id'))) {
			 $params['organization_id'] = base64_encode($request->input('organization_id'));
		 }
         return redirect()->route('subscription.subscriptionMaster',$params)->withInput();
       }
       else {
         $page = 25;
		 if(!empty($request->input('page_no'))) {
			$page = base64_decode($request->input('page_no'));
		 }
		$file_type = base64_decode($request->input('file_type'));
		 $query = UsersSubscriptions::with(["PlanPeriods.Plans","UserSubscribedPlans.PlanPeriods","User","ReferralMaster"])->whereNotNull("id");

               
         if ($request->input('type')  != '') {
			 $type = base64_decode($request->input('type'));
			 $query->where('order_status',$type);
		 }
		 if ($request->input('payment_mode')  != '') {
			 $payment_mode = base64_decode($request->input('payment_mode'));
			 $query->where('payment_mode',$payment_mode);
		 }
		  if($request->input('plan_id')  != '') {
			 $plan_id = base64_decode($request->input('plan_id'));
			 $pIds = getPlanIdToSlug($plan_id);
			 $query->whereHas('PlanPeriods', function($q)  use ($pIds) {$q->whereIn('user_plan_id',$pIds);});
		 }
         if($request->input('search')  != '') {
			$search = base64_decode($request->input('search'));
			$query->where('plan_title','like','%'.$search.'%');
         }
		 if($request->input('organization_id')  != '') {
			$organization_id = base64_decode($request->input('organization_id'));
			$query->where('organization_id',$organization_id);
         }
		 if($request->input('code')  != '') {
			$code = base64_decode($request->input('code'));
			if($code == "blank"){
				$code = null;
			}
			if($code == "emitra"){
				$query->where('hg_miniApp',2);
			}
			else{
				$query->where('ref_code',$code)->where('hg_miniApp','!=',2);
			}
         }
        if($request->input('name')  != '') {
  			$name = base64_decode($request->input('name'));
  			$query->whereHas('User', function($q)  use ($name) {
          $q->where(function ($q1) use($name) {
              $q1->where(DB::raw("CONCAT(IFNULL(first_name,''),' ',IFNULL(last_name,''))") , 'like', '%'.$name.'%')
              ->orWhere('mobile_no', $name);
          });
        });
       }
       if($request->input('status')  != '') {
  			$status = base64_decode($request->input('status'));
        $query->whereHas('PlanPeriods', function($q)  use ($status) {
          $q->Where('status', $status);
        });
       }

		 if(!empty($request->input('start_date')) || !empty($request->input('end_date'))) {
			if(!empty($request->input('start_date'))) {
				$start_date = date('Y-m-d',strtotime(base64_decode($request->input('start_date'))));
				$query->whereRaw('date(created_at) >= ?', [$start_date]);
			}
			if(!empty($request->input('end_date')))	{
				$end_date = date('Y-m-d',strtotime(base64_decode($request->input('end_date'))));
				$query->whereRaw('date(created_at) <= ?', [$end_date]);
			}
		}
		if($file_type == "excel") {
			/*$orders = AppointmentOrder::where(['type'=>0,'order_status'=>1])->where('doc_id','!=',24)->groupBy("order_by")->get();
			if(count($orders)>0){
				foreach($orders as $raw){
					if(!empty($raw->meta_data)){
						$meta_data = json_decode($raw->meta_data,true);
						$patient_name = $meta_data['patient_name'];
						$mobile_no = $meta_data['mobile_no'];
					}
					$cnt = AppointmentOrder::where(['order_status'=>1])->where('doc_id','!=',24)->where('type','!=',0)->where('order_by',$raw->order_by)->count();
					$sub =  "NO";
					$isSubs = checkUserSubcription($raw->order_by);
					if($isSubs){
						$sub = "Yes";
					}
					// if($cnt > 0){
					$subsArray[] = array(
						 $patient_name,
						 $mobile_no,
						 $cnt,
						 $sub,
						 '',
						 '',
						 '',
						 '',
						 '',
						 '',
						 ''
					 );
					// }
				}
			}
			return Excel::download(new SubscriptionExport($subsArray), 'subscription.xlsx');
			*/
			
			$subsData = $query->orderBy('id', 'desc')->get();
			// $subsData->each(function($subs, $key) use (&$subsData){
			   // if (($subs->order_status == "3" || $subs->order_status == 0) && $subs->isSubComplete() == true){
				// // unset($subsData[$key]);
				 // $subsData->forget($key);
			   // }
			 // });
			 $subsArray = array();
			 foreach($subsData as $i => $element) {
				 $payment_mode = "";
				 $order_status = "";
				 $planType = "";
				 if($element->payment_mode == "1") {$payment_mode = "Online Payment";}
				 elseif($element->payment_mode == "2"){ $payment_mode = "Cheque"; }
				 elseif($element->payment_mode == "3"){ $payment_mode = "Cash"; }
				 elseif($element->payment_mode == "4"){ $payment_mode = "Admin Online";}
				 elseif($element->payment_mode == "5"){ $payment_mode = "Free";}

				if($element->order_status == "0") {$order_status = "Pending";}
				elseif($element->order_status == "1") {$order_status = "Completed";}
				elseif($element->order_status == "2")  {$order_status = "Cancelled";}
				elseif($element->order_status == "3") {$order_status = "Failure Transaction";}

				if(!empty($element->PlanPeriods) && !empty($element->PlanPeriods->Plans)) {
					$planType = @$element->PlanPeriods->Plans->plan_title." -".number_format(@$element->PlanPeriods->Plans->price - @$element->PlanPeriods->Plans->discount_price,2);
				}
				$totAppt = 0;
				$planPrice = 0;
				$planDisPrice = 0;
				// $appointment_cnt = @$element->UserSubscribedPlans[0]->appointment_cnt;
				// if(!empty($appointment_cnt)){
					// $totalRemAppt = 0;
					// $remaining_appointment = @$element->UserSubscribedPlans[0]->PlanPeriods->remaining_appointment;
					// $appointment_ids = @$element->UserSubscribedPlans[0]->PlanPeriods->appointment_ids;
					// if($element->id == 625){
					$appointment_ids = "";
					if(count($element->UserSubscribedPlans) >0){
						foreach($element->UserSubscribedPlans as $plan){
							if(!empty($plan->PlanPeriods) && !empty($plan->PlanPeriods->appointment_ids)){
								$appointment_ids .= $plan->PlanPeriods->appointment_ids.",";
							}
							$planPrice = $plan->plan_price;
							$planDisPrice = $plan->discount_price;
						}
					}
					// pr($appointment_ids);
					if(!empty($appointment_ids)){
						$apptIds = explode(",",$appointment_ids);
						$totAppt = Appointments::select("id")->whereIn("id",$apptIds)->where("delete_status",1)->count();
						// foreach($apptIds as $appId){
							// if(!empty($appId)){
							// $appt = Appointments::select("id")->where("id",$appId)->where("delete_status",1)->count();
							// if($appt > 0){
								// $totAppt++;
							// }
							// }
						// }
					}
					
					/*if(!empty($appointment_ids)) {
						$apptIds = explode(",",$appointment_ids);
						foreach($apptIds as $appId){
							if(!empty($appId)){
							$appt = Appointments::with("chiefComplaints")->where("id",$appId)->where(["visit_status"=>1,"delete_status"=>1])->first();
							
							if(!empty($appt) && count($appt->chiefComplaints) > 0){
								foreach($appt->chiefComplaints as $cc) {
									$cData = json_decode($cc->data,true);
									if(count($cData)>0) {
										foreach($cData as $raw) {
											$cmpName = $raw['complaint_name'];
											$subsArray[] = array(
												 '',
												 '',
												 '',
												 '',
												 '',
												 '',
												 '',
												 '',
												 '',
												 '',
												 $cmpName
											  );
										}
									}
								}
								$totAppt++;
							}
							}
						}
					}*/
					// }
					// if($appointment_cnt != $remaining_appointment){
					// $totAppt = $totalRemAppt;
					// }
				// }
				 $ref_code = !empty($element->ReferralMaster) ? $element->ReferralMaster->code : $element->User->mobile_no;
				 if($element->hg_miniApp == '1'){
					$ref_code = $ref_code."\n(Help India)";
				 }
				 else if($element->hg_miniApp == '1'){
					$ref_code = $ref_code."\n(E-Mitra)";
				 }
				 $addedBy = null;
				 if($element->added_by != 0){ $addedBy = getNameByLoginId($element->added_by);}
				 $subsArray[] = array(
					 $i+1,
					 $addedBy,
					 $element->order_id,
					 $element->User->first_name." ".$element->User->last_name,
					 $element->User->mobile_no,
					 $payment_mode,
					 $planType,
					 $planPrice,
					 $planDisPrice,
					 $element->tax,
					 $element->order_total,
					 $ref_code,
					 getOrganizationIdByName($element->organization_id),
					 $order_status,
					 date('d-m-Y',strtotime($element->created_at)),
					 date('H:i',strtotime($element->created_at)),
					 $totAppt,
					 $element->remark
				  );
			 }
			return Excel::download(new SubscriptionExport($subsArray), 'subscription.xlsx');
		}
    $subscriptionArray = array();
		 $subscriptions = $query->orderBy('id', 'desc')->paginate($page);
     // if (count($subscriptions) > 0) {
       // foreach ($subscriptions as $key => $subs) {
         // if (($subs->order_status == "3" || $subs->order_status == 0) && $subs->isSubComplete() == true) {
           // continue;
         // }
          // $subscriptionArray[] = $subs;
       // }
     // }
     // $perPage = 25;
     // $input = $request->all();
     // if (isset($input['page']) && !empty($input['page'])) { $currentPage = $input['page']; } else { $currentPage = 1; }
     // $offset = ($currentPage * $page) - $page;
     // $itemsForCurrentPage = array_slice($subscriptionArray, $offset, $page, false);
     // $subscriptions =  new Paginator($itemsForCurrentPage, count($subscriptionArray), $page,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));

       }
       return view('admin.subscription.subscriptionMaster',compact('subscriptions'));
   }
  public function viewSubscription(Request $request) {
		 $id = base64_decode($request->id);
		 $UsersSubscriptions = UsersSubscriptions::Where('user_id', $id)->get();
		 $user = User::where("id",$id)->first();
		 // dd($UsersSubscriptions);
		 return view('admin.Patients.subscription.viewSubscription',compact('UsersSubscriptions','user'));
  }

   public function viewPlan(Request $request) {
		 $id = $request->id;
		 $UsersSubscriptions = UsersSubscriptions::Where('id', $id)->first();
		 return view('admin.Patients.subscription.viewPlan',compact('UsersSubscriptions'));
  }

  public function newSubscription(Request $request){
         if ($request->isMethod('post')) {
			$data = $request->all();
			// dd($data);
			$orderId = "SUBS"."1";
				$userSubs = UsersSubscriptions::orderBy("id","DESC")->first();
				if(!empty($userSubs)){
					$sid = $userSubs->id + 1;
					$orderId = "SUBS".$sid;
				}
				if($data['subcribetime']){
					$subcribedate = date("Y-m-d",strtotime($data['subcribedate']))." ".date("H:i:s",strtotime($data['subcribetime']));
				}else{
					$subcribedate = date("Y-m-d",strtotime($data['subcribedate']))." ".date("H:i:s");
				}
			
			  $subscription =  UsersSubscriptions::create([
				'login_id' => Session::get('id'),
				 'user_id' => $data['user_id'],
				 'order_id' => $orderId,
				 'payment_mode' => $data['payment_mode'],
				 'ref_code' => $data['referral_user_id'],
				 // 'coupon_id' => null,
				 // 'tax' => $data['tax'],
				 'created_at' => $subcribedate,
				 'coupon_discount' => $data['coupon_discount'],
				 'order_subtotal' => $data['order_total'],
				 'order_total' => $data['order_total'],
				 'order_status' => ($data['payment_mode'] == '6') ? 0 : 1,
				 'added_by' => $data['added_by'],
				 'remark' => $data['remark'],
				 'organization_id' => $data['organization_id'],
				 'meta_data' => json_encode($data),
			  ]);
				if($data['payment_mode'] == '6'){
				$lnk = route('subsPayment',[base64_encode($subscription->id)]);
				$links = ApptLink::create([
					'type' => 3,
					'user_id' => $subscription->user_id,
					'link' => $lnk,
					'order_id' => $orderId,
					'createBy' => 0,
					'meta_data' => json_encode($subscription),
				]);
				return ['type'=>2,'data'=>$links];
		}else {
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
  				'cheque_no'=>$data['cheque_no'],
  				'cheque_payee_name'=>$data['cheque_payee_name'],
  				'cheque_bank_name'=>$data['cheque_bank_name'],
  				'cheque_date'=>$data['cheque_date'],
  				'tran_status' => "Success",
  				'trans_date' => date('d-m-Y')
  			]);
  			Session::flash('message', "Subscription Created Successfully");
        return ['type'=>1,'data'=>$data['user_id']];
      }

       }
	   else{
		    $id = base64_decode($request->id);
			$user = User::where("id",$id)->first();
		    return view('admin.Patients.subscription.newSubscription',compact('user'));
	   }
   }

    function ApplyReferralCodeAdmin(Request $request) {
		 if($request->isMethod('post')) {
			$data = $request->all();
			$success = 0;
			$res = ["success"=>$success,"referral_user_id"=>"","coupon_discount"=>""];
			// $checkCode = User::select('id')->where(['mobile_no'=> $data['ref_code'],"parent_id"=>0])->where('id', '!=', $data['user_id'])->first();
			// if(!empty($checkCode)) {
				// $success = 1;
				// $res['referral_user_id'] =  $checkCode->id;
				// $res['coupon_discount'] =  getSetting("referred_amount")[0];
			// }
			// else {
				$refData = ReferralMaster::where('code',$data['ref_code'])->where(['status'=>1,'delete_status'=>1])->first();
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
     }

	public function changePlanPeriodStatus(Request $request) {
		if($request->isMethod('post')) {
			$data = $request->all();
			if($data['s_type'] == 1) {
				if($data['status'] == 0) {
					PlanPeriods::where('subscription_id',$data['id'])->update(['status' => 1]);
					return 1;
				}
				else {
					PlanPeriods::where('subscription_id',$data['id'])->update(['status' => 0]);
					return 2;
				}
			}
			else {
				$sts = $data['status'] == 1  ? 2 : 1;
				UsersSubscriptions::where('id',$data['id'])->update(['order_status' => $sts]);
				return 1;

			}
		}
    }


	function instantSubs(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->all();
            \Session::put('admin_org_id', $data['organization']);
            \Session::put('admin_ref_code', $data['ref_code']);
            $user = User::where(['mobile_no'=>trim($data['mobile_no']),'parent_id'=>0])->first();
            if(empty($user)) {
                $first_name = trim(strtok($data['user_name'], ' '));
                $last_name = trim(strstr($data['user_name'], ' '));
                $user = User::create([
                    'first_name' => ucfirst($first_name),
                    'last_name' => $last_name,
                    'mobile_no' => $data['mobile_no'],
                    'profession_type' => 2,
                    'organization' => $data['organization'],
                    'login_type' => 2,
                    'device_type' => 3,
                    'register_by' => Session::get('id'),
                ]);
                createUsersReferralCode($user->id);
            }
            //else{
            //$isSubs = UsersSubscriptions::with(["PlanPeriods.Plans"])->whereNotNull("id")->where('user_id',$user->id)->where('order_status',1)->whereHas('PlanPeriods', function($q) {$q->Where('status', 1);})->count();
            //if($isSubs > 0){
            //	return ['type'=>3];
            //}
            //}

            $orderId = "SUBS"."1";
            $userSubs = UsersSubscriptions::orderBy("id","DESC")->first();
            if(!empty($userSubs)){
                $sid = $userSubs->id + 1;
                $orderId = "SUBS".$sid;
            }
            $plan = Plans::where('id',7)->first();
            $coupon_discount = 0;
            $refData = ReferralMaster::where('id',$data['ref_code'])->where(['status'=>1,'delete_status'=>1])->first();
            if(!empty($refData)){
                if(!empty($refData->plan_ids)) {
                    $plan_ids = explode(",",$refData->plan_ids);
                    if(in_array($plan->id,$plan_ids)) {
                        $coupon_discount = getDiscount($refData->referral_discount_type,$refData->referral_discount,$plan->id);
                    }
                }
                else{
                    $coupon_discount = getDiscount($refData->referral_discount_type,$refData->referral_discount,$plan->id);
                }
            }
            $actualPice = $plan->price - $plan->discount_price;
            $order_total = $actualPice - $coupon_discount;
            // $order_total = 1;
            $subArray = $data;
            $subArray['user_id'] = $user->id;
            $subArray['plan_id'] = $plan->id;
            $subscription =  UsersSubscriptions::create([
                'login_id' => Session::get('id'),
                'user_id' => $user->id,
                'order_id' => $orderId,
                'payment_mode' => $data['payment_type'] == 'cash' ? 3 : 1,
                'ref_code' => $data['ref_code'],
                'coupon_discount' => $coupon_discount,
                'order_subtotal' => $order_total,
                'order_total' => $order_total,
                'order_status' => $data['payment_type'] == 'cash' ? 1 : 0,
                'added_by' => Session::get('id'),
                // 'remark' => $data['remark'],
                'organization_id' => $data['organization'],
                'meta_data' => json_encode($subArray),
            ]);
            if($data['payment_type'] == 'online') {
                $mid = "yNnDQV03999999736874";
                $merchent_key = "&!VbTpsYcd6nvvQS";
                $paytmParams["body"] = array(
                    "mid"           => $mid,
                    "orderId"       => $subscription->order_id,
                    "amount"        => $subscription->order_total,
                    "businessType"  => "UPI_QR_CODE",
                    "posId"         => time()
                );
                $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $merchent_key);
                $paytmParams["head"] = array(
                    "clientId"	=> 'C11',
                    "version"	=> 'v1',
                    "signature"	=> $checksum
                );
                $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
                /* for Production */
                $url = "https://securegw.paytm.in/paymentservices/qr/create";
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                $response = curl_exec($ch);
                $response = json_decode($response,true);
                $qr_code = "";
                if($response['body']['resultInfo']['resultCode'] == "QR_0001" && $response['body']['resultInfo']['resultStatus'] == "SUCCESS") {
                    $qr_code = $response['body']['image'];
                }
                // $lnk = route('subsPayment',[base64_encode($subscription->id)]);
                // $link = ApptLink::create([
                // 'type' => 3,
                // 'user_id' => $user->id,
                // 'link' => $lnk,
                // 'order_id' => $orderId,
                // 'createBy' => Session::get('id'),
                // 'meta_data' => json_encode($subscription),
                // ]);
                return ['type'=>2,'orderId'=>$orderId,'qr_code'=>$qr_code];
            }
            else {
                $subs_id = @$subscription->id;
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
                $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').'+'.$duration_in_days.' days'));
                $PlanPeriods =  PlanPeriods::create([
                    'subscription_id' => $subs_id,
                    'subscribed_plan_id' => $subscribedPlan->id,
                    'user_plan_id' => $plan->id,
                    'user_id' => $user->id,
                    'start_trail' => date('Y-m-d H:i:s'),
                    'end_trail'=> $end_date,
                    'remaining_appointment' => $plan->appointment_cnt,
                    'specialist_appointment_cnt' => $plan->specialist_appointment_cnt,
                    'lab_pkg_remaining' => 0,
                    'status' => 1
                ]);
                UserSubscriptionsTxn::create([
                    'subscription_id' => $subs_id,
                    'tran_mode'=> 'Cash',
                    'currency'=> "INR",
                    'payed_amount'=>$order_total,
                    'tran_status' => "Success",
                    'trans_date' => date('d-m-Y')
                ]);
                $this->sendMessageToUser($subscription);
                Session::flash('message', "Subscription Created Successfully");
                return ['type'=>1];
            }
        }
        else{
            $onlineSubs = UsersSubscriptions::with(["PlanPeriods.Plans","UserSubscribedPlans.PlanPeriods","User","ReferralMaster"])->whereNotNull("id")->where('order_status',1)->whereHas('PlanPeriods', function($q) {
                $q->Where('status', 1);
            })->where('added_by',Session::get('id'))->where('payment_mode',1)->whereRaw('date(created_at) >= ?', [date('Y-m-d')])->whereRaw('date(created_at) <= ?', [date('Y-m-d')])->orderBy('id', 'desc')->count();

            $cashSubs = UsersSubscriptions::with(["PlanPeriods.Plans","UserSubscribedPlans.PlanPeriods","User","ReferralMaster"])->whereNotNull("id")->where('order_status',1)->whereHas('PlanPeriods', function($q) {
                $q->Where('status', 1);
            })->where('added_by',Session::get('id'))->where('payment_mode',3)->whereRaw('date(created_at) >= ?', [date('Y-m-d')])->whereRaw('date(created_at) <= ?', [date('Y-m-d')])->orderBy('id', 'desc')->count();

            $OrganizationList =  OrganizationMaster::whereIn('id',[91,74,49,48,13,4,55])->orderBy('id', 'desc')->get();
            $orgQuery = ReferralMaster::whereIn('org_id',[91,74,49,48,13,4,55]);
            if(Session::get("admin_org_id")!= null) {
                $orgQuery->where('org_id',Session::get("admin_org_id"));
            }
            $refCodeData = $orgQuery->get();
            return view('admin.subscription.instant-subscription',compact('OrganizationList','onlineSubs','cashSubs','refCodeData'));
        }
    }



    public function instantSubsReport(Request $request) 
    {
        if($request->isMethod('post'))
         {
            $params = array();
            if (!empty($request->input('search'))) {
                $params['search'] = base64_encode($request->input('search'));
            }
            if (!empty($request->input('page_no'))) {
                $params['page_no'] = base64_encode($request->input('page_no'));
            }
            return redirect()->route('admin.instantSubsReport',$params)->withInput();
        }
        else 
        {
            $page = 25;
            if(!empty($request->input('page_no')))
             {
                $page = base64_decode($request->input('page_no'));
             }

            $instReport =  DB::table('instant_subs_report')->where('added_by',Session::get('id'))->orderBy('id', 'desc')->paginate($page);
            $adminData = DB::table('admins')->where('id',Session::get('id'))->first();
            return view('admin.subscription.instant-subscription-report',compact('instReport','adminData'));
        }
    }
    public function instantSubsReportAdmin(Request $request) {
        if ($request->isMethod('post')) {
            $params = array();
            if (!empty($request->input('start_date'))) 
            {
                $params['start_date'] = base64_encode($request->input('start_date'));
            }
            if (!empty($request->input('end_date'))) 
            {
                $params['end_date'] = base64_encode($request->input('end_date'));
            }
            if (!empty($request->input('page_no'))) 
            {
                $params['page_no'] = base64_encode($request->input('page_no'));
            }
            if (!empty($request->input('city'))) {
                $params['city'] = base64_encode($request->input('city'));
            }
            if (!empty($request->input('file_type'))) 
            {
                $params['file_type'] = base64_encode($request->input('file_type'));
            }
            if (!empty($request->input('added_by'))) 
            {
                $params['added_by'] = base64_encode($request->input('added_by'));
            }
            return redirect()->route('admin.instantSubsReportAdmin',$params)->withInput();
        }
        else {
            $page = 25;
            if(!empty($request->input('page_no'))) {
                $page = base64_decode($request->input('page_no'));
            }
            $query = DailyReport::with("Admin");
             
            $result = DB::table('user_subscriptions')
            ->join('instant_subs_report', 'user_subscriptions.added_by', '=', 'instant_subs_report.added_by')
            ->select('user_subscriptions.added_by', DB::raw('COUNT(*) as occurrence_count'))
            ->where('user_subscriptions.payment_mode', 4)
            ->groupBy('user_subscriptions.added_by')
            ->get();
            
            if(!empty($request->input('start_date')) || !empty($request->input('end_date'))) {
                if(!empty($request->input('start_date'))) {
                    $start_date = date('Y-m-d',strtotime(base64_decode($request->input('start_date'))));
                    $query->whereRaw('date(created_at) >= ?', [$start_date]);
                }
                if(!empty($request->input('end_date')))	{
                    $end_date = date('Y-m-d',strtotime(base64_decode($request->input('end_date'))));
                    $query->whereRaw('date(created_at) <= ?', [$end_date]);
                }
                

                   $sumPlanCash = $query->sum('plan_cash');
                    $sumPlanOnline = $query->sum('plan_online');
               
            }

            if($request->input('added_by')  != '') {
                $added_by = base64_decode($request->input('added_by'));
                $query->where('added_by',$added_by);
            }
            if($request->input('city')  != '') {
                $city = base64_decode($request->input('city'));
                $query->whereHas('Admin', function($q)  use ($city) {$q->where('city',$city);});
            }
            $file_type = base64_decode($request->input('file_type'));
            
                    $sumPlanCash = $query->sum('plan_cash');
                    $sumPlanOnline = $query->sum('plan_online');

            if($file_type == "excel") {
                $depositData = $query->orderBy('id', 'desc')->get();
                $instArray = array();
                foreach($depositData as $i => $element) {
                    $instArray[] = array(
                        $i+1,
                        $element->Admin->name,
                        $element->Admin->city,
                        $element->total_students,
                        $element->plan_online,
                        $element->plan_cash,
                        $element->amount,
                        date('d-m-Y',strtotime($element->created_at)),
                        date('H:i',strtotime($element->created_at)),
                    );
                }
                return Excel::download(new CommonExport($instArray), 'subs.xlsx');
            }
            $instReport = $query->orderBy('id', 'desc')->paginate($page);
            // $instReport = $subscription->orderBy('id', 'desc')->paginate($page);
            return view('admin.subscription.instant-subscription-report-admin',compact('instReport' ,'result' , 'sumPlanCash' , 'sumPlanOnline' ));
        }
    }


	   public function subcriptionImport(Request $request){
			
		if($request->subcription_plan){
		
			$extensions = array("xls","xlsx","csv","ods");
				
			$fileextension = $request->file('subcription_plan')->extension();
			if(in_array($fileextension,$extensions)){
				
			}else{
				Session::flash('error', "File type should be in xls,xlsx,csv,ods");
				return back();
			}

			    Excel::import(new SubcritionImport,request()->file('subcription_plan'));

				Session::flash('message', "Data Imported successfully");
				return back();

		}else{
			Session::flash('error', "Please Upload File");
				return back();
		}
		

				
	   }

	   public function addSubNote(Request $request) {
        if($request->isMethod('post')) {

            $data = $request->all();
            $id = base64_decode($data['id']);
            UsersSubscriptions::where('id', $id)->update(array('remark' => $data['note']));
            return 1;
        }
    }

	public function depositAmt(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->all();
            $fileName = null;
            if($request->hasFile('slip')) {
                $filepath = 'public/instant-subs-slip/';
                $slip = $request->file('slip');
                $fileName = strtolower(str_replace(" ","",$slip->getClientOriginalName()));
                if(!\Storage::disk('s3')->exists($filepath)) {
                    \Storage::disk('s3')->makeDirectory($filepath);
                }
                \Storage::disk('s3')->put($filepath.$fileName, file_get_contents($slip), 'public');
            }
            DB::table('subs_amt_deposit')->insert([
                'amount' => $data['amount'],
                'slip' => $fileName,
                'added_by' => Session::get('id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return 1;
        }
    }

	public function depositReqAdmin(Request $request) {
        if ($request->isMethod('post')) {
            $params = array();
            if (!empty($request->input('start_date'))) {
                $params['start_date'] = base64_encode($request->input('start_date'));
            }
            if (!empty($request->input('end_date'))) {
                $params['end_date'] = base64_encode($request->input('end_date'));
            }
            if ($request->input('status') != "") {
                $params['status'] = base64_encode($request->input('status'));
            }
            if (!empty($request->input('page_no'))) {
                $params['page_no'] = base64_encode($request->input('page_no'));
            }
            if (!empty($request->input('city'))) {
                $params['city'] = base64_encode($request->input('city'));
            }
            if (!empty($request->input('file_type'))) {
                $params['file_type'] = base64_encode($request->input('file_type'));
            }
            if (!empty($request->input('added_by'))) {
                $params['added_by'] = base64_encode($request->input('added_by'));
            }
            return redirect()->route('admin.depositReqAdmin',$params)->withInput();
        }
        else {
            $page = 25;
            if(!empty($request->input('page_no'))) {
                $page = base64_decode($request->input('page_no'));
            }
            $query =  SubAmtDeposit::with("Admin");
            if(!empty($request->input('start_date')) || !empty($request->input('end_date'))) {
                if(!empty($request->input('start_date'))) {
                    $start_date = date('Y-m-d',strtotime(base64_decode($request->input('start_date'))));
                    $query->whereRaw('date(created_at) >= ?', [$start_date]);
                }
                if(!empty($request->input('end_date')))	{
                    $end_date = date('Y-m-d',strtotime(base64_decode($request->input('end_date'))));
                    $query->whereRaw('date(created_at) <= ?', [$end_date]);
                }
            }
            if($request->input('status')  != '') {
                $status = base64_decode($request->input('status'));
                $query->where('status',$status);
            }
            if($request->input('added_by')  != '') {
                $added_by = base64_decode($request->input('added_by'));
                $query->where('added_by',$added_by);
            }
            if($request->input('city')  != '') {
                $city = base64_decode($request->input('city'));
                $query->whereHas('Admin', function($q)  use ($city) {$q->where('city',$city);});
            }
            $file_type = base64_decode($request->input('file_type'));
            if($file_type == "excel") {
                $depositData = $query->orderBy('id', 'desc')->get();
                $DepArray = array();
                foreach($depositData as $i => $element) {
                    $sts = "";
                    if($element->status == "0") {$sts = "Pending";}
                    elseif($element->status == "1") {$sts = "Success";}
                    elseif($element->status == "2")  {$sts = "Invalid";}

                    $DepArray[] = array(
                        $i+1,
                        $element->Admin->name,
                        $element->Admin->city,
                        $element->amount,
                        $element->Admin->subs_amount,
                        $sts,
                        date('d-m-Y',strtotime($element->created_at)),
                        date('H:i',strtotime($element->created_at)),
                    );
                }
                return Excel::download(new DepositExport($DepArray), 'deposits.xlsx');
            }
            $deposits = $query->orderBy('id', 'desc')->paginate($page);
            return view('admin.subscription.deposit-subscription-report-admin',compact('deposits'));
        }
    }
    public function depositReq(Request $request) {
        if ($request->isMethod('post')) {
            $params = array();
            if (!empty($request->input('search'))) {
                $params['search'] = base64_encode($request->input('search'));
            }
            if (!empty($request->input('page_no'))) {
                $params['page_no'] = base64_encode($request->input('page_no'));
            }
            return redirect()->route('admin.depositReq',$params)->withInput();
        }
        else {
            $page = 25;
            if(!empty($request->input('page_no'))) {
                $page = base64_decode($request->input('page_no'));
            }
            $deposits =  SubAmtDeposit::with("Admin")->where('added_by',Session::get('id'))->orderBy('id', 'desc')->paginate($page);
            return view('admin.subscription.deposit-subscription-report',compact('deposits'));
        }
    }
    public function updateDepositReqSts(Request $request) {
        $data = $request->all();
        if($data['status'] == 1) {
            $deps = DB::table('subs_amt_deposit')->where('id',$data['id'])->first();
            $adminData = DB::table('admins')->where('id',Session::get('id'))->first();
            $lastAmt = $adminData->subs_amount - $deps->amount;
            DB::table('admins')->where('id',$deps->added_by)->update([
                'subs_amount' => $lastAmt
            ]);
        }
        $deposits =  DB::table('subs_amt_deposit')->where('id',$data['id'])->update([
            'status' => $data['status']
        ]);
        return 1;
    }
 

     }
