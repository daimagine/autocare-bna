
@section('content')

@include('partial.notification')

<!-- Table with opened toolbar -->
{{ Form::open('/item/approved_action', 'POST',  array('id' => 'formBody', 'name' => 'formBody')) }}
{{ Form::hidden('action', '-') }}

<fieldset>
    <div class="widget fluid">
        <div class="whead"><h6>Detail Approved</h6><div class="clear"></div></div>
        {{ Form::nginput('text', '', $subAccountTrx->account_transaction->invoice_no, 'Invoice', array('readonly' => 'readonly')) }}

        {{ Form::nginput('text', '', $subAccountTrx->account_transaction->reference_no, 'Reference No', array('readonly' => 'readonly')) }}

        {{ Form::nginput('text', '', '', 'Create By', array('readonly' => 'readonly')) }}

        {{ Form::nginput('text', '', $subAccountTrx->item, 'Item', array('readonly' => 'readonly')) }}

        {{ Form::nginput('text', '', $subAccountTrx->qty, 'Quantity at invoice', array('readonly' => 'readonly')) }}

        {{ Form::nginput('text', '', $subAccountTrx->description, 'Description', array('readonly' => 'readonly')) }}
    </div>

    <div class="widget fluid">
        <div class="whead">
            <h6>Stock Opname List</h6><div class="clear">
        </div>
        </div>
        <div style="padding: 5px 16px">
        <div class="btn-group" style="display: inline-block; margin-bottom: -4px;">
            <a class="buttonS bBlue" data-toggle="dropdown" href="#"><span>Put Item</span><span class="caret"></span></a>
            <ul class="dropdown-menu">
                @foreach($itemCategory as $c)
                <li><a onclick="getListItem('{{$c->id}}');" ><span class="icos-folder"></span>Select Item {{$c->name}}</a></li>
                @endforeach
                @foreach($itemCategory as $c)
                <li><a onclick="formNewItem('{{$c->id}}')"><span class="icos-add"></span>New Item {{$c->name}}</a></li>
                @endforeach
            </ul>
        </div>
        </div>
        <div class="formRow noBorderB" style="padding-top: 5px;">
            <table cellpadding="0" cellspacing="0" width="100%" class="tDark">
                <thead>
                <tr>
                    <td>Item Name</td>
                    <td>Code</td>
                    <td>Quantity Opname</td>
                    <td>Current Stock</td>
                    <td>Total Stock</td>
                    <td>Vendor</td>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{$item->item->name }}</td>
                    <td>{{$item->item->code }}</td>
                    <td>{{$item->quantity }}</td>
                    <td>{{$item->item->stock }}</td>
                    <td>{{($item->item->stock) + ($item->quantity) }}</td>
                    <td>{{$item->item->vendor }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding: 19px 16px">
            <div class="formSubmit">
                {{ Form::submit('Reject', array( 'class' => 'buttonM bRed mb10 mt5', 'id' => 'buttonReject' )) }}
                {{ Form::submit('Complete', array( 'class' => 'buttonL bGreen mb10 mt5', 'id' => 'buttonConfirm')) }}
                <div class="clear"></div>
            </div>
            <div class="btn-group dropup" style="display: inline-block; margin-bottom: 0px;">
                {{ HTML::link('item/list_approved', 'Back', array( 'class' => 'buttonL bDefault mb10 mt5' )) }}
            </div>
            <!-- Form Dialog New Item -->
            <div id="formDialogNewItem" class="dialog" title="Dialog with form elements" >
            </div>

            <!-- Form Dialog Add Item -->
            <div id="formDialogListItem" class="dialog" title="List Item" >
            </div>

        </div>
    </div>
</fieldset>
<script type="text/javascript">

</script>
{{ Form::close() }}
@endsection