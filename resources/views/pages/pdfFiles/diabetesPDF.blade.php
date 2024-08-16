<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Weight Management</title>

  </head>
  <body style="font-family: 'Open Sans', sans-serif !important;">
  	<table cellpadding="0" cellspacing="0" style="width: 730px;">
  		<thead>
  			<tr>
  				<th colspan="5" style="color: #000; font-size:15px; padding-bottom: 20px; border-bottom: 2px solid #ccc;"><img style="width:80px;" src="{{ URL::asset('img/logo-section-top.png') }}" /></th>
  			</tr>
  			<tr>
  				<th colspan="5" style="color: #000; font-size:20px; padding-bottom: 10px;"></th>
  			</tr>
  		</thead>
  		<tbody>
  			
  							<tr>
  								<td colspan="5" style="text-align:center; color: #189ad4; font-size:24px; padding: 5px 10px;">Sugar Details </td>
  							</tr>
  							<tr>
  								<td style="border: 1px solid #ccc; font-size: 16px; color: #189ad4; padding: 5px 10px;">Sugar Level</td>
  								<td style="border: 1px solid #ccc; font-size: 16px; color: #189ad4; padding: 5px 10px;">Test Done At</td>
  								<td style="border: 1px solid #ccc; font-size: 16px; color: #189ad4; padding: 5px 10px;">Date</td>
  								<td style="border: 1px solid #ccc; font-size: 16px; color: #189ad4; padding: 5px 10px;">Time</td>
  								<td style="border: 1px solid #ccc; font-size: 16px; color: #189ad4; padding: 5px 10px;">Note</td>
  							</tr>
							@if(count($diabetes)>0)
								@foreach($diabetes as $raw)
									<tr>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #333; padding: 5px 10px;">{{$raw->sugar_level}} mmol/L</td>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #000; padding: 5px 10px;">@if($lng == 'hi') {{getTestNameByIdHin($raw->test_id)}} @else {{getTestNameByIdEng($raw->test_id)}} @endif </td>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #333; padding: 5px 10px;">{{date('d-m-Y',strtotime($raw->date))}}</td>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #333; padding: 5px 10px;">{{date('g:i A',strtotime($raw->time))}}</td>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #000; padding: 5px 10px;">{{$raw->notes}}</td>
									</tr>
								@endforeach
							@endif		
  						
  		</tbody>
  	</table>
  </body>
</html>