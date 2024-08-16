<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use DB;
// use App\Models\Admin\Admin;
use App\Models\User;
use App\Models\ehr\PatientRagistrationNumbers;
use App\Models\ehr\Patients;
use App\Models\ehr\Appointments;
use App\Models\ehr\RoleUser;
use App\Models\ehr\DoctorsInfo;
use App\Models\ehr\User as ehrUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Exports\AppointmentExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ehr\AppointmentOrder;
use App\Models\Doctors;
use App\Models\ehr\EmailTemplate;
use App\Models\PlanPeriods;
use App\Models\UserPrescription;
use Session;
use URL;
use Mail;
use File;
use Route;
use PDF;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
class AppointmentController extends Controller {
    public function hgAppointments(Request $request) {
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
		 if (!empty($request->input('user_id'))) {
             $params['user_id'] = base64_encode($request->input('user_id'));
         }
		 if (!empty($request->input('app_type'))) {
             $params['app_type'] = base64_encode($request->input('app_type'));
         }
		 if (!empty($request->input('type'))) {
             $params['type'] = base64_encode($request->input('type'));
         }
		 if ($request->input('pay_sts') != "") {
             $params['pay_sts'] = base64_encode($request->input('pay_sts'));
         }
		 if ($request->input('app_from') != "") {
             $params['app_from'] = base64_encode($request->input('app_from'));
         }
		 if (!empty($request->input('page_no'))) {
             $params['page_no'] = base64_encode($request->input('page_no'));
         }
		 if (!empty($request->input('file_type'))) {
			 $params['file_type'] = base64_encode($request->input('file_type'));
		 }
		 if ($request->input('pres_type') != "") {
             $params['pres_type'] = base64_encode($request->input('pres_type'));
         }
		 if ($request->input('today_appt') != "") {
             $params['today_appt'] = base64_encode($request->input('today_appt'));
         }
         if ($request->input('date_type') != "") {
            $params['date_type'] = base64_encode($request->input('date_type'));
         }
		 if ($request->input('id') != "") {
            $params['id'] = base64_encode($request->input('id'));
         }
		 if ($request->input('code') != "") {
            $params['code'] = base64_encode($request->input('code'));
         }
		 if ($request->input('appintmentstatus') != "") {
            $params['appintmentstatus'] = base64_encode($request->input('appintmentstatus'));
         }
         return redirect()->route('admin.hgAppointments',$params)->withInput();
		}
		else {
	
			$filters = array();
			$search = base64_decode($request->input('search'));
			$pay_sts = base64_decode($request->input('pay_sts'));
			$app_from = base64_decode($request->input('app_from'));
			$date_type = base64_decode($request->input('date_type'));
			$file_type = base64_decode($request->input('file_type'));
			$status = base64_decode($request->input('appintmentstatus'));
			$pId = base64_decode($request->input('id'));
			$query = Appointments::with(['AppointmentTxn','AppointmentOrder.PlanPeriods','User.DoctorInfo','Patient','NotifyUserSms','Doctors.DoctorData','UserPP.OrganizationMaster','PatientLabs.labs','PatientLabs.LabPack','chiefComplaints','PatientLabsOne'])->whereIn('app_click_status',array(5,6))->where("added_by","!=",24)->where("delete_status",1);
			
			if(!empty($search)) {
				$query->whereHas('Patient', function($que) use($search) {
					$que->where(DB::raw('concat(IFNULL(first_name,"")," ",IFNULL(last_name,"")," ",IFNULL(mobile_no,""))') , 'like', '%'.$search.'%');
				});
			}
			if(!empty($status) && $status=='1') {
				$query->where('working_status','=',NULL);
			}
			if(!empty($status) && $status!='1') {
				$query->where('working_status->status','=',$status);
			}
			if(!empty($pId)){
				$p_ids = User::select("pId")->where(["parent_id"=>$pId])->pluck("pId")->toArray();
				array_push($p_ids,$pId);
				$query->whereIn('pId',$p_ids);
			}
			if(!empty($request->input('today_appt'))) {
				$today_appt = base64_decode($request->input('today_appt'));
				if($today_appt == '1') {
					if(!empty($request->input('start_date')) || !empty($request->input('end_date'))) {
						if(!empty($request->input('start_date'))) {
							$start_date = date('Y-m-d',strtotime(base64_decode($request->input('start_date'))));
							// $query->where(function($q) use($start_date) {
							  // $q->whereRaw('date(created_at) >= ?', [$start_date])
								// ->orWhereRaw('date(start) >= ?', [$start_date]);
							// });
							$query->whereRaw('date(start) >= ?', [$start_date]);
							$query->whereRaw('date(created_at) != ?', [$start_date]);
						}
						if(!empty($request->input('end_date')))	{
							$end_date = date('Y-m-d',strtotime(base64_decode($request->input('end_date'))));
							// $query->where(function($q) use($end_date) {
							  // $q->whereRaw('date(created_at) <= ?', [$end_date])
								// ->orWhereRaw('date(start) <= ?', [$end_date]);
							// });
							$query->whereRaw('date(start) <= ?', [$end_date]);
							$query->whereRaw('date(created_at) != ?', [$end_date]);
						}
					}
				}
				else{
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
				}
			}
			else{
				if(!empty($request->input('start_date')) || !empty($request->input('end_date'))) {
					if(!empty($request->input('start_date'))) {
						$start_date = date('Y-m-d',strtotime(base64_decode($request->input('start_date'))));
            if ($date_type == 2) {
              $query->whereRaw('date(start) >= ?', [$start_date]);
            }else {
              $query->whereRaw('date(created_at) >= ?', [$start_date]);
            }
					}
					if(!empty($request->input('end_date')))	{
						$end_date = date('Y-m-d',strtotime(base64_decode($request->input('end_date'))));
            if ($date_type == 2) {
              $query->whereRaw('date(start) <= ?', [$end_date]);
            }else {
              $query->whereRaw('date(created_at) <= ?', [$end_date]);
            }
					}
				}
			}

			if(!empty($request->input('app_type'))) {
				$app_type = base64_decode($request->input('app_type'));
				if($app_type == 2){
					$query->where(['appointment_confirmation'=>0,'status'=>1]);
				}
				else if($app_type == 3){
					$query->where(['appointment_confirmation'=>1,'status'=>1]);
				}
				else if($app_type == 4){
					$query->where('status',0);
				}
			}
			if(!empty($request->input('pres_type'))) {
				$pres_type = base64_decode($request->input('pres_type'));
				$query->where('visit_status',$pres_type);
			}

			if(!empty($request->input('type'))) {
				$type = base64_decode($request->input('type'));
				if($type == '2'){
					$query->where(['type'=>'3']);
				}
				else if($type == '1'){
					$query->where(['type'=>null]);
				}
				else if($type == '4'){
					$query->where(['visit_type'=>6]);
				}
			}
			if(!empty($request->input('user_id'))) {
				$user_id = base64_decode($request->input('user_id'));
				$query->where('doc_id',$user_id);
			}

		
			// if($request->input('code')  != '') {
				// $code = base64_decode($request->input('code'));
				// if($code == 9) {
					// $query->whereHas('AppointmentOrder', function($q) {
						// $q->where(['hg_miniApp'=>1]);
					// });
				// }
				// elseif($code == 10 ) {
					// $query->whereHas('AppointmentOrder', function($q) {
						// $q->where(['hg_miniApp'=>2]);
					// });
				// }
				// else {
					// $query->whereHas('UserPP', function($que) use($code) {
						// $que->where(['organization'=>$code]);
					// });
				// }
			// }
			$page = 25;
			if(!empty($request->input('page_no'))) {
				$page = base64_decode($request->input('page_no'));
			}
            
			if($file_type == "excel") {
				 $appointmentData = $query->orderBy('id', 'desc')->get();

				//  dd($appointmentData);
				 /****Per month total collection by paid appointments.**/
				 // AppointmentOrder::with(['AppointmentTxn','Appointments'])->where("doc_id","!=",24)->where(['type'=>1,'order_status'=>1])->get();
				 /*****END**********/
				 // $appointmenArray = array();
				 $appointments = [];
				foreach($appointmentData as $i => $element) {
					$appointmentIds = [];
					if(isset($element->AppointmentOrder->PlanPeriods) && count($element->AppointmentOrder->PlanPeriods)>0){
						$appointment_ids = "";
						foreach($element->AppointmentOrder->PlanPeriods as $val){
							$appointment_ids .= $val->appointment_ids.",";
						}
						$appointmentIds = [];
						if(!empty($appointment_ids)){
							$appointmentIds = explode(",",$appointment_ids);
						}
					}
					if($pay_sts == '1') {
						if(!empty($element->AppointmentTxn) && @$element->AppointmentOrder->type == "1"){
							$appointments[] = $element;
						}
						else if(empty($element->AppointmentOrder)) {
							$appointments[] = $element;
						}
					}
					else if($pay_sts == '2') {
						// if(@$element->AppointmentOrder->type == "0" && checkAppointmentIsElite($element->id,@$raw->AppointmentOrder->order_by) == 0) {
						if(@$element->AppointmentOrder->type == "0" && in_array($element->id,$appointmentIds) == false) {
							$appointments[] = $element;
						}
					}
					else if($pay_sts == '4') {
						// if(@$element->AppointmentOrder->type == "0" && checkAppointmentIsElite($element->id,@$raw->AppointmentOrder->order_by) == 1) {
						if(@$element->AppointmentOrder->type == "0" && in_array($element->id,$appointmentIds) == true) {
							$appointments[] = $element;
						}
					}
					else if($pay_sts == '3') {
						if(@$element->AppointmentOrder->type == "2"){
							$appointments[] = $element;
						}
					}
					else{
						$appointments[] = $element;
					}
				}
				if(count($appointments) > 0 && !empty($app_from)){
					$appointmentsArr = [];
					foreach($appointments as $raw){
						if($app_from == '1') {
							if($raw->app_click_status == '6'){
								if(!empty($raw->AppointmentOrder) && !empty($raw->AppointmentOrder->meta_data)){
									$meta_data = json_decode($raw->AppointmentOrder->meta_data);
									if(isset($meta_data->isPaytmTab) && $meta_data->isPaytmTab == "false"){
										$appointmentsArr[] = $raw;
									}
									if(!isset($meta_data->isPaytmTab)){
										$appointmentsArr[] = $raw;
									}
								}
								if(empty($raw->AppointmentOrder)) {
									$appointmentsArr[] = $raw;
								}
								if(!empty($raw->AppointmentOrder) && empty($raw->AppointmentOrder->meta_data)) {
									$appointmentsArr[] = $raw;
								}
							}
						}
						else if($app_from == '2') {
							if($raw->app_click_status == '5'){
								$appointmentsArr[] = $raw;
							}
						}
						else if($app_from == '3') {
							if($raw->app_click_status == '6' && !empty($raw->AppointmentOrder) && !empty($raw->AppointmentOrder->meta_data)){
								$meta_data = json_decode($raw->AppointmentOrder->meta_data);
								if(isset($meta_data->isPaytmTab) && $meta_data->isPaytmTab == "true"){
									$appointmentsArr[] = $raw;
								}
							}
						}
					}
					$appointments = $appointmentsArr;
				}
				if(count($appointments) > 0 && !empty($request->input('type'))) {
					if(base64_decode($request->input('type')) == '3') {
						$appointmentsArr = [];
						foreach($appointments as $raw) {
							if(checkAppointmentIsElite($raw->id,@$raw->AppointmentOrder->order_by) == 1) {
								$appointmentsArr[] = $raw;
							}
						}
						$appointments = $appointmentsArr;
					}
				}
				if(count($appointments) > 0 && $request->input('code')  != '') {
					$appointmentsCodes = [];
					$code = base64_decode($request->input('code'));
					foreach($appointments as $raw) {
						if($code == 9 && @$raw->AppointmentOrder->hg_miniApp == 1) {
							$appointmentsCodes[] = $raw;
						}
						elseif($code == 10 && @$raw->AppointmentOrder->hg_miniApp == 2) {
							$appointmentsCodes[] = $raw;
						}
						elseif(isset($raw->UserPP) && $raw->UserPP->organization == $code){
							$appointmentsCodes[] = $raw;
						}
					}
					$appointments = $appointmentsCodes;
				}
				/*foreach($appointments as $i => $element) {
					$meta_data = @json_decode($element->AppointmentOrder->meta_data);
				 	if((!empty(getAppointmentTxnDetails($element->id)) && @$element->AppointmentOrder->type == "1") || empty($element->AppointmentOrder)) {
				 		$paymentstatus = 'Paid';
				 	}
					else if(@$element->AppointmentOrder->type == "0") {
						if(checkAppointmentIsElite($element->id,@$element->AppointmentOrder->order_by) == 0) {
							$paymentstatus = "Free Direct";
						}
						else {
							$paymentstatus = "Free By Plan";
						}
				 	}
					else if(@$element->AppointmentOrder->type == "2"){
						$paymentstatus = 'Cash';
					}
					if(isset($element->AppointmentOrder)){
						if($element->AppointmentOrder->order_from == '1') {
							$bookfrom =	"APP";
						}
						elseif($element->AppointmentOrder->order_from == '0'){
							$bookfrom =	"WEB";
						}
						elseif($element->AppointmentOrder->order_from == '2'){
							$bookfrom =	"Admin";
						}
						if(isset($element->AppointmentTxn) && !empty($element->AppointmentTxn->received_by)){
							$bookfrom .= " ".getNameByLoginId($element->AppointmentTxn->received_by);
						}
						if(isset($meta_data->isPaytmTab) && $meta_data->isPaytmTab == "true"){
							$bookfrom .= " (Paytm)";
						}
						elseif(isset($meta_data->organization)){
							$bookfrom .= " ".$meta_data->organization;
						}
						if(isset($element->AppointmentOrder) && $element->AppointmentOrder->hg_miniApp == 1) {
							$bookfrom = "(Help India)";
						}
					}
					else {
						if($element->app_click_status == '5'){ $bookfrom = "APP";} elseif($element->app_click_status == '6'){ $bookfrom = "WEB";}
					}
				 	if ($element->status != '1') {
				 		$status = 'Cancelled';
				 	}
				 	elseif ($element->appointment_confirmation == '1') {
				 		$status = 'Confirmed';
				 	}
				 	else{
				 		$status = 'Pending';
				 	}
					$pStatus = "";
					if(!empty(getAppointmentTxnDetails($element->id))) { //pr(getAppointmentTxnDetails($element->id));
						$pStatus = @getAppointmentTxnDetails($element->id)->tran_status;
					}

                    $docFeeToPay=0;
                    if(!empty($element->AppointmentOrder) && @$element->AppointmentOrder->type == "0")
					{
					    $docFeeToPay= getPlanFeebyDoc($element->User->id,@$element->AppointmentOrder->order_subtotal);
				    }elseif(!empty($element->AppointmentOrder) && @$element->AppointmentOrder->type != "0" && $element->type == '3'  && @$meta_data->isDirectAppt == '0'){
						$docFeeToPay= number_format(@$element->AppointmentOrder->order_subtotal,2);
					}elseif(!empty($element->AppointmentOrder) && @$element->AppointmentOrder->type != "0" && $element->type != '3')
					{
						$docFeeToPay= 0;
				    }
					else{
					    $docFeeToPay= number_format(getPlanFeebyDoc($element->User->id,@$element->AppointmentOrder->order_subtotal),2);
					}
					$accNo = "";
					if(!empty($element->User->DoctorInfo->acc_no) && Session::get('id') == 22) {
						$accNo = "(".replacewithStar(@$element->User->DoctorInfo->acc_no,4).")";
					}
					    $appointmenArray[] = array(
						 $i+1,
						 date('d-m-Y h:i A',strtotime($element->start)),
						 @$element->AppointmentOrder->id,
						 //getVisitType($element->visit_type),
						 @$element->User->DoctorInfo->first_name." ".@$element->User->DoctorInfo->last_name." (".@$element->User->id.") (".@$element->User->DoctorInfo->mobile.")".$accNo,
						 getStateName(@$element->User->DoctorInfo->state_id),
						 getCityName(@$element->User->DoctorInfo->city_id),
						 @$element->Patient->first_name." ".@$element->Patient->last_name." (".@$element->Patient->id.") (".@$element->Patient->mobile_no.")",
						 @$element->Patient->gender,
						 ($element->type == '3') ? " Tele Consult" : "In Clinic",
                         $docFeeToPay,
						 //(!empty($element->AppointmentOrder))? getPlanFeebyDoc($element->User->id,@$element->AppointmentOrder->order_subtotal) : getPlanFeebyDoc($element->User->id,$element->consultation_fees),
						 (!empty($element->AppointmentOrder))? @$element->AppointmentOrder->order_subtotal : $element->consultation_fees,
						 (!empty($element->AppointmentOrder))? @$element->AppointmentOrder->order_total : $element->consultation_fees,
						 @$paymentstatus,
						 @$bookfrom,
						 (!empty($element->AppointmentOrder->rating)) ? @$element->AppointmentOrder->rating." STAR" : "",
						 date('d-m-Y h:i A',strtotime($element->created_at)),
						 $status,
						 $pStatus,
					  );
				 }*/
				return Excel::download(new AppointmentExport($appointments), 'appointments.xlsx');
			}
			if($file_type == "pdf") {
				$appointments = [];
				$appointmentData = $query->orderBy('id','desc')->get();
				foreach($appointmentData as $i => $element) {
					if($pay_sts == '1') {
						if(!empty($element->AppointmentTxn) && @$element->AppointmentOrder->type == "1"){
							$appointments[] = $element;
						}
						else if(empty($element->AppointmentOrder)) {
							$appointments[] = $element;
						}
					}
					else if($pay_sts == '2') {
						if(@$element->AppointmentOrder->type == "0" && checkAppointmentIsElite($element->id,@$raw->AppointmentOrder->order_by) == 0) {
							$appointments[] = $element;
						}
					}
					else if($pay_sts == '4') {
						if(@$element->AppointmentOrder->type == "0" && checkAppointmentIsElite($element->id,@$raw->AppointmentOrder->order_by) == 1) {
							$appointments[] = $element;
						}
					}
					else if($pay_sts == '3') {
						if(@$element->AppointmentOrder->type == "2"){
							$appointments[] = $element;
						}
					}
					else{
						$appointments[] = $element;
					}
				}
				if(count($appointments) > 0 && !empty($app_from)){
					$appointmentsArr = [];
					foreach($appointments as $raw){
						if($app_from == '1') {
							if($raw->app_click_status == '6'){
								if(!empty($raw->AppointmentOrder) && !empty($raw->AppointmentOrder->meta_data)){
									$meta_data = json_decode($raw->AppointmentOrder->meta_data);
									if(isset($meta_data->isPaytmTab) && $meta_data->isPaytmTab == "false"){
										$appointmentsArr[] = $raw;
									}
									if(!isset($meta_data->isPaytmTab)){
										$appointmentsArr[] = $raw;
									}
								}
								if(empty($raw->AppointmentOrder)) {
									$appointmentsArr[] = $raw;
								}
								if(!empty($raw->AppointmentOrder) && empty($raw->AppointmentOrder->meta_data)) {
									$appointmentsArr[] = $raw;
								}
							}
						}
						else if($app_from == '2') {
							if($raw->app_click_status == '5'){
								$appointmentsArr[] = $raw;
							}
						}
						else if($app_from == '3') {
							if($raw->app_click_status == '6' && !empty($raw->AppointmentOrder) && !empty($raw->AppointmentOrder->meta_data)){
								$meta_data = json_decode($raw->AppointmentOrder->meta_data);
								if(isset($meta_data->isPaytmTab) && $meta_data->isPaytmTab == "true"){
									$appointmentsArr[] = $raw;
								}
							}
						}
					}
					$appointments = $appointmentsArr;
				}
				if(count($appointments) > 0 && !empty($request->input('type'))) {
					if(base64_decode($request->input('type')) == '3') {
						$appointmentsArr = [];
						foreach($appointments as $raw) {
							if(checkAppointmentIsElite($raw->id,@$raw->AppointmentOrder->order_by) == 1) {
								$appointmentsArr[] = $raw;
							}
						}
						$appointments = $appointmentsArr;
					}
				}
				if(count($appointments) > 0 && $request->input('code')  != '') {
					$appointmentsCodes = [];
					$code = base64_decode($request->input('code'));
					foreach($appointments as $raw) {
						if($code == 9 && @$raw->AppointmentOrder->hg_miniApp == 1) {
							$appointmentsCodes[] = $raw;
						}
						elseif($code == 10 && @$raw->AppointmentOrder->hg_miniApp == 2) {
							$appointmentsCodes[] = $raw;
						}
						elseif(isset($raw->UserPP) && $raw->UserPP->organization == $code){
							$appointmentsCodes[] = $raw;
						}
					}
					$appointments = $appointmentsCodes;
				}
				$pdf = PDF::loadView('admin.appointments.appointmentPDF',compact('appointments'));
				return $pdf->download('appointment-report.pdf');
			}
			
				$appointmentData = $query->orderBy('id', 'desc')->get();
				
				$appointments = [];

				foreach($appointmentData as $i => $element) {
					$appointmentIds = [];
					if(isset($element->AppointmentOrder->PlanPeriods) && count($element->AppointmentOrder->PlanPeriods)>0){
						$appointment_ids = "";
						foreach($element->AppointmentOrder->PlanPeriods as $val){
							$appointment_ids .= $val->appointment_ids.",";
						}
						$appointmentIds = [];
						if(!empty($appointment_ids)){
							$appointmentIds = explode(",",$appointment_ids);
						}
					}
					if($pay_sts == '1') {
						if(!empty($element->AppointmentTxn) && @$element->AppointmentOrder->type == "1"){
							$appointments[] = $element;
						}
						else if(empty($element->AppointmentOrder)) {
							$appointments[] = $element;
						}
					}
					else if($pay_sts == '2') {
						if(@$element->AppointmentOrder->type == "0" && in_array($element->id,$appointmentIds) == false) {
							$appointments[] = $element;
						}
					}
					else if($pay_sts == '4') {
						if(@$element->AppointmentOrder->type == "0" && in_array($element->id,$appointmentIds) == true) {
							$appointments[] = $element;
						}
					}
					else if($pay_sts == '3') {
						if(@$element->AppointmentOrder->type == "2"){
							$appointments[] = $element;
						}
					}
					else{
						$appointments[] = $element;
					}
				}

				if(count($appointments) > 0 && !empty($app_from)){
					$appointmentsArr = [];
					foreach($appointments as $raw){
						if($app_from == '1') {
							if($raw->app_click_status == '6'){
								if(!empty($raw->AppointmentOrder) && !empty($raw->AppointmentOrder->meta_data)){
									$meta_data = json_decode($raw->AppointmentOrder->meta_data);
									if(isset($meta_data->isPaytmTab) && $meta_data->isPaytmTab == "false"){
										$appointmentsArr[] = $raw;
									}
									if(!isset($meta_data->isPaytmTab)){
										$appointmentsArr[] = $raw;
									}
								}
								if(empty($raw->AppointmentOrder)) {
									$appointmentsArr[] = $raw;
								}
								if(!empty($raw->AppointmentOrder) && empty($raw->AppointmentOrder->meta_data)) {
									$appointmentsArr[] = $raw;
								}
							}
						}
						else if($app_from == '2') {
							if($raw->app_click_status == '5'){
								$appointmentsArr[] = $raw;
							}
						}
						else if($app_from == '3') {
							if($raw->app_click_status == '6' && !empty($raw->AppointmentOrder) && !empty($raw->AppointmentOrder->meta_data)){
								$meta_data = json_decode($raw->AppointmentOrder->meta_data);
								if(isset($meta_data->isPaytmTab) && $meta_data->isPaytmTab == "true"){
									$appointmentsArr[] = $raw;
								}
							}
						}
					}
					$appointments = $appointmentsArr;
				}

				if(count($appointments) > 0 && !empty($request->input('type'))) {
					if(base64_decode($request->input('type')) == '3') {
						$appointmentsArr = [];
						foreach($appointments as $raw) {
							if(checkAppointmentIsElite($raw->id,@$raw->AppointmentOrder->order_by) == 1) {
								$appointmentsArr[] = $raw;
							}
						}
						$appointments = $appointmentsArr;
					}
				}
				if(count($appointments) > 0 && $request->input('code')  != '') {
					$appointmentsCodes = [];
					$code = base64_decode($request->input('code'));
					foreach($appointments as $raw) {
						if($code == 9 && @$raw->AppointmentOrder->hg_miniApp == 1) {
							$appointmentsCodes[] = $raw;
						}
						elseif($code == 10 && @$raw->AppointmentOrder->hg_miniApp == 2) {
							$appointmentsCodes[] = $raw;
						}
						elseif(isset($raw->UserPP) && $raw->UserPP->organization == $code){
							$appointmentsCodes[] = $raw;
						}
					}
					$appointments = $appointmentsCodes;
				}
				$perPage = 25;
				$input = Input::all();
				if (isset($input['page']) && !empty($input['page'])) { $currentPage = $input['page']; } else { $currentPage = 1; }
				$offset = ($currentPage * $page) - $page;
				$itemsForCurrentPage = array_slice($appointments, $offset, $page, false);
				$appointments =  new Paginator($itemsForCurrentPage, count($appointments), $page,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
		}
		$practices = Doctors::select(['first_name','last_name','email','consultation_fees','oncall_fee','user_id'])->with("docSpeciality")->where(["delete_status"=>1,"hg_doctor"=>1,"claim_status"=>1,"varify_status"=>1])->orderBy("id","ASC")->get();
		// $practices = ehrUser::with(['DoctorInfo'])->where(['status'=>1,'varify_status'=>1,'delete_status'=>1])->orderBy("id","ASC")->get();
	
		// dd($appointments->toArray());

		return view('admin.appointments.appointment-master',compact('appointments','practices'));
	}

