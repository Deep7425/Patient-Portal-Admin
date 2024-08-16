<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Models\ehr\Appointments;
use Illuminate\Support\Facades\Validator;
use App\Models\ehr\RoleUser;
use App\Models\ehr\PracticeDetails;
use App\Models\ehr\EmailTemplate;
use App\Models\ehr\Plans;
use App\Models\ehr\PracticesSubscriptions;
use App\Models\ehr\ManageTrailPeriods;
use App\Models\ehr\SubscribedPlans;
use App\Models\Contact;
use App\Models\Pages;
use App\Models\SubcribedEmail;
use App\Models\Doctors;
use App\Models\ehr\User as ehrUser;
use App\Models\ehr\DoctorsInfo;
use App\Models\ehr\clinicalNotePermissions;
use App\Models\ehr\OpdTimings;
use App\Models\AppLinkSend;
use App\Models\CovidHospitalDoctors;
use App\Models\CovidHospital;
use App\Models\DonatePlasma;
use App\Models\covidTesting;
use App\Models\OxygenSuppliers;
use App\Models\VaccinationDrive;
use App\Models\RunnersLead;
use App\Models\ReferralCashback;
use App\Models\UsersSubscriptions;
use App\Models\Corporate;
use App\Models\PatientFeedback;
use Illuminate\Support\Facades\Hash;
use DB;
use URL;
use Mail;
use Auth;
use File;
use PDF;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Softon\Indipay\Facades\Indipay;
use App\Models\AuMarathonReg;
use App\Models\SalesTeam;
use App\Models\Coupons;
use App\Models\MedicalStoreDetails;
use App\Models\CovidHelp;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Storage;
use Exception;
use Illuminate\Database\QueryException;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
        // $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

	public function index(){

	
	try{	
		if(!isset($_COOKIE["in_mobile"])) {
			$detect = getsystemInfo($_SERVER);
			if($detect['device']=='MOBILE') {
				$_COOKIE['in_mobile'] = '1';
			}
			else {
				$_COOKIE['in_mobile'] = '0';
			}
		}
		Session::forget('search_from_lab');
		Session::forget('search_from_search_bar');
		$user = \Auth::user();
		// if($user!= null && $user->profile_status != '1') {
  // 			// return redirect()->route('profile',['id'=>base64_encode($user->id)]);
  // 			return view('home');
  // 		}

		// //login from cart
		// else if($user!= null &&  Session::get('loginFrom') == '1') {
		// 	Session::forget('loginFrom');
		// 	Session::forget('profile_status');
		// 	 return redirect()->route('LabCart');
		// }
		// //login from Medicines
		// elseif ($user!= null &&  Session::get('loginFrom') == '2') {
		// 	Session::forget('loginFrom');
		// 	Session::forget('profile_status');
		// 	echo '<script>window.open("'.route('oneMgOpen').'","_blank")</script>';
		// 	return view('home');
		// }
		// elseif($user!= null && Session::get('loginFrom') == '3') {
		// 	Session::forget('loginFrom');
		// 	Session::forget('profile_status');
		// 	$appData = Session::get('appDoctorData');
		// 	Session::forget('appDoctorData');
		// 	return redirect()->route('doctor.bookSlot',$appData)->withInput();
		// }
		// elseif($user!= null && Session::get('loginFrom') == '5') {
		// 	Session::forget('loginFrom');
		// 	Session::forget('profile_status');
		// 	$feedData = Session::get('feedDoctorData');
		// 	Session::forget('feedDoctorData');
		// 	return \Redirect::to($feedData);
		// }
  // 		else{
		// 	Session::forget('loginFrom');
  // 			Session::forget('profile_status');
  // 			return view('home');
  // 		}
		Session::forget('loginFrom');
		Session::forget('profile_status');
		// return view('home');

		return view($this->getView('home'));

	}catch(Exception $e){

		return $e->getMessage();

	}
		
    }

	public function appointmentConfirm(Request $request) {

	
		try{
		$appointment = '';
		if(!empty($request->id)) {
			$appointment_id = base64_decode($request->id);
			$appointment = Appointments::with(['User.DoctorInfo','Patient'])->where('id',$appointment_id)->first();
		}
		if ($request->isMethod('post')) {
			if(!empty($appointment)){
					Appointments::where('id', $appointment_id)->update(array(
						'appointment_confirmation' => 1,
						'status' => 1,
					));
					$practice =  RoleUser::select(['user_id','role_id','practice_id'])->where(['user_id'=>$appointment->doc_id])->first();
					$practiceData =  PracticeDetails::where(['user_id'=>$practice->practice_id])->first();
					$to = $appointment->Patient->email;
					$pat_name = ucfirst($appointment->Patient->first_name)." ".ucfirst($appointment->Patient->last_name);

					if(Parent::is_connected()==1) {
						if(!empty($appointment->Patient->email)) {
							$EmailTemplate = EmailTemplate::where('slug','patientappointment')->first();
							if($EmailTemplate && !empty($to)) {
								$body = $EmailTemplate->description;

								$tbl = '<table style="width: 100%;" cellpadding="0" cellspacing="0"><tbody><tr><td colspan="2" style="color:#189ad4; font-size: 15px;font-weight:500; padding: 15px 0px 0px;">Dear '.$pat_name.'</td></tr><tr><td colspan="2" style="color:#333; font-size: 13px;font-weight:500; padding: 4px 0px 15px;">if you wish to reschedule or cancel your appointment, please call us at <br> '.$practiceData->mobile.'</td></tr><tr><td width="130" style="border:1px solid #ccc;font-size: 13px; color:#189ad4; padding: 5px 10px;">Appointment Dr.</td><td style="border:1px solid #ccc;font-size: 13px; color:#189ad4; padding: 5px 10px;">Dr. '.@$appointment->User->DoctorInfo->first_name." ".@$appointment->User->DoctorInfo->last_name.'</td></tr><tr><td width="130" style="border:1px solid #ccc;font-size: 13px; color:#189ad4; padding: 5px 10px;">Date and Time</td><td style="border:1px solid #ccc;font-size: 13px; color:#189ad4; padding: 5px 10px;">'.date('d-m-Y, h:i:sa',strtotime($appointment->start)).'</td></tr><tr><td width="130" style="border:1px solid #ccc;font-size: 13px; color:#189ad4; padding: 5px 10px;">Address</td><td style="border:1px solid #ccc; font-size: 13px; color:#189ad4; padding: 5px 10px;">'.$practiceData->address_1.', '.$practiceData->address_2.','.getCityName($practiceData->city_id).','.getStateName($practiceData->state_id).','.getCountrieName($practiceData->country_id).','.$practiceData->zipcode.'</td></tr><tr><td colspan="2" style="font-size: 13px; color:#333; padding:10px 0px 10px;">if you wish to reschedule or cancel your appointment,please call us at '.$practiceData->mobile.'</td></tr><tr><td colspan="2" style="font-size: 13px; color:#333; padding:10px 0px 10px;"><strong>Thanks <br>'.$practiceData->clinic_name.'</strong></td></tr></tbody></table>';

								$mailMessage = str_replace(array('{{pat_name}}','{{clinic_name}}','{{clinic_phone}}','{{appointmenttable}}'),
								array($pat_name,$practiceData->clinic_name,$practiceData->mobile,$tbl),$body);
								$to_docname = '';
								$datas = array('to' =>$to,'from' => 'noreply@healthgennie.com','mailTitle'=>$EmailTemplate->title,'practiceData'=>$practiceData,'content'=>$mailMessage,'subject'=>$EmailTemplate->subject);
								try{
								Mail::send( 'emails.mailtempPractice', $datas, function( $message ) use ($datas) {
									$message->to( $datas['to'] )->from( $datas['from'])->subject($datas['subject']);
								});
								}
								catch(\Exception $e)
							   {
								  // Never reached
							   }
							}
						}
						if(!empty($appointment->Patient->mobile_no)) {
							$app_link = "https://www.healthgennie.com/download";
							$appointDate = date('d-m-Y',strtotime($appointment->start));
							$appointtime = date('h:i A',strtotime($appointment->start));
							$message = urlencode("Dear ".ucfirst($appointment->Patient->first_name)." ".$appointment->Patient->last_name." Your appointment with Dr. ".$appointment->User->DoctorInfo->first_name." ".$appointment->User->DoctorInfo->last_name." on  ".$appointDate." at ".$appointtime." has been confirmed by Dr. ".$appointment->User->DoctorInfo->first_name." ".$appointment->User->DoctorInfo->last_name.". Please visit the clinic 15 mins before your appointment time at clinic address. For Better Experience Download Health Gennie App".$app_link." Thanks Team Health Gennie");
							$this->sendSMS($appointment->Patient->mobile_no,$message,'1707161735128760937');
						}
					}
					return 1;
			}
		}
		return view($this->getView('doctors.appointment-confirmation'),['appointment'=>$appointment]);

	}catch(Exception $e){

		return $e->getMessage();

	}

    }

	public function appointmentCancel(Request $request) {

		try{
		if(!empty($request->id)) {
			$appointment_id = base64_decode($request->id);
			$appointmentData = Appointments::with(['User.DoctorInfo','Patient'])->where('id',$appointment_id)->first();
			if(!empty($appointmentData)) {
					Appointments::where('id', $appointment_id)->update(array(
						'status' => 0,
						'appointment_confirmation' => 1,
						'cancel_reason' => "cancelbydoctor",
					));
					  $practice =  RoleUser::select(['user_id','role_id','practice_id'])->where(['user_id'=>$appointmentData->doc_id])->first();
					  $practiceData =  PracticeDetails::where(['user_id'=>$practice->practice_id])->first();
					  $pName = ucfirst($appointmentData->Patient->first_name)." ".@$appointmentData->Patient->last_name;
					  $doctorname = $appointmentData->User->DoctorInfo->first_name.' '.$appointmentData->User->DoctorInfo->last_name;
					  $appointDate = date('d-m-Y',strtotime($appointmentData->start));
					  $appointtime = date('h:i A',strtotime($appointmentData->start));
					  if(Parent::is_connected()==1){
						if(!empty($appointmentData->Patient->email)) {
							$to = $appointmentData->Patient->email;
							$EmailTemplate = EmailTemplate::where('slug','cancelappointmentmailPatient')->first();
							if($EmailTemplate){
								$body = $EmailTemplate->description;

								$mailMessage = str_replace(array('{{pat_name}}','{{clinic_name}}','{{date}}','{{time}}','{{doctorname}}','{{mobile}}'),
								array($pName,$practiceData->clinic_name,$appointDate,$appointtime,$doctorname,$appointmentData->User->DoctorInfo->mobile),$body);
								$datas = array( 'to' =>$to,'from' => 'noreply@healthgennie.com','mailTitle'=>$EmailTemplate->title,'content'=>$mailMessage,'practiceData'=>$practiceData,'subject'=>$EmailTemplate->subject);
								try{
								Mail::send( 'emails.mailtempPractice', $datas, function( $message ) use ($datas)
								{
									$message->to( $datas['to'] )->from( $datas['from'])->subject($datas['subject']);
								});
								}
								catch(\Exception $e)
								   {
									  // Never reached
								   }
							}
						}
						if (!empty($appointmentData->Patient->mobile_no)) {
							$app_link = "www.healthgennie.com/download";
							$message = urlencode("Dear ".$pName.", Due to the unavailability of Dr., Your request for appointment with Dr. ".$doctorname." has not been approved. Please select an alternate time or book appointment with another Doctor \nFor Better Experience Download Health Gennie App\n".$app_link."\nThanks Team Health Gennie.");
						$this->sendSMS($appointmentData->Patient->mobile_no,$message,'1707161588025544243');
						}
							  $docName = "Dr. ".ucfirst($appointmentData->User->DoctorInfo->first_name)." ".$appointmentData->User->DoctorInfo->last_name;
							  $patientname = $appointmentData->Patient->first_name.' '.$appointmentData->Patient->last_name;
							  $appointDate = date('d-m-Y',strtotime($appointmentData->start));
							  $appointtime = date('h:i A',strtotime($appointmentData->start));
								if(!empty($appointmentData->User->email)) {
									$to = $appointmentData->User->email;
									$EmailTemplate = EmailTemplate::where('slug','cancelappointmentmaildoctor')->first();
									if($EmailTemplate) {
										$body = $EmailTemplate->description;

										$mailMessage = str_replace(array('{{doc_name}}','{{clinic_name}}','{{date}}','{{time}}','{{patientname}}'),
										array($docName,$practiceData->clinic_name,$appointDate,$appointtime,$patientname),$body);
										$datas = array( 'to' =>$to,'from' => 'noreply@healthgennie.com','mailTitle'=>$EmailTemplate->title,'content'=>$mailMessage,'practiceData'=>$practiceData,'subject'=>$EmailTemplate->subject);
										try{
										Mail::send( 'emails.mailtempPractice', $datas, function( $message ) use ($datas)
										{
											$message->to( $datas['to'] )->from( $datas['from'])->subject($datas['subject']);
										});
										}
										catch(\Exception $e)
									   {
										  // Never reached
									   }
									}
								}
							if (!empty($appointmentData->User->DoctorInfo->mobile)) {
							  $message = urlencode("Dear ".$docName.", Appointment of ".$patientname.", with you on ".$appointDate." at ".$appointtime." has been cancelled Thanks Team Health Gennie");
							  $this->sendSMS($appointmentData->User->DoctorInfo->mobile,$message,'1707161587827747448');
							}
					  }
				return 1;
			}
		}

	}catch(Exception $e){

		return $e->getMessage();

	}
    }

	public function aboutUs(){

		try{

		return view($this->getView('pages.about'));

		}catch(Exception $e){

			return $e->getMessage();

		}
    }
	public function contactUs(Request $request) {

		try{
		if($request->isMethod('post')) {
			$data = $request->all();
			$validator = Validator::make($data, [
				'interest_in' => 'required|max:255',
				'name' => 'required|max:50',
				'email' => 'required|email|max:255',
				'mobile' => 'required|numeric',
				'subject' => 'required|max:50',
				'message' => 'required|max:255'
			]);
			if($validator->fails()) {
				$errors = $validator->errors();
				return redirect('contact-us')->withErrors($validator)->withInput();
			}
			else {
				$contact =  Contact::create([
					 'interest_in' => $data['interest_in'],
					 'name' => $data['name'],
					 'email' => $data['email'],
					 'mobile' => $data['mobile'],
					 'subject' => $data['subject'],
					 'message' => $data['message'],
					 'status' => 1
				 ]);
				$from = $contact->email;
				$EmailTemplate = EmailTemplate::where('slug', 'webcontactus')->first();
				if(Parent::is_connected()==1) {
					if($EmailTemplate) {
						$body = $EmailTemplate->description;
						array($body);
						$username = ucfirst($contact->name);
						$message = $data['message'];
						$mailMessage = str_replace(array('{{username}}','{{email}}','{{contact_no}}','{{comment}}'),array($username,$from,$contact->mobile,$message),$body);
						$datas = array( 'to' =>'info@healthgennie.com','from' =>$from,'mailTitle'=>$EmailTemplate->title,'content'=>$mailMessage,'subject'=>$EmailTemplate->subject);
						try {
						  Mail::send( 'emails.all', $datas, function( $message ) use ($datas)
						  {
						  $message->to($datas['to'])->from($datas['from'], 'HealthGennie')->subject($datas['subject']);
						  });
						}
						catch(\Exception $e)
						{
						   // Never reached
						}
					}
				}
				Session::flash('message', "Thanks For Your Contact! We will contact soon");
			}
			return redirect()->route('contactUs');
        }
		return view($this->getView('pages.contact'));

		}catch(Exception $e){

			return $e->getMessage();

		}
    }
	public function subcribedEmail(Request $request) {

	  try{	
		$data = $request->all();
		$validator = Validator::make($data, [
			'email' => 'required|email|max:255'
		]);
		if($validator->fails()) {
			$errors = $validator->errors();
			return $errors->messages()['email'];
		}
		SubcribedEmail::create(['email'=>$request->email]);
		$EmailTemplate = EmailTemplate::where('slug','subscribed_email')->first();
		if($EmailTemplate) {
			$body = $EmailTemplate->description;
			$datas = array('to' =>$request->email,'from' => 'noreply@healthgennie.com','mailTitle'=>$EmailTemplate->title,'content'=>$body,'subject'=>$EmailTemplate->subject);
			try{
			Mail::send('emails.subscribedEmail', $datas, function( $message ) use ($datas)
			{
				$message->to( $datas['to'] )->from( $datas['from'])->subject($datas['subject']);
			});
			}
			catch(\Exception $e)
		   {
			  // Never reached
		   }
		}
		Session::flash('message', "Thanks For Your Subcription.");
		return 1;

	}catch(Exception $e){

		return $e->getMessage();

	}

	}
	public function viewMailTemplate(Request $request) {
	
		try{
		return view($this->getView('emails.subscribedEmail'));
		}catch(Exception $e){

			return $e->getMessage();

		}
	}
	public function carrerUs(){
	
		try{
		return view($this->getView('pages.career'));
		}catch(Exception $e){

			return $e->getMessage();

		}
    }
	public function helpMe(){
		try{
		return view($this->getView('pages.help'));
		}catch(Exception $e){

			return $e->getMessage();

		}
    }
	public function privacyPolicy(){
	
		try{
		
		$page = Pages::where(["slug"=>"privacy_policy"])->first();
		return view($this->getView('pages.privacy-policy'),['page'=>$page]);

		}catch(Exception $e){

			return $e->getMessage();

		}
    }
	public function termsConditions() {
	
	 try{	
		$page = Pages::where(["slug"=>"terms_conditions"])->first();
		return view($this->getView('pages.terms-conditions'),['page'=>$page]);
	
	}catch(Exception $e){

		return $e->getMessage();

	}
    }
	public function claimTermsConditions() {
	
		try{
		$page = Pages::where(["slug"=>"claim_terms_conditions"])->first();
		return view($this->getView('pages.terms-conditions'),['page'=>$page]);
	
		}catch(Exception $e){

			return $e->getMessage();

		}
    }
	public function oneMgOpen(Request $request) {

		try{

		if(Auth::user() == null) {
		  Session::put('loginFrom', '2');
		  return redirect()->route('login');
		}
		$user = \Auth::user();
		if($user) {
			header('Location: http://bit.ly/2vMrOls');
			exit;
		}
		else{
			return view($this->getView('home'));
		}
       /* $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.1mg.com/webservices/merchants/generate-merchant-hash");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, true);
		$user = \Auth::user();
		if($user){
			$user_id = $user->id;
			$email = $user->email;
			$name = $user->first_name." ".$user->last_name;
			$data = array(
				'api_key' => 'cadc8dff-c1a8-4bf9-9a1f-cbb1d8ea8ed9',
				'user_id' => $user_id,
				'email' => $email,
				'name' => $name,
				'redirect_url' => 'https://www.1mg.com/',
				'source' => 'health_gennie'
			);

			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$output = curl_exec($ch);
			$info = curl_getinfo($ch);
			curl_close($ch);
			$hash = json_decode($output)->hash;
			header('Location: https://www.1mg.com?_source=health_gennie&merchant_token='.$hash);
			exit;
		}*/

		}catch(Exception $e){

			return $e->getMessage();

		}

    }

	public function hgOffers(Request $request) {

		try{
		/*$id = Session::get('offer_doc_id');
		$doctor = "";
		if(!empty($id)){
			$doctor = Doctors::with(["docSpeciality","DoctorRatingReviews"])->Where(['id'=>$id])->first();
		}
		return view($this->getView('subscription.health-gennie-offers'),['doctor'=>$doctor]);*/
		// $refers = ReferralCashback::select('referral_id','referred_id',DB::raw('count(referred_id) as total_ref'))->where(['status'=>1,'paytm_status'=>'DE_001'])->groupBy('referral_id')->orderBy('total_ref','DESC')->get();
		// $t_countRef = 0;
		// if(count($refers)){
			// foreach($refers as $raw){
				// $t_countRef += $raw->total_ref;
			// }
		// }
		if ($request->isMethod('post')) {
		 $params = array();
		 if (!empty($request->input('fname'))) {
             $params['fname'] = base64_encode($request->input('fname'));
         }
         return redirect()->route('hgOffers',$params)->withInput();
		}
		else{
			$query = UsersSubscriptions::with(['User','PlanPeriods','UserReferral'=> function($q) {
					$q->select('referral_id','referred_id',DB::raw('count(referred_id) as total_ref'))->where(['status'=>1,'paytm_status'=>'DE_001'])->groupBy('referral_id');
			}]);
			if(!empty($request->input('fname'))) {
				$fname = base64_decode($request->input('fname'));
				$query->whereHas('User', function($q) use($fname){
				  $q->where(DB::raw('concat(IFNULL(first_name,"")," ",IFNULL(last_name,"")," ",IFNULL(mobile_no,""))') , 'like', '%'.$fname.'%');
				});
			}
			$subs =  $query->whereHas('PlanPeriods', function($q){
			  $q->Where('status', 1);
			})->where(["order_status"=>1])->where('user_id','!=','1')->groupBy('user_id')->get()->toArray();
			if(count($subs)>0) {
				$subsData = [];
				foreach($subs as $key => $raw) {
					if(!empty($raw['user_referral'])){
						$raw['total_ref'] = $raw['user_referral']['total_ref'];
					}
					else{
						$raw['total_ref'] = 0;
					}
					$subsData[] = $raw;
				}
				$tref = array();
				foreach($subsData as $key => $raw) {
					if(!empty($raw['total_ref'])) {
						$tref[$key] = $raw['total_ref'];
					}
					else{
						$tref[$key] = 0;
					}
				}
				array_multisort($tref, SORT_DESC, $subsData);
				$subs = $subsData;
			}
			// $perPage = 10;
			// $input = Input::all();
			// if (isset($input['page']) && !empty($input['page'])) { $currentPage = $input['page']; } else { $currentPage = 1; }

			// $offset = ($currentPage * $perPage) - $perPage;
			// $itemsForCurrentPage = array_slice($subs, $offset, $perPage, false);
			// $subs =  new Paginator($itemsForCurrentPage, count($subs), $perPage,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
			return view($this->getView('pages.offers'),['subs'=>$subs]);
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
    }

	public function hgOffersPlans(Request $request) {

		
	
		try{
		
		if(!empty($request->doc_id)) {
		
			$doc_id = base64_decode($request->doc_id);
			$doctor = Doctors::where('delete_status', '=', '1')->Where('id','=',$doc_id)->first();
			return view($this->getView('subscription.health-gennie-plans'),['doc_id'=>$doc_id,'doctor'=>$doctor]);
		}
		else{
			// dd(222);
			return view($this->getView('home'));
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
    }

	public function checkOut(Request $request) {


		try{

		if($request->isMethod('post')){
			$data = $request->all();
			$doc_id = $data['doc_id'];
		}
		else{
			if(!empty($request->id)) {
				$doc_id = base64_decode($request->doc_id);
				$product_id = base64_decode($request->id);

				$doc_data = Doctors::Where(['id'=>$doc_id])->first();
				if(empty($doc_data->user_id)) {
					$pass  = trim(substr($doc_data->first_name,0,3)).substr($doc_data->mobile_no,-4).rand(000,999);

					$urls = json_encode(getEhrFullUrls());
					if(!empty($doc_data->clinic_image)){
						$this->uploadClinicImgFileBy($doc_data->clinic_image);
					}
					if(!empty($doc_data->profile_pic)){
						$this->uploadDoctorFileBy($doc_data->profile_pic);
					}
					if(!empty($doc_data->practice_id)) {
						$mem_id = $this->getUniqueId('Doc');
					}
					else{
						$mem_id = $this->getUniqueId('Pra');
					}

					$user =  ehrUser::create([
						'email' => $doc_data->email,
						'mobile_no' => $doc_data->mobile_no,
						'device_id' => 3,
						'reg_device_type' => 4,
						'member_id'=> $mem_id,
						'profile_status' => 1,
						'password'=>bcrypt($pass),
					]);

					if(empty($doc_data->practice_id)) {
						$practiceDetails    = new PracticeDetails;
						$practiceDetails->clinic_name = $doc_data->clinic_name;
						$practiceDetails->address_1 = $doc_data->address_1;
						$practiceDetails->mobile = $doc_data->clinic_mobile;
						$practiceDetails->email = $doc_data->clinic_email;
						$practiceDetails->practice_type = $doc_data->practice_type;
						$practiceDetails->city_id = $doc_data->city_id;
						$practiceDetails->locality_id = $doc_data->locality_id;
						$practiceDetails->state_id = $doc_data->state_id;
						$practiceDetails->country_id = $doc_data->country_id;
						$practiceDetails->zipcode = $doc_data->zipcode;
						$practiceDetails->website = $doc_data->website;
						$practiceDetails->specialization = $doc_data->clinic_speciality;
						$practiceDetails->logo = $doc_data->clinic_image;
						$practiceDetails->slot_duration =  $doc_data->slot_duration;
						$practiceDetails->my_visits = '{"1":{"id":"1","amount":"'.$doc_data->consultation_fees.'"},"2":{"id":"4","amount":""}}';
						$user->practiceDetails()->save($practiceDetails);
					}

					  $userDetails    = new DoctorsInfo;
					  $userDetails->first_name  = ucfirst($doc_data->first_name);
					  $userDetails->last_name  = $doc_data->last_name;
					  $userDetails->mobile  = $doc_data->mobile_no;
					  $userDetails->gender  = $doc_data->gender;
					  $userDetails->reg_no  = $doc_data->reg_no;
					  $userDetails->reg_year  = $doc_data->reg_year;
					  $userDetails->reg_council  = $doc_data->reg_council;
					  $userDetails->last_obtained_degree  = $doc_data->last_obtained_degree;
					  $userDetails->degree_year  = $doc_data->degree_year;
					  $userDetails->university  = $doc_data->university;
					  $userDetails->consultation_discount  = $doc_data->consultation_discount;
					  $userDetails->speciality  = $doc_data->speciality;
					  $userDetails->address_1  = $doc_data->address_1;
					  $userDetails->city_id  = $doc_data->city_id;
					  $userDetails->locality_id  = $doc_data->locality_id;
					  $userDetails->state_id  = $doc_data->state_id;
					  $userDetails->country_id  = $doc_data->country_id;
					  $userDetails->zipcode  = $doc_data->zipcode;
					  $userDetails->profile_pic  = $doc_data->profile_pic;
					  $userDetails->educations  = $doc_data->qualification;
					  $userDetails->experience  = $doc_data->experience;
					  $userDetails->content  = $doc_data->content;
					  $userDetails->consultation_fee  = $doc_data->consultation_fees;
					  $userDetails->ref_code  = $doc_data->ref_code;
					  $userDetails->oncall_status  = $doc_data->oncall_status;
					  $userDetails->oncall_fee  = $doc_data->oncall_fee;
					  $userDetails->acc_no  = $doc_data->acc_no;
					  $userDetails->ifsc_no  = $doc_data->ifsc_no;
					  $userDetails->bank_name  = $doc_data->bank_name;
					  $userDetails->paytm_no  = $doc_data->paytm_no;
					  $userDetails->hg_doctor  = 1;
					  $userDetails->claim_status  = 1;
					  $user->doctorInfo()->save($userDetails);

					if(!empty($doc_data->practice_id)) {
						$role =  RoleUser::create([
							'user_id' => $user->id,
							'role_id' => 3,
							'practice_id' => $doc_data->practice_id
						]);
						$practice_id = $doc_data->practice_id;
					}
					else {
						$role_type = array(2,3);
						foreach($role_type as $key=>$val){
						   $role    = new RoleUser;
						   $role->role_id = $val;
						   $role->practice_id = $user->id;
						   $user->RoleUser()->save($role);
						}
						$practice_id = $user->id;
					}

					clinicalNotePermissions::insert(['user_id'=>$user->id,'practice_id' => $user->id,'modules_access' => "1,2,3,4,6,7,8,9,11,12,13,14,15,16" ,'created_at'=> date("Y-m-d h:i:s"), 'updated_at'=> date("Y-m-d h:i:s")]);

					OpdTimings::create(['user_id'=>$user->id,'practice_id'=>$user->id,'schedule' => $doc_data->opd_timings]);

					Doctors::where('id', $doc_id)->update(array(
						//'hg_doctor' => 1,
						//'varify_status' => 1,
						'password' => bcrypt($pass),
						'created_at' => date('Y-m-d h:i:s'),
						'user_id'=> $user->id,
						'member_id'=> $user->member_id,
						'practice_id' => $practice_id,
						'claim_status' => 1,
					));

					$plans = Plans::Where("id",5)->first();
					$duration_type = $plans->plan_duration_type;
					if($duration_type=="d") {
					  $duration_in_days = $plans->plan_duration;
					}
					elseif ($duration_type=="m") {
					  $duration_in_days = (30*$plans->plan_duration);
					}
					elseif ($duration_type=="y") {
					  $duration_in_days = (365*$plans->plan_duration);
					}
					$create_date = date('Y-m-d H:i:s');
					$end_date = date('Y-m-d H:i:s', strtotime($create_date.'+'.$duration_in_days.' days'));
					$ManageTrailPeriods =  ManageTrailPeriods::create([
					   'user_id' => $user->id,
					   'user_plan_id'=> $plans->id,
					   'start_trail' => $create_date,
					   'end_trail'=> $end_date,
					   'remaining_sms' => $plans->promotional_sms_limit
					]);
				}
				$plan = Plans::where('id', $product_id)->first();
				return view($this->getView('subscription.checkout_plan'),['plan'=>$plan,'doc_id'=>$doc_id]);
			}
			else{
				Session::flash('message', "You didn't select any plan");
				return redirect()->route('hgOffersPlans');
			}
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
    }

	public  function varifyAfterSubcription(Request $request) {

		try{

		$id = $request->id;
		if(!empty($id)) {
			$doc_data = Doctors::where(["id"=>$id])->first();
			$pass = $doc_data->first_name."".$doc_data->reg_no;
			Doctors::where('id', $id)->update(array(
				'hg_doctor' => 1,
				'varify_status' => 1,
				'password' => bcrypt($pass),
				'created_at' => date('Y-m-d h:i:s'),
			));
			ehrUser::where('id',$doc_data->user_id)->update(array(
				'varify_status' => 1,
				'password'=>bcrypt($pass),
			));
			if(!empty($doc_data->mobile_no)) {
				$username = ucfirst($doc_data->first_name)." ".$doc_data->last_name;
				$to = $doc_data->email;
				$message = urlencode("Congratulation! Dear Dr. ".$username.", Your profile verified successfully with HealthGennie.Your Subcription start from now.Please use this credential for login Email : ".$to." Password : ".$pass." Thanks,If any query please call at +91-8929920932 Thanks Team Health Gennie");
				$this->sendSMS($doc_data->mobile_no,$message,'1707161735186568608');
			}
			return 1;
		}
		return 2;

			}catch(Exception $e){

				return $e->getMessage();

			}
	}

	public function getUniqueId($str) {

		try{
        $num = 1;
        // $users =  DB::select('SELECT MAX(CAST((SUBSTRING(member_id,4)) as UNSIGNED)) as total FROM healthgennieEhr.users');
        $users =  ehrUser::select(DB::raw('MAX(CAST((SUBSTRING(member_id,4)) as UNSIGNED)) as total'))->pluck('total');
		// return $users[0];
		if(!empty($users)) {
           $num = $users[0]+$num;
        }
        return $str.$num;

		}catch(Exception $e){

			return $e->getMessage();

		}
    }

	public function uploadDoctorFileBy($fileName,$old_image = null) {
		// @file_get_contents(getEhrUrl()."/doctorFileWriteByUrl?fileName=".$fileName."&old_profile_pic=".$old_image);
    }

	public function uploadClinicImgFileBy($fileName,$old_image = null) {
		// @file_get_contents(getEhrUrl()."/clinicFileWriteByUrl?fileName=".$fileName."&old_profile_pic=".$old_image);
    }

	public function SendAppLink(Request $request) {


		try{

		if ($request->isMethod('post')) {
		  $data = $request->all();
			$validator = Validator::make($data, [
				'mobile_no' => 'required|min:10'
			]);
			if($validator->fails()) {
				$errors = $validator->errors();
				return $errors->messages()['mobile_no'];
			}
		  $mobile_no = trim(str_replace(" ","",$data['mobile_no']));
		  AppLinkSend::create(["mobile_no"=>$mobile_no]);
		  $app_link = "www.healthgennie.com/download";
		  $message = urlencode("Click on below link to download Health Gennie App ".$app_link." Thanks Team Health Gennie");
			$this->sendSMS($mobile_no,$message,'1707161588035056619');
		  return 1;
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
	}

	public function healthgenniePatientApp(Request $request) {

		try{
          $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
          $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
          $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
          $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
          $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

          //do something with this information
          if( $iPod || $iPhone || $iPad){
            sleep(1);
            header('Location: https://apps.apple.com/in/app/health-gennie-care-at-home/id1492557472');
            exit;
          }
          else {
            sleep(1);
            header('Location: https://play.google.com/store/apps/details?id=io.Hgpp.app&hl=en');
            exit;
          }
		}catch(Exception $e){

			return $e->getMessage();

		}
    }

	public function qrCodeIndex(Request $request,$action,$slug) {

		try{
      if ($action == "clinic") {
        $doc_id = getClinicIdBySlug($slug);
      }
      else {
        $doc_id = getDoctorIdBySlug($slug);
      }
		if(!empty($doc_id) && count($doc_id) > 0){
			$user = Doctors::Where(['id'=>$doc_id])->first();
			if(!empty($user)){
        if ($action == "clinic") {
          $user['url'] = url("/")."/".$user->getCityName->slug."/clinic/".$user->DoctorSlug->clinic_name_slug;
        }
        else {
          $user['url'] = url("/")."/".$user->getCityName->slug."/doctor/".$user->DoctorSlug->name_slug;
        }
				if($request->file_type == "pdf"){
					$pdf = PDF::loadView('admin.qrCode.printqrCode',compact('user'))->setOption('page-width', '1152')->setOption('page-height', '1728');
					return $pdf->download('doctor-qr-code.pdf');
				}
				return view($this->getView('admin.qrCode.qrCodeIndex'),['user'=>$user]);
			}
			else{
				return abort(404);
			}
		}
		else{
			return abort(404);
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
    }

	public function printqrCode(Request $request) {
		try {
		$id = $request->input('id');
		$action = $request->input('action');
		$logo = "https://www.healthgennie.com/img/health-gennie-logo23.png";
		$user = Doctors::Where(['id'=>$id])->first();
		if ($action == "clinic") {
		  $user['url'] = url("/")."/".$user->getCityName->slug."/clinic/".$user->DoctorSlug->clinic_name_slug;
		}
		else {
		  $user['url'] = url("/")."/".$user->getCityName->slug."/doctor/".$user->DoctorSlug->name_slug;
		}
        if($request->input('qRtype') == '1'){
			return view($this->getView('admin.qrCode.printqrCodeEnglish'),['user'=>$user,'action'=>$action,'logo'=>$logo]);
		}
		else{
			return view($this->getView('admin.qrCode.printqrCodeHindi'),['user'=>$user,'action'=>$action,'logo'=>$logo]);
		}
		}catch(Exception $e){

			return $e->getMessage();

		}
    }

	public function downloadQrCode(Request $request) {

		try{
		$id = $request->input('id');
		$user = Doctors::Where(['id'=>$id])->first();
		$user['url'] = url("/")."/".$user->getCityName->slug."/doctor/".$user->DoctorSlug->name_slug;
		$pdf = PDF::loadView('admin.qrCode.printqrCode',compact('user'));
        return $pdf->download('doctor-qr-code.pdf');
		/*$docPath = public_path().'/doctor/'.$user->id.'/qrcode/';
		if(!is_dir($docPath)){
			 File::makeDirectory($docPath, $mode = 0777, true, true);
		}
		if(!file_exists($docPath.'qrCodePrint.pdf')) {
			File::copy(public_path().'/htmltopdfview.pdf', $docPath.'qrCodePrint.pdf');
			File::makeDirectory($docPath.'qrCodePrint.pdf', $mode = 0777, true, true);
		}
		$output = PDF::loadHTML($html)->output();
		file_put_contents(public_path()."/doctor/".$user->id."/qrcode/qrCodePrint.pdf", $output);
		return 1;*/

		}catch(Exception $e){

			return $e->getMessage();

		}
    }

	public function qrCodeApp(Request $request) {
		try{
		$url = "https://www.healthgennie.com/download";
		return view($this->getView('admin.qrCode.qrCodeApp'),['url'=>$url]);

		}catch(Exception $e){

			return $e->getMessage();

		}
    }

    public function AuMarathonReg(Request $request) {

	
	try{	
      if ($request->isMethod('post')) {
			  $data = $request->all();
              $already = AuMarathonReg::Where('mobile_no', 'LIKE', "%{$data['mobile_no']}%")->first();

              $validatedData = Validator::make($data, [
                'name' => 'required|max:50',
                'email' => 'required|max:50',
                'mobile_no' => 'required|min:10',
                'dob' => 'required',
                'gender' => 'required',
                't_shirt_size' => 'required'
              ]);
              if($validatedData->fails()){
                  $errors = $validatedData->errors();
                  return array('status' => 0, 'error' => $errors);
              }
              else {
					if(empty($already)) {
					  $registration =  AuMarathonReg::create([
						 'name' => $data['name'],
						 'email' => $data['email'],
						 'mobile_no' => $data['mobile_no'],
						 'dob' => date("Y-m-d", strtotime($data['dob'])),
						 'gender' => $data['gender'],
						 't_shirt_size' => $data['t_shirt_size']
					  ]);
					  if (!empty($data['mobile_no'])) {
						  $mobile_no = trim($data['mobile_no']);
						  $message = urlencode("Thank you for registering for AU bank Jaipur Marathon Dream run category. Please collect your kit from Diggi Palace , Jaipur on 31st Jan 2020 from 10 am to 7 PM. Download healthgennie app from healthgennie.com/download to show at the time of kit collection.\nTeam Health Gennie.");
						  $this->sendSMS($mobile_no,$message);
					  }
					  saveUserActivity($request, 'AuMarathonReg', 'au_marathon_reg', @$registration->id);
                  return 1;
                }
                else {
                    return 0;
                }
              }
		 }
         // return view('pages.au-marathon-registration');
		 return view($this->getView('pages.au-marathon-registration'));

		}catch(Exception $e){

			return $e->getMessage();

		}
      }
		public function generateCode(Request $request) {
			try{
			 return view($this->getView('pages.generate-code'));
			}catch(Exception $e){

				return $e->getMessage();
	
			}
		}
		public function generateCouponCode(Request $request) {

			try{

		if ($request->isMethod('post')) {
			 $data = $request->all();
			 $validator = Validator::make($data, [
				'name' => 'required|max:50',
				'owner_name' => 'required|max:50',
				'address' => 'required|max:255',
				'mobile' => 'required|numeric',
				'interest_in' => 'required|max:50',
			]);
			if($validator->fails()) {
				$errors = $validator->errors();
				return redirect('generateCode')->withErrors($validator)->withInput();
			}
			else {
				$fileName = null;
				if(isset($data['document']) && $request->hasFile('document')) {
					$images = $request->file('document');
					$fileName = str_replace(" ","",$images->getClientOriginalName());
					$filepath = 'public/medicalStoreFiles/';
					// if(!is_dir($filepath)){
						// File::makeDirectory($filepath, $mode = 0777, true, true);
					// }
					Storage::disk('s3')->makeDirectory($filepath);
					// $request->file('document')->move($filepath, $fileName);
					Storage::disk('s3')->put($filepath.$fileName, file_get_contents($images),'public');
				}
				 $user = SalesTeam::Where('id', $data['interest_in'])->first();
				 // $name = explode(" ",$user->name);
				 $cop = Coupons::select("id")->orderBy("id","DESC")->first();
				 $cop_id = 1;
				 if(!empty($cop)){
					 $cop_id = $cop->id + 1;
				 }
				 // $rand = rand(100,999);
				 $coupon_code = "GENNIE".''.$cop_id;
				 $coupon = Coupons::create([
					 'type' => 2,
					 'coupon_title' => 'Extra Discount',
					 'coupon_discount' => 5,
					 'coupon_code' => strtoupper($coupon_code),
					 'coupon_duration_type' => 'y',
					 'coupon_duration' => 1,
					 'coupon_last_date' => date('Y-m-d',strtotime('+1 year',strtotime(date('Y-m-d')))),
					 'generated_by' => $data['interest_in'],
				 ]);

				 MedicalStoreDetails::create([
					 'name' => $data['name'],
					 'address' => $data['address'],
					 'owner_name' => $data['owner_name'],
					 'mobile' => $data['mobile'],
					 'document' => $fileName,
					 'acc_no' => $data['acc_no'],
					 'acc_name' => $data['acc_name'],
					 'ifsc_no' => $data['ifsc_no'],
					 'bank_name' => $data['bank_name'],
					 'paytm_no' => $data['paytm_no'],
					 'country_id' => $data['country_id'],
					 'state_id' => $data['state_id'],
					 'city_id' => $data['city_id'],
					 'coupon_id' => $coupon->id,
					 'generated_by' => $data['interest_in'],
				 ]);
				 $message = urlencode("Dear ".$user->name.", Please use this coupon code to get extra 5% discount.{#var#}\n".$coupon_code);
				 $this->sendSMS($user->mobile,$message,'1707161735181382094');
				 Session::flash('message', "Coupon code generated successfully. ".$coupon->coupon_code);
				 return redirect()->route('generateCode');
				 // return array('status'=>1, 'coupon' => $coupon_code);
			 }
		 }

		}catch(Exception $e){

			return $e->getMessage();

		}
	}

	public function CovidHelp(Request $request) {
		try{
		if ($request->isMethod('post')) {
			$data = $request->all();
			$validatedData = Validator::make($data, [
				'helper_no' => 'required|min:10',
				// 'target_no' => 'required|min:10'
			]);
			if($validatedData->fails()){
					$errors = $validatedData->errors();
					return array('status' => 0, 'error' => $errors);
			}
			else {
					$registration =  CovidHelp::create([
					 'helper_no' => $data['helper_no'],
					 'target_no' => @$data['target_no']
					]);
					saveUserActivity($request, 'CovidHelp', 'covid_help', @$registration->id);
					return 1;
			}
	 }
			 // return view('pages.au-marathon-registration');
	 return view($this->getView('pages.covid-help'));

	}catch(Exception $e){

		return $e->getMessage();

	}
		}

	public function covidGuide(Request $request) {
	try{	
		return view($this->getView('pages.covid-guide'));

	}catch(Exception $e){

		return $e->getMessage();

	}
	}
	public function covidTreatment(Request $request) {
		try{
		return view($this->getView('pages.covid-treatment'));
		}catch(Exception $e){

			return $e->getMessage();

		}
	}
	public function covidVaccine(Request $request) {
	try{	
		return view($this->getView('pages.covid-vaccine'));

	}catch(Exception $e){

		return $e->getMessage();

	}
	}
		public function covidDoctors(Request $request) {

	  try{		
		if ($request->isMethod('post')) {
		$params = array();
		 if (!empty($request->input('state'))) {
             $params['state'] = base64_encode($request->input('state'));
         }
		 if (!empty($request->input('city'))) {
             $params['city'] = base64_encode($request->input('city'));
         }
         return redirect()->route('covidDoctors',$params)->withInput();
		}
		else{
			$query = CovidHospitalDoctors::with("CovidHospital")->where('status',1);
			if(!empty($request->input('state'))) {
				$state = base64_decode($request->input('state'));
				$query->whereHas('CovidHospital', function($q) use($state) {
					$q->where(['state'=>$state]);
				});
			}
			if(!empty($request->input('city'))) {
				$city = base64_decode($request->input('city'));
				$query->whereHas('CovidHospital', function($q) use($city) {
					$q->where(['city'=>$city]);
				});
			}
			$doctors = $query->get();
			$hgDocs = CovidHospitalDoctors::where(['hos_id'=>0,'status'=>1])->get();
			// pr($hgDocs);
			return view($this->getView('pages.covid-doctors'),['doctors'=>$doctors,'hgDocs'=>$hgDocs]);
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
	}
	public function covidHospital(Request $request) {
	
		try{
		if ($request->isMethod('post')) {
		$params = array();
		 if (!empty($request->input('state'))) {
             $params['state'] = base64_encode($request->input('state'));
         }
		 if (!empty($request->input('city'))) {
             $params['city'] = base64_encode($request->input('city'));
         }
         return redirect()->route('covidHospital',$params)->withInput();
		}
		else{
			$query = CovidHospital::with("CovidHospitalDoctors")->where('status',1);
			if(!empty($request->input('state'))) {
				$state = base64_decode($request->input('state'));
				$query->where('state',$state);
			}
			if(!empty($request->input('city'))) {
				$city = base64_decode($request->input('city'));
				$query->where('city',$city);
			}
			$hospitals = $query->get();
			return view($this->getView('pages.covid-hospitals'),['hospitals'=>$hospitals]);
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
	}
	public function homeService(Request $request) {
		try{
		return view($this->getView('pages.home-service'));
		}catch(Exception $e){

			return $e->getMessage();

		}
	}
	public function meal(Request $request) {
	try{	
		return view($this->getView('pages.meal'));

	}catch(Exception $e){

		return $e->getMessage();

	}
	}
	public function plasama(Request $request) {
		try{
		if ($request->isMethod('post')) {
		$params = array();
		 if (!empty($request->input('state'))) {
             $params['state'] = base64_encode($request->input('state'));
         }
		 if (!empty($request->input('city'))) {
             $params['city'] = base64_encode($request->input('city'));
         }
         return redirect()->route('plasama',$params)->withInput();
		}
		else{
			$query = DonatePlasma::where('status',1);
			if(!empty($request->input('state'))) {
				$state = base64_decode($request->input('state'));
				$query->where('state',$state);
			}
			if(!empty($request->input('city'))) {
				$city = base64_decode($request->input('city'));
				$query->where('city',$city);
			}
			$plasama = $query->get();
			// $subs = UsersSubscriptions::with(['User'])->
				// whereHas('UserReferral', function($q) {
					// $q->select('referral_id','referred_id',DB::raw('count(referred_id) as total_ref'))->where(['status'=>1,'paytm_status'=>'DE_001'])->groupBy('referral_id');
				// })
				// where(["order_status"=>1])->groupBy('user_id')->get();
				// dd($subs);
			return view($this->getView('pages.plasama'),['plasama'=>$plasama]);
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
	}
	public function donatePlasma(Request $request) {

		try{
		if ($request->isMethod('post')) {
			$data = $request->all();
			$validator = Validator::make($data, [
				'blood_group' => 'required',
				'name' => 'required',
				'mobile' => 'required|min:10',
				'state' => 'required',
				'city' => 'required',
				// 'message' => 'required',
			]);
			if($validator->fails()){
				$errors = $validator->errors();
				return redirect('donate-plasma')->withErrors($validator)->withInput();
			}
			else {
				$registration =  DonatePlasma::create([
				 'blood_group' => $data['blood_group'],
				 'name' => $data['name'],
				 'mobile' => $data['mobile'],
				 'state' => $data['state'],
				 'city' => $data['city'],
				 // 'message' => $data['message'],
				]);
				Session::flash('message', "Thanks For Your Interest! We will contact soon");
			}
		 }
		return view($this->getView('pages.donate-plasma'));

		}catch(Exception $e){

			return $e->getMessage();

		}
	}
	public function covidTesting(Request $request) {

		try{

		if ($request->isMethod('post')) {
		$params = array();
		 if (!empty($request->input('state'))) {
             $params['state'] = base64_encode($request->input('state'));
         }
		 if (!empty($request->input('city'))) {
             $params['city'] = base64_encode($request->input('city'));
         }
         return redirect()->route('covidTesting',$params)->withInput();
		}
		else{
			$query = covidTesting::where('status',1);
			if(!empty($request->input('state'))) {
				$state = base64_decode($request->input('state'));
				$query->where('state',$state);
			}
			if(!empty($request->input('city'))) {
				$city = base64_decode($request->input('city'));
				$query->where('city',$city);
			}
			$testings = $query->get();
			return view($this->getView('pages.covid-testing'),['testings'=>$testings]);
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
	}
	public function getCityListByName(Request $request) {

		try{
		$id = $request->input('id');
		$cities = OxygenSuppliers::select("city")->where('state',$id)->groupBy("city")->get();
		return $cities;
		}catch(Exception $e){

			return $e->getMessage();

		}
	}

	public function oxygenAvailablity(Request $request) {

		try{
		if ($request->isMethod('post')) {
		$params = array();
		 if (!empty($request->input('state'))) {
             $params['state'] = base64_encode($request->input('state'));
         }
		 if (!empty($request->input('city'))) {
             $params['city'] = base64_encode($request->input('city'));
         }
         return redirect()->route('oxygenAvailablity',$params)->withInput();
		}
		else{
			$query = OxygenSuppliers::where('status',1);
			$cityData = OxygenSuppliers::select("city");
			if(!empty($request->input('state'))) {
				$state = base64_decode($request->input('state'));
				$query->where('state',$state);
				$cityData->where('state',$state);
			}
			if(!empty($request->input('city'))) {
				$city = base64_decode($request->input('city'));
				$query->where('city',$city);
			}
			$oxygen = $query->get();
			$states = OxygenSuppliers::select("state")->groupBy("state")->get();
			$cities = $cityData->groupBy("city")->get();
			return view($this->getView('pages.oxygen-availablity'),['oxygen'=>$oxygen,'states'=>$states,'cities'=>$cities]);
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
	}
		public function vaccinationDrive(Request $request) {

			try{
			return abort(404);
			if ($request->isMethod('post')) {
				$data = $request->all();


				$validatedData = Validator::make($data, [
					'name' => 'required|max:50',
					'mobile_no' => 'required|min:10',
					'dose_type' => 'required',
					'persons' => 'required',
					'address' => 'required||max:255'
				]);
				if($validatedData->fails()){
						$errors = $validatedData->errors();
						return array('status' => 0, 'error' => $errors);
				}
				else {
					$registration =  VaccinationDrive::create([
					 'name' => $data['name'],
					 'mobile_no' => $data['mobile_no'],
					 'dose_type' => $data['dose_type'],
					 'persons' => $data['persons'],
					 'preferred_date' => date("Y-m-d", strtotime($data['preferred_date'])),
					 'address' => $data['address']
					]);

					if (!empty($data['mobile_no'])) {
						$mobile_no = trim($data['mobile_no']);
						$message = urlencode("Your request for Vaccination has been registered successfully. One of our team members will call you for date and time. For any questions please call 9414430699. Thanks. Team Health Gennie.");
						$this->sendSMS($mobile_no,$message,'1707162702747842759');
					}
					saveUserActivity($request, 'VaccinationDrive', 'vaccination_drive', @$registration->id);
					return 1;

				}
		 }
			 // return view('pages.au-marathon-registration');
	 	 return view($this->getView('pages.vaccination-drive'));

		}catch(Exception $e){

			return $e->getMessage();
	
		}
	}
	public function runnersLead(Request $request) {

		try{
			if ($request->isMethod('post')) {
				$data = $request->all();
				$validatedData = Validator::make($data, [
					'name' => 'required|max:50',
					'mobile_no' => 'required|min:10',
					'address' => 'required',
					'app_download' => 'required',
					'appointment' => 'required',
					'plan_sold' => 'required',
					'created_by' => 'required'
				]);
				if($validatedData->fails()){
						$errors = $validatedData->errors();
						return array('status' => 0, 'error' => $errors);
				}
				else {
					$registration =  RunnersLead::create([
					 'name' => $data['name'],
					 'mobile_no' => $data['mobile_no'],
					 'address' => $data['address'],
					 'app_download' => $data['app_download'],
					 'appointment' => $data['appointment'],
					 'plan_sold' => $data['plan_sold'],
					 'created_by' => $data['created_by']
					]);
					saveUserActivity($request, 'RunnersLead', 'runner', @$registration->id);
					$count = RunnersLead::where('created_by',$data['created_by'])->count();
					return $count;

				}
		 	}
			$sales = SalesTeam::all();
			 // return view('pages.au-marathon-registration');
		 return view($this->getView('pages.runners-lead'),['sales'=>$sales]);

		}catch(Exception $e){

			return $e->getMessage();
	
		}
	}
	public function partners(Request $request) {

		try{
		return view($this->getView('pages.partners'));

		}catch(Exception $e){

			return $e->getMessage();

		}
	}
	public function corporate(Request $request) {

		try{
		if ($request->isMethod('post')) {
			$data = $request->all();
			$validator = Validator::make($data, [
				'name' => 'required',
				'mobile' => 'required|min:10',
				'org_name' => 'required',
				'org_size' => 'required',
			]);
			if($validator->fails()){
				$errors = $validator->errors();
				return redirect('corporate')->withErrors($validator)->withInput();
			}
			else {
				$qry_from = 2;
				if(!empty($data['qry_from'])){
					if(strpos($data['qry_from'], '?home') !== false){
						$qry_from = 1;
					}
				}
				Corporate::create([
				 'name' => $data['name'],
				 'mobile' => $data['mobile'],
				 'email' => $data['email'],
				 'org_name' => $data['org_name'],
				 'org_size' => $data['org_size'],
				 'qry_from' => $qry_from,
				]);
				Session::flash('message', "Thanks For Your Interest! We will contact soon");
			}
		 }
		return view($this->getView('pages.corporate'));

	}catch(Exception $e){

		return $e->getMessage();

	}
	}

	public function patientFeedback(Request $request) {

		$RandId=$request->id;
		return view('pages.patient_feedback_for_doctor',compact('RandId'));
		
    }

	public function patientFeedbacksave(Request $request) {
     
		    $data = $request->all();
		  
			$this->validate($request,[
				'recommendation' => 'required',
				'waiting_time' => 'required',
				'visit_type' => 'required',
				'suggestions' => 'required',
				'rating' => 'required',
				'experience' => 'required',
				'randomid'=>'required'
			 ]);
			
			PatientFeedback::where('random_no', $request->randomid)->update(array(
				'recommendation' => $request->recommendation,
				'waiting_time' => $request->waiting_time,
				'visit_type' => $request->visit_type,
				'suggestions' => json_encode($request->suggestions,JSON_FORCE_OBJECT),
				'rating' => $request->rating,
				'experience' => $request->experience,
				'publish_status'=>$request->publish_status,
				'delete_status'=>1,
				'resource'=>1
			));

			Session::flash('message', "Thanks For Your Feedback");
			return redirect()->back();
	

    }
}