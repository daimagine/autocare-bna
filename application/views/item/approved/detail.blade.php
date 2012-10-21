
@section('content')

@include('partial.notification')

<!-- Table with opened toolbar -->
{{ Form::open('/item/approved_action', 'POST',  array('id' => 'formAutocare', 'name' => 'formAutocare')) }}
{{ Form::hidden('action', '-', array('id' => 'action')) }}

<fieldset>
    <div class="widget fluid">
        <div class="whead"><h6>Detail Approved</h6><div class="clear"></div></div>
        {{ Form::nginput('text', '', $subAccountTrx->account_transaction->invoice_no, 'Invoice', array('readonly' => 'readonly')) }}

        {{ Form::nginput('text', '', $subAccountTrx->account_transaction->reference_no, 'Reference No', array('readonly' => 'readonly')) }}

        {{ Form::nginput('text', '', $subAccountTrx->account_transaction->user->name, 'Create By', array('readonly' => 'readonly')) }}

        {{ Form::nginput('text', '', $subAccountTrx->item, 'Item', array('readonly' => 'readonly')) }}

        {{ Form::nginput('text', '', $subAccountTrx->quantity, 'Quantity at invoice', array('readonly' => 'readonly')) }}

        {{ Form::nginput('text', '', $subAccountTrx->description, 'Description', array('readonly' => 'readonly')) }}
    </div>

    <div class="widget fluid">
        <div class="whead">
            <h6>Stock Opname Item</h6><div class="clear">
        </div>
        </div>
        <div style="padding: 5px 16px">
        <div class="btn-group" id="putitem-button" style="display: inline-block; margin-bottom: -4px;">
            <a class="buttonS bBlue" data-toggle="dropdown" href="#"><span>Put Item</span><span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a onclick="items.approved.openDialog_lst_items()" ><span class="icos-folder"></span>Select Item</a></li>
                @foreach($itemCategory as $c)
                <li><a onclick="items.approved.openDialog_new_items('{{$c->id}}', '{{$c->name}}')"><span class="icos-add"></span>New Item {{$c->name}}</a></li>
                @endforeach
            </ul>
        </div>
        </div>
        <div class="formRow noBorderB" style="padding-top: 5px;" id="item-body">
            <table cellpadding="0" cellspacing="0" width="100%" class="tDark" id="item-table">
                <thead>
                <tr>
                    <td>Type</td>
                    <td>Unit</td>
                    <td>Code</td>
                    <td>Name</td>
                    <td>Vendor</td>
                    <td>Current Stock</td>
                    <td>Quantity Opname</td>
                    <!--                    <td>Total</td>-->
                </tr>
                </thead>
                <tbody id="item-tbody">

                </tbody>
            </table>
            <input type="hidden" id="item-rows" value="0"/>
            <div id="item-input-wrapper" style="display: none;"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label>Remarks message :<span class="req">*</span></label></div>
            <div class="grid9"><textarea rows="8" cols="" name="remarks" class="validate[required]" id="remarks"></textarea></div><div class="clear"></div>
        </div>

        <div style="padding: 19px 16px">
            <div class="formSubmit">
                {{ Form::submit('Reject', array( 'class' => 'buttonM bRed mb10 mt5', 'id' => 'buttonCloseApproved' )) }}
                {{ Form::submit('Complete', array( 'class' => 'buttonL bGreen mb10 mt5', 'id' => 'buttonConfirmApproved')) }}
                <div class="clear"></div>
            </div>
            <div class="btn-group dropup" style="display: inline-block; margin-bottom: 0px;">
                {{ HTML::link('item/list_approved', 'Back', array( 'class' => 'buttonL bDefault mb10 mt5' )) }}
            </div>
            <!-- Form Dialog New Item -->
            <div id="formDialogNewItem" class="dialog" title="Dialog new items" >
            </div>

            <!-- Form Dialog Add Item -->
            <div id="formDialogListItem" class="dialog" title="List Item" >
            </div>

            <div id="formDialogApproved" title="Confirmation Closed Approved Invoice">
            </div>

        </div>
    </div>
</fieldset>


{{ Form::close() }}
@endsection
