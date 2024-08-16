<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Doctors;
/**ehr db models */
use App\Models\ehr\User as ehrUser;
use App\Models\ehr\PracticeDetails;
use App\Models\ehr\DoctorsInfo;
use App\Models\ehr\StaffsInfo;
use App\Models\ehr\RoleUser;
use App\Models\ehr\OpdTimings;
use App\Models\ehr\Plans;
use App\Models\ehr\CityLocalities;
use App\Models\ehr\ManageTrailPeriods;
use App\Models\ehr\PatientRagistrationNumbers;
use App\Models\ehr\Patients;
use App\Models\ehr\EmailTemplate;
use App\Models\ehr\Appointments;
use App\Models\ehr\PracticeDocuments;
use App\Models\ehr\AppointmentOrder;
use App\Models\Admin\SymptomsSpeciality;
use App\Models\ThyrocarePackageGroup;
use App\Models\UsersLaborderAddresses;

use App\Models\Admin\Symptoms;
use App\Models\Admin\SymptomTags;
use App\Models\OtpPracticeDetails;
use App\Models\Speciality;
use App\Models\PatientFeedback;
use App\Models\Coupons;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use File;
use Session;
use Auth;
use Softon\Indipay\Facades\Indipay;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
class MedicineController extends Controller
{

		public function __construct()
		{
			
		}

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request){

		return view($this->getView('medicine.index'),['type'=>'','groups'=>'']);
	}

}