	public function ChangeWorkingStatus(Request $request) {
		$data = $request->all();
		$appointment_id = base64_decode($data['id']);
		 $user_id = Session::get('userdata')->id;
		if ($data['status'] == null) {
		  $status = array('status' => 1, 'user_id' => $user_id);
		  Appointments::where('id', $appointment_id)->update(array('working_status' => json_encode($status)));
		}
		elseif ($data['status'] == 1) {
		  $status = array('status' => 2, 'user_id' => $user_id);
		  Appointments::where('id', $appointment_id)->update(array('working_status' => json_encode($status)));
		}
		return 1;
	  }

	public function switchAppointment(Request $request) {
		$data = $request->all();
		$appointment_id = base64_decode($data['app_id']);
		$doc_id = $data['doc_id'];
		$pId = $data['pId'];
		if(!empty($appointment_id) && !empty($doc_id)) {
			$exist_doctor = Appointments::select(["consultation_fees","doc_id","added_by","type"])->where('id', $appointment_id)->first();
			$docInfo = Doctors::select(["consultation_fees","oncall_fee","slot_duration"])->where("user_id",$doc_id)->first();
			$plan_data = PlanPeriods::whereRaw("find_in_set('".$appointment_id."',plan_periods.appointment_ids)")->first();
			if(($exist_doctor->doc_id != $doc_id && checkAppointmentIsElite($appointment_id) == 0) || (!empty($plan_data) && $plan_data->specialist_appointment_cnt <= 0)) {
				if($exist_doctor->type == "3") {
					// if(checkAppointmentIsElite($appointment_id) == 0 && $exist_doctor->consultation_fees != $docInfo->oncall_fee && $exist_doctor->doc_id != "2219") {
						// return 4;
					// }
				}
				else{
					// if(checkAppointmentIsElite($appointment_id) == 0 && $exist_doctor->consultation_fees != $docInfo->consultation_fees) {
						// return 4;
					// }
				}
			}
			$increment_time = $docInfo->slot_duration*60;
			$startVal = date('Y-m-d',strtotime($data['appstart_date'])).' '.date('H:i:s',$data['time']);
			$endVal = date('Y-m-d',strtotime($data['appstart_date'])).' '.date('H:i:s',$data['time']+$increment_time);
			// $endVal = date('Y-m-d H:i:s',strtotime($data['appstart_date']." ".$data['time'])+$increment_time);
			Appointments::where('id',$appointment_id)->update(array('start' => $startVal,'end' =>  $endVal));
			if(isset($data['markAsFollowup'])) {
				if($data['markAsFollowup'] == '1'){
					Appointments::where('id',$appointment_id)->update(array('visit_type' => 6));
				}
				else{
					Appointments::where('id',$appointment_id)->update(array('visit_type' => 1));
				}
			}
			if($exist_doctor->doc_id != $doc_id) {
				if($exist_doctor->type == "3") {
					$appFee = $docInfo->oncall_fee;
				}
				else{
					$appFee = $docInfo->consultation_fees;
				}
				$existPracticeId = $exist_doctor->added_by;
				$practice =  RoleUser::select(['user_id','role_id','practice_id'])->where(['user_id'=>$doc_id])->first();
				Appointments::where('id', $appointment_id)->update(array('doc_id' => $doc_id,'added_by'=>$practice->practice_id,'consultation_fees'=>$appFee));
				AppointmentOrder::where('appointment_id', $appointment_id)->update(array('doc_id' => $doc_id,'order_subtotal'=>$appFee));
				$is_existPat = Patients::where('id', $pId)->whereRaw("find_in_set('".$practice->practice_id."',patients.practices_id)")->count();
				if($is_existPat == 0) {
					$practices_ids = Patients::select('practices_id')->where('id', $pId)->pluck("practices_id")->toArray();
					if(!in_array($practice->practice_id,$practices_ids)){
						array_push($practices_ids,$practice->practice_id);
					}
					$last_reg_no = PatientRagistrationNumbers::where(['added_by'=>$practice->practice_id,'status'=>1])->max('reg_no');
					$reg_no = 1;
					if(!empty($last_reg_no)){
					  $reg_no = $last_reg_no+1;
					}
					if(countExistsAppointment($pId,$practice->practice_id) == 0) {
						if(($key = array_search($existPracticeId, $practices_ids)) !== false) {
							unset($practices_ids[$key]);
						}
						PatientRagistrationNumbers::where(['pid'=>$pId,"added_by"=>$existPracticeId])->update(array(
							'added_by'=>$practice->practice_id,
							'reg_no'=> $reg_no,
						));
					}
					else{
						PatientRagistrationNumbers::create([
							 'pid' => $pId,
							 'reg_no' =>  $reg_no,
							 'status' =>  1,
							 'added_by' => $practice->practice_id,
						]);
					}
					array_unique($practices_ids);
					$practices_ids =  implode(',',$practices_ids);
					Patients::where('id', $pId)->update(array(
						'added_by'=>$practice->practice_id,
						'practices_id'=>$practices_ids
					));
					User::where('pId', $pId)->update(array(
						'added_by'=>$practice->practice_id,
						'practices_id'=>$practices_ids
					));
				}
				if(checkAppointmentIsElite($appointment_id) == 1) {
					if(in_array($doc_id,getSetting("specialist_doctor_user_ids"))) {
						if($plan_data->specialist_appointment_cnt > 0) {
							$remaining_appointment_count = $plan_data->specialist_appointment_cnt;
							PlanPeriods::where('id',$plan_data->id)->update(array('specialist_appointment_cnt' => ($remaining_appointment_count-1)));
						}
					}
				}
				AppointmentOrder::where('appointment_id', $appointment_id)->update(array('switch_apt' => '1'));
				$this->sendPlanAppointmentMail($appointment_id);
			}
			return 1;
		}
		return 2;
	}

