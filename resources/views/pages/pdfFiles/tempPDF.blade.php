<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Weight Management</title>

  </head>
  <body style="font-family: 'Open Sans', sans-serif !important;">
  	<table cellpadding="0" cellspacing="0" style="width: 730px; border: 0px;">
  		<thead>
  			<tr>
  				<th colspan="3" style="color: #000; font-size:15px; padding-bottom: 20px;border-bottom: 2px solid #ccc; border-left: 0px; border-right: 0px;"><img style="width:80px;" src="{{ URL::asset('img/logo-section-top.png') }}" /></th>
  			</tr>
  			<tr>
  				<th colspan="3" style="color: #000; font-size:20px; padding-bottom: 10px;"></th>
  			</tr>
  			<tr>
  								<td colspan="3" style="text-align:center; color: #189ad4; font-size:24px; padding: 5px 10px;">Temprature Details </td>
  							</tr>
  							<tr>
  								<td style="border: 1px solid #ccc; font-size: 16px; color: #000; padding: 5px 10px;">Temprature</td>
  								<td style="border: 1px solid #ccc; font-size: 16px; color: #333; padding: 5px 10px;">Date</td>
  								<td style="border: 1px solid #ccc; font-size: 16px; color: #333; padding: 5px 10px;">Time</td>
  							</tr>
  		</thead>
  		<tbody>
  							
							@if(count($temp)>0)
								@foreach($temp as $raw)
									<tr>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #333; padding: 5px 10px;">{{$raw->temp}}  @if($raw->temp_type == '2') (°c) @else (F) @endif</td>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #333; padding: 5px 10px;">{{date('d-m-Y',strtotime($raw->date))}}</td>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #333; padding: 5px 10px;">{{date('g:i A',strtotime($raw->time))}}</td>
									</tr>
								@endforeach
							@endif		
  						</tbody>

  	</table>
  </body>
</html>