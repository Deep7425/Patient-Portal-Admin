<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Weight Management</title>
<style>
	@font-face {
	  font-family: 'k010';
		 font-style: normal;
		 src: url('{{ URL::asset('fonts/k010/k010.eot') }}');
		  src: local('k010'), url('{{ URL::asset('fonts/k010/k010.woff') }}') format('woff'), url('{{ URL::asset('fonts/k010/k010.ttf') }}') format('truetype');
	  }
	  .hindifont{
		font-family: k010 !important;
		font-size: 15px!important;
	  }
	</style>
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
  								<td colspan="4" style="text-align:center; color: #189ad4; font-size:34px; padding: 5px 10px;" class="hindifont">otu fooj.k </td>
  							</tr>
  							<tr>
  								<td style="border: 1px solid #ccc; font-size: 16px;color: #189ad4; padding: 5px 10px;" class="hindifont">fnukad le;</td>
  								<td style="border: 1px solid #ccc; font-size: 16px;color: #189ad4; padding: 5px 10px;" class="hindifont">dn</td>
  								<td style="border: 1px solid #ccc; font-size: 16px;color: #189ad4; padding: 5px 10px;" class="hindifont">otu</td>
  								<td style="border: 1px solid #ccc; font-size: 16px;color: #189ad4; padding: 5px 10px;" class="hindifont">ch,evkbZ</td>
  							</tr>
							@if(count($weight)>0)
								@foreach($weight as $raw)
									<tr>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #000; padding: 5px 10px;">{{date('d-m-Y',strtotime($raw->date))}} {{date('g:i A',strtotime($raw->time))}}</td>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #333; padding: 5px 10px;">{{$raw->weight}}</td>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #333; padding: 5px 10px;">{{$raw->weight}}</td>
										<td style="border: 1px solid #ccc; font-size: 14px; color: #333; padding: 5px 10px;">{{$raw->bmi}}</td>
									</tr>
								@endforeach
							@endif		


  		</tbody>
  	</table>
  </body>
</html>