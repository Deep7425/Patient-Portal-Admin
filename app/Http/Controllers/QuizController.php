<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Session;
use App\Models\QuizForm;
use App\Models\AssementStuFeedback;
use App\Models\SessionAssesment;
use App\Models\CounslerPanelList;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\OrganizationMaster;
use App\Models\Exports\QuizFormExport;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Request as Input;

class QuizController extends Controller{
    
	public function QuizRegistration(Request $request,$slug) {
		if($request->isMethod('post')) {
			$data = $request->all();
			$validator = Validator::make($data, [
				'name' => 'required|max:50',
				'mobile' => 'required',
				'gender' => 'required',
				'age' => 'required'
			]);
			if($validator->fails()) {
				$errors = $validator->errors();
				return redirect('quiz-registration')->withErrors($validator)->withInput();
			}
			else {
				$isExists = QuizForm::where('mobile',$data['mobile'])->count();
				if($isExists == 0) {
					$form =  QuizForm::create([
						 'org_id' => isset($data['oid'])? base64_decode($data['oid']) : null,
						 'name' => $data['name'],
						 'age' => $data['age'],
						 'gender' => $data['gender'],
						 'mobile' => $data['mobile'],
						 'class' => $data['mobile'],
						 'subject' => $data['subject'],
						 'institute_id' => $data['institute_id'],
					 ]);
					return redirect()->route('quiz',['id'=>base64_encode($form->id)]);
				}
				else{
					return '<h3 class="mental-res" style="font-size:30px; font-family:arial; position:absolute; left:0px; right:0px; width:100%; text-align:center; font-weight:600; top:0px; bottom:0px; height:150px; margin:auto; color:#0b316d;">Your form already submitted!<h3>';
				}
			}
			return redirect()->route('QuizRegistration');
        }
		if(!empty($slug)){
			$oid = getOrganizationIdBySlug($slug);
			return view('pages.quiz-registration',compact('slug','oid'));
		}
		else{
			return abort(404);
		}
    }
	public function index(Request $request) {
		if($request->isMethod('post')) {
			$data = $request->all();
			$quiz_id = base64_decode($data['quiz_id']);
			QuizForm::where('id', $quiz_id)->update(array(
				'meta_data' => $data['answerObject']
			));
			$status = getScoreByUser($data['answerObject']);
			if(!empty($status)){
				QuizForm::where('id', $quiz_id)->update(array(
					'status' => $status
				));
			}
			return 1;
        }
		return view('pages.quiz');
    }
	
