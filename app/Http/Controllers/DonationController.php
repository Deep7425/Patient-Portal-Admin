<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use DB;
use App\Models\UsersDonation;
use App\Models\UserDonationTxn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use URL;
use Mail;
use File;
use Route;
use Auth;
use Softon\Indipay\Facades\Indipay;
use App\Http\Controllers\PaytmChecksum;
class DonationController extends Controller {
		public function donation(Request $request) {
		if($request->isMethod('post')) {
			$data = $request->all();
			$validator = Validator::make($data, [
				'name' => 'required|max:50',
				// 'email' => 'email|max:150',
				'mobile_no' => 'required|numeric',
				'amount' => 'required|numeric'
			]);
			if($validator->fails()) {
				$errors = $validator->errors();
				return redirect('donation')->withErrors($validator)->withInput();
			}
			else {
				$user = User::where(['mobile_no'=>$data['mobile_no'],'parent_id'=>0])->first();
				if(empty($user)) {
					$first_name = trim(strtok($data['name'], ' '));
					$last_name = trim(strstr($data['name'], ' '));
					$user = User::create([
					   'mobile_no' =>  $data['mobile_no'],
					   'email' =>  $data['email'],
					   'first_name' =>  $first_name,
					   'last_name' =>  $last_name,
					   'parent_id' => 0,
					   'status' =>  1,
					   'device_type' =>  3,
					   'login_type' =>  2,
					   'is_login' => 1,
					   'notification_status' => 1,
					]);
				}
				$orderId = "DON"."1";
				$userDont = UsersDonation::orderBy("id","DESC")->first();
				if(!empty($userDont)){
					$sid = $userDont->id + 1;
					$orderId = "DON".$sid;
				}
				$donation =  UsersDonation::create([
					 'user_id' => $user->id,
					 'order_id' => $orderId,
					 'payment_mode' => 1,
					 'order_subtotal' => $data['amount'],
					 'order_total' => $data['amount'],
					 'meta_data' => json_encode($data),
				]);
				$parameters = [];
				// $parameters["MID"] = "fiBzPH32318843731373"; 
				$parameters["MID"] = "yNnDQV03999999736874"; 
				$parameters["ORDER_ID"] = $orderId; 
				$parameters["CUST_ID"] = $user->id; 
				// $parameters["internationalCardPayment"] = true; 
				$parameters["TXN_AMOUNT"] = $donation->order_total; 
				// $parameters["TXN_AMOUNT"] = array(
					// "value"     => "1.00",
					// "currency"  => "INR",
				// );
				$parameters["CALLBACK_URL"] = url('paytmresponse'); 
				$order = Indipay::gateway('Paytm')->prepare($parameters);
				return Indipay::process($order); 
				// Session::flash('message', "Tha`nks For Your Donation!");
				
				// $res = $this->donateAmount($orderId,$user->id,$data['amount']);
				
				// $paytmParams = array();
				// $paytmParams["head"] = array(
				// "tokenType" => "TXN_TOKEN",
				// 'token'     => $res
				// );
				// $paytmParams["body"] = array("mid" => "yNnDQV03999999736874");
				// $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
				/* for Staging */
				// $url = "https://securegw-stage.paytm.in/theia/api/v2/fetchPaymentOptions?mid=YOUR_MID_HERE&orderId=ORDERID_98765";

				/* for Production */
				// return "https://securegw.paytm.in/theia/api/v2/fetchPaymentOptions?mid=yNnDQV03999999736874&orderId=".$orderId;
				// $url = "https://securegw.paytm.in/theia/api/v2/fetchPaymentOptions?mid=yNnDQV03999999736874&orderId=".$orderId;
				// $ch = curl_init($url);
				// curl_setopt($ch, CURLOPT_POST, true);
				// curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
				// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
				// curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
				// $response = curl_exec($ch);
				// pr($response);
				// header('Location: https://securegw.paytm.in/theia/api/v2/fetchPaymentOptions?mid=yNnDQV03999999736874&orderId='.$orderId);
				// exit;
				
				// $paytmParams = array();
				// $paytmParams["body"] = array(
					// "requestType" => "NATIVE",
					// "mid"         => "yNnDQV03999999736874",
					// "orderId"     => $orderId,
					// "paymentMode" => "CREDIT_CARD",
					// "cardInfo"    => "|4111111111111111|111|122032",
					// "authMode"    => "otp",
				// );
				// $paytmParams["head"] = array("txnToken" => $res);
				// $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
				/* for Staging */
				// $url = "https://securegw-stage.paytm.in/theia/api/v1/processTransaction?mid=yNnDQV03999999736874&orderId=ORDERID_98765";
				/* for Production */
				/*$url = "https://securegw.paytm.in/theia/api/v1/processTransaction?mid=yNnDQV03999999736874&orderId=".$orderId;

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
				curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
				$response = curl_exec($ch);
				
				header('Location: https://securegw.paytm.in/theia/api/v1/processTransaction?mid=yNnDQV03999999736874&orderId='.$orderId);
				exit;*/
				// print_r($response);
			}
        }
		return view($this->getView('pages.donation'));
    }
	public function donateAmount($order_id,$order_by,$amount) {
		$parameters = [];
		$parameters["MID"] = "yNnDQV03999999736874"; 
		$parameters["ORDER_ID"] = $order_id; 
		$parameters["CUST_ID"] = $order_by; 
		$parameters["TXN_AMOUNT"] = $amount; 
		//$parameters["CALLBACK_URL"] = url('paytmresponse'); 
		$paytmParams = array();
		$paytmParams["body"] = array(
			"requestType"   => "Payment",
			"mid"           => $parameters["MID"],
			"websiteName"   => "WEBPROD",
			"orderId"       => $parameters["ORDER_ID"],
			"callbackUrl"   => url('paytmresponse'),
			"txnAmount"     => array(
				"value"     => $parameters["TXN_AMOUNT"],
				"currency"  => "INR",
			),
			"userInfo"      => array(
				"custId"    => $parameters["CUST_ID"],
			),
		);
		$checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "&!VbTpsYcd6nvvQS");
		$paytmParams["head"] = array("signature" => $checksum);
		$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
		/* for Staging */
		//$url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=".$parameters["MID"]."&orderId=".$parameters["ORDER_ID"];
		/* for Production */
		// pr($post_data);
		$url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=".$parameters["MID"]."&orderId=".$parameters["ORDER_ID"];
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
		$response = curl_exec($ch);
		$response = json_decode($response,true);
		// pr($response);
		$txnToken = "";
		if(isset($response['body']['resultInfo']) && $response['body']['resultInfo']['resultStatus'] == "S"){
			$txnToken = $response['body']['txnToken'];
		}
		return $txnToken;
	}
}
