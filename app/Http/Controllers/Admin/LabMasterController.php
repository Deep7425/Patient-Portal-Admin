<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\DefaultLabs;
use App\Models\LabCollection;
use App\Models\LabRequests;
use App\Models\LabPackage;
use App\Models\LabOrders;
use App\Models\LabReports;
use App\Models\LabCompany;
use App\Models\ThyrocareLab;
use App\Models\LabOrderTxn;
use App\Models\LabPincode;
use Session;
use File;
class LabMasterController extends Controller{

	   public function defaultLab(Request $request) {
		 if($request->isMethod('post')) {
			$params = array();
			if (!empty($request->input('search'))) {
				 $params['search'] = base64_encode($request->input('search'));
			}
			if (!empty($request->input('page_no'))) {
			 $params['page_no'] = base64_encode($request->input('page_no'));
			}
			return redirect()->route('admin.defaultLab.index',$params)->withInput();
		  }
		  else {
			 $filters = array();
			 $query = DefaultLabs::where('delete_status', '=', '1');
			 if($request->input('search')  != '') {
			   $search = base64_decode($request->input('search'));
			   $query->where(DB::raw('concat(default_labs.title," ",IFNULL(default_labs.short_name,""))') , 'like', '%'.$search.'%');
			 }
			 $page = 10;
			 if(!empty($request->input('page_no'))) {
				$page = base64_decode($request->input('page_no'));
			 }
			 $labs = $query->orderBy('id', 'desc')->paginate($page);
		  }
		  return view('admin.defaultLab.index',compact('labs'));
	   }

	   public function create(Request $request){
			 if($request->isMethod('post')) {
				$data = $request->all();
				$user =  DefaultLabs::create([
					'login_id' => Session::get('id'),
					'title' => ucfirst($data['title']),
					'short_name' => $data['short_name'],
					// 'data_type' => $data['data_type'],
					// 'num_high_value' => $data['num_high_value'],
					// 'num_low_value' => $data['num_low_value'],
					// 'unit' => $data['unit'],
					// 'results' => implode(',',$data['result'])
			  ]);
			  Session::flash('message', "Lab Added Successfully");
			  return 1;
		   }
		   return 2;
	   }
	 public function edit(Request $request){
        $id = $request->id;
        $lab = DefaultLabs::where('delete_status', '=', '1')->Where( 'id', '=', $id)->first();
        return view('admin.defaultLab.edit',compact('lab'));
     }
	 public function update(Request $request){
		 if ($request->isMethod('post')) {
			 $data = $request->all();
			 $id = $data['id'];
			 $user =  DefaultLabs::where('id', $id)->update(array(
			 'title' => ucfirst($data['title']),
			 'short_name' => $data['short_name'],
			 // 'data_type' => $data['data_type'],
			 // 'num_high_value' => $data['num_high_value'],
			 // 'num_low_value' => $data['num_low_value'],
			 // 'unit' => $data['unit'],
			 // 'results' => implode(',',$data['result'])
			 ));
			Session::flash('message', "Lab Updated Successfully");
			return 1;
		   }
		return redirect()->route('admin.defaultLab.index');
    }
	public function delete(Request $request) {
	   $id = $request->id;
       DefaultLabs::where('id', $id)->update(array('delete_status' => '0'));
       Session::flash('message', "Lab Deleted Successfully");
       return 1;
   }


   public function labCollection(Request $request) {
		 if($request->isMethod('post')) {
			$params = array();
			if (!empty($request->input('search'))) {
				 $params['search'] = base64_encode($request->input('search'));
			}
			if (!empty($request->input('page_no'))) {
			 $params['page_no'] = base64_encode($request->input('page_no'));
			}
			return redirect()->route('admin.labCollection.index',$params)->withInput();
		  }
		  else {
			 $filters = array();
			 $query = LabCollection::with("DefaultLabs")->where('delete_status', '=', '1');
			 if($request->input('search')  != '') {
			   $search = base64_decode($request->input('search'));
			   $query->whereHas("DefaultLabs",function($q) use($search){
				   $q->where(DB::raw('concat(default_labs.title," ",IFNULL(default_labs.short_name,""))') , 'like', '%'.$search.'%');
			   });
			 }
			 $page = 10;
			 if(!empty($request->input('page_no'))) {
				$page = base64_decode($request->input('page_no'));
			 }
			 $labs = $query->orderBy('id', 'desc')->paginate($page);
		  }
			  $defaultLab = DefaultLabs::all();
		  return view('admin.labCollection.index',compact('labs','defaultLab'));
	   }

