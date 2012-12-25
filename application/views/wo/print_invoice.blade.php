<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Work Order Invoice</title>

	<link rel='stylesheet' type='text/css' href='../../css/print/style.css' />
	<link rel='stylesheet' type='text/css' href='../../css/print/print.css' media="print" />
	<script type='text/javascript' src='../../js/wo/print/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='../../js/wo/print/example.js'></script>
</head>

<body onload="javascript:window.print()">

<div style="margin-top: 10px;text-align: center;">
    <a href="javascript:window.print()" class="buttonM bGreen"><span class="iconb" data-icon="" style="margin-left: 0px;"></span><span>PRINT</span></a>
</div>
	<div id="page-wrap">

		<textarea id="header">INVOICE</textarea>
		
		<div id="identity">
		
            <textarea id="address" readonly="true">Autocare BNA
123 Rawa Buayo Street
CONDET, 12220

Phone: (6221) 555-5555</textarea>

            <div id="logoctr">
                &nbsp;
            </div>
            <div id="logo">
              <img id="image" src="../../images/logo.png" alt="logo" />
            </div>
		
		</div>
		
		<div style="clear:both"></div>
		
		<div id="customer">

            <textarea id="customer-title">To : {{$transaction->vehicle->customer->name}}</textarea>

            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice</td>
                    <td><textarea>{{$transaction->invoice_no}}</textarea></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td id="currentTime"></td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td><div class="due">IDR {{$transaction->paid_amount}}</div></td>
                </tr>

            </table>
		
		</div>
		
		<table id="items">
		
		  <tr>
		      <th>Description</th>
		      <th>Unit</th>
              <th>Quantity</th>
              <th>Unit Price</th>
		      <th>Sub Total</th>
		  </tr>

          @foreach($transaction->transaction_service as  $trx_service)
		  <tr class="item-row">
              <td class="description">{{ $trx_service->service_formula->service->name }}</td>
              <td class="item-name" align="center">-</td>
              <td class="qty" align="center">1</td>
              <td class="cost">IDR {{ $trx_service->service_formula->price }}</td>
		      <td class="price">IDR {{ ($trx_service->service_formula->price)}}</span></td>
		  </tr>
          @endforeach

            @foreach($transaction->transaction_item as  $trx_item)
            <?php $total=number_format((float)(($trx_item->item_price->price) * ($trx_item->quantity)), 2, '.', ''); ?>
            <tr class="item-row">
                <td class="description">{{ $trx_item->item_price->item->name}}</td>
                <td class="item-name" align="center">{{ $trx_item->item_price->item->item_unit->name}}</td>
                <td class="qty" align="center">{{ $trx_item->quantity}}</td>
                <td class="cost">IDR {{ $trx_item->item_price->price}}</td>
                <td><span class="price">IDR {{$total}}</span></td>
            </tr>
            @endforeach
		  <tr style="border-bottom: 1px solid black;">
		    <td colspan="5">Calculation</td>
		  </tr>
		  
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value"><div id="subtotal">IDR {{$transaction->amount}}</div></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Pph 0%</td>
		      <td class="total-value"><div id="pph">IDR 0.00</div></td>
		  </tr>
            <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">
                  Discount Service
                  @if(isset($transaction->vehicle->membership->discount))
                  {{$transaction->vehicle->membership->discount->value}} %
                  @endif
              </td>
		      <td class="total-value"><div id="discount">IDR {{$transaction->discount_amount}}</div></td>
		  </tr>
            <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Total</td>
		      <td class="total-value"><div id="total">IDR {{$transaction->paid_amount}}</div></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Amount Paid</td>

		      <td class="total-value">IDR {{$transaction->paid_amount}}</td>
		  </tr>
		
		</table>
		
		<div id="terms">
		  <h5>Terms</h5>
		  <textarea>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</textarea>
        </div>

	</div>
</body>

</html>