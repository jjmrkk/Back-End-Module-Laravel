<table border="0.0" width="100%" cellpadding="">
<tr>
<br>
    <th width="20%" style="text-align: left; position:relative !important"><img src="C:\xampp\htdocs\hris-office\storage\sunwest_logo.jpg" alt="Logo" width="125" height="34" class="logo"/></th>
    <th width="60%" style="text-align: center; font-size: 12px !important"><br><br><b>Stock In and Stock Out Report</b></th>
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

<table border="0.0" width="100%" cellpadding="1.5" >
@foreach($products as $item)
@if($item->count != 0)

<tr>
    <td width="10%" style="font-size: 7px !important;">Category:</td>
    <td width="90%" style="font-size: 7px !important;"><b>{{ $item->category_code }} - {{ $item->category_name }} </b></td>
</tr>
<tr>
    <td width="10%" style="font-size: 7px !important;">Name:</td>
    <td width="90%" style="font-size: 7px !important;"><b>({{ $item->item_code }})- {{ $item->name }} </b></td>
</tr>
<tr>
  <td width="10%" style="font-size: 7px !important;">Current Balance:</td>
  <td width="90%" style="font-size: 7px !important;"><b>{{ $item->quantity }} {{ $item->measurement_name }} </b></td>
</tr>

      <table border="0.1" width="100%" cellpadding="1.5" >

        <tr>
          <th width="10%" style="text-align: center; font-size: 6.5px !important"><b>DATE</b></th>
          <th width="10%" style="text-align: center; font-size: 6.5px !important"><b>WAREHOUSE</b></th>
          <th width="10%" style="text-align: center; font-size: 6.5px !important"><b>STOCK IN</b></th>
          <th width="50%" style="text-align: center; font-size: 6.5px !important"><b>STOCK OUT</b></th>
          <th width="10%" style="text-align: center; font-size: 6.5px !important"><b>BALANCE</b></th>
          <th width="10%" style="text-align: center; font-size: 6.5px !important"><b>CUSTODIAN</b></th>
    </tr>

   

        @foreach($item->item_in as $logs_in)
       
        <tr>
          <td width="10%" style="text-align: center; font-size: 7px !important;"><b>{{ $logs_in->created_at }} </b></td>
          <td width="10%" style="text-align: center; font-size: 7px !important;"><b>{{ $logs_in->warehouse }} - {{ $logs_in->location }} </b></td>
          <td width="10%" style="text-align: center; font-size: 7px !important;"><b>{{ $logs_in->quantity }} </b></td>
          <td width="50%" style="text-align: center; font-size: 7px !important;">
          
            <table border="0.1" width="100%" cellpadding="1.5" >
              <tr>
                <th width="25%" style="text-align: center; font-size: 6.5px !important"><b>DATE</b></th>
                <th width="25%" style="text-align: center; font-size: 6.5px !important"><b>STOCK OUT</b></th>
                <th width="25%" style="text-align: center; font-size: 6.5px !important"><b>WAREHOUSE</b></th>
                <th width="25%" style="text-align: center; font-size: 6.5px !important"><b>CUSTODIAN</b></th>
              </tr>

              @if($logs_in->count != 0)
              @foreach($logs_in->item_out as $logs_out)
              <tr>
              <td width="25%" style="text-align: center; font-size: 7px !important;"><b>{{ $logs_out->created_at }} </b></td>
              <td width="25%" style="text-align: center; font-size: 7px !important;"><b>{{ $logs_out->out }} </b></td>
              <td width="25%" style="text-align: center; font-size: 7px !important;"><b>{{ $logs_out->warehouse }} </b></td>
              <td width="25%" style="text-align: center; font-size: 7px !important;"><b>{{ $logs_out->first_name }} {{ $logs_out->last_name }} </b></td>
              </tr>
              @endforeach
              @else
              <tr>
                <td width="100%" style="color:#DC143C; text-align: center; font-size: 7px !important;"><b>**NO RECORD FOUND**</b></td>
              </tr>  
              @endif

            </table>

          </td>
          <td width="10%" style="text-align: center; font-size: 7px !important;"><b>{{ $logs_in->balance }} </b></td>
          <td width="10%" style="text-align: center; font-size: 7px !important;"><b>{{ $logs_in->first_name }} {{ $logs_in->last_name }}</b></td>
      </tr>

        @endforeach

        </table>
        @else  
        @endif
<br>
@endforeach
</table>