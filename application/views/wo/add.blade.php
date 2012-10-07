@section('content')

@include('partial.notification')
<br>

{{ Form::open('/work_order/add', 'POST') }}
<fieldset>
<div class="widget fluid">
    <div class="whead">
        <h6>Customer Add</h6>

        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Customer</label> </div>
        <div class="grid5">
            <div class="searchLine" style="margin-top: 0px">
                <form action="">
                    <input type="text" id="customerName" name="customerName" class="ac ui-autocomplete-input" placeholder="Enter search name..." autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                    <a onclick="WorkOrder.customer.openDialog_lst_customer()"><span class="icos-search" style="position: absolute;top: 0;right: 0;"></span></a>
                </form>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Status</label> </div>
        <div class="grid5">
            <div class="searchLine" style="margin-top: 0px">
                <form action="">
                    <input type="text" id="memberStatus" name="search" class="ac ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" disabled="true"></button>
                </form>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div>
       <input type="hidden" id="customerId" name="customerId">
    </div>
</div>


    <div class="widget fluid">
        <div id="vehicle-whead" class="whead " >
            <h6>Vehicle</h6>
            <a href="#vehicle-body" id="add-new-vehicle" class="buttonH bBlue" title="" onclick="WorkOrder.customer.openDialog_vehicle();">Add</a>
            <div class="clear"></div>
        </div>
        <div id="vehicle-body" class="body" style="display: block; ">
            @if(!isset($customer['vehicles']))
            <span id="vehicle-addnotice" class="">Search customer member first <br/> or click add button to add new vehicle for customer non member</span>
            @endif

            <table id="vehicle-table" cellpadding="0" cellspacing="0" width="100%" class="tDark" style=" {{ !isset($customer['vehicles']) ? 'display:none;' : '' }} ">
                <thead>
                <tr>
                    <td>Vehicle No</td>
                    <td>Type</td>
                    <td>Color</td>
                    <td>Model</td>
                    <td>Brand</td>
                    <td>Description</td>
                </tr>
                </thead>
                <tbody id="vehicle-tbody">

                </tbody>
            </table>
            <input type="hidden" id="vehicle-rows" value="0"/>
            <div id="vehicle-input-wrapper" style="display: none;"></div>
        </div>
    </div>

    <div class="widget fluid">
        <div class="whead">
            <h6>Add Service</h6>

            <div class="clear"></div>
        </div>

        {{ Form::nyelect('unit_id', @$selectionService, isset($service['id']) ? $service['id'] : 0, 'Service Type', array('class' => 'validate[required]', 'id' => 'serviceType')) }}

        <div class="formRow">
            <div class="grid3"><label>Description</label></div>
            <div class="grid9">
                @if($lstService!=null)
                @foreach($lstService as $service)
                <textarea rows="8" cols="" name="description" class="desc-service" id="desc-{{$service->id}}" readonly="true" style="display: none">{{$service->description}}</textarea>
                {{ Form::hidden('price', $service->service_formula()->price, array('id'=>'service-price-'.$service->id)) }}
                @endforeach
                @endif
               <textarea rows="8" cols="" name="description" class="desc-service" id="desc-0" readonly="true"></textarea>
            </div>
            <a href="#vehicle-body" id="add-service" class="buttonH bBlue mb10 mt5" title="">Add This Service</a>
            <div class="clear"></div>
        </div>


        <div id="service-body" class="body" style="display: block; ">
        <table id="service-table" cellpadding="0" cellspacing="0" width="100%" class="tDark" style="">
            <thead>
            <tr>
                <td>No</td>
                <td>Service Name</td>
                <td>Service Price</td>
                <td>Description</td>
            </tr>
            </thead>
            <tbody id="service-tbody">

            </tbody>
            <input type="hidden" id="service-rows" value="0"/>
            <div id="service-input-wrapper" style="display: none;"></div>
        </table>
            </div>
    </div>

    <div class="widget fluid">
        <div id="item-whead" class="whead " >
            <h6>Item</h6>
            <a href="#vehicle-body" class="buttonH bBlue" title="" onclick="WorkOrder.items.openDialog_lst_items();">Add</a>
            <div class="clear"></div>
        </div>
        <div id="item-body" class="body" style="display: block; ">
            @if(!isset($customer['items']))
            <span id="item-addnotice" class=""><em>click add button to include item for this work order</em></span>
            @endif

            <table id="item-table" cellpadding="0" cellspacing="0" width="100%" class="tDark" style=" {{ !isset($customer['items']) ? 'display:none;' : '' }} ">
                <thead>
                <tr>
                    <td>Type</td>
                    <td>Unit</td>
                    <td>Code</td>
                    <td>Name</td>
                    <td>Vendor</td>
                    <td>Price</td>
                    <td>Total</td>
                </tr>
                </thead>
                <tbody id="item-tbody">

                </tbody>
            </table>
            <input type="hidden" id="item-rows" value="0"/>
            <div id="item-input-wrapper" style="display: none;"></div>
        </div>
    </div>

    <div class="widget fluid">
        <div class="whead">
            <h6>Assign Mechanic</h6>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3">{{Form::label('mechanic', 'Mechanic')}}</div>
            <div class="grid9">
                {{Form::select('merchanic', $selectionMechanic, isset($mechanic['id']) ? $mechanic['id'] : 0, array('class' => 'validate[required]', 'id' => 'mechanic'))}}
                <a href="#vehicle-body" id="add-mechanic" class="buttonH bBlue mb10 mt5" title="" style="margin-right: 20px;">Assign this mechanic</a>
            </div>
            <div class="clear"></div>
        </div>


        <div class="grid7">
        <div id="mechanic-body" class="body" style="display: block; ">
            <table id="mechanic-table" cellpadding="0" cellspacing="0" width="100%" class="tDark" style="">
                <thead>
                <tr>
                    <td>No</td>
                    <td>Mechanic Name</td>
                </tr>
                </thead>
                <tbody id="mechanic-tbody">

                </tbody>
            </table>
            <input type="hidden" id="mechanic-rows" value="0"/>
            <div id="mechanic-input-wrapper" style="display: none;"></div>
        </div>
        </div>
    </div>

    <div class="widget fluid">
        <div class="wheadLight2">
            <h6>Action</h6>
            <div class="clear"></div>
        </div>

        <div class="formRow noBorderB">
            <div class="status" id="status3">
                <div class="grid5">
                    <span class="">click save button to save this work order</span>
                </div>
                <div class="grid7">
                    <div class="formSubmit">