	  public function sendPlanAppointmentMail($appointment_id) {
		if($this->is_connected()==1) {
			$appointment =  Appointments::where('id',$appointment_id)->first();
			$consultation_fees = $appointment->consultation_fees;
			$fees_type = "";
			if($appointment->AppointmentOrder->type == '0'){
				$consultation_fees = '<strike>'.getSetting("tele_main_price")[0].'</strike>';
				$fees_type = "FREE";
			}
			$docData = Doctors::where(['user_id'=>$appointment->doc_id])->first();
			$docData["appointment_type"] = $appointment->type;
			$docName = "Dr. ".ucfirst($docData->first_name)." ".$docData->last_name;
			$patientname = $appointment->patient->first_name.' '.$appointment->patient->last_name;
			$appointDate = date('d-m-Y',strtotime($appointment->start));
			$appointtime = date('h:i A',strtotime($appointment->start));

			if(!empty($appointment->Patient->email)) {
				$EmailTemplate = EmailTemplate::where('slug','teleconsultpatientappointment')->first();
				$to = $appointment->Patient->email;
				if($EmailTemplate && !empty($to)) {
					$body = $EmailTemplate->description;
					$tbl = '<table style="width: 100%;" cellpadding="0" cellspacing="0"><tbody><tr><td width="130" style="border:1px solid #ccc;font-size: 13px; color:#189ad4; padding: 5px 10px;">Appointment Dr.</td><td style="border:1px solid #ccc;font-size: 13px; color:#189ad4; padding: 5px 10px;">Dr. '.@$docData->first_name." ".@$docData->last_name.'</td></tr><tr><td width="130" style="border:1px solid #ccc;font-size: 13px; color:#189ad4; padding: 5px 10px;">Date and Time</td><td style="border:1px solid #ccc;font-size: 13px; color:#189ad4; padding: 5px 10px;">'.date('d-m-Y, h:i:sa',strtotime($appointment->start)).'</td></tr><tr><td width="130" style="border:1px solid #ccc;font-size: 13px; color:#189ad4; padding: 5px 10px;">Payment for Consultations</td><td style="border:1px solid #ccc;font-size: 13px; color:#189ad4; padding: 5px 10px;">₹ '.$consultation_fees." ".$fees_type.'</td></tr><tr><td colspan="2" style="font-size: 13px; color:#333; padding:10px 0px 10px;">If you wish to reschedule or cancel your appointment, please contact to our help line number.</td></tr></tbody></table>';

					$mailMessage = str_replace(array('{{pat_name}}','{{clinic_name}}','{{clinic_phone}}','{{appointmenttable}}'),
					array($patientname,$docData->clinic_name,$docData->mobile,$tbl),$body);
					$to_docname = '';
					$datas = array('to' =>$to,'from' => 'noreply@healthgennie.com','mailTitle'=>$EmailTemplate->title,'practiceData'=>$docData,'content'=>$mailMessage,'subject'=>$EmailTemplate->subject);
					try{
					Mail::send('emails.mailtempPractice', $datas, function( $message ) use ($datas) {
						$message->to( $datas['to'] )->from( $datas['from'])->subject($datas['subject']);
					});
					}
					catch(\Exception $e){
					  // Never reached
					}
				}
			}
			if(!empty($appointment->Patient->mobile_no)) {
				$message = urlencode("Dear ".ucfirst($appointment->Patient->first_name)." ".$appointment->Patient->last_name." , Your Tele consultation with Dr. ".$appointment->User->DoctorInfo->first_name." ".$appointment->User->DoctorInfo->last_name." on ".$appointDate." and ".$appointtime." has been confirmed. Please keep the Health Gennie app open at the time of consultation. Thanks Team Health Gennie");
				$this->sendSMS($appointment->Patient->mobile_no,$message,'1707161587979652683');
			}
		}
	}