	public function healthAssesAdmin(Request $request,$slug) {
		$orgData = null; $totalAssessment = null; $totalAssessmentToday = null; $totalReg = null; $chartArray = []; $piChartArray = []; $wildChart = []; $piChartRegArray = [];
		if(!empty($slug)) {
			$orgData = OrganizationMaster::where("slug", $slug)->first();
			$totalAssessment = QuizForm::where('org_id',$orgData->id)->where('meta_data','!=',null)->count();
			$totalAssessmentPending = QuizForm::where('org_id',$orgData->id)->where('meta_data','=',null)->count();
			$totalAssessmentToday = QuizForm::where('org_id',$orgData->id)->where('meta_data','!=',null)->whereDate('created_at','>=', date('y-m-d'))->count();
			$totalReg = QuizForm::where('org_id',$orgData->id)->count();
			$quizDatas = $this->getDataBySlug($slug);
			$normal = 0; $mild =0; $most_val =0;
			$negativeA_most_val = 0; $detechment_most_val = 0; $antagonism_most_val = 0; $disinhibition_most_val = 0; $psychoticism_most_val = 0;
			$negativeA_mild = 0; $detechment_mild = 0; $antagonism_mild = 0; $disinhibition_mild = 0; $psychoticism_mild = 0;
 			if(count($quizDatas)) {
				foreach($quizDatas as $index => $raw) {
					$negative_effect = $raw->negative_effect;
					$detechment = $raw->detechment;
					$antagonism = $raw->antagonism;
					$disinhibition = $raw->disinhibition;
					$psychoticism = $raw->psychoticism;
					
					if($negative_effect > 2 && $negative_effect <= 3) {
						$negativeA_most_val ++;
					}
					if($negative_effect > 1 && $negative_effect <= 2) {
						$negativeA_mild ++;
					}
					if($detechment > 2 && $detechment <= 3){
						$detechment_most_val ++;
					}
					if($detechment > 1 && $detechment <= 2){
						$detechment_mild ++;
					}
					if($antagonism > 2 && $antagonism <= 3){
						$antagonism_most_val ++;
					}
					if($antagonism > 1 && $antagonism <= 2){
						$antagonism_mild ++;
					}
					if($disinhibition > 2 && $disinhibition <= 3){
						$disinhibition_most_val ++;
					}
					if($disinhibition > 1 && $disinhibition <= 2){
						$disinhibition_mild ++;
					}
					if($psychoticism > 2 && $psychoticism <= 3){
						$psychoticism_most_val ++;
					}
					if($psychoticism > 1 && $psychoticism <= 2){
						$psychoticism_mild ++;
					}
					
					
					$finalTotalScore = $raw->finalTotalScore;
					if($finalTotalScore >= 0 && $finalTotalScore <= 1){
						$normal ++ ;
					}
					if($finalTotalScore > 1 && $finalTotalScore <= 2){
						$mild ++;
					}
					if($finalTotalScore > 2 && $finalTotalScore <= 3){
						$most_val ++;
					}
				}
			}
			$chartArray[] = ['title'=>'Negative Affect','tot'=>$negativeA_most_val];
			$chartArray[] = ['title'=>'Detachment','tot'=>$detechment_most_val];
			$chartArray[] = ['title'=>'Antagonism','tot'=>$antagonism_most_val];
			$chartArray[] = ['title'=>'Disinhibition','tot'=>$disinhibition_most_val];
			$chartArray[] = ['title'=>'Psychoticism','tot'=>$psychoticism_most_val];
			
			
			$wildChart[] = ['title'=>'Negative Affect','tot'=>$negativeA_mild];
			$wildChart[] = ['title'=>'Detachment','tot'=>$detechment_mild];
			$wildChart[] = ['title'=>'Antagonism','tot'=>$antagonism_mild];
			$wildChart[] = ['title'=>'Disinhibition','tot'=>$disinhibition_mild];
			$wildChart[] = ['title'=>'Psychoticism','tot'=>$psychoticism_mild];
			
			$piChartArray[] = ['title'=>'Normal','tot'=>$normal];
			$piChartArray[] = ['title'=>'Mild','tot'=>$mild];
			$piChartArray[] = ['title'=>'Most Vulnerable','tot'=>$most_val];
			
			// $piChartRegArray[] = ['title'=>'Total Registered','tot'=>$totalReg];
			$piChartRegArray[] = ['title'=>'Assessment Done','tot'=>$totalAssessment];
			$piChartRegArray[] = ['title'=>'Assessment Pending','tot'=>$totalAssessmentPending];
			
			$totChartVal = count($quizDatas);
			// $chartArray = json_encode($chartArray);
		}
		// pr($totChartVal);
		// echo $normal."--".$mild."--".$most_val;die;
		return view('pages.quiz-files.health-asses-admin',compact('totalAssessment','totalReg','totalAssessmentToday','orgData','chartArray','totChartVal','piChartArray','wildChart','piChartRegArray'));
	}
	public function checkDomainScore($score,$i,$j){
		if($finalTotalScore >= 0 && $finalTotalScore <= 1) {
			$normal ++ ;
		}
		if($finalTotalScore > 1 && $finalTotalScore <= 2){
			$mild ++;
		}
		if($finalTotalScore > 2 && $finalTotalScore <= 3){
			$most_val ++;
		}
	}
	public function assessmentData(Request $request,$slug) {
		$enquirys = [];
		if(!empty($slug)) {
			$enquirys = $this->getDataBySlug($slug);
		}
		return $enquirys;
	}
	
	public function getDataBySlug($slug) {
		$orgData = OrganizationMaster::select('id','pwd','title')->where("slug", $slug)->first();
		$enquirys = QuizForm::where('org_id',$orgData->id)->where('meta_data','!=',null)->get();
		 if($enquirys->count() > 0){
		  foreach($enquirys as $index => $element) {
			$meta_data = !empty($element->meta_data) ? json_decode($element->meta_data,true) : [];
			$negative_effect = 0;
			$negative_effect_ans = 0;
			$detechment = 0;
			$detechment_ans = 0;
			$antagonism = 0;
			$antagonism_ans = 0;
			$disinhibition = 0;
			$disinhibition_ans = 0;
			$psychoticism = 0;
			$psychoticism_ans = 0;
			
			if(count($meta_data)>0) {
				foreach($meta_data as $raw) {
					$ans = null;
					if($raw['ans'] == 'optionA'){
						$ans = 0;
					}
					if($raw['ans'] == 'optionB'){
						$ans = 1;
					}
					if($raw['ans'] == 'optionC'){
						$ans = 2;
					}
					if($raw['ans'] == 'optionD'){
						$ans = 3;
					}
					if($raw['ques'] == 8 || $raw['ques'] == 9 || $raw['ques'] == 10 || $raw['ques'] == 11 || $raw['ques'] == 15){
						if($ans != null){
							$negative_effect_ans += $ans; 
						}
					}
					if($raw['ques'] == 4 || $raw['ques'] == 13 || $raw['ques'] == 14 || $raw['ques'] == 16 || $raw['ques'] == 18){
						if($ans != null){
							$detechment_ans += $ans; 
						}
					}
					if($raw['ques'] == 17 || $raw['ques'] == 19 || $raw['ques'] == 20 || $raw['ques'] == 22 || $raw['ques'] == 25){
						if($ans != null){
							$antagonism_ans += $ans; 
						}
					}
					if($raw['ques'] == 1 || $raw['ques'] == 2 || $raw['ques'] == 3 || $raw['ques'] == 5 || $raw['ques'] == 6){
						if($ans != null){
							$disinhibition_ans += $ans; 
						}
					}
					if($raw['ques'] == 7 || $raw['ques'] == 12 || $raw['ques'] == 21 || $raw['ques'] == 23 || $raw['ques'] == 24){
						if($ans != null){
							$psychoticism_ans += $ans; 
						}
					}
				}
			}
			$negative_effect = $negative_effect_ans / 5 ;
			$detechment = $detechment_ans / 5 ;
			$antagonism = $antagonism_ans / 5 ;
			$disinhibition = $disinhibition_ans / 5 ;
			$psychoticism = $psychoticism_ans / 5 ;
			
			$totalScore = $negative_effect_ans + $detechment_ans + $antagonism_ans + $disinhibition_ans + $psychoticism_ans;
			$finalTotalScore = $totalScore / 25 ;
			
			$element['id'] = $index + 1;
			$element['negative_effect'] = round($negative_effect);
			$element['detechment'] = round($detechment);
			$element['antagonism'] = round($antagonism);
			$element['disinhibition'] = round($disinhibition);
			$element['psychoticism'] = round($psychoticism);
			$element['finalTotalScore'] = round($finalTotalScore);
		 }
		}
		return $enquirys;
	}
	