	   public function createLabCollection(Request $request){
			 if($request->isMethod('post')) {
				$data = $request->all();
				// dd(implode (", ", $data['sub_lab_id']));
				$user =  LabCollection::create([
				 'company_id' => $data['company_id'],
				 'login_id' => Session::get('id'),
				 'lab_id' => $data['lab_id'],
				 'sub_lab_id' =>  isset($data['sub_lab_id']) ? implode (",", $data['sub_lab_id']) : null,
				 'method' => $data['method'],
				 'instruction' => $data['instruction'],
				 'information' => $data['information'],
				 'cost' => $data['cost'],
				 'offer_rate' => $data['offer_rate'],
				 'reporting' => $data['reporting'],

			  ]);


			  Session::flash('message', "Lab Added Successfully");
			  return 1;
		   }
		   return 2;
	   }
	 public function editLabCollection(Request $request){
        $id = $request->id;
        $lab = LabCollection::where('delete_status', '=', '1')->Where( 'id', '=', $id)->first();
		 $defaultLab = DefaultLabs::all();
        return view('admin.labCollection.edit',compact('lab','defaultLab'));
     }
	 public function updateLabCollection(Request $request){
		 if ($request->isMethod('post')) {
			 $data = $request->all();
			 $id = $data['id'];
			 $user =  LabCollection::where('id', $id)->update(array(
			 'company_id' => $data['company_id'],
			 'lab_id' => $data['lab_id'],
			 'method' => $data['method'],
			 'instruction' => $data['instruction'],
			 'information' => $data['information'],
			 'cost' => $data['cost'],
			 'sub_lab_id' => isset($data['sub_lab_id']) ? implode (",", $data['sub_lab_id']) : null,
			 'offer_rate' => $data['offer_rate'],
			 'reporting' => $data['reporting'],
			 ));
			Session::flash('message', "Lab Updated Successfully");
			return 1;
		   }
		return redirect()->route('admin.labCollection.index');
    }
	public function deleteLabCollection(Request $request) {
	   $id = $request->id;
       LabCollection::where('id', $id)->update(array('delete_status' => '0'));
       Session::flash('message', "Lab Deleted Successfully");
       return 1;
   }

   public function labRequests(Request $request) {
	 if($request->isMethod('post')) {
		$params = array();
		if (!empty($request->input('search'))) {
			 $params['search'] = base64_encode($request->input('search'));
		}
		if (!empty($request->input('page_no'))) {
		 $params['page_no'] = base64_encode($request->input('page_no'));
		}
		return redirect()->route('admin.labRequests.index',$params)->withInput();
	  }
	  else {
		 $filters = array();
		 $query = LabRequests::with(["MedicinePrescriptions","user"]);
		 if($request->input('search')  != '') {
		   $search = base64_decode($request->input('search'));
		   $query->whereHas("user",function($q) use($search){
			   $q->where(DB::raw('concat(users.first_name," ",IFNULL(users.last_name,""))') , 'like', '%'.$search.'%');
		   });
		 }
		 $page = 10;
		 if(!empty($request->input('page_no'))) {
			$page = base64_decode($request->input('page_no'));
		 }
		 $labs = $query->orderBy('id', 'desc')->paginate($page);
	  }
	  return view('admin.lab_order.lab_req',compact('labs'));
   }
	 public function updateLabPackSts(Request $request) {
	 		if ($request->isMethod('post')) {
	 	        $data = $request->all();
	 	      	if ($data['status'] == '1') {
	 	            LabPackage::where('id', $data['id'])->update(array('status' => '0'));
	 	        }
	 	        else {
					LabPackage::where('id', $data['id'])->update(array('status' => '1'));
	 	        }
	 	        return 1;
	 	    }
	    }
		 public function updateLabcompanySts(Request $request) {
	 		if ($request->isMethod('post')) {
	 	        $data = $request->all();
	 	      	if ($data['status'] == '1') {
	 	            LabCompany::where('id', $data['id'])->update(array('status' => '0'));
	 	        }
	 	        else {
					LabCompany::where('id', $data['id'])->update(array('status' => '1'));
	 	        }
	 	        return 1;
	 	    }
	    }
	 public function defaultLabupdateStatus(Request $request) {
	 		if ($request->isMethod('post')) {
	 	        $data = $request->all();
	 	      	if ($data['status'] == '1') {
	 	            DefaultLabs::where('id', $data['id'])->update(array('status' => '0'));
	 	        }
	 	        else {
					DefaultLabs::where('id', $data['id'])->update(array('status' => '1'));
	 	        }
	 	        return 1;
	 	    }
	    }
	 public function labCollectionstatus(Request $request) {
	 		if ($request->isMethod('post')) {
	 	        $data = $request->all();
	 	      	if ($data['status'] == '1') {
	 	            LabCollection::where('id', $data['id'])->update(array('status' => '0'));
	 	        }
	 	        else {
					LabCollection::where('id', $data['id'])->update(array('status' => '1'));
	 	        }
	 	        return 1;
	 	    }
	    }

