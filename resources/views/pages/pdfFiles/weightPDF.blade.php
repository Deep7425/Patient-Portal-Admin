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
  				<th colspan="4" style="color: #000; font-size:15px; padding-bottom: 20px; border-bottom: 2px solid #ccc;"><img style="width:80px;" src="{{ URL::asset('img/logo-section-top.png') }}" /></th>
  			</tr>
  			<tr>
  				<th colspan="4" style="color: #000; font-size:20px; padding-bottom: 10px;"></th>
  			</tr>
  		</thead>
  		<tbody>
  			
  							<tr>
  								<td colspan="4" style="text-align:center; color: #189ad4; font-size:24px; padding: 5px 10px;">Weight Details </td>
  							</tr>
  							<tr>
  								<td style="border: 1px solid #ccc; font-size: 16px; color: #189ad4; padding: 5px 10px;">Date/Time</td>
  								<td style="border: 1px solid #ccc; font-size: 16px; color: #189ad4; padding: 5px 10px;">Height</td>
  								<td style="border: 1px solid #ccc; font-size: 16px; color: #189ad4; padding: 5px 10px;">Weight</td>
  								<td style="border: 1px solid #ccc; font-size: 16px; color: #189ad4; padding: 5px 10px;">BMI</td>
  							</tr>
							@if(count($weight)>0)
								@foreach($weight as $raw)
									<tr>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #000; padding: 5px 10px;">{{date('d-m-Y',strtotime($raw->date))}} {{date('g:i A',strtotime($raw->time))}}</td>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #333; padding: 5px 10px;">{{$raw->height}}</td>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #333; padding: 5px 10px;">{{$raw->weight}}</td>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #333; padding: 5px 10px;">{{$raw->bmi}}</td>
									</tr>
								@endforeach
							@endif		
  					
  		</tbody>
  	</table>
  </body>
</html>