<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use DB;
// use App\Models\Admin\Admin;
use App\Models\User;
use App\Models\NonHgDoctors;
use App\Models\NewsFeeds;
use App\Models\Admin\Symptoms;
use App\Models\Admin\SymptomTags;
use App\Models\Admin\SymptomsSpeciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use URL;
use Mail;
use File;
use Route;
//use Illuminate\Mail\Mailer;
class SymptomController extends Controller {
    
    
	
		
	public function SymptomsMaster(Request $request) {
		$search = '';
		if ($request->isMethod('post')) {
		$params = array();
         if (!empty($request->input('search'))) {
             $params['search'] = base64_encode($request->input('search'));
         }
		 if (!empty($request->input('spaciality'))) {
             $params['spaciality'] = base64_encode($request->input('spaciality'));
         }
		 if (!empty($request->input('page_no'))) {
             $params['page_no'] = base64_encode($request->input('page_no'));
         }
         return redirect()->route('symptoms.SymptomsMaster',$params)->withInput();
		}
		else {
         // $symptoms = SpecialitySymptoms::where('delete_status', '=', '1')->orderBy('id', 'desc')->paginate(10);
			// if ($request->input('search')  != '') {
			   $search = base64_decode($request->input('search'));
			   $spaciality = base64_decode($request->input('spaciality'));
			   $query = Symptoms::with("SymptomsSpeciality.Speciality")->where('delete_status', '=', '1');
			   $page = 25;
				if(!empty($request->input('page_no'))){
					$page = base64_decode($request->input('page_no')); 
				}
				if(!empty($search)){
					$query->where('symptom','like','%'.$search.'%');
				}
				if($spaciality){ 
					$query->whereHas('SymptomsSpeciality', function($q)  use ($spaciality) {$q->Where(['speciality_id'=>$spaciality]);});
				}
			    $symptoms = $query->orderBy('id', 'desc')->paginate($page);
		}
		return view('admin.manage_symptoms.symptoms-master',compact('symptoms'));
	}

    public function addSymptoms(Request $request){
		if($request->isMethod('post')) {
            $data = $request->all();
			$symptomTags = $data['tags'];
			$spaciality_id = [];
          	$symtomps_exists_array = [];
			if(!empty($data['spaciality_id'])) {
				foreach($data['spaciality_id'] as $spc) {
					$symtomps_exists = Symptoms::with("SymptomsSpeciality")->where('symptom' ,'like', $data['symptom'])->whereHas("SymptomsSpeciality",function($q) use($spc) {$q->Where(['speciality_id'=>$spc]);})->count();
					if($symtomps_exists > 0) {
						$symtomps_exists_array[] = ['id'=>$spc,'name'=>getSpecialityData($spc)];
					}
					else{
						$spaciality_id[] = $spc;
					}
				}
			}
			if(count($spaciality_id) > 0) {
				$symptoms = Symptoms::create([
					'symptom' => $data['symptom'],
					'symptom_hindi' => $data['symptom_hindi'],
					'description' => $data['description'],
					'description_hindi' => $data['description_hindi'],
					'disease' => $data['disease'],
					'treatment' => $data['treatment'],
					'treatment_hindi' => $data['treatment_hindi'],
					'cause' => $data['cause'],
					'cause_hindi' => $data['cause_hindi'],
					'status' => $data['status'],
				]); 
				foreach($spaciality_id as $spc) {
					SymptomsSpeciality::create([
						'symptoms_id' => $symptoms->id,
						'speciality_id' => $spc
					]);		
				}
			
			if (!is_null($symptomTags) && is_array($symptomTags) && count($symptomTags) > 0) {
					foreach(json_decode($symptomTags) as $tag) {
						SymptomTags::create([
							'symptoms_id' => $symptoms->id,
							'text' => $tag
						]);		
					}
				}
			}
			Session::flash('message', "Speciality Symptoms Added Successfully");
			if(count($symtomps_exists_array)>0){
				return ["spaciality"=>$symtomps_exists_array,"symptom"=>$data['symptom']];
			}
			else return 1;
		}
		return view('admin.manage_symptoms.add-symptoms');
	}
	public function editSymptoms(Request $request) {
        $id = $request->id;
        $symptom = Symptoms::with(["SymptomsSpeciality","SymptomTags"])->where('delete_status', '=', '1')->Where( 'id', '=', $id)->first();
		$spaciality_id = [];
		if(count($symptom->SymptomsSpeciality) > 0){
			foreach($symptom->SymptomsSpeciality as $val){
				$spaciality_id[] = $val->speciality_id;
			}
		}
        return view('admin.manage_symptoms.edit-symptoms',compact('symptom','spaciality_id'));
    }
	public function updateSymptoms(Request $request){
		// session_unset('message');
        if($request->isMethod('post')) {
			$data = $request->all(); 
			$symptomTags = $data['tags'];
			$spaciality_id = [];
          	$symtomps_exists_array = [];
			if(!empty($data['spaciality_id'])) {
				foreach($data['spaciality_id'] as $spc) {
					$symtomps_exists = Symptoms::with("SymptomsSpeciality")->where('symptom' ,'like', $data['symptom'])->where('id','!=', $data['id'])->whereHas("SymptomsSpeciality",function($q) use($spc) {$q->Where(['speciality_id'=>$spc]);})->count();
					if($symtomps_exists > 0) {
						$symtomps_exists_array[] = ['id'=>$spc,'name'=>getSpecialityData($spc)];
					}
					else{
						$spaciality_id[] = $spc;
					}
				}
			}
			if(count($spaciality_id) > 0) {
				$symptoms = Symptoms::where('id', $data['id'])->update(array(
					'symptom' => $data['symptom'],
					'symptom_hindi' => $data['symptom_hindi'],
					'description' => $data['description'],
					'description_hindi' => $data['description_hindi'],
					'disease' => $data['disease'],
					'treatment' => $data['treatment'],
					'treatment_hindi' => $data['treatment_hindi'],
					'cause' => $data['cause'],
					'cause_hindi' => $data['cause_hindi'],
					'status' => $data['status'],
				)); 
				SymptomsSpeciality::where('symptoms_id',$data['id'])->delete();
				foreach($spaciality_id as $spc) {
					SymptomsSpeciality::create([
						'symptoms_id' => $data['id'],
						'speciality_id' => $spc
					]);	
				}
				if ($symptomTags !== null && count($symptomTags) > 0) {
					SymptomTags::where('symptoms_id',$data['id'])->delete();	
					foreach(json_decode($symptomTags) as $tag) {
						SymptomTags::create([
							'symptoms_id' => $data['id'],
							'text' => $tag
						]);		
					}
				}
			}
			if(count($symtomps_exists_array)>0){
				return ["spaciality"=>$symtomps_exists_array,"symptom"=>$data['symptom']];
			}
			else return 1;
		}
		return 2;
	}
	public function deleteSymptoms(Request $request) {
		session_unset();
		$id = $request->id; 
		Symptoms::where('id', $id)->delete();
		SymptomsSpeciality::where('symptoms_id', $id)->delete();
		SymptomTags::where('symptoms_id', $id)->delete();
		Session::flash('message', "Speciality Symptoms Deleted Successfully");
		return 1;
    }


	
	
	


}