   public function labPackage(Request $request) {
		 if($request->isMethod('post')) {
			$params = array();
			if (!empty($request->input('search'))) {
				 $params['search'] = base64_encode($request->input('search'));
			}
			if (!empty($request->input('page_no'))) {
			 $params['page_no'] = base64_encode($request->input('page_no'));
			}
			return redirect()->route('admin.labPackage.index',$params)->withInput();
		  }
		  else {
			 $filters = array();
			 $query = LabPackage::where('delete_status', '=', '1');
			 if($request->input('search')  != '') {
			   $search = base64_decode($request->input('search'));
			   $query->where('title', 'like', '%'.$search.'%');
			 }
			 $page = 10;
			 if(!empty($request->input('page_no'))) {
				$page = base64_decode($request->input('page_no'));
			 }
			 $labs = $query->orderBy('id', 'desc')->paginate($page);
		  }
		  return view('admin.labPackage.index',compact('labs'));
	   }

	   public function createLabPackage(Request $request){
			 if($request->isMethod('post')) {
				$data = $request->all();
				$fileName = null;
				if($request->hasFile('image')) {
					  $image  = $request->file('image');
					  $fullName = str_replace(" ","",$image->getClientOriginalName());
					  $onlyName = explode('.',$fullName);
					  if(is_array($onlyName)){
						$fileName = $onlyName[0].time().".".$onlyName[1];
					  }
					  else{
						$fileName = $onlyName.time();
					  }
					  $request->file('image')->move(public_path("/lab-package-icon"), $fileName);
				}
				$labIds = null;
				if(!empty($data['lab_id'])){
					$labIds = implode(",",$data['lab_id']);
				}
				LabPackage::create([

					'login_id' => Session::get('id'),
					'title' => ucfirst($data['title']),
					'company_id' => $data['company_id'],
					'price' => $data['price'],
					'discount_price' => $data['discount_price'],
					'image' => $fileName,
					'lab_id' => $labIds,
				]);
			  Session::flash('message', "Lab Added Successfully");
			  return 1;
		   }
		   return 2;
	 }
	 public function editLabPackage(Request $request){
        $id = $request->id;
        $lab = LabPackage::where('delete_status', '=', '1')->Where( 'id', '=', $id)->first();
		$labs = LabCollection::with("DefaultLabs","LabCompany")->where('delete_status', '=', '1')->where('company_id',$lab->company_id)->orderBy('id', 'desc')->get();
        return view('admin.labPackage.edit',compact('lab','labs'));
     }
	 public function updateLabPackage(Request $request){
		 if ($request->isMethod('post')) {
			 $data = $request->all();
			 $id = $data['id'];
			 $fileName = null;
			 if($request->hasFile('image')) {
				  $old_filename = public_path().'/lab-package-icon/'.$data['old_image'];
				  if(file_exists($old_filename)){
				    File::delete($old_filename);
				  }
				  $image  = $request->file('image');
				  $fullName = str_replace(" ","",$image->getClientOriginalName());
				  $onlyName = explode('.',$fullName);
				  if(is_array($onlyName)){
					$fileName = $onlyName[0].time().".".$onlyName[1];
				  }
				  else{
					$fileName = $onlyName.time();
				  }
				  $request->file('image')->move(public_path("/lab-package-icon"), $fileName);
			 }
			 else{
				 $fileName = $data['old_image'];
			 }
			 $labIds = null;
			 if(!empty($data['lab_id'])){
				 $labIds = implode(",",$data['lab_id']);
			 }
			 $user =  LabPackage::where('id', $id)->update(array(
				'title' => ucfirst($data['title']),
				'company_id' => $data['company_id'],
				'price' => $data['price'],
				'discount_price' => $data['discount_price'],
				'lab_id' => $labIds,
				'image' => $fileName,
			 ));
			Session::flash('message', "Lab Updated Successfully");
			return 1;
		   }
		return redirect()->route('admin.defaultLab.index');
    }
	public function deleteLabPackage(Request $request) {
	   $id = $request->id;
       LabPackage::where('id', $id)->update(array('delete_status' => '0'));
       Session::flash('message', "Lab Deleted Successfully");
       return 1;
   }

