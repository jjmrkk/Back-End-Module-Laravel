
<body>
	<br>
<table style="border-width: .2px .2px .2px .2px !important" width="100%" cellpadding="3">
<tr>
	<th width="100%" style="position:relative !important">

		<table border="0.0" width="100%" cellpadding="0">
				<tr><th width="100%"></th></tr>
				<tr>
						<th width="1%"></th>
						<th width="14%" style="text-align: left; position:relative !important">&nbsp;&nbsp;<img src="{{ public_path('img/mss_logo.png') }}" alt="Logo" width="70" height="70" class="logo"/></th>
						<th width="74%" style="text-align: left; font-size: 10px !important"><b><br><br>Metropolis Security System Pte Ltd<br>Visitor Information</b></th>
						<th width="10%" style="float: right; font-size: 10px !important"><img border="0.1" src="{{ public_path('img/avatar.jpg') }}" alt="Logo" width="80" height="80" class="logo"/></th>
						<th width="1%"></th>
				</tr>
				<tr><th width="100%"></th></tr>

				<table style="border-width: 1px 1px 1px 1px !important" width="100%" cellpadding="0.5" >
					<tr><td style="font-size: 8px; font-style: italic; background-color: orange; color:rgb(255, 255, 255) !important;"> &nbsp;<b> Personal Information</b></td></tr>
				</table>
				<tr><th width="100%"></th></tr>
				<tr>
					<th width="25%" style="text-align: left; font-size: 8px !important">&nbsp;Vistor ID No.: <b>{{ $Record_list->visitor_id_no }}</b></th>
					<th width="25%" style="text-align: left; font-size: 8px !important">Visit Type: <b>{{ $Record_list->visit_type }}</b></th>
					<th width="25%" style="text-align: left; font-size: 8px !important"> <b></b></th>
					<th width="25%" style="text-align: left; font-size: 8px !important">Date registered: <b>{{ $Record_list->check_in }}</b></th>
				</tr>
				<tr><th width="100%"></th></tr>
				<tr>
					<th width="25%" style="text-align: left; font-size: 8px !important">&nbsp;Name: <b>{{ $Record_list->name }}</b></th>
					<th width="25%" style="text-align: left; font-size: 8px !important">Gender: <b></b>{{ $Record_list->gender }}</th>
					<th width="25%" style="text-align: left; font-size: 8px !important">Contact Number: <b></b>{{ $Record_list->contact_no }}</th>
					<th width="25%" style="text-align: left; font-size: 8px !important"><b></b></th>
				</tr>
				<br>
				<tr>
				    <th width="1%" style="text-align: left; font-size: 8px !important"></th>
					<th width="44%" style="text-align: left; font-size: 8px !important">&nbsp;Purpose of Visit: <b>{{ $Record_list->purpose_of_visit }}</b></th>
					<th width="10%" style="text-align: left; font-size: 8px !important"></th>
					<th width="40%" style="text-align: left; font-size: 8px !important">Note: <b>{{ $Record_list->note }}</b></th>
					<th width="5%" style="text-align: left; font-size: 8px !important"></th>
				</tr>
				<tr><th width="100%"></th></tr>
				<table style="border-width: 1px 1px 1px 1px !important" width="100%" cellpadding="0.5" >
					<tr><td style="font-size: 8px; font-style: italic; background-color: orange; color:rgb(255, 255, 255) !important;"> &nbsp;<b>Check IN/OUT Details</b></td></tr>
		      </table>
			 
				<tr>
				<br>
					<th width="100%" style="text-align: left; font-size: 8px !important">&nbsp;Check In: <b>{{ $Record_list->check_in }}</b></th>
				</tr>
				<tr>
					<th width="100%" style="text-align: left; font-size: 8px !important">&nbsp;Check Out: <b>{{ $Record_list->check_out }}</b></th>
					
				</tr>

				<tr>
				<br>
					<th width="100%" style="text-align: left; font-size: 8px !important">&nbsp;Registered By: <b>{{ $Record_list->encoded_by }}</b></th>
					<br>
				</tr>
				
		 </table>
	</th>
</tr>
</table>
</body>