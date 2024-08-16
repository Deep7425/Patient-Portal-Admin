<style type="text/css">
body {
  font: 12pt Georgia, "Times New Roman", Times, serif;
  line-height: 1.3;
}

@page {
  /* switch to landscape */
  size:auto;
  /* set page margins */
  margin: 0.5cm;
  /* Default footers */

  @bottom-left {
    content: "Department of Strategy";
  }
  @bottom-right {
    content: counter(page) " of " counter(pages);
  }

}

/* footer, header - position: fixed */
#header {
  position: fixed;
  width: 100%;
  top: 0;
  left: 0;
  right: 0;
}

#footer {
  position: fixed;
  width: 100%;
  bottom: 0;
  left: 0;
  right: 0;
}
/* Fix overflow of headers and content */
body {
  padding-top: 10px;
}
.custom-page-start {
  margin-top: 50px;
}
.custom-footer-page-number:after {
  content: counter(page);
}
</style>

<body>
  
  <div id="header" style="font-family:Arial, Helvetica, sans-serif; float:left; width:755px; margin: 0px auto; padding-left:0px;">

    <table class="table" style=" width:100%;"cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                    <th  style=" font-size:13.5px; margin-top:100px;">
                        <table class="table" style=" width:100%;" cellpadding="0" cellspacing="0">
                    <tbody>

                    <tr>
                    <td style="border-top:1px solid #189ad4; padding-top:8px; vertical-align: top;"><strong>Patient Name</strong></td>
                    <td style="width: 40px; text-align:center; color: #189ad4;border-top:1px solid #189ad4; padding-top:8px; vertical-align: top;">:</td>
                    <td style="text-transform: capitalize;border-top:1px solid #189ad4; padding-top:8px; vertical-align: top;"><span style="">{{$patient->Patient->first_name}} {{$patient->Patient->last_name}}</span></td>
                    <td style="border-top:1px solid #189ad4; padding-top:8px; vertical-align: top;"><strong>Patient ID </strong><span> </span></td>
                    <td style="width: 40px; text-align:center; color: #189ad4;border-top:1px solid #189ad4; padding-top:8px; vertical-align: top;">:</td>
                    <td style="border-top:1px solid #189ad4; padding-top:8px; vertical-align: top;">{{@$patient->Patient->PatientRagistrationNumbers->reg_no}}</td>
                    </tr>

                    <tr>
                      <td style=" vertical-align: top;"><strong>Age/Gender </strong></td>
                      <td style="width: 40px; text-align:center; color: #189ad4; vertical-align: top;">:</td>
                      <td style="text-transform: capitalize; vertical-align: top;">{{get_patient_age($patient->Patient->dob)}}</td>
                      <td style=" vertical-align: top;"><strong>Contact No. </strong></td>
                      <td style="width: 40px; text-align:center; color: #189ad4; vertical-align: top;">:</td>
                      <td style=" vertical-align: top;">{{$patient->Patient->mobile_no}}</td>
                    </tr>

                    <tr>
                        <td style="border-bottom:1px solid #189ad4;padding-bottom:8px; vertical-align: top;"><strong>Date </strong></td>
                        <td style=" vertical-align: top;width: 40px;text-align:center;color: #189ad4;border-bottom:1px solid #189ad4;padding-bottom:8px;">:</td>
                            <td colspan="4" style="border-bottom:1px solid #189ad4;padding-bottom:8px; vertical-align: top;">{{date('Y-m-d',strtotime($patient->start))}}</td>
                    </tr>
                    </tbody>
                    </table>
                    </th>
                </tr>
        </thead>
    </table>
  </div>
   <div style="width:755px; clear:both;">

      @if(count($pVitals) > 0)
        <div class="vitalsCls" style="padding-top:3px; clear:both; margin-top:3px;">
          @if(count($pVitals) > 0)
          <div class="subjective-box" style="font-family:Arial, Helvetica, sans-serif;">
            <table style="width:100%; margin-top: 0px;background: #f1f1f1; padding: 5px; font-family:Arial, Helvetica, sans-serif;" class="table">

              <thead>
              <tr>
                 <th colspan="7"><h2 style="margin: 0px; padding: 0px;">
                  <strong style=" font-size:13.5px; font-weight: 700; color: #000; padding-bottom: 4px;">Vitals :</strong></h2></th>
                </tr>
              <tr>
				<th style="font-size: 13px;">Temprature</th>
				<th style="font-size: 13px;">Blood Presssure</th>
				<th style="font-size: 13px;">Pulse Rate</th>
				<th style="font-size: 13px;">Height</th>
				<th style="font-size: 13px;">Weight</th>
				<th style="font-size: 13px;">BMI</th>
				<th style="font-size: 13px;">Head Circumference</th>
				</tr>
              </thead>
              <tbody>
              <tr>
				  <td style="font-size: 13px;">{{$pVitals->temprature}} @if($pVitals->temprature !='') °C @endif</td>
				  <td style="font-size: 13px;">{{$pVitals->bp_systolic}}@if($pVitals->bp_systolic !='' || $pVitals->bp_diastolic !='') / @endif{{$pVitals->bp_diastolic}} @if($pVitals->bp_systolic !='') MmHg @endif</td>
				  <td style="font-size: 13px;">{{$pVitals->pulse_rate}} @if($pVitals->pulse_rate !='') /Min @endif</td>
				  <td style="font-size: 13px;">{{$pVitals->heightCm}} @if($pVitals->heightCm !='') CM @endif</td>
				  <td style="font-size: 13px;">{{$pVitals->weight}} @if($pVitals->weight !='') Kg @endif</td>
				  <td style="font-size: 13px;">@if($pVitals->heightCm !='' || $pVitals->weight !='') {{$pVitals->bmi}} @endif </td>
				  <td style="font-size: 13px;">{{$pVitals->head_circumference}} @if($pVitals->head_circumference !='') Cm @endif</td>
				</tr>
              </tbody>
            </table>
          </div>
          @endif
        </div>
        @endif


                 @if(count($chiefComplaints) > 0)
         <div class="chief" style="padding-top:10px; font-family:Arial, Helvetica, sans-serif; padding-bottom:10px; font-size:13.5px;width: 100%;clear:both;">
        <table cellpadding="0" cellspacing="0" style=" width:100%;">
          <tbody>
              <tr>
                  <td style=" width:150px" valign="top"><strong>Chief Complaint (s)</strong></td>
                    <td style=" width:50px; text-align:center; font-size:12px;" valign="top"> <strong>:</strong> </td>

                    <td style=" text-align:left; font-size:12px;">@if(count($chiefComplaints) > 0)
            <?php $coms = json_decode($chiefComplaints->data); ?>
            <?php  $names=[];$len = 0;?>
            <p style="padding: 0px; margin: 0px;">
            <?php
            foreach($coms as $com){
            $len += strlen($com->complaint_name);
            echo $com->complaint_name.",";
            if($len >38){
            $len = 0;
            echo "<br>";
            }
            }
            ?>
             @endif
            </td>

                </tr>
            </tbody>
        </table>
      </div>
              @endif

    @if(count($pDiagnos) > 0)
    <div style=" width:100%; padding-bottom:10px; text-align:left; clear:both;">
          <table cellpadding="0" cellspacing="0" style=" width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13.5px;">
              <tbody>
                  <tr>
                      <td style="width:150px" valign="top"><strong>Diagnosis</strong></td>
                        <td style=" width:50px; text-align:center; font-size:12px;" valign="top"> <strong>:</strong> </td>

                        <td style=" text-align:left; font-size:12px;">
                          @if(count($pDiagnos) > 0)
                          <div class="subjective-box" style="font-weight: 300; font-family:Arial, Helvetica, sans-serif; color: #2b2b2b; padding-left: 0px; padding-top: 0px;">
              @php $hasComma = false; @endphp
              @foreach ($pDiagnos as $diagno)
              @php if ($hasComma){  echo ",";  } @endphp
              <span style="padding: 0px; margin: 0px;"><b>  @if(!empty($diagno->diagnosis_eye)) {{$diagno->Diagnosis->shortDesc}} :@endif {{ucfirst($diagno->Diagnosis->shortDesc)}}</b>@if(!empty($diagno->notes)) ({{$diagno->notes}})@endif</span>
              @php $hasComma=true; @endphp
              @endforeach
            </div>@endif</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif




    @if(count($labs) > 0)
    <div style=" width:100%; font-family:Arial, Helvetica, sans-serif; padding-bottom:10px;font-size:13.5px; clear:both;">
          <table cellpadding="0" cellspacing="0" width="" style="font-family:Arial, Helvetica, sans-serif;">
              <tr>
                  <td style=" width:150px;" valign="top"><strong>Lab Order</strong></td>
                   <td style=" width:50px; text-align:center; font-size:12px;" valign="top"> <strong>:</strong> </td>

                    <td align="left" style=" font-size:12px;">@if(count($labs) > 0)<div class="subjective-box" style="font-family:Arial, Helvetica, sans-serif; font-weight: 300; color: #2b2b2b; padding-left: 0px; padding-top: 0px;">
            @php $hasComma = false; @endphp
            @foreach ($labs as $lab)
              @php if ($hasComma){  echo ",";  } @endphp
              <span style="padding: 0px; margin: 0px;"><b> {{$lab->Labs->title}} : </b>{{$lab->instructions}}</span>
              @php $hasComma=true; @endphp
            @endforeach
            </div>@endif</td>
                </tr>
            </table>
        </div>
