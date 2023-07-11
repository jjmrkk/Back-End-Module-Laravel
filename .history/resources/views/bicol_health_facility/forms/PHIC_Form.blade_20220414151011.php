<body>
	<br>
<table style="border-width: .2px .2px .2px .2px !important" width="100%" cellpadding="0">
<tr>
	<th width="50%" style="position:relative !important">

	<table border="0.0" width="100%" cellpadding="0">
		<tr><th width="100%"></th></tr>
		<tr>
			<th width="18%" style="text-align: left; position:relative !important">&nbsp;&nbsp;<img src="{{ public_path('img/philhealth.jpg') }}" alt="Logo" width="40" height="40" class="logo"/></th>
			<th width="87%" style="text-align: left; font-size: 10px !important"><b>Philhealth Konsulta Registration Form</b></th>
		</tr>
	
       <table style="border-width: 1px 1px 1px 1px !important" width="100%" cellpadding="0.5" >
				<tr><td style="font-size: 8px; font-style: italic; background-color: orange; color:rgb(255, 255, 255) !important;"> &nbsp; <b> To be filled-out by the beneficiary</b></td></tr>
	   </table>
	<tr><th width="100%"></th></tr>
	<tr><th width="100%" style="text-align: center; position:relative !important"><b>PhilHealth's Copy</b></th></tr>
	<tr><th width="100%"></th></tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; Name:<b>{{ $info->last_name }}, {{ $info->first_name }} {{ $info->middle_name }}</b></td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; PIN:<b>{{ $info->philhealth_id }}</b></td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; Client Type: <b>{{ $info->client_type }}</b></td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; Contact No.: 	
	@if($info->contact_number != null)
	<b>{{ $info->contact_number }}</b></td>
	@else
	&nbsp;N/A<br>
	@endif
	
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; Email: <b>{{ $info->philhealth_id }}</b></td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; Name of previous PhilHwalth Konsulta Facility: ______________________</td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; Preferred PhilHealth Konsulta Facility and Address </td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; (Municipality/Town/City/Province):</td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; 1st Choice: ______________________</td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; 2nd Choice: ______________________</td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; 3rd Choice: ______________________</td>
	</tr>
	<tr><th width="100%"></th></tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp;&nbsp;________________________</td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp;(Signature over printed name)</td>
	</tr>

	<tr><th width="100%"></th></tr>
	</table>
</th>


<th width="50%" style="position:relative !important">
<table style="border-width: .2px .2px .2px .2px !important" width="100%" cellpadding="0">
		<tr><th width="100%"></th></tr>
		<tr>
			<th width="18%" style="text-align: left; position:relative !important">&nbsp;&nbsp;<img src="{{ public_path('img/philhealth.jpg') }}" alt="Logo" width="40" height="40" class="logo"/></th>
			<th width="87%" style="text-align: left; font-size: 10px !important"><b>Philhealth Konsulta Registration <br>Confirmation Slip</b></th>
		</tr>
       <table style="border-width: 1px 1px 1px 1px !important" width="100%" cellpadding="0.5" >
				<tr><td style="font-size: 8px; font-style: italic; background-color: orange; color:rgb(255, 255, 255) !important;"> &nbsp; <b>To be filled-out by the Authorized personel </b></td></tr>
	   </table>
	   <tr><th width="100%"></th></tr>
	   <tr><th width="100%" style="text-align: center; position:relative !important"><b>Beneficiary's Copy</b></th></tr>
	   <tr><th width="100%"></th></tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; Registration No.: ______________________</td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; Date Registered: ______________________</td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; Name: ______________________</td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; PIN: ______________________</td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; PhilHealth Konsulta Facility: ______________________</td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp;PhilHealth Konsulta Facility Address: ______________________</td>
	</tr>
	<tr><th width="100%"></th></tr><tr><th width="100%"></th></tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp;&nbsp;________________________</td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp;(Signature over printed name of Authorized Personel)</td>
	</tr>
	<tr><td style="font-size: 8px !important;"></td></tr>
	<tr><td style="font-size: 8px !important;"></td></tr>
	<tr><td style="font-size: 8px !important;"></td></tr>
	<tr><td style="font-size: 8px !important;"></td></tr>
	<tr><td style="font-size: 8px !important;"></td></tr>
	<tr><td style="font-size: 8px !important;"></td></tr>
	</table>
</th>
</tr>

<table style="border-width: .2px .2px .2px .2px !important" width="100%" cellpadding="0">
	<tr><th width="100%">&nbsp;Instruction:</th></tr>
	<tr><th width="100%">&nbsp;1. All information should be written in UPPERCASE/CAPITAL LETTERS.</th></tr>
	<tr><th width="100%">&nbsp;2. All fields are mandatory.</th></tr>
	<tr><th width="100%">&nbsp;3. If the beneficiary is dependent, use the dependent PIN.</th></tr>
	<tr><th width="100%">&nbsp;4. If the beneficiary is below 21 Years old, the signatory should be the parent/guardian.</th></tr>
</table>

</body>