	public function programme(Request $request,$slug) {
		$orgData = OrganizationMaster::where("slug", $slug)->first();
		return view('pages.quiz-files.programme',compact('orgData'));
	}
	public function assessmentList(Request $request,$slug) {
		$orgData = OrganizationMaster::select('id','pwd','title')->where("slug", $slug)->first();
		$query=QuizForm::where('org_id',$orgData->id)->where('meta_data','!=',null);

		if ($request->input('from_date') != '') {
			$from_date=date("Y-m-d", strtotime($request->input('from_date')) );
			$query->whereDate('created_at','>=', $from_date);
		}
		if ($request->input('to_date') != '') {
			$to_date=date("Y-m-d", strtotime($request->input('to_date')) );
			$query->whereDate('created_at','<=', $to_date);
		}

		if ($request->input('candidate') != '') {
			$candidate=$request->input('candidate');
			if(is_numeric($candidate)){
				$query->where('mobile', $candidate);
			}else{
				$query->where('name','like', '%' . $candidate . '%');
				
			}
			
		}

		if ($request->input('status') != '') {
			$status=$request->input('status');
			
				$query->where('status', $status);
			
			
		}


		if ($request->input('assesment') != '') {
		 $enquirys = $query->get();
		}else{
			$enquirys = $query->paginate(50);
		}
		 $arrss = [];
		 if(count($enquirys) > 0){
		  foreach($enquirys as $index => $element) {
			$meta_data = !empty($element->meta_data) ? json_decode($element->meta_data,true) : [];
			$negative_effect = 0;
			$negative_effect_ans = 0;
			$detechment = 0;
			$detechment_ans = 0;
			$antagonism = 0;
			$antagonism_ans = 0;
			$disinhibition = 0;
			$disinhibition_ans = 0;
			$psychoticism = 0;
			$psychoticism_ans = 0;
			
			if(count($meta_data)>0) {
				foreach($meta_data as $raw) {
					$ans = null;
					if($raw['ans'] == 'optionA'){
						$ans = 0;
					}
					if($raw['ans'] == 'optionB'){
						$ans = 1;
					}
					if($raw['ans'] == 'optionC'){
						$ans = 2;
					}
					if($raw['ans'] == 'optionD'){
						$ans = 3;
					}
					if($raw['ques'] == 8 || $raw['ques'] == 9 || $raw['ques'] == 10 || $raw['ques'] == 11 || $raw['ques'] == 15){
						if($ans != null){
							$negative_effect_ans += $ans; 
						}
					}
					if($raw['ques'] == 4 || $raw['ques'] == 13 || $raw['ques'] == 14 || $raw['ques'] == 16 || $raw['ques'] == 18){
						if($ans != null){
							$detechment_ans += $ans; 
						}
					}
					if($raw['ques'] == 17 || $raw['ques'] == 19 || $raw['ques'] == 20 || $raw['ques'] == 22 || $raw['ques'] == 25){
						if($ans != null){
							$antagonism_ans += $ans; 
						}
					}
					if($raw['ques'] == 1 || $raw['ques'] == 2 || $raw['ques'] == 3 || $raw['ques'] == 5 || $raw['ques'] == 6){
						if($ans != null){
							$disinhibition_ans += $ans; 
						}
					}
					if($raw['ques'] == 7 || $raw['ques'] == 12 || $raw['ques'] == 21 || $raw['ques'] == 23 || $raw['ques'] == 24){
						if($ans != null){
							$psychoticism_ans += $ans; 
						}
					}
				}
			}
			$negative_effect = $negative_effect_ans / 5 ;
			$detechment = $detechment_ans / 5 ;
			$antagonism = $antagonism_ans / 5 ;
			$disinhibition = $disinhibition_ans / 5 ;
			$psychoticism = $psychoticism_ans / 5 ;
			
			$totalScore = $negative_effect_ans + $detechment_ans + $antagonism_ans + $disinhibition_ans + $psychoticism_ans;
			$finalTotalScore = $totalScore / 25 ;
			
			$element['id'] = $index + 1;
			$element['negative_effect'] = round($negative_effect);
			$element['detechment'] = round($detechment);
			$element['antagonism'] = round($antagonism);
			$element['disinhibition'] = round($disinhibition);
			$element['psychoticism'] = round($psychoticism);
			$element['finalTotalScore'] = round($finalTotalScore);
			
		 }
		}
	
	
		// if ($request->input('assesment') != '') {

			
		// 	$assessArray = [];
		
		// 	foreach($enquirys as $raw){

		// 		if($request->input('assesment')=='mild'){
		// 			$finalTotalScore = $raw->finalTotalScore;
		// 			if($finalTotalScore > 1 && $finalTotalScore <= 2){
		// 				$assessArray[] = $raw;
		// 		    }
		// 	     }

		// 	   if($request->input('assesment')=='normal'){
		// 		$finalTotalScore = $raw->finalTotalScore;
				
		// 		if($finalTotalScore >= 0 && $finalTotalScore <= 1){
		// 			$assessArray[] = $raw;
		// 		}
		//         }

		// 	   if($request->input('assesment')=='most_vulnerable'){
		// 		$finalTotalScore = $raw->finalTotalScore;
		// 		if($finalTotalScore > 2 && $finalTotalScore <= 3){
		// 			$assessArray[] = $raw;
		// 		}
		// 		}

			
		// 	}
		// 	$enquirys = $assessArray;
		// 	$page = 50;
		// $input = Input::all();
		// if (isset($input['page']) && !empty($input['page'])) { $currentPage = $input['page']; } else { $currentPage = 1; }
		// $offset = ($currentPage * $page) - $page;
		// $itemsForCurrentPage = array_slice($enquirys, $offset, $page, false);
		// $enquirys =  new Paginator($itemsForCurrentPage, count($enquirys), $page,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
		// }

		
		if($request->input('file_type') == "excel") {
			$i=1;
			$ordersDataArray[] = array('Sr. No.','Name','Gender','Mobile','Age','Negative Effect ','Detachment','Antgonism ','Disinhibition ','Psuchoticism','Total Score','Status');
					foreach($enquirys as $res){

						$ordersDataArray[] = array(
							$i,
							$res->name,
							$res->gender,
							$res->mobile,
						
							$res->age,
							$res->negative_effect,
							$res->detechment,
							$res->antagonism,
							$res->disinhibition,
							$res->psychoticism,
							$res->finalTotalScore,
							$res->status,
							
						);

						$i++;
					}
	               
			return Excel::download(new QuizFormExport($ordersDataArray), 'assessment.xlsx');
		}


	
		$orgData = OrganizationMaster::where("slug", $slug)->first();
		
		return view('pages.quiz-files.assessment-list',compact('orgData','enquirys'));
	}