@endif




       @if(count($patientDiagnosticImagings) > 0)
        <div style=" width:100%; font-family:Arial, Helvetica, sans-serif;padding-bottom:10px;font-size:13.5px; clear:both;">
          <table cellpadding="0" cellspacing="0" width="" style="font-family:Arial, Helvetica, sans-serif;">
              <tr>
                  <td style=" width:150px;" valign="top"><strong>Diagnostic Imaging</strong></td>
                    <td style=" width:50px; text-align:center; font-size:12px;" valign="top"> <strong>:</strong> </td>

                    <td style=" font-size:12px;"> @if(count($patientDiagnosticImagings) > 0)<div class="subjective-box" style="font-family:Arial, Helvetica, sans-serif; font-weight: 300; color: #2b2b2b; padding-left: 0px; padding-top: 0px;">
            @php $hasComma = false; @endphp
            @foreach ($patientDiagnosticImagings as $dim)
              @php if ($hasComma){  echo ",";  } @endphp
              <span style="padding: 0px; margin: 0px;"><b> {{$dim->RadiologyMaster->title}} : </b>{{$dim->instructions}}</span>
              @php $hasComma=true; @endphp
            @endforeach
            </div> @endif</td>
                </tr>
            </table>
        </div>
 @endif




      @if(count($procedures) > 0)
       <div style=" width:100%;padding-bottom:10px; clear:both;">
          <table cellpadding="0" cellspacing="0" width="" style="font-family:Arial, Helvetica, sans-serif; font-size:13.5px;">
              <tr>
                  <td style=" width:150px;" valign="top"><strong>Procedures</strong></td>
                    <td style=" width:50px; text-align:center; font-size:12px;" valign="top"> <strong>:</strong> </td>

                    <td style=" font-size:12px;"> @if(count($procedures) > 0)<div class="subjective-box" style="font-family:Arial, Helvetica, sans-serif; font-weight: 300; color: #2b2b2b; padding-left: 0px; padding-top: 0px;">
            @php $hasComma = false; @endphp
            @foreach ($procedures as $procedure)
              @php if ($hasComma){  echo ",";  } @endphp
              <span style="padding: 0px; margin: 0px;"><b> {{$procedure->Procedures->name}} : </b>{{$procedure->notes}}</span>
              @php $hasComma=true; @endphp
            @endforeach
            </div>  @endif</td>
                </tr>
            </table>
        </div>
      @endif



      @if(count($pAllergies) > 0)
     <div style=" width:100%; padding-bottom:0px; clear:both;">
          <table cellpadding="0" cellspacing="0" width="" style="font-family:Arial, Helvetica, sans-serif; font-size:13.5px;">
              <tr>
                  <td style=" width:150px;" valign="top"><strong>Allergies</strong></td>
                    <td style=" width:50px; text-align:center; font-size:12px;" valign="top"> <strong>:</strong> </td>

                    <td style=" font-size:12px;"> @if(count($pAllergies) > 0)
                     <?php  //print_r($pAllergies);die; ?><div class="subjective-box" style="font-family:Arial, Helvetica, sans-serif; font-weight: 300; color: #2b2b2b; padding-left: 0px; padding-top: 0px;">
          @php $hasComma = false; @endphp
          @foreach ($pAllergies as $pAllergy)
          @php if ($hasComma){  echo ",";  } @endphp
          <span style="padding: 0px; margin: 0px;"><b> {{$pAllergy->Allergies->title}}  </b>@if(!empty($pAllergy->notes)) :{{$pAllergy->notes}} @endif</span>
          @php $hasComma=true; @endphp
          @endforeach
          </div>@endif</td>
                </tr>
            </table>
        </div>
 @endif




     @if(count($treatments) > 0)
      <div style=" width:100%; padding-bottom:0px; clear:both;">
        <li style="padding: 0px; margin: 10px 0px 5px; list-style: none;">
          <strong style="font-size:15px; font-weight: 700; color: #000; ">R<sub>x</sub></strong>
        </li>
        @if(count($treatments) > 0)
          <?php $tretCount = 1 ?>
          <table style="width: 100%; font-family:Arial, Helvetica, sans-serif;" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th style="width: 50px;"></th>
                <th style="font-size: 12px;">Medicine Name</th>
                <th style="font-size: 12px;">Dose</th>
                <th style="font-size: 12px;">Frequency</th>
                <th style="font-size: 12px;">Duration</th>
                <th style="font-size: 12px;">Instructions</th>
              </tr>
            </thead>
          <tbody>
            @foreach ($treatments as $treatment)
              <tr>
                <td style="font-size: 12px; padding: 6px 0px 0px; vertical-align: top;">{{$tretCount}}</td>
                <td style="font-size: 12px; padding: 6px 0px 0px; vertical-align: top;"><strong>{{$treatment->ItemDetails->item_name}}</strong></td>
                <td style="font-size: 12px; padding: 6px 0px 0px; vertical-align: top;">@if(!empty($treatment->strength) && !empty($treatment->strength)) {{$treatment->strength}} {{$treatment->unit}} @else - @endif</td>
                <td style="font-size: 12px; padding: 6px 0px 0px; vertical-align: top;"><strong>@if(is_numeric($treatment->frequency)) {{$treatment->TreatmentFrequency->title}} {{getFreqDurType($treatment->frequency_type, 1)}} @else {{@$treatment->frequency}} @endif</strong></td>
                <td style="font-size: 12px; padding: 6px 0px 0px; vertical-align: top;">{{$treatment->duration}} @if(isset($treatment->duration_type)) {{getFreqDurType($treatment->duration_type, 2)}} @else Day @endif</td>
                <td style="font-size: 12px; padding: 6px 0px 0px; vertical-align: top;">@if(!empty($treatment->medi_instruc)) {{$treatment->TreatmentInstruction->title}} @else -  @endif</td>
              </tr>
              <tr>
                <th></th>
                <th colspan="5" style="font-size: 11px; font-weight: 400;">@if(!empty($treatment->ItemDetails->composition_name)) <i>Composition </i> :  {{@$treatment->ItemDetails->composition_name}} @endif</th>
              </tr>
              <tr>
                <th style="border-bottom: 1px solid #ccc; padding: 3px 0px 3px;"></th>
                <th colspan="5" style="font-size: 11px;border-bottom: 1px solid #ccc; padding: 3px 0px 3px; font-weight: 400;">@if(!empty($treatment->notes))<i><strong>Note</strong>: {{$treatment->notes}} </i>@endif</th>
              </tr>
              <?php $tretCount++; ?>
              @endforeach
            </tbody>
          </table>
        @endif
        </div>
      @endif
      @if(count($examinations) > 0)
        <div style=" width:100%; clear:both;">
          <table style="width: 100%; font-family:Arial, Helvetica, sans-serif; padding:10px 0 0px 0;" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
              <td style="font-size:13.5px; font-weight: 700; color: #000; width: 150px; vertical-align: top;">Clinical Examination </td>
              <td style="width:20px; text-align:center; vertical-align: top;font-size:12px;">:</td>
              <td style="font-size:12px; font-weight: 300; color: #2b2b2b;">
              @if(count($examinations) > 0)
              <div class="subjective-box" style="font-weight: 300; color: #2b2b2b; padding-left: 0px; padding-top: 0px;">
              @php $hasComma = false; @endphp
              @foreach ($examinations as $examination)
              @php if ($hasComma){  echo ",";  } @endphp
              <span style="padding: 0px; margin: 0px;"><b> {{$examination->BodySites->name}} : </b>{{$examination->observation}}</span>
              @php $hasComma=true; @endphp
              @endforeach
              </div>
              @endif
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      @endif

     <div style=" width:100%; clear:both;">
        <table style=" width:100%; font-family:Arial, Helvetica, sans-serif;" class="table" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td colspan="3" style="padding-bottom: 5px;">
                <li style="padding: 0px; margin: 10px 0px 0px; list-style: none;">
                <strong style="font-size:13.5px; font-weight: 700; color: #000;">Nutritional Information : </strong>
                </li>
              </td>
            </tr>
          @if(!empty($nutritional_info))
            @if(!empty($nutritional_info->eating_habits))
              <tr>
                <td style=" border:1px solid #bdbdbd; border-left: 1px solid #bdbdbd; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width: 250px;"><strong>Eating Habits</strong></td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width:40px;">:</td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 1px solid #bdbdbd; text-align:left; padding: 3px 4px; font-size:12px;">{{$nutritional_info->eating_habits}} (As Informed)</td>
              </tr>
            @endif
            @if(!empty($nutritional_info->medical_concern))
              <tr>
                <td style=" border:1px solid #bdbdbd; border-left: 1px solid #bdbdbd; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width: 250px;"><strong>Medical Concern</strong></td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width:40px;">:</td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 1px solid #bdbdbd; text-align:left; padding: 3px 4px; font-size:12px;">{{$nutritional_info->medical_concern}} (As Informed)</td>
              </tr>
            @endif
            @if(!empty($nutritional_info->disease_option))
              <tr>
                <td style=" border:1px solid #bdbdbd; border-left: 1px solid #bdbdbd; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width: 250px;"><strong>Disease </strong></td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width:40px;">:</td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 1px solid #bdbdbd; text-align:left; padding: 3px 4px; font-size:12px;"> @if(@$nutritional_info->disease_option == 'Yes') {{$nutritional_info->disease}} (As Informed) @else No (As Informed) @endif</td>
              </tr>
            @endif
            @if(!empty($nutritional_info->medical_treatment_option))
              <tr>
                <td style=" border:1px solid #bdbdbd; border-left: 1px solid #bdbdbd; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width: 250px;"><strong>Medical Treatment Undergoing</strong></td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width:40px;">:</td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 1px solid #bdbdbd; text-align:left; padding: 3px 4px; font-size:12px;"> @if(@$nutritional_info->medical_treatment_option == 'Yes') {{$nutritional_info->medical_treatment}} (As Informed) @else No (As Informed) @endif</td>
              </tr>
            @endif
            @if(!empty($nutritional_info->allergy))
              <tr>
                <td style=" border:1px solid #bdbdbd; border-left: 1px solid #bdbdbd; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width: 250px;"><strong>Allergy</strong></td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width:40px;">:</td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 1px solid #bdbdbd; text-align:left; padding: 3px 4px; font-size:12px;">{{$nutritional_info->allergy}} (As Informed)</td>
              </tr>
            @endif
            @if(!empty($nutritional_info->physical_activity))
              <tr>
                <td style=" border:1px solid #bdbdbd; border-left: 1px solid #bdbdbd; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width: 250px;"><strong>Physical Activity</strong></td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width:40px;">:</td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 1px solid #bdbdbd; text-align:left; padding: 3px 4px; font-size:12px;">{{$nutritional_info->physical_activity}} (As Informed)</td>
              </tr>
            @endif
            @if(!empty($nutritional_info->work_schedule_from))
              <tr>
                <td style=" border:1px solid #bdbdbd; border-left: 1px solid #bdbdbd; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width: 250px;"><strong>Work Schedule From </strong></td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width:40px;">:</td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 1px solid #bdbdbd; text-align:left; padding: 3px 4px; font-size:12px;">{{$nutritional_info->work_schedule_from}} (As Informed)</td>
              </tr>
            @endif
            @if(!empty($nutritional_info->life_style))
              <tr>
                <td style=" border:1px solid #bdbdbd; border-left: 1px solid #bdbdbd; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width: 250px;"><strong>Life Style</strong></td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width:40px;">:</td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 1px solid #bdbdbd; text-align:left; padding: 3px 4px; font-size:12px;">{{$nutritional_info->life_style}} (As Informed)</td>
              </tr>
            @endif
            @if(!empty($nutritional_info->body_type))
              <tr>
                <td style=" border:1px solid #bdbdbd; border-left: 1px solid #bdbdbd; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width: 250px;"><strong>Body Type</strong></td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width:40px;">:</td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 1px solid #bdbdbd; text-align:left; padding: 3px 4px; font-size:12px;">{{$nutritional_info->body_type}}</td>
              </tr>
            @endif
            @if(!empty($nutritional_info->energy_calories))
              <tr>
                <td style=" border:1px solid #bdbdbd; border-left: 1px solid #bdbdbd; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width: 250px;"><strong>Energy-calories/Day</strong></td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width:40px;">:</td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 1px solid #bdbdbd; text-align:left; padding: 3px 4px; font-size:12px;">{{$nutritional_info->energy_calories}}</td>
              </tr>
            @endif
            @if(!empty($nutritional_info->protein))
              <tr>
                <td style=" border:1px solid #bdbdbd; border-left: 1px solid #bdbdbd; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width: 250px;"><strong>Protien/Day</strong></td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width:40px;">:</td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 1px solid #bdbdbd; text-align:left; padding: 3px 4px; font-size:12px;">{{$nutritional_info->protein}}</td>
              </tr>
            @endif
            @if(!empty($nutritional_info->fat))
              <tr>
                <td style=" border:1px solid #bdbdbd; border-left: 1px solid #bdbdbd; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width: 250px;"><strong>Fat/Day</strong></td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width:40px;">:</td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 1px solid #bdbdbd; text-align:left; padding: 3px 4px; font-size:12px;">{{$nutritional_info->fat}}</td>
              </tr>
            @endif
            @if(!empty($nutritional_info->calcium))
              <tr>
                <td style=" border:1px solid #bdbdbd; border-left: 1px solid #bdbdbd; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width: 250px;"><strong>Calcium</strong></td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 0px; text-align:left; padding: 3px 4px; font-size:12px; width:40px;">:</td>
                <td style=" border:1px solid #bdbdbd; border-left: 0px; border-right: 1px solid #bdbdbd; text-align:left; padding: 3px 4px; font-size:12px;">{{$nutritional_info->calcium}}</td>
              </tr>
            @endif
          @endif
          </tbody>
        </table>
		</div>

      @if(count($diet_plan) > 0)
      <div style=" width:100%; clear: both; margin-top:10px;">
        @if(count($diet_plan) > 0)

         <li style="padding: 0px; margin: 0px 0px 6px 0; list-style: none;"><strong style=" font-size:13.5px; font-family:Arial, Helvetica, sans-serif; font-weight: 700; color: #000;">Diet Plan : </strong></li>

          <table width="100%" cellpadding="0" cellpadding="0" style="border: 1px solid #ccc; border-bottom:0px; font-family:Arial, Helvetica, sans-serif;">
            <tr>
              <th style="font-size:12px;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;padding: 0 4px; text-align:center;">S.No.</th>
              <th style="font-size:12px;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;padding: 0 4px;">Meal</th>
              <th style="font-size:12px;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;padding: 0 4px;">Diet (As Informed <br> By Patient)</th>
              <th style="font-size:12px;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;padding: 0 4px;">Menu (Change <br> Recommended)</th>
              <th style="font-size:12px;border-bottom: 1px solid #ccc;padding:0 4px;">Ingredient</th>
            </tr>
            <?php $i = 1 ?>
            @if(count($diet_plan)>0)
              @foreach($diet_plan as $plan)
              <tr>
                <td style="font-size:12px;border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;padding: 0 4px; text-align:center;"><strong>{{$i}}.</strong></td>
                <td style="font-size:12px;border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;padding: 0 4px;">{{@$plan->MealPlanMaster->title}}<br> @if(!empty($plan->meal_plan_time))  ({{date('h:i A',strtotime($plan->meal_plan_time))}}) @endif</td>
                <td style="font-size:12px;border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;padding: 0 4px;">{{@$plan->menu}}</td>
                <td style="font-size:12px;border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;padding: 0 4px;">{{@$plan->menu_exchange}}</td>
                <td style="font-size:12px;border-bottom: 1px solid #ccc;padding: 3px 4px;">{{@$plan->ingredient}}</td>
              </tr>
              <?php $i++ ?>
              @endforeach
            @endif
            </table>
        @endif
        </div>
      @endif


      @if(count($eyes) > 0)
		<div class="subjective-box" style=" font-weight: 300; color: #2b2b2b; margin-top: 6px; width:100%; clear:both;">
        <li style="padding: 0px; margin: 10px 0px 0px; list-style: none; font-family:Arial, Helvetica, sans-serif;">
        <strong style="font-size:13.5px; font-weight: 700; color: #000;">Eyes Examination :</strong>
        </li>
        
        @if(count($eyes) > 0)
        <table style=" width:100%; font-family:Arial, Helvetica, sans-serif;" class="table" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
        <th style="border-bottom: 0px; border-right:1px solid #bdbdbd;" colspan="2"></th>
        <th style="text-align: center; padding: 3px 0px 3px 3px; border:1px solid #bdbdbd;font-size:12px; vertical-align: top;">SPHERE</th>
        <th style="text-align: center; padding: 3px 0px 3px 3px; border:1px solid #bdbdbd;font-size:12px; vertical-align: top;">CYLINDER</th>
        <th style="text-align: center; padding: 3px 0px 3px 3px; border:1px solid #bdbdbd;font-size:12px; vertical-align: top;">AXIS</th>
        <th style="text-align: center; padding: 3px 0px 3px 3px; border:1px solid #bdbdbd;font-size:12px; vertical-align: top;">PRISM</th>
        <th style="text-align: center; padding: 3px 0px 3px 3px; border:1px solid #bdbdbd;font-size:12px; vertical-align: top;">BASE</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td style="border:1px solid #bdbdbd; text-align: center; padding-left: 0px; font-size:12px;" rowspan="2">DISTANCE</td>
        <td style="border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; border-top:1px solid #ccc; font-size:12px;">OD</td>
        <td style="border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; font-size:12px;">{{$eyes->d_od_s}}</td>
        <td style="border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; font-size:12px;">{{$eyes->d_od_c}}</td>
        <td style="border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; font-size:12px;">{{$eyes->d_od_a}}</td>
        <td style="border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; font-size:12px;">{{$eyes->d_od_p}}</td>
        <td style="border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; font-size:12px;">{{$eyes->d_od_b}}</td>
        </tr>
        <tr>
        <td style="border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; font-size:12px;">OS</td>
        <td style="border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; font-size:12px;">{{$eyes->d_os_s}}</td>
        <td style="border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; font-size:12px;">{{$eyes->d_os_c}}</td>
        <td style="border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; font-size:12px;">{{$eyes->d_os_a}}</td>
        <td style="border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; font-size:12px;">{{$eyes->d_os_p}}</td>
        <td style="border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; font-size:12px;">{{$eyes->d_os_b}}</td>
        </tr>
        <tr>
        <td style="border: 1px solid #bdbdbd;text-align: center; padding: 3px 4px;border-bottom:1px solid #bdbdbd; font-size:12px;" rowspan="2">ADD</td>
        <td style=" border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; font-size:12px;">OD</td>
        <td style=" border:1px solid #bdbdbd; text-align: center; padding: 3px 4px; font-size:12px;">{{$eyes->a_od_s}}</td>
        <td rowspan="2" colspan="4" style="border: 0px solid #fff; text-align: center; padding: 3px 4px;"></td>
        </tr>
        <tr>
        <td style="border:1px solid #bdbdbd;text-align: center; padding: 3px 4px; font-size:12px;">OS</td>
        <td style="border:1px solid #bdbdbd;text-align: center; padding: 3px 4px; font-size:12px;">{{$eyes->a_os_s}}</td>
        </tr>
        </tbody>
        </table>
        </div>
        @endif
       @endif


        @if(count($immunizations) > 0)
             <div style="width: 100%; clear: both; font-family:Arial, Helvetica, sans-serif;">

             <table style="width: 100%; padding-top: 10px;" cellpadding="0" cellspacing="0">
         <tbody>
       <tr>
       <td style="font-size:13.5px; font-weight: 700; color: #000; width: 150px; vertical-align: top;">Patient Immunizations </td>
         <td style="width:20px; text-align:center; vertical-align: top;font-size:12px;">:</td>
       <td style="font-size:12px; font-weight: 300; color: #2b2b2b;">
       @if(count($immunizations) > 0)
       <div class="subjective-box" style="font-weight: 300; color: #2b2b2b; padding-left: 0px; padding-top: 0px;">
             @php $hasComma = false; @endphp
       @foreach ($immunizations as $element)
             @php if ($hasComma){  echo ",";  } @endphp
       <span style="padding: 0px; margin: 0px;">@if(!empty($element->Immunizations->name)) <b>{{$element->Immunizations->name}} </b> : Dose {{@$element->dose_no}} @endif @if(!empty($element->given_date)) ({{$element->given_date}}) @endif</span>
             @php $hasComma=true; @endphp
       @endforeach
       </div>
       @endif
       </td>
             </tr>
             </tbody>
             </table>

             </div>
             @endif

      @if(count($proce_order) > 0)
      <div style="width: 100%; clear: both;">
        <table style="width: 100%; padding-top: 10px; font-family:Arial, Helvetica, sans-serif;" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
            <td style="font-size:13.5px; font-weight: 700; color: #000; width: 150px; vertical-align: top;">Procedure Orders </td>
            <td style="width:20px; text-align:center; vertical-align: top;font-size:12px;">:</td>
            <td style="font-size:12px; font-weight: 300; color: #2b2b2b;">
              @if(count($proce_order) > 0)
              <div class="subjective-box" style="font-weight: 300; color: #2b2b2b; padding-left: 0px; padding-top: 0px;">
                @php $hasComma = false; @endphp
                @foreach ($proce_order as $porder)
                @php if ($hasComma){  echo ",";  } @endphp
                <span style="padding: 0px; margin: 0px;"><b>{{$porder->Procedures->name}} : </b>{{$porder->notes}}</span>
                @php $hasComma=true; @endphp
                @endforeach
              </div>
              @endif
            </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif

      @if(count($dentals) > 0)
      <div style=" width:100%; clear:both;">
        <table style="width: 100%; font-family:Arial, Helvetica, sans-serif;" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td style="font-size:13.5px; font-weight: 700; color: #000; width: 150px; vertical-align: top;">Patient Dentals </td>
              <td style="width:20px; text-align:center; vertical-align: top;font-size:12px;">:</td>
              <td style="font-size:12px; font-weight: 300; color: #2b2b2b;">
              @if(count($dentals) > 0)
              <div class="subjective-box" style="font-weight: 300; color: #2b2b2b; padding-left: 0px; padding-top: 0px;">
                @php $hasComma = false; @endphp
                @foreach ($dentals as $dental)
                @php if ($hasComma){  echo ",";  } @endphp
                <span style="padding: 0px; margin: 0px;"><b>{{$dental->Procedures->name}} : </b>{{$dental->dental_id}}</span>
                @php $hasComma=true; @endphp
                @endforeach
              </div>
              @endif
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif

      @if(count($pReferral) > 0)
        <div style="width: 100%; clear: both;">
          <table style="width: 100%; padding-top: 10px; font-family:Arial, Helvetica, sans-serif;" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <td style="font-size:13.5px; font-weight: 700; color: #000; width: 150px; vertical-align: top;">Patient Referral</td>
                <td style="width:20px; text-align:center; vertical-align: top;font-size:12px;">:</td>
                <td style="font-size:12px; font-weight: 300; color: #2b2b2b;">
                  @if(count($pReferral) > 0)
                  <div class="subjective-box" style="font-weight: 300; color: #2b2b2b; padding-left: 0px; padding-top: 0px;">
                  <p style="padding: 0px; margin: 0px;">Referral to Dr. @if($pReferral->referral_to != 0) {{getRefdocDetails($pReferral->referral_to)->doctor_name}} @else {{$pReferral->referral_to_other}} @endif</p>
                  </div>
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      @endif
  <div style=" width:100%; clear:both;">

        @if(get_age($patient->Patient->dob) <= 20)
        <table style=" width:100%; padding-top: 10px; font-family:Arial, Helvetica, sans-serif;">
          <tbody>
            <tr>
              <td colspan="2">
                <li style="padding:0px; margin:0px; list-style: none;"><strong style="font-size:13.5px; font-weight: 700; color: #000;">Growth Chart : </strong></li></td>
            </tr>
            <tr>
              <td>
              @if(!empty($chart))
              <img src="{{$chart}}" width="300" height="150" style="">
              @endif
              </td>
              <td>
              @if(!empty($chart_height))
              <img src="{{$chart_height}}" width="300" height="150" style="">
              @endif
              </td>
            </tr>
          </tbody>
        </table>
        @endif
      </div>

    @if(count($physical_excercise) > 0)
        <div style="width:100%; clear:both; padding-top:0px;">
        <table cellpadding="0" cellspacing="0" style=" width:100%; font-family:Arial, Helvetica, sans-serif;">
          <tbody>

                 @foreach ($physical_excercise as $i=> $exc)

                <tr>
                  <td>
                    <h2 style=" margin:0px; padding:0px; font-size:13.5px; font-weight:600">Physical Exercise :</h2>
                    @if(count($physical_excercise) > 0)
          <div class="subjective-box" style="font-size:12px;">

            <?php $i++; ?>
            @if($i%2 == 0)
            <div style="padding: 5px 0; text-align:center;">
            @else
            <div style="padding:0; text-align:left; margin-top: 10px;">
            @endif
            <p style="padding: 0px 0px 10px; margin: 0px;"><strong>@if(!empty($exc->PhysicalExcerciseMaster->name)){{$exc->PhysicalExcerciseMaster->name}}@endif</strong>:<br> @if(!empty($exc->instructions)){{$exc->instructions}}@endif
