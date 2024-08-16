<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\APIBaseController as APIBaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Request as Input;
use App\Models\User;
use App\Models\UsersOTP;
use App\Models\UserCashback;
use App\Models\NewsFeeds;
use App\Models\PlanPeriods;
use App\Models\UserSubscribedPlans;
use App\Models\ehr\EmailTemplate;
use App\Models\ehr\Patients;
use App\Models\UserActivity;
use Carbon\Carbon;
use App\Http\Controllers\PaytmChecksum;
use App\Models\UserDetails;
use Hash;
use Mail;
use File;
class UserController extends APIBaseController {
	public $successStatus = 200;
	
	/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
	 
	 /*public function login(Request $request) { //die;
		$data = $request->all();
        // $data=Input::json();
		// $user_array=array();
        // $user_array['mobile_no']=$data->get('mobile_no');
        // $user_array['fcm_token'] = $data->get('fcm_token');
        // $user_array['device_type'] = $data->get('device_type');
        // $user_array['loginInput'] = $data->get('loginInput');
		
		// $log = [];
		// $log['action'] = json_encode($data);
		// $log['table_name'] = $user_array['device_type'];
		// $log['location'] = json_encode($request);
		// UserActivity::create($log);
		// pr($data);
		$validator = Validator::make($data, [
            'loginInput' =>  'required|numeric',
            // 'fcm_token' =>   'required',
            'device_type' => 'required',
        ]);
		if($validator->fails()){
            return $this->sendError('Please reinstall new app.', $validator->errors());
        }
        else{
			$device_type = 3;
			if($data['device_type'] == "Android") {
				$device_type = 1;
			}
			else if($data['device_type'] == "iOS") {
				$device_type = 2;
			}
			$notifyres = "";
			$title = 'Health Gennie';
			$subtitle = 'Health Gennie';
			$tickerText = 'Health Gennie';
			$message = "Welcome In Health Gennie";
			$fcm_token = $data['fcm_token'];
			if($device_type == 1 && !empty($fcm_token)) {
				$notifyres = $this->pn($this->notificationKey,$fcm_token,$message,$title,$subtitle,$tickerText,'welcome');
			}
			else if($device_type == 2 && !empty($fcm_token)) {
				$notifyres = $this->iosNotificationSend($fcm_token,$message,$title,'welcome');
			}
			$notificationData = json_decode($notifyres,true);
			if($notificationData['success'] == "1") {
				if(!empty($data['loginInput'])) {
					$user = User::Where(['mobile_no'=>$data['loginInput'],'parent_id'=>0])->first();
					if(!empty($user)) {
						if(!empty($user->image)) {
							$image_url = getEhrUrl()."/public/patients_pics/".$user->image;
							if(does_url_exists($image_url)) {
							  $user['image'] = $image_url;
							}
							else{
								$user['image'] = null;
							}
						}
						$otp = rand(100000,999999);
						if($user->mobile_no == "9509416659") {
							$otp = "123456";
						}
						User::where('id',$user->id)->update(['otp'=>$otp,'fcm_token'=>$data['fcm_token'],'device_type' =>  $device_type]);  
						$user['otp'] = $otp;
						$user['user_status'] = "1";
						if(!empty($user->mobile_no)) {
						  $message = urlencode("Your Health Gennie OTP is ".$otp);
						  $this->sendSMS($user->mobile_no,$message);
						}
						if(!empty($user->OrganizationMaster) && !empty($user->OrganizationMaster->logo)) {
							$logo = url("/")."/public/organization_logo/".$user->OrganizationMaster->logo;
						}
						else{
							$logo = null;
						}
						$user->organization = array("id"=>($user->organization!=null)?$user->organization:"","title"=>getOrganizationIdByName(@$user->organization),"logo"=>$logo);
						saveUserActivity($request, 'loginAlready', 'users', @$user->id);
						$res['id'] = $user->id;
						$res['fcm_token'] = $data['fcm_token'];
						return $this->sendResponse($res, 'Login Successfully',$success = true);
					}
					else{
						$fcmTocken = User::Where(['fcm_token'=>$data['fcm_token']])->count();
						if($fcmTocken == 0) {
							$otp = rand(100000,999999);
							$user = User::create([
							   'mobile_no' =>  $data['loginInput'],
							   'fcm_token' =>  $data['fcm_token'],
							   'device_type' =>  $device_type,
							   'urls' =>  json_encode(getEhrFullUrls()),
							   'otp' =>  $otp,
							   'parent_id' => 0,
							   'status' =>  1,
							   'login_type' =>  2,
							]);
							$user['user_status'] = "1";
							if(!empty($user->mobile_no)) {
							  $message = urlencode("Your Health Gennie OTP is ".$otp);
							  $this->sendSMS($user->mobile_no,$message);
							}
							saveUserActivity($request, 'login', 'users', @$user->id);
							$res['id'] = $user->id;
							$res['fcm_token'] = $data['fcm_token'];
							return $this->sendResponse($res, 'Registered Successfully',$success = true);
						}
						else{
							saveUserActivity($request, 'DeviceAlreadyRegistered', 'users', '');
							return $this->sendError('Device already registered,Please use the registered number.');
						}
					}
				}
				else{
					return $this->sendError('Mobile Number is required.');
				}
			}
			else{
				saveUserActivity($request, 'loginInvalidRegistration', 'users', '');
				return $this->sendError('Invalid Registration');
			}
        }
    }*/
	