	public function reportcard(Request $request){

		$slug=$request->slug;

		
		
		
        //  $id=base64_decode($request->id);
	
		// 	$SessionAssesdata=SessionAssesment::get();
		
		//  }
	
		// $orgData = OrganizationMaster::select('id','pwd','title')->where("slug", $slug)->first();

	
	
		$query=SessionAssesment::with('QuizForm');

		if(isset($request->status)){
          
			if($request->status==1){
				$query->whereColumn('session_assigned','session_taken');
			}

			if($request->status==0){
				
				$query->whereColumn('session_assigned','!=','session_taken');
			}
			
			
		}

		
		if(isset($request->id)){
		
			$id=base64_decode($request->id);
			
			$query->where('quiz_id',$id);
			
		}

		// dd($query->count());

		$SessionAssesdata=$query->get();
	
		
		
		//  $arrss = [];
		
			// $meta_data = !empty($enquirys->meta_data) ? json_decode($enquirys->meta_data,true) : [];
			
			// $negative_effect = 0;
			// $negative_effect_ans = 0;
			// $detechment = 0;
			// $detechment_ans = 0;
			// $antagonism = 0;
			// $antagonism_ans = 0;
			// $disinhibition = 0;
			// $disinhibition_ans = 0;
			// $psychoticism = 0;
			// $psychoticism_ans = 0;
			

			// $negative_effect = $negative_effect_ans / 5 ;
			// $detechment = $detechment_ans / 5 ;
			// $antagonism = $antagonism_ans / 5 ;
			// $disinhibition = $disinhibition_ans / 5 ;
			// $psychoticism = $psychoticism_ans / 5 ;
			
			// $totalScore = $negative_effect_ans + $detechment_ans + $antagonism_ans + $disinhibition_ans + $psychoticism_ans;
			// $finalTotalScore = $totalScore / 25 ;
			
			// $negative_effect = round($negative_effect);
			// $detechment = round($detechment);
			// $antagonism = round($antagonism);
			// $disinhibition = round($disinhibition);
			// $psychoticism = round($psychoticism);
			// $finalTotalScore = round($finalTotalScore);
			
			// $asses='';
				
			// 	if($finalTotalScore > 1 && $finalTotalScore <= 2){
			// 		$asses = 'Mild';
			// 	}
			   
				
				
			// 	if($finalTotalScore >= 0 && $finalTotalScore <= 1){
			// 		$asses = 'Normal';
			// 	}
		       
			// 	if($finalTotalScore > 2 && $finalTotalScore <= 3){
			// 		$asses = 'Most Vulnerable';
			// 	}

		

            
		
		// if($request->input('file_type') == "excel") {
		// 	$i=1;
		// 	$ordersDataArray[] = array('Sr. No.','Name','Gender','Mobile','Age','Negative Effect ','Detachment','Antgonism ','Disinhibition ','Psuchoticism','Total Score');
		// 			foreach($enquirys as $res){

		// 				$ordersDataArray[] = array(
		// 					$i,
		// 					$res->name,
		// 					$res->gender,
		// 					$res->mobile,
						
		// 					$res->age,
		// 					$res->negative_effect,
		// 					$res->detechment,
		// 					$res->antagonism,
		// 					$res->disinhibition,
		// 					$res->psychoticism,
		// 					$res->finalTotalScore,
							
		// 				);

		// 				$i++;
		// 			}
	               
		// 	return Excel::download(new QuizFormExport($ordersDataArray), 'assessment.xlsx');
		// }


		
		$orgData = OrganizationMaster::where("slug", $slug)->first();


		return view('pages.quiz-files.report-card-details',compact('orgData','SessionAssesdata','slug'));



	}