    public function changeOrderStatus(Request $request){
		 if ($request->isMethod('post')) {
			 $data = $request->all();
			//   dd($data['status']);
			 $id = $data['id'];
			 $user =  LabOrders::where('id', $id)->update(array(
			 'order_status' => $data['status']
			 ));
			 $order = LabOrders::where('id', $id)->first();
			 if($data['status'] == 'REPORTED') {
				$meta_data = json_decode($order->meta_data,true);
				$message =  urlencode('Dear '.$order->order_by.', Your lab report is now ready. You can now avail FREE doctor consultation with Health Gennie-certified doctors. Book your free consultation now or call 8929920932');
				$this->sendSMS($meta_data['mobile'],$message,'1707165122333414122');
			 }
			return 1;
		   }
		return 2;
    }

	
	// public function changePaymentMode(Request $request)
	// {
	// 	if ($request->isMethod('post')) {
	// 		$data = $request->all();
	// 		dd($data);
	// 	 if($data['payment_mode_type'] == 4 || $data['payment_mode_type'] ==  7){

	// 		if (isset($data['id']) && isset($data['payment_mode_type'])) {
	// 			$id = $data['id'];
	// 			$user = LabOrders::where('id', $id)->update([
	// 				'payment_mode_type' => $data['payment_mode_type'],
	// 			]);
	// 			LabOrderTxn::create([
	// 				'tracking_id'=>$data['tracking_id'],
	// 				'trans_date' => $data['trans_date']
	// 			]);

	
	// 			// Return a success response if the update was successful
	// 			return response()->json(['success' => true]);
	// 		}
	// 	 }
	// 	 else{
	// 		if (isset($data['id']) && isset($data['payment_mode_type'])) {
	// 			$id = $data['id'];
	// 			$user = LabOrders::where('id', $id)->update([
	// 				'payment_mode_type' => $data['payment_mode_type'],
	// 			]);
	// 	 }

