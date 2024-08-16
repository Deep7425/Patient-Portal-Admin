<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UsersOTP;
use App\Models\LabCart;
use Mail;
use Hash;
use File;
use Session;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Database\QueryException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
	protected $redirectAfterLogout = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function showLoginForm()
	{
		try{

			return view($this->getView('auth.login'));

		} catch (Exception $e) {

			return $e->getMessage();

		}
		
	} 
	public function login(Request $request) {

      
       try{
		$data = $request->all();
		$validator = Validator::make($data, [
            'mobile_no' => 'required|numeric',
        ]);
		if($validator->fails()){
            //return $this->sendError('Validation Error.Please reinstall new app.', $validator->errors());
            return 'Please enter a valid mobile no.';
        }
        else{
			if(isset($data['mobile_no']) && !empty($request->get('mobile_no'))) {
				$user = UsersOTP::select(['id','expiry_date','mobile_no'])->Where(['mobile_no'=>$data['mobile_no']])->first();
				if(!empty($user)) {
					$this->sendOTP($user->id);
					saveUserActivity($request, 'login', 'users', @$user->id);
					return ["status"=>1,"type"=>"mobile","user_id"=>$user->id,"msg"=>"Login successfully"];
				}
				else{
					$currentDate = date('Y-m-d H:i:s');
					$expiry_date = date('Y-m-d H:i:s', strtotime('+3 minutes', strtotime($currentDate)));
					$otp = rand(100000,999999);
					// $user = User::create([
					   // 'mobile_no' =>  $data['mobile_no'],
					   // 'otp' =>  $otp,
					   // 'parent_id' => 0,
					   // 'status' =>  1,
					   // 'device_type' =>  3,
					   // 'login_type' =>  2,
					// ]);
					$user = UsersOTP::create([
						'mobile_no' =>  $data['mobile_no'],
						'expiry_date' =>  $expiry_date,
						'device_type' =>  3,
						'otp' =>  $otp
					]);
					if(!empty($user->mobile_no)) {
					  $app_link = "www.healthgennie.com/download";
					  // $message =  urlencode("Your Health Gennie OTP is ".$otp.".\nThis otp is valid for 60 seconds.\nFor Better Experience Download Health Gennie App\n".$app_link);
					  // $message =  urlencode("Your Health Gennie OTP is ".$otp.". Creating Healthy Generations. For Better Experience Download Health Gennie App ".$app_link." Thanks Team Health Gennie");
					  // $this->sendSMS($user->mobile_no,$message,'1707161588054689348');
					  $message =  urlencode("Your Health Gennie OTP is ".$otp."\nThis otp is valid for 60 seconds Thanks Team Health Gennie");
					  $this->sendSMS($user->mobile_no,$message,'1707165547064979677');
					  saveUserActivity($request, 'login', 'users_otp', @$user->id);
					  return ["status"=>1,"type"=>"mobile","user_id"=>$user->id,"msg"=>"Login successfully"];
					}
				}
			}
			// else if(isset($data['email']) && !empty($request->get('email'))) {
			// 	if(!empty($request->get('password'))) {
			// 		$user = User::where('email', $request->get('email'))->where('parent_id',0)->first();
			// 		if(!empty($user)) {
			// 			$validCredentials = Hash::check($request->get('password'), $user->getAuthPassword());
			// 			if($validCredentials) {
			// 				saveUserActivity($request, 'login', 'users', @$user->id);
			// 				\Auth::login($user);
			// 				Session::put('profile_status', $user->profile_status);
			// 				if(Session::has('CartPackages')) {
			// 				   $packages = Session::get('CartPackages');
			// 				   foreach ($packages as $key => $value) {
			// 					 $alreadyAdded = LabCart::where(['user_id' => $user->id, 'product_name' => $value['name'], 'product_code' => $value['code']])->delete();
			// 					   $LabCart = LabCart::create([
			// 						 'user_id' => $user->id,
			// 						 'product_name' => $value['name'],
			// 						 'product_code' => $value['code'],
			// 						 'product_type' => $value['type'],
			// 					   ]);
			// 				   }
			// 				   Session::forget('CartPackages');
			// 				}
			// 				return ["status"=>1,"type"=>"email","user_id"=>$user->id,"msg"=>"Login successfully"];
			// 			}
			// 			else{
			// 				return ["status"=>0,"type"=>"email","user_id"=>$user->id,"msg"=>"Wrong Password"];
			// 			}
			// 		}
			// 		else{
			// 			return ["status"=>0,"type"=>"email","user_id"=>"","msg"=>"Your account does not exist."];
			// 		}
			// 	}
			// 	else{
			// 		return ["status"=>0,"type"=>"email","user_id"=>"","msg"=>"password is required."];
			// 	}
			// }
			else{
				return redirect()->route('home');
			}
	    }


	     }catch(Exception $e){

		return $e->getMessage();
	     
	      }

    }
	public function loginOld(Request $request) {
        // Check validation
		try{

			$validator = Validator::make($request->all(), [
				'mobile_no' => 'required|digits:10',
			]);
	
			if($validator->fails()) {
				return 'error';
			}
			else{
				// Get user record
				$user = User::where('mobile_no', $request->get('mobile_no'))->where('parent_id',0)->first();
				if(!empty($user)) {
					$this->sendOTP($user->id);
					saveUserActivity($request, 'login', 'users', @$user->id);
					return $user->id;
					// \Auth::login($user);
				}
				else{
					$user = User::create([
					   'mobile_no' =>  $request->get('mobile_no'),
					   'device_type' =>  3,
					   'parent_id' => 0,
					   'status' =>  1,
					]);
					createUsersReferralCode($user->id);
					saveUserActivity($request, 'login', 'users', @$user->id);
					$this->sendOTP($user->id);
					return $user->id;
				}
				// Redirect home page
				return redirect()->route('home');
			}

		}catch(Exeception $e){

			return $e->getMessage();
		}
    
    }
	public function sendUserOtp(Request $request) {

		try{

			if(!empty($request->user_id)){
				$this->sendOTP($request->user_id);
				return 1;
			}
			else{
				return false;
			}

		}catch(Eception $e){

			return $e->getMessage();

		}
		
	}

	public function sendOTP($id) {

		try{
			$otp = rand(100000,999999);
			$currentDate = date('Y-m-d H:i:s');
			$expiry_date = date('Y-m-d H:i:s', strtotime('+3 minutes', strtotime($currentDate)));
			UsersOTP::where('id',$id)->update(['otp'=>$otp,'expiry_date' =>  $expiry_date]);
			$user = UsersOTP::where('id',$id)->first();
			if(!empty($user->mobile_no)) {
			$app_link = "www.healthgennie.com/download";
			$message =  urlencode("Your Health Gennie OTP is ".$otp."\nThis otp is valid for 60 seconds Thanks Team Health Gennie");
			$this->sendSMS($user->mobile_no,$message,'1707165547064979677');
			}
			return $user->id;

		}catch(Eception $e){

			return $e->getMessage();

		}

	}

	public function confirmOtp(Request $request) {


		try{

			if ($request->isMethod('post')) {
				$data = $request->all();
				$validator = Validator::make($data, [
					'otp' => 'required|numeric|min:6'
				]);
				if($validator->fails()) {
					$errors = $validator->errors();
					return $errors->messages()['otp'];
				}
				$userOTP = UsersOTP::where('id', $request->get('user_id'))->first();
				$currentDate = date('Y-m-d H:i:s');
				if($data['otp'] == $userOTP->otp) {
					if($currentDate <= $userOTP->expiry_date) {
						$user = User::where(['mobile_no'=>$userOTP->mobile_no,'parent_id'=>0])->first();
						if(empty($user)) {
							$user = User::create([
							   'mobile_no' =>  $userOTP->mobile_no,
							   'parent_id' => 0,
							   'status' =>  1,
							   'device_type' =>  3,
							   'login_type' =>  2,
							   'is_login' => 1,
							   'notification_status' => 1,
							]);
							createUsersReferralCode($user->id);
						}
						UsersOTP::Where(['id'=>$userOTP->id])->update(['user_id'=>$user->id,'expiry_date'=>$currentDate]);
						\Auth::login($user);
						Session::put('profile_status', $user->profile_status);
						 if(Session::has('CartPackages')) {
						   $packages = Session::get('CartPackages');
						   if(Session::get("lab_company_type") == 0) {
							LabCart::where(['user_id'=>$user->id])->where('type','!=',0)->delete();
						   }
						   else{
							LabCart::where(['user_id'=>$user->id,'type'=>0])->delete();  
						   }
						   foreach($packages as $key => $value) {
							 if(isset($value['DefaultLabs'])) {
								 $alreadyAdded = LabCart::where(['user_id' => $user->id, 'product_name' => $value['DefaultLabs']['title'], 'product_code' => $value['DefaultLabs']['id']])->delete();
								 if($value['lab_cart_type'] == 'package'){
									 $lab_cart_type = "OFFER";
								 }
								 else{
									 $lab_cart_type = "TEST";
								 }
								   LabCart::create([
									 'type' => $value['lab_company']['id'],
									 'user_id' => $user->id,
									 'product_name' => $value['DefaultLabs']['title'],
									 'product_code' => $value['DefaultLabs']['id'],
									 'product_type' => $lab_cart_type,
								   ]);
							 }
							 else{
								 LabCart::create([
									 'user_id' => $user->id,
									 'product_name' => $value['name'],
									 'product_code' => $value['code'],
									 'product_type' => $value['type'],
								 ]);
							 }
						   }
						   Session::forget('CartPackages');
						 }
						 return 1;
					 }
					 else{
						 return 3;
					 }
				}
				else{
					return 2;
				}
			}

		}catch(Eception $e){

			return $e->getMessage();

		}

	
	}

	public function __construct() {
        $this->middleware('guest')->except('logout');
    }
}