<!--                        {{ HTML::link('customer/index', 'Cancel', array( 'class' => 'buttonL bDefault mb10 mt5' )) }}-->
                        {{ Form::submit('Save', array( 'class' => 'buttonL bGreen mb10 mt5' )) }}
                    </div>
                </div>
            </div>

            <div class="clear"></div>
        </div>
    </div>


    <!-- Dialog add service confirmation -->
    <div id="service-dialog" class="dialog" title="Add Service Confirmation" style="display: none;">
    </div>

    <!-- Dialog content select customer member -->
    <div id="customer-dialog" class="dialog" title="Customer list" style="display: none;">

    </div>

    <!-- Dialog content select items-->
    <div id="item-dialog" class="dialog" title="Item list" style="display: none;">

    </div>

    <!-- Dialog confirmation assign mechanic-->
    <div id="mechanic-dialog" class="dialog" title="Item list" style="display: none;">

    </div>

    <div id="vehicle-dialog" class="dialog" title="Vehicle Registration Form" style="display: none;">
        <form id="vehicle-form" name="vehicle-form">
            <div class="messageTo">
                <span> Register vehicle to <strong><span id="vehicle-customer-name"></span></strong></span>
            </div>
            <div class="divider"><span></span></div>
            <div class="dialogSelect m10">
                <label>Vehicle Number *</label>
                <input type="text" id="vehicle-no"/>
            </div>
            <div class="dialogSelect m10">
                <label>Vehicle Type</label>
                <input type="text" id="vehicle-type"/>
            </div>
            <div class="dialogSelect m10">
                <label>Vehicle Color</label>
                <input type="text" id="vehicle-color"/>
            </div>
            <div class="dialogSelect m10">
                <label>Vehicle Model</label>
                <input type="text" id="vehicle-model"/>
            </div>
            <div class="dialogSelect m10">
                <label>Vehicle Brand</label>
                <input type="text" id="vehicle-brand"/>
            </div>
            <div class="dialogSelect m10">
                <label>Vehicle Description</label>
                <input type="text" id="vehicle-description"/>
            </div>
            <input type="hidden" id="customer-method" value="add"/>
        </form>
    </div>

<div>

</div>

</fieldset>

{{ Form::close() }}

@endsection