	public function updateNextsessiondate(Request $request){



		SessionAssesment::where('id', $request->session_id)->update(array(
			'next_session_date' => $request->datatime
		));

		return 1;

	}
	
	public function getScoreByUser($meta_data){
		$meta_data = !empty($meta_data) ? json_decode($meta_data,true) : [];
		$negative_effect = 0;
		$negative_effect_ans = 0;
		$detechment = 0;
		$detechment_ans = 0;
		$antagonism = 0;
		$antagonism_ans = 0;
		$disinhibition = 0;
		$disinhibition_ans = 0;
		$psychoticism = 0;
		$psychoticism_ans = 0;
		
		if(count($meta_data)>0) {
			foreach($meta_data as $raw) {
				$ans = null;
				if($raw['ans'] == 'optionA'){
					$ans = 0;
				}
				if($raw['ans'] == 'optionB'){
					$ans = 1;
				}
				if($raw['ans'] == 'optionC'){
					$ans = 2;
				}
				if($raw['ans'] == 'optionD'){
					$ans = 3;
				}
				if($raw['ques'] == 8 || $raw['ques'] == 9 || $raw['ques'] == 10 || $raw['ques'] == 11 || $raw['ques'] == 15){
					if($ans != null){
						$negative_effect_ans += $ans; 
					}
				}
				if($raw['ques'] == 4 || $raw['ques'] == 13 || $raw['ques'] == 14 || $raw['ques'] == 16 || $raw['ques'] == 18){
					if($ans != null){
						$detechment_ans += $ans; 
					}
				}
				if($raw['ques'] == 17 || $raw['ques'] == 19 || $raw['ques'] == 20 || $raw['ques'] == 22 || $raw['ques'] == 25){
					if($ans != null){
						$antagonism_ans += $ans; 
					}
				}
				if($raw['ques'] == 1 || $raw['ques'] == 2 || $raw['ques'] == 3 || $raw['ques'] == 5 || $raw['ques'] == 6){
					if($ans != null){
						$disinhibition_ans += $ans; 
					}
				}
				if($raw['ques'] == 7 || $raw['ques'] == 12 || $raw['ques'] == 21 || $raw['ques'] == 23 || $raw['ques'] == 24){
					if($ans != null){
						$psychoticism_ans += $ans; 
					}
				}
			}
		}
		$negative_effect = $negative_effect_ans / 5 ;
		$detechment = $detechment_ans / 5 ;
		$antagonism = $antagonism_ans / 5 ;
		$disinhibition = $disinhibition_ans / 5 ;
		$psychoticism = $psychoticism_ans / 5 ;
		
		$totalScore = $negative_effect_ans + $detechment_ans + $antagonism_ans + $disinhibition_ans + $psychoticism_ans;
		$finalTotalScore = $totalScore / 25;
		$asses = null;
		if($finalTotalScore >= 0 && $finalTotalScore <= 1){
			$asses = 1;
		}
		if($finalTotalScore > 1 && $finalTotalScore <= 2){
			$asses = 2;
		}
		if($finalTotalScore > 2 && $finalTotalScore <= 3){
			$asses = 3;
		}
		return $asses;
	}