	public function RefundOrder(Request $request) {
	  	if ($request->isMethod('post')) {
		$data = $request->all();
		$ch_app = curl_init();
		curl_setopt($ch_app, CURLOPT_URL, "https://apitest.ccavenue.com/apis/servlet/refundOrder");
		curl_setopt($ch_app, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch_app, CURLOPT_POST, true);
		$order_array = array(
			'reference_no' => 123446,
			'refund_amount' => 50,
			'refund_ref_no' => 1234,
		);
		$order_data = json_encode($order_array);
		curl_setopt($ch_app, CURLOPT_POSTFIELDS, $order_data);
		curl_setopt($ch_app, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch_app, CURLOPT_RETURNTRANSFER, true);
		$app_output = curl_exec($ch_app);
		curl_close($ch_app);
		$output = json_decode($app_output,true);
		dd($output);
	  }
	}

	public function appointmentRating(Request $request) {
		$data = $request->all();
		$appointment_id = base64_decode($data['appId']);
		if(!empty($appointment_id)) {
			AppointmentOrder::where('appointment_id', $appointment_id)->update(array('rating' => $data['rating']));
		}
		return 1;
	}
	public function showAppts(Request $request) {
		$data = $request->all();
		$pid = base64_decode($data['pid']);
		$mobile = base64_decode($data['mobile']);
		$user = User::select(["id","pId"])->where(["mobile_no"=>$mobile])->where("parent_id",0)->first();
		$user_id = $user->id;

		$remaining_appointment = PlanPeriods::select('remaining_appointment')->where("user_id",$user_id)->where('status',1)->sum('remaining_appointment');
		$rem_appt = "";
		if(!empty($remaining_appointment)){
		$rem_appt = $remaining_appointment;
		}
		$p_ids = User::select("pId")->where(["parent_id"=>$user->pId])->pluck("pId")->toArray();
		array_push($p_ids,$user->pId);
		$appts = Appointments::with(['user.doctorInfo','Patient','AppointmentOrder'])->whereIn('pID',$p_ids)->where('delete_status',1)->orderBy('start','desc')->get();
		return ['appts'=>$appts,'tot_rem_appt'=>$rem_appt];
	  }
	  public function showSlotAdmin(Request $request) {
		$doc_id = $request->doc_id;
		$type = $request->type;
		$visit_type = $request->visit_type;
		$app_id = $request->app_id;
		$pId = $request->pId;
		$date = date('d-m-Y',strtotime($request->date));
		// pr(base64_decode($type));
		$doctor = Doctors::where(['user_id'=>$doc_id])->first(); // pr($doctor);
		if(!empty($doctor->convenience_fee)){
			$charge = $doctor->convenience_fee;
		}
		else{
			$charge = getSetting("service_charge_rupee")[0];
		}
		$consultation_fees = 0;
		if(base64_decode($type) == '1') { 
			$consultation_fees = $doctor->oncall_fee;;
		}
		else if(base64_decode($type) == '2'){ 
			$consultation_fees = 0;
		} 
		$conFee = $consultation_fees + $charge;
		if($doctor->id == 49188){
         $conFee = 99;
		}
		return view('admin.appointments.slots',compact('doctor','type','date','conFee','visit_type','app_id','pId'));
	}
	public function showSlotAdminCampAppt(Request $request) {
		$doc_id = $request->doc_id;
		$pId = $request->pId;
		$date = date('d-m-Y',strtotime($request->date));
		$type = '1';
		$visit_type = 1;
		$doctor = Doctors::where(['user_id'=>$doc_id])->first(); // pr($doctor);
		if(!empty($doctor->convenience_fee)){
			$charge = $doctor->convenience_fee;
		}
		else{
			$charge = getSetting("service_charge_rupee")[0];
		}
		$consultation_fees = 0;
		if(base64_decode($type) == '1') { 
			$consultation_fees = $doctor->oncall_fee;;
		}
		else if(base64_decode($type) == '2'){ 
			$consultation_fees = 0;
		} 
		$conFee = $consultation_fees + $charge;
		if($doctor->id == 49188){
         $conFee = 99;
		}
		return view('admin.appointments.camp-slots',compact('doctor','type','date','conFee','visit_type','pId'));
	}
	public function sendPres(Request $request) {
		$data = $request->all();
		$appt = Appointments::with(['AppointmentOrder','User.DoctorInfo','Patient'])->where("id",$data['appId'])->first();
		$name = $appt->Patient->first_name." ".$appt->Patient->last_name;
		$docName = "Dr. ".$appt->User->DoctorInfo->first_name." ".$appt->User->DoctorInfo->first_name;
		$pdfUrl = url("/")."/rad/".base64_encode($appt->id);
		$tmpName = "pres_share_v3h";
		$post_data = ['parameters'=>[['name'=>'name','value'=>$name],['name'=>'link','value'=>$pdfUrl]],'template_name'=>$tmpName,'broadcast_name'=>'share prescription'];
		
		$presDta = UserPrescription::select(["prescription","type"])->where(['appointment_id'=>$data['appId']])->orderBy("id","DESC")->first();
		$this->writeClinicNoteFile($appt->Patient->patient_number,$presDta->prescription);
		$preUrl = 	getPath("uploads/PatientDocuments/".$appt->Patient->patient_number."/misc/clinicalNotePrint.pdf");
		$curl = curl_init();
		$cfile = getCurlValue($preUrl,'application/pdf','clinicalNotePrint.pdf');
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://live-server-2748.wati.io/api/v1/sendSessionFile/91".$appt->Patient->mobile_no."?caption=prescription",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => array('file' => $cfile),
		  CURLOPT_HTTPHEADER => array(
			paytmAuthToken(),
			"content-type: multipart/form-data",
			"Content-Type: application/pdf",
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response,true);
		if(isset($response['result']) && $response['result'] == 'success') {
			return 1;
		}
		else {
			return sendWhatAppMsg($post_data,$appt->Patient->mobile_no);
		}
		// if(isset($response['ticketStatus']) && ($response['ticketStatus'] == 'CLOSED' || $response['ticketStatus'] == 'EXPIRED')) {
			
		// }
	}
	
