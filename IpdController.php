<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\DoctorsInfo;
use App\Models\Appointments;
use App\Models\Patients;
use App\Models\ChiefComplaints;
use App\Models\PatientMedications;
use App\Models\PatientLabs;
use App\Models\PatientSubLabs;
use App\Models\ItemDetails;
use App\Models\ItemType;
use App\Models\PatientAllergy;
use App\Models\DentalMaster;
use App\Models\PatientProcedures;
use App\Models\PatientDiagnosis;
use App\Models\PatientVitalss;
use App\Models\PatientExaminations;
use App\Models\PatientDentals;
use App\Models\PatientEyes;
use App\Models\PatientImmunizations;
use App\Models\PatientDiagnosticImagings;
use App\Models\PatientMedicalHistory;
use App\Models\PatientSurgicalHistory;
use App\Models\PatientHospitalizationHistory;
use App\Models\PatientFamilyHistory;
use App\Models\PatientSocialHistory;
use App\Models\PatientGynHistory;
use App\Models\PatientObHistory;
use App\Models\DocFavorite;
use App\Models\PatientReferrals;
use App\Models\MedicineOrders;
use App\Models\Labs;
use App\Models\SubLabs;
use App\Models\LabOrders;
use App\Models\DefaultLabs;
use App\Models\RadiologyMaster;
use App\Models\RadiologyOrders;
use App\Models\BodySites;
use App\Models\Procedures;
use App\Models\Diagnosis;
use App\Models\Allergies;
use App\Models\PracticeDetails;
use App\Models\VisitTypes;
use App\Models\PracticeDocuments;
use App\Models\ReferralsMaster;
use App\Models\OpdTimings;
use App\Models\LabProfile;
use App\Models\RadiologyProfile;
use App\Models\PharmacyProfile;
use App\Models\CompanyName;
use App\Models\FollowUp;
use App\Models\Immunizations;
use App\Models\FavoriteItems;
use App\Models\IPDWards;
use App\Models\IPDRequest;
use App\Models\IPDPatientBed;
use App\Models\IPDDischarge;
use App\Models\EomMaster;
use App\Models\PatientEom;
use App\Models\PatientSle;
use App\Models\SleMaster;
use App\Models\PatientFundus;
use App\Models\PatientSystematicIllness;
use App\Models\PatientEyesExaminations;
use App\Models\TemplateMeta;
use App\Models\PatientSleCanvas;
use App\Models\BillingCategories;
use App\Models\PatientRelation;
use App\Models\VisualAcuityUcvaMaster;
use App\Models\OtReportTemplate;
use App\Models\PatientOtTemplate;
use App\Models\PatientCounselling;
use App\Models\PatientCounsellingPacks;
use App\Models\IPDPatientBills;
use App\Models\IPDAdvanceBill;
use App\Models\BillableItem;
use App\Models\IPDPatientWardTransfer;
use App\Models\IPDRemainingPatientBills;
use App\Models\IPDBilledItems;
use App\Models\IPDBillingPayments;
use App\Models\PatientAllergyHistory;
use App\Models\DischargeHistory;
use App\Models\NeonatologyHistory;
use App\Models\NeonatologyTreatment;
use App\Models\MeternalHistory;
use App\Models\BornChecklist;
use App\Models\NeonatologyManagement;
use App\Models\PatientGrowthChart;
use App\Models\RecycleBin;
use App\Models\LabPack;
use App\Models\OTRegistration;
use App\Models\GynecologyDischargeSummary;


