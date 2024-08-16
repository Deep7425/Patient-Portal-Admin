<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Patients;
use App\Models\Appointments;
use App\Models\Plans;
use App\Models\PlanPeriods;
use App\Models\UserSubscribedPlans;
use App\Models\UsersSubscriptions;
use App\Models\UserSubscriptionsTxn;
use App\Models\Doctors;
use App\Models\ReferralMaster;
use App\Models\Plans as userPlan;
use Session;
use DB;
use URL;
use Mail;
use Auth;
use File;
use Hash;
use Route;
use Response;
use App\Models\EmailTemplate;
use App\Models\Templates;
use App\Models\Pages;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Softon\Indipay\Facades\Indipay;
use Storage;
use PDF;
use PaytmWallet;
use Exception;
use Illuminate\Database\QueryException;
class CommonController extends Controller
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

   public function applyWalletAmt(Request $request) {

    $data=$request->all();
	$user_id = Auth::id();
    $user_array=array();
    $user_array['type']=$data['type'];
    $user_array['wallet_amount']=$data['wallet_amount'];
 
         $availAmount = 0; $isApplicable = 0;
        if($user_array['type'] == 1) {
            $avail_limit = getSetting("reward_appt_avail_limit")[0];
            if($user_array['wallet_amount'] > $avail_limit) {
                $availAmount = (float) $avail_limit;
            }
            else{
                $availAmount = (float) $user_array['wallet_amount'];
            }
            // if($user_array['appt_type'] == 1) {
            //     $isApplicable = 1;
            // }
            // else{
            //     $isApplicable = 0;
            // }
            // if($user_array['isFirstTeleAppointment'] == 1 && $user_array['meta_data']['isDirectAppt'] == 1) {
            //     $isApplicable = 0;
            // }
          
        }
        else if($user_array['type'] == 2) {
            $avail_limit = getSetting("reward_subs_avail_limit")[0];
            if($user_array['wallet_amount'] > $avail_limit) {
                $availAmount =(float)  $avail_limit;
            }
            else{
                $availAmount = (float)$user_array['wallet_amount'];
            }
            
            $isApplicable = 1;
        }
        else if($user_array['type'] == 3) {
            $avail_limit = getSetting("reward_labs_avail_limit")[0];
            if($user_array['wallet_amount'] > $avail_limit) {
                $availAmount = (float)$avail_limit;
            }
            else{
                $availAmount = (float)$user_array['wallet_amount'];
            }
           
            $isApplicable = 1;
        }
        $res = ['availAmount'=>$availAmount,'isApplicable'=>$isApplicable];
		return Response::json(['success' => $res ], 200);
    
}

}