	// 		 else {
	// 			// Return an error response if 'id' or 'payment_mode_type' is not provided
	// 			return response()->json(['success' => false, 'message' => 'Order ID or Payment Mode Type not provided.']);
	// 		}
	// 	}
	// }
	// }

//----------------------------------------------------------------------------------------------------------------------------------------------
public function changePaymentMode(Request $request)
{
    if ($request->isMethod('post')) {
        $data = $request->all();

        if (isset($data['id']) && isset($data['payment_mode_type'])) {
            $id = $data['id'];
            $payment_mode_type = $data['payment_mode_type'];

            $labOrder = LabOrders::find($id);

            if ($payment_mode_type == 4 || $payment_mode_type == 7) {
                if (isset($data['id']) && isset($data['trans_date'])) {
                    $labOrder->update([
                        'payment_mode_type' => $payment_mode_type,
                    ]);

                    $labOrderTxn = LabOrderTxn::where('order_id', $data['id'])->first();

                    if ($labOrderTxn) {
                        $labOrderTxn->update([
                            'tracking_id' => $data['tracking_id'],
                            'trans_date' => $data['trans_date'],
                        ]);
                    } else {
                        LabOrderTxn::create([
                            'order_id' => $data['id'],
                            'tran_mode'=> "online",
                            'payed_amount'=> '',
                            'cheque_no'=> null,
                            'cheque_payee_name'=> null,
                            'cheque_bank_name'=> null,
                            'cheque_date'=> null,
                            'tran_status' => "Success",
                            'currency' => "INR",
                            'tracking_id' => $data['tracking_id'],  // Make sure $data['tracking_id'] is defined
                            'trans_date' => $data['trans_date'],
                        ]);
                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'Tracking ID or Transaction Date missing for payment mode type 4 or 7.']);
                }
            } else {
                $labOrder->update([
                    'payment_mode_type' => $payment_mode_type,
                ]);

                $labOrderTxn = LabOrderTxn::where('order_id', $data['id'])->first();
                if ($labOrderTxn) {
                    $labOrderTxn->update([
                        'tracking_id' => null,
                        'trans_date' => $data['trans_date'],
                    ]);
                }
            }

            // Return a success response if the update was successful
            return response()->json(['success' => true]);
        } else {
            // Return an error response if 'id' or 'payment_mode_type' is not provided
            return response()->json(['success' => false, 'message' => 'Order ID or Payment Mode Type not provided.']);
        }
    }
}