	public function sendPresToPharmacy(Request $request) {
		$data = $request->all();
		$appt = Appointments::with(['AppointmentOrder','User.DoctorInfo','Patient'])->where("id",$data['appId'])->first();
		$name = $appt->Patient->first_name." ".$appt->Patient->last_name;
		$docName = "Dr. ".$appt->User->DoctorInfo->first_name." ".$appt->User->DoctorInfo->first_name;
		$pdfUrl = url("/")."/rad/".base64_encode($appt->id);
		$tmpName = "pres_share_v3h";
		$post_data = ['parameters'=>[['name'=>'name','value'=>$name],['name'=>'link','value'=>$pdfUrl]],'template_name'=>$tmpName,'broadcast_name'=>'share prescription'];
		
		$presDta = UserPrescription::select(["prescription","type"])->where(['appointment_id'=>$data['appId']])->orderBy("id","DESC")->first();
		$this->writeClinicNoteFile($appt->Patient->patient_number,$presDta->prescription);
		$preUrl = 	getPath("uploads/PatientDocuments/".$appt->Patient->patient_number."/misc/clinicalNotePrint.pdf");
		$curl = curl_init();
		$cfile = getCurlValue($preUrl,'application/pdf','clinicalNotePrint.pdf');
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://live-server-2748.wati.io/api/v1/sendSessionFile/918905557252?caption=prescription",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => array('file' => $cfile),
		  CURLOPT_HTTPHEADER => array(
			paytmAuthToken(),
			"content-type: multipart/form-data",
			"Content-Type: application/pdf",
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response,true);
		// pr($response);
		if(isset($response['result']) && $response['result'] == 'success') {
			return 1;
		}
		else {
			return sendWhatAppMsg($post_data,8905557252);
		}
		// if(isset($response['ticketStatus']) && ($response['ticketStatus'] == 'CLOSED' || $response['ticketStatus'] == 'EXPIRED')) {
			
		// }
	}
	public function showPrescription(Request $request){
		$data = $request->all();
		$appt = Appointments::with(['AppointmentOrder','User.DoctorInfo','Patient'])->where("id",$data['appId'])->first();
		$presDta = UserPrescription::select(["prescription","type"])->where(['appointment_id'=>$data['appId']])->orderBy("id","DESC")->first();
		$this->writeClinicNoteFile($appt->Patient->patient_number,$presDta->prescription);
		return getPath("uploads/PatientDocuments/".$appt->Patient->patient_number."/misc/clinicalNotePrint.pdf");
	}
	public function cahngeStatus(Request $request){
        try {
		 $id =  \Session::get('id');
		 $jsonData = array('status' => $request->status, 'user_id' => \Session::get('id'));
		 Appointments::where('id', $request->appId)->update(array('working_status' => json_encode($jsonData)));
        } catch (Exception $e) {
            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);
            exit;
        }
		return response()->json(['success'=>true]);
	}
}
