<table border="0.0" width="100%" cellpadding="">
<tr>
<br>
    <th width="20%" style="text-align: left; position:relative !important"><img src="C:\xampp\htdocs\hris-office\storage\sunwest_logo.jpg" alt="Logo" width="125" height="34" class="logo"/></th>
    <th width="60%" style="text-align: center; font-size: 12px !important"><br><br><b>Receiving Report</b></th>
    <th width="20%" style="text-align: right; font-size: 12px !important"></th>
    </tr>
    <tr>
    <th width="100%" style="text-align: center; font-size: 9px !important">From: <b>{{$from}}</b> To: <b>{{$to}}</b></th>
  </tr>
    <tr>
      <th width="80%"  style="text-align: left; font-size: 7.0px !important"></th>
      <th width="20%"  style="text-align: left; font-size: 7.0px !important"><b>&nbsp;&nbsp;&nbsp;Warehouse: </b><b style="text-decoration: underline; color:#DC143C; !important">{{ $warehouse->name }}</b></th>     
    </tr>
</table>
<br>
<table border="0.0" width="100%" cellpadding="1.5" >
  
@foreach($products as $item)
@foreach($item->from as $logs_out)
      @foreach($logs_out->item_details as $item_detail)
<br>
<tr>
<td width="10%" style="font-size: 7px !important;">Category:</td>
<td width="90%" style="font-size: 7px !important;"><b>{{ $item_detail->sku }}</b></td>
</tr>
<tr>
<td width="10%" style="font-size: 7px !important;">Name:</td>
<td width="90%" style="font-size: 7px !important;"><b>({{ $item_detail->item_code }}) - {{ $item_detail->name }} </b></td>
</tr>

<table border="0.1" width="100%" cellpadding="1.5" >

<tr>
<th width="20%" style="text-align: center; font-size: 6.5px !important"><b>DATE</b></th>
<th width="20%" style="text-align: center; font-size: 6.5px !important"><b>FROM WAREHOUSE</b></th>
<th width="20%" style="text-align: center; font-size: 6.5px !important"><b>Quantity</b></th>
<th width="20%" style="text-align: center; font-size: 6.5px !important"><b>CUSTODIAN</b></th>
<th width="20%" style="text-align: center; font-size: 6.5px !important"><b>Received by</b></th>
</tr>

<tr>
<td width="20%" style="text-align: center; font-size: 7px !important;"><b>{{ $item->created_at }} </b></td>
<td width="20%" style="text-align: center; font-size: 7px !important;"><b>{{ $logs_out->from_warehouse }}</b></td>
<td width="20%" style="text-align: center; font-size: 7px !important;"><b>{{ $item->out }} - {{ $item_detail->measurement_name }}</b></td>
<td width="20%" style="text-align: center; font-size: 7px !important;"><b>{{ $item->first_name }} {{ $item->last_name }}</b></td>
<th width="20%" style="text-align: center; font-size: 6.5px !important"><b></b></th>
</tr>
</table>
<br>

@endforeach
@endforeach
@endforeach

  
  


  
</table>