	public function counciling(Request $request){

		 $data=$request->all();
		 $newArray=[];
         unset($data['quiz_id'][0]);
		//  dd($data);
				
		 foreach($data['quiz_id'] as $key=> $val){
 
			$newArray[$key]['quiz_id']=$val;
			$newArray[$key]['counselor_id']='1';
			$newArray[$key]['assigned_date']=date('Y-m-d H:i:s');
			$newArray[$key]['created_at']=date('Y-m-d H:i:s');
			$newArray[$key]['updated_at']=date('Y-m-d H:i:s');

		 }

		 CounslerPanelList::insert($newArray);
		// $item = CounslerPanelList::create( $newArray);

		return back();

	}

	public function councelingdashboard(Request $request,$slug){

		$orgData = null; $totalAssessment = null; $totalAssessmentToday = null; $totalReg = null; $chartArray = []; $piChartArray = []; $wildChart = []; $piChartRegArray = [];
		if(!empty($slug)) {
			$orgData = OrganizationMaster::where("slug", $slug)->first();
			// $totalAssessment = QuizForm::where('org_id',$orgData->id)->where('meta_data','!=',null)->count();
			$totalAssessmentPending = CounslerPanelList::where('session_status','0')->count();
			$totalAssessmentDone = CounslerPanelList::where('session_status','1')->count();
			// $totalAssessmentToday = OrganizationMaster::where('created_at', '>=', date('Y-m-d').' 00:00:00')->count();
			$totalAssessmentToday=CounslerPanelList::whereDate('created_at', '=', date('Y-m-d'))->count();
			$Quiz=QuizForm::select('status')->get();
			$query=QuizForm::where('org_id',$orgData->id)->where('status','=','2');
			$totalReg = CounslerPanelList::count();
			$totalAssessment = CounslerPanelList::count();
			$quizDatas = $this->getDataBySlug($slug);
			$normal = 0; $mild =0; $most_val =0;
			$negativeA_most_val = 0; $detechment_most_val = 0; $antagonism_most_val = 0; $disinhibition_most_val = 0; $psychoticism_most_val = 0;
			$negativeA_mild = 0; $detechment_mild = 0; $antagonism_mild = 0; $disinhibition_mild = 0; $psychoticism_mild = 0;
 			if(count($quizDatas)) {
				foreach($quizDatas as $index => $raw) {
					$negative_effect = $raw->negative_effect;
					$detechment = $raw->detechment;
					$antagonism = $raw->antagonism;
					$disinhibition = $raw->disinhibition;
					$psychoticism = $raw->psychoticism;
					
					if($negative_effect > 2 && $negative_effect <= 3) {
						$negativeA_most_val ++;
					}
					if($negative_effect > 1 && $negative_effect <= 2) {
						$negativeA_mild ++;
					}
					if($detechment > 2 && $detechment <= 3){
						$detechment_most_val ++;
					}
					if($detechment > 1 && $detechment <= 2){
						$detechment_mild ++;
					}
					if($antagonism > 2 && $antagonism <= 3){
						$antagonism_most_val ++;
					}
					if($antagonism > 1 && $antagonism <= 2){
						$antagonism_mild ++;
					}
					if($disinhibition > 2 && $disinhibition <= 3){
						$disinhibition_most_val ++;
					}
					if($disinhibition > 1 && $disinhibition <= 2){
						$disinhibition_mild ++;
					}
					if($psychoticism > 2 && $psychoticism <= 3){
						$psychoticism_most_val ++;
					}
					if($psychoticism > 1 && $psychoticism <= 2){
						$psychoticism_mild ++;
					}
					
					
					$finalTotalScore = $raw->finalTotalScore;
					if($finalTotalScore >= 0 && $finalTotalScore <= 1){
						$normal ++ ;
					}
					if($finalTotalScore > 1 && $finalTotalScore <= 2){
						$mild ++;
					}
					if($finalTotalScore > 2 && $finalTotalScore <= 3){
						$most_val ++;
					}
				}
			}
			$chartArray[] = ['title'=>'Negative Affect','tot'=>$negativeA_most_val];
			$chartArray[] = ['title'=>'Detachment','tot'=>$detechment_most_val];
			$chartArray[] = ['title'=>'Antagonism','tot'=>$antagonism_most_val];
			$chartArray[] = ['title'=>'Disinhibition','tot'=>$disinhibition_most_val];
			$chartArray[] = ['title'=>'Psychoticism','tot'=>$psychoticism_most_val];
			
			
			$wildChart[] = ['title'=>'Negative Affect','tot'=>$negativeA_mild];
			$wildChart[] = ['title'=>'Detachment','tot'=>$detechment_mild];
			$wildChart[] = ['title'=>'Antagonism','tot'=>$antagonism_mild];
			$wildChart[] = ['title'=>'Disinhibition','tot'=>$disinhibition_mild];
			$wildChart[] = ['title'=>'Psychoticism','tot'=>$psychoticism_mild];
			
			// $piChartArray[] = ['title'=>'Normal','tot'=>$normal];
			// $piChartArray[] = ['title'=>'Mild','tot'=>$mild];
			// $piChartArray[] = ['title'=>'Most Vulnerable','tot'=>$most_val];
			
			// $piChartRegArray[] = ['title'=>'Total Registered','tot'=>$totalReg];
			$piChartRegArray[] = ['title'=>'Assessment Done','tot'=>$totalAssessmentDone];
			$piChartRegArray[] = ['title'=>'Assessment Pending','tot'=>$totalAssessmentPending];
			
			$totChartVal = count($quizDatas);
			// $chartArray = json_encode($chartArray);
		}

		foreach($Quiz as $val){
			if($val->status=='1'){
				$normal++;
			}

			if($val->status=='2'){
				$normal++;
			}

			if($val->status=='3'){
				$most_val++;
			}
			
		}
		$piChartArray[] = ['title'=>'Normal','tot'=>$normal];
		$piChartArray[] = ['title'=>'Mild','tot'=>$mild];
		$piChartArray[] = ['title'=>'Most Vulnerable','tot'=>$most_val];
		// pr($totChartVal);
		// echo $normal."--".$mild."--".$most_val;die;
	
		return view('pages.counsellor.counceling-dashboard',compact('totalAssessment','totalReg','totalAssessmentToday','orgData','chartArray','totChartVal','piChartArray','wildChart','piChartRegArray','totalAssessmentPending'));

	}

