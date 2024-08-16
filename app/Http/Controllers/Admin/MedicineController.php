<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use URL;
use Mail;
use File;
use Route;
use App\Http\Controllers\PaytmChecksum;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\MedicineProductDetails;
use App\Models\MedicinePrescriptions;
use App\Models\MedicineOrders;
use App\Models\MedicineOrderedItems;
use App\Models\MedicineTxn;
use App\Models\ApptLink;
use App\Models\MedicineCart;
use App\Models\UsersLaborderAddresses;
use App\Models\User;
use Softon\Indipay\Facades\Indipay;
use PaytmWallet;
class MedicineController extends Controller {

	public  function medicineOrder(Request $request) {
		$search = '';
		if ($request->isMethod('post')) {
		$params = array();
         if (!empty($request->input('search'))) {
             $params['search'] = base64_encode($request->input('search'));
         }
		 if (!empty($request->input('start_date'))) {
             $params['start_date'] = base64_encode($request->input('start_date'));
         }
		 if (!empty($request->input('end_date'))) {
             $params['end_date'] = base64_encode($request->input('end_date'));
         }
		 if (!empty($request->input('page_no'))) {
             $params['page_no'] = base64_encode($request->input('page_no'));
         }
		 if ($request->input('type') != "") {
			 $params['type'] = base64_encode($request->input('type'));
		 }
		 if ($request->input('pres_type') != "") {
			 $params['pres_type'] = base64_encode($request->input('pres_type'));
		 }
		 if ($request->input('status') != "") {
			 $params['status'] = base64_encode($request->input('status'));
		 }
         return redirect()->route('admin.medicineOrder',$params)->withInput();
		}
		else {
			$query = MedicineOrders::with(['MedicineOrderedItems.MedicineProductDetails','MedicineTxn','User'])->where('delete_status',1);
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
			$page = 25;
			if(!empty($request->input('pres_type'))){
				$pres_type = base64_decode($request->input('pres_type'));
				$query->where('pres_type',$pres_type);
			}
			if(!empty($request->input('status'))){
				$status = base64_decode($request->input('status'));
				$query->where('status',$status);
			}
			if(!empty($request->input('page_no'))){
				$page = base64_decode($request->input('page_no'));
			}
			$orders = $query->orderBy('id', 'DESC')->paginate($page);
			// dd($orders);
		}
		return view('admin.medicine-manage.orders',compact('orders'));
	}
	public function completeOrder(Request $request) {
		if($request->isMethod('post')) {
			$data = $request->all();
			if($data['appttype'] == '2') {
				$orderData = MedicineOrders::where(['id'=>base64_decode($data['orderId'])])->first();
				$orderID = $orderData->id;
				$tran_mode = "online";
				$type = 2;
				if($data['payment_mode'] == "2"){
					$tran_mode = "cash";
				}
				else if($data['payment_mode'] == "3"){
					$tran_mode = "free";
					$type = 1;
				}
				if($tran_mode != "free") {
					MedicineTxn::create([
						'type' => 1,
						'order_id' => $orderData->id,
						'tran_mode' => $tran_mode,
						'tracking_id' => @$data['tracking_id'],
						'currency'=> "INR",
						'payed_amount'=> $orderData->order_total,
						'tran_status' => "TXN_SUCCESS",
						'trans_date' => date('Y-m-d H:i:s')
					]);
				}
				$meta_data = json_decode($orderData->meta_data,true);
				if(count($meta_data['meds'])>0) {
					foreach($meta_data['meds'] as $raw) {
						$item = new MedicineOrderedItems;
						$item->medicine_id = @$raw['medicine_id'];
						$item->order_id = $orderData->id;
						$item->qty = @$raw['qty'];
						$item->cost = @$raw['medicine_details']['price'];
						// $item->discount_amt = $raw->discount_amt;
						// $item->discount_type = $raw->discount_type;
						// $item->tax = $raw->tax;
						// $item->tax_amt = $raw->tax_amt;
						$item->total_amount = @$raw['medicine_details']['price'];
						$item->save();
					}
				}
				
				MedicineOrders::where(["id"=>$orderData->id])->update([
					'type' => $type,
					'status' => 1,
				]);
				return ['status'=>2];
			}
			else if($data['appttype'] == '1') {
				$order = MedicineOrders::where(['id'=>base64_decode($data['orderId'])])->where('delete_status',1)->first();
				$islnk = ApptLink::where(["type"=>2,"order_id"=>$order->order_id])->first();
				if(!empty($islnk)) {
					return ['status'=>1,'link'=>$islnk->link];
				}
				else {
					$lnk = route('crtPayment',[base64_encode($order->order_id)]);
					ApptLink::create([
						'type' => 2,
						'user_id' => $order->user_id,
						'link' => $lnk,
						'order_id' => $order->order_id,
						'createBy' => $data['logId'],
						'meta_data' => json_encode($order),
					]);
					// $name = $user_array['patient_name'];
					// $tmpName = "payment_link_v2";
					// $post_data = ['parameters'=>[['name'=>'user','value'=>$name],['name'=>'link','value'=>$lnk]],'template_name'=>$tmpName,'broadcast_name'=>'Payment'];
					// sendWhatAppMsg($post_data,$user->mobile_no);
					// $this->sendSMS($user->mobile_no,$message,'1707163047105925473');
					return ['status'=>1,'link'=>$lnk];
				}
			}
		}
	}

