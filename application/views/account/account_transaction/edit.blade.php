@section('content')

@include('partial.notification')
<br>

{{ Form::open('/account/invoice_edit/'.$account->type, 'POST') }}

{{ Form::hidden('id', $account->id) }}

{{ Form::hidden('type', $account->type) }}

<fieldset>

    <div class="widget fluid">
        <div class="whead">
            <h6>Edit Invoice {{ $accountTransType === 'D' ? 'Account Receivable' : 'Account Payable' }}</h6>

            <div class="clear"></div>
        </div>

        {{ Form::nginput('text', 'subject', $account->subject, $accountTransType === 'D' ? 'To *' : ($accountTransType === 'C' ? 'From *' : 'Subject *'), array( 'id' => 'account-name' ) ) }}

        {{ Form::nginput('text', 'invoice_no', $account->invoice_no, 'Invoice', array( 'readonly' => 'readonly' )) }}

        {{ Form::nginput('text', 'reference_no', $account->reference_no, 'Reference *') }}

        <div class="formRow">
            <div class="grid3"><label>Invoice Date *</label></div>
            <div class="grid9">
                <ul class="timeRange">
                    <li><input name="invoice_date" type="text" class="datepicker" value="{{ $invoice_date }}" /></li>
                    <li class="sep">-</li>
                    <li><input name="invoice_time" type="text" class="timepicker" size="10" value="{{$invoice_time }}" />
                        <span class="ui-datepicker-append">(hh:mm:ss)</span>
                    </li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>


        <div class="formRow">
            <div class="grid3"><label>Due Date *</label></div>
            <div class="grid9">
                <ul class="timeRange">
                    <li><input name="due_date" type="text" class="datepicker" value="{{ $due_date }}" /></li>
                    <li class="sep">-</li>
                    <li><input name="due_time" type="text" class="timepicker" size="10" value="{{ $due_time }}" />
                        <span class="ui-datepicker-append">(hh:mm:ss)</span>
                    </li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>

        {{ Form::nyelect('status', array(1 => 'Active', 0 => 'Inactive'), $account->status, 'Status') }}

        {{ Form::nginput('text', 'description', $account->description, 'Description') }}

    </div>

    <div class="widget">
        <div id="item-whead" class="whead " >
            <h6>item</h6>
            <a href="#item-body" class="buttonH bBlue" title="" onclick="Account.Item.openDialog();">Add</a>
            <div class="clear"></div>
        </div>
        <div id="item-body" class="body" style="display: block; ">
            @if( is_array($items) && empty($items) )
            <span id="item-addnotice" class="">click add button to register new item</span>
            @endif

            <table id="item-table" cellpadding="0" cellspacing="0" width="100%" class="tDark" style=" {{ ( is_array($items) && empty($items) ) ? 'display:none;' : '' }} ">
                <thead>
                    <tr>
                        <td>Item</td>
                        <td>Quantity</td>
                        <td>Account</td>
                        <td>Tax Amount</td>
                        <td>Amount</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody id="item-tbody">
                    @for ($i = 0; $i < count($items); $i++)
                        <tr id="v-rows-{{ $i }}">
                            <td class="v-no v-num-{{ $i }}">{{ $items[$i]->item }}</td>
                            <td class="v-type-{{ $i }}">{{ $items[$i]->quantity }}</td>
                            <td class="v-color-{{ $i }}">{{ $items[$i]->account->name }}</td>
                            <td class="v-model-{{ $i }}">{{ $items[$i]->tax }}</td>
                            <td class="v-brand-{{ $i }}">{{ $items[$i]->amount }}</td>
                            <td>
                                <div>
                                    <a href="#item-tbody" onclick="Account.Item.edit('v-rows-{{ $i }}','{{ $i }}')">edit</a> |
                                    <a href="#item-tbody" onclick="Account.Item.remove('v-rows-{{ $i }}')">remove</a>
                                </div>
                            </td>
                            <td style="display: none; ">
                                <input type="hidden" class="v-item-hid-{{ $i }}" name="items[{{ $i }}][item]" value="{{ $items[$i]->item }}" />
                                <input type="hidden" class="v-qty-hid-{{ $i }}" name="items[{{ $i }}][quantity]" value="{{ $items[$i]->quantity }}" />
                                <input type="hidden" class="v-account-hid-{{ $i }}" name="items[{{ $i }}][account_type_id]" value="{{ $items[$i]->account_type_id }}" />
                                <input type="hidden" class="v-tax-hid-{{ $i }}" name="items[{{ $i }}][tax]" value="{{ $items[$i]->tax }}" />
                                <input type="hidden" class="v-amount-hid-{{ $i }}" name="items[{{ $i }}][amount]" value="{{ $items[$i]->amount }}" />
                                <input type="hidden" name="items[{{ $i }}][status]" value="{{ $items[$i]->status }}" />
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <input type="hidden" id="item-rows" value="{{ empty($items) ? 0 : sizeof($items) }}"/>
            <div id="item-input-wrapper" style="display: none;"></div>
        </div>
    </div>


    <div class="widget fluid">
        <div class="wheadLight2">
            <h6>Action</h6>
            <div class="clear"></div>
        </div>

        <div class="formRow noBorderB">
            <div class="status" id="status3">
                <div class="grid8">
                    <span class="">click save button to register this {{ $accountTransType === 'D' ? 'Account Receivable' : 'Account Payable' }} or cancel to return</span>
                </div>
                <div class="grid4">
                    <div class="formSubmit">
                        {{ HTML::link( $accountTransType === 'D' ? 'account/account_receivable' : 'account/account_payable', 'Cancel', array( 'class' => 'buttonL bDefault mb10 mt5' )) }}
                        {{ Form::submit( 'Save', array( 'class' => 'buttonL bGreen mb10 mt5' )) }}
                    </div>
                </div>
            </div>

            <div class="clear"></div>
        </div>
    </div>

    <!-- Dialog content -->
    <div id="item-dialog" class="dialog" title="Item Registration Form" style="display: none;">
        <form id="item-form" name="item-form">
            <div class="messageTo">
                <span> Assign item to <strong><span id="item-account-name"></span></strong></span>
            </div>
            <div class="divider"><span></span></div>
            <div class="dialogSelect m10" id="item-dialog-notification"></div>

            <div class="fluid">
                <div class="grid6">
                    <div class="dialogSelect m10">
                        <label>Item Information *</label><br>
                        <input type="text" id="item-info"/>
                    </div>
                    <div class="dialogSelect m10">
                        <label>Item Description</label><br>
                        <input type="text" id="item-description"/>
                    </div>
                    <div class="dialogSelect m10">
                        <label>Item Quantity *</label><br>
                        <input type="text" id="item-quantity" onchange="Account.Item.calculateAmount()"/>
                    </div>
                    <div class="dialogSelect m10">
                        <label>Unit Price *</label><br>
                        <input type="text" id="item-unit-price" onchange="Account.Item.calculateAmount()"/>
                    </div>
                </div>
                <div class="grid6">
                    <div class="dialogSelect m10">
                        <label>Discount</label><br>
                        <input type="text" id="item-discount" onchange="Account.Item.calculateAmount()"/>
                    </div>
                    <div class="dialogSelect m10">
                        <label style="margin-bottom: -13px; display: block;">Account</label><br>
                        <select id="item-account-type">
                            @foreach($accounts as $key => $value)
                            <option id="select-account-id-{{ $key }}" value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="dialogSelect m10">
                        <label>Tax Amount</label><br>
                        <input type="text" id="item-tax" onchange="Account.Item.calculateAmount()"/>
                    </div>
                    <div class="dialogSelect m10">
                        <label>Amount</label><br>
                        <input type="text" id="item-amount" readonly="readonly" value="0"/>
                    </div>
                </div>
            </div>
            <input type="hidden" id="item-method" value="add"/>
        </form>
    </div>

</fieldset>

{{ Form::close() }}

@endsection