	public function counselinglist(Request $request,$slug){

		$orgData = OrganizationMaster::select('id','pwd','title')->where("slug", $slug)->first();
		$query=CounslerPanelList::with('QuizForm');
		

		if ($request->input('from_date') != '') {
			$from_date=date("Y-m-d", strtotime($request->input('from_date')) );
			$query->whereDate('created_at','>=', $from_date);
		}
		if ($request->input('to_date') != '') {
			$to_date=date("Y-m-d", strtotime($request->input('to_date')) );

			$query->whereDate('created_at','<=', $to_date);
		}

		if ($request->input('candidate') != '') {
			$candidate=$request->input('candidate');
		
			if(is_numeric($candidate)){
				$query->whereHas('QuizForm', function ($query) use ($candidate){
					$query->where('mobile', $candidate);
				 });
			}else{
				$query->whereHas('QuizForm', function ($query) use ($candidate){
					$query->where('name', $candidate);
				 });
				
			}
			
		}

		if ($request->input('status') != '') {
			$status=$request->input('status');
			
				$query->where('status', $status);
			
			
		}

		
		if ($request->input('session_status') != '') {
			$session_status=$request->input('session_status');

			
				$query->where('session_status', $session_status);
			
			
		}

		


		if ($request->input('assesment') != '') {
		 $enquirys = $query->get();
		}else{
			$enquirys = $query->paginate(50);
		}
		
		 $arrss = [];
		 if(count($enquirys) > 0){
		  foreach($enquirys as $index => $element) {
			$meta_data = !empty($element->QuizForm->meta_data) ? json_decode($element->QuizForm->meta_data,true) : [];
			$negative_effect = 0;
			$negative_effect_ans = 0;
			$detechment = 0;
			$detechment_ans = 0;
			$antagonism = 0;
			$antagonism_ans = 0;
			$disinhibition = 0;
			$disinhibition_ans = 0;
			$psychoticism = 0;
			$psychoticism_ans = 0;
			
			if(count($meta_data)>0) {
				foreach($meta_data as $raw) {
					$ans = null;
					if($raw['ans'] == 'optionA'){
						$ans = 0;
					}
					if($raw['ans'] == 'optionB'){
						$ans = 1;
					}
					if($raw['ans'] == 'optionC'){
						$ans = 2;
					}
					if($raw['ans'] == 'optionD'){
						$ans = 3;
					}
					if($raw['ques'] == 8 || $raw['ques'] == 9 || $raw['ques'] == 10 || $raw['ques'] == 11 || $raw['ques'] == 15){
						if($ans != null){
							$negative_effect_ans += $ans; 
						}
					}
					if($raw['ques'] == 4 || $raw['ques'] == 13 || $raw['ques'] == 14 || $raw['ques'] == 16 || $raw['ques'] == 18){
						if($ans != null){
							$detechment_ans += $ans; 
						}
					}
					if($raw['ques'] == 17 || $raw['ques'] == 19 || $raw['ques'] == 20 || $raw['ques'] == 22 || $raw['ques'] == 25){
						if($ans != null){
							$antagonism_ans += $ans; 
						}
					}
					if($raw['ques'] == 1 || $raw['ques'] == 2 || $raw['ques'] == 3 || $raw['ques'] == 5 || $raw['ques'] == 6){
						if($ans != null){
							$disinhibition_ans += $ans; 
						}
					}
					if($raw['ques'] == 7 || $raw['ques'] == 12 || $raw['ques'] == 21 || $raw['ques'] == 23 || $raw['ques'] == 24){
						if($ans != null){
							$psychoticism_ans += $ans; 
						}
					}
				}
			}
			$negative_effect = $negative_effect_ans / 5 ;
			$detechment = $detechment_ans / 5 ;
			$antagonism = $antagonism_ans / 5 ;
			$disinhibition = $disinhibition_ans / 5 ;
			$psychoticism = $psychoticism_ans / 5 ;
			
			$totalScore = $negative_effect_ans + $detechment_ans + $antagonism_ans + $disinhibition_ans + $psychoticism_ans;
			$finalTotalScore = $totalScore / 25 ;
			
			$element['id'] = $index + 1;
			$element['negative_effect'] = round($negative_effect);
			$element['detechment'] = round($detechment);
			$element['antagonism'] = round($antagonism);
			$element['disinhibition'] = round($disinhibition);
			$element['psychoticism'] = round($psychoticism);
			$element['finalTotalScore'] = round($finalTotalScore);
			
		 }
		}
	
	
		if ($request->input('assesment') != '') {

			
			$assessArray = [];
		
			foreach($enquirys as $raw){

				if($request->input('assesment')=='mild'){
					$finalTotalScore = $raw->finalTotalScore;
					if($finalTotalScore > 1 && $finalTotalScore <= 2){
						$assessArray[] = $raw;
				    }
			     }

			   if($request->input('assesment')=='normal'){
				$finalTotalScore = $raw->finalTotalScore;
				
				if($finalTotalScore >= 0 && $finalTotalScore <= 1){
					$assessArray[] = $raw;
				}
		        }

			   if($request->input('assesment')=='most_vulnerable'){
				$finalTotalScore = $raw->finalTotalScore;
				if($finalTotalScore > 2 && $finalTotalScore <= 3){
					$assessArray[] = $raw;
				}
				}

			
			}
			$enquirys = $assessArray;
			$page = 50;
		$input = Input::all();
		if (isset($input['page']) && !empty($input['page'])) { $currentPage = $input['page']; } else { $currentPage = 1; }
		$offset = ($currentPage * $page) - $page;
		$itemsForCurrentPage = array_slice($enquirys, $offset, $page, false);
		$enquirys =  new Paginator($itemsForCurrentPage, count($enquirys), $page,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
		}

		
		if($request->input('file_type') == "excel") {
			$i=1;
			$ordersDataArray[] = array('Sr. No.','Name','Gender','Mobile','Age','Negative Effect ','Detachment','Antgonism ','Disinhibition ','Psuchoticism','Total Score','Status');
					foreach($enquirys as $res){

						$ordersDataArray[] = array(
							$i,
							$res->QuizForm->name,
							$res->QuizForm->gender,
							$res->QuizForm->mobile,
						
							$res->QuizForm->age,
							$res->negative_effect,
							$res->detechment,
							$res->antagonism,
							$res->disinhibition,
							$res->psychoticism,
							$res->finalTotalScore,
							$res->status,
							
						);

						$i++;
					}
	               
			return Excel::download(new QuizFormExport($ordersDataArray), 'assessment.xlsx');
		}


	
		$orgData = OrganizationMaster::where("slug", $slug)->first();
		
		return view('pages.counsellor.counseliing-list',compact('orgData','enquirys'));


	}

	public function councilingdone(Request $request){

		$data=$request->all();
		
		unset($data['counce_id'][0]);

	    
		$updateProduct = CounslerPanelList::whereIn('id',$data['counce_id'])
		->update(['session_status' => '1']);

	   // $item = CounslerPanelList::create( $newArray);

	   return back();

   }

   public function addNote(Request $request){

		$data=$request->all();
		
		$updateProduct = CounslerPanelList::where('id',$data['counsellor_id'])
		->update(['note' => $data['note']]);

		return 1;

   }

   public function Addfeedback(Request $request){

    $data=	$request->all();

	if ($request->method('post')){

		$form =  AssementStuFeedback::create([
			'quiz_id' => '1',
			'hg_rating' => $data['hg_rating'],
			'counselor_feedback' => $data['counselor_feedback'],
			'quality' => $data['quality'],
			'content' => $data['content'],
		
		]);

	}
	


	return view('pages.patient-feedback');
          

   }


	
}