</p>

            <!---
			@if(!empty(@$exc->PhysicalExcerciseMaster->file))
            <img style="width:100%; height:400px;" src="<?php echo url("/")."/public/uploads/excercise-file/".$exc->PhysicalExcerciseMaster->file; ?>" />
            @else
            Not Available
            @endif
			--->

            </div>
            </div>

          </div>
        @endif

        </td>
                </tr>
                @endforeach

            </tbody>
        </table>
        </div>
         @endif

        @if(count($dietitian_template) > 0)
        <div style=" width:100%; padding-top:10px; clear:both;">
         <!-- <strong >Template: </strong>-->
          @if(count($dietitian_template) > 0)
          <div>
            @foreach ($dietitian_template as $temp)
            <p style=" font-size:13.5px;">@if(strpos($temp->dietitian_temp_id, ',') == false && !empty($temp->dietitian_temp_id))<strong> {{$temp->DietitianReportTemplate->title}}</strong>:@endif</p>
            @endforeach
          </div>
          @endif
            <p style=" font-size:12px;"> @if(!empty($temp->instructions)){!!$temp->instructions!!}@endif</p>
        </div>
      @endif
        @if(count($followUp) > 0)
          <div style="width: 100%; clear:both; padding-top: 10px;">
          <table cellpadding="0" cellspacing="0" style=" font-family:Arial, Helvetica, sans-serif; font-size:13.5px; font-weight:600">
            <tbody>
            <tr>
              <td style="">Follow up date</td>
              <td style=" width:100px; font-size:12px;">:</td>
              <td style=" font-size:12px;">
                @if(count($followUp) > 0)
                @if($followUp->follow_up_date != "") {{$followUp->follow_up_date}} @endif
                @endif
              </td>
            </tr>
            <tr>
            	<td colspan="3" style="height:50px;"></td>
            </tr>
            </tbody>
          </table>

          </div>
        @endif

        </div>

     <div style=" width:755px;left:0px; right:0px; margin: 0 auto;  z-index: 99999; position:absolute;bottom:-30px; margin-left:0px;" class="authority-signature">
         <table style=" font-family:Arial, Helvetica, sans-serif; width:100%;">
          <tbody>
          <tr>
              <td style="font-size:14px; font-weight: 700; color: #189ad4; padding-top:0px; margin-right: 0px; margin-left: 0px;text-align:right; border-bottom: 1px solid #189ad4;">
              @if($patient->User->DoctorInfo->sign_view == 1)
              <span style="width:100%; text-align:right; right: 0px; float: right;">
                <img class="sign_image" style="width:120px; height:70px; background-color: #fff; color:#000;" src="<?php
					$image_res = getEhrUrl()."/public/doctor/signature/".$patient->User->DoctorInfo->doctor_sign;
					if(!empty($patient->User->DoctorInfo->doctor_sign)) {
							echo $image_res;
					}?>"/>
              </span>
              @endif
              <p style="margin:0px;">(Authority Signature)</p>
              </td>
          </tr>
          <tr><td style=" font-size:11px; padding: 0px; vertical-align: top;">Powered By Healthgennie</td></tr>
          </tbody>
          </table>
          </div>

</body>
</html>
