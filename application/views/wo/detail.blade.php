@section('content')

@include('partial.notification')
<br>

{{ Form::open('/work_order/add', 'POST') }}
<fieldset>
<div class="widget fluid">
    <div class="whead">
        <h6>Workorder Detail Information</h6>

        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Work Order No</label> </div>
        <div class="grid5">
                    <input type="text"  name="customerName" class="ac ui-autocomplete-input" readonly="true" value="{{$transaction->workorder_no}}">
        </div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Status Work Order</label> </div>
        <div class="grid5">
            <input type="text"  name="customerName" class="ac ui-autocomplete-input" readonly="true" value="{{$transaction->status == 'O' ? 'OPEN' : ($transaction->status == 'D' ? 'CLOSED' : ($transaction->status == 'C' ? 'CANCELED' : ''))}}">
        </div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Customer</label> </div>
        <div class="grid5">
            <input type="text"  name="customerName" class="ac ui-autocomplete-input" readonly="true" value="{{$transaction->vehicle->customer->name}}">
        </div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Vehicle Model</label> </div>
        <div class="grid5">
            <input type="text"  name="customerName" class="ac ui-autocomplete-input" readonly="true" value="{{$transaction->vehicle->model}}">
        </div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Vehicle No</label> </div>
        <div class="grid5">
            <input type="text"  name="customerName" class="ac ui-autocomplete-input" readonly="true" value="{{$transaction->vehicle->number}}">
        </div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Service Time</label> </div>
        <div class="grid5">
            <input type="text"  name="customerName" class="ac ui-autocomplete-input" readonly="true" value="{{$transaction->date}}">
        </div>
        <div class="clear"></div>
    </div>
</div>

<div class="divider"><span></span></div>
    <span class=""><h6>SERVICE LIST</h6></span>
    <div class="widget" style="margin-top: 10px;width: 70%;">
        <table cellpadding="0" cellspacing="0" width="100%" class="tDark">
            <thead>
            <tr>
                <td>Service Name</td>
                <td>Price</td>
                <td>Detail</td>
            </tr>
            </thead>
            <tbody>
            @foreach($transaction->transaction_service as $trx_service)
            <tr>
                <td>{{ $trx_service->service_formula->service->name }}</td>
                <td>{{ $trx_service->service_formula->price }}</td>
                <td>{{ $trx_service->service_formula->service->description }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="divider"><span></span></div>
    <span class=""><h6>ITEM LIST</h6></span>
    <div class="widget" style="margin-top: 10px;width: 70%;">
        <table cellpadding="0" cellspacing="0" width="100%" class="tDark">
            <thead>
            <tr>
                <td>Category</td>
                <td>Name</td>
                <td>Unit</td>
                <td>Quantity</td>
                <td>Price</td>
            </tr>
            </thead>
            <tbody>
            @foreach($transaction->transaction_item as $trx_item)
            <tr>
                <td>{{ $trx_item->item_price->item->item_category->name}}</td>
                <td>{{ $trx_item->item_price->item->name}}</td>
                <td>{{ $trx_item->item_price->item->item_unit->name}}</td>
                <td>{{ $trx_item->quantity}}</td>
                <td>{{ $trx_item->item_price->price}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <div class="divider"><span></span></div>
    <span class=""><h6>MECHANIC LIST</h6></span>
    <div class="widget" style="margin-top: 10px;width: 50%;">
        <table cellpadding="0" cellspacing="0" width="100%" class="tDark">
            <thead>
            <tr>
                <td>Id</td>
                <td>Name</td>
            </tr>
            </thead>
            <tbody>
            @foreach($transaction->user_workorder as $mechanic)
            <tr>
                <td>{{ $mechanic->user->id }}</td>
                <td>{{ $mechanic->user->name }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="divider"><span></span></div>
    <div class="widget fluid">
        <div class="wheadLight2">
            <h6>Action</h6>
            <div class="clear"></div>
        </div>

        <div class="formRow noBorderB">
            <div class="status" id="status3">
                <div class="grid5">
                    <span class="">{{ HTML::link('work_order/list', 'Back', array( 'class' => 'buttonL bDefault mb10 mt5' )) }}</span>
                </div>
                <div class="grid7">
                    <div class="formSubmit">
                        @if($transaction->status == 'O')
                        <a href="#" class="buttonM bGreen"><span class="iconb" data-icon="" style="margin-left: 0px;"></span><span>Close WO</span></a>
                        <a href="#" class="buttonM bGreyish"><span class="iconb" data-icon=""  style="margin-left: 0px;"></span><span>Canceled</span></a>
                        @endif
                        @if($transaction->status == 'D' or $transaction->status == 'O')
                        <a href="#" class="buttonM bGold"><span class="iconb" data-icon=""  style="margin-left: 0px;"></span><span>To Invoice</span></a>
                        @endif
                        @if($transaction->status == 'C' or $transaction->status == 'D')
                        <a href="#" class="buttonM bSea"><span class="iconb" data-icon=""  style="margin-left: 0px;"></span><span>Reopen</span></a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="clear"></div>
        </div>
    </div>

<!-- Dialog add service confirmation -->
<div id="service-dialog" class="dialog" title="Add Service Confirmation" style="display: none;">
</div>

</div>

</fieldset>

{{ Form::close() }}

@endsection