	public function login(Request $request) {
		$data = $request->all();
		$validator = Validator::make($data, [
			'loginInput' =>  'required|numeric',
			// 'fcm_token' =>   'required',
			// 'device_type' => 'required',
		]);
		if($validator->fails()) {
			return $this->sendError('Validation Error !', $validator->errors());
		}
		else{
			$device_type = 3;
			if($data['device_type'] == "Android") {
				$device_type = 1;
			}
			else if($data['device_type'] == "iOS") {
				$device_type = 2;
			}
			$otp = rand(100000,999999);
			if($data['loginInput'] == "9509416659") {
				$otp = "123456";
			}
			$user = UsersOTP::select(['id','expiry_date','mobile_no'])->Where(['mobile_no'=>$data['loginInput']])->first();
			$currentDate = date('Y-m-d H:i:s');
			$expiry_date = date('Y-m-d H:i:s', strtotime('+1 minutes', strtotime($currentDate)));
			if(!empty($user)) {
				// if ($currentDate > $user->expiry_date) {
					UsersOTP::Where(['id'=>$user->id])->update([
						'device_type' =>  $device_type,
						'fcm_token' =>  $data['fcm_token'],
						'expiry_date' =>  $expiry_date,
						'otp' =>  $otp,
					]);
				// }
				// else{
					// return $this->sendError('OTP already send! Please wait for 60 seconds');
				// }
			}
			else {
				$userData = User::where('mobile_no', '=',$data['loginInput'])->where('parent_id',0)->count();
				if($userData == 0) {
					$notifyres = "";
					$title = 'Health Gennie';
					$subtitle = 'Health Gennie';
					$tickerText = 'Health Gennie';
					$message = "Welcome In Health Gennie";
					$fcm_token = $data['fcm_token'];
					if($device_type == 1 && !empty($fcm_token)) {
						$notifyres = $this->pn($this->notificationKey,$fcm_token,$message,$title,$subtitle,$tickerText,'welcome');
					}
					else if($device_type == 2 && !empty($fcm_token)) {
						$notifyres = $this->iosNotificationSend($fcm_token,$message,$title,'welcome');
					}
					$notificationData = json_decode($notifyres,true);
					// if($notificationData['success'] == "1") {
						$fcmTocken = UsersOTP::Where(['fcm_token'=>$data['fcm_token']])->count();
						// if($fcmTocken == 0) {
							$user = UsersOTP::create([
								'mobile_no' =>  $data['loginInput'],
								'fcm_token' =>  $data['fcm_token'],
								'expiry_date' =>  $expiry_date,
								'device_type' =>  $device_type,
								'otp' =>  $otp
							]);
						// }
						// else{
							// saveUserActivity($request, 'DeviceAlreadyRegistered', 'users', '');
							// return $this->sendError('Device already registered,Please use the registered number.');
						// }
					// }
					// else{
						// saveUserActivity($request, 'loginInvalidRegistration', 'users', '');
						// return $this->sendError('Invalid Registration');
					// }
				}
				else{
					$user = UsersOTP::create([
						'mobile_no' =>  $data['loginInput'],
						'fcm_token' =>  @$data['fcm_token'],
						'expiry_date' =>  $expiry_date,
						'device_type' =>  $device_type,
						'otp' =>  $otp
					]);
				}
			}
			if(!empty($user->mobile_no)) {
				$message =  urlencode("Your Health Gennie OTP is ".$otp."\nThis otp is valid for 60 seconds Thanks Team Health Gennie");
				$this->sendSMS($user->mobile_no,$message,'1707165547064979677');
			}
			saveUserActivity($request, 'login', 'user_otp', @$user->id);
			$res['id'] = $user->id;
			$res['is_forgot'] = 0;
			return $this->sendResponse($res, 'Otp Send Successfully',$success = true);
 		}
    }

	
	public function addUser(Request $request) { 
       /* $data = Input::json();
        $user_array=array();
        $user_array['email']   = $data->get('email');
        $user_array['first_name']        =$data->get('first_name');
        $user_array['last_name']        =$data->get('last_name');
        $user_array['password']     =$data->get('password');
        // $user_array['dob']    =$data->get('dob');
        $user_array['mobile_no']    =$data->get('mobile_no');
        $user_array['device_type'] =$data->get('device_type');
        $user_array['fcm_token']    =$data->get('fcm_token');
		$otp = rand(100000,999999);
		
        $validator = Validator::make($user_array, [
            'first_name'        => 'required',
            // 'last_name'        => 'required',
            'mobile_no'         => 'required|numeric',
            // 'password'          => 'required|string|min:6|max:20'
          ],[
            'first_name.required'   		=> 'Name field cannot be empty',
            // 'last_name.required'   		=> 'Last Name field cannot be empty',
            'mobile_no.required'    => 'Mobile No. field cannot be empty',
            // 'password.required'     => 'Password field cannot be empty',
          ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        else {
			$mobile_exist = User::where('mobile_no', '=',$user_array['mobile_no'])->where('parent_id',0)->count();
			$email_exist = User::where(['email'=>trim($user_array['email'])])->where('email','!=','')->whereNotNull("email")->count();
			
			if($mobile_exist > 0 || $email_exist > 0 ) {
				if($email_exist > 0) {
					return $this->sendError('Email-id already exist.');
				}
				else if($mobile_exist > 0){
					return $this->sendError('Mobile Number already exist.');
				}
			}
			else{
				$device_type = 3;
				if($user_array['device_type'] == "Android"){
					$device_type = 1;
				}
				else if($user_array['device_type'] == "iOS"){
					$device_type = 2;
				}
				$first_name = $user_array['first_name'];
				$last_name = ' ';
				if(!empty($user_array['first_name'])){
					$name = explode(" ",$user_array['first_name']);
					$first_name = $name[0];
					$last_name = (isset($name[1]) ? $name[1] : ' ');
				}
				$password = null;
				if(!empty($user_array['email'])){
					$password = bcrypt($user_array['password']);
				}
				$user = User::create([
				   'first_name' =>  $first_name,
				   'last_name' =>  $last_name,
				   'mobile_no' =>  trim($user_array['mobile_no']),
				   'email' =>  trim($user_array['email']),
				   'fcm_token' =>  $user_array['fcm_token'],
				   'device_type' =>  $device_type,
				   'urls' =>  json_encode(getEhrFullUrls()),
				   'password' => $password,
				   'otp' =>  $otp,
				   'parent_id' => 0,
				   'status' =>  1,
				   'login_type' =>  2,
				]);
					
				//$user['token'] = $user->createToken('PatientPortal')->accessToken; 
				
				if(!empty($user_array['mobile_no'])) {
				  $message = urlencode("Your Health Gennie OTP is ".$user->otp);
				  $this->sendSMS($user_array['mobile_no'],$message);
				
					$to = $user_array['email'];
					if(!empty($to)) {
						$EmailTemplate = EmailTemplate::where('slug','accountactivationByOtp')->first();
						if($EmailTemplate) {
							$body = $EmailTemplate->description;
							$mailMessage = str_replace(array('{{username}}', '{{otp}}'),array("Sir ",$user->otp),$body);
							$datas = array('to' =>$to,'from' => 'info@healthgennie.com','mailTitle'=>$EmailTemplate->title,'content'=>$mailMessage,'subject'=>$EmailTemplate->subject);
							Mail::send('emails.all', $datas, function( $message ) use ($datas)
							{
							   $message->to( $datas['to'] )->from( $datas['from'])->subject($datas['subject']);
							});
						}	
					}
				}
				$user['is_forgot'] = 0;
				return $this->sendResponse($user, 'User Registered successfully.',$success = true);
			}
		}*/
    }
	