use Session;
use DB;
use URL;
use Mail;
use Auth;
use File;
use Hash;
use Route;
use PDF;
use DateTime;
use App\Models\EmailTemplate;
use App\Models\Templates;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class IpdController extends Controller
{
    /*
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function IPDRequest(Request $request){

        date_default_timezone_set('Asia/kolkata');
        if ($request->isMethod('post')) {
         $data = $request->all();
         $practiceId = Parent::getMyPractice()->practice_id;
// 18002585656
         $patient_exist = IPDRequest::where(['delete_status' => 1,'status' => 1,'patient_id'=>$data['patient_id']])->first();
         $is_referred = is_referred($data['patient_id']);
         if(empty($patient_exist))
         {

           $wards =  IPDRequest::create([
             'register_status'=>$data['register_status'],
             'appointment_id'=>$data['appointment_id'],
             'patient_id'=>$data['patient_id'],
             'ipd_request_date' => date('Y-m-d H:i:s',strtotime(date('H:i:s'),strtotime($data['ipd_request_date']))),
             'ward_name' => $data['ward_name'],
             'ipd_note' => $data['ipd_note'],
             'order_by' => $data['doc_id'],
             'is_reffered' => (isset($data['is_reffred']) ? $data['is_reffred'] : '0'),
             'referred_by' => (isset($data['referred_by']) ? $data['referred_by'] : '0'),
             'is_referred' => $is_referred,
             'practice_id'   => $practiceId
             //'practice_id' => $practiceId
           ]);
           if($data['appointment_id']!=0){Appointments::where('id', $data['appointment_id'])->update(array('ipd_request_id' =>$wards->id));}
           else{
             $startDate =  date('Y-m-d H:i:s',strtotime(date('H:i:s'),strtotime($data['ipd_request_date'])));
             $appointment = Appointments::create([
                 'ipd_request_id' => $wards->id,
                 'doc_id' => $data['doc_id'],
                 'pId' => $data['patient_id'],
                 'billable_status' =>1,
                 'visit_type' =>1,
                 'start' => $startDate,
                 'end' => $startDate,
                 'status' => 1
               ]);
               IPDRequest::where('id', $wards->id)->update(array('appointment_id' =>$appointment->id));
           }
           Session::flash('message',"IPD Request Added Successfully");
           return 1;
         }else {
           return 3;
         }
      }
      return 2;
    }

    public function deleteIPDRequest($id)
    {
        IPDRequest::where('id', base64_decode($id))->update(array('delete_status' => '0'));
  	    Session::flash('message', "IPD Request Deleted Successfully");
        return redirect()->route('ipd.index');
    }

   public function index(Request $request){

     if ($request->isMethod('post'))
     {
         $params = array();
          if (!empty($request->input('from_date'))) {
              $params['from_date'] = base64_encode($request->input('from_date'));
          }
          if (!empty($request->input('to_date'))) {
              $params['to_date'] = base64_encode($request->input('to_date'));
          }
          if (!empty($request->input('ward_name'))) {
              $params['ward_name'] = base64_encode($request->input('ward_name'));
          }
          return redirect()->route('ipd.index',$params)->withInput();
      }
      else
      {
        $filters = array();
        //$practiceId = Parent::getMyPractice()->practice_id;
          $query =  IPDRequest::Where(['order_status'=> 0, 'delete_status' => 1,'status' => 1]);

          if ($request->input('from_date')  != '' || $request->input('to_date')  != '' || $request->input('ward_name')  != '')
          {
            $from_date = date('Y-m-d',strtotime(base64_decode($request->input('from_date'))));
            $to_date = date('Y-m-d',strtotime(base64_decode($request->input('to_date'))));
            $ward_name = base64_decode($request->input('ward_name'));

            if ($request->input('from_date') != '') {
               $query->whereDate('ipd_request_date','>=', $from_date);
            }
            if ($request->input('to_date') != '') {
               $query->whereDate('ipd_request_date','<=', $to_date);
            }
            if ($request->input('ward_name') != '') {
               $query->where('ward_name', $ward_name);
            }
          }
          $wardRequests = $query->orderBy('id', 'desc')->paginate(10);
          $wards = IPDWards::where(['status' => 1,'delete_status' => 1])->orderBy('id', 'desc')->get();
        }
        return view('ipd.index',compact('wardRequests','wards'));
      }

	 public function admitPatientModal(Request $request)
    {
        $id = $request->id;
		    $practice = Parent::getMyPractice();
        $admitPatient = IPDRequest::Where('id',$id)->first();
        $ward_id = $admitPatient->ward_name;
        $busyRooms = IPDRequest::Where(['order_status'=> 1, 'delete_status' => 1 ,'status' => 1])->whereHas('IPDPatientBed', function($q)  use ($ward_id) {$q->Where('alloted_ward',$ward_id);})->get();
        $wards = IPDWards::where(['status' => 1,'delete_status' => 1])->orderBy('id', 'desc')->get();
        $patientCategory = BillingCategories::where('delete_status', '=', '1')->whereIn('added_by', array(0,$practice->practice_id))->orderBy('name', 'ASC')->get();
        $patientRalation = PatientRelation::where('status', '=', '1')->get();
        //pr($busyRooms);
        $busyRoom = array();
        foreach ($busyRooms as $key => $value) {
        $busyRoom[] = $value->IPDPatientBed->alloted_bed;
        }
        return view('ipd.ajaxpages.admitPatient',compact('admitPatient','wards','busyRooms','busyRoom','patientCategory','patientRalation'));
    }


    public function admittedPatientModal(Request $request)
    {
        $id = $request->id;
       
        $admitted_id = $request->admitted_id;
       
		    $practice = Parent::getMyPractice();
        $admitPatient = IPDRequest::Where('id',$id)->first();
        $admittedPatient= IPDPatientBed::where('id',$admitted_id)->first();

        $ward_id = $admitPatient->ward_name;
        $busyRooms = IPDRequest::Where(['order_status'=> 1, 'delete_status' => 1 ,'status' => 1])->whereHas('IPDPatientBed', function($q)  use ($ward_id) {$q->Where('alloted_ward',$ward_id);})->get();
        $wards = IPDWards::where(['status' => 1,'delete_status' => 1])->orderBy('id', 'desc')->get();
        $patientCategory = BillingCategories::where('delete_status', '=', '1')->whereIn('added_by', array(0,$practice->practice_id))->orderBy('name', 'ASC')->get();
        $patientRalation = PatientRelation::where('status', '=', '1')->get();
        //pr($busyRooms);
        $busyRoom = array();
        foreach ($busyRooms as $key => $value) {
        $busyRoom[] = $value->IPDPatientBed->alloted_bed;
        }
        return view('ipd.ajaxpages.editadmittedPatient',compact('admitted_id','admitPatient','wards','busyRooms','busyRoom','patientCategory','patientRalation','admittedPatient'));
    }

    public function wardSelection(Request $request)
    {
        $id = $request->id;
        $wardSelection = IPDWards::where('id', '=', $id)->first();
        $busyRooms = IPDRequest::Where(['order_status'=> 1, 'delete_status' => 1 ,'status' => 1])
        ->whereHas('IPDPatientBed', function($q)  use ($id) {$q->Where('alloted_ward',$id);})->get();
        //pr($busyRooms);
        $busyRoom = array();
        foreach ($busyRooms as $key => $value) {
        $busyRoom[] = $value->IPDPatientBed->alloted_bed;
        }
        return view('ipd.ajaxpages.wardSelection',compact('wardSelection','busyRooms','busyRoom'));
    }

	public function createBill($practiceId,$ipd_id,$patient_id,$billableItem,$item_type,$bill_date = null) {
		if(!empty($bill_date)){
			$bill_date = date('Y-m-d',strtotime($bill_date));
		}
		else{
			$bill_date = date('Y-m-d');
		}
		$PatientBill = IPDPatientBills::where(['ipd_request_id'=>$ipd_id,'patient_id'=>$patient_id,'practice_id'=>$practiceId,'delete_status'=>1])->whereDate('bill_date','=', $bill_date)->orderBy("created_at","DESC")->first();
		if($item_type == "billable_item"){
			$itemPrice = $billableItem->price;
			$itemId = $billableItem->id;
		}
		else{
			$itemPrice = @getProcedureById($billableItem->procedure_id)->cost;
			$itemId = $billableItem->procedure_id;
		}

		if(empty($PatientBill)) {
			$last_id = DB::table('ipd_patient_bills')->select('id')->orderBy('id', 'DESC')->first();
			if(!empty($last_id)){
				$transaction_id = substr($practiceId,0,1).substr(strtotime(date('d-m-Y h:i:s')),1,7).substr($last_id->id+1,0,1);
			}
			else{
				$transaction_id = substr($practiceId,0,1).substr(strtotime(date('d-m-Y h:i:s')),1,7).'1';
			}
      $is_referred = is_referred($patient_id);
      $last_bill_no = IPDPatientBills::where(['practice_id'=>$practiceId,'is_referred'=>$is_referred,'delete_status'=>1])->orderBy('id', 'DESC')->first();
      $bill_number = getBillNo(@$last_bill_no->bill_no, $is_referred);

			$PatientBill =  IPDPatientBills::create([
			 'ipd_request_id'  => $ipd_id,
			 'pat_category'    => 1,
			 'package_category'=> 1,
			 'transaction_id'  => $transaction_id,
			 'bill_no'         => $bill_number,
			 'bill_date'       => date('Y-m-d H:i:s',strtotime($bill_date)),
			 'bill_collect_date' => date('Y-m-d H:i:s',strtotime($bill_date)),
			 'patient_id'      => $patient_id,
			 'bill_amount'     => $itemPrice,
			 'tot_amount'      => $itemPrice,
			 'payed_amount'    => $itemPrice,
			 'balance_amount'  => $itemPrice,
			 'added_by'        => Auth::id(),
			 'practice_id'     => $practiceId
			]);
			IPDRemainingPatientBills::create([
				'bill_id' => $PatientBill->id,
				'ipd_request_id' => $ipd_id,
				'paid_amount' => $itemPrice,
				'added_by'   => Auth::id(),
				'practice_id'   => $practiceId
			]);
			IPDBillingPayments::create([
			   'bill_id' => $PatientBill->id,
			   'ipd_request_id' => $ipd_id,
			   'payment_mode' => 'Cash',
			   'paid_amount' => $itemPrice,
			   'added_by' => Auth::id(),
			   'practice_id' => $practiceId
			]);
		}
		IPDBilledItems::create([
		  'bill_id'   => $PatientBill->id,
		  'item_id'   => $itemId,
		  'charge_type' => $item_type,
		  'qty'  => 1,
		  'cost'  => $itemPrice,
		  'discount_type'  => 'percent',
		  'total_amount'  => $itemPrice
		]);
	}
	public function IPDPatientBed(Request $request){
        //$practiceId = Parent::getMyPractice()->practice_id;
    
        if ($request->isMethod('post')) {
			  $data = $request->all();

      if(isset($data['admitted_id'])){
        // ddd($data);
        $is_referred = is_referred($data['patient_id']);
        $IPDPatientBed =  IPDPatientBed::where('ipd_request_id', $data['ipd_request_id'])->update([
          'alloted_ward'=>$data['alloted_ward'],
          'alloted_bed'=>$data['alloted_bed'],
          'treatment_by'=>$data['treatment_by'],
          'patient_attendant'=>$data['patient_attendant'],
          'attendant_relation' => $data['attendant_relation'],
          'attendant_mobile' => $data['attendant_mobile'],
          'marital_status' => $data['marital_status'],
          'ward_note'=>$data['ward_note'],
          'reference_by' => $data['reference_by'],
          'admit_date' => $data['admit_date'],
        ]);

      }else{

        $is_referred = is_referred($data['patient_id']);
        $IPDPatientBed =  IPDPatientBed::create([
          'ipd_request_id'=>$data['ipd_request_id'],
          'alloted_ward'=>$data['alloted_ward'],
          'alloted_bed'=>$data['alloted_bed'],
          'treatment_by'=>$data['treatment_by'],
          'patient_attendant'=>$data['patient_attendant'],
          'attendant_relation' => $data['attendant_relation'],
          'attendant_mobile' => $data['attendant_mobile'],
          'marital_status' => $data['marital_status'],
          'reference_by' => $data['reference_by'],
          'admit_date' => $data['admit_date'],
        ]);

      }
  
         Patients::where('id', $data['patient_id'])->update(array(
             'pat_category' => $data['pat_category'],
             'aadhar_no' => $data['aadhar_no'],
             'bhamashah_no' => $data['bhamashah_no'],
             'ration_card_no' => $data['ration_card_no']
         ));

         if($IPDPatientBed){
            $last_ipd_no = IPDRequest::orderBy('id', 'DESC')->whereNotNull("ipd_no")->where('is_refered', $is_referred)->where('delete_status', 1)->first();
            if ($is_referred == 1) {
                // $ipd_no = 'R-IPD1';
                if(!empty($last_ipd_no)){
                  $number = str_split($last_ipd_no->ipd_no, 5);
                  $num = $number[1]+1;
                  $ipd_no = $num;
                }
            }else{
                if(!empty($last_ipd_no)) {
                  $number = substr($last_ipd_no->ipd_no, 3);
                  $number = $number + 1 ;
                  $ipd_no = $data['ipd_request_id'];
                }
                else{
                  $ipd_no = $IPDPatientBed->id;
                }
            }


          $IPDRequest =  IPDRequest::where('id', $data['ipd_request_id'])->update(array('ipd_no' => $ipd_no,'order_status' => 1));
         }
		$practiceId = Parent::getMyPractice()->practice_id;
		$ipd_id =$data['ipd_request_id'];
		$billableItem = BillableItem::where('ward_id', $data['alloted_ward'])->where('status', '1')->where('delete_status', '1')->where('added_by',$practiceId)->first();
		// $itemPrice = $billableItem->price;
		if (!empty($billableItem) > 0) {
			$this->createBill($practiceId,$ipd_id,$data['patient_id'],$billableItem,"billable_item",$data['admit_date']);
		}
    
    if(isset($data['admitted_id'])){

      IPDPatientWardTransfer::where('ipd_request_id', $ipd_id)->update([
        'patient_id'   => $data['patient_id'],
        'ipd_request_id'   => $ipd_id,
        'admit_date'   => (!empty($data['admit_date'])) ? date('Y-m-d H:i:s',strtotime($data['admit_date']))." ".date('G:i:s'): '',
        'alloted_ward'  => $data['alloted_ward'],
        'alloted_bed'  => $data['alloted_bed'],
        'added_by'  => Auth::id()
      ]);
      return 1;
    }else{

      IPDPatientWardTransfer::create([
        'patient_id'   => $data['patient_id'],
        'ipd_request_id'   => $ipd_id,
        'admit_date'   => (!empty($data['admit_date'])) ? date('Y-m-d',strtotime($data['admit_date']))." ".date('G:i:s'): '',
        'alloted_ward'  => $data['alloted_ward'],
        'alloted_bed'  => $data['alloted_bed'],
        'added_by'  => Auth::id()
      ]);

      $practice_detail = PracticeDetails::where(['user_id'=>2])->first();
      $patients = @$IPDPatientBed->IPDRequest->Patients;
      $pdf = PDF::loadView('ipd.printAdmissionSlip',compact('IPDPatientBed','practice_detail'));
      $output = $pdf->output();
      $docPath = 'uploads/PatientDocuments/'.$patients->patient_number.'/misc/';
      if(!is_dir($docPath)){
         File::makeDirectory($docPath, $mode = 0777, true, true);
      }
      if(!file_exists($docPath.'printAdmissionSlip.pdf')){
           File::copy(public_path().'/htmltopdfview.pdf', $docPath.'printAdmissionSlip.pdf');
      }
      file_put_contents("uploads/PatientDocuments/".$patients->patient_number."/misc/printAdmissionSlip.pdf", $output);
       // Session::flash('message', "Bed Alloted Successfully");
       return 1;


    }
     
      }
      return 2;
    }

   public function admitedPatients(Request $request){
   if ($request->isMethod('post'))
   {
       $params = array();
        if (!empty($request->input('from_date'))) {
            $params['from_date'] = base64_encode($request->input('from_date'));
        }
        if (!empty($request->input('to_date'))) {
            $params['to_date'] = base64_encode($request->input('to_date'));
        }
        if (!empty($request->input('patient_name'))) {
            $params['patient_name'] = base64_encode($request->input('patient_name'));
        }
        if (!empty($request->input('treatment_by'))) {
            $params['treatment_by'] = base64_encode($request->input('treatment_by'));
        }
        if (!empty($request->input('ward_name'))) {
            $params['ward_name'] = base64_encode($request->input('ward_name'));
        }
        return redirect()->route('ipd.admitedPatients',$params)->withInput();
    }
    else
    {
      $filters = array();
      //$practiceId = Parent::getMyPractice()->practice_id;
        $query =  IPDRequest::Where(['order_status'=> 1, 'delete_status' => 1,'status' => 1]);

        if ($request->input('from_date')  != '' || $request->input('to_date')  != '' || $request->input('patient_name')  != '' || $request->input('treatment_by')  != '' || $request->input('ward_name')  != '')
        {
          $from_date = date('Y-m-d',strtotime(base64_decode($request->input('from_date'))));
          $to_date = date('Y-m-d',strtotime(base64_decode($request->input('to_date'))));
          $patient_name = base64_decode($request->input('patient_name'));
          $treatment_by = base64_decode($request->input('treatment_by'));
          $ward_name = base64_decode($request->input('ward_name'));

          if ($request->input('from_date') != '') {
             $query->whereHas('IPDPatientBed', function($q) use ($from_date){$q->whereDate('created_at','>=',$from_date);});
          }
          if ($request->input('to_date') != '') {
             $query->whereHas('IPDPatientBed', function($q) use ($to_date){$q->whereDate('created_at','<=',$to_date);});
          }
          if ($request->input('patient_name') != '') {
            if (is_numeric($patient_name)){
              $query = $query->whereHas('Patients.PatientRagistrationNumbers', function($q) use($patient_name){$q->Where('reg_no', 'LIKE', '%'.$patient_name.'%'); });
            }
            else {
              $query = $query->whereHas('Patients', function($q) use($patient_name){$q->Where(DB::raw('concat(first_name," ",IFNULL(last_name,""))') , 'like', "%$patient_name%"); });
            }
          }
          if ($request->input('treatment_by') != '') {
             $query->whereHas('IPDPatientBed', function($q) use ($treatment_by) {$q->Where(['treatment_by'=>$treatment_by]);});
          }
          if ($request->input('ward_name') != '') {
            $query->whereHas('IPDPatientBed', function($q) use ($ward_name) {$q->Where(['alloted_ward'=>$ward_name]);});
          }
        }
        $wardRequests = $query->orderBy('id', 'desc')->paginate(10);
        $wards = IPDWards::where(['status' => 1,'delete_status' => 1])->orderBy('id', 'desc')->get();
      }
      // pr($wardRequests);
      return view('ipd.admitedPatients',compact('wardRequests','wards'));
    }

    public function wardTransferModal(Request $request)
    {
        $id = $request->id;
        $admitPatient = IPDRequest::Where('id',$id)->first();
        $ward_id = $admitPatient->IPDPatientBed->alloted_ward;
        $busyRooms = IPDRequest::Where(['order_status'=> 1, 'delete_status' => 1 ,'status' => 1])
        ->whereHas('IPDPatientBed', function($q)  use ($ward_id) {$q->Where('alloted_ward',$ward_id);})->get();
        $wards = IPDWards::where(['status' => 1,'delete_status' => 1])->orderBy('id', 'desc')->get();
        $patientCategory = BillingCategories::where('delete_status', '=', '1')->orderBy('name', 'ASC')->get();
        $busyRoom = array();
        foreach ($busyRooms as $key => $value) {
        $busyRoom[] = $value->IPDPatientBed->alloted_bed;
        }
        return view('ipd.ajaxpages.wardTransferModal',compact('admitPatient','wards','busyRooms','patientCategory','busyRoom'));
    }

    public function wardTransfer(Request $request){

        $practiceId = Parent::getMyPractice()->practice_id;
        if ($request->isMethod('post')) {
         $data = $request->all();
         $lastWard = IPDPatientBed::where('id', $data['ipd_bed_id'])->first();
         $ipd_id = $lastWard->ipd_request_id;
        if ($data['current_ward'] != $data['alloted_ward']) {
          $billableItem = BillableItem::where('ward_id', $data['alloted_ward'])->where('status', '1')->where('delete_status', '1')->where('added_by',$practiceId)->first();
		  if (!empty($billableItem) > 0) {
			$this->createBill($practiceId,$ipd_id,$data['patient_id'],$billableItem,"billable_item");
          }
		  // $itemPrice = $billableItem->price;

          /*if (count($billableItem) > 0) {
            $last_id = DB::table('ipd_patient_bills')->select('id')->orderBy('id', 'DESC')->first();
            if(!empty($last_id)){
              $transaction_id = substr($practiceId,0,1).substr(strtotime(date('d-m-Y h:i:s')),1,7).substr($last_id->id+1,0,1);
            }
            else{
              $transaction_id = substr($practiceId,0,1).substr(strtotime(date('d-m-Y h:i:s')),1,7).'1';
            }
            $last_bill_no = IPDPatientBills::where(['practice_id'=>$practiceId,'delete_status'=>1])->orderBy('bill_no', 'DESC')->first();
            $bill_number = 1;
            if(!empty($last_bill_no->bill_no)){
              $bill_number = $last_bill_no->bill_no+1;
            }
            else{
              $bill_number = 1;
            }
              $PatientBill =  IPDPatientBills::create([
                 'ipd_request_id'  => $ipd_id,
                 'pat_category'    => 1,
                 'package_category'=> 1,
                 'transaction_id'  => $transaction_id,
                 'bill_no'         => $bill_number,
                 'bill_date'       => date('Y-m-d H:i:s'),
                 'bill_collect_date' => date('Y-m-d H:i:s'),
                 'patient_id'      => $data['patient_id'],
                 'bill_amount'     => $itemPrice,
                 'tot_amount'      => $itemPrice,
                 'payed_amount'    => $itemPrice,
                 'balance_amount'  => $itemPrice,
                 'added_by'        => Auth::id(),
                 'practice_id'     => $practiceId
             ]);
              IPDRemainingPatientBills::create([
                'bill_id' => $PatientBill->id,
                'ipd_request_id' => $ipd_id,
                'paid_amount' => $itemPrice,
                'added_by'   => Auth::id(),
                'practice_id'   => $practiceId
            ]);
            IPDBilledItems::create([
              'bill_id'   => $PatientBill->id,
              'item_id'   => $billableItem->id,
              'charge_type' => 'billable_item',
              'qty'  => 1,
              'cost'  => $itemPrice,
              'discount_type'  => 'percent',
              'total_amount'  => $itemPrice
            ]);
      		   IPDBillingPayments::create([
      			   'bill_id' => $PatientBill->id,
      			   'ipd_request_id' => $ipd_id,
      			   'payment_mode' => 'Cash',
      			   'paid_amount' => $itemPrice,
      			   'added_by' => Auth::id(),
      			   'practice_id' => $practiceId
      			]);
          }*/
        }

      if ($data['current_ward'] != $data['alloted_ward']) {
        IPDPatientWardTransfer::create([
          'patient_id'   => $data['patient_id'],
          'ipd_request_id'   => $ipd_id,
          'admit_date'   => date('Y-m-d H:i:s'),
          'alloted_ward'  => $data['alloted_ward'],
          'alloted_bed'  => $data['alloted_bed'],
          'added_by'  => Auth::id()
        ]);
      }
         $wards =  IPDPatientBed::where('id', $data['ipd_bed_id'])->update(array(
           'alloted_ward'=>$data['alloted_ward'],
           'alloted_bed'=>$data['alloted_bed'],
           'treatment_by'=>$data['treatment_by'],
           'ward_note'=>$data['ward_note'],
         ));
    		Patients::where('id', $data['patient_id'] )->update(array(
          'pat_category' => $data['pat_category'],
          'aadhar_no' => $data['aadhar_no'],
          'bhamashah_no' => $data['bhamashah_no'],
    			'ration_card_no' => $data['ration_card_no'],
    		));
         Session::flash('message', "Bed Transferred Successfully");
         return 1;
      }
      return 2;
    }

    public function wardStatus(Request $request)
    {
        $busyRooms = IPDRequest::with('IPDWards')->Where(['order_status'=> 1, 'delete_status' => 1 ,'status' => 1])->get();
        $wards = IPDWards::where(['status' => 1,'delete_status' => 1])->orderBy('id', 'desc')->get();
        return view('ipd.wardStatus',compact('wards','busyRooms'));
    }

    public function dischargedPatients(Request $request){
    if ($request->isMethod('post'))
    {
        $params = array();
         if (!empty($request->input('from_date'))) {
             $params['from_date'] = base64_encode($request->input('from_date'));
         }
         if (!empty($request->input('to_date'))) {
             $params['to_date'] = base64_encode($request->input('to_date'));
         }
         if (!empty($request->input('patient_name'))) {
             $params['patient_name'] = base64_encode($request->input('patient_name'));
         }
         if (!empty($request->input('treatment_by'))) {
             $params['treatment_by'] = base64_encode($request->input('treatment_by'));
         }
         if (!empty($request->input('ward_name'))) {
             $params['ward_name'] = base64_encode($request->input('ward_name'));
         }
         return redirect()->route('ipd.dischargedPatients',$params)->withInput();
     }
     else
     {
       $filters = array();
       //$practiceId = Parent::getMyPractice()->practice_id;
         $query =  IPDRequest::Where(['order_status'=> 1, 'delete_status' => 1,'status' => 0]);

         if ($request->input('from_date')  != '' || $request->input('to_date')  != '' || $request->input('patient_name')  != '' || $request->input('treatment_by')  != '' || $request->input('ward_name')  != '')
         {
           $from_date = date('Y-m-d',strtotime(base64_decode($request->input('from_date'))));
           $to_date = date('Y-m-d',strtotime(base64_decode($request->input('to_date'))));
           $patient_name = base64_decode($request->input('patient_name'));
           $treatment_by = base64_decode($request->input('treatment_by'));
           $ward_name = base64_decode($request->input('ward_name'));

           if ($request->input('from_date') != '') {
              $query->whereHas('IPDDischarge', function($q) use ($from_date){$q->whereDate('created_at','>=',$from_date);});
           }
           if ($request->input('to_date') != '') {
              $query->whereHas('IPDDischarge', function($q) use ($to_date){$q->whereDate('created_at','<=',$to_date);});
           }
           if ($request->input('patient_name') != '') {
             if (is_numeric($patient_name)){
               $query = $query->whereHas('Patients.PatientRagistrationNumbers', function($q) use($patient_name){$q->Where('reg_no', 'LIKE', '%'.$patient_name.'%'); });
             }
             else {
               $query = $query->whereHas('Patients', function($q) use($patient_name){$q->Where(DB::raw('concat(first_name," ",IFNULL(last_name,""))') , 'like', "%$patient_name%"); });
             }
           }
           if ($request->input('treatment_by') != '') {
              $query->whereHas('IPDPatientBed', function($q) use ($treatment_by) {$q->Where(['treatment_by'=>$treatment_by]);});
           }
           if ($request->input('ward_name') != '') {
             $query->whereHas('IPDPatientBed', function($q) use ($ward_name) {$q->Where(['alloted_ward'=>$ward_name]);});
           }
         }
         $wardRequests = $query->orderBy('id', 'desc')->paginate(10);
         $wards = IPDWards::where(['status' => 1,'delete_status' => 1])->orderBy('id', 'desc')->get();
       }
       //pr($wardRequests->IPDPatientBed);
       return view('ipd.dischargedPatients',compact('wardRequests','wards'));
     }

     public function dischargedPatientPrint(Request $request)
        {
        if ($request->isMethod('post')) {
        $data = $request->all();
        $ipd_id = base64_decode($data['ipd_id']);
        $practiceId = Parent::getMyPractice()->practice_id;
        $practice_detail =  PracticeDetails::where(['user_id'=>$practiceId])->first();
        $ipd_patient_detail = IPDRequest::Where('id', '=', $ipd_id)->first();
        $ipd_discharge = IPDDischarge::Where(['ipd_request_id'=>$ipd_id])->orderBy('id','DESC')->first();
        $pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_id'=>$ipd_id,'delete_status'=>1])->get();
        $procedure = PatientProcedures::with(['Procedures'])->where('ipd_type','!=', '4')->where(['ipd_id'=>$ipd_id,'delete_status'=>1])->get();
        $treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_id'=>$ipd_id,'delete_status'=>1])->get();
        $labs =  PatientLabs::with(['Labs','LabOrders'])->where(['ipd_id'=>$ipd_id,'delete_status'=>1])->get();
         $docPath = 'uploads/PatientDocuments/'.$ipd_patient_detail->Patients->patient_number.'/ipd/';
          if(!is_dir($docPath)){
             File::makeDirectory($docPath, $mode = 0777, true, true);
          }
          if(!file_exists($docPath.'ipdDischargePrint.pdf')) {
               File::copy(public_path().'/htmltopdfview.pdf', $docPath.'ipdDischargePrint.pdf');
          }
          $pdf = PDF::loadView('ipd.pages.ipd_discharge_print',compact('practice_detail','ipd_patient_detail','ipd_discharge','pDiagnos','procedure','treatments','labs'));
          $output = $pdf->output();
          file_put_contents("uploads/PatientDocuments/".$ipd_patient_detail->Patients->patient_number."/ipd/ipdDischargePrint.pdf", $output);
          $arr = array('ipd_id'=>$ipd_patient_detail->id,'patient_email'=>$ipd_patient_detail->Patients->email,'p_phone'=>$ipd_patient_detail->Patients->mobile_no,'patient_number'=>$ipd_patient_detail->Patients->patient_number);
          return $arr;
        }
     }

     public function dischargeShare(Request $request)
     {
       $data = $request->all();
       $ipd_id = $data['ipd_id'];
       $practiceId = Parent::getMyPractice()->practice_id;
       $practice_detail =  PracticeDetails::where(['user_id'=>$practiceId])->first();
       $ipd_patient_detail = IPDRequest::Where('id', '=', $ipd_id)->first();
       $username = $ipd_patient_detail->Patients->first_name." ".$ipd_patient_detail->Patients->last_name;
		if(!empty($data['by'])){
			if($practice_detail->internet_connection == 1 && Parent::is_connected()==1 ) {
			 if (in_array("1", $data['by']) && !empty($data['email'])) {
			 $to = $data['email'];
			 $EmailTemplate = EmailTemplate::where('slug','dichargepatient')->first();
			 if($EmailTemplate)
			 {
			   $body = $EmailTemplate->description;
			   $docPath = 'uploads/PatientDocuments/'.$ipd_patient_detail->Patients->patient_number.'/ipd/ipdDischargePrint.pdf';
         $drName = 'Dr. '.ucwords(@$ipd_patient_detail->User->DoctorInfo->first_name).' '.ucwords(@$ipd_patient_detail->User->DoctorInfo->last_name);
         $mailMessage = str_replace(array('{{username}}','{{drname}}'),
         array($username,$drName),$body);
          $title = "Discharge Summary of  ".$username;
				   $datas = array('to' =>$to,'from' =>$practice_detail->email,'mailTitle'=>$title,'content'=>$mailMessage,'subject'=>$EmailTemplate->subject,'docPath'=>$docPath);
				   try{
				   Mail::send('emails.all', $datas, function( $message ) use ($datas)
				   {
						$message->to($datas['to'])->from( $datas['from'])->subject($datas['subject']);
						$message->attach($datas['docPath'], array(
						'as' => 'discharge',
						'mime' => 'application/pdf')
						);
					 });
					}
					catch(\Exception $e){
						   // Never reached
					}
			 }
			}
			 if (in_array("2", $data['by']) && !empty($data['mobile'])) {
				 //sms area
				 $message = urlencode("Dear ".$username.", Your Discharge Report sent Successfully on your email.");
				 $this->sendSMS($data["mobile"],$message);
			 }
		 }
         return 1;
       }
       return 2;
     }

	public function IPDClinicalNotes($id ,$vid = null) {
       $chiefComplaints = []; $pDiagnos = []; $treatments = []; $eyes = []; $labs = []; $patientDiagnosticImagings = []; $procedures = []; $pAllergies = []; $dentals = []; $examinations = []; $pVitals = [];
        $immunizations = []; $proce_order = [];  $pReferral = []; $patient_vitals = [];

       $appointment_id = base64_decode($id);
       $ipd = IPDRequest::Where(['appointment_id' => $appointment_id,'order_status' => 1,'delete_status' => 1])->orderBy('id','DESC')->first();
        $patient =  Appointments::where(['id'=>$appointment_id,'delete_status'=>1])->first();
       if(!empty($ipd)>0){
         $appointment_id = $ipd->appointment_id;
       }else {

         $ipd = IPDRequest::Where(['patient_id' => $patient->pId,'order_status' => 1,'delete_status' => 1])->orderBy('id','DESC')->first();
         if(!empty($ipd)>0){
           $appointment_id = $ipd->appointment_id;
         }
         else {
           return redirect()->route('ipd.index');
         }
       }
       if ($vid) {
         $appointment_id = base64_decode($vid);
       }
       $admitPatient = IPDRequest::Where(['appointment_id'=>$appointment_id,'order_status' => 1,'delete_status' => 1])->first();
       $ipd_request_id = $admitPatient->id;
  		if(checkIPDClinicalNoteModulePermission(17)) {
           $chiefComplaints =  ChiefComplaints::where(['ipd_type'=>1,'ipd_id'=>$ipd_request_id,'status' => 1])->first();
  		}
        if(checkIPDClinicalNoteModulePermission(18)) {
           $pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_type'=>1,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
        }
        if(checkIPDClinicalNoteModulePermission(20)) {
			$treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_type'=>1,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
        }
        if(checkIPDClinicalNoteModulePermission(21)) {
  			$eyes = PatientEyes::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();
  		}
       if(checkIPDClinicalNoteModulePermission(22)) {
			      $labs =  PatientLabs::with(['Labs','LabOrders'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
       }
       if(checkIPDClinicalNoteModulePermission(23)) {
         $patientDiagnosticImagings =  PatientDiagnosticImagings::with(['RadiologyMaster','RadiologyOrders'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
       }
       if(checkIPDClinicalNoteModulePermission(24)) {
         $procedures = PatientProcedures::with(['Procedures'])->where('ipd_type','!=', '4')->where(['ipd_id'=>$ipd_request_id,'procedure_type'=>'current','delete_status'=>1])->where(function ($query) {
         $query->where('order_date', '=', date("Y-m-d"))->orWhereNull('order_date');
         })->get();
       }
       if(checkIPDClinicalNoteModulePermission(25)) {
         $pAllergies= PatientAllergy::with(['Allergies'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
       }
       if(checkIPDClinicalNoteModulePermission(26)) {
         $dentals = PatientDentals::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
       }
       if(checkIPDClinicalNoteModulePermission(28)) {
         $examinations = PatientExaminations::with(['BodySites'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
       }
       if(checkIPDClinicalNoteModulePermission(29)) {
         $pVitals = PatientVitalss::where(['ipd_type'=>1,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->orderBy('id','DESC')->get();
       }
       if(checkIPDClinicalNoteModulePermission(30)) {
         $immunizations = PatientImmunizations::with(['Vaccine'])->where(['patient_id'=>$patient->pId,'delete_status'=>1])->get();
       }
       if(checkIPDClinicalNoteModulePermission(31)) {
         $proce_order = PatientProcedures::with(['Procedures'])->where('ipd_type','!=', '4')->where(['ipd_id'=>$ipd_request_id,'procedure_type'=>'order','status'=>0,'delete_status'=>1])->get();
       }
       if(checkIPDClinicalNoteModulePermission(32)) {
         $pReferral = PatientReferrals::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();
       }
	   $eyesExam  = PatientEyesExaminations::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();

       $item_categories = DB::table('item_category')->where('status','1')->get();
       $item_types = DB::table('item_type')->where('status', '1')->get();
       $item_routes = DB::table('item_route')->where('status', '1')->get();
       $company_names= CompanyName::where(['status'=>1])->get();
       $patient_vitals = PatientVitalss::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
       $wards = IPDWards::where(['status'=>1,'delete_status'=>1])->get();

      $patient_eom = PatientEom::with(['Eom'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $patient_sle = PatientSle::with(['Sle'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $patient_sys_ill = PatientSystematicIllness::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $patient_fundus = PatientFundus::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();
      $visualAcuityUcvaMaster = VisualAcuityUcvaMaster::orderBy('id','ASC')->get();
	    $PatientSleCanvas = PatientSleCanvas::where(['ipd_id'=>$ipd_request_id])->first();
      $ot_template = PatientOtTemplate::with("OtReportTemplate")->where(['ipd_type'=>1,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();
	    $ot_temp = OtReportTemplate::where(['status'=>1,'delete_status'=>1])->get();

	   //$favorite_list_items = DocFavorite::with(['FavoriteItems'=> function($q) {$q->whereNotNull('ipd_id');}])->where(["status"=>1])->get();
     $favorite_list_items = DocFavorite::whereHas('FavoriteItems', function($q) {$q->whereNotNull('ipd_id');})->where(["status"=>1])->get();


     $fav_arr_CC = array();
     $fav_arr_diagnosis = array();
     $fav_arr_treatment = array();
     $fav_arr_lab = array();
     $fav_arr_Di = array();
     $fav_arr_Procedure = array();
     $fav_arr_allergies = array();
     $fav_arr_Procedure_order = array();
     $fav_arr_examinations = array();
     $fav_arr_dentals = array();
     $fav_arr_sys = array();

     if(count($favorite_list_items) > 0) {
       foreach($favorite_list_items as $items){

           if($items->id == 1) {
             if(count($items->FavoriteItems) > 0){
               foreach($items->FavoriteItems as $fav){
                 $fav_arr_CC[] =  $fav->data;
               }
             }
           }
         else if($items->id == 2) {
           if(count($items->FavoriteItems) > 0){
             foreach($items->FavoriteItems as $fav){
               $fav_arr_diagnosis[] =  $fav->data_id;
             }
           }
         }
         else if($items->id == 3) {
           if(count($items->FavoriteItems) > 0){
             foreach($items->FavoriteItems as $fav){
               $fav_arr_treatment[] = $fav->data_id;
             }
           }
         }
         else if($items->id == 4) {
           if(count($items->FavoriteItems) > 0){
             foreach($items->FavoriteItems as $fav){
               $fav_arr_lab[] = $fav->data_id;
             }
             //dd($items->FavoriteItems);
           }
         }
         else if($items->id == 5) {
           if(count($items->FavoriteItems) > 0){
             foreach($items->FavoriteItems as $fav){
               $fav_arr_Di[] =  $fav->data_id;
             }
           }
         }
         else if($items->id == 6) {
           if(count ($items->FavoriteItems) > 0){
             foreach($items->FavoriteItems as $fav){
               $fav_arr_Procedure[] =  $fav->data_id;
             }
           }
         }
         else if($items->id == 7) {
           if(count($items->FavoriteItems)>0){
             foreach($items->FavoriteItems as $fav){
               $fav_arr_allergies[] =  $fav->data_id;
             }
           }
         }
         else if($items->id == 8) {
           if(count($items->FavoriteItems)>0){
             foreach($items->FavoriteItems as $fav){
               $fav_arr_Procedure_order[] = $fav->data_id;
             }
           }
         }
         else if($items->id == 9) {
           if(count($items->FavoriteItems) > 0){
             foreach($items->FavoriteItems as $fav){
               $fav_arr_examinations[] = $fav->data_id;
             }
           }
         }
         else if($items->id == 10) {
           if(count($items->FavoriteItems) > 0){
             foreach($items->FavoriteItems as $fav){
               $fav_arr_dentals[] =  $fav->data_id;
             }
           }
         }
		  else if($items->id == 12) {
              if(count($items->FavoriteItems) > 0){
                foreach($items->FavoriteItems as $fav){
                  $fav_arr_sys[] =  $fav->data;
                }
              }
            }
		}
     }
     return view('ipd.clinicalNotes',compact('admitPatient','chiefComplaints','treatments','labs','pAllergies','procedures','pDiagnos','pVitals','examinations','dentals','eyes','proce_order','immunizations','patientDiagnosticImagings','pReferral','item_categories','item_types','item_routes','company_names','patient_vitals','wards','fav_arr_CC','fav_arr_diagnosis','fav_arr_treatment','fav_arr_lab','fav_arr_Di','fav_arr_Procedure','favorite_list_items','fav_arr_allergies','fav_arr_Procedure_order','fav_arr_examinations','fav_arr_dentals','patient_eom','patient_sle','patient_sys_ill','patient_fundus','visualAcuityUcvaMaster','fav_arr_sys','eyesExam','PatientSleCanvas','patient','ot_template','ot_temp'));
    }

    public function patientDischarge($id){
      $ipd_request_id = base64_decode($id);
      $admitPatient = IPDRequest::Where('id', '=', $ipd_request_id)->first();
      $pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $procedures = PatientProcedures::with(['Procedures'])->where('ipd_type','!=', '4')->where(['ipd_id'=>$ipd_request_id,'procedure_type'=>'current','delete_status'=>1])->where(function ($query) {
          $query->where('order_date', '=', date("Y-m-d"))
        ->orWhereNull('order_date');
        })->get();
      $labs =  PatientLabs::with(['Labs','LabOrders'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();

      //$favorite_list_items = DocFavorite::with(['FavoriteItems'])->where(["status"=>1])->get();
      $favorite_list_items = DocFavorite::whereHas('FavoriteItems', function($q) {$q->whereNotNull('ipd_id');})->where(["status"=>1])->get();

      $fav_arr_CC = array();
      $fav_arr_diagnosis = array();
      $fav_arr_treatment = array();
      $fav_arr_lab = array();
      $fav_arr_Di = array();
      $fav_arr_Procedure = array();
      $fav_arr_allergies = array();
      $fav_arr_Procedure_order = array();
      $fav_arr_examinations = array();
      $fav_arr_dentals = array();

      if(count($favorite_list_items) > 0) {
        foreach($favorite_list_items as $items){

          if($items->id == 2) {
            if(count($items->FavoriteItems) > 0){
              foreach($items->FavoriteItems as $fav){
                $fav_arr_diagnosis[] =  $fav->data_id;
              }
            }
          }
          else if($items->id == 3) {
            if(count($items->FavoriteItems) > 0){
              foreach($items->FavoriteItems as $fav){
                $fav_arr_treatment[] = $fav->data_id;
              }
            }
          }
          else if($items->id == 4) {
            if(count($items->FavoriteItems) > 0){
              foreach($items->FavoriteItems as $fav){
                $fav_arr_lab[] = $fav->data_id;
              }
              //dd($items->FavoriteItems);
            }
          }
          else if($items->id == 6) {
            if(count ($items->FavoriteItems) > 0){
              foreach($items->FavoriteItems as $fav){
                $fav_arr_Procedure[] =  $fav->data_id;
              }
            }
          }
        }
      }
      return view('ipd.patientDischarge',compact('admitPatient','treatments','labs','procedures','pDiagnos','favorite_list_items','fav_arr_diagnosis','fav_arr_treatment','fav_arr_lab','fav_arr_Di','fav_arr_Procedure'));
     }
     public function pediatricPatientDischarge($id){
       $ipd_request_id = base64_decode($id);
       $admitPatient = IPDRequest::Where('id', '=', $ipd_request_id)->first();
       $pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_type'=>2,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
       $pAllergyHistory = PatientAllergyHistory::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
       $dischargeHistory = DischargeHistory::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
       $chiefComplaints =  ChiefComplaints::where(['ipd_type'=>2,'ipd_id'=>$ipd_request_id])->first();
       $pVital = PatientVitalss::where(['ipd_type'=>2,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();
       $ot_temp = OtReportTemplate::where(['status'=>1,'delete_status'=>1])->get();
       $ot_template = PatientOtTemplate::with("OtReportTemplate")->where(['ipd_type'=>2,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();
       $advise_template = PatientOtTemplate::with("OtReportTemplate")->where(['ipd_type'=>2,'type'=>'2','ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();
       $treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_type'=>2,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
       $IPDDischarge = IPDDischarge::where('ipd_request_id', $ipd_request_id)->first();
       $company_names= CompanyName::where(['status'=>1])->get();
	     $item_categories = DB::table('item_category')->where('status','1')->get();
	     $item_types = DB::table('item_type')->where('status', '1')->get();
       $DoctorsInfo= DoctorsInfo::select('first_name','last_name','id')->where(['discharge_view'=>1])->get();
       $doctorIfoids=[];
       if(isset($IPDDischarge->doctor_info_ids) && $IPDDischarge->doctor_info_ids!=''){

        $doctorIfoids=json_decode($IPDDischarge->doctor_info_ids,true);

       }
      
       
       //$favorite_list_items = DocFavorite::with(['FavoriteItems'])->where(["status"=>1])->get();
       $favorite_list_items = DocFavorite::whereHas('FavoriteItems', function($q) {$q->whereNotNull('ipd_id');})->where(["status"=>1])->get();

       $fav_arr_CC = array();
       $fav_arr_diagnosis = array();
       $fav_arr_treatment = array();
       $fav_arr_Di = array();
       $fav_arr_allergies = array();
       $fav_arr_dentals = array();
       $fav_arr_allergy_history = array();

       if(count($favorite_list_items) > 0) {
         foreach($favorite_list_items as $items){
           if($items->id == 1) {
             if(count($items->FavoriteItems) > 0){
               foreach($items->FavoriteItems as $fav){
                 $fav_arr_CC[] =  $fav->data;
               }
             }
           }
           if($items->id == 2) {
             if(count($items->FavoriteItems) > 0){
               foreach($items->FavoriteItems as $fav){
                 $fav_arr_diagnosis[] =  $fav->data_id;
               }
             }
           }
           if($items->id == 14) {
             if(count($items->FavoriteItems) > 0){
               foreach($items->FavoriteItems as $fav){
                 $fav_arr_allergy_history[] =  $fav->data;
               }
             }
           }
           else if($items->id == 3) {
             if(count($items->FavoriteItems) > 0){
               foreach($items->FavoriteItems as $fav){
                 $fav_arr_treatment[] = $fav->data_id;
               }
             }
           }
         }
       }

       return view('ipd.pediatricPatientDischarge',compact('admitPatient','item_types','item_categories','company_names','IPDDischarge','chiefComplaints','treatments','pDiagnos','favorite_list_items','fav_arr_diagnosis','fav_arr_CC','fav_arr_treatment','pAllergyHistory','fav_arr_allergy_history','dischargeHistory','ot_template','advise_template','pVital','ot_temp','DoctorsInfo','doctorIfoids'));
      }
      public function neonatologyPatientDischarge($id){
        $ipd_request_id = base64_decode($id);
        $admitPatient = IPDRequest::Where('id', '=', $ipd_request_id)->first();
        $pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_type'=>3,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
        $dischargeHistory = DischargeHistory::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
        $chiefComplaints =  ChiefComplaints::where(['ipd_type'=>3,'ipd_id'=>$ipd_request_id])->first();
        $NeonatologyHistory =  NeonatologyHistory::where(['ipd_type'=>3,'ipd_id'=>$ipd_request_id])->first();
        $MeternalHistory =  MeternalHistory::where(['ipd_type'=>3,'ipd_id'=>$ipd_request_id])->first();
        $NeonatologyManagement =  NeonatologyManagement::where(['ipd_type'=>3,'ipd_id'=>$ipd_request_id])->first();
        $NeonatologyTreatment =  NeonatologyTreatment::where(['ipd_type'=>3,'ipd_id'=>$ipd_request_id])->first();
        $BornChecklist =  BornChecklist::where(['ipd_type'=>3,'ipd_id'=>$ipd_request_id])->first();
        $treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_type'=>3,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
        $labs =  PatientLabs::with(['Labs','LabOrders'])->where(['ipd_type'=>3,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
        $company_names= CompanyName::where(['status'=>1])->get();

        $ot_template = PatientOtTemplate::with("OtReportTemplate")->where(['ipd_type'=>3,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();
        $IPDDischarge = IPDDischarge::where('ipd_request_id', $ipd_request_id)->first();
        $item_categories = DB::table('item_category')->where('status','1')->get();
        $item_types = DB::table('item_type')->where('status', '1')->get();
        $item_routes = DB::table('item_route')->where('status', '1')->get();
        $DoctorsInfo= DoctorsInfo::select('first_name','last_name','id')->where(['discharge_view'=>1])->get();
        $doctorIfoids=[];
        if(isset($IPDDischarge->doctor_info_ids) && $IPDDischarge->doctor_info_ids!=''){
 
         $doctorIfoids=json_decode($IPDDischarge->doctor_info_ids,true);
 
        }
        //$favorite_list_items = DocFavorite::with(['FavoriteItems'])->where(["status"=>1])->get();
        $favorite_list_items = DocFavorite::whereHas('FavoriteItems', function($q) {$q->whereNotNull('ipd_id');})->where(["status"=>1])->get();

        $fav_arr_CC = array();
        $fav_arr_diagnosis = array();
        $fav_arr_treatment = array();
          $fav_arr_lab = array();

        if(count($favorite_list_items) > 0) {
          foreach($favorite_list_items as $items){
            if($items->id == 1) {
              if(count($items->FavoriteItems) > 0){
                foreach($items->FavoriteItems as $fav){
                  $fav_arr_CC[] =  $fav->data;
                }
              }
            }
            if($items->id == 2) {
              if(count($items->FavoriteItems) > 0){
                foreach($items->FavoriteItems as $fav){
                  $fav_arr_diagnosis[] =  $fav->data_id;
                }
              }
            }
            else if($items->id == 3) {
              if(count($items->FavoriteItems) > 0){
                foreach($items->FavoriteItems as $fav){
                  $fav_arr_treatment[] = $fav->data_id;
                }
              }
            }
            else if($items->id == 4) {
              if(count($items->FavoriteItems) > 0){
                foreach($items->FavoriteItems as $fav){
                  $fav_arr_lab[] = $fav->data_id;
                }
              }
            }
          }
        }

        return view('ipd.neonatologyPatientDischarge',compact('admitPatient','IPDDischarge','chiefComplaints','treatments','pDiagnos','labs','favorite_list_items','fav_arr_diagnosis','fav_arr_CC','fav_arr_treatment','fav_arr_lab','ot_template','dischargeHistory','NeonatologyHistory','MeternalHistory','NeonatologyManagement','NeonatologyTreatment','BornChecklist','company_names','item_categories','item_types','item_routes','DoctorsInfo','doctorIfoids'));
    }


   public function admitDesk(Request $request){
      $wards = IPDWards::where(['status' => 1,'delete_status' => 1])->orderBy('id', 'desc')->get();
      return view('ipd.admitDesk',compact('wards'));
    }

    public function saveDischarge(Request $request) {
          if($request->isMethod('post')) {
            $data = $request->all();
            if(!empty($data['ipd_id'])) {
              if(!isset($data['id'])) {
                 $ipd_discharge =  IPDDischarge::create([
                     'ipd_request_id' =>  $data['ipd_id'],
                     'brief_summary' =>  $data['brief_summary'],
                     'operativefinding' =>  json_encode($data['operativefinding']),
                     'follow_up' =>  (isset($data['follow_up']) ? date('Y-m-d',strtotime($data['follow_up'])) : null),
                     'discharge_diet' =>  $data['discharge_diet'],
                     'outcome' =>  $data['outcome'],
                     'discharge_note'=>  $data['discharge_note'],
                   ]);
                   //to change the status for discharged Patient
                   IPDRequest::where('id', $data['ipd_id'])->update(array('status' => 0));
              }
              else{
                  IPDDischarge::where('id', $data['id'])->update(array('ipd_request_id' =>  $data['ipd_id'],
                  'brief_summary' =>  $data['brief_summary'],
                  'operativefinding' => json_encode($data['operativefinding']),
                  'follow_up' =>  date('Y-m-d',strtotime($data['follow_up'])),
                  'discharge_diet' =>  $data['discharge_diet'],
                  'outcome' =>  $data['outcome'],
                  'discharge_note'=>  $data['discharge_note'],
                  'created_at' => date('Y-m-d H:i:s')
                  ));

                  $ipd_discharge = IPDDischarge::where('id', $data['id'])->first();
              }

              $ipd_patient_detail = IPDRequest::Where('id', '=', $data['ipd_id'])->first();
              $pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
              $procedure = PatientProcedures::with(['Procedures'])->where('ipd_type','!=', '4')->where(['ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
              $treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
              $labs =  PatientLabs::with(['Labs','LabOrders'])->where(['ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
              $practice_detail =  PracticeDetails::where(['user_id'=>2])->first();
               $docPath = 'uploads/PatientDocuments/'.$ipd_patient_detail->Patients->patient_number.'/ipd/';
                if(!is_dir($docPath)){
                   File::makeDirectory($docPath, $mode = 0777, true, true);
                }
                if(!file_exists($docPath.'ipdDischargePrint.pdf')) {
                     File::copy(public_path().'/htmltopdfview.pdf', $docPath.'ipdDischargePrint.pdf');
                }
                $pdf = PDF::loadView('ipd.pages.ipd_discharge_print',compact('practice_detail','ipd_patient_detail','ipd_discharge','pDiagnos','procedure','treatments','labs'));
               $output = $pdf->output();
                file_put_contents("uploads/PatientDocuments/".$ipd_patient_detail->Patients->patient_number."/ipd/ipdDischargePrint.pdf", $output);
               return 1;
            }
       }
   }

    public function createChiefComplaints(Request $request) {
      if($request->isMethod('post')) {
        $data = $request->all();
        if(!empty($data['chiefComplaints'])){
          $this->AddToFavoriteList($data);
          $user = Auth::id();
          if(!isset($data['chiefId'])) {
             ChiefComplaints::create([
                 'appointment_id' =>  $data['appointment_id'],
                 'ipd_id' =>  $data['ipd_id'],
				 'ipd_type' =>  $data['ipd_type'],
                 'pId' =>  $data['patient_id'],
                 'data'=>  json_encode($data['chiefComplaints']),
                 'added_by' => $user
               ]);
          }
          else{
              ChiefComplaints::where('id', $data['chiefId'])->update(array('appointment_id' =>  $data['appointment_id'],
                'ipd_id' =>  $data['ipd_id'],
                'pId' =>  $data['patient_id'],
                'data'=>  json_encode($data['chiefComplaints'])
              ));
          }
        }
       return 1;
       }
   }

   public function createPatientDiagnosis(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();
            $this->AddToFavoriteList($data);
            $practiceId = Parent::getMyPractice();
            if (!empty($data['diagnosis']))
            {
                foreach ($data['diagnosis'] as $diagnosis)
                {
                    if (isset($diagnosis['id']))
                    {
                        PatientDiagnosis::where('id', $diagnosis['id'])->update(array(
                            'appointment_id' => $data['appointment_id'],
                            'ipd_id' => $data['ipd_id'],
                            'patient_id' => $data['patient_id'],
                            // 'diagnosis_eye' => $diagnosis['diagnosis_eye'],
                            'diagnosis_id' => $diagnosis['diagnosis_id'],
                            //'onset' => strtotime($diagnosis['onset']),
                            'notes' => $diagnosis['notes'],
                            'added_by' => $practiceId->practice_id
                        ));
                    }
                    else
                    {
                        if (!empty($diagnosis['diagnosis_id']))
                        {
                            PatientDiagnosis::create(['appointment_id' => $data['appointment_id'], 'ipd_id' => $data['ipd_id'], 'patient_id' => $data['patient_id'],
                            // 'diagnosis_eye' => $diagnosis['diagnosis_eye'],
                            'diagnosis_id' => $diagnosis['diagnosis_id'],
                            //'onset' => strtotime($diagnosis['onset']),
                            'notes' => $diagnosis['notes'], 'added_by' => $practiceId->practice_id]);
                        }
                    }
                }
            }
            return 1;
        }
    }

    public function createMedications(Request $request) {
    if ($request->isMethod('post')) {
         $data = $request->all();
         $this->AddToFavoriteList($data);
         $practiceId = Parent::getMyPractice();
           if(!empty($data['madication'])){
             $orderId='';
             // if(empty($data['order_id'])){
             if ($data['ipd_type'] == 1) {
               if(isset($data['new_row'])) {
       				  $order = MedicineOrders::create([
       				  'appointment_id'=>$data['appointment_id'],
       				  'ipd_id' =>  $data['ipd_id'],
       				  'patient_id'=>$data['patient_id'],
       				  'order_by' => $data['doc_id'],
       				  'doctor_type' => 1,
       				  'practice_id' => $practiceId->practice_id
       				  ]);
       				  $orderId = $order->id;
       				}
             }
            // }
           // else{
               // $orderId = trim($data['order_id']);
            // }
             foreach($data['madication'] as $med){
             if(!empty($med['med_id'])){
                PatientMedications::where('id', $med['med_id'])->update(array('appointment_id' => $data['appointment_id'],
                'patient_id'=>$data['patient_id'],
                'drug_id' => $med['drug_id'],
                'strength' => $med['strength'],
                'strength_id' => $med['strength_id'],
                'unit' => $med['unit'],
                'quantity' => (isset($med['qty']) ? $med['qty'] : null),
                'medi_for' => (isset($med['medi_for']) ? $med['medi_for'] : null),
                'frequency' => $med['frequency'],
                'frequency_type' => $med['frequency_type'],
                // 'route' => $med['route'],
                'duration' => $med['duration'],
                'duration_type' => $med['duration_type'],
                'medi_instruc' => $med['medi_instruc'],
                'notes' => $med['notes']
                ));
             }
         else{
             if(!empty($med['drug_id'])){
                  PatientMedications::create([
                  'appointment_id'=>$data['appointment_id'],
                  'ipd_id' =>  $data['ipd_id'],
				  'ipd_type' =>  $data['ipd_type'],
                  'patient_id'=>$data['patient_id'],
                  'drug_id' => $med['drug_id'],
                  'strength' => $med['strength'],
                  'strength_id' => $med['strength_id'],
                  'unit' => $med['unit'],
                  'quantity' => (isset($med['qty']) ? $med['qty'] : null),
                  'medi_for' => (isset($med['medi_for']) ? $med['medi_for'] : null),
                  'frequency' => $med['frequency'],
                  'frequency_type' => $med['frequency_type'],
                  // 'route' => $med['route'],
                  'duration' => $med['duration'],
                  'duration_type' => $med['duration_type'],
                  'medi_instruc' => $med['medi_instruc'],
                   'notes' => $med['notes'],
                   'order_id' => $orderId,
                  'added_by' => Auth::id()
                  ]);
                   }
               }
             }
         }
       return 1;
      }
    }
   //load container of current medication
   public function currentMedications($id)
    {
        // echo $id;
        $medications =  PatientMedications::with(['ItemDetails'])->where(['patient_id'=>$id,'delete_status'=>1])->paginate(8);
       // echo "<pre>"; print_r($medications);die;
        return view('emr.ajaxloadPages.current_medication',compact('medications'));
    }

  public function createPatientLabs(Request $request) {
    if($request->isMethod('post')) {
      $data = $request->all();
      $practiceId = Parent::getMyPractice()->practice_id;
      if(!empty($data['labs'])){
        $orderId='';
        $order="";
        if ($data['ipd_type'] == 1) {
          if(isset($data['new_row'])){
           $order = LabOrders::create([
               'appointment_id'=> $data['appointment_id'],
             'ipd_id' =>  $data['ipd_id'],
             'patient_id'=> $data['patient_id'],
             'order_by' => $data['doc_id'],
             'doctor_type' => 1,
             'practice_id' => $practiceId
           ]);
           $orderId = $order->id;
          }
        }
        $lab_array = array();
        foreach($data['labs'] as $lab){
          if(isset($lab['id'])) {
            if($lab['lab_pack_id']!=1)
            {
            $lab_name = $lab['title'];
            $labs = Labs::where(['title'=>$lab_name,'delete_status'=>1,'status' => 1,'added_by' => $practiceId])->first();
            if($labs){
              $lab_id = $labs->id;
            }
            else {
              $did = $lab['lab_id'];
              $defaultLabs = DefaultLabs::where(['id' => $did])->first();
              if($defaultLabs->component==1) {
                $createLab =  Labs::create([
                  'title' => $defaultLabs->title,
                  'short_name' => $defaultLabs->short_name,
                  'data_type' => $defaultLabs->data_type,
                  'num_high_value' => $defaultLabs->num_high_value,
                  'num_low_value' => $defaultLabs->num_low_value,
                  'unit' => $defaultLabs->unit,
                  'component' => $defaultLabs->component,
                  'results' => $defaultLabs->results,
                  'added_by' => $practiceId
                ]);
                $subLabs = SubLabs::where(['delete_status'=>1,'added_by'=>0,'lab_id' => $did])->get();
                if($subLabs){
                  foreach ($subLabs as $slabs) {
                    if($slabs->data_type==''){$data_type = 'tex';}else{$data_type = $slabs->data_type;}
                    $createSubLabs =  SubLabs::create([
                      'lab_id' => $createLab->id,
                      'title' => $slabs->title,
                      'short_name' => $slabs->short_name,
                      'data_type' => $data_type,
                      'num_high_value' => $slabs->num_high_value,
                      'num_low_value' => $slabs->num_low_value,
                      'unit' => $slabs->unit,
                      'results' => $slabs->results,
                      'added_by' => $practiceId
                    ]);
                  }
                }
              }
              else {
                if($defaultLabs->data_type==''){$data_type = 'tex';}else{$data_type = $defaultLabs->data_type;}
                $createLab =  Labs::create([
                'title' => $defaultLabs->title,
                'short_name' => $defaultLabs->short_name,
                'data_type' => $data_type,
                'num_high_value' => $defaultLabs->num_high_value,
                'num_low_value' => $defaultLabs->num_low_value,
                'unit' => $defaultLabs->unit,
                'component' => $defaultLabs->component,
                'results' => $defaultLabs->results,
                'added_by' => $practiceId
                 ]);
              }
              $lab_id = $createLab->id;
            }
            PatientLabs::where('id', $lab['id'])->update(array(
              'appointment_id'=>$data['appointment_id'],
              'patient_id'=>$data['patient_id'],
              'ipd_id' =>  $data['ipd_id'],
              'lab_id' => $lab_id,
              'instructions' => $lab['instructions']
            ));
            $lab['lab_id'] = $lab_id;
            //loop of Package Start
          }
       else {
          PatientLabs::where('pack_id', $lab['lab_id'])->update(array(
            'instructions' => $lab['instructions']
              ));
            }
          }
          else{

            if($lab['lab_pack_id'] != 1)
            {
            if(!empty($lab['title'])){
              $lab_name = $lab['title'];
              $labs = Labs::where(['title'=>$lab_name,'delete_status'=>1,'status' => 1,'added_by' => $practiceId])->first();
              if($labs) {
                $lab_id = $labs->id;
              }
              else {
                $did = $lab['lab_id'];
                $defaultLabs = DefaultLabs::where(['id' => $did])->first();
                if($defaultLabs->component==1) {
                  $createLab =  Labs::create([
                    'title' => $defaultLabs->title,
                    'short_name' => $defaultLabs->short_name,
                    'data_type' => $defaultLabs->data_type,
                    'num_high_value' => $defaultLabs->num_high_value,
                    'num_low_value' => $defaultLabs->num_low_value,
                    'unit' => $defaultLabs->unit,
                    'component' => $defaultLabs->component,
                    'results' => $defaultLabs->results,
                    'added_by' => $practiceId
                  ]);
                  $subLabs = SubLabs::where(['delete_status'=>1,'added_by'=>0,'lab_id' => $did])->get();
                  if($subLabs){
                    foreach ($subLabs as $slabs) {
                      if($slabs->data_type==''){$data_type = 'tex';}else{$data_type = $slabs->data_type;}
                      $createSubLabs =  SubLabs::create([
                        'lab_id' => $createLab->id,
                        'title' => $slabs->title,
                        'short_name' => $slabs->short_name,
                        'data_type' => $data_type,
                        'num_high_value' => $slabs->num_high_value,
                        'num_low_value' => $slabs->num_low_value,
                        'unit' => $slabs->unit,
                        'results' => $slabs->results,
                        'added_by' => $practiceId
                      ]);
                    }
                  }
                }
                else {
                  if($defaultLabs->data_type==''){$data_type = 'tex';}else{$data_type = $defaultLabs->data_type;}
                  $createLab =  Labs::create([
                    'title' => $defaultLabs->title,
                    'short_name' => $defaultLabs->short_name,
                    'data_type' => $data_type,
                    'num_high_value' => $defaultLabs->num_high_value,
                    'num_low_value' => $defaultLabs->num_low_value,
                    'unit' => $defaultLabs->unit,
                    'component' => $defaultLabs->component,
                    'results' => $defaultLabs->results,
                    'added_by' => $practiceId
                   ]);
                }
                $lab_id = $createLab->id;
              }
              $lab['lab_id'] = $lab_id;
              //end lab create
              $patientLabs =PatientLabs::create([
                'appointment_id'=>$data['appointment_id'],
                'ipd_id' =>  $data['ipd_id'],
                'ipd_type' =>  $data['ipd_type'],
                'patient_id'=>$data['patient_id'],
                'lab_id' => $lab_id,
                'instructions' => $lab['instructions'],
                'order_id' => $orderId,
                'added_by' => $practiceId
              ]);
              $labs = Labs::where('id',$lab_id)->first();
              foreach($labs->SubLabs as $subLabs){
                PatientSubLabs::create([
                  'parent_id'=>$patientLabs->id,
                  'lab_id' => $lab_id,
                  'sub_lab_id' => $subLabs->id,
                  'order_id' => $patientLabs->order_id,
                  'added_by' => $practiceId
                ]);
              }
            }
          }else {
            $lab_pack = LabPack::where('id',$lab['lab_id'])->first();
            $array = explode(',',$lab_pack->lab_ids); //split string into array seperated by ', '
            foreach($array as $value) //loop over values
            {
              $labs = Labs::where(['id'=>$value,'added_by' => $practiceId])->first();
              if($labs)
              {
                $lab_id = $labs->id;
              }
              $patientLabs = PatientLabs::create([
              'appointment_id'=>$data['appointment_id'],
              'ipd_id' =>  $data['ipd_id'],
              'ipd_type' =>  $data['ipd_type'],
              'patient_id'=>$data['patient_id'],
              'pack_status' => $lab['lab_pack_id'],
              'pack_id' => $lab['lab_id'],
              'lab_id' => $lab_id,
              'instructions' => $lab['instructions'],
              'order_id' => $orderId,
              'added_by' => $practiceId,
              ]);
              //$labs = Labs::where(['id'=>$lab['lab_id'],'added_by' => $practiceId)])->first();
              $subLabss = SubLabs::where(['added_by' => $practiceId,'lab_id' => $lab_id,'delete_status'=>1])->get();
              foreach($subLabss as $subLabs)
              {
                PatientSubLabs::create([
                'appointment_id'=>$data['appointment_id'],
                'parent_id'=>$patientLabs->id,
                'lab_id' => $patientLabs->lab_id,
                'sub_lab_id' => $subLabs->id,
                'order_id' => $patientLabs->order_id,
                'added_by' => $practiceId,
                ]);
              }
            }
          }
          }
          $lab_array[] = $lab;
        }
        $data['labs'] = $lab_array;
        $this->AddToFavoriteList($data);
      }
          return 1;
      }
  }

     public function createPatientEoms(Request $request) {
    if($request->isMethod('post')) {
      $data = $request->all();
      // pr($data);
      $practiceId = Parent::getMyPractice();
      if(!empty($data['eom'])){
          foreach($data['eom'] as $eomData){
          if(isset($eomData['id'])){
            PatientEom::where('id', $eomData['id'])->update(array('appointment_id'=>$data['appointment_id'],
            'patient_id'=>$data['patient_id'],
            'eom_id' => $eomData['eom_id'],
            'eom_type' => $eomData['eom_type']
            ));
          }
          else{
            $PatientEom =PatientEom::create([
              'appointment_id'=>$data['appointment_id'],
              'patient_id'=>$data['patient_id'],
              'ipd_id' =>  $data['ipd_id'],
              'eom_id' => $eomData['eom_id'],
              'eom_type' => $eomData['eom_type'],
              'added_by' => Auth::id()
            ]);
          }
        }
        return 1;
      }
         return 2;
        }
    }

  public function createPatientSle(Request $request) {
		if($request->isMethod('post')) {
			$data = $request->all();
			   //pr($data);
			  $practiceId = Parent::getMyPractice();
			  if(isset($data['canvas_img'])){
				if($data['sleImgType'] == 'base64'){
					$path = 'uploads/PatientDocuments/'.$data['patient_number'].'/eye/';
					if(!is_dir($path)){
						File::makeDirectory($path, $mode = 0777, true, true);
					}
					$sleCanvaseye = $data['canvas_img'];  // your base64 encoded
					$sleCanvaseye = str_replace('data:image/png;base64,', '', $sleCanvaseye);
					$sleCanvaseye = str_replace(' ', '+', $sleCanvaseye);
					$sleCanvaseyeName = time().$data['patient_number'].'Sle.'.'png';
				}

			   // pr($data);
				if(isset($data['sleCanvas_id'])) {
						if($data['sleImgType'] == 'base64'){
						  $sleEye = $path.$data['canvas_img'];
						  $sleEye2 = $path.$data['sleImgUrl'];
						  File::delete($sleEye2);
						  //unlink($sleEye2);
						  File::put($path.$sleCanvaseyeName, base64_decode($sleCanvaseye));
						  PatientSleCanvas::where('id', $data['sleCanvas_id'])->update(array('appointment_id'=>$data['appointment_id'],
						  'patient_id'=>$data['patient_id'],
						  'canvas_img' => $sleCanvaseyeName,
						  ));
						}else{
						  PatientSleCanvas::where('id', $data['sleCanvas_id'])->update(array('appointment_id'=>$data['appointment_id'],
						  'patient_id'=>$data['patient_id']
						  ));
						}
				}else{
					File::put($path.$sleCanvaseyeName, base64_decode($sleCanvaseye));
					$PatientSle =PatientSleCanvas::create([
						'appointment_id'=>$data['appointment_id'],
						'ipd_id'=>$data['ipd_id'],
						'patient_id'=>$data['patient_id'],
						'canvas_img' => $sleCanvaseyeName,
						'added_by' => Auth::id()
					  ]);
				}
			  }

			  if(!empty($data['sle'])){
				  foreach($data['sle'] as $sleData){
				  if(isset($sleData['id'])){
					PatientSle::where('id', $sleData['id'])->update(array('appointment_id'=>$data['appointment_id'],
          'patient_id'=>$data['patient_id'],
					// 'sle_eye'=>$sleData['sle_eye'],
					'sle_id' => $sleData['sle_id'],
					'notes' => $sleData['notes']
					));
				  }
				  else{
					if(!empty($sleData['sle_name'])){
					  $PatientSle = PatientSle::create([
						'appointment_id'=>$data['appointment_id'],
						'ipd_id'=>$data['ipd_id'],
						'patient_id'=>$data['patient_id'],
            // 'sle_eye'=>$sleData['sle_eye'],
						'sle_id' => $sleData['sle_id'],
						'notes' => $sleData['notes'],
						'added_by' => Auth::id()
					  ]);
					}
				  }
				}
				return 1;
			  }
         return 2;
        }
    }
  public function createPatientSysIllness(Request $request) {
    if($request->isMethod('post')) {
      $data = $request->all();
      // pr($data);
	  $this->AddToFavoriteList($data);
      $practiceId = Parent::getMyPractice();
      if(!empty($data['sysIll'])){
          foreach($data['sysIll'] as $sys){
          if(isset($sys['id'])){
            PatientSystematicIllness::where('id', $sys['id'])->update(array('appointment_id'=>$data['appointment_id'],
            'patient_id'=>$data['patient_id'],
            'notes' => $sys['notes']
            ));
          }
          else{
            if(!empty($sys['notes'])){
              $PatientSystematicIllness = PatientSystematicIllness::create([
                'appointment_id'=>$data['appointment_id'],
                'ipd_id' =>  $data['ipd_id'],
                'patient_id'=>$data['patient_id'],
                'notes' => $sys['notes'],
                'added_by' => Auth::id()
              ]);
            }
          }
        }
        return 1;
      }
         return 2;
        }
    }


	public function createPatientFundus(Request $request) {
    if($request->isMethod('post')) {
      $data = $request->all();
      // pr($data);
      // pr(json_encode($data['fundus_exam']));
      $path = 'uploads/PatientDocuments/'.$data['patient_number'].'/eye/';
      if(!is_dir($path)){
          File::makeDirectory($path, $mode = 0777, true, true);
      }
      $fundus_img_right_eye = $data['fundus_img_right_eye'];  // your base64 encoded
      $fundus_img_right_eye = str_replace('data:image/png;base64,', '', $fundus_img_right_eye);
      $fundus_img_right_eye = str_replace(' ', '+', $fundus_img_right_eye);
      $fundus_img_right_eyeName = time().$data['patient_number'].'R.'.'png';

      $fundus_img_left_eye = $data['fundus_img_left_eye'];  // your base64 encoded
      $fundus_img_left_eye = str_replace('data:image/png;base64,', '', $fundus_img_left_eye);
      $fundus_img_left_eye = str_replace(' ', '+', $fundus_img_left_eye);
      $fundus_img_left_eyeName = time().$data['patient_number'].'L.'.'png';


      $practiceId = Parent::getMyPractice();
      if(isset($data['id'])){
              $rightEye = $path.$data['fundus_img_right_eye_old'];
              $leftEye = $path.$data['fundus_img_left_eye_old'];
              if(file_exists($rightEye)){
                  File::delete($rightEye);
              }
              if(file_exists($leftEye)){
                  File::delete($leftEye);
              }
          File::put($path.$fundus_img_right_eyeName, base64_decode($fundus_img_right_eye));
          File::put($path.$fundus_img_left_eyeName, base64_decode($fundus_img_left_eye));
          PatientFundus::where('id', $data['id'])->update(array('appointment_id'=>$data['appointment_id'],
            'appointment_id'=>$data['appointment_id'],
            'patient_id'=>$data['patient_id'],
            'fundus_img_check'=> (isset($data['fundus_img_check']) ? $data['fundus_img_check'] : ''),
            'fundus_img_right_eye' => $fundus_img_right_eyeName,
            'fundus_right_eye_note' => $data['fundus_right_eye_note'],
            'fundus_img_left_eye' => $fundus_img_left_eyeName,
            'fundus_left_eye_note' => $data['fundus_left_eye_note']
          ));
      }
      else{

          File::put($path.$fundus_img_right_eyeName, base64_decode($fundus_img_right_eye));
          File::put($path.$fundus_img_left_eyeName, base64_decode($fundus_img_left_eye));
          $PatientFundus = PatientFundus::create([
            'appointment_id'=>$data['appointment_id'],
            'patient_id'=>$data['patient_id'],
			'ipd_id' =>  $data['ipd_id'],
            'fundus_img_right_eye' => $fundus_img_right_eyeName,
            'fundus_right_eye_note' => $data['fundus_right_eye_note'],
            'fundus_img_left_eye' => $fundus_img_left_eyeName,
            'fundus_left_eye_note' => $data['fundus_left_eye_note'],
            'added_by' => Auth::id()
          ]);
      }
      return 1;
        }
    }


   //DI Imaging code insert updateEyeModal
   public function createPatientDiagnosticImagings(Request $request)
   {
   if ($request->isMethod('post')) {
        $data = $request->all();
        $this->AddToFavoriteList($data);
        $practiceId = Parent::getMyPractice();
        if(!empty($data['patientDiagnosticImagings'])){
          $orderId='';
          //for create multiple lab orders this is set to null all the time
          $data['order_id'] = "";
          // if(empty($data['order_id'])){
              if(isset($data['new_row'])){
              $order = RadiologyOrders::create([
              'appointment_id'=>$data['appointment_id'],
              'ipd_id' =>  $data['ipd_id'],
              'patient_id'=>$data['patient_id'],
              'order_by' => $data['doc_id'],
              'doctor_type' => 1,
              'practice_id' => $practiceId->practice_id,
              ]);
              $orderId = $order->id;
            }
          // }else{
            // $orderId = trim($data['order_id']);
          // }

          foreach($data['patientDiagnosticImagings'] as $patientDiagnosticImaging){
          if(isset($patientDiagnosticImaging['id'])){
          PatientDiagnosticImagings::where('id', $patientDiagnosticImaging['id'])->update(array('appointment_id'=>$data['appointment_id'],
          'ipd_id' =>  $data['ipd_id'],
          'patient_id'=>$data['patient_id'],
          'lab_id' => $patientDiagnosticImaging['lab_id'],
          'instructions' => $patientDiagnosticImaging['instructions']
          ));
          }else{
          if(!empty($patientDiagnosticImaging['title'])){
          PatientDiagnosticImagings::create([
          'appointment_id'=>$data['appointment_id'],
          'ipd_id' =>  $data['ipd_id'],
          'patient_id'=>$data['patient_id'],
          'lab_id' => $patientDiagnosticImaging['lab_id'],
          'instructions' => $patientDiagnosticImaging['instructions'],
          'order_id' => $orderId,
          'added_by' => Auth::id(),
          ]);
          }
          }
      }
  }
         return 1;
        }

    }

    public function createPatientProcedures(Request $request)
   {
   if ($request->isMethod('post')) {
         $data = $request->all();
         // dd($data);
         $this->AddToFavoriteList($data);
        // echo "<pre>";
        // print_r($data);
         $practiceId = Parent::getMyPractice();
        // $user = Auth::id();
         $status = 1;
         // pr($data);
         if(!empty($data['procedures'])){
              foreach($data['procedures'] as $procedure) {
                            $startDate = null;
                            $endDate = null;
                            $starttime = null;
                            $endtime =null;
                  if(isset($procedure['id'])){

                            if(isset($procedure['order_date'])){
                              $starttime = date('H:i:s',strtotime($procedure['order_time']));
                              $endtime = date('H:i:s', strtotime("+".$procedure['duration']." minutes", strtotime($procedure['order_time'])));
                              $startDate = date('Y-m-d H:i:s', strtotime($procedure['order_date']." ".$starttime));
                              $endDate = date('Y-m-d H:i:s', strtotime($procedure['order_date']." ".$endtime));
                              $status = 0;

                            PatientProcedures::where('id', $procedure['id'])->update(array( 'appointment_id'=>$data['appointment_id'],
                            'ipd_id' =>  $data['ipd_id'],
                    				'patient_id'=>$data['patient_id'],
                            // 'procedure_eye' => $procedure['procedure_eye'],
                    				'procedure_type' => $procedure['procedure_type'],
                    				'procedure_id' => $procedure['procedure_id'],
                    				//'order_date' => (isset($procedure['order_date']) ? strtotime($procedure['order_date']) : null),
                    				'order_date' => date('d-m-Y',strtotime($procedure['order_date'])),
                    				'order_time' =>$procedure['order_time'],
                    				'duration' =>$procedure['duration'],
                    				'notes' => $procedure['notes'],
                            'status' => $status
                    				 ));
                            }else{
                             PatientProcedures::where('id', $procedure['id'])->update(array( 'appointment_id'=>$data['appointment_id'],
                            'ipd_id' =>  $data['ipd_id'],
                    				'patient_id'=>$data['patient_id'],
                            // 'procedure_eye' => $procedure['procedure_eye'],
                    				'procedure_type' => $procedure['procedure_type'],
                    				'procedure_id' => $procedure['procedure_id'],
                    				//'order_date' => (isset($procedure['order_date']) ? strtotime($procedure['order_date']) : null),
                    				'notes' => $procedure['notes'],
                            'status' => $status
                    				 ));
                            }
                  }else{
                    if(!empty($procedure['procedure_id'])){
                      if(isset($procedure['order_date'])){
                        $starttime = date('H:i:s',strtotime($procedure['order_time']));
                        $endtime = date('H:i:s', strtotime("+".$procedure['duration']." minutes", strtotime($procedure['order_time'])));
                        $startDate = date('Y-m-d H:i:s', strtotime($procedure['order_date']." ".$starttime));
                        $endDate = date('Y-m-d H:i:s', strtotime($procedure['order_date']." ".$endtime));
                        $status = 0;

                			$order = 	PatientProcedures::create([
                				'appointment_id'=>$data['appointment_id'],
                        'ipd_id' =>  $data['ipd_id'],
                				'patient_id'=>$data['patient_id'],
                        // 'procedure_eye' => $procedure['procedure_eye'],
                				'procedure_type' => $procedure['procedure_type'],
                        'ipd_type' =>  (isset($data['ipd_type']) ? $data['ipd_type'] : ''),
                				'procedure_id' => $procedure['procedure_id'],
                				// 'order_date' =>(isset($procedure['order_date']) ? strtotime($procedure['order_date']) : null),
                				'order_date' => date('d-m-Y',strtotime($procedure['order_date'])),
                				'order_time' =>$procedure['order_time'],
                				'duration' =>$procedure['duration'],
                				'notes' => $procedure['notes'],
                        'status' => $status,
                				'added_by' => Auth::id()
                				]);
                				  Appointments::create([
                            'doc_id' =>  $data['doc_id'],
                            'pId' =>  $data['patient_id'],
                            'billable_status' =>1,
                            'visit_type' =>1,
                            'start' =>  $startDate,
                            'end' =>  $endDate,
                            'status' =>  1,
                            'added_by' => $practiceId->practice_id
                       ]);
					   if(time() < strtotime($procedure['order_date'])) {
						   $procedure['order_date'] = date("Y-m-d");
					   }
					   $this->createBill($practiceId->practice_id,$data['ipd_id'],$data['patient_id'],$order,"procedure_order",$procedure['order_date']);
                      }
                      else{
                          PatientProcedures::create([
                  				'appointment_id'=>$data['appointment_id'],
                          'ipd_id' =>  $data['ipd_id'],
                  				'patient_id'=>$data['patient_id'],
                          'ipd_type' =>  (isset($data['ipd_type']) ? $data['ipd_type'] : ''),
                          // 'procedure_eye' => $procedure['procedure_eye'],
                  				'procedure_type' => $procedure['procedure_type'],
                  				'procedure_id' => $procedure['procedure_id'],
                  				// 'order_date' =>(isset($procedure['order_date']) ? strtotime($procedure['order_date']) : null),
                          'notes' => $procedure['notes'],
                          'status' => $status,
                  				'added_by' => Auth::id()
                  				]);
                         }
                			}
                  }
              }
          }
		     Session::flash('message', "Procedure Added Successfully");
         return 1;
  	     }
    }

  public function createPatientAllergyHistory(Request $request)
  {
    if ($request->isMethod('post')) {
      $data = $request->all();
      $this->AddToFavoriteList($data);
      $practiceId = Parent::getMyPractice();
      if(!empty($data['allergy'])){
        foreach($data['allergy'] as $allergy) {
          if(isset($allergy['id'])){
            PatientAllergyHistory::where('id', $allergy['id'])->update([
            'allergy' => $allergy['allergy'],
            'notes' => $allergy['notes']
            ]);
          }
          else{
            PatientAllergyHistory::create([
            'appointment_id'=>$data['appointment_id'],
            'ipd_id' =>  $data['ipd_id'],
            'ipd_type' =>  $data['ipd_type'],
            'patient_id'=>$data['patient_id'],
            'allergy' => $allergy['allergy'],
            'notes' => $allergy['notes'],
            'added_by' => Auth::id()
            ]);
          }
        }
      }
      Session::flash('message', "Allergy Added Successfully");
      return 1;
    }
  }
  public function createPatientDischargeHistory(Request $request)
  {
 
    if ($request->isMethod('post')) {
      $data = $request->all();
      $practiceId = Parent::getMyPractice();
      if(!empty($data['id'])){
        DischargeHistory::where('id', $data['id'])->update([
          'history' => $data['history']
        ]);
      }
      else{
        
        DischargeHistory::create([
        'appointment_id'=>$data['appointment_id'],
        'ipd_id' =>  $data['ipd_id'],
        'ipd_type' =>  $data['ipd_type'],
        'history_type' =>  $data['type'],
        'patient_id'=>$data['patient_id'],
        'history' => $data['history'],
        'added_by' => Auth::id()
        ]);
      }
      Session::flash('message', "Allergy Added Successfully");
      return 1;
    }
  }
  public function createPatientOtTemplate(Request $request) {
		if($request->isMethod('post')) {
			$data = $request->all();
			$practiceId = Parent::getMyPractice();
			if(!empty($data)){ //pr($data);
				if(isset($data["ot_temp_id"]) && $data["ot_temp_id"] == '0' && !empty($data['new_template'])) {
					OtReportTemplate::create([
						'type' => $data['type'],
						'ipd_type'=>$data['ipd_type'],
						'title'=>$data['new_template'],
						'report'=>$data['instructions'],
						'added_by' => Auth::id()
					]);
				}
				if(!empty($data['id'])){
					PatientOtTemplate::where('id', $data['id'])->update(array(
						'instructions' => $data['instructions'],
						'surgen' =>  (isset($data['surgen']) ? $data['surgen'] : null),
					));
				}
				else{
					PatientOtTemplate::create([
						'ipd_id'=>$data['ipd_id'],
						'ipd_type'=>$data['ipd_type'],
						'type'=>$data['type'],
						'appointment_id'=>$data['appointment_id'],
						'patient_id'=>$data['patient_id'],
						'instructions' => $data['instructions'],
						'surgen' => (isset($data['surgen']) ? $data['surgen'] : null),
						'added_by' => Auth::id()
					]);
      			}
            }
         return 1;
  	    }
    }

    public function addReferral(Request $request)
    {
      $practiceId = Parent::getMyPractice();
      $practice =  PracticeDetails::where(['user_id'=>$practiceId->practice_id])->first();
      if ($request->isMethod('post')) {
      $data = $request->all();
			 if($data['referral_to']==0){
					ReferralsMaster::create([
					'referral_by' => $data['referral_by'],
					'email' => $data['email'],
					'phone_no' => $data['phone_no'],
					'referral_to' => $data['referral_to'],
					'doctor_name' => $data['referral_to_other'],
					'speciality_id' => $data['speciality_id'],
					//'speciality_other' => $data['speciality_other'],
					'added_by' => Auth::id()
					]);

				if(isset($data['id'])){
				  PatientReferrals::where('id', $data['id'])->update(array(
					'appointment_id'=>$data['appointment_id'],
          'ipd_id' =>  $data['ipd_id'],
					'patient_id'=>$data['patient_id'],
					'referral_date' => strtotime($data['referral_date']),
					'referral_by' => $data['referral_by'],
					'email' => $data['email'],
					'phone_no' => $data['phone_no'],
					'referral_to' => $data['referral_to'],
					'referral_to_other' => $data['referral_to_other'],
					'speciality_id' => $data['speciality_id'],
					//'speciality_other' => $data['speciality_other'],
					));
				}
				else{
				  PatientReferrals::create([
					'appointment_id'=>$data['appointment_id'],
          'ipd_id' =>  $data['ipd_id'],
					'patient_id'=>$data['patient_id'],
					'referral_date' => strtotime($data['referral_date']),
					'referral_by' => $data['referral_by'],
					'email' => $data['email'],
					'phone_no' => $data['phone_no'],
					'referral_to' => $data['referral_to'],
					'referral_to_other' => $data['referral_to_other'],
					'speciality_id' => $data['speciality_id'],
					//'speciality_other' => $data['speciality_other'],
					'added_by' => Auth::id()
						]);
    			}
    		}
			 else{
				 if(isset($data['id'])){
				  PatientReferrals::where('id', $data['id'])->update(array(
					'appointment_id'=>$data['appointment_id'],
          'ipd_id' =>  $data['ipd_id'],
					'patient_id'=>$data['patient_id'],
					'referral_date' => strtotime($data['referral_date']),
					'referral_by' => $data['referral_by'],
					'email' => $data['email'],
					'phone_no' => $data['phone_no'],
					'referral_to' => $data['referral_to'],
					'referral_to_other' => $data['referral_to_other'],
					'speciality_id' => $data['speciality_id'],
					//'speciality_other' => $data['speciality_other'],
					));
				}
				else{
				  PatientReferrals::create([
					'appointment_id'=>$data['appointment_id'],
          'ipd_id' =>  $data['ipd_id'],
					'patient_id'=>$data['patient_id'],
					'referral_date' => strtotime($data['referral_date']),
					'referral_by' => $data['referral_by'],
					'email' => $data['email'],
					'phone_no' => $data['phone_no'],
					'referral_to' => $data['referral_to'],
					'referral_to_other' => $data['referral_to_other'],
					'speciality_id' => $data['speciality_id'],
					//'speciality_other' => $data['speciality_other'],
					'added_by' => Auth::id()
					]);
				}
			}
        if($practice->internet_connection == 1 && Parent::is_connected()==1 ) {
          if(!empty($data['notifyBy'])){
				if(!empty($data['referral_to']) || $data['referral_to'] != 0){
				$to_docname = ucfirst(getRefdocDetails($data['referral_to'])->doctor_name);
				}else{
				  $to_docname = ucfirst($data['referral_to_other']);
				}
				$p_phoneNo='';
				if(!empty($data['p_phoneNo'])){
				   $p_phoneNo = $data['p_phoneNo'];
				}
				if (in_array("1", $data['notifyBy'])) {
				$to = $data['email'];
				$EmailTemplate = EmailTemplate::where('slug','referralmail')->first();
				if($EmailTemplate)
				{
					$body = $EmailTemplate->description;
					$patientname = $data['patient_name'];
					$from_doc_no ='';
					if(!empty($data['doc_phoneNo'])){
					   $from_doc_no = $data['doc_phoneNo'];
					}
					$from_docname = $data['referral_DocName'];
					$mailMessage = str_replace(array('{{to_docname}}','{{patientname}}','{{p_phoneNo}}','{{from_docname}}','{{from_doc_no}}'),
					array($to_docname,$patientname,$p_phoneNo,$from_docname,$from_doc_no),$body);
					$datas = array( 'to' =>$to,'from' => 'noreply@healthgennie.com','mailTitle'=>$EmailTemplate->title,'practiceData'=>$practice,'content'=>$mailMessage,'subject'=>$EmailTemplate->subject);
					try{
					Mail::send('emails.mailtempPractice', $datas, function( $message ) use ($datas)
					{
						$message->to( $datas['to'] )->from( $datas['from'])->subject($datas['subject']);
					});
					}
					catch(\Exception $e){
					   // Never reached
					}
				}
				}
				if (in_array("2", $data['notifyBy']) && !empty($data['phone_no'])) {
					//sms area
					$message = urlencode($data['patient_name']." is my patient and i would like to refer him to you for further diagnosis.You can contact him at ".$p_phoneNo." and set up an appointment.");
          $this->sendSMS($data["phone_no"],$message);
				}
             }
           }
          return 1;
        }
    }

    public function createPatientAllergies(Request $request)
   {
   if ($request->isMethod('post')) {
         $data = $request->all();
         $this->AddToFavoriteList($data);
        //echo "<pre>";
      // print_r($data);die;
        $practiceId = Parent::getMyPractice();
        // $user = Auth::id();
        if(!empty($data['allergies'])){
            foreach($data['allergies'] as $allergy){
                if(isset($allergy['id'])){
                PatientAllergy::where('id', $allergy['id'])->update(array( 'appointment_id'=>$data['appointment_id'],
                  'ipd_id' =>  $data['ipd_id'],
          				'patient_id'=>$data['patient_id'],
          				'allergy_type' => $allergy['allergy_type'],
          				'allergy_id' => $allergy['allergy_id'],
          				'allergy_reactions' => $allergy['reactions'],
          				'severity' => $allergy['severity'],
          				'notes' => $allergy['notes']
                    ));
                }else{
                  if(!empty($allergy['allergy_id'])){
          				PatientAllergy::create([
          				'appointment_id'=>$data['appointment_id'],
                  'ipd_id' =>  $data['ipd_id'],
          				'patient_id'=>$data['patient_id'],
          				'allergy_type' => $allergy['allergy_type'],
          				'allergy_id' => $allergy['allergy_id'],
          				'allergy_reactions' => $allergy['reactions'],
          				'severity' => $allergy['severity'],
          				'notes' => $allergy['notes'],
          				'added_by' => Auth::id()
          				]);
          			}
                }
            }
        }
       return 1;
	     }
    }

    public function createPatientDentals(Request $request)
    {
    if ($request->isMethod('post')) {
         $data = $request->all();
         $this->AddToFavoriteList($data);
         $practiceId = Parent::getMyPractice();
         if(!empty($data['dentals'])){
         foreach($data['dentals'] as $dental){
             if(isset($dental['id'])){//echo "ravi";die;
                 PatientDentals::where('id', $dental['id'])->update(array( 'appointment_id'=>$data['appointment_id'],
                'ipd_id' =>  $data['ipd_id'],
         				'patient_id'=>$data['patient_id'],
         				'dental_id' => $dental['dental_id'],
         				'dental_procedure' => $dental['dental_procedure'],
                 'dental_note' => $dental['dental_note']
               ));
             }else{
               if(!empty($dental['dental_procedure'])){//echo "khanna";die;
         				PatientDentals::create([
         				'appointment_id'=>$data['appointment_id'],
                'ipd_id' =>  $data['ipd_id'],
         				'patient_id'=>$data['patient_id'],
         				'dental_id' => $dental['dental_id'],
                 'dental_procedure' => $dental['dental_procedure'],
         				'dental_note' => $dental['dental_note'],
         				'added_by' => Auth::id()
         				]);
         			   }
                }
              }
            }
         return 1;
       }
     }


    public function createPatientVitals(Request $request) {
      if ($request->isMethod('post')) {
      $data = $request->all();
      $practiceId = Parent::getMyPractice();
      //if(isset($data['na'])){
		if($data['ipd_type'] == 2 && isset($data['id']) && !empty($data['id'])){
        PatientVitalss::where('id', $data['id'])->update(array(
        'appointment_id'=>$data['appointment_id'],
        'ipd_id' =>  $data['ipd_id'],
        'patient_id'=>$data['patient_id'],
        'heightCm' => $data['heightCm'],
        'weight' => $data['weight'],
        'bmi' => $data['bmi'],
        'bp_systolic' => $data['bp_systolic'],
        'bp_diastolic' => $data['bp_diastolic'],
        'pulse_rate' => $data['pulse_rate'],
        'temprature' => (isset($data['temprature']) ? $data['temprature'] : null),
        'dis_heightCm' => (isset($data['dis_heightCm']) ? $data['dis_heightCm'] : null),
        'dis_weight' => (isset($data['dis_weight']) ? $data['dis_weight'] : null),
        'dis_bmi' => (isset($data['dis_bmi']) ? $data['dis_bmi'] : null),
        'temperature_f' => (isset($data['temperature_f']) ? $data['temperature_f'] : null),
        'head_circumference' => (isset($data['head_circumference']) ? $data['head_circumference'] : null),
        'Spo_two' => $data['Spo_two'],
        ));
      }else{
        PatientVitalss::create([
        'appointment_id'=>$data['appointment_id'],
        'ipd_id' =>  $data['ipd_id'],
        'ipd_type' =>  $data['ipd_type'],
        'patient_id'=>$data['patient_id'],
        'heightCm' => $data['heightCm'],
        'weight' => $data['weight'],
        'bmi' => $data['bmi'],
        'bp_systolic' => $data['bp_systolic'],
        'bp_diastolic' => $data['bp_diastolic'],
        'pulse_rate' => $data['pulse_rate'],
        'temprature' => (isset($data['temprature']) ? $data['temprature'] : null),
        'dis_heightCm' => (isset($data['dis_heightCm']) ? $data['dis_heightCm'] : null),
        'dis_weight' => (isset($data['dis_weight']) ? $data['dis_weight'] : null),
        'dis_bmi' => (isset($data['dis_bmi']) ? $data['dis_bmi'] : null),
        'temperature_f' => (isset($data['temperature_f']) ? $data['temperature_f'] : null),
        'head_circumference' => (isset($data['head_circumference']) ? $data['head_circumference'] : null),
        // 'notes' => $data['notes'],
        'Spo_two' => $data['Spo_two'],
        'added_by' => Auth::id()
        ]);
      }
      return 1;
      }
    }

    public function createPatientExaminations(Request $request)
    {
    if ($request->isMethod('post')) {
      $data = $request->all();
      $this->AddToFavoriteList($data);
      $practiceId = Parent::getMyPractice();
      if(!empty($data['examinations'])){
          foreach($data['examinations'] as $examination){
          //if(!empty($procedure['bodySite_id'])){
          if(isset($examination['id'])){
          PatientExaminations::where('id', $examination['id'])->update(array( 'appointment_id'=>$data['appointment_id'],
          'ipd_id' =>  $data['ipd_id'],
          'patient_id'=>$data['patient_id'],
          'bodySite_id' => $examination['bodySite_id'],
          'observation' => $examination['observation']
          ));
          }else{
            if(!empty($examination['bodySite_id'])){
              PatientExaminations::create([
              'appointment_id'=>$data['appointment_id'],
              'ipd_id' =>  $data['ipd_id'],
              'patient_id'=>$data['patient_id'],
              'bodySite_id' => $examination['bodySite_id'],
              'observation' => $examination['observation'],
              'added_by' => Auth::id()
              ]);
              }
            }
           }
          //}
        }
        return 1;
	     }
     }

     public function createPatientimmunizations(Request $request)
     {
     if ($request->isMethod('post')) {
          $data = $request->all();
          //pr($data);die;
          $user = Auth::id();
          if(!empty($data['immunizations'])){
          foreach($data['immunizations'] as $immunizations){
          if(isset($immunizations['id'])){
              PatientImmunizations::where('id', $immunizations['id'])->update(array('appointment_id'=>$data['appointment_id'],
              'ipd_id' =>  $data['ipd_id'],
      				'patient_id'=>$data['patient_id'],
              'immunization_type' => $immunizations['immunization_type'],
              'vaccine_id' => $immunizations['immunization_type'],
              'immunization_id' =>  $immunizations['immunization_id'],
              'schedule_id' => $immunizations['schedule_id'],
              'dose_qty' => $immunizations['dose_qty'],
              'dose_unit' => $immunizations['dose_unit'],
              'dose_status' => $immunizations['dose_status'],
              // 'dose_no' => $immunizations['dose_no'],
              'route' => $immunizations['route'],
              'other_route' => (isset($immunizations['other_route']) ? $immunizations['other_route'] : null),
              'body_location' => $immunizations['body_location'],
              'comment' => $immunizations['comment'],
              'given_by' => $immunizations['given_by'],
              'given_date' => (isset($immunizations['given_date']) ? $immunizations['given_date'] : null)
              ));
          }else{
      				PatientImmunizations::create([
                'appointment_id'=>$data['appointment_id'],
                'ipd_id' =>  $data['ipd_id'],
        				'patient_id'=>$data['patient_id'],
                'immunization_type' => $immunizations['immunization_type'],
                'vaccine_id' => $immunizations['immunization_type'],
                'immunization_id' =>  $immunizations['immunization_id'],
                'schedule_id' => $immunizations['schedule_id'],
                'dose_qty' => $immunizations['dose_qty'],
                'dose_unit' => $immunizations['dose_unit'],
                'dose_status' => $immunizations['dose_status'],
                // 'dose_no' => $immunizations['dose_no'],
                'route' => $immunizations['route'],
                'other_route' => (isset($immunizations['other_route']) ? $immunizations['other_route'] : null),
                'body_location' => $immunizations['body_location'],
                'comment' => $immunizations['comment'],
                'given_by' => $immunizations['given_by'],
                'given_date' => (isset($immunizations['given_date']) ? $immunizations['given_date'] : null),
                'added_by' => $user
      				]);
            }
          }
        }
        return 1;
       }
     }

     public function addEyesExamination(Request $request)
    {
      if ($request->isMethod('post')) {
            $data = $request->all();
            $path = 'uploads/PatientDocuments/'.$data['patient_number'].'/eye/';
            if(!is_dir($path)){
            File::makeDirectory($path, $mode = 0777, true, true);
            }
            $img_right_eye = $data['r_ratinoscopy'];  // your base64 encoded
            $img_right_eye = str_replace('data:image/png;base64,', '', $img_right_eye);
            $img_right_eye = str_replace(' ', '+', $img_right_eye);
            $img_right_eyeName = time().$data['patient_number'].'RS.'.'png';

           // $img_left_eye = $data['l_ratinoscopy'];  // your base64 encoded
          //  $img_left_eye = str_replace('data:image/png;base64,', '', $img_left_eye);
          //  $img_left_eye = str_replace(' ', '+', $img_left_eye);
          //  $img_left_eyeName = time().$data['patient_number'].'LS.'.'png';
            $user = Auth::id();
               if(isset($data['eye_id'])) {
                  $rightEye = $path.$data['r_ratinoscopy'];
                 // $leftEye = $path.$data['l_ratinoscopy'];
                  if(file_exists($rightEye)){
                  File::delete($rightEye);
                  }
                 // if(file_exists($leftEye)){
                //  File::delete($leftEye);
                //  }
                  File::put($path.$img_right_eyeName, base64_decode($img_right_eye));
                //  File::put($path.$img_left_eyeName, base64_decode($img_left_eye));
                  PatientEyes::where('id', $data['eye_id'])->update(array(
                    'va_check'=>(isset($data['va_check']) ? $data['va_check'] : ''),
                    'r_va_h'=>$data['r_va_h'],
                    'r_va_m'=>$data['r_va_m'],
                    'l_va_h'=>$data['l_va_h'],
                    'l_va_m'=>$data['l_va_m'],
                    'bcva_check'=>(isset($data['bcva_check']) ? $data['bcva_check'] : ''),
                    'r_bcva'=>$data['r_bcva'],
                    'l_bcva'=>$data['l_bcva'],
                    'iop_check'=>(isset($data['iop_check']) ? $data['iop_check'] : ''),
                    'r_iop'=>$data['r_iop'],
                    'r_iop_other'=>$data['r_iop_other'],
                    'l_iop'=>$data['l_iop'],
                    'l_iop_other'=>$data['l_iop_other'],
                    'ar_check'=>(isset($data['ar_check']) ? $data['ar_check'] : ''),
                    'r_ar'=>$data['r_ar'],
                    'r_ar_input1'=>$data['r_ar_input1'],
                    'r_ar_input2'=>$data['r_ar_input2'],
                    'l_ar'=>$data['l_ar'],
                    'l_ar_input1'=>$data['l_ar_input1'],
                    'l_ar_input2'=>$data['l_ar_input2'],
                    'dilar_check'=>(isset($data['dilar_check']) ? $data['dilar_check'] : ''),
                    'r_dilar_input1'=>$data['r_dilar_input1'],
                    'r_dilar_input2'=>$data['r_dilar_input2'],
                    'r_dilar_input3'=>$data['r_dilar_input3'],
                    'r_dilar_input4'=>$data['r_dilar_input4'],
                    'l_dilar_input1'=>$data['l_dilar_input1'],
                    'l_dilar_input2'=>$data['l_dilar_input2'],
                    'l_dilar_input3'=>$data['l_dilar_input3'],
                    'l_dilar_input4'=>$data['l_dilar_input4'],
                    'k1k2_check'=>(isset($data['k1k2_check']) ? $data['k1k2_check'] : ''),
                    'r_k1k2_text'=>$data['r_k1k2_text'],
                    'r_k1k2_axis'=>$data['r_k1k2_axis'],
                    'l_k1k2_text'=>$data['l_k1k2_text'],
                    'l_k1k2_axis'=>$data['l_k1k2_axis'],
                    'axl_check'=>(isset($data['axl_check']) ? $data['axl_check'] : ''),
                    'r_axl'=>$data['r_axl'],
                    'l_axl'=>$data['l_axl'],
                    'iol_check'=>(isset($data['iol_check']) ? $data['iol_check'] : ''),
                    'r_iol'=>$data['r_iol'],
                    'l_iol'=>$data['l_iol'],
                    'syringing_check'=>(isset($data['syringing_check']) ? $data['syringing_check'] : ''),
                    'r_syringing'=>$data['r_syringing'],
                    'l_syringing'=>$data['l_syringing'],
                    'color_vision_check'=>(isset($data['color_vision_check']) ? $data['color_vision_check'] : ''),
                    'r_color_vision_text'=>$data['r_color_vision_text'],
                    'r_color_vision_type'=>$data['r_color_vision_type'],
                    'l_color_vision_text'=>$data['l_color_vision_text'],
                    'l_color_vision_type'=>$data['l_color_vision_type'],
                    'pgp_check'=>(isset($data['pgp_check']) ? $data['pgp_check'] : ''),
                    'r_pgp'=>$data['r_pgp'],
                    'r_pgp_shp'=>$data['r_pgp_shp'],
                    'r_pgp_cg'=>$data['r_pgp_cg'],
                    'r_pgp_axis'=>$data['r_pgp_axis'],
                    'r_pgp_b'=>$data['r_pgp_b'],
                    'r_pgp_shp_b'=>$data['r_pgp_shp_b'],
                    'r_pgp_cg_b'=>$data['r_pgp_cg_b'],
                    'r_pgp_axis_b'=>$data['r_pgp_axis_b'],
                    'l_pgp'=>$data['l_pgp'],
                    'l_pgp_shp'=>$data['l_pgp_shp'],
                    'l_pgp_cg'=>$data['l_pgp_cg'],
                    'l_pgp_axis'=>$data['l_pgp_axis'],
                    'l_pgp_b'=>$data['l_pgp_b'],
                    'l_pgp_shp_b'=>$data['l_pgp_shp_b'],
                    'l_pgp_cg_b'=>$data['l_pgp_cg_b'],
                    'l_pgp_axis_b'=>$data['l_pgp_axis_b'],
                    'retinoscopy_check'=>(isset($data['retinoscopy_check']) ? $data['retinoscopy_check'] : ''),
                    'r_ratinoscopy'=>$img_right_eyeName,
                    // 'r_ratinoscopy2'=>$data['r_ratinoscopy2'],
                    //  'l_ratinoscopy'=>$img_left_eyeName,
                    // 'l_ratinoscopy2'=>$data['l_ratinoscopy2'],
                    //'eye_note' => $data['eye_note'],
                    'r_ar_sph_sign'=>$data['r_ar_sph_sign'],
                    'r_ar_cyl_sign'=>$data['r_ar_cyl_sign'],
                    'r_dil_sph_sign'=>$data['r_dil_sph_sign'],
                    'r_dil_cyl_sign'=>$data['r_dil_cyl_sign'],
                    'r_ogp_sph_sign'=>$data['r_ogp_sph_sign'],
                    'r_ogp_cyl_sign'=>$data['r_ogp_cyl_sign'],
                    'r_ogp_sph_sign2'=>$data['r_ogp_sph_sign2'],
                    'r_ogp_cyl_sign2'=>$data['r_ogp_cyl_sign2'],
                    'l_ar_sph_sign'=>$data['l_ar_sph_sign'],
                    'l_ar_cyl_sign'=>$data['l_ar_cyl_sign'],
                    'l_dil_sph_sign'=>$data['l_dil_sph_sign'],
                    'l_dil_cyl_sign'=>$data['l_dil_cyl_sign'],
                    'l_ogp_sph_sign'=>$data['l_ogp_sph_sign'],
                    'l_ogp_cyl_sign'=>$data['l_ogp_cyl_sign'],
                    'l_ogp_sph_sign2'=>$data['l_ogp_sph_sign2'],
                    'l_ogp_cyl_sign2'=>$data['l_ogp_cyl_sign2']
                 ));
               }
               else {
                  File::put($path.$img_right_eyeName, base64_decode($img_right_eye));
                //  File::put($path.$img_left_eyeName, base64_decode($img_left_eye));
                  PatientEyes::create([
                    'appointment_id'=>$data['appointment_id'],
                    'patient_id'=>$data['patient_id'],
                    'ipd_id' =>  $data['ipd_id'],
                    'va_check'=>(isset($data['va_check']) ? $data['va_check'] : ''),
                    'r_va_h'=>$data['r_va_h'],
                    'r_va_m'=>$data['r_va_m'],
                    'l_va_h'=>$data['l_va_h'],
                    'l_va_m'=>$data['l_va_m'],
                    'bcva_check'=>(isset($data['bcva_check']) ? $data['bcva_check'] : ''),
                    'r_bcva'=>$data['r_bcva'],
                    'l_bcva'=>$data['l_bcva'],
                    'iop_check'=>(isset($data['iop_check']) ? $data['iop_check'] : ''),
                    'r_iop'=>$data['r_iop'],
                    'r_iop_other'=>$data['r_iop_other'],
                    'l_iop'=>$data['l_iop'],
                    'l_iop_other'=>$data['l_iop_other'],
                    'ar_check'=>(isset($data['ar_check']) ? $data['ar_check'] : ''),
                    'r_ar'=>$data['r_ar'],
                    'r_ar_input1'=>$data['r_ar_input1'],
                    'r_ar_input2'=>$data['r_ar_input2'],
                    'l_ar'=>$data['l_ar'],
                    'l_ar_input1'=>$data['l_ar_input1'],
                    'l_ar_input2'=>$data['l_ar_input2'],
                    'dilar_check'=>(isset($data['dilar_check']) ? $data['dilar_check'] : ''),
                    'r_dilar_input1'=>$data['r_dilar_input1'],
                    'r_dilar_input2'=>$data['r_dilar_input2'],
                    'r_dilar_input3'=>$data['r_dilar_input3'],
                    'r_dilar_input4'=>$data['r_dilar_input4'],
                    'l_dilar_input1'=>$data['l_dilar_input1'],
                    'l_dilar_input2'=>$data['l_dilar_input2'],
                    'l_dilar_input3'=>$data['l_dilar_input3'],
                    'l_dilar_input4'=>$data['l_dilar_input4'],
                    'k1k2_check'=>(isset($data['k1k2_check']) ? $data['k1k2_check'] : ''),
                    'r_k1k2_text'=>$data['r_k1k2_text'],
                    'r_k1k2_axis'=>$data['r_k1k2_axis'],
                    'l_k1k2_text'=>$data['l_k1k2_text'],
                    'l_k1k2_axis'=>$data['l_k1k2_axis'],
                    'axl_check'=>(isset($data['axl_check']) ? $data['axl_check'] : ''),
                    'r_axl'=>$data['r_axl'],
                    'l_axl'=>$data['l_axl'],
                    'iol_check'=>(isset($data['iol_check']) ? $data['iol_check'] : ''),
                    'r_iol'=>$data['r_iol'],
                    'l_iol'=>$data['l_iol'],
                    'syringing_check'=>(isset($data['syringing_check']) ? $data['syringing_check'] : ''),
                    'r_syringing'=>$data['r_syringing'],
                    'l_syringing'=>$data['l_syringing'],
                    'color_vision_check'=>(isset($data['color_vision_check']) ? $data['color_vision_check'] : ''),
                    'r_color_vision_text'=>$data['r_color_vision_text'],
                    'r_color_vision_type'=>$data['r_color_vision_type'],
                    'l_color_vision_text'=>$data['l_color_vision_text'],
                    'l_color_vision_type'=>$data['l_color_vision_type'],
                    'pgp_check'=>(isset($data['pgp_check']) ? $data['pgp_check'] : ''),

                    'r_pgp'=>$data['r_pgp'],
                    'r_pgp_shp'=>$data['r_pgp_shp'],
                    'r_pgp_cg'=>$data['r_pgp_cg'],
                    'r_pgp_axis'=>$data['r_pgp_axis'],
                    'l_pgp'=>$data['l_pgp'],
                    'l_pgp_shp'=>$data['l_pgp_shp'],
                    'l_pgp_cg'=>$data['l_pgp_cg'],
                    'l_pgp_axis'=>$data['l_pgp_axis'],
                    'r_pgp_b'=>$data['r_pgp_b'],
                    'r_pgp_shp_b'=>$data['r_pgp_shp_b'],
                    'r_pgp_cg_b'=>$data['r_pgp_cg_b'],
                    'r_pgp_axis_b'=>$data['r_pgp_axis_b'],
                    'l_pgp_b'=>$data['l_pgp_b'],
                    'l_pgp_shp_b'=>$data['l_pgp_shp_b'],
                    'l_pgp_cg_b'=>$data['l_pgp_cg_b'],
                    'l_pgp_axis_b'=>$data['l_pgp_axis_b'],

                    'retinoscopy_check'=>(isset($data['retinoscopy_check']) ? $data['retinoscopy_check'] : ''),
                    'r_ratinoscopy'=>$img_right_eyeName,
                   // 'r_ratinoscopy2'=>$data['r_ratinoscopy2'],
                  //  'l_ratinoscopy'=>$img_left_eyeName,
                   // 'l_ratinoscopy2'=>$data['l_ratinoscopy2'],
                    //'eye_note' => $data['eye_note'],
                    'r_ar_sph_sign'=>$data['r_ar_sph_sign'],
                    'r_ar_cyl_sign'=>$data['r_ar_cyl_sign'],
                    'r_dil_sph_sign'=>$data['r_dil_sph_sign'],
                    'r_dil_cyl_sign'=>$data['r_dil_cyl_sign'],
                    'r_ogp_sph_sign'=>$data['r_ogp_sph_sign'],
                    'r_ogp_cyl_sign'=>$data['r_ogp_cyl_sign'],
                    'r_ogp_sph_sign2'=>$data['r_ogp_sph_sign2'],
                    'r_ogp_cyl_sign2'=>$data['r_ogp_cyl_sign2'],
                    'l_ar_sph_sign'=>$data['l_ar_sph_sign'],
                    'l_ar_cyl_sign'=>$data['l_ar_cyl_sign'],
                    'l_dil_sph_sign'=>$data['l_dil_sph_sign'],
                    'l_dil_cyl_sign'=>$data['l_dil_cyl_sign'],
                    'l_ogp_sph_sign'=>$data['l_ogp_sph_sign'],
                    'l_ogp_cyl_sign'=>$data['l_ogp_cyl_sign'],
                    'l_ogp_sph_sign2'=>$data['l_ogp_sph_sign2'],
                    'l_ogp_cyl_sign2'=>$data['l_ogp_cyl_sign2'],
                    'added_by' => $user
                  ]);
                  }
           return 1;
         }
    }

	public function addPatientEyesExamination(Request $request)
    {
    if ($request->isMethod('post')) {
        $data = $request->all();
        // pr($data);
         $remrks = '';
         if(isset($data['remarks'])){
            $remrks =  implode('/',$data['remarks']);
         }
		 $practiceId = Parent::getMyPractice();
            if(isset($data['id'])) {
                PatientEyesExaminations::where('id', $data['id'])->update(array(
                  'r_dist_shp_type'=>$data['r_dist_shp_type'],
                  'r_dist_shp_val'=>$data['r_dist_shp_val'],
                  'r_dist_cy_type'=>$data['r_dist_cy_type'],
                  'r_dist_cy_val'=>$data['r_dist_cy_val'],
                  'r_dist_axis'=>$data['r_dist_axis'],
                  'r_dist_vision'=>$data['r_dist_vision'],
                  'r_dist_vision_type'=>$data['r_dist_vision_type'],
                  'l_dist_shp_type'=>$data['l_dist_shp_type'],
                  'l_dist_shp_val'=>$data['l_dist_shp_val'],
                  'l_dist_cy_type'=>$data['l_dist_cy_type'],
                  'l_dist_cy_val'=>$data['l_dist_cy_val'],
                  'l_dist_axis'=>$data['l_dist_axis'],
                  'l_dist_vision'=>$data['l_dist_vision'],
                  'l_dist_vision_type'=>$data['l_dist_vision_type'],
                  'r_near_shp_type'=>$data['r_near_shp_type'],
                  'r_near_shp_val'=>$data['r_near_shp_val'],
                  'r_near_cy_type'=>$data['r_near_cy_type'],
                  'r_near_cy_val'=>$data['r_near_cy_val'],
                  'r_near_axis'=>$data['r_near_axis'],
                  'r_near_vision'=>$data['r_near_vision'],
                  'r_near_vision_type'=>$data['r_near_vision_type'],
                  'l_near_shp_type'=>$data['l_near_shp_type'],
                  'l_near_shp_val'=>$data['l_near_shp_val'],
                  'l_near_cy_type'=>$data['l_near_cy_type'],
                  'l_near_cy_val'=>$data['l_near_cy_val'],
                  'l_near_axis'=>$data['l_near_axis'],
                  'l_near_vision'=>$data['l_near_vision'],
                  'l_near_vision_type'=>$data['l_near_vision_type'],
                  'remarks'=>$remrks,
                  'note'=>$data['note']
               ));
             }
             else {
                PatientEyesExaminations::create([
                  'appointment_id'=>$data['appointment_id'],
                  'patient_id'=>$data['patient_id'],
                  'ipd_id'=>$data['ipd_id'],
                  'r_dist_shp_type'=>$data['r_dist_shp_type'],
                  'r_dist_shp_val'=>$data['r_dist_shp_val'],
                  'r_dist_cy_type'=>$data['r_dist_cy_type'],
                  'r_dist_cy_val'=>$data['r_dist_cy_val'],
                  'r_dist_axis'=>$data['r_dist_axis'],
                  'r_dist_vision'=>$data['r_dist_vision'],
                  'r_dist_vision_type'=>$data['r_dist_vision_type'],
                  'l_dist_shp_type'=>$data['l_dist_shp_type'],
                  'l_dist_shp_val'=>$data['l_dist_shp_val'],
                  'l_dist_cy_type'=>$data['l_dist_cy_type'],
                  'l_dist_cy_val'=>$data['l_dist_cy_val'],
                  'l_dist_axis'=>$data['l_dist_axis'],
                  'l_dist_vision'=>$data['l_dist_vision'],
                  'l_dist_vision_type'=>$data['l_dist_vision_type'],
                  'r_near_shp_type'=>$data['r_near_shp_type'],
                  'r_near_shp_val'=>$data['r_near_shp_val'],
                  'r_near_cy_type'=>$data['r_near_cy_type'],
                  'r_near_cy_val'=>$data['r_near_cy_val'],
                  'r_near_axis'=>$data['r_near_axis'],
                  'r_near_vision'=>$data['r_near_vision'],
                  'r_near_vision_type'=>$data['r_near_vision_type'],
                  'l_near_shp_type'=>$data['l_near_shp_type'],
                  'l_near_shp_val'=>$data['l_near_shp_val'],
                  'l_near_cy_type'=>$data['l_near_cy_type'],
                  'l_near_cy_val'=>$data['l_near_cy_val'],
                  'l_near_axis'=>$data['l_near_axis'],
                  'l_near_vision'=>$data['l_near_vision'],
                  'l_near_vision_type'=>$data['l_near_vision_type'],
                  'remarks'=>$remrks,
                  'note'=>$data['note'],
                  'added_by' => Auth::id()
                ]);
                }
         return 1;
       }
     }

   public function AddToFavoriteList($data) {
       $practiceId = Parent::getMyPractice();

       if(!empty($practiceId)){
         $fav_id='';
         $checkfavDoc = DocFavorite::where(['type'=>$data['type'],"status"=>1])->first();
         if(!empty($checkfavDoc)){
           $fav_id= $checkfavDoc->id;
         }
         if($data['type'] == "chief_complaints"){
           if(!empty($data['chiefComplaints'])){
             foreach($data['chiefComplaints'] as $key => $value){
               $fav_item_already = FavoriteItems::where(["fav_id"=>$fav_id,"data"=>$value['complaint_name'],'added_by'=>$practiceId->practice_id])->whereNotNull('ipd_id')->first();
               if(empty($fav_item_already)) {
                 if(isset($value['favorite_item']) && $value['favorite_item'] == 1){
                   FavoriteItems::create([
                     'fav_id'=>$fav_id,
                     'ipd_id'=>$data['ipd_id'],
                     'data' => $value['complaint_name'],
                     'doc_id'=>$data['doc_id'],
                     'added_by'=>$practiceId->practice_id
                   ]);
                 }
               }
             }
           }
         }
         else if($data['type'] == "allergy_history"){
           if(!empty($data['allergy'])){
             foreach($data['allergy'] as $key => $value){
               $fav_item_already = FavoriteItems::where(["fav_id"=>$fav_id,"data"=>$value['allergy'],'added_by'=>$practiceId->practice_id])->whereNotNull('ipd_id')->first();
               if(empty($fav_item_already)) {
                 if(isset($value['favorite_item']) && $value['favorite_item'] == 1){
                   FavoriteItems::create([
                     'fav_id'=>$fav_id,
                     'ipd_id'=>$data['ipd_id'],
                     'data' => $value['allergy'],
                     'doc_id'=>$data['doc_id'],
                     'added_by'=>$practiceId->practice_id
                   ]);
                 }
               }
             }
           }
         }
         else if($data['type'] == "diagnosis") {
           if(!empty($data['diagnosis'])){
             foreach($data['diagnosis'] as $key=>$value){
               $fav_item_all = FavoriteItems::where(["fav_id"=>$fav_id,"data_id"=>$value['diagnosis_id'],'added_by'=>$practiceId->practice_id])->whereNotNull('ipd_id')->first();
               //pr($fav_item_all);
               if(empty($fav_item_all)){
                   if(isset($value['favorite_item']) && $value['favorite_item'] == 1){
                     FavoriteItems::create([
                     'fav_id'=>$fav_id,
                     'ipd_id'=>$data['ipd_id'],
                     'data_id' => $value['diagnosis_id'],
                     'data' => $value['name'],
                     'doc_id'=>$data['doc_id'],
                     'added_by'=>$practiceId->practice_id
                   ]);
                 }
               }
             }
           }
         }
         else if($data['type'] == "treatment") {
           if(!empty($data['madication'])){
             foreach($data['madication'] as $key=>$value) {
               $fav_item_all = FavoriteItems::where(["fav_id"=>$fav_id,"data_id"=>$value['drug_id'],'added_by'=>$practiceId->practice_id])->whereNotNull('ipd_id')->first();
               //pr($fav_item_all);
               if(empty($fav_item_all)){
                   if(isset($value['favorite_item']) && $value['favorite_item'] == 1){
                       FavoriteItems::create([
                       'fav_id'=>$fav_id,
                       'ipd_id'=>$data['ipd_id'],
                       'data_id' => $value['drug_id'],
                       'data' => $value['name'],
                       'doc_id'=>$data['doc_id'],
                       'added_by'=>$practiceId->practice_id
                     ]);
                 }
               }
             }
           }
         }
         else if($data['type'] == "labs") {
          if(!empty($data['labs'])) {
            foreach($data['labs'] as $key=>$value) {
              $fav_item_all = FavoriteItems::where(["fav_id"=>$fav_id,"data_id"=>$value['lab_id'],'added_by'=>$practiceId->practice_id])->whereNotNull('ipd_id')->first();
              //pr($fav_item_all);
              if(empty($fav_item_all)) {
                  if(isset($value['favorite_item']) && $value['favorite_item'] == 1) {
                    FavoriteItems::create([
                    'fav_id'=>$fav_id,
                    'ipd_id'=>$data['ipd_id'],
                    'lab_pack_status'=>$value['lab_pack_id'],
                    'data_id' => $value['lab_id'],
                    'data' => $value['title'],
                    'doc_id'=>$data['doc_id'],
                    'added_by'=>$practiceId->practice_id
                  ]);
                }
              }
              else {
                if($value['favorite_item'] == 0 && !empty($fav_item_all)) {
                  FavoriteItems::where(["fav_id"=>$fav_id,"data_id"=>$value['lab_id'],'added_by'=>$practiceId->practice_id])->delete();
                }
              }
            }
          }
        }
         else if($data['type'] == "diagnostic_imaging") {
           if(!empty($data['patientDiagnosticImagings'])) {
             foreach($data['patientDiagnosticImagings'] as $key=>$value) {
               $fav_item_all = FavoriteItems::where(["fav_id"=>$fav_id,"data_id"=>$value['lab_id'],'added_by'=>$practiceId->practice_id])->whereNotNull('ipd_id')->first();
               //pr($fav_item_all);
               if(empty($fav_item_all)) {
                   if(isset($value['favorite_item']) && $value['favorite_item'] == 1) {
                       FavoriteItems::create([
                       'fav_id'=>$fav_id,
                       'ipd_id'=>$data['ipd_id'],
                       'data_id' => $value['lab_id'],
                       'data' => $value['title'],
                       'doc_id'=>$data['doc_id'],
                       'added_by'=>$practiceId->practice_id
                     ]);
                 }
               }
             }
           }
         }
         else if($data['type'] == "procedures") {
           if(!empty($data['procedures'])) {
             foreach($data['procedures'] as $key=>$value) {
               $fav_item_all = FavoriteItems::where(["fav_id"=>$fav_id,"data_id"=>$value['procedure_id'],'added_by'=>$practiceId->practice_id])->whereNotNull('ipd_id')->first();
               //pr($fav_item_all);
               if(empty($fav_item_all)) {
                   if(isset($value['favorite_item']) && $value['favorite_item'] == 1) {
                       FavoriteItems::create([
                       'fav_id'=>$fav_id,
                       'ipd_id'=>$data['ipd_id'],
                       'data_id' => $value['procedure_id'],
                       'data' => $value['name'],
                       'doc_id'=>$data['doc_id'],
                       'added_by'=>$practiceId->practice_id
                     ]);
                 }
               }
             }
           }
         }
         else if($data['type'] == "allergies") {
           if(!empty($data['allergies'])) {
             foreach($data['allergies'] as $key=>$value) {
               $fav_item_all = FavoriteItems::where(["fav_id"=>$fav_id,"data_id"=>$value['allergy_id'],'added_by'=>$practiceId->practice_id])->whereNotNull('ipd_id')->first();
               //pr($fav_item_all);
               if(empty($fav_item_all)) {
                   if(isset($value['favorite_item']) && $value['favorite_item'] == 1) {
                       FavoriteItems::create([
                       'fav_id'=>$fav_id,
                       'ipd_id'=>$data['ipd_id'],
                       'data_id' => $value['allergy_id'],
                       'allergy_type' => $value['allergy_type'],
                       // 'data' => $value['title'],
                       'doc_id'=>$data['doc_id'],
                       'added_by'=>$practiceId->practice_id
                     ]);
                 }
               }
             }
           }
         }
         else if($data['type'] == "procedure_order") {
           if(!empty($data['procedures'])) {
             foreach($data['procedures'] as $key=>$value) {
               $fav_item_all = FavoriteItems::where(["fav_id"=>$fav_id,"data_id"=>$value['procedure_id'],'added_by'=>$practiceId->practice_id])->whereNotNull('ipd_id')->first();
               //pr($fav_item_all);
               if(empty($fav_item_all)) {
                   if(isset($value['favorite_item']) && $value['favorite_item'] == 1) {
                       FavoriteItems::create([
                       'fav_id'=>$fav_id,
                       'ipd_id'=>$data['ipd_id'],
                       'data_id' => $value['procedure_id'],
                       'data' => $value['name'],
                       'doc_id'=>$data['doc_id'],
                       'added_by'=>$practiceId->practice_id
                     ]);
                 }
               }
             }
           }
         }
         else if($data['type'] == "examinations") {
           //dd($data);
           if(!empty($data['examinations'])) {
             foreach($data['examinations'] as $key=>$value) {
               $fav_item_all = FavoriteItems::where(["fav_id"=>$fav_id,"data_id"=>$value['bodySite_id'],'added_by'=>$practiceId->practice_id])->whereNotNull('ipd_id')->first();
               //pr($fav_item_all);
               if(empty($fav_item_all)) {
                 if(isset($value['favorite_item']) && $value['favorite_item'] == 1) {
                     FavoriteItems::create([
                     'fav_id'=>$fav_id,
                     'ipd_id'=>$data['ipd_id'],
                     'data_id' => $value['bodySite_id'],
                     'data' => $value['name'],
                     'doc_id'=>$data['doc_id'],
                     'added_by'=>$practiceId->practice_id
                   ]);
                 }
               }
             }
           }
         }
         else if($data['type'] == "dentals") {
           if(!empty($data['dentals'])) {
             foreach($data['dentals'] as $key=>$value) {
               $fav_item_all = FavoriteItems::where(["fav_id"=>$fav_id,"data_id"=>$value['dental_procedure'],'added_by'=>$practiceId->practice_id])->whereNotNull('ipd_id')->first();
               //pr($fav_item_all);
               if(empty($fav_item_all)) {
                   if(isset($value['favorite_item']) && $value['favorite_item'] == 1) {
                       FavoriteItems::create([
                       'fav_id'=>$fav_id,
                       'ipd_id'=>$data['ipd_id'],
                       'data_id' => $value['dental_procedure'],
                       'data' => $value['procedure'],
                       'doc_id'=>$data['doc_id'],
                       'added_by'=>$practiceId->practice_id
                     ]);
                 }
               }
             }
           }
         }
		  else if($data['type'] == "SystemIllness"){
            if(!empty($data['sysIll'])){
              foreach($data['sysIll'] as $key => $value){
                $fav_item_already = FavoriteItems::where(["fav_id"=>$fav_id,"data"=>$value['notes'],'added_by'=>$practiceId->practice_id])->whereNotNull('ipd_id')->first();
                if(empty($fav_item_already)) {
                  if(isset($value['favorite_item']) && $value['favorite_item'] == 1){
                    FavoriteItems::create([
                      'fav_id'=>$fav_id,
					            'ipd_id'=>$data['ipd_id'],
                      'data' => $value['notes'],
                      'doc_id'=>$data['doc_id'],
                      'added_by'=>$practiceId->practice_id
                    ]);
                  }
                }
              }
            }
          }
         return 1;
       }
       else{
         return 2;
       }
   }

   public function visitClose($id){
      $id = base64_decode($id);
      $appointData =  Appointments::select(['visit_status'])->where(['id'=>$id])->first();
      if($appointData->visit_status != 1){
         Appointments::where('id', $id)->update(array(
       'visit_status' =>1,
       ));
     }
      return redirect('ipd');
   }
   public function visitHistory($id)
   {
     $appointment_id = base64_decode($id);
     $ipd = IPDRequest::Where(['appointment_id' => $appointment_id,'order_status' => 1,'delete_status' => 1])->orderBy('id','DESC')->first();
     //echo $ipd->isEmpty();die;
     if($ipd){
       $appointment_id = $ipd->appointment_id;
     }else {
       $patient =  Appointments::where(['id'=>$appointment_id,'delete_status'=>1])->first();
       $ipd = IPDRequest::Where(['patient_id' => $patient->pId,'order_status' => 1,'delete_status' => 1])->orderBy('id','DESC')->first();
       //$appointment_id = $ipd->appointment_id;
       if(!empty($ipd)>0){
         $appointment_id = $ipd->appointment_id;
       }
       else {
         return redirect()->route('ipd.index');
       }
     }

     $admitPatient = IPDRequest::Where(['appointment_id'=> $appointment_id,'order_status' => 1,'delete_status' => 1])->first();
     $pid = $admitPatient->patient_id;
     $patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id])->first();
     $patients =  Appointments::with(['Patient','User.DoctorInfo','ChiefComplaints'])->where(['pId'=>$pid,'status'=>1,'delete_status'=>1])->orderBy('start', 'desc')->paginate(10);
     //echo "<pre>"; print_r($patients);die;
     return view('ipd.pages.visit-history',compact('patient','patients','admitPatient'));
   }
  public function OTHistory($id)
   {
     $appointment_id = base64_decode($id);
     $ipd = IPDRequest::Where(['appointment_id' => $appointment_id,'order_status' => 1,'delete_status' => 1])->orderBy('id','DESC')->first();
     //echo $ipd->isEmpty();die;
     if($ipd){
       $appointment_id = $ipd->appointment_id;
     }else {
       $patient =  Appointments::where(['id'=>$appointment_id,'delete_status'=>1])->first();
       $ipd = IPDRequest::Where(['patient_id' => $patient->pId,'order_status' => 1,'delete_status' => 1])->orderBy('id','DESC')->first();
       //$appointment_id = $ipd->appointment_id;
       if(!empty($ipd)>0){
         $appointment_id = $ipd->appointment_id;
       }
       else {
         return redirect()->route('ipd.index');
       }
     }

     $admitPatient = IPDRequest::Where(['appointment_id'=> $appointment_id,'order_status' => 1,'delete_status' => 1])->first();
     $pid = $admitPatient->patient_id;
     $OTRegistrations = OTRegistration::with('IPDRequest.Patients')->where(['delete_status'=>1])->whereHas('IPDRequest', function($q) use ($pid) {$q->Where(['patient_id'=>$pid]);})->paginate(10);
     return view('ipd.pages.ot-history',compact('OTRegistrations','admitPatient'));
   }

   public function consultationHistory($id)
   {
     $id = base64_decode($id);
     $patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id,'status'=>1,'delete_status'=>1])->first();
     $admitPatient = IPDRequest::Where(['appointment_id'=> $id,'order_status' => 1,'delete_status' => 1])->first();
     $cons = PatientCounselling::Where('delete_status','1')->Where('patient_id',$patient->pId)->paginate(10);
     return view('ipd.pages.consultation-history',compact('cons','patient','admitPatient'));
   }

   public function EditconsultationHistory($id)
   {
     $id = base64_decode($id);
     $cons = PatientCounselling::Where('delete_status','1')->Where('id', $id)->first();
     return view('ipd.ajaxpages.Counselling-status-popup',compact('cons','id'));
   }

   public function UpdateconsultationHistory(Request $request)
   {
	    if (!empty($request->counselling_status)) {

			if ($request->counselling_status == 1) {
				PatientCounselling::where('id', $request->CounsellingID)->update(array('counselling_status' => 1));
			}
			else {
				PatientCounselling::where('id', $request->CounsellingID)->update(array('counselling_status' => 2));
			}
		}
    if (!empty($request->date)) {
        $date = date('Y-m-d',strtotime($request->date));
        PatientCounselling::where('id', $request->CounsellingID)->update(array(
          'counselling_date' => $date
        ));
    }
     $cons = PatientCounselling::Where('delete_status','1')->Where('id', $request->CounsellingID)->first();

      foreach($cons->PatientCounsellingPacks as $counselling_pack) {
          PatientCounsellingPacks::where('id', $counselling_pack->id)->update(array(
            'status' => '0'
          ));
        }
        if (!empty($request->counsellingpackID)) {
          PatientCounsellingPacks::whereIn('id', $request->counsellingpackID)->update(array(
            'status' => '1'
          ));
        }


    return 1;
   }
   public function visitClinicalNotes($id)
   {
       $id = base64_decode($id);
       $patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id,'delete_status'=>1])->first();
       $chiefComplaints =  ChiefComplaints::where(['ipd_type'=>1,'appointment_id'=>$id])->whereNull('ipd_id')->first();
       $treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_type'=>1,'appointment_id'=>$id,'patient_id'=>$patient->pId,
         'delete_status'=>1])->whereNull('ipd_id')->get();
       $labs =  PatientLabs::with(['Labs','LabOrders'])->where(['appointment_id'=>$id,'patient_id'=>$patient->pId,'delete_status'=>1])->whereNull('ipd_id')->get();
       $pAllergies= PatientAllergy::with(['Allergies'])->where(['appointment_id'=>$id,'patient_id'=>$patient->pId,'delete_status'=>1])->whereNull('ipd_id')->get();

      // $procedures = PatientProcedures::with(['Procedures'])->where(['appointment_id'=>$id,'procedure_type'=>'current','delete_status'=>1])->get();
      $procedures = PatientProcedures::with(['Procedures'])->where(['appointment_id'=>$id,'patient_id'=>$patient->pId,'delete_status'=>1])->where(function ($query) {
       $query->where('order_date', '=', date("Y-m-d"))
           ->orWhereNull('order_date');
   })->whereNull('ipd_id')->get();

       $pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_type'=>1,'appointment_id'=>$id,'patient_id'=>$patient->pId,'delete_status'=>1])->whereNull('ipd_id')->get();
       $pVitals = PatientVitalss::where(['ipd_type'=>1,'appointment_id'=>$id,'patient_id'=>$patient->pId,'delete_status'=>1])->whereNull('ipd_id')->first();
       $examinations = PatientExaminations::with(['BodySites'])->where(['appointment_id'=>$id,'patient_id'=>$patient->pId,'delete_status'=>1])->whereNull('ipd_id')->get();
       $proce_order = PatientProcedures::with(['Procedures'])->where('ipd_type','!=', '4')->where(['appointment_id'=>$id,'patient_id'=>$patient->pId,'procedure_type'=>'order','status'=>0,'delete_status'=>1])->whereNull('ipd_id')->get();
       $immunizations = PatientImmunizations::with(['Vaccine'])->where(['appointment_id'=>$id,'patient_id'=>$patient->pId,'delete_status'=>1])->whereNull('ipd_id')->get();
       $patientDiagnosticImagings =  PatientDiagnosticImagings::with(['RadiologyMaster','RadiologyOrders'])->where(['appointment_id'=>$id,'patient_id'=>$patient->pId,'delete_status'=>1])->whereNull('ipd_id')->get();
       $patientMedHistory =  PatientMedicalHistory::with(['Diagnosis'])->where(['patient_id'=>$patient->pId,'delete_status'=>1])->get();
       $patientSurHistory =  PatientSurgicalHistory::where(['patient_id'=>$patient->pId,'delete_status'=>1])->get();
       $patientHosHistory =  PatientHospitalizationHistory::where(['patient_id'=>$patient->pId,'delete_status'=>1])->get();
       $patientFamilyHistory =  PatientFamilyHistory::where(['patient_id'=>$patient->pId,'delete_status'=>1])->first();
       $patientSocialTobaccoHistory =  PatientSocialHistory::where(['patient_id'=>$patient->pId,'type'=>'tobacco','delete_status'=>1])->first();
       $patientSocialAlcohalHistory =  PatientSocialHistory::where(['patient_id'=>$patient->pId,'type'=>'alcohal','delete_status'=>1])->first();
       $patientSocialmiscHistory =  PatientSocialHistory::where(['patient_id'=>$patient->pId,'type'=>'misc','delete_status'=>1])->first();
       $patientSocialHouseHistory =  PatientSocialHistory::where(['patient_id'=>$patient->pId,'type'=>'household','delete_status'=>1])->first();
       $patientGynHistory =  PatientGynHistory::where(['patient_id'=>$patient->pId,'delete_status'=>1])->first();
       $patientObHistory =  PatientObHistory::where(['patient_id'=>$patient->pId,'delete_status'=>1])->first();
       $pReferral = PatientReferrals::where(['appointment_id'=>$id,'delete_status'=>1])->whereNull('ipd_id')->first();
       $dentals = PatientDentals::where(['appointment_id'=>$id,'delete_status'=>1])->whereNull('ipd_id')->get();
       $eyes = PatientEyes::where(['appointment_id'=>$id,'delete_status'=>1])->whereNull('ipd_id')->first();
       $eyesExam  = PatientEyesExaminations::where(['appointment_id'=>$id,'delete_status'=>1])->whereNull('ipd_id')->first();
       $patient_eom = PatientEom::with(['Eom'])->where(['appointment_id'=>$id,'patient_id'=>$patient->pId,'delete_status'=>1])->get();
       $patient_sle = PatientSle::with(['Sle'])->where(['appointment_id'=>$id,'patient_id'=>$patient->pId,'delete_status'=>1])->get();
       $patient_sys_ill = PatientSystematicIllness::where(['appointment_id'=>$id,'patient_id'=>$patient->pId,'delete_status'=>1])->get();
       $patient_fundus = PatientFundus::where(['appointment_id'=>$id,'delete_status'=>1])->first();
       $PatientSleCanvas = PatientSleCanvas::where(['appointment_id'=>$id])->first();
	     $ot_template = PatientOtTemplate::with("OtReportTemplate")->where(['ipd_type'=>1,'appointment_id'=>$id,'delete_status'=>1])->first();
       //$hh=1;
      // echo "<pre>"; print_r($miscHistory);die;
		//pr($ot_template);
       return view('ipd.pages.visit_clinical_note',compact('patient','chiefComplaints',
       'treatments','labs','pAllergies','procedures','pDiagnos','pVitals',
       'examinations','proce_order','immunizations','patientDiagnosticImagings','patientMedHistory','patientSurHistory',
       'patientFamilyHistory','patientHosHistory','patientSocialTobaccoHistory','patientSocialAlcohalHistory','patientSocialmiscHistory',
       'patientSocialHouseHistory','patientGynHistory','patientObHistory','pReferral','dentals','eyes','eyesExam',
       'patient_eom','patient_sle','patient_sys_ill','patient_fundus','PatientSleCanvas','ot_template'));
   }

   public function ipdClinicalNote($id)
   {
      $appointment_id = base64_decode($id);
      $admitPatient = IPDRequest::Where(['appointment_id'=>$appointment_id,'order_status' => 1,'delete_status' => 1])->first();

      $ipd_request_id = $admitPatient->id;
      $chiefComplaints =  ChiefComplaints::where(['ipd_type'=>1,'ipd_id'=>$ipd_request_id])->first();
      $pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_type'=>1,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_type'=>1,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $eyes = PatientEyes::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();
      $labs =  PatientLabs::with(['Labs','LabOrders'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $patientDiagnosticImagings =  PatientDiagnosticImagings::with(['RadiologyMaster','RadiologyOrders'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $procedures = PatientProcedures::with(['Procedures'])->where('ipd_type','!=', '4')->where(['ipd_id'=>$ipd_request_id,'procedure_type'=>'current','delete_status'=>1])->where(function ($query) {
      $query->where('order_date', '=', date("Y-m-d"))->orWhereNull('order_date');
      })->get();
      $pAllergies= PatientAllergy::with(['Allergies'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $dentals = PatientDentals::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $examinations = PatientExaminations::with(['BodySites'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $pVitals = PatientVitalss::where(['ipd_type'=>1,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->orderBy('id','DESC')->get();
      $immunizations = PatientImmunizations::with(['Vaccine'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $proce_order = PatientProcedures::with(['Procedures'])->where('ipd_type','!=', '4')->where(['ipd_id'=>$ipd_request_id,'procedure_type'=>'order','status'=>0,'delete_status'=>1])->get();
      $pReferral = PatientReferrals::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();

      $eyesExam  = PatientEyesExaminations::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();
      $patient_eom = PatientEom::with(['Eom'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $patient_sle = PatientSle::with(['Sle'])->where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $patient_sys_ill = PatientSystematicIllness::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
      $patient_fundus = PatientFundus::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();
      $PatientSleCanvas = PatientSleCanvas::where(['ipd_id'=>$ipd_request_id])->first();
      $ot_template = PatientOtTemplate::with("OtReportTemplate")->where(['ipd_type'=>1,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();

	   return view('ipd.pages.ipdclinicalNote',compact('admitPatient','chiefComplaints','treatments','labs','pAllergies','procedures','pDiagnos','pVitals','examinations','dentals','eyes','proce_order','immunizations','patientDiagnosticImagings','pReferral','patient_eom','patient_sle','patient_sys_ill','patient_fundus','PatientSleCanvas','ot_template'));
   }

   public function patientVitals($id)
   {
	   $practiceId = Parent::getMyPractice();
     $id = base64_decode($id);
     $patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id,'delete_status'=>1])->first();
     $pVitals = PatientVitalss::with('Appointment')->where(['patient_id'=>$patient->pId,'delete_status'=>1])->paginate(10);
	 return view('ipd.pages.patient-vitals',compact('patient','pVitals'));
   }
   public function patientAllergies($id)
   {
	   $practiceId = Parent::getMyPractice();
     $id = base64_decode($id);
     $patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id,'delete_status'=>1])->first();
     $pAllergies = PatientAllergy::with(['Allergies','Appointment'])->where(['patient_id'=>$patient->pId,'delete_status'=>1])->paginate(10);
     return view('ipd.pages.patient-allergies',compact('patient','pAllergies'));
   }
   public function clinicalExaminations($id)
   {
  	$id = base64_decode($id);
	  $practiceId = Parent::getMyPractice();
  	$patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id,'delete_status'=>1])->first();
  	$examinations = PatientExaminations::with(['BodySites'])->where(['patient_id'=>$patient->pId,'delete_status'=>1])->paginate(10);
  	return view('ipd.pages.clinical-examinations',compact('patient','examinations'));
   }
   public function labResults($id)
   {
	  $practiceId = Parent::getMyPractice();
  	$id = base64_decode($id);
  	$patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id,'delete_status'=>1])->first();
  	// $labs =  PatientLabs::where(['patient_id'=>$patient->pId,'delete_status'=>1])->orderBy('id','desc')->paginate(10);
    $orders = LabOrders::with(['PatientLabs','Patient'])->where(['patient_id'=>$patient->pId,'order_status'=>0,'delete_status'=>1,'practice_id'=>$practiceId->practice_id])->orderBy('id', 'desc')->paginate(10);
  	return view('ipd.pages.lab-results',compact('patient','orders'));
   }
   public function diagnosticImaging($id)
   {
	  $practiceId = Parent::getMyPractice();
  	$id = base64_decode($id);
  	$patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id,'delete_status'=>1])->first();
  	$patientDiagnosticImagings =  PatientDiagnosticImagings::with(['RadiologyMaster'])->where(['patient_id'=>$patient->pId,'delete_status'=>1])->paginate(10);
  	return view('ipd.pages.diagnostic-imaging',compact('patient','patientDiagnosticImagings'));
   }
   public function patientDiagnosis($id)
   {
	  $practiceId = Parent::getMyPractice();
  	$id = base64_decode($id);
  	$patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id,'delete_status'=>1])->first();
  	$pDiagnos = PatientDiagnosis::with(['Diagnosis','Appointment'])->where(['patient_id'=>$patient->pId,'delete_status'=>1])->paginate(10);
  	return view('ipd.pages.patient-diagnosis',compact('patient','pDiagnos'));
   }
   public function patientPrescription($id)
   {
	  $practiceId = Parent::getMyPractice();
  	$id = base64_decode($id);
  	$patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id,'delete_status'=>1])->first();
    $treatments =  PatientMedications::with(['ItemDetails.ItemType','Appointment'])->where(['patient_id'=>$patient->pId,'delete_status'=>1])->groupBy('appointment_id')->paginate(10);
	 return view('ipd.pages.patient-prescription',compact('patient','treatments'));
   }
   public function procedureOrders($id)
   {
  	$practiceId = Parent::getMyPractice();
  	$id = base64_decode($id);
  	$patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id,'delete_status'=>1])->first();
  	$procedures = PatientProcedures::with(['Procedures','Appointment'])->where('ipd_type','!=', '4')->where(['patient_id'=>$patient->pId,'delete_status'=>1])->paginate(10);
  	return view('ipd.pages.procedure-orders',compact('patient','procedures'));
   }

   public function dentalProcedure($id){
  	$practiceId = Parent::getMyPractice();
  	$id = base64_decode($id);
    $patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id,'delete_status'=>1])->first();
    $dentals = PatientDentals::with(['Procedures','Appointment'])->where(['patient_id'=>$patient->pId,'added_by'=>$practiceId->practice_id,'delete_status'=>1])->paginate(10);
	  return view('ipd.pages.dental-procedures',compact('patient','dentals'));
   }

   public function eyesExamination($id){
  	$practiceId = Parent::getMyPractice();
  	$id = base64_decode($id);
  	$patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id,'delete_status'=>1])->first();
    $eyes = PatientEyes::with("Appointment")->where(['patient_id'=>$patient->pId,'added_by'=>$practiceId->practice_id,'delete_status'=>1])->paginate(10);
    return view('ipd.pages.eyes-examination',compact('patient','eyes'));
   }

   public function patientDocument(Request $request, $id)
   {
   	$id = base64_decode($id);
   	$urls = explode('/',$id);
    // pr(base64_decode($request->path));
  	$patient =  Appointments::with(['Patient','User.DoctorInfo'])->where(['id'=>$id,'delete_status'=>1])->first();
        if(isset($request->path)) {
           $path = base64_decode($request->path);
        }else{
              $path = 'uploads/PatientDocuments/'.$patient->Patient->patient_number;
        }
    	$files = array_slice(scandir($path), 2);
      // pr($files);
    	//echo "<pre>";print_r($files);die;
    	return view('ipd.pages.patient-document',compact('files','patient','path'));
   }

   public function clinicalNotePrint(Request $request)
   {
       if($request->isMethod('post')) {
         $ipd_request_id = $request->input('ipdId');
       $chart = $request->input('chart');
       $chart_height = $request->input('chart_height');
       $id = base64_decode($request->input('appointId'));
       $rows = $request->input('rows');

       $practiceId = Parent::getMyPractice();
       $admitPatient = IPDRequest::Where(['appointment_id'=>$id,'order_status' => 1,'delete_status' => 1])->first();
       $practice_detail =  PracticeDetails::where(['user_id'=>$practiceId->practice_id])->first();
       $patient =  Appointments::with(['Patient.PatientRagistrationNumbers','User.DoctorInfo'])->where(['id'=>$id,'delete_status'=>1])->first();
       $chiefComplaints =  ChiefComplaints::where(['ipd_type'=>1,'appointment_id'=>$id,'ipd_id'=>$ipd_request_id])->first();
       $treatments =  PatientMedications::with(['ItemDetails.ItemType'])->where(['ipd_type'=>1,'appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->get();
       $labs =  PatientLabs::with(['Labs'])->where(['appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->get();
       $pAllergies= PatientAllergy::with(['Allergies'])->where(['appointment_id'=>$id,'patient_id'=>$patient->pId,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->get();

       // $procedures = PatientProcedures::with(['Procedures'])->where(['appointment_id'=>$id,'procedure_type'=>'current','delete_status'=>1])->get();
       $procedures = PatientProcedures::with(['Procedures'])->where('ipd_type','!=', '4')->where(['appointment_id'=>$id,'procedure_type'=>'current','delete_status'=>1,'ipd_id'=>$ipd_request_id])->where(function ($query) {
       $query->where('order_date', '=', date("Y-m-d"))->orWhereNull('order_date');})->get();

       $pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_type'=>1,'appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->get();
       $pVitals = PatientVitalss::where(['ipd_type'=>1,'appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->first();
       $examinations = PatientExaminations::with(['BodySites'])->where(['appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->get();
       $proce_order = PatientProcedures::with(['Procedures'])->where('ipd_type','!=', '4')->where(['appointment_id'=>$id,'procedure_type'=>'order','status'=>0,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->get();
       $followUp = FollowUp::where('appointment_id',$id)->where(['added_by'=>$practiceId->practice_id])->first();
       $dentals = PatientDentals::where(['appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->get();
       $eyes = PatientEyes::where(['appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->first();
       $patientDiagnosticImagings =  PatientDiagnosticImagings::with(['RadiologyMaster'])->where(['appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->get();
       $pReferral = PatientReferrals::where(['appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->first();

	    $eyesExam  = PatientEyesExaminations::where(['appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->first();
	    $patient_eom = PatientEom::with(['Eom'])->where(['appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->get();
        $patient_sle = PatientSle::with(['Sle'])->where(['appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->get();
        $patient_sys_ill = PatientSystematicIllness::where(['appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->get();
        $patient_fundus = PatientFundus::where(['appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->first();
	    $PatientSleCanvas = PatientSleCanvas::where(['appointment_id'=>$id,'ipd_id'=>$ipd_request_id])->first();
		  $ot_template = PatientOtTemplate::with("OtReportTemplate")->where(['ipd_type'=>1,'appointment_id'=>$id,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->first();
      $immunizations = PatientImmunizations::with(['Vaccine'])->where(['appointment_id'=>$id,'patient_id'=>$patient->pId,'delete_status'=>1,'ipd_id'=>$ipd_request_id])->get();
		// pr($ot_template->OtReportTemplate);
        $docPath = 'uploads/PatientDocuments/'.$patient->Patient->patient_number.'/misc/';
               if(!is_dir($docPath)){
                  File::makeDirectory($docPath, $mode = 0777, true, true);
               }
               if(!file_exists($docPath.'clinicalNotePrint.pdf')){
                    File::copy(public_path().'/htmltopdfview.pdf', $docPath.'clinicalNotePrint.pdf');
               }
       $pdf = "";
       if($practice_detail->print_layout == '1') {
         //$chart = 'kap';
         $pdf = PDF::loadView('ipd.ajaxpages.clinical_note_print',compact('admitPatient','chart','chart_height','patient','chiefComplaints','labs','pAllergies','procedures','pDiagnos','pVitals','examinations','proce_order','treatments','patientDiagnosticImagings','practice_detail','rows','pReferral','dentals','eyes','followUp','eyesExam','patient_eom','patient_sle','patient_sys_ill','patient_fundus','PatientSleCanvas','ot_template','immunizations'));
       }
       else{
         $pdf = PDF::loadView('ipd.ajaxpages.clinical_note_print_without_hf',compact('admitPatient','chart','chart_height','patient','chiefComplaints','labs','pAllergies','procedures','pDiagnos','pVitals','examinations','proce_order','treatments','patientDiagnosticImagings','practice_detail','rows','pReferral','dentals','eyes','followUp','eyesExam','patient_eom','patient_sle','patient_sys_ill','patient_fundus','PatientSleCanvas','ot_template','immunizations'));
       }
       $output = $pdf->output();
       file_put_contents("uploads/PatientDocuments/".$patient->Patient->patient_number."/misc/clinicalNotePrint.pdf", $output);
       return 1;
       }
   }

   public function ipdDelete($id)
   {
       $id = base64_decode($id);
       RecycleBin::create(['slug' => 'IPDRequest','meta_data'=> json_encode(IPDRequest::where('id', $id)->first())]);
       IPDRequest::where('id', $id)->first()->delete();

       RecycleBin::create(['slug' => 'IPDDischarge','meta_data'=> json_encode(IPDDischarge::where('ipd_request_id', $id)->first())]);
       IPDDischarge::where('ipd_request_id', $id)->delete();

       RecycleBin::create(['slug' => 'IPDPatientBed','meta_data'=> json_encode(IPDPatientBed::where('ipd_request_id', $id)->first())]);
       IPDPatientBed::where('ipd_request_id', $id)->delete();

       RecycleBin::create(['slug' => 'IPDAdvanceBill','meta_data'=> json_encode(IPDAdvanceBill::where('ipd_request_id', $id)->get())]);
       IPDAdvanceBill::where('ipd_request_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientDiagnosis','meta_data'=> json_encode(PatientDiagnosis::where('ipd_id', $id)->get())]);
       PatientDiagnosis::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientProcedures','meta_data'=> json_encode(PatientProcedures::where('ipd_id', $id)->get())]);
       PatientProcedures::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'Appointments','meta_data'=> json_encode(Appointments::where('ipd_request_id', $id)->get())]);
       Appointments::where('ipd_request_id', $id)->delete();

       RecycleBin::create(['slug' => 'ChiefComplaints','meta_data'=> json_encode(ChiefComplaints::where('ipd_id', $id)->get())]);
       ChiefComplaints::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientEyes','meta_data'=> json_encode(PatientEyes::where('ipd_id', $id)->get())]);
       PatientEyes::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientAllergy','meta_data'=> json_encode(PatientAllergy::where('ipd_id', $id)->get())]);
       PatientAllergy::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientDentals','meta_data'=> json_encode(PatientDentals::where('ipd_id', $id)->get())]);
       PatientDentals::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientExaminations','meta_data'=> json_encode(PatientExaminations::where('ipd_id', $id)->get())]);
       PatientExaminations::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientVitalss','meta_data'=> json_encode(PatientVitalss::where('ipd_id', $id)->get())]);
       PatientVitalss::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientImmunizations','meta_data'=> json_encode(PatientImmunizations::where('ipd_id', $id)->get())]);
       PatientImmunizations::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientReferrals','meta_data'=> json_encode(PatientReferrals::where('ipd_id', $id)->get())]);
       PatientReferrals::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientEom','meta_data'=> json_encode(PatientEom::where('ipd_id', $id)->get())]);
       PatientEom::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientSle','meta_data'=> json_encode(PatientSle::where('ipd_id', $id)->get())]);
       PatientSle::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientSystematicIllness','meta_data'=> json_encode(PatientSystematicIllness::where('ipd_id', $id)->get())]);
       PatientSystematicIllness::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientFundus','meta_data'=> json_encode(PatientFundus::where('ipd_id', $id)->get())]);
       PatientFundus::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientSleCanvas','meta_data'=> json_encode(PatientSleCanvas::where('ipd_id', $id)->get())]);
       PatientSleCanvas::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientOtTemplate','meta_data'=> json_encode(PatientOtTemplate::where('ipd_id', $id)->get())]);
       PatientOtTemplate::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'PatientEyesExaminations','meta_data'=> json_encode(PatientEyesExaminations::where('ipd_id', $id)->get())]);
       PatientEyesExaminations::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'NeonatologyManagement','meta_data'=> json_encode(NeonatologyManagement::where('ipd_id', $id)->get())]);
       NeonatologyManagement::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'BornChecklist','meta_data'=> json_encode(BornChecklist::where('ipd_id', $id)->get())]);
       BornChecklist::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'MeternalHistory','meta_data'=> json_encode(MeternalHistory::where('ipd_id', $id)->get())]);
       MeternalHistory::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'NeonatologyTreatment','meta_data'=> json_encode(NeonatologyTreatment::where('ipd_id', $id)->get())]);
       NeonatologyTreatment::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'NeonatologyHistory','meta_data'=> json_encode(NeonatologyHistory::where('ipd_id', $id)->get())]);
       NeonatologyHistory::where('ipd_id', $id)->delete();

       RecycleBin::create(['slug' => 'DischargeHistory','meta_data'=> json_encode(DischargeHistory::where('ipd_id', $id)->get())]);
       DischargeHistory::where('ipd_id', $id)->delete();


       Session::flash('message', "IPD Records Deleted Successfully");
       return redirect()->route('ipd.index');
  }

   public function mergeTemplates(Request $request){
       if ($request->isMethod('post')) {
        $data = $request->all();
        $Aid = $data['appointment_id'];
        $templateData = TemplateMeta::where(['temp_id'=>$data['temp_id']])->get();
        $user = Auth::id();
        $practiceId = Parent::getMyPractice();
         foreach($templateData as $tempData){
             if($tempData->meta_key == 'chiefComplaint') {
               if(checkClinicalNoteModulePermission(1)){
                 $checkChief = ChiefComplaints::where(['appointment_id'=>$data['appointment_id'],'pId'=>$data['patient_id']])->first();
                  if(!empty($checkChief) > 0) {
                      $finalarr = json_encode((object)(array_merge(json_decode($checkChief->data, true), json_decode($tempData->meta_data, true))));
                       ChiefComplaints::where('id',$checkChief->id)->update(array('data' => $finalarr));
                   }
                   else{
                       ChiefComplaints::create([
                          'appointment_id' =>  $data['appointment_id'],
                          'ipd_id' =>  $data['ipd_id'],
                          'pId' =>  $data['patient_id'],
                          'data'=>  $tempData->meta_data,
                          'added_by' => $user
                       ]);
                   }
                }
             }
             else if($tempData->meta_key == 'medication'){
               if(checkClinicalNoteModulePermission(4)){
                      $medData = json_decode($tempData->meta_data);
                      $orderId='';
                      $check_medorder =  PatientMedications::where(['appointment_id'=>$data['appointment_id'],'patient_id'=>$data['patient_id'],'delete_status'=>1])->first();
                      if(!empty($check_medorder) && !empty($check_medorder) > 0 && !empty($check_medorder->order_id)){
                          $orderId = $check_medorder->order_id;
                      }
                      else{
                        $order = MedicineOrders::create([
                            'appointment_id'=>$data['appointment_id'],
                            'ipd_id' =>  $data['ipd_id'],
                            'patient_id'=>$data['patient_id'],
                            'order_by' => $data['doc_id'],
                            'doctor_type' => 1,
                            'practice_id' => $practiceId->practice_id,
                        ]);
                          $orderId = $order->id;
                      }
				   foreach($medData as $med){
                         PatientMedications::create([
        		              'appointment_id'=>$data['appointment_id'],
        		              'patient_id'=>$data['patient_id'],
							  'ipd_id' =>  $data['ipd_id'],
        		              'drug_id' => $med->drug_id,
                          'strength' => $med->strength,
        		              'strength_id' => (isset($med->strength_id) ? $med->strength_id : null),
        		              'unit' => $med->unit,
        		              // 'quantity' => $med->qty,
        		              'frequency' =>$med->frequency,
                          'frequency_type' => (isset($med->frequency_type) ? $med->frequency_type : null),
        		              // 'route' => $med->route,
                          'duration' => $med->duration,
                          'duration_type' => (isset($med->duration_type) ? $med->duration_type : null),
        		              'medi_instruc' => (isset($med->medi_instruc) ? $med->medi_instruc : null),
                          'order_id' => $orderId,
        		              'added_by' => $user
  		                  ]);
                    }
                }
             }
             else if($tempData->meta_key == 'lab'){
                 if(checkClinicalNoteModulePermission(6)){
                      $meta = json_decode($tempData->meta_data);
                      $orderId='';
                      $check_labOrder =  PatientLabs::where(['appointment_id'=>$data['appointment_id'],'patient_id'=>$data['patient_id'],'delete_status'=>1])->first();
                      if(!empty($check_labOrder) && !empty($check_labOrder) > 0 && !empty($check_labOrder->order_id)){
                          $orderId = $check_labOrder->order_id;
                      }else{
                        $order = LabOrders::create([
                            'patient_id'=>$data['patient_id'],
                            'order_by' => $data['doc_id'],
                            'doctor_type' => 1,
                            'practice_id' => $practiceId->practice_id,
                        ]);
                          $orderId = $order->id;
                      }
                      foreach($meta as $lab){
                        PatientLabs::create([
                       'appointment_id'=>$data['appointment_id'],
                       'ipd_id' =>  $data['ipd_id'],
                       'ipd_type' =>  $data['ipd_type'],
                       'patient_id'=>$data['patient_id'],
                       'lab_id' => $lab->lab_id,
                       'instructions' => $lab->instructions,
                       'order_id' => $orderId,
                       'added_by' => $user
                       ]);
                  }
               }
             }
             else if($tempData->meta_key == 'allergies'){
                 if(checkClinicalNoteModulePermission(9)){
                    $meta = json_decode($tempData->meta_data);
                   foreach($meta as $allergy){
                      PatientAllergy::create([
                         'appointment_id'=>$data['appointment_id'],
                         'ipd_id' =>  $data['ipd_id'],
                         'patient_id'=>$data['patient_id'],
                         'allergy_type' => $allergy->allergy_type,
                         'allergy_id' => $allergy->allergy_id,
                         'allergy_reactions' => $allergy->reactions,
                         'severity' => $allergy->severity,
                         'notes' => $allergy->notes,
                         'added_by' => $user
                      ]);
                   }
                }
             }
             else if($tempData->meta_key == 'procedures'){
               if(checkClinicalNoteModulePermission(8)){
                    $meta = json_decode($tempData->meta_data);
                   foreach($meta as $proced){
                        PatientProcedures::create([
                           'appointment_id'=>$data['appointment_id'],
                           'ipd_id' =>  $data['ipd_id'],
                           'patient_id'=>$data['patient_id'],
                           'procedure_type' => $proced->procedure_type,
                           'procedure_id' => $proced->procedure_id,
                           'notes' => $proced->notes,
                           'added_by' => $user
                           ]);
                       }
                  }
             }
             else if($tempData->meta_key == 'diagnosis'){
               if(checkClinicalNoteModulePermission(2)){
                    $meta = json_decode($tempData->meta_data);
                   foreach($meta as $diagno){
                        PatientDiagnosis::create([
                         'appointment_id'=>$data['appointment_id'],
                         'ipd_id' =>  $data['ipd_id'],
                         'patient_id'=>$data['patient_id'],
                         'diagnosis_id' => $diagno->diagnosis_id,
                         'notes' => $diagno->notes,
                         'added_by' => $user
                       ]);
                   }
                 }
             }
             else if($tempData->meta_key == 'diagnosticImaging'){
               if(checkClinicalNoteModulePermission(7)){
                    $meta = json_decode($tempData->meta_data);
                    $orderId='';
                    $check_order =  PatientDiagnosticImagings::where(['appointment_id'=>$data['appointment_id'],'patient_id'=>$data['patient_id'],'delete_status'=>1])->first();
                    if(!empty($check_order) && !empty($check_order) > 0 && !empty($check_order->order_id)){
                        $orderId = $check_order->order_id;
                    }
                    else{
                      $order = RadiologyOrders::create([
                          'patient_id'=>$data['patient_id'],
                          'order_by' => $data['doc_id'],
                          'doctor_type' => 1,
                          'practice_id' => $practiceId->practice_id,
                      ]);
                        $orderId = $order->id;
                    }
                   foreach($meta as $di){
                        PatientDiagnosticImagings::create([
                         'appointment_id'=>$data['appointment_id'],
                         'ipd_id' =>  $data['ipd_id'],
                         'patient_id'=>$data['patient_id'],
                         'lab_id' => $di->lab_id,
                         'order_id' => $orderId,
                         'instructions' => $di->instructions,
                       ]);
                   }
                }
             }
         }
         return redirect()->route('ipd.IPDClinicalNotes', base64_encode($Aid));
       }
       else{
           return redirect()->route('ipd.IPDClinicalNotes', base64_encode($Aid));
       }
   }
   public function printSticker(Request $request)
   {
     $ipdID = $request->ipdID;
      $total_sticker = $request->total_sticker;
    //  dd($total_sticker);
      $IPDRequest = IPDRequest::with('Patients')->Where(['id' => $ipdID])->orderBy('id','DESC')->first();
      $patients = $IPDRequest->Patients;
        $pdf = PDF::loadView('ipd.printSticker',compact('IPDRequest','total_sticker'));
        $output = $pdf->output();
        $docPath = 'uploads/PatientDocuments/'.$patients->patient_number.'/misc/';
        if(!is_dir($docPath)){
           File::makeDirectory($docPath, $mode = 0777, true, true);
        }
        if(!file_exists($docPath.'printSticker.pdf')){
             File::copy(public_path().'/htmltopdfview.pdf', $docPath.'printSticker.pdf');
        }
        file_put_contents("uploads/PatientDocuments/".$patients->patient_number."/misc/printSticker.pdf", $output);
        return 1;
   }

   public function printAdmissionSlip(Request $request)
   {
      $ipdID = $request->ipdID;
      
      $total_sticker = $request->total_sticker;
      $IPDPatientBed = IPDPatientBed::with('IPDRequest.Patients')->Where(['ipd_request_id' => $ipdID])->orderBy('id','DESC')->first();
      $practice_detail = PracticeDetails::where(['user_id'=>2])->first();
      $patients = @$IPDPatientBed->IPDRequest->Patients;
      //  dd($ipdID);
        $pdf = PDF::loadView('ipd.printAdmissionSlip',compact('IPDPatientBed','practice_detail'));
        $output = $pdf->output();
        $docPath = 'uploads/PatientDocuments/'.$patients->patient_number.'/misc/';
        if(!is_dir($docPath)){
           File::makeDirectory($docPath, $mode = 0777, true, true);
        }
        if(!file_exists($docPath.'printAdmissionSlip.pdf')){
             File::copy(public_path().'/htmltopdfview.pdf', $docPath.'printAdmissionSlip.pdf');
        }
        file_put_contents("uploads/PatientDocuments/".$patients->patient_number."/misc/printAdmissionSlip.pdf", $output);
        return 1;
    }

	public function pediatricPatientSaveDischarge(Request $request) {
         if($request->isMethod('post')) {
            $data = $request->all();
         
              $docId='';
              $ResidentInfo='';
              $cunsultantinfo='';
              $docInfoId=[];
              if(isset($data['cunsultant_doc_id'])){
                $docId=$data['cunsultant_doc_id'];
                $docInfoId['cunsultant_doc_id']=$docId;
                
              } 
              
              if(isset($data['resident_doc_id'])){
            
                $docId=$data['resident_doc_id'];
                $docInfoId['resident_doc_id']=$docId;
              

              } 

              $jsondocinfoData='';
              if(count($docInfoId)>0){
               $jsondocinfoData= json_encode($docInfoId);
              }
              

            if (isset($data['discharge_datetime'])) {
              $DisDateTime =  $data['discharge_datetime'];
            } else {
              $DisDateTime = date('Y-m-d H:i:s');
            }
            if(!empty($data['ipd_id'])) {
              if(empty($data['id'])) {
                 $ipd_discharge =  IPDDischarge::create([
                     'ipd_request_id' =>  $data['ipd_id'],
                     'ipd_type' =>  1,
                     'brief_summary' =>  $data['brief_summary'],
                     'operativefinding' =>  json_encode($data['operativefinding']),
                     'follow_up' =>  (!empty($data['follow_up']) ? date('Y-m-d',strtotime($data['follow_up'])) : null),
                     'discharge_diet' =>  $data['discharge_diet'],
                     'outcome' =>  $data['outcome'],
                     'discharge_note'=>  $data['discharge_note'],
                     'discharge_date'=>  $DisDateTime,
                     'doctor_info_ids'=>$jsondocinfoData,
                   ]);

				      }
				       else{

         
                  IPDDischarge::where('id', $data['id'])->update(array('ipd_request_id' =>  $data['ipd_id'],
                  'brief_summary' =>  $data['brief_summary'],
                  'operativefinding' => json_encode($data['operativefinding']),
                  'follow_up' =>  (!empty($data['follow_up']) ? date('Y-m-d',strtotime($data['follow_up'])) : null),
                  'discharge_diet' =>  $data['discharge_diet'],
                  'outcome' =>  $data['outcome'],
                  'discharge_note'=>  $data['discharge_note'],
                  'discharge_date' => $DisDateTime,
                  'doctor_info_ids'=>$jsondocinfoData,
                  ));
                  $ipd_discharge = IPDDischarge::where('id', $data['id'])->first();
                  
				}
					if ($data['dischargeStatus'] == 1) {
					  IPDRequest::where('id', $data['ipd_id'])->update(array('status' => 0));
					}
       
     
       $ipd_patient_detail = IPDRequest::Where('id', '=', $data['ipd_id'])->first();
        $IPDPatientBed = IPDPatientBed::Where('ipd_request_id', '=', $data['ipd_id'])->first();
				$pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_type'=>2,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
				$treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_type'=>2,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
				$chiefComplaints =  ChiefComplaints::where(['ipd_type'=>2,'ipd_id'=>$data['ipd_id']])->first();
				$pVitals = PatientVitalss::where(['ipd_type'=>2,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->first();
				$practice_detail = PracticeDetails::where(['user_id'=>2])->first();

			   $pAllergyHistory = PatientAllergyHistory::where(['ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
			   $dischargeHistory = DischargeHistory::where(['ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
			   $ot_template = PatientOtTemplate::with("OtReportTemplate")->where(['type'=>'1','ipd_id'=>$data['ipd_id'],'delete_status'=>1])->first();
			   $advise_template = PatientOtTemplate::with("OtReportTemplate")->where(['ipd_type'=>2,'type'=>'2','ipd_id'=>$data['ipd_id'],'delete_status'=>1])->first();
			   $charts = PatientGrowthChart::where(['discharge_type'=>2,'ipd_request_id'=>$data['ipd_id']])->get();
				$docPath = 'uploads/PatientDocuments/'.$ipd_patient_detail->Patients->patient_number.'/ipd/';
				if(!is_dir($docPath)){
				   File::makeDirectory($docPath, $mode = 0777, true, true);
				}
				if(!file_exists($docPath.'ipdDischargePrint.pdf')) {
					 File::copy(public_path().'/htmltopdfview.pdf', $docPath.'ipdDischargePrint.pdf');
				}

        if(File::exists($docPath.'ipdDischargePrint.pdf')){
          File::delete($docPath.'ipdDischargePrint.pdf');
        }

    
        if(isset($data['cunsultant_doc_id'])){
          $docId=$data['cunsultant_doc_id'];
        
          $cunsultantinfo = DoctorsInfo::select('first_name','last_name','id','doctor_sign')->Where('id', $docId)->first();
        } 
        
        if(isset($data['resident_doc_id'])){
      
          $docId=$data['resident_doc_id'];
        
          $ResidentInfo = DoctorsInfo::select('first_name','last_name','id','doctor_sign')->Where('id', $docId)->first();

        } 
				$pdf = PDF::loadView('ipd.pages.ipd_pediatric_discharge_print',compact('practice_detail','chiefComplaints','pVitals','ipd_patient_detail','ipd_discharge','pDiagnos','treatments','pAllergyHistory','dischargeHistory','ot_template','advise_template','charts','IPDPatientBed','cunsultantinfo','ResidentInfo'));
				$output = $pdf->output();
				file_put_contents("uploads/PatientDocuments/".$ipd_patient_detail->Patients->patient_number."/ipd/ipdDischargePrint.pdf", $output);
				return 1;
           }
       }
   }


    public function pediatricDischargedPatientPrint(Request $request)
        {
        if ($request->isMethod('post')) {
        $data = $request->all();
        $data['ipd_id'] = base64_decode($data['ipd_id']);
        $practiceId = Parent::getMyPractice()->practice_id;
        $practice_detail =  PracticeDetails::where(['user_id'=>$practiceId])->first();

        $ipd_discharge = IPDDischarge::Where(['ipd_request_id'=>$data['ipd_id']])->orderBy('id','DESC')->first();

		$ipd_patient_detail = IPDRequest::Where('id', '=', $data['ipd_id'])->first();
		$pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_type'=>2,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
		$treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_type'=>2,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
		$chiefComplaints =  ChiefComplaints::where(['ipd_type'=>2,'ipd_id'=>$data['ipd_id']])->first();
		$pVitals = PatientVitalss::where(['ipd_type'=>2,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->first();
		$practice_detail = PracticeDetails::where(['user_id'=>2])->first();

	   $pAllergyHistory = PatientAllergyHistory::where(['ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
	   $dischargeHistory = DischargeHistory::where(['ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
	   $ot_template = PatientOtTemplate::with("OtReportTemplate")->where(['type'=>'1','ipd_id'=>$data['ipd_id'],'delete_status'=>1])->first();
	   $advise_template = PatientOtTemplate::with("OtReportTemplate")->where(['ipd_type'=>2,'type'=>'2','ipd_id'=>$data['ipd_id'],'delete_status'=>1])->first();
	   $charts = PatientGrowthChart::where(['discharge_type'=>2,'ipd_request_id'=>$data['ipd_id']])->get();

         $docPath = 'uploads/PatientDocuments/'.$ipd_patient_detail->Patients->patient_number.'/ipd/';
          if(!is_dir($docPath)){
             File::makeDirectory($docPath, $mode = 0777, true, true);
          }
          if(!file_exists($docPath.'ipdDischargePrint.pdf')) {
               File::copy(public_path().'/htmltopdfview.pdf', $docPath.'ipdDischargePrint.pdf');
          }

		  $pdf = PDF::loadView('ipd.pages.ipd_pediatric_discharge_print',compact('practice_detail','chiefComplaints','pVitals','ipd_patient_detail','ipd_discharge','pDiagnos','treatments','pAllergyHistory','dischargeHistory','ot_template','advise_template','charts'));
          $output = $pdf->output();
          file_put_contents("uploads/PatientDocuments/".$ipd_patient_detail->Patients->patient_number."/ipd/ipdDischargePrint.pdf", $output);
          $arr = array('ipd_id'=>$ipd_patient_detail->id,'patient_email'=>$ipd_patient_detail->Patients->email,'p_phone'=>$ipd_patient_detail->Patients->mobile_no,'patient_number'=>$ipd_patient_detail->Patients->patient_number);
          return $arr;
        }
     }
     public function neonatologyPatientSaveDischarge(Request $request) {
            if($request->isMethod('post')) {
               $data = $request->all();

               $docId='';
               $ResidentInfo='';
               $cunsultantinfo='';
               $docInfoId=[];
               if(isset($data['cunsultant_doc_id'])){
                 $docId=$data['cunsultant_doc_id'];
                 $docInfoId['cunsultant_doc_id']=$docId;
                 
               } 
               
               if(isset($data['resident_doc_id'])){
             
                 $docId=$data['resident_doc_id'];
                 $docInfoId['resident_doc_id']=$docId;
               
 
               } 
 
               $jsondocinfoData='';
               if(count($docInfoId)>0){
                $jsondocinfoData= json_encode($docInfoId);
               }

               if (isset($data['discharge_date'])) {
                 $DisDateTime = date('Y-m-d', strtotime($data['discharge_date'])).' '.date('H:i:s', strtotime($data['discharge_time']));
               }
               else {
                 $DisDateTime = date('Y-m-d H:i:s');
               }
               if(!empty($data['ipd_id'])) {
                 if(empty($data['id'])) {
                    $ipd_discharge =  IPDDischarge::create([
                        'ipd_request_id' =>  $data['ipd_id'],
                        'ipd_type' =>  2,
                        'brief_summary' =>  $data['brief_summary'],
                        'operativefinding' =>  json_encode($data['operativefinding']),
                        'follow_up' =>  (!empty($data['follow_up']) ? date('Y-m-d',strtotime($data['follow_up'])) : null),
                        'discharge_diet' =>  $data['discharge_diet'],
                        'outcome' =>  $data['outcome'],
                        'discharge_note'=>  $data['discharge_note'],
                        'doctor_info_ids'=>$jsondocinfoData,
                      ]);

   				      }
   				else{
                     IPDDischarge::where('id', $data['id'])->update(array('ipd_request_id' =>  $data['ipd_id'],
                     'brief_summary' =>  $data['brief_summary'],
                     'operativefinding' => json_encode($data['operativefinding']),
                     'follow_up' =>  (!empty($data['follow_up']) ? date('Y-m-d',strtotime($data['follow_up'])) : null),
                     'discharge_diet' =>  $data['discharge_diet'],
                     'outcome' =>  $data['outcome'],
                     'discharge_note'=>  $data['discharge_note'],
                     'created_at' => $DisDateTime,
                     'doctor_info_ids'=>$jsondocinfoData,
                     ));
                     $ipd_discharge = IPDDischarge::where('id', $data['id'])->first();
   				}
           if ($data['dischargeStatus'] == 1) {
             IPDRequest::where('id', $data['ipd_id'])->update(array('status' => 0));
           }
   				$ipd_patient_detail = IPDRequest::Where('id', '=', $data['ipd_id'])->first();
   				$pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
   				$treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
   				$chiefComplaints =  ChiefComplaints::where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id']])->first();
   				$practice_detail = PracticeDetails::where(['user_id'=>2])->first();
   			  $dischargeHistory = DischargeHistory::where(['ipd_type'=>2,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
          $ot_template = PatientOtTemplate::with("OtReportTemplate")->where(['type'=>'1','ipd_type'=>3,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->first();
          $NeonatologyHistory =  NeonatologyHistory::where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id']])->first();
          $MeternalHistory =  MeternalHistory::where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id']])->first();
          $NeonatologyManagement =  NeonatologyManagement::where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id']])->first();
          $NeonatologyTreatment =  NeonatologyTreatment::where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id']])->first();
          $BornChecklist =  BornChecklist::where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id']])->first();
          $labs =  PatientLabs::with(['Labs','LabOrders'])->where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
			    $charts = PatientGrowthChart::where(['discharge_type'=>3,'ipd_request_id'=>$data['ipd_id']])->get();
   				$docPath = 'uploads/PatientDocuments/'.$ipd_patient_detail->Patients->patient_number.'/ipd/';
           if(isset($data['cunsultant_doc_id'])){
            $docId=$data['cunsultant_doc_id'];
          
            $cunsultantinfo = DoctorsInfo::select('first_name','last_name','id','doctor_sign')->Where('id', $docId)->first();
          } 
          
          if(isset($data['resident_doc_id'])){
        
            $docId=$data['resident_doc_id'];
          
            $ResidentInfo = DoctorsInfo::select('first_name','last_name','id','doctor_sign')->Where('id', $docId)->first();
  
          }
   				if(!is_dir($docPath)){
   				   File::makeDirectory($docPath, $mode = 0777, true, true);
   				}
   				if(!file_exists($docPath.'ipdDischargePrint.pdf')) {
   					 File::copy(public_path().'/htmltopdfview.pdf', $docPath.'ipdDischargePrint.pdf');
   				}
           if(isset($data['cunsultant_doc_id'])){
            $docId=$data['cunsultant_doc_id'];
          
            $cunsultantinfo = DoctorsInfo::select('first_name','last_name','id','doctor_sign')->Where('id', $docId)->first();
          } 
          
          if(isset($data['resident_doc_id'])){
        
            $docId=$data['resident_doc_id'];
          
            $ResidentInfo = DoctorsInfo::select('first_name','last_name','id','doctor_sign')->Where('id', $docId)->first();
  
          } 
   				$pdf = PDF::loadView('ipd.pages.ipd_neonatology_discharge_print',compact('practice_detail','chiefComplaints','ipd_patient_detail','ipd_discharge','pDiagnos','treatments','dischargeHistory','ot_template','NeonatologyHistory','MeternalHistory','NeonatologyManagement','NeonatologyTreatment','BornChecklist','labs','charts','cunsultantinfo','ResidentInfo'));
   				$output = $pdf->output();
   				file_put_contents("uploads/PatientDocuments/".$ipd_patient_detail->Patients->patient_number."/ipd/ipdDischargePrint.pdf", $output);
   				return 1;
              }
          }
      }
     public function neonatologyDischargedPatientPrint(Request $request)
         {
         if ($request->isMethod('post')) {
         $data = $request->all();
         $data['ipd_id'] = base64_decode($data['ipd_id']);
         $practiceId = Parent::getMyPractice()->practice_id;
         $practice_detail =  PracticeDetails::where(['user_id'=>$practiceId])->first();

         $ipd_discharge = IPDDischarge::Where(['ipd_request_id'=>$data['ipd_id']])->orderBy('id','DESC')->first();

         $ipd_patient_detail = IPDRequest::Where('id', '=', $data['ipd_id'])->first();
         $pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
         $treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
         $chiefComplaints =  ChiefComplaints::where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id']])->first();
         $practice_detail = PracticeDetails::where(['user_id'=>2])->first();
         $dischargeHistory = DischargeHistory::where(['ipd_type'=>2,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
         $ot_template = PatientOtTemplate::with("OtReportTemplate")->where(['type'=>'1','ipd_type'=>3,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->first();
         $NeonatologyHistory =  NeonatologyHistory::where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id']])->first();
         $MeternalHistory =  MeternalHistory::where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id']])->first();
         $NeonatologyManagement =  NeonatologyManagement::where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id']])->first();
         $NeonatologyTreatment =  NeonatologyTreatment::where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id']])->first();
         $BornChecklist =  BornChecklist::where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id']])->first();
         $labs =  PatientLabs::with(['Labs','LabOrders'])->where(['ipd_type'=>3,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
		     $charts = PatientGrowthChart::where(['discharge_type'=>3,'ipd_request_id'=>$data['ipd_id']])->get();
          $docPath = 'uploads/PatientDocuments/'.$ipd_patient_detail->Patients->patient_number.'/ipd/';
           if(!is_dir($docPath)){
              File::makeDirectory($docPath, $mode = 0777, true, true);
           }
           if(!file_exists($docPath.'ipdDischargePrint.pdf')) {
                File::copy(public_path().'/htmltopdfview.pdf', $docPath.'ipdDischargePrint.pdf');
           }

           $pdf = PDF::loadView('ipd.pages.ipd_neonatology_discharge_print',compact('practice_detail','chiefComplaints','ipd_patient_detail','ipd_discharge','pDiagnos','treatments','dischargeHistory','ot_template','NeonatologyHistory','MeternalHistory','NeonatologyManagement','NeonatologyTreatment','BornChecklist','labs','charts'));
           $output = $pdf->output();
           file_put_contents("uploads/PatientDocuments/".$ipd_patient_detail->Patients->patient_number."/ipd/ipdDischargePrint.pdf", $output);
           $arr = array('ipd_id'=>$ipd_patient_detail->id,'patient_email'=>$ipd_patient_detail->Patients->email,'p_phone'=>$ipd_patient_detail->Patients->mobile_no,'patient_number'=>$ipd_patient_detail->Patients->patient_number);
           return $arr;
         }
  }

    public function saveGynecologySummary(Request $request) {
      if($request->isMethod('post')) {
        $data = $request->all();
        $row = GynecologyDischargeSummary::Where('ipd_request_id', $data['ipd_id'])->first();
        if (empty($row)) {
          $row = new GynecologyDischargeSummary();
        }
        $row->ipd_request_id = $data['ipd_id'];
        if ($data['type'] == 'indication') {
          $row->indication = $data['indication'];
        }
        if ($data['type'] == 'pmsh') {
          $row->pmsh = $data['pmsh'];
        }
        if ($data['type'] == 'baby_deatils') {
          $row->baby_deatils = $data['baby_deatils'];
        }
        if ($data['type'] == 'menstrual_history') {
          $row->menstrual_history = $data['menstrual_history'];
        }
        if ($data['type'] == 'obstetric_history') {
          $row->obstetric_history = $data['obstetric_history'];
        }
        if ($data['type'] == 'antenatal_period') {
          $row->antenatal_period = $data['antenatal_period'];
        }
        if ($data['type'] == 'exam_findings') {
          $row->exam_findings = $data['exam_findings'];
        }
        if ($data['type'] == 'usg') {
          $row->usg = $data['usg'];
        }
        if ($data['type'] == 'indication_2') {
          $row->indication_2 = $data['indication_2'];
        }
        if ($data['type'] == 'level') {
          $row->level = $data['level'];
        }
        if ($data['type'] == 'intraoprative') {
          $row->intraoprative = $data['intraoprative'];
        }
        if ($data['type'] == 'postoprative') {
          $row->postoprative = $data['postoprative'];
        }
        if ($data['type'] == 'baby1') {
          $row->baby1 = $data['baby1'];
        }
        if ($data['type'] == 'treatment_note') {
          $row->mother_note = $data['mother_note'];
          $row->child_note = $data['child_note'];
        }
        $row->save();
        return 1;
      }
    }
    public function gynecologyPatientDischarge($id){
        $ipd_request_id = base64_decode($id);
        $admitPatient = IPDRequest::Where('id', '=', $ipd_request_id)->first();
        $pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_type'=>4,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
        $chiefComplaints =  ChiefComplaints::where(['ipd_type'=>4,'ipd_id'=>$ipd_request_id])->first();
        $treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_type'=>4,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
        $labs =  PatientLabs::with(['Labs','LabOrders'])->where(['ipd_type'=>4,'ipd_id'=>$ipd_request_id,'delete_status'=>1])->get();
        $IPDDischarge = IPDDischarge::where('ipd_request_id', $ipd_request_id)->first();
        $company_names= CompanyName::where(['status'=>1])->get();
        $item_categories = DB::table('item_category')->where('status','1')->get();
        $item_types = DB::table('item_type')->where('status', '1')->get();
        $item_routes = DB::table('item_route')->where('status', '1')->get();
        $DischargeSummary = GynecologyDischargeSummary::Where('ipd_request_id', $ipd_request_id)->first();
        $procedures = PatientProcedures::with(['Procedures'])->where(['ipd_type'=>4,'ipd_id'=>$ipd_request_id,'procedure_type'=>'current','delete_status'=>1])->where(function ($query) {
        $query->where('order_date', '=', date("Y-m-d"))->orWhereNull('order_date');
        })->get();
        $DoctorsInfo= DoctorsInfo::select('first_name','last_name','id')->where(['discharge_view'=>1])->get();
        $doctorIfoids=[];
        if(isset($IPDDischarge->doctor_info_ids) && $IPDDischarge->doctor_info_ids!=''){
 
         $doctorIfoids=json_decode($IPDDischarge->doctor_info_ids,true);
 
        }
        return view('ipd.gynecologyPatientDischarge',compact('admitPatient','IPDDischarge','chiefComplaints','treatments','pDiagnos','labs','company_names','item_categories','item_types','item_routes','DischargeSummary','procedures','DoctorsInfo','doctorIfoids'));
    }
    public function gynecologyPatientSaveDischarge(Request $request) {
         if($request->isMethod('post')) {
            $data = $request->all();
            $docInfoId=[];
            if (isset($data['discharge_date'])) {
              $DisDateTime = date('Y-m-d', strtotime($data['discharge_date'])).' '.date('H:i:s', strtotime($data['discharge_time']));
            }
            else {
              $DisDateTime = date('Y-m-d H:i:s');
            }
            if(isset($data['cunsultant_doc_id'])){
              $docId=$data['cunsultant_doc_id'];
              $docInfoId['cunsultant_doc_id']=$docId;
              
            } 
            
            if(isset($data['resident_doc_id'])){
          
              $docId=$data['resident_doc_id'];
              $docInfoId['resident_doc_id']=$docId;
            

            } 

            $jsondocinfoData='';
            if(count($docInfoId)>0){
             $jsondocinfoData= json_encode($docInfoId);
            }
            if(!empty($data['ipd_id'])) {
              if(empty($data['id'])) {
                 $ipd_discharge =  IPDDischarge::create([
                     'ipd_request_id' =>  $data['ipd_id'],
                     'ipd_type' =>  3,
                     'brief_summary' =>  $data['brief_summary'],
                     'operativefinding' =>  json_encode($data['operativefinding']),
                     'follow_up' =>  (!empty($data['follow_up']) ? date('Y-m-d',strtotime($data['follow_up'])) : null),
                     'discharge_diet' =>  $data['discharge_diet'],
                     'outcome' =>  $data['outcome'],
                     'discharge_note'=>  $data['discharge_note'],
                     'doctor_info_ids'=>$jsondocinfoData,
                  ]);
              }
            else
            {
                IPDDischarge::where('id', $data['id'])->update(array('ipd_request_id' =>  $data['ipd_id'],
                'brief_summary' =>  $data['brief_summary'],
                'operativefinding' => json_encode($data['operativefinding']),
                'follow_up' =>  (!empty($data['follow_up']) ? date('Y-m-d',strtotime($data['follow_up'])) : null),
                'discharge_diet' =>  $data['discharge_diet'],
                'outcome' =>  $data['outcome'],
                'discharge_note'=>  $data['discharge_note'],
                'created_at' => $DisDateTime,
                'doctor_info_ids'=>$jsondocinfoData,
                ));
                $ipd_discharge = IPDDischarge::where('id', $data['id'])->first();
            }
            if ($data['dischargeStatus'] == 1) {
              IPDRequest::where('id', $data['ipd_id'])->update(array('status' => 0));
            }
            $IPDDischarge = IPDDischarge::where('ipd_request_id', $data['ipd_id'])->first();
            $doctorIfoids=[];
            if(isset($IPDDischarge->doctor_info_ids) && $IPDDischarge->doctor_info_ids!=''){
 
              $doctorIfoids=json_decode($IPDDischarge->doctor_info_ids,true);
      
             }
             $cunsultantinfo=[];    
        if(isset($data['cunsultant_doc_id'])){
          $docId=$data['cunsultant_doc_id'];
        
          $cunsultantinfo = DoctorsInfo::select('first_name','last_name','id','doctor_sign')->Where('id', $docId)->first();
        } 
        $ResidentInfo=[]; 
        if(isset($data['resident_doc_id'])){
      
          $docId=$data['resident_doc_id'];
        
          $ResidentInfo = DoctorsInfo::select('first_name','last_name','id','doctor_sign')->Where('id', $docId)->first();

        }
               $ipd_patient_detail = IPDRequest::Where('id', '=', $data['ipd_id'])->first();
               $pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_type'=>4,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
               $treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_type'=>4,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
               $chiefComplaints =  ChiefComplaints::where(['ipd_type'=>4,'ipd_id'=>$data['ipd_id']])->first();
               $practice_detail = PracticeDetails::where(['user_id'=>2])->first();
               $labs =  PatientLabs::with(['Labs','LabOrders'])->where(['ipd_type'=>4,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
               $procedures = PatientProcedures::with(['Procedures'])->where(['ipd_type'=>4,'procedure_type'=>'current','delete_status'=>1,'ipd_id'=>$data['ipd_id']])->get();
               $summary = GynecologyDischargeSummary::Where('ipd_request_id', $data['ipd_id'])->first();
               $docPath = 'uploads/PatientDocuments/'.$ipd_patient_detail->Patients->patient_number.'/ipd/';
               if(!is_dir($docPath)){
                  File::makeDirectory($docPath, $mode = 0777, true, true);
               }
               if(!file_exists($docPath.'ipdDischargePrint.pdf')) {
                  File::copy(public_path().'/htmltopdfview.pdf', $docPath.'ipdDischargePrint.pdf');
               }
               $pdf = PDF::loadView('ipd.pages.ipd_gynecology_discharge_print',compact('practice_detail','chiefComplaints','ipd_patient_detail','ipd_discharge','pDiagnos','treatments','labs','procedures','summary','doctorIfoids','cunsultantinfo','ResidentInfo'));
               $output = $pdf->output();
               file_put_contents("uploads/PatientDocuments/".$ipd_patient_detail->Patients->patient_number."/ipd/ipdDischargePrint.pdf", $output);
               return 1;
           }
        }
     }
     public function gynecologyDischargedPatientPrint(Request $request)
         {
         if ($request->isMethod('post')) {
         $data = $request->all();
         $data['ipd_id'] = base64_decode($data['ipd_id']);
         $practiceId = Parent::getMyPractice()->practice_id;
         $practice_detail =  PracticeDetails::where(['user_id'=>$practiceId])->first();

         $ipd_discharge = IPDDischarge::Where(['ipd_request_id'=>$data['ipd_id']])->orderBy('id','DESC')->first();

         $ipd_patient_detail = IPDRequest::Where('id', '=', $data['ipd_id'])->first();
         $pDiagnos = PatientDiagnosis::with(['Diagnosis'])->where(['ipd_type'=>4,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
         $treatments =  PatientMedications::with(['ItemDetails.ItemType','MedicineOrders'])->where(['ipd_type'=>4,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
         $chiefComplaints =  ChiefComplaints::where(['ipd_type'=>4,'ipd_id'=>$data['ipd_id']])->first();
         $procedures = PatientProcedures::with(['Procedures'])->where(['ipd_type'=>4,'procedure_type'=>'current','delete_status'=>1,'ipd_id'=>$data['ipd_id']])->get();
         $summary = GynecologyDischargeSummary::Where('ipd_request_id', $data['ipd_id'])->first();
         $labs =  PatientLabs::with(['Labs','LabOrders'])->where(['ipd_type'=>4,'ipd_id'=>$data['ipd_id'],'delete_status'=>1])->get();
          $docPath = 'uploads/PatientDocuments/'.$ipd_patient_detail->Patients->patient_number.'/ipd/';
          if(!is_dir($docPath)){
             File::makeDirectory($docPath, $mode = 0777, true, true);
          }
          if(!file_exists($docPath.'ipdDischargePrint.pdf')) {
             File::copy(public_path().'/htmltopdfview.pdf', $docPath.'ipdDischargePrint.pdf');
          }
          $pdf = PDF::loadView('ipd.pages.ipd_gynecology_discharge_print',compact('practice_detail','chiefComplaints','ipd_patient_detail','ipd_discharge','pDiagnos','treatments','labs','procedures','summary'));
          $output = $pdf->output();
           file_put_contents("uploads/PatientDocuments/".$ipd_patient_detail->Patients->patient_number."/ipd/ipdDischargePrint.pdf", $output);
           $arr = array('ipd_id'=>$ipd_patient_detail->id,'patient_email'=>$ipd_patient_detail->Patients->email,'p_phone'=>$ipd_patient_detail->Patients->mobile_no,'patient_number'=>$ipd_patient_detail->Patients->patient_number);
           return $arr;
         }
  }


     public function createNeonatologyHistory(Request $request) {
       if ($request->isMethod('post')) {
       $data = $request->all();

       $practiceId = Parent::getMyPractice();
       $dobTime = "0000-00-00 ";
       if (!empty($data['dob'])) {
         $dobTime = date('Y-m-d', strtotime($data['dob'])).' ';
       }
       if (!empty($data['time'])) {
         $dobTime = $dobTime.''.date('H:i:s', strtotime($data['time']));
       }
   		   if(isset($data['id']) && !empty($data['id'])){
           NeonatologyHistory::where('id', $data['id'])->update(array(
           'dob' => $dobTime,
           'gender' => (isset($data['gender']) ?  $data['gender'] : ''),
           'mod' => (isset($data['mod']) ?  $data['mod'] : null),
           'pod' => $data['pod'],
           'history' => $data['history']
           ));
         }else{
           NeonatologyHistory::create([
           'appointment_id'=>$data['appointment_id'],
           'ipd_id' =>  $data['ipd_id'],
           'ipd_type' =>  $data['ipd_type'],
           'patient_id'=>$data['patient_id'],
           'dob' => $dobTime,
           'gender' => (isset($data['gender']) ?  $data['gender'] : null),
           'mod' => (isset($data['mod']) ?  $data['mod'] : null),
           'pod' => $data['pod'],
           'history' => $data['history'],
           'added_by' => Auth::id()
           ]);
         }
       return 1;
       }
     }
     public function createNeonatologyTreatment(Request $request) {
       if ($request->isMethod('post')) {
       $data = $request->all();
       $practiceId = Parent::getMyPractice();

   		   if(isset($data['id']) && !empty($data['id'])){
           NeonatologyTreatment::where('id', $data['id'])->update(array(
           'condition_at' => (isset($data['condition_at']) ?  $data['condition_at'] : null),
           'condition_note' => $data['condition_note'],
           'description' => $data['description']
           ));
         }else{
           NeonatologyTreatment::create([
           'appointment_id'=>$data['appointment_id'],
           'ipd_id' =>  $data['ipd_id'],
           'ipd_type' =>  $data['ipd_type'],
           'patient_id'=>$data['patient_id'],
           'condition_at' => (isset($data['condition_at']) ?  $data['condition_at'] : null),
           'condition_note' => $data['condition_note'],
           'description' => $data['description'],
           'added_by' => Auth::id()
           ]);
         }
       return 1;
       }
     }
     public function createNeonatologyManagement(Request $request) {
       if ($request->isMethod('post')) {
       $data = $request->all();
       $practiceId = Parent::getMyPractice();
   		   if(isset($data['id']) && !empty($data['id'])){
           NeonatologyManagement::where('id', $data['id'])->update(array(
           'hfo' => $data['hfo'],
           'mv' => $data['mv'],
           'cpap' => $data['cpap'],
           'hfnc' => $data['hfnc'],
           'ino' => $data['ino'],
           'hspda' => (isset($data['hspda']) ?  $data['hspda'] : null),
           'hspda_by' => (isset($data['hspda_by']) ?  $data['hspda_by'] : null),
           'hspda_note' => $data['hspda_note'],
           'ppharx' => (isset($data['ppharx']) ?  $data['ppharx'] : null),
           'cld' => (isset($data['cld']) ?  $data['cld'] : null),
           'rop_grade' => (isset($data['rop_grade']) ?  $data['rop_grade'] : null),
           'surgery' => (isset($data['surgery']) ?  $data['surgery'] : null),
           'blood_transfusion' => $data['blood_transfusion'],
           'birth_weight' => $data['birth_weight'],
           'height' => $data['height'],
           'ofc' => $data['ofc'],
		   'discharge_weight' => $data['discharge_weight'],
           'height_discharge' => $data['height_discharge'],
           'ofc_discharge' => $data['ofc_discharge'],
           'description' => $data['description']
           ));
         }else{
           NeonatologyManagement::create([
           'appointment_id'=>$data['appointment_id'],
           'ipd_id' =>  $data['ipd_id'],
           'ipd_type' =>  $data['ipd_type'],
           'patient_id'=>$data['patient_id'],
           'hfo' => $data['hfo'],
           'mv' => $data['mv'],
           'cpap' => $data['cpap'],
           'hfnc' => $data['hfnc'],
           'ino' => $data['ino'],
           'hspda' => (isset($data['hspda']) ?  $data['hspda'] : null),
           'hspda_by' => (isset($data['hspda_by']) ?  $data['hspda_by'] : null),
           'hspda_note' => $data['hspda_note'],
           'ppharx' => (isset($data['ppharx']) ?  $data['ppharx'] : null),
           'cld' => (isset($data['cld']) ?  $data['cld'] : null),
           'rop_grade' => (isset($data['rop_grade']) ?  $data['rop_grade'] : null),
           'surgery' => (isset($data['surgery']) ?  $data['surgery'] : null),
           'blood_transfusion' => $data['blood_transfusion'],
           'birth_weight' => $data['birth_weight'],
           'height' => $data['height'],
           'ofc' => $data['ofc'],
		   'discharge_weight' => $data['discharge_weight'],
           'height_discharge' => $data['height_discharge'],
           'ofc_discharge' => $data['ofc_discharge'],
           'description' => $data['description'],
           'added_by' => Auth::id()
           ]);
         }
       return 1;
       }
     }

     public function createMeternalHistory(Request $request) {
       if ($request->isMethod('post')) {
         $data = $request->all();
         $gpal = array("g"=>"", "p"=>"", "a"=>"", "l"=>"");
         if (is_numeric($data['g'])) {
           $gpal['g'] = $data['g'];
         }
         if (is_numeric($data['p'])) {
           $gpal['p'] = $data['p'];
         }
         if (is_numeric($data['a'])) {
           $gpal['a'] = $data['a'];
         }
         if (is_numeric($data['l'])) {
           $gpal['l'] = $data['l'];
         }
       $practiceId = Parent::getMyPractice();
   		   if(isset($data['id']) && !empty($data['id'])){
           MeternalHistory::where('id', $data['id'])->update(array(
           'age' => $data['age'],
           'age_type' => $data['age_type'],
           'gpal' => json_encode($gpal),
           'blood_group' => $data['blood_group'],
           'consanguinity' => (isset($data['consanguinity']) ?  $data['consanguinity'] : null),
           'lmp' => (!empty($data['lmp']) ?  date('Y-m-d', strtotime($data['lmp'])) : null),
           'edd' => (!empty($data['edd']) ?  date('Y-m-d', strtotime($data['edd'])) : null),
           'gdm' => (isset($data['gdm']) ?  $data['gdm'] : null),
           'pih' => (isset($data['pih']) ?  $data['pih'] : null),
           'hypothyroidism' => (isset($data['hypothyroidism']) ?  $data['hypothyroidism'] : null),
           'steroid' => (isset($data['steroid']) ?  $data['steroid'] : null),
           'mgso' => (isset($data['mgso']) ?  $data['mgso'] : null),
           'history' => $data['history']
           ));
         }else{
          $test =  MeternalHistory::create([
           'appointment_id'=>$data['appointment_id'],
           'ipd_id' =>  $data['ipd_id'],
           'ipd_type' =>  $data['ipd_type'],
           'patient_id'=>$data['patient_id'],
           'age' => $data['age'],
           'age_type' => $data['age_type'],
           'gpal' => json_encode($gpal),
           'blood_group' => $data['blood_group'],
           'consanguinity' => (isset($data['consanguinity']) ?  $data['consanguinity'] : null),
           'lmp' => (!empty($data['lmp']) ?  date('Y-m-d', strtotime($data['lmp'])) : null),
           'edd' => (!empty($data['edd']) ?  date('Y-m-d', strtotime($data['edd'])) : null),
           'gdm' => (isset($data['gdm']) ?  $data['gdm'] : null),
           'pih' => (isset($data['pih']) ?  $data['pih'] : null),
           'hypothyroidism' => (isset($data['hypothyroidism']) ?  $data['hypothyroidism'] : null),
           'steroid' => (isset($data['steroid']) ?  $data['steroid'] : null),
           'mgso' => (isset($data['mgso']) ?  $data['mgso'] : null),
           'history' => $data['history'],
           'added_by' => Auth::id()
           ]);
         }
       return 1;
       }
     }
     public function createBornChecklist(Request $request) {
       if ($request->isMethod('post')) {
       $data = $request->all();
       $practiceId = Parent::getMyPractice();
   		   if(isset($data['id']) && !empty($data['id'])){
           BornChecklist::where('id', $data['id'])->update(array(
           'spo_upar_lower_line' => (isset($data['spo_upar_lower_line']) ?  $data['spo_upar_lower_line'] : null),
           'red_reflex_test' => (isset($data['red_reflex_test']) ?  $data['red_reflex_test'] : null),
           'hip_stability_test' => (isset($data['hip_stability_test']) ?  $data['hip_stability_test'] : null),
           'brest_feeding' => (isset($data['brest_feeding']) ?  $data['brest_feeding'] : null),
           'rop_screening' => (isset($data['rop_screening']) ?  $data['rop_screening'] : null),
           'follow_date' => (!empty($data['follow_date']) ?  date('Y-m-d', strtotime($data['follow_date'])) : null),
           'immunization_done' => (isset($data['immunization_done']) ?  $data['immunization_done'] : null),
           'next_immunization_date' => (!empty($data['next_immunization_date']) ?  date('Y-m-d', strtotime($data['next_immunization_date'])) : null),
           'new_born_screening' => (isset($data['new_born_screening']) ?  $data['new_born_screening'] : null),
           'hearing_screening' => (isset($data['hearing_screening']) ?  $data['hearing_screening'] : null),
           'advice' => $data['advice']
           ));
         }else{
           BornChecklist::create([
           'appointment_id'=>$data['appointment_id'],
           'ipd_id' =>  $data['ipd_id'],
           'ipd_type' =>  $data['ipd_type'],
           'patient_id'=>$data['patient_id'],
           'spo_upar_lower_line' => (isset($data['spo_upar_lower_line']) ?  $data['spo_upar_lower_line'] : null),
           'red_reflex_test' => (isset($data['red_reflex_test']) ?  $data['red_reflex_test'] : null),
           'hip_stability_test' => (isset($data['hip_stability_test']) ?  $data['hip_stability_test'] : null),
           'brest_feeding' => (isset($data['brest_feeding']) ?  $data['brest_feeding'] : null),
           'rop_screening' => (isset($data['rop_screening']) ?  $data['rop_screening'] : null),
           'follow_date' => (!empty($data['follow_date']) ?  date('Y-m-d', strtotime($data['follow_date'])) : null),
           'immunization_done' => (isset($data['immunization_done']) ?  $data['immunization_done'] : null),
           'next_immunization_date' => (!empty($data['next_immunization_date']) ?  date('Y-m-d', strtotime($data['next_immunization_date'])) : null),
           'new_born_screening' => (isset($data['new_born_screening']) ?  $data['new_born_screening'] : null),
           'hearing_screening' => (isset($data['hearing_screening']) ?  $data['hearing_screening'] : null),
           'advice' => $data['advice'],
           'added_by' => Auth::id()
           ]);
         }
       return 1;
       }
     }
	public function patientChart($id,$type=null) {
		$id = base64_decode($id);
		$type = base64_decode($type);
		$patient = IPDRequest::Where('id', '=', $id)->first();
	    $charts = PatientGrowthChart::where(["ipd_request_id"=>$id,"patient_id"=>$patient->Patients->id,'discharge_type'=>$type])->get();
		if($type == "2") {
			$pVitals = PatientVitalss::where(['ipd_type'=>$type,'ipd_id'=>$id,'delete_status'=>1])->first();
			return view('ipd.patient-chart',compact('patient','pVitals','charts'));
		}
		else{
			$pVitals =  NeonatologyManagement::where(['ipd_type'=>$type,'ipd_id'=>$id])->first();
			return view('ipd.patient-chart-neonatology',compact('patient','pVitals','charts'));
		}
   }

   public function saveChart(Request $request) {
	   if(!empty($request->chartItemsData)) {
		   if(!empty($request->chartItemsData)>0){
			   PatientGrowthChart::where(["ipd_request_id"=>$request->ipd_id,"patient_id"=>$request->patient_id,'discharge_type'=>$request->discharge_type])->delete();
			   foreach($request->chartItemsData as $raw) {
				   if(!empty($raw["id"]) && $raw["value"]){
					  PatientGrowthChart::create([
							'ipd_request_id'=>$request->ipd_id,
							'patient_id'=>$request->patient_id,
							'chart_id'=>$raw["id"],
							'chart_data'=>$raw["value"],
							'discharge_type'=>$request->discharge_type,
					   ]);
				   }
			   }
		   }
		   return 1;
	   }
	   else return 0;
   }
      public function OTRegistration($id){
        $ipd_request_id = base64_decode($id);
        $admitPatient = IPDRequest::with('Patients')->Where('id', '=', $ipd_request_id)->first();
        $OTRegistration = OTRegistration::where(['ipd_id'=>$ipd_request_id,'delete_status'=>1])->first();
        return view('ipd.OTRegistration',compact('admitPatient','OTRegistration'));
      }
    public function createOTRegistration(Request $request) {
       if ($request->isMethod('post')) {
        $data = $request->all();

        $data['surgery_date'] = date('Y-m-d', strtotime($data['date']));
        $data['from_time'] = date('H:i:s', strtotime($data['from_time']));
        $data['to_time'] = date('H:i:s', strtotime($data['to_time']));
          if (!empty($data['id'])) {
            OTRegistration::where('id',$data["id"])->update([
              'ipd_id'  =>  $data["ipd_id"],
              'surgery_date'  =>  $data["surgery_date"],
              'from_time'  =>  $data["from_time"],
              'to_time'  =>  $data["to_time"],
              'type_anaesthesia'  =>  $data["type_anaesthesia"],
              'provisions_diagnosis'  =>  $data["provisions_diagnosis"],
              'surgery_title' => $data["surgery_title"],
              'operating_surgeon' => $data["operating_surgeon"],
              'anaesthetist_doctor' => $data["anaesthetist_doctor"],
              'assisting_doctor'  =>  $data["assisting_doctor"],
              'assisting_nurse' => $data["assisting_nurse"],
              'status' => $data["status"],
              'remark'  =>  $data["remark"]
             ]);
          }else{
            OTRegistration::create([
              'ipd_id'  =>  $data["ipd_id"],
              'surgery_date'  =>  $data["surgery_date"],
              'from_time'  =>  $data["from_time"],
              'to_time'  =>  $data["to_time"],
              'type_anaesthesia'  =>  $data["type_anaesthesia"],
              'provisions_diagnosis'  =>  $data["provisions_diagnosis"],
              'surgery_title' => $data["surgery_title"],
              'operating_surgeon' => $data["operating_surgeon"],
              'anaesthetist_doctor' => $data["anaesthetist_doctor"],
              'assisting_doctor'  =>  $data["assisting_doctor"],
              'assisting_nurse' => $data["assisting_nurse"],
              'status' => $data["status"],
              'remark'  =>  $data["remark"]
            ]);
          }
          return 1;

          }
          return 0;
       }
  }