	public function crtPayment(Request $request,$orderId) {
		if(!empty($orderId)) {
			$medOrder = MedicineOrders::select(["user_id","order_total"])->where(["order_id"=>base64_decode($orderId)])->where('status','0')->first();
			if(!empty($medOrder)){
				$parameters = [];
				// $parameters["MID"] = "yNnDQV03999999736874";
				// $parameters["MID"] = "fiBzPH32318843731373";
				// $parameters["ORDER_ID"] = base64_decode($orderId);
				// $parameters["CUST_ID"] = @$medOrder->order_by;
				// $parameters["TXN_AMOUNT"] = $medOrder->order_total;
				// $parameters["CALLBACK_URL"] = url('paytmresponse');
				// $order = Indipay::gateway('Paytm')->prepare($parameters);
				// return Indipay::process($order);
				$mbl = @User::where("id",$medOrder->user_id)->first()->mobile_no;
				$parameters["order"] = base64_decode($orderId);
				$parameters["amount"] = $medOrder->order_total;
				$parameters["user"] = @$medOrder->user_id;
				$parameters["mobile_number"] = $mbl;
				$parameters["email"] = 'test';
				$parameters["callback_url"] = url('paytmresponse');
				$payment = PaytmWallet::with('receive');
				$payment->prepare($parameters);
				return $payment->receive();
			} else return abort('404');
		}
		else return abort('404');
	}
	public function viewOrderDetails(Request $request) {
		 $id = $request->id;
		 $order = MedicineOrders::with(['MedicineOrderedItems.MedicineProductDetails','MedicineTxn','User'])->where(["id"=>$id])->first();
		 return view('admin.medicine-manage.viewDetails',compact('order'));
	}
	public function makeMedOrder(Request $request) {
		if ($request->isMethod('post')) {
			$data = $request->all();
			$orderId = "MED1";
			$med = MedicineOrders::orderBy("id","DESC")->first();
			if(!empty($med)){
				$sid = $med->id + 1;
				$orderId = "MED".$sid;
			}
			$medIds = array();
			foreach($data['cart'] as $medicine) {

				$medicine_exists = MedicineCart::where(['user_id'=>$data['user_id'],'medicine_id' => $medicine['medicine_id']])->first();

				if(!empty($medicine_exists)) {
					$qty = $medicine_exists->qty + $medicine['qty'];
					MedicineCart::where("id",$medicine_exists->id)->update([
						'qty' => $qty
					]);
					$medCartIds[] = $medicine_exists->id;
				}
				else{
					$MedicineCart = MedicineCart::create([
						'user_id' => $data['user_id'],
						'medicine_id' => $medicine['medicine_id'],
						'qty' => $medicine['qty']
					]);
					$medCartIds[] = $MedicineCart->id;
				}
			}

			$meta_data = array();
			$presIds=array();
			if($request->hasFile('document') && $data['pres_type'] == 1){
				$files = $request->file('document');
				foreach($files as $file){
						$fileName = str_replace(" ","",$file->getClientOriginalName());
						$filepath = public_path().'/medicine-files/';
						$file->move($filepath, $fileName);
						$prescription = MedicinePrescriptions::create(['user_id'=>$data['user_id'],'prescription'=>$fileName]);
						$presIds[]=$prescription->id;
				}
			}

			$cartData = MedicineCart::with('MedicineProductDetails')->whereIn("id",$medCartIds)->get();
			$meta_data['user_id'] = $data['user_id'];
			$meta_data['pres_type'] = $data['pres_type'];
			$meta_data['address_id'] = $data['address_id'];
			$meta_data['order_by'] = 0;
			$meta_data['order_subtotal'] = $data['order_subtotal'];
			$meta_data['order_total'] = $data['order_total'];
			$meta_data['coupon_amt'] = $data['coupon_discount'];
			$meta_data['coupon_id'] = $data['coupon_id'];
			$meta_data['tax'] = null;
			$meta_data['meds'] = $cartData;
			$order =  MedicineOrders::create([
				 'type' => 0,
				 'order_id' => $orderId,
				 'order_from' => 2,
				 'presIds' => implode(",",$presIds),
				 'user_id' => $data['user_id'],
				 'address_id' => $data['address_id'],
				 'payment_mode' => 1,
				 'coupon_id' => $data['coupon_id'],
				 'coupon_discount' => $data['coupon_discount'],
				 'tax' => null,
				 'order_subtotal' => $data['order_subtotal'],
				 'order_total' => $data['order_total'],
				 'seller_detail' => $data['seller_detail'],
				 'delivery_charge' => $data['delivery_charge'],
				 'status' => 0,
				 'order_by' => 0,
				 'meta_data' => json_encode($meta_data),
			]);

			MedicineCart::WhereIn('id',$medCartIds)->delete();
			return 1;

		}else {
			$id = base64_decode($request->id);
			$user = User::where('id', $id)->first();
			$addresses = UsersLaborderAddresses::Where('user_id', $id)->get();
			return view('admin.Patients.make-medicine-order',compact('addresses','user'));
		}

	}
	public function changeOrderSts(Request $request) {
		if($request->isMethod('post')) {
			$data = $request->all();
			MedicineOrders::where(["id"=>$data['orderId']])->update([
				'order_status' => $data['order_status'],
			]);
			return 1;
		}
	}
	public function changeorderDate(Request $request) {
		if($request->isMethod('post')) {
			$data = $request->all();
			MedicineOrders::where(["id"=>$data['orderId']])->update([
				'delivery_date' => $data['d_date'],
			]);
			return 1;
		}
	}
}
