<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\ehr\Appointments;
use App\Models\ehr\RoleUser;
use App\Models\ehr\PracticeDetails;
use App\Models\ehr\EmailTemplate;
use App\Models\UserPrescription;
use App\Models\ehr\Patients;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Plans;
use App\Models\UserDetails;
use App\Models\ehr\ChiefComplaints;
use App\Models\ehr\PatientDiagnosis;
use App\Models\ehr\PatientMedications;
use App\Models\ehr\PatientEyes;
use App\Models\ehr\PatientLabs;
use App\Models\ehr\PatientDiagnosticImagings;
use App\Models\ehr\PatientProcedures;
use App\Models\ehr\PatientAllergy;
use App\Models\ehr\PatientDentals;
use App\Models\ehr\PatientExaminations;
use App\Models\ehr\PatientVitalss;
use App\Models\ehr\FollowUp;
use App\Models\ehr\PatientImmunizations;
use App\Models\ehr\PatientReferrals;
use App\Models\ehr\clinicalNotePermissions;

use App\Models\ehr\Nutritionalinfo;
use App\Models\ehr\DietPlan;
use App\Models\ehr\MealPlanMaster;
use App\Models\ehr\PatientPhysicalExcercise;
use App\Models\ehr\DietitianReportTemplate;
use App\Models\ehr\PatientDietitianTemplate;
use App\Models\ehr\PatientDietPlanFile;
use App\Models\UsersOTP;
use Validator;
use DB;
use URL;
use Mail;
use Auth;
use File;
use PDF;
use Storage;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class UserController extends Controller {

	public function __construct()
    {
        $this->middleware('auth');
    }
	public function uploadUserFileBy($fileName,$old_image = null) {

		try{

		@file_get_contents(getEhrUrl()."/patientFileWriteByUrl?fileName=".$fileName."&old_profile_pic=".$old_image);
		if(isset($old_image) && !empty($old_image)) {
			$oldFilename = public_path()."/patientPics/".$old_image;
			if(file_exists($oldFilename)) {
			   File::delete($oldFilename);
			}
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
    }
    public function profile(Request $request) {

		try{

		if($request->isMethod('post')) {
			$data = $request->all(); //pr($data);

			$validator = Validator::make($data, [
			  'full_name'   => 'required|max:50',
			 // 'last_name'   => 'required|max:50',
			  'dob'   => 'required||max:200',
			  'gender'   => 'required|max:50',
			  'country_id'   => 'required|max:50',
			  'state_id'   => 'required|max:50',
			  'city_id'   => 'required|max:50',
			  'gender'   => 'required|max:50',
			  // 'aadhar_no'   => 'max:12|min:12',
			  'email' => 'required|email|max:255',
			  'mobile_no' => 'required|numeric',
			]);
			if($validator->fails()) {
				$errors = $validator->errors();
				return redirect('user-profile')->withErrors($validator)->withInput();
			}
			else {
				$user = User::where('id', $data['id'])->first();
				$old_number = $user->mobile_no;
				$old_email = $user->email;
				$errors = [];
				if($old_email != $data['email']) {
					$email_exists = User::where('email', 'like', '%'.$data['email'].'%')->count();
					if($email_exists > 0){
						$errors["email"] = ['Email already exist.'];
					}
				}
				if($old_number != $data['mobile_no']) {
					$no_exists = User::where(['mobile_no'=>trim($data['mobile_no'])])->count();
					if($no_exists > 0) {
						$errors["mobile_no"] = ['Mobile Number already exist.'];
					}
				}
				if(count($errors) > 0){
					return redirect('user-profile')->withErrors($errors)->withInput();
				}
				$fileName = null;
				$old_profile_pic = $data['old_profile_pic'];
				if(isset($data['image']) && $request->hasFile('image')) {
					  $image  = $request->file('image');
					  $fullName = str_replace(" ","",$image->getClientOriginalName());
					  $onlyName = explode('.',$fullName);
					  if(is_array($onlyName)) {
						$fileName = $onlyName[0].time().".".$onlyName[1];
					  }
					  else{
						$fileName = $onlyName.time();
					  }
					  Storage::disk('s3')->put("public/patients_pics/".$fileName,file_get_contents($image),'public');
					  // $request->file('image')->move('public/patients_pics', $fileName);
					   // $this->uploadUserFileBy($fileName,$old_profile_pic);
				}
				else if(empty($request->hasFile('image')) && !empty($data['profile_image_cam'])) {
						$imgdata = base64_decode($data['profile_image_cam']);
						$image_name =  time() . '.png';
						$file = "public/patients_pics/".$image_name;
						// file_put_contents($file,$imgdata);
						Storage::disk('s3')->put($file,$imgdata,'public');
						$fileName = $image_name;
						unset($data['profile_image_cam']);
						if(isset($data['old_profile_pic']) && !empty($data['old_profile_pic'])){
						$oldFilename = "public/patients_pics/".$data['old_profile_pic'];
						// if(file_exists($oldFilename)){
						   // File::delete($oldFilename);
						// }
						if(Storage::disk('s3')->exists($oldFilename)) {
						   Storage::disk('s3')->delete($oldFilename);
						}
					  }
					   // $this->uploadUserFileBy($fileName,$old_profile_pic);
				}
				else{
					$fileName = isset($data['old_profile_pic']) ? $data['old_profile_pic'] : null;
				}
				$first_name = trim(strtok($data['full_name'], ' '));
				$last_name = trim(strstr($data['full_name'], ' '));
				User::where('id', $data['id'])->update(array(
					  'first_name' => ucfirst($first_name),
					  'last_name' => $last_name,
					  'address' => $data['address'],
					  'email' => $data['email'],
					  'gender' => $data['gender'],
					 // 'organization' => $data['organization'],
					 // 'aadhar_no' => $data['aadhar_no'],
					  'dob' => (isset($data['dob']) ? strtotime($data['dob']) : null),
					  //'locality_id' => $data['locality_id'],
					  'city_id' => $data['city_id'],
					  'state_id' => $data['state_id'],
					  'country_id' => $data['country_id'],
					  'zipcode' => $data['zipcode'],
					 // 'content' => $data['content'],
					  'image' => $fileName,
					  'profile_status' => 1,
				));

				if(!empty($user->patient_number)) {
					Patients::where('patient_number', $user->patient_number)->update(array(
					  'first_name' => ucfirst($first_name),
					  'last_name' => $last_name,
					  'address' => $data['address'],
					  'email' => $data['email'],
					  'gender' => $data['gender'],
					  //'aadhar_no' => $data['aadhar_no'],
					  'dob' => (isset($data['dob']) ? strtotime($data['dob']) : null),
					  'city_id' => $data['city_id'],
					  'state_id' => $data['state_id'],
					  'country_id' => $data['country_id'],
					  'zipcode' => $data['zipcode'],
					  'image' => $fileName,
					));
				}
				Session::forget('profile_status');
				Session::flash('message', "Your profile updated successfully");

				if($old_number != $data['mobile_no']) {
					$otp = rand(100000,999999);
					UsersOTP::where(['mobile_no'=>$data['mobile_no']])->orWhere('user_id',$user->id)->delete();
					$currentDate = date('Y-m-d H:i:s');
					$expiry_date = date('Y-m-d H:i:s', strtotime('+1 minutes', strtotime($currentDate)));
					UsersOTP::create([
						 'user_id' =>  $user->id,
						 'mobile_no' =>  $data['mobile_no'],
						 'expiry_date' =>  $expiry_date,
						 'otp' =>  $otp
					]);
					if(!empty($data['mobile_no'])) {
						$app_link = "www.healthgennie.com/download";
						$message =  urlencode("Your Health Gennie OTP is ".$otp."\nThis otp is valid for 60 seconds Thanks Team Health Gennie");
					    $this->sendSMS($data['mobile_no'],$message,'1707161735200778103');
					}
					$mobile_no = $data['mobile_no'];
					return view($this->getView('users.user-otp'),['mobile_no'=>$mobile_no]);
				}

				//login from cart
				  // if(Session::get('loginFrom') == '1') {
					// Session::forget('loginFrom');
					// return redirect()->route('LabCart');
				  // }
				  //login from Medicines
				// elseif (Session::get('loginFrom') == '2') {
					// Session::forget('loginFrom');
					// return redirect()->route('oneMgOpen');
				// }
				if (Session::get('loginFrom') == '3') {
					Session::forget('loginFrom');
					$appData = Session::get('appDoctorData');
					Session::forget('appDoctorData');
					return redirect()->route('doctor.bookSlot',$appData)->withInput();
				}
				else{
					return redirect()->route('home');
				}
			}
		}
		// $id = base64_decode($request->id);
		$id = Auth::id();
		$user = User::where('id', $id)->first();
		if(!empty($user->image)) {
			$image_url = getPath("public/patients_pics/".$user->image);
			$user['image_url'] = $image_url;
		}
		else{
			$user['image_url'] = null;
		}
		if(!empty($user->country_id)){
		  $country_id = $user->country_id;
		  $state_id   = $user->state_id;
		}else{
		  $country_id = '101';
		  $state_id   = '32';
		}
		if(!empty($user->city_id)){
			$city_id = $user->city_id;
		}
		else{
			$city_id = '3378';
		}
		$user->first_name = trim(@$user->first_name." ".@$user->last_name);
		$stateList =  parent::getUpdateStateList($country_id);
		$cityList =  parent::getUpdateCityList($state_id);
		$localityList =  parent::getUpdateLocalityList($city_id);
		return view($this->getView('users.edit-user'),['user'=>$user,'stateList'=>$stateList,'cityList'=>$cityList,'localityList'=>$localityList]);

		}catch(Exception $e){

			return $e->getMessage();

		}
    }

	public function changePassword(Request $request) {

		try{
		if($request->isMethod('post')) {
			$data = $request->all();
			User::where('id', $data['id'])->update(array(
				'password' => Hash::make($data['password']),
			));
			Session::flash('message', "Your password has been changed successfully!");
			return redirect()->route('drive');
		}
		else{
			$id = base64_decode($request->id);
			return view($this->getView('users.password-change'),['id'=>$id]);
		}
		}catch(Exception $e){

			return $e->getMessage();

		}

	}


	public function forgotEmail(Request $request) {
		try{
       if ($request->isMethod('post')) {
			$data = $request->all();
            $user =  User::where('email', $data['email'])->where('parent_id',0)->first();
		   if(!empty($user)) {
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
					catch(\Exception $e)
				   {
					  // Never reached
				   }
					User::where('id',$user->id)->update(['password'=>bcrypt($password)]);
					Session::flash('status', "We have e-mailed your password!");
					return redirect()->back();
				}
		   }
		   else{
			   $errors = ['email' => 'user does not exist'];
			   return redirect()->back()->withErrors($errors);
		   }
        }

		}catch(Exception $e){

			return $e->getMessage();

		}

    }

	public function uploadPriscription(Request $request) {

		try{
		if($request->isMethod('post')) {
			$data = $request->all();
			$fileName = null;
			if(!empty($data['prescription_imageBlob'])) {
				$imgdata = base64_decode($data['prescription_imageBlob']);
				$fileName =  time() . '.png';
				$file = public_path().'/prescription-files/'.$fileName;
				file_put_contents($file,$imgdata);
				unset($data['prescription_imageBlob']);
			}
			else{
				$images = $request->file('prescription');
				$fileName = str_replace(" ","",$images->getClientOriginalName());
				$filepath = public_path().'/prescription-files/';
				$request->file('prescription')->move($filepath, $fileName);
				// $this->compress($fileName, $filepath);
			}

			$userss = \Auth::user();
			$pres = UserPrescription::create([
			  'user_id' =>   $userss->id,
			  'pId' =>   $userss->pId,
			  'patient_number' =>  @$userss->patient_number,
			  'aptTime' =>  $data['aptTime'],
			  'aptDate' =>  $data['aptDate'],
			  'doc_name' =>  $data['doc_name'],
			  //'record_for' =>  $data['record_for'],
			  //'record_type' =>  $data['record_type'],
			  'prescription' =>  $fileName,
			  'status' =>  1
			]);
			Session::flash('message', "Your prescription has been uploaded successfully!");
			// return redirect()->route('myPriscription');
			return 1;
		}
		else{
			return 2;
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
	}

	public function deletePriscription(Request $request) {
		
		try{

		if($request->isMethod('post')) {
			$data = $request->all();
			$prescription =  UserPrescription::where("id",$data['id'])->first();
			$pfile = public_path()."/prescription-files/".$prescription->prescription;
			if(file_exists($pfile)){
			   File::delete($pfile);
			}
			// if(Storage::disk('s3')->exists($pfile)) {
			   // Storage::disk('s3')->delete($pfile);
			// }
			UserPrescription::where("id",$data['id'])->delete();
			Session::flash('message', "Your prescription has been deleted successfully!");
			return 1;
		}

		}catch(Exception $e){

			return $e->getMessage();

		}

	}

	public function sharePrescription(Request $request) {
		try{
		if($request->isMethod('post')) {
			$data = $request->all();
				$prescription =  UserPrescription::select(["prescription","user_id","patient_number","type"])->where("id",$data['id'])->first();
				$user = User::select(["first_name","last_name"])->where('id', $prescription->user_id)->first();
				$name = $data['name'];
				$dataSrc = ""; $username = "";
				if($prescription->type == "1") {
					if(!empty($prescription->prescription)) {
						$this->writeClinicNoteFile($prescription->patient_number,$prescription->prescription);
					}
					$dataSrc = getPath("uploads/PatientDocuments/".$prescription->patient_number."/misc/clinicalNotePrint.pdf");
				}
				else {
					$dataSrc = url("/").'/public/prescription-files/'.$prescription->prescription;
				}
				if(!empty($user)) {
					$username = ucfirst($user->first_name)." ".$user->last_name;
				}
				if(!empty($data['mobile'])) {
					$app_link = "www.healthgennie.com/download";
					$message = urlencode("Dear ".$name.", Please check your email you have received an prescription file from ".$username.", For Better Experience Download Health Gennie App".$app_link." Thanks Team Health Gennie");
					$this->sendSMS($data['mobile'],$message,'1707161735192013804');
				}
				if(!empty($data['email'])) {
					$to = $data['email'];
					$phone = "+91-8302072136";
					$EmailTemplate = EmailTemplate::where('slug','prescriptionfileshared')->first();
					if($EmailTemplate) {
						$body = $EmailTemplate->description;
						$mailMessage = str_replace(array('{{name}}','{{username}}','{{phone}}'),array($name,$username,$phone),$body);
						$datas = array('to' =>$to,'from' => 'info@healthgennie.com','mailTitle'=>$EmailTemplate->title,'content'=>$mailMessage,'subject'=>$EmailTemplate->subject,'dataSrc'=>$dataSrc);
						try{
						Mail::send('emails.all', $datas, function( $message ) use ($datas) {
						   $message->to( $datas['to'] )->from( $datas['from'])->subject($datas['subject']);
						   if(!empty($datas['dataSrc'])){$message->attach($datas['dataSrc']);}
						});
						}
						catch(\Exception $e)
						   {
							  // Never reached
						   }
					}
				}
			Session::flash('message', "Your prescription has been shared successfully!");
			return 1;
		}

		}catch(Exception $e){

			return $e->getMessage();

		}

	}

	public function compress($source, $destination) {
		try{
		$info = getimagesize($destination."/".$source);
		if ($info['mime'] == 'image/jpeg')
			$image = imagecreatefromjpeg($destination."/".$source);
		elseif ($info['mime'] == 'image/png')
			$image = imagecreatefrompng($destination."/".$source);
		else return $destination;
		imagejpeg($image, $destination."/".$source, 50);
		return $destination;
		}catch(Exception $e){

			return $e->getMessage();

		}
	}

	public function myPriscription(Request $request) {

		try{

		$userss = \Auth::user();
		if(!empty($userss) && $userss != null) {
			$user_id = $userss->id;
			$patient_number = $userss->patient_number;
			$user = array();
			$user = UserPrescription::where(['user_id'=>$user_id,'delete_status'=>1])->orderBy('created_at','desc')->paginate(10);
			if(count($user)>0) {
				foreach($user as $val) {
					if($val->type == "1") {
						$val["file_type"] = "pdf";
						$pdf_url = 	getPath("uploads/PatientDocuments/".$val->patient_number."/misc/clinicalNotePrint.pdf");
						$val['prescription'] = $pdf_url;

					}
					else {
						$val["file_type"] = @explode(".",$val->prescription)[1];
						if(!empty($val->prescription)) {
							$image_url = url("/").'/public/prescription-files/'.$val->prescription;
							if(does_url_exists($image_url)) {
								$val['prescription'] = $image_url;
							}
							else{
								$val['prescription'] = null;
							}
						}
						else{
							$val['prescription'] = null;
						}
					}
				}
			}
			return view($this->getView('users.prescriptions'),['user'=>$user]);
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
	}

	public function arraySort($a,$b) {
		try{
		return strtotime($b->created_at) - strtotime($a->created_at);
		}catch(Exception $e){

			return $e->getMessage();

		}
	}
	public function writeClinicNoteFile($patient_number,$prescription) {
		try{
		$docPath = 'uploads/PatientDocuments/'.$patient_number.'/misc/';
		if(!Storage::disk('s3')->exists($docPath)) {
			Storage::disk('s3')->makeDirectory($docPath);
		}
		$output = PDF::loadHTML($prescription)->output();
		Storage::disk('s3')->put($docPath.'clinicalNotePrint.pdf', $output,'public');
		// if(!is_dir($docPath)){
			 // File::makeDirectory($docPath, $mode = 0777, true, true);
		// }
		// if(!file_exists($docPath.'clinicalNotePrint.pdf')) {
			// File::copy(public_path().'/htmltopdfview.pdf', $docPath.'clinicalNotePrint.pdf');
			// File::makeDirectory($docPath.'clinicalNotePrint.pdf', $mode = 0777, true, true);
		// }
		// file_put_contents(public_path()."/PatientDocuments/".$patient_number."/misc/clinicalNotePrint.pdf", $output);
		}catch(Exception $e){

			return $e->getMessage();

		}
	}
	public function getNotePrintOfWebOld(Request $request) {

		try{
		if ($request->isMethod('post')) {
			$data = $request->all();
			$presDta = UserPrescription::select(["prescription","patient_number"])->where(['id'=>$data['app_id']])->first();
			if(!empty($presDta->prescription)){
				$this->writeClinicNoteFile($presDta->patient_number,$presDta->prescription);
				return 1;
			}
			return 2;
		}
		}catch(Exception $e){

			return $e->getMessage();

		}

	}

	public function getNotePrintOfWeb(Request $request) {
		try{
		if ($request->isMethod('post')) {
			$data = $request->all();
			$res = $this->getClinicalNoteByApp($data['appointment_id'])["url"];
			if(!empty($res)){
				return 1;
			}
			else{
				return 2;
			}
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
	}
	public function getClinicalNoteByApp($app_id) {

		try{
		$presDta = UserPrescription::select(["type","prescription","patient_number"])->where(['appointment_id'=>$app_id])->orderBy("id","ASC")->first();
		$preUrl = null;
		$type = null;
		if(!empty($presDta->prescription)) {
			$type = $presDta->type;
			if($presDta->type == "1"){
				$this->writeClinicNoteFile($presDta->patient_number,$presDta->prescription);
				$preUrl = getPath("uploads/PatientDocuments/".$presDta->patient_number."/misc/clinicalNotePrint.pdf");
			}
			else{
				$image_url = url("/").'/public/prescription-files/'.$presDta->prescription;
				if(does_url_exists($image_url)) {
					$preUrl = $image_url;
				}
			}
		}
		return ['url'=>$preUrl,'type'=>$type];

		}catch(Exception $e){

			return $e->getMessage();

		}

	}

	public function getClinicNoteData($user_array) {
		 try{
		$patient =  Appointments::with(['Patient.PatientRagistrationNumbers'])->where(['id'=>$user_array['appointment_id'],'delete_status'=>1])->first();
		if(!empty($patient)) {
			$chiefComplaints = []; $treatments = []; $labs = [];  $pAllergies = []; $procedures = []; $pDiagnos = []; $pVitals = [];$immunizations = []; $examinations = []; $dentals = []; $eyes = []; $proce_order = [];  $patientDiagnosticImagings = []; $pReferral = []; $nutritional_info = []; $physical_excercise = []; $dietitian_template = []; $diet_plan = [];
			$chart_height = ""; $chart = "";
			$practice =  RoleUser::select(['user_id','role_id','practice_id'])->where(['user_id'=>$user_array['doc_id']])->first();
			$practice_detail =  PracticeDetails::with('PrintSettings')->where(['user_id'=>$practice->practice_id])->first();

			$clinical_note_permission = clinicalNotePermissions::where(['user_id'=>$user_array['doc_id'],'practice_id' => $practice->practice_id])->first();
			$permission = explode(',', $clinical_note_permission->modules_access);

			$rows = ['chief'=>'0','diagnosis'=>'0','treatment'=>'0','labOrder'=>'0','di'=>'0','Procedures'=>'0','allergies'=>'0','vitals'=>'0','immunization'=>'0','exam'=>'0','pOrder'=>'0','referral'=>'0','dental'=>'0','followUp'=>'1','eyes'=>'0','pchart'=>'0','nutritional_info'=>'0','diet_plan'=>'0','physical_excercise'=>'0','dietitian_template'=>'0'];
			if(in_array('1',$permission)) {
				$chiefComplaints =  ChiefComplaints::where(['appointment_id'=>$user_array['appointment_id']])->first();
				$rows['chief'] = '1';
			}

			if(in_array('2',$permission)) {
				$pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->get();
				$rows['diagnosis'] = '1';
			}
			if(in_array('4',$permission)) {
				$treatments =  PatientMedications::with(['ItemDetails.ItemType'])->where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->get();
				$rows['treatment'] = '1';
			}
			if(in_array('5',$permission)) {
				$eyes = PatientEyes::where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->first();
				$rows['eyes'] = '1';
			}
			if(in_array('6',$permission)) {
				$labs =  PatientLabs::with(['Labs'])->where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->get();
				$rows['labOrder'] = '1';
			}
			if(in_array('7',$permission)) {
				$patientDiagnosticImagings =  PatientDiagnosticImagings::with(['RadiologyMaster'])->where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->get();
				$rows['di'] = '1';
			}
			if(in_array('8',$permission)) {
				$procedures = PatientProcedures::with(['Procedures'])->where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->where(function ($query) {
					$query->where('order_date', '=', date("Y-m-d"))
						->orWhereNull('order_date');
					})->get();
				$rows['Procedures'] = '1';
			}
			if(in_array('9',$permission)) {
				$pAllergies= PatientAllergy::with(['Allergies'])->where(['appointment_id'=>$user_array['appointment_id'],'patient_id'=>$patient->pId,'delete_status'=>1])->get();
				$rows['allergies'] = '1';
			}
			if(in_array('10',$permission)) {
				$dentals = PatientDentals::where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->get();
				$rows['dental'] = '1';
			}

			if(in_array('12',$permission)) {
				$examinations = PatientExaminations::with(['BodySites'])->where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->get();
				$rows['exam'] = '1';
			}
			if(in_array('13',$permission)) {
				$pVitals = PatientVitalss::where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->first();
				$rows['vitals'] = '1';
			}
			if(in_array('14',$permission)) {
				$immunizations = PatientImmunizations::with(['Immunizations'])->where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->get();
				$rows['immunization'] = '1';
			}
			if(in_array('15',$permission)) {
				$proce_order = PatientProcedures::with(['Procedures'])->where(['appointment_id'=>$user_array['appointment_id'],'procedure_type'=>'order','status'=>0,'delete_status'=>1])->get();
				$rows['pOrder'] = '1';
			}
			if(in_array('16',$permission)) {
				$pReferral = PatientReferrals::where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->first();
				$rows['referral'] = '1';
			}

			//new modules
			if(in_array('21',$permission)) {
				$nutritional_info = Nutritionalinfo::where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->first();
				$rows['nutritional_info'] = '1';
			}
			if(in_array('18',$permission)) {
				$diet_plan = DietPlan::with('MealPlanMaster')->where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->get();
				$rows['diet_plan'] = '1';
			}
			if(in_array('19',$permission)) {
				$physical_excercise = PatientPhysicalExcercise::with("PhysicalExcerciseMaster")->where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->get();
				$rows['physical_excercise'] = '1';
			}

			if(in_array('20',$permission)) {
				$dietitian_template = PatientDietitianTemplate::with("DietitianReportTemplate")->where(['appointment_id'=>$user_array['appointment_id'],'delete_status'=>1])->get();
				$rows['dietitian_template'] = '1';
			}
			$followUp = FollowUp::where('appointment_id',$user_array['appointment_id'])->where(['added_by'=>$practice->practice_id])->first();

			$chart = "";
			$chart_height = "";
			if(in_array('17',$permission)) {
				if(Storage::disk('s3')->exists('uploads/PatientDocuments/'.$patient->Patient->patient_number.'/misc/growthchart.png')) {
					$chart = getPath('uploads/PatientDocuments/'.$patient->Patient->patient_number.'/misc/growthchart.png');
				}
				if(get_age($patient->Patient->dob) <= 5) {
					if(Storage::disk('s3')->exists('uploads/PatientDocuments/'.$patient->Patient->patient_number.'/misc/growthchartHeight.png')) {
						$chart_height = getPath('uploads/PatientDocuments/'.$patient->Patient->patient_number.'/misc/growthchartHeight.png');
					}
				}
				$rows['pchart'] = '1';
			}
			$docPath = 'uploads/PatientDocuments/'.$patient->Patient->patient_number.'/misc/';
			// if(!is_dir($docPath)){
				 // File::makeDirectory($docPath, $mode = 0777, true, true);
			// }
			if(!Storage::disk('s3')->exists($docPath)) {
				Storage::disk('s3')->makeDirectory($docPath);
			}
			// if(!file_exists($docPath.'clinicalNotePrint.pdf')) {
				// File::copy(public_path().'/htmltopdfview.pdf', $docPath.'clinicalNotePrint.pdf');
				// File::makeDirectory($docPath.'clinicalNotePrint.pdf', $mode = 0777, true, true);
			// }
			$html = view('ehr_print.clinical_note_print',compact('chart','chart_height','patient','chiefComplaints','labs','pAllergies','procedures','pDiagnos','pVitals','immunizations','examinations','proce_order','treatments','patientDiagnosticImagings','practice_detail','rows','pReferral','dentals','followUp','eyes','nutritional_info','diet_plan','physical_excercise','dietitian_template'))->render();
			$output = PDF::loadHTML($html)->output();
			Storage::disk('s3')->put($docPath.'clinicalNotePrint.pdf', $output,'public');
			// file_put_contents(public_path()."/PatientDocuments/".$patient->Patient->patient_number."/misc/clinicalNotePrint.pdf", $output);
			// $pdf_url = 	url("/")."/public/PatientDocuments/".$patient->Patient->patient_number."/misc/clinicalNotePrint.pdf";
			return getPath($docPath.'clinicalNotePrint.pdf');
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
	}

	public function sendEditUserOtp(Request $request) {
		try{
		if(!empty($request->user_id)){
			$this->sendOTP($request->user_id,$request->mobile_no);
			return 1;
		}
		else{
			return false;
		}
		}catch(Exception $e){

			return $e->getMessage();

		}
	}

	public function sendOTP($id,$mobile_no = null) {
		
		try{
		$otp = rand(100000,999999);
		$currentDate = date('Y-m-d H:i:s');
		$expiry_date = date('Y-m-d H:i:s', strtotime('+1 minutes', strtotime($currentDate)));
		UsersOTP::where('user_id',$id)->update(['otp'=>$otp,'expiry_date' =>  $expiry_date]);
		$user = UsersOTP::where('user_id',$id)->first();
		if(!empty($mobile_no)) {
			$app_link = "www.healthgennie.com/download";
			$message =  urlencode("Your Health Gennie OTP is ".$otp."\nThis otp is valid for 60 seconds Thanks Team Health Gennie");
		   //$app_link = "https://www.healthgennie.com/download";
		   //$message =  urlencode("Your Health Gennie OTP is ".$otp.".\nThis otp is valid for 60 seconds.\nFor Better Experience Download Health Gennie App\n".$app_link);
		   $this->sendSMS($mobile_no,$message,'1707161735200778103');
		}
		return $user->id;

		}catch(Exception $e){

			return $e->getMessage();

		}
	}


	public function confirmUserOtp(Request $request) {

		try{

		if ($request->isMethod('post')) {
			$data = $request->all();
			$userOTP = UsersOTP::where('user_id', $request->get('user_id'))->first();
			$currentDate = date('Y-m-d H:i:s');
			$expiry_date = date('Y-m-d H:i:s', strtotime('+1 minutes', strtotime($currentDate)));
			if($data['otp'] == $userOTP->otp) {
				if($currentDate <= $userOTP->expiry_date) {
					$user = User::select('mobile_no')->where('id', $request->get('user_id'))->first();
					if(!empty($data['mobile_no'])) {
						Patients::where('mobile_no', $user->mobile_no)->update(array(
							'mobile_no' =>  trim($data['mobile_no']),
						));
						User::where('mobile_no', $user->mobile_no)->update(array(
							'mobile_no' =>  trim($data['mobile_no']),
						));
					   $app_link = "www.healthgennie.com/download";
					   $message =  urlencode("Your Mobile number has been successfully changed. For Better Experience Download Health Gennie App ".$app_link." Thanks Team Health Gennie");
					   $this->sendSMS($data['mobile_no'],$message,'1707161588049388015');
					}
					Session::forget('profile_status');
					Session::flash('message', "Your profile updated successfully");
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

		}catch(Exception $e){

			return $e->getMessage();

		}
	}
	public function uploadDocument(Request $request) {

		try{
		$data = $request->all();
		if($request->isMethod('post')) {
			$images = $request->file('document');
			if(!empty($data['prescription_imageBlob'])) {	
				$filedata = base64_decode($data['prescription_imageBlob']);
				$fileName =  time() . '.png';
				$filepath = 'uploads/PatientDocuments/'.$data['patient_number'].'/appointments/'.$data['appointment_id'].'/'; 
				Storage::disk('s3')->makeDirectory($filepath);
				Storage::disk('s3')->put($filepath.$fileName, $filedata,'public');
				unset($data['prescription_imageBlob']);
			}
			else{
				$images = $request->file('document');
				$fileName = str_replace(" ","",$images->getClientOriginalName());
				$filepath = 'uploads/PatientDocuments/'.$data['patient_number'].'/appointments/'.$data['appointment_id'].'/'; 
				// if(!is_dir($filepath)){
					// File::makeDirectory($filepath,$mode = 0777, true, true);
				// }
				// $request->file('document')->move($filepath, $fileName);
				Storage::disk('s3')->makeDirectory($filepath);
				Storage::disk('s3')->put($filepath.$fileName,file_get_contents($images),'public');
			}
			Appointments::where('id', $data['appointment_id'])->update(array('is_document_uploaded' => 1));
			return 1;
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
	}

	public function deleteDocument(Request $request) {
		
		try{
		if($request->isMethod('post')) {
			$data = $request->all();
			$filename = 'uploads/PatientDocuments/'.$data['patient_number'].'/appointments/'.$data['appointment_id']."/".$data['document'];
			if(Storage::disk('s3')->exists($filename)) {
			   Storage::disk('s3')->delete($filename);
			}
			return 1;
		}

		}catch(Exception $e){

			return $e->getMessage();

		}
		
	}

	function Applywalletcoupon(Request $request) {
		if($request->isMethod('post')) {
			$data = $request->all();
			$validator = Validator::make($data, [
				'walletCode' => 'required'
			 ]);
			if($validator->fails()) {
				$errors = $validator->errors();
				return $errors->messages()['walletCode'];
			}
		   $query =  UserDetails::select(['id','referral_code','wallet_amount'])->where("referral_code",$data['walletCode'])->first();//
			if($query) {
				$arr = array('status'=>'1','userdetails_id'=>$query->id,'wallet_amount'=>$query->wallet_amount,'referral_code'=>$query->referral_code,'msg'=>'Wallet Code Applied Successfully');
				return $arr;
			}
			else {
				return ['status'=>'0','msg'=>'Wallet Code Not Matched.'];
			}
	   }

   }
}