//----------------------------------------------------------------------------------------------------------------------------------------------



    public function changeLabReqSts(Request $request){
		 if ($request->isMethod('post')) {
			 $data = $request->all();
			 $id = $data['id'];
			 $user =  LabRequests::where('id', $id)->update(array(
			 'status' => $data['status'] == 1 ? 0 : 1
			 ));
			return 1;
		   }
		return 2;
    }
	public function uploadReport(Request $request){
		 try{
		 if ($request->isMethod('post')) {
			 $data = $request->all();
			 $fileName = null;
			 if($request->hasFile('new_report')) {
				  $old_filename = public_path().'/others/lab-reports/'.$data['old_report'];
				  if(file_exists($old_filename)){
				    File::delete($old_filename);
				  }
				  $new_report  = $request->file('new_report');
				  $fullName = str_replace(" ","",$new_report->getClientOriginalName());
				  $onlyName = explode('.',$fullName);
				  if(is_array($onlyName)){
					$fileName = $onlyName[0].time().".".$onlyName[1];
				  }
				  else{
					$fileName = $onlyName.time();
				  }
				  $request->file('new_report')->move(public_path("/others/lab-reports"), $fileName);
			 }
			 else{
				 $fileName = $data['old_report'];
			 }
			 if(!empty($data['id'])){
				LabReports::where(['id'=>$data['id']])->update([
				  'report_pdf_name' => $fileName,
				 ]);
			 }
			 else{
				 LabReports::create([
				  'company_id' => $data['company_id'],
				  'order_id' => $data['order_id'],
				  'user_id' => $data['user_id'],
				  'report_pdf_name' => $fileName,
				 ]);
			 }
			// return redirect()->route('admin.labOrders')->withInput();
			return redirect()->back(); //If you want to go back
		   }
		}
		catch(\Exception $e){
			throw new \Exception($e->getMessage());
			// \Session::flash('error', 'Unable to process request.Error:'.json_encode($e->getMessage(), true));
		}
		return redirect()->back(); //If you want to go back
    }
	 public function getlabcompany(Request $request) {

			// $labs = LabCompany::all();
			// // dd($getlabcpmpanies);
		  //   return view('admin.labcompanies.index',compact('labs'));
			if($request->isMethod('post')){
					$data = $request->all();
					$params = [];
					if(!empty($data['search'])) {
							$params['search']=  base64_encode($data['search']);
					}
					return redirect()->route('lab.company',$params)->withInput();
			}
			else{
					$query = LabCompany::select('*');
					 if(!empty($request->search)){
							$search = base64_decode($request->search);
							$query->where('title','LIKE','%'.$search.'%');
					 }

					 $labs = $query->get();
			return view('admin.labcompanies.index',compact('labs'));
			}
		}

		public function createLabcompany(Request $request){
			if($request->isMethod('post')) {
			 $data = $request->all();
			 $fileName = null;
			 if($request->hasFile('icon')) {
					 $image  = $request->file('icon');
					 $fullName = str_replace(" ","",$image->getClientOriginalName());
					 $onlyName = explode('.',$fullName);
					 if(is_array($onlyName)){
					 $fileName = $onlyName[0].time().".".$onlyName[1];
					 }
					 else{
					 $fileName = $onlyName.time();
					 }
					 $request->file('icon')->move(public_path("/others/company_logos"), $fileName);
			 }

			 LabCompany::create([
				'login_id' => Session::get('id'),
				 'title' => ucfirst($data['title']),
				 'discount' => $data['discount'],
				 'desc' => $data['desc'],
				 'start_time' => $data['start_time'],
				 'end_time' => $data['end_time'],
				 'slot_duration' => $data['slot_duration'],
				 'icon' => $fileName,

			 ]);
			 Session::flash('message', "Company Added Successfully");
			 return 1;
			}
			return 2;
	}
	public function deleteLabCompany(Request $request) {
	 $id = $request->id;
		 LabCompany::where('id', $id)->delete();
		 Session::flash('message', "Company Deleted Successfully");
		 return 1;
 }
 public function editLabCompany(Request $request){
			 $id = $request->id;
			 $lab = LabCompany::Where( 'id', '=', $id)->first();
			 return view('admin.labcompanies.edit',compact('lab'));
		}
		public function updateLabCompany(Request $request){
		 if ($request->isMethod('post')) {
		   $data = $request->all();
		    // dd($data);
		   $id = $data['id'];
		   $fileName = null;
		   if($request->hasFile('icon')) {
		      $old_filename = public_path().'/others/company_logos/'.$data['old_icon'];
		      if(file_exists($old_filename)){
		        File::delete($old_filename);
		      }
		      $image  = $request->file('icon');
		      $fullName = str_replace(" ","",$image->getClientOriginalName());
		      $onlyName = explode('.',$fullName);
		      if(is_array($onlyName)){
		      $fileName = $onlyName[0].time().".".$onlyName[1];
		      }
		      else{
		      $fileName = $onlyName.time();
		      }
		      $request->file('icon')->move(public_path("/others/company_logos"), $fileName);
		   }
		   else{
		     $fileName = $data['old_icon'];
		   }


		   $user =  LabCompany::where('id', $id)->update(array(
		     'title' => ucfirst($data['title']),
		     'discount' => $data['discount'],
		     'desc' => $data['desc'],
		     'start_time' => $data['start_time'],
		     'end_time' => $data['end_time'],
		     'slot_duration' => $data['slot_duration'],
		     'icon' => $fileName,
		   ));
		  Session::flash('message', "Company Updated Successfully");
		  return 1;
		   }
		return redirect()->route('lab.company');
		 }
		 public function getcomapnypin(){
			 $getlabcompanypin = LabPincode::orderBy('id', 'desc')->paginate(10);
			 $getlabPackage = LabPackage::all();
			 return view('admin.pinMaster.pinmaster',compact('getlabcompanypin','getlabPackage'));
		 }
		 public function createLabcompanypin(Request $request){

			 $request->validate([
	            'company_id' => 'required',
	            'pincode' => 'required|digits:6|integer'
	        ]);
		 	$data = $request->all();

	        // LabPincode::create();
			LabPincode::create([
				'company_id' => $data['company_id'],
				'pincode' => $data['pincode'],
               'login_id' => Session::get('id'),
			]);
						 Session::flash('message', "Company Pin Create Successfully");
	        return 1;
}
public function deleteLabCompanypin(Request $request) {
 $id = $request->id;
	 LabPincode::where('id', $id)->delete();
	 Session::flash('message', "Company Deleted Successfully");
	 return 1;
}
public function editLabCompanypin(Request $request){
			$id = $request->id;
			$lab = LabPincode::Where( 'id', '=', $id)->first();
			$getlabPackage = LabPackage::all();
			return view('admin.pinMaster.edit',compact('lab','getlabPackage'));
	 }
	 public function updateLabcompanypin(Request $request){
		if ($request->isMethod('post')) {
			$data = $request->all();
			$id = $data['id'];
			$labIds = null;
			if(!empty($data['lab_id'])){
				$labIds = implode(",",$data['lab_id']);
			}
			$user =  LabPincode::where('id', $id)->update(array(

			 'company_id' => $data['company_id'],
			 'pincode' => $data['pincode'],

			));
		 Session::flash('message', "Pin Updated Successfully");
		 return 1;
			}
	 return redirect()->route('admin.defaultLab.index');
		}
		public function thyrocareLab(Request $request) {
			if($request->isMethod('post')){
					$data = $request->all();
					$params = [];
					if(!empty($data['search'])) {
							$params['search']=  base64_encode($data['search']);
					}
					return redirect()->route('admin.thyrocareLab',$params)->withInput();
			}
			else{
					$query = ThyrocareLab::select('*');
					 if(!empty($request->search)){
							$search = base64_decode($request->search);
							$query
							->where('code','LIKE','%'.$search.'%')
							->orWhere('name','LIKE','%'.$search.'%')
							->orWhere('common_name','LIKE','%'.$search.'%');
					 }


					 $labs = $query->paginate(10);
			return view('admin.Thyrocare_Lab.Thyrocare_Master',compact('labs'));
			}
		}
		public function deleteThyrocareLab(Request $request) {
		 $id = $request->id;
			 ThyrocareLab::where('id', $id)->delete();
			 Session::flash('message', "Company Deleted Successfully");
			 return 1;
	 }
	 public function ThyrocareLabedit(Request $request){

				 $id = $request->id;
				 $lab = ThyrocareLab::Where( 'id', '=', $id)->first();
				 return view('admin.Thyrocare_Lab.edit',compact('lab'));
			}
			public function ThyrocareLabupdate(Request $request){
				if ($request->isMethod('post')) {
					$data = $request->all();
					$id = $data['id'];
					$user =  ThyrocareLab::where('id', $id)->update(array(
					'name' => $data['name'],
					'common_name' => $data['common_name'],

					));
				 Session::flash('message', "Lab Updated Successfully");
				 return 1;
					}
			 return redirect()->route('admin.thyrocareLab');
			 }

			 
	public function uploadoriginReport(Request $request){
		try{
		if ($request->isMethod('post')) {
			$data = $request->all();
			$fileNameOrigin = null;
			if($request->hasFile('new_origin_report')) {
			   $old_filename = public_path().'/others/lab-origin-reports/'.$data['old_origin_report'];
			   if(file_exists($old_filename)){
				 File::delete($old_filename);
			   }
			   $new_report  = $request->file('new_origin_report');
			   $fullName = str_replace(" ","",$new_report->getClientOriginalName());
			   $onlyName = explode('.',$fullName);
			   if(is_array($onlyName)){
				 $fileNameOrigin = $onlyName[0].time().".".$onlyName[1];
			   }
			   else{
				 $fileNameOrigin = $onlyName.time();
			   }
			   $request->file('new_origin_report')->move(public_path("/others/lab-origin-reports"), $fileNameOrigin);
		  }
		  else{
			  $fileNameOrigin = $data['old_origin_report'];
		  }
			if(!empty($data['id'])){
			   LabReports::where(['id'=>$data['id']])->update([
				 'origin_lab_report'=>$fileNameOrigin,
				]);
			}
			else{
				LabReports::create([
				 'company_id' => $data['company_id'],
				 'order_id' => $data['order_id'],
				 'user_id' => $data['user_id'],
				 'origin_lab_report'=>$fileNameOrigin,
				]);
			}
		   // return redirect()->route('admin.labOrders')->withInput();
		   return redirect()->back(); //If you want to go back
		  }
	   }
	   catch(\Exception $e){
		   throw new \Exception($e->getMessage());
		   // \Session::flash('error', 'Unable to process request.Error:'.json_encode($e->getMessage(), true));
	   }
	   return redirect()->back(); //If you want to go back
   }
}
