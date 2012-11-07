@section('content')

@include('partial.notification')

@include('partial.report.middlenav')

<div class="clear"></div>
<div class="divider"><span></span></div>

@include('partial.report.warehouse_middlenav')

<div class="clear"></div>
<div class="divider"><span></span></div>


<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>Warehouse Item Report :: List</h6>
        <div class="clear"></div>
    </div>

    <form method="get" id="formList">
        <div class="fluid grid">
            <div class="formRow noBorderB">
                <div class="grid6">
                    <div class="clear" style=""></div>
                        <div class="grid3"><label>Item Name</label> </div>
                        <div class="grid7">
                            <div class="searchLine" style="margin-top: 0px">
                                    <input type="text" id="itemName" name="name" class="ac ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" value="{{$name}}"></button>
                            </div>
                        </div>
                    <div class="clear" style="padding-bottom: 15px;"></div>
                        <div class="grid3"><label>Vendor</label> </div>
                        <div class="grid7">
                            <div class="searchLine" style="margin-top: 0px">
                                <input type="text" id="itemVendor" name="vendor" class="ac ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" value="{{$vendor}}"></button>
                            </div>
                        </div>
                    <div class="clear" style="padding-bottom: 15px;"></div>
                </div>

                <div class="grid6">
                    <div class="clear" style=""></div>
                        <div class="grid3"><label>Code</label> </div>
                        <div class="grid7">
                                <div class="searchLine" style="margin-top: 0px">
                                    <input type="text" id="itemCode" name="code" class="ac ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" value="{{$code}}"></button>
                                </div>
                        </div>
                    <div class="clear" style="padding-bottom: 15px;"></div>
                    <div class="grid3"><label>Stock</label> </div>
                    <div class="grid7">
                        <div style="float: left;">
                            {{Form::select('opQryStock', array('=' => 'eq', '<' => 'lt', '>' => 'gt'), $opQryStock)}}
                        </div>
                        <div class="grid5 searchLine" style="margin-top: 0px">
                                <input type="text" id="itemStock" name="stock" class="ac ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" value="{{$stock}}"></button>
                            </div>
                        </div>
                    <div class="clear" style="padding-bottom: 15px;"></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="fluid grid">
            <div class="formRow noBorderB">
                <div class="grid">
                    <ul class="timeRange">
                        <li><input type="submit" class="buttonS bLightBlue" value="Search"></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </form>

    <div class="divider"><span></span></div>


    <div id="dyn2" class="shownpars overflowtable">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTableWarehouseItem" dtable-sortlist="[[0,'desc']]">
            <thead>
            <tr>
                <th>Item Name</th>
                <th>Category</th>
                <th>Type</th>
                <th>Unit</th>
                <th>Code</th>
                <th>Vehicle</th>
                <th>Current Stock</th>
                <th>Total updated stock</th>
                <th>Sell Price</th>
                <th>Purchase Price</th>
                <th>Vendor</th>
                <th>Status Item</th>
                <th>Created Date</th>
                <th>Last Updated</th>
            </tr>
            </thead>

            <tbody>
            @foreach($items as $item)
            <tr class="">
                <td>{{ $item->name }}</td>
                <td>{{ $item->category }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ $item->unit }}</td>
                <td>{{ $item->code }}</td>
                <td>{{ $item->current_stock }}</td>
                <td>{{ $item->total_update_stock }}</td>
                <td>IDR {{  number_format($item->sell_price, 2) }}</td>
                <td>{{ $item->total_update_sell_price }}</td>
                <td>IDR {{  number_format($item->purchase_price, 2) }}</td>
                <td>{{ $item->vendor }}</td>

                @if($item->status === statusType::ACTIVE)
                <td>Active</td>
                @elseif($item->status === statusType::INACTIVE)
                <td>Inactive</td>
                @else
                <td></td>
                @endif
                <td>{{ date('Y-m-d', strtotime($item->create_date)) }}</td>
                <td>{{ date('Y-m-d', strtotime($item->last_update)) }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
</div>

@endsection

