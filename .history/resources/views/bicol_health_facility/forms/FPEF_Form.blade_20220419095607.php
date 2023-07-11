
<body>
	<br>
<table style="border-width: .2px .2px .2px .2px !important" width="100%" cellpadding="3">
<tr>
	<th width="100%" style="position:relative !important">

	<table border="0.0" width="100%" cellpadding="0">
		<tr><th width="100%"></th></tr>
		<tr>
			<th width="1%"></th>
			<th width="12%" style="text-align: left; position:relative !important">&nbsp;&nbsp;<img src="{{ public_path('img/BHF.jpg') }}" alt="Logo" width="50" height="50" class="logo"/></th>
			<th width="76%" style="text-align: left; font-size: 10px !important"><b><br>BICOL TRUE VALUE DIAGNOSTIC FACILITY, INC<br>First Patient Encounter Form (FPEF)</b></th>
			<th width="10%" style="float: right; font-size: 10px !important"><img border="0.1" src="{{ public_path('img/avatar.jpg') }}" alt="Logo" width="50" height="50" class="logo"/></th>
			<th width="1%"></th>
		</tr>
		<tr><th width="100%"></th></tr>
    <table style="border-width: 1px 1px 1px 1px !important" width="100%" cellpadding="0.5" >
		<tr><td style="font-size: 8px; font-style: italic; background-color: orange; color:rgb(255, 255, 255) !important;"> &nbsp;<b> Personal Information</b></td></tr>
	</table>
	<tr><th width="100%"></th></tr>
	<tr>
		<th width="25%" style="text-align: left; font-size: 8px !important">&nbsp;Philhealth ID: <b>{{ $info->philhealth_id }}</b></th>
		<th width="25%" style="text-align: left; font-size: 8px !important">Client Type: <b>{{ $info->client_type }}</b></th>
		<th width="30%" style="text-align: left; font-size: 8px !important">Membership Category: <b>{{ $info->membership_category }}</b></th>
		<th width="20%" style="text-align: left; font-size: 8px !important">Date of registration: <<b>{{ date('M d, Y', strtotime($info->created_at)) }} - {{ $age }}</b></th>
	</tr>
	<tr><th width="100%"></th></tr>
	<tr>
		<th width="25%" style="text-align: left; font-size: 8px !important">&nbsp;Last Name: <b>{{ $info->last_name }}</b></th>
		<th width="25%" style="text-align: left; font-size: 8px !important">First Name: <b>{{ $info->first_name }}</b></th>
		<th width="25%" style="text-align: left; font-size: 8px !important">Middle Name: <b>{{ $info->middle_name }}</b></th>
		<th width="25%" style="text-align: left; font-size: 8px !important">Extension: <b>{{ $info->extension }}</b></th>
	</tr>
	<tr>
		<th width="25%" style="text-align: left; font-size: 8px !important">&nbsp;Date of Birth: <b>{{ date('M d, Y', strtotime($info->date_of_birth)) }} - {{ $age }}</b></th>
		<th width="25%" style="text-align: left; font-size: 8px !important">Gender: <b>{{ $info->gender }}</b></th>
		<th width="25%" style="text-align: left; font-size: 8px !important">Email: <b>{{ $info->email }}</b></th>
		<th width="25%" style="text-align: left; font-size: 8px !important">Contact No.: <b>{{ $info->contact_number }}</b></th>
	</tr>
	<tr>
		<th width="100%" style="text-align: left; font-size: 8px !important">&nbsp;Home Address: <b>{{ $info->home_address }}</b></th>
	</tr>
	<tr><th width="100%"></th></tr>
	<table style="border-width: 1px 1px 1px 1px !important" width="100%" cellpadding="0.5" >
		<tr><td style="font-size: 8px; font-style: italic; background-color: orange; color:rgb(255, 255, 255) !important;"> &nbsp;<b> Past Medical History</b></td></tr>
     </table>
	 <tr><th width="100%"></th></tr>
	 <tr>
		<th width="100%" style="text-align: left; font-size: 9px !important">&nbsp;<b>Previous Illnesses</b></th>
	</tr>

	@if($info->previous_illnesses_array != null)
	@foreach($info->previous_illnesses_array as $a)
	<tr>
		<th width="100%" style="text-align: left; font-size: 9px !important">&nbsp; {{ $a->previous_illnesses_name }}</th>
	</tr>
	@endforeach
	@else
	<tr>
		<th width="100%" style="text-align: left; font-size: 9px !important">&nbsp; N/A</th>
	</tr>
	@endif

	
	<tr><th width="100%"></th></tr>
	<tr>
		<th width="100%" style="text-align: left; font-size: 9px !important">&nbsp;<b>Hospitalizations:</b></th>
	</tr>
	 <table border="0" width="100%" cellpadding="5">
		
		<tr>
			<th width="30%" style="border-left-width: 0.1px; border-right-width: 0.1px; border-top-width: 0.1px; border-bottom-width: 0.1px; text-align: center; font-size: 8px !important"><b>HOSPITAL</b></th>
			<th width="20%" style="border-left-width: 0.1px; border-right-width: 0.1px; border-top-width: 0.1px; border-bottom-width: 0.1px;text-align: center; font-size: 8px !important"><b>DATE</b></th>
			<th width="50%" style="border-left-width: 0.1px; border-right-width: 0.1px; border-top-width: 0.1px; border-bottom-width: 0.1px;text-align: center; font-size: 8px !important"><b>REASON</b></th>
		</tr>
		@foreach(json_decode($info->hospitalization) as $a)
		<tr>
			<th width="30%" style="border-left-width: 0.1px; border-right-width: 0.1px; border-top-width: 0.1px; border-bottom-width: 0.1px; text-align: center; font-size: 8px !important"><br><br>{{ $a->hospital }}<br></th>
			<th width="20%" style="border-left-width: 0.1px; border-right-width: 0.1px; border-top-width: 0.1px; border-bottom-width: 0.1px; text-align: center; font-size: 8px !important"><br><br>{{ date('M d, Y', strtotime($a->date)) }}<br></th>
			<th width="50%" style="border-left-width: 0.1px; border-right-width: 0.1px; border-top-width: 0.1px; border-bottom-width: 0.1px; text-align: center; font-size: 8px !important"><br><br>{{ $a->reason }}<br></th>
		</tr>
		@endforeach
	</table>
	<tr><th width="100%"></th></tr>

	 <table style="border-width: 1px 1px 1px 1px !important" width="100%" cellpadding="0.5" >
		<tr><td style="font-size: 8px; font-style: italic; background-color: orange; color:rgb(255, 255, 255) !important;"> &nbsp;<b> Family History</b></td></tr>
     </table>
	 <tr><th width="100%"></th></tr>
	 <tr>
		<th width="18%" style="text-align: left; font-size: 9px !important">&nbsp;<b>Father's Family</b></th>
		<th width="18%" style="text-align: left; font-size: 9px !important">&nbsp;<b>Mothers's Family</b></th>
	</tr>	
	<tr>
		<td width="18%" style="text-align: left; font-size: 9px !important">

	@if($info->family_history_father_array != null)
	@foreach($info->family_history_father_array as $a)
	&nbsp;{{ $a->family_history_name }}<br>
	@endforeach
	@else
	&nbsp;N/A<br>
	@endif

		</td>
		<td width="18%" style="text-align: left; font-size: 9px !important">

	@if($info->family_history_mother_array != null)
	@foreach($info->family_history_mother_array as $a)
	&nbsp;{{ $a->family_history_name }}<br>
	@endforeach
	@else
	&nbsp;N/A<br>
	@endif
			</td>
	</tr>

	 <table style="border-width: 1px 1px 1px 1px !important" width="100%" cellpadding="0.5" >
		<tr><td style="font-size: 8px; font-style: italic; background-color: orange; color:rgb(255, 255, 255) !important;"> &nbsp;<b> Personal and Soccial History</b></td></tr>
     </table>
	 <tr><th width="100%"></th></tr>
	 <tr>
		<th width="25%" style="text-align: left; font-size: 9px !important">&nbsp;<b>Lifestyle Information</b></th>
		<th width="25%" style="text-align: left; font-size: 9px !important">&nbsp;<b>Present Illnesses</b></th>
		<th width="25%" style="text-align: left; font-size: 9px !important">&nbsp;<b>Immunization</b></th>
	</tr>

	<tr>
		<td width="25%" style="text-align: left; font-size: 9px !important">
			
			@if($info->lifestyle_info_array != null)
			@foreach($info->lifestyle_info_array as $a)
			&nbsp;{{ $a->lifestyle_info_name }}<br>
			@endforeach
			@else
			&nbsp;N/A<br>
			@endif

		</td>
		<td width="25%" style="text-align: left; font-size: 9px !important">	

			@if($info->present_illnesses_array != null)
			@foreach($info->present_illnesses_array as $a)
			&nbsp;{{ $a->present_illnesses_name }}<br>
			@endforeach
			@else
			&nbsp;N/A<br>
			@endif

		</td>
		<td width="25%" style="text-align: left; font-size: 9px !important">	
			
			@if($info->immunization_history_array != null)
			@foreach($info->immunization_history_array as $a)
			&nbsp;{{ $a->immunization_history_name }}<br>
			@endforeach
			@else
			&nbsp;N/A<br>
			@endif
			
	</td>
	</tr>

	 <tr><th width="100%"></th></tr>
	 <tr>
		<th width="48%" style="text-align: left; font-size: 9px !important">&nbsp;<b>Maintenance Medication:</b></th>
		<th width="4%" style="text-align: left; font-size: 9px !important"></th>
		<th width="48%" style="text-align: left; font-size: 9px !important">&nbsp;<b>Note:</b></th>
	</tr>

	<tr>
		<th width="48%" style="text-align: left; font-size: 9px !important">&nbsp;{{ $info->maintenance_medication }}</th>
		<th width="4%" style="text-align: left; font-size: 9px !important"></th>
		<th width="48%" style="text-align: left; font-size: 9px !important">&nbsp;{{ $info->note }}</th>
	</tr>

	<tr><th width="100%"></th></tr>

	 <table style="border-width: 1px 1px 1px 1px !important" width="100%" cellpadding="0.5" >
		<tr><td style="font-size: 8px; font-style: italic; background-color: orange; color:rgb(255, 255, 255) !important;"> &nbsp;<b> PhilHealth Details:</b></td></tr>
     </table>
	 <tr><th width="100%"></th></tr>
	 <tr>
		<th width="18%" style="text-align: left; font-size: 9px !important">&nbsp;<b>Registration Number:</b></th>
		<th width="18%" style="text-align: left; font-size: 9px !important">&nbsp;<b>ATC Number:</b></th>
	</tr>	
	<tr>
		<td width="18%" style="text-align: left; font-size: 9px !important">

	@if($info->registration_no != null)
	&nbsp;{{ $a->registration_no }}<br>
	@else
	&nbsp;N/A<br>
	@endif

		</td>
		<td width="18%" style="text-align: left; font-size: 9px !important">

	@if($info->atc_no != null)
	&nbsp;{{ $a->atc_no }}<br>
	@else
	&nbsp;N/A<br>
	@endif
			</td>
	</tr>


	<tr><th width="100%"></th></tr>
	<tr><td width="100%" style="font-size: 8px !important;">_______________________________________________________________________________________________________________________________</td></tr>
	<tr><th width="100%"></th></tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; Under the penalty of law, I attest that the information I provided in this form are true and accurate.</td>
	</tr>
	<tr>
		<td style="font-size: 8px !important;">&nbsp; (Sa ilalim ng batas, pinatutunayan ko na ang impormasyong ibinigay ko ay totoo at tama)</td>
	</tr>

	<tr><th width="100%"></th></tr><tr><th width="100%"></th></tr><tr><th width="100%"></th></tr>
	<tr>
		<td width="50%" style="font-size: 8px !important;">&nbsp; ___________________________________</td>
	</tr>
	<tr>
		<td width="50%" style="font-size: 8px !important;">&nbsp; Signature over printed name of patient</td>
	</tr>
	<tr>
		<td style="font-style: italic; font-size: 8px !important;">&nbsp; (Lagda sa nakalimbag na pangalan ng pasyente)</td>
	</tr>
	<tr><th width="100%"></th></tr><tr><th width="100%"></th></tr>
</table>
</th>
</tr>
</table>
</body>