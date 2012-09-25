@section('content')

@include('partial.notification')
<br>

<ul class="middleNavA">
    @foreach($allItemCategory as $category)
    <li><a href="add?category={{$category->id}}" title="{{$category->name}}" style="width: 100px;height: 65px;"><img src="../images/icons/color/config.png" alt="" /><span style="@if($itemCategory->name == $category->name) color:red @endif">{{$category->name}}</span></a></li>
    @endforeach
</ul>
<div class="divider"><span></span></div>

{{ Form::open('item/add', 'POST') }}

<fieldset>

    <div class="widget fluid">
        <div class="whead">
            <h6>Add Item {{$itemCategory->name}}</h6>

            <div class="clear"></div>
        </div>


        {{ Form::hidden('item_category_id', $itemCategory->id) }}

        {{ Form::nyelect('account_transaction_id', @$accountTransaction, isset($item['account_transaction_id']) ? $item['account_transaction_id'] : null, 'Account Transaction') }}

        {{ Form::nyelect('item_type_id', @$itemType, isset($item['item_type_id']) ? $item['item_type_id'] : 1, 'Item Type') }}

        {{ Form::nyelect('unit_id', @$unitType, isset($item['unit_id']) ? $item['unit_id'] : 1, 'Unit Type') }}

        {{ Form::nginput('text', 'name', @$item['name'], 'Name') }}

        {{ Form::nginput('text', 'code', @$item['code'], 'Code') }}

        {{ Form::nginput('text', 'stock', @$item['stock'], 'Stock') }}

        {{ Form::nginput('text', 'description', @$access['description'], 'Description') }}

        {{ Form::nginput('text', 'price', @$item['price'], 'Price') }}

        {{ Form::nginput('text', 'vendor', @$item['vendor'], 'Vendor') }}

        {{ Form::nyelect('status', array(1 => 'Active', 0 => 'Inactive'), isset($item['status']) ? $item['status'] : 1, 'Status') }}

        <div class="formRow noBorderB">
            <div class="status" id="status3"></div>
            <div class="formSubmit">
                {{ HTML::link('item/index', 'Cancel', array( 'class' => 'buttonL bDefault mb10 mt5' )) }}
                {{ Form::submit('Save', array( 'class' => 'buttonL bGreen mb10 mt5' )) }}
            </div>
            <div class="clear"></div>
        </div>
    </div>

</fieldset>

{{ Form::close() }}

@endsection