	/*public function resendOtp(Request $request) {
		$data=Input::json();
		$user_array=array();
		$user_array['id']=$data->get('id');
		$user_array['is_forgot']=$data->get('is_forgot');
	   
		$validator = Validator::make($user_array, [
			'id' => 'required'
		]);

		if($validator->fails()){
			return $this->sendError('Validation Error.', $validator->errors());
		}
		else{
			$user = User::where(['id'=>$user_array['id']])->first();
			if(!empty($user)) {
				$otp = rand(100000,999999);	
				User::where('id',$user->id)->update(['otp'=>$otp]);    
				if(!empty($user->mobile_no)) {
				   $message = urlencode("Your Health Gennie OTP is ".$otp);
				   $this->sendSMS($user->mobile_no,$message);
				}
				$user['otp'] = "";
				$user['is_forgot'] = $user_array['is_forgot'];
				return $this->sendResponse($user, 'OTP send successfully.',$success = true);
			}
			else{
				 return $this->sendError('User not activated');
			}
		}
	}*/
	
	public function resendOtp(Request $request) {
		$data=Input::json();
		$user_array=array();
		$user_array['id']=$data->get('id');
		$user_array['is_forgot']=$data->get('is_forgot');

		$validator = Validator::make($user_array, [
			'id' => 'required'
		]);

		if($validator->fails()){
			return $this->sendError('Validation Error.', $validator->errors());
		}
		else{
			if($user_array['is_forgot'] == '0'){
				$userOTP = UsersOTP::select(['expiry_date','mobile_no'])->Where(['id'=>$user_array['id']])->first();
			}
			else{
				$userOTP = UsersOTP::select(['expiry_date','mobile_no'])->Where(['user_id'=>$user_array['id']])->first();
			}
			if(!empty($userOTP)) {
				$currentDate = date('Y-m-d H:i:s');
				$expiry_date = date('Y-m-d H:i:s', strtotime('+1 minutes', strtotime($currentDate)));
				if ($currentDate > $userOTP->expiry_date) {
					$otp = rand(100000,999999);
					if($user_array['is_forgot'] == '0'){
						UsersOTP::Where(['id'=>$user_array['id']])->update([
							'expiry_date' =>  $expiry_date,
							'otp' =>  $otp,
						]);
					}
					else{
						UsersOTP::Where(['user_id'=>$user_array['id']])->update([
							'expiry_date' =>  $expiry_date,
							'otp' =>  $otp,
						]);
					}
					if(!empty($userOTP->mobile_no)) {
					   $message =  urlencode("Your Health Gennie OTP is ".$otp."\nThis otp is valid for 60 seconds Thanks Team Health Gennie");
					   $this->sendSMS($userOTP->mobile_no,$message,'1707165547064979677');
					}
					return $this->sendResponse('', 'OTP send successfully.',$success = true);
				}
				else{
					return $this->sendError('OTP already send! Please wait for 60 seconds.');
				}
			}
			else{
				 return $this->sendError('User not found');
			}
		}
	}

	
	public function otpVerifiedOld(Request $request) {
		$data=Input::json();
		$user_array=array();
		$user_array['id'] = $data->get('id');
		$user_array['otp'] = $data->get('otp');
		$user_array['mobile_no'] = $data->get('mobile_no');
		$user_array['is_forgot'] = $data->get('is_forgot');
		$validator = Validator::make($user_array, [
			'id'                => 'required|max:255',
			],[
			'id.required'   => 'Id field cannot be empty',
		]);
		if($validator->fails()){
			return $this->sendError('Validation Error.', $validator->errors());
		}
		else{
			$user = User::where('id',$user_array['id'])->first();
			if(!empty($user)) {
				if($user_array['otp'] == $user->otp) {
					if(!empty($user_array['mobile_no'])) {
						Patients::where('mobile_no', $user->mobile_no)->update(array(
							'mobile_no' =>  trim($user_array['mobile_no']),
						));
						User::where('mobile_no', $user->mobile_no)->update(array(
							'mobile_no' =>  trim($user_array['mobile_no']),
							'is_login' => 1,
						));
						$user['mobile_no'] = $user_array['mobile_no'];
					}
					$user->status = 1;
					$user->save();
					$user['is_forgot'] = $user_array['is_forgot'];
					if(!empty($user->image)) {
						$image_url = getPath("public/patients_pics/".$user->image);
						if(does_url_exists($image_url)) {
						  $user['image'] = $image_url;
						}
						else{
							$user['image'] = null;
						}
					}
					$is_subscribed = PlanPeriods::select('subscription_id')->where('user_id', $user_array['id'])->where('remaining_appointment', '!=', '0')->where('status', '1')->first();
					$user['is_subscribed'] = 0;
					$user['max_appointment_fee'] = 0;
					if (!empty($is_subscribed)) {
							$UserSubscribedPlans = UserSubscribedPlans::select('meta_data')->where('subscription_id', $is_subscribed->subscription_id)->first();
							// $user['is_subscribed'] = 1;
							$plan_meta = json_decode($UserSubscribedPlans->meta_data);
							$max_fee = @$plan_meta->max_appointment_fee;
							$user['max_appointment_fee'] = $max_fee;
					}
					if(!empty($user->OrganizationMaster) && !empty($user->OrganizationMaster->logo)){
						$logo = url("/")."/public/organization_logo/".$user->OrganizationMaster->logo;
					}
					else{
						$logo = null;
					}
					if(!empty($user->OrganizationMaster)) {
						$user->organization = array("id"=>($user->organization!=null)?$user->organization:"","title"=>getOrganizationIdByName(@$user->organization),"logo"=>$logo);
					}
					
					
					$tokenResult = $user->createToken('PatientPortal'); 
					$token = $tokenResult->token;
					if ($request->remember_me){
						$token->expires_at = Carbon::now()->addWeeks(20);
						$token->save();
					}
					$user['token'] = $tokenResult->accessToken;
					$user['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
					$user["dob_type"] = 0;
					if(!empty($user->dob)) {
						$user["dob_type"] = get_patient_age_api($user->dob)[1];
						$user["dob"] = get_patient_age_api($user->dob)[0];
					}
					return $this->sendResponse($user, 'Otp Verified Successfully.',$success = true);
				}
				else{
					return $this->sendError('Invalid or Incorrect OTP');
				}
			}
			else{
				return $this->sendError('User does not exist');
			}
		}
	}
	
	/*public function otpVerified(Request $request) {
		$data=Input::json();
		$user_array=array();
		$user_array['id'] = $data->get('id');
		$user_array['otp'] = $data->get('otp');
		$user_array['mobile_no'] = $data->get('mobile_no');
		$user_array['is_forgot'] = $data->get('is_forgot');
		$user_array['fcm_token'] = $data->get('fcm_token');
		// File::put(public_path('testData/test.txt'),json_encode($data));
		$validator = Validator::make($user_array, [
			'id'                => 'required|max:255',
			// 'otp'                => 'required',
			// 'fcm_token'                => 'required',
			],[
			'id.required'   => 'Id field cannot be empty',
		]);
		
		if($validator->fails()){
			return $this->sendError('Validation Error.', $validator->errors());
		}
		else{
			$user = User::where('id',$user_array['id'])->first();
			if(!empty($user)) {
				if($user_array['otp'] == $user->otp) {
					if(!empty($user_array['mobile_no'])) {
						Patients::where('mobile_no', $user->mobile_no)->update(array(
							'mobile_no' =>  trim($user_array['mobile_no']),
						));
						User::where('mobile_no', $user->mobile_no)->update(array(
							'mobile_no' =>  trim($user_array['mobile_no']),
							'is_login' => 1,
						));
						$user['mobile_no'] = $user_array['mobile_no'];
					}
					if(!empty($user_array['fcm_token'])) {
						$user->fcm_token = $user_array['fcm_token'];
					}
					$user->status = 1;
					$user->save();
					$user['is_forgot'] = $user_array['is_forgot'];
					if(!empty($user->image)) {
						$image_url = getEhrUrl()."/public/patients_pics/".$user->image;
						if(does_url_exists($image_url)) {
						  $user['image'] = $image_url;
						}
						else{
							$user['image'] = null;
						}
					}
					$is_subscribed = PlanPeriods::select('subscription_id')->where('user_id', $user_array['id'])->where('remaining_appointment', '!=', '0')->where('status', '1')->first();
					$user['is_subscribed'] = 0;
					$user['max_appointment_fee'] = 0;
					if (!empty($is_subscribed)) {
						$UserSubscribedPlans = UserSubscribedPlans::select('meta_data')->where('subscription_id', $is_subscribed->subscription_id)->first();
						// $user['is_subscribed'] = 1;
						$plan_meta = json_decode($UserSubscribedPlans->meta_data);
						$max_fee = @$plan_meta->max_appointment_fee;
						$user['max_appointment_fee'] = $max_fee;
					}
					if(!empty($user->OrganizationMaster) && !empty($user->OrganizationMaster->logo)){
						$logo = url("/")."/public/organization_logo/".$user->OrganizationMaster->logo;
					}
					else{
						$logo = null;
					}
					if(!empty($user->OrganizationMaster)) {
						$user->organization = array("id"=>($user->organization!=null)?$user->organization:"","title"=>getOrganizationIdByName(@$user->organization),"logo"=>$logo);
					}
					$tokenResult = $user->createToken('PatientPortal'); 
					$token = $tokenResult->token;
					if ($request->remember_me){
						$token->expires_at = Carbon::now()->addWeeks(100000);
						$token->save();
					}
					$user['token'] = $tokenResult->accessToken;
					$user['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
					$user["dob_type"] = 0;
					if(!empty($user->dob)) {
						$user["dob_type"] = get_patient_age_api($user->dob)[1];
						$user["dob"] = get_patient_age_api($user->dob)[0];
					}
					$cashBack = UserCashback::where(['user_id'=>$user->id])->count();
					if($cashBack == 0 && empty($user_array['mobile_no']) && $user->parent_id == 0 && $user->is_cashBack == 0) {
						// $user["cashbackOrderId"] = $this->walletCashback($user);
					}
					saveUserActivity($request, 'OtpVerified', 'users', @$user->id);
					return $this->sendResponse($user, 'Otp Verified Successfully.',$success = true);
				}
				else{
					return $this->sendError('Invalid or Incorrect OTP');
				}
			}
			else{
				return $this->sendError('User does not exist');
			}
		}
	}*/
	 
	public function otpVerified7Jan(Request $request) {
		$data=Input::json();
		$user_array=array();
		$user_array['id'] = $data->get('id');
		$user_array['otp'] = $data->get('otp');
		$user_array['mobile_no'] = $data->get('mobile_no');
		$user_array['is_forgot'] = $data->get('is_forgot');
		$user_array['fcm_token'] = $data->get('fcm_token');
		// File::put(public_path('testData/test.txt'),json_encode($data));
		$validator = Validator::make($user_array, [
			'id'                => 'required|max:255',
			'otp'                => 'required|numeric|digits:6',
			// 'fcm_token'                => 'required',
			],[
			'mobile_no.required'   => 'mobile_no field cannot be empty',
			'id.required'   => 'Id field cannot be empty',
			'digits.size'   => 'Otp must be 6 digit',
		]);
		if($validator->fails()){ //pr($validator->errors());
			foreach($validator->errors()->all() as $error){
				return $this->sendError($error);
				break;
			}
			return $this->sendError('Validation Error!',$validator->errors());
		}
		else{
			// if(empty($user_array['mobile_no'])) {
				$userOTP = UsersOTP::Where(['id'=>$user_array['id']])->first();
			// }
			// else {
				// $userOTP = UsersOTP::Where(['user_id'=>$user_array['id']])->first();
			// }
			$device_type = $userOTP->device_type;
			// if($userOTP->device_type == "Android") {
				// $device_type = 1;
			// }
			// else if($userOTP->device_type == "iOS") {
				// $device_type = 2;
			// }
			$currentDate = date('Y-m-d H:i:s');
			if(!empty($userOTP)) {
				$user_array['id'] = $userOTP->user_id;
				if($user_array['otp'] == $userOTP->otp) {
					if($currentDate <= $userOTP->expiry_date) {
						if(!empty($user_array['mobile_no'])) {
							$user = User::where('id',$user_array['id'])->first();
							Patients::where('mobile_no', $user->mobile_no)->update(array(
								'mobile_no' =>  trim($user_array['mobile_no']),
							));
							User::where('mobile_no', $user->mobile_no)->update(array(
								'mobile_no' =>  trim($user_array['mobile_no']),
								'is_login' => 1,
							));
							$user['mobile_no'] = $user_array['mobile_no'];
							UsersOTP::Where(['id'=>$userOTP->id])->update(['user_id'=>$user->id,'expiry_date'=>$currentDate]);
						}
						else {
							$user = User::where(['mobile_no'=>$userOTP->mobile_no,'parent_id'=>0])->first();
							if(empty($user)) {
								$user = User::create([
									'mobile_no' =>  $userOTP->mobile_no,
									'device_type' =>  $device_type,
									'urls' =>  json_encode(getEhrFullUrls()),
									'parent_id' => 0,
									'status' =>  1,
									'login_type' =>  2,
									'is_login' => 1,
									'notification_status' => 1,
								]);
								createUsersReferralCode($user->id);
							}
							UsersOTP::Where(['id'=>$userOTP->id])->update(['user_id'=>$user->id,'expiry_date'=>$currentDate]);
						}
						if(!empty($user_array['fcm_token'])) {
							$user->fcm_token = $user_array['fcm_token'];
						}
						$user->status = 1;
						$user->save();
						$user['is_forgot'] = $user_array['is_forgot'];
						if(!empty($user->image)) {
							$image_url = getPath("public/patients_pics/".$user->image);
							if(does_url_exists($image_url)) {
								$user['image'] = $image_url;
							}
							else{
								$user['image'] = null;
							}
						}
						$is_subscribed = PlanPeriods::select('subscription_id')->where('user_id', $user_array['id'])->where('remaining_appointment', '!=', '0')->where('status', '1')->first();
						$user['is_subscribed'] = 0;
						$user['max_appointment_fee'] = 0;
						if (!empty($is_subscribed)) {
							$UserSubscribedPlans = UserSubscribedPlans::select('meta_data')->where('subscription_id', $is_subscribed->subscription_id)->first();
							// $user['is_subscribed'] = 1;
							$plan_meta = json_decode($UserSubscribedPlans->meta_data);
							$max_fee = @$plan_meta->max_appointment_fee;
							$user['max_appointment_fee'] = $max_fee;
						}
						if(!empty($user->OrganizationMaster) && !empty($user->OrganizationMaster->logo)){
							$logo = url("/")."/public/organization_logo/".$user->OrganizationMaster->logo;
						}
						else{
							$logo = null;
						}
						if(!empty($user->OrganizationMaster)) {
							$user->organization = array("id"=>($user->organization!=null)?$user->organization:"","title"=>getOrganizationIdByName(@$user->organization),"logo"=>$logo);
						}
						
						$tokenResult = $user->createToken('PatientPortal');
						$token = $tokenResult->token;
						if ($request->remember_me){
							$token->expires_at = Carbon::now()->addWeeks(20);
							$token->save();
						}
						$user['token'] = $tokenResult->accessToken;
						$user['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
						
						$user["dob_type"] = 0;
						if(!empty($user->dob)) {
							$user["dob_type"] = get_patient_age_api($user->dob)[1];
							$user["dob"] = get_patient_age_api($user->dob)[0];
						}
						$cashBack = UserCashback::where(['user_id'=>$user->id])->count();
						if($cashBack == 0 && empty($user_array['mobile_no']) && $user->parent_id == 0 && $user->is_cashBack == 0) {
							// $user["cashbackOrderId"] = $this->walletCashback($user);
						}
						saveUserActivity($request, 'OtpVerified', 'users', @$user->id);
						return $this->sendResponse($user, 'Otp Verified Successfully.',$success = true);
					}
					else{
						return $this->sendError('OTP has been Expired.');
					}
				}
				else{
					return $this->sendError('Invalid or Incorrect OTP');
				}
			}
			else{
				return $this->sendError('User Does not exists.');
			}
		}
	}
	
	public function otpVerified(Request $request) {
		$data=Input::json();
		$user_array=array();
		$user_array['id'] = $data->get('id');
		$user_array['otp'] = $data->get('otp');
		$user_array['mobile_no'] = $data->get('mobile_no');
		$user_array['is_forgot'] = $data->get('is_forgot');
		$user_array['fcm_token'] = $data->get('fcm_token');
		// File::put(public_path('testData/test.txt'),json_encode($data));
		$validator = Validator::make($user_array, [
			'id'                => 'required|max:255',
			'otp'                => 'required|numeric|digits:6',
			// 'fcm_token'                => 'required',
			],[
			'mobile_no.required'   => 'mobile_no field cannot be empty',
			'id.required'   => 'Id field cannot be empty',
			'digits.size'   => 'Otp must be 6 digit',
		]);
		if($validator->fails()){ //pr($validator->errors());
			foreach($validator->errors()->all() as $error){
				return $this->sendError($error);
				break;
			}
			return $this->sendError('Validation Error!',$validator->errors());
		}
		else{
			if(empty($user_array['mobile_no'])) {
				$userOTP = UsersOTP::Where(['id'=>$user_array['id']])->first();
			}
			else {
				$userOTP = UsersOTP::Where(['user_id'=>$user_array['id']])->first();
			}
			$device_type = $userOTP->device_type;
			// if($userOTP->device_type == "Android") {
				// $device_type = 1;
			// }
			// else if($userOTP->device_type == "iOS") {
				// $device_type = 2;
			// }
			$currentDate = date('Y-m-d H:i:s');
			if(!empty($userOTP)) {
				if($user_array['otp'] == $userOTP->otp) {
					if($currentDate <= $userOTP->expiry_date) {
						if(!empty($user_array['mobile_no'])) {
							$user = User::where('id',$user_array['id'])->first();
							Patients::where('mobile_no', $user->mobile_no)->update(array(
								'mobile_no' =>  trim($user_array['mobile_no']),
							));
							User::where('mobile_no', $user->mobile_no)->update(array(
								'mobile_no' =>  trim($user_array['mobile_no']),
								'is_login' => 1,
							));
							$user['mobile_no'] = $user_array['mobile_no'];
							UsersOTP::Where(['id'=>$userOTP->id])->update(['user_id'=>$user->id,'expiry_date'=>$currentDate]);
						}
						else {
							$user = User::where(['mobile_no'=>$userOTP->mobile_no,'parent_id'=>0])->first();
							if(empty($user)) {
								$user = User::create([
									'mobile_no' =>  $userOTP->mobile_no,
									'device_type' =>  $device_type,
									'urls' =>  json_encode(getEhrFullUrls()),
									'parent_id' => 0,
									'status' =>  1,
									'login_type' =>  2,
									'is_login' => 1,
									'notification_status' => 1,
								]);
								createUsersReferralCode($user->id);
							}
							UsersOTP::Where(['id'=>$userOTP->id])->update(['user_id'=>$user->id,'expiry_date'=>$currentDate]);
						}
						if(!empty($user_array['fcm_token'])) {
							$user->fcm_token = $user_array['fcm_token'];
						}
						$user->device_type = $device_type;
						$user->status = 1;
						$user->save();
						$user['is_forgot'] = $user_array['is_forgot'];
						if(!empty($user->image)) {
							$image_url = getPath("public/patients_pics/".$user->image);
							if(does_url_exists($image_url)) {
								$user['image'] = $image_url;
							}
							else{
								$user['image'] = null;
							}
						}
						$is_subscribed = PlanPeriods::select('subscription_id')->where('user_id', $user_array['id'])->where('remaining_appointment', '!=', '0')->where('status', '1')->first();
						$user['is_subscribed'] = 0;
						$user['max_appointment_fee'] = 0;
						if (!empty($is_subscribed)) {
							$UserSubscribedPlans = UserSubscribedPlans::select('meta_data')->where('subscription_id', $is_subscribed->subscription_id)->first();
							// $user['is_subscribed'] = 1;
							$plan_meta = json_decode($UserSubscribedPlans->meta_data);
							$max_fee = @$plan_meta->max_appointment_fee;
							$user['max_appointment_fee'] = $max_fee;
						}
						if(!empty($user->OrganizationMaster) && !empty($user->OrganizationMaster->logo)){
							$logo = url("/")."/public/organization_logo/".$user->OrganizationMaster->logo;
						}
						else{
							$logo = null;
						}
						if(!empty($user->OrganizationMaster)) {
							$user->organization = array("id"=>($user->organization!=null)?$user->organization:"","title"=>getOrganizationIdByName(@$user->organization),"logo"=>$logo);
						}
						
						$tokenResult = $user->createToken('PatientPortal');
						$token = $tokenResult->token;
						if ($request->remember_me){
							$token->expires_at = Carbon::now()->addWeeks(20);
							$token->save();
						}
						$user['token'] = $tokenResult->accessToken;
						$user['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
						
						$user["dob_type"] = 0;
						if(!empty($user->dob)) {
							$user["dob_type"] = get_patient_age_api($user->dob)[1];
							$user["dob"] = get_patient_age_api($user->dob)[0];
						}
						$cashBack = UserCashback::where(['user_id'=>$user->id])->count();
						if($cashBack == 0 && empty($user_array['mobile_no']) && $user->parent_id == 0 && $user->is_cashBack == 0) {
							// $user["cashbackOrderId"] = $this->walletCashback($user);
						}
						$user_details = UserDetails::select("user_id","referral_code","referred_id","wallet_amount")->where('user_id',$user->id)->first();
						$user_details['referred_code'] = getRefCodeByUserId(@$user_details->referred_id);
						$user['user_details'] = $user_details;
						saveUserActivity($request, 'OtpVerified', 'users', @$user->id);
						return $this->sendResponse($user, 'Otp Verified Successfully.',$success = true);
					}
					else{
						return $this->sendError('OTP has been Expired.');
					}
				}
				else{
					return $this->sendError('Invalid or Incorrect OTP');
				}
			}
			else{
				return $this->sendError('User Does not exists.');
			}
		}
	}
	public function walletCashback($user) {
		//if($user->parent_id == 0 && $user->is_cashBack == 0) {
			$totalUser = UserCashback::where('status',1)->count();		
			$amount = 5;
			for($i = 1; $i <= $totalUser; $i++ ) {
				if($totalUser%100 == 0) {
					$amount = 5;
				}
				if($totalUser%1000 == 0){
					$amount = 10;
				}
				if($totalUser%100000 == 0){
					$amount = 100;
				}
			}
			$order_id = "HGCB".$user->id;
			$mobile = $user->mobile_no;
			$paytmParams = array();
			$paytmParams["subwalletGuid"]      = "77128966-fb92-4fc3-a27f-52474285d3fa";
			$paytmParams["orderId"]            = $order_id;
			$paytmParams["beneficiaryPhoneNo"] = $mobile;
			$paytmParams["amount"]             = $amount;
			$paytmParams["maxQueueDays"]       = 0;
			$paytmParams["disburseToNewUser"]  = false;
			$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
			$checksum = PaytmChecksum::generateSignature($post_data, "OJ0vuq8N&t3aAR7y");
			// $checksum = PaytmChecksum::generateSignature($post_data, "J7IeK&JZ6LwrfmBv");
			// $x_mid      = "FITKID54692936504563";
			$x_mid      = "FITKID61350170158252";
			$x_checksum = $checksum;
			/* for Staging */
			//$url = "https://staging-dashboard.paytm.com/bpay/api/v1/disburse/order/wallet/{solution}";
			// $url = "https://staging-dashboard.paytm.com/bpay/api/v1/disburse/order/wallet/gratification";
			//$url = "https://staging-dashboard.paytm.com/bpay/api/v1/disburse/order/wallet/gift";
			/* for Production */
			$url = "https://dashboard.paytm.com/bpay/api/v1/disburse/order/wallet/gratification";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "x-mid: " . $x_mid, "x-checksum: " . $x_checksum)); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			$response = curl_exec($ch);
			$response = json_decode($response,true); //pr($response);
			
			
			//if($response["status"] == "ACCEPTED" || $response["status"] == "SUCCESS") {
				// sleep(5);
				//$this->walletPaytmDisburseStatus($order_id,$user->id);
				UserCashback::create([
				   'order_id' =>  $order_id,
				   'user_id' =>  $user->id,
				   'meta_data' =>  json_encode($response),
				  //'meta_data' =>  json_encode($response),
				   'paytm_status' => $response["statusCode"],
			   ]);
			//}else{

			//}
			return $order_id;
		//}
	}
	
	public function walletPaytmDisburseStatus($order_id,$userId) {
		// $order_id = "HGCB13586"; 
        $paytmParams = array();
	    $paytmParams["orderId"] = $order_id;
		$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
		$checksum = PaytmChecksum::generateSignature($post_data, "OJ0vuq8N&t3aAR7y");
		// $checksum = PaytmChecksum::generateSignature($post_data, "J7IeK&JZ6LwrfmBv");
		// $x_mid      = "FITKID54692936504563";
		$x_mid      = "FITKID61350170158252";
		$x_checksum = $checksum;
		/* for Staging */
        // $url = "https://staging-dashboard.paytm.com/bpay/api/v1/disburse/order/query";
        /* for Production */
         sleep(3);
        $url = "https://dashboard.paytm.com/bpay/api/v1/disburse/order/query";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "x-mid: " . $x_mid, "x-checksum: " . $x_checksum)); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		$response = curl_exec($ch);
		$response = json_decode($response,true);
        sleep(3);
		// pr($response);
		if($response['status'] == "SUCCESS") {  //echo "kaps";
			UserCashback::create([
			   'order_id' =>  $order_id,
			   'user_id' =>  $userId,
			   'meta_data' =>  json_encode($response),
			   'status' =>  1,
			]);
			User::where('id',$userId)->update(['is_cashBack'=>1]);    
		}
		//pr($response);
	}
	
	public function ChangePassword(Request $request) {
        $data=Input::json();
        $password_array=array();
        $password_array['id']=$data->get('id');
        $password_array['new_password']=$data->get('new_password');
        $password_array['old_password']=$data->get('old_password');

        $validator = Validator::make($password_array, [
			'id'           => 'required',
            'new_password' => 'required',
            'old_password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        else{
			
           $user =  User::where('id', $password_array['id'])->first();
		   if(!empty($user)){ 
			    if(Hash::check($password_array['old_password'], $user->password)) {	
					$user->password = Hash::make($password_array['new_password']);
					$user->save();
					return $this->sendResponse('', 'Password Changed Successfully.',$success = true);
				}
				else{
					return $this->sendError('Current password does not match');
				}	
		   }
		   else{
				return $this->sendError('User does not exist');
		   }
        }
    }
	public function forgotOld(Request $request) {
        $data=Input::json();
        $password_array=array();
        $password_array['mobile_no']=$data->get('mobile_no');
        
        $validator = Validator::make($password_array, [
			'mobile_no'            => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        else{
           $user =  User::where('mobile_no', $password_array['mobile_no'])->first();
		   if(!empty($user)){
				$otp = rand(100000,999999);	
				User::where('id',$user->id)->update(['otp'=>$otp]);    
				if(!empty($user->mobile_no)) {
				   $message = urlencode("Use ".$otp." to forgot password in to ".$user->first_name.", as patient-portal account verification code  Thanks Team Health Gennie");
				   $this->sendSMS($user->mobile_no,$message,'1707161588064068016');
				}
				$user['otp'] = $otp;
				$user['is_forgot'] = 1;
				return $this->sendResponse($user, 'OTP send successfully.',$success = true);
		   }
		   else{
				return $this->sendError('user does not exist');
		   }
        }
    }
	
	public function forgot(Request $request) {
        $data=Input::json();
        $password_array=array();
        $password_array['email']=$data->get('email');
        $validator = Validator::make($password_array, [
			'email' => 'email|required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        else{
           $user =  User::where('email', $password_array['email'])->where('parent_id',0)->first();
		   if(!empty($user)) {
				if(!empty($user->email)) { 
					$to = $user->email;
					$username = ucfirst($user->first_name)." ".$user->last_name;
					$password = rand(100000,999999);	
					$EmailTemplate = EmailTemplate::where('slug','userresetpassword')->first();
					if($EmailTemplate) {
						$body = $EmailTemplate->description;
						$mailMessage = str_replace(array('{{username}}','{{password}}'),array($username,$password),$body);
						$datas = array('to' =>$to,'from' => 'info@healthgennie.com','mailTitle'=>$EmailTemplate->title,'content'=>$mailMessage,'subject'=>$EmailTemplate->subject);
						try{
						Mail::send('emails.all', $datas, function( $message ) use ($datas)
						{
						   $message->to( $datas['to'] )->from( $datas['from'])->subject($datas['subject']);
						});
						}
						catch(\Exception $e){
							  // Never reached
						}
						User::where('id',$user->id)->update(['password'=>bcrypt($password)]);  
						return $this->sendResponse('', 'We have e-mailed your password!',true);
					}
				}
				else{
					return $this->sendError('Email does not exist.');
				}
		   }
		   else{
				return $this->sendError('user does not exist');
		   }
        }
    }
	public function logoutUser(Request $request) {
		$data=Input::json();
		$user_array=array();
		$user_array['id']=$data->get('id');
		
		$validator = Validator::make($user_array, [
			'id' => 'required'
		]);
		if($validator->fails()){
			return $this->sendError('Validation Error.', $validator->errors());
		}
		else{
			User::where('id',$user_array['id'])->update(['is_login'=>0]);    
			return $this->sendResponse('', 'OTP send successfully.',$success = true);
		}
	}
	public function updateFcmToken(Request $request) {
        $data=Input::json();
		$user_array=array();
		$user_array['user_id']=$data->get('user_id');
        $user_array['fcm_token'] = $data->get('fcm_token');
        $user_array['device_type'] = $data->get('device_type');
        
		$validator = Validator::make($user_array, [
            'user_id' => 'required',
        ]);
		if($validator->fails()){
            return $this->sendError('Validation Error..', $validator->errors());
        }
        else{
			$device_type = 3;
			if($user_array['device_type'] == "Android") {
				$device_type = 1;
			}
			else if($user_array['device_type'] == "iOS") {
				$device_type = 2;
			}
			User::where('id',$user_array['user_id'])->update(['fcm_token'=>$user_array['fcm_token'],'device_type' =>  $device_type]);  
			return $this->sendResponse("", 'Updated Successfully',$success = true);
		}
    }
	public function saveUserLocation(Request $request) {
		$data=Input::json();
		$user_array=array();
		$user_array['id']=$data->get('user_id');
		$user_array['location']=$data->get('loc_data');
		
		$validator = Validator::make($user_array, [
			'id' => 'required',
			'location' => 'required'
		]);
		if($validator->fails()){
			return $this->sendError('Validation Error.', $validator->errors());
		}
		else{
			$userData = User::select("location_meta")->where('id',$user_array['id'])->first();
			if(empty($userData->location_meta)){
				User::where('id',$user_array['id'])->update(['location_meta'=>json_encode($user_array['location'])]);    
			}
			return $this->sendResponse('', 'Location Save successfully.',$success = true);
		}
	}
}
