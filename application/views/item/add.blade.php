@section('content')

@include('partial.notification')
<br>

<ul class="middleNavA">
    @foreach($allItemCategory as $category)
    <li><a href="add?category={{$category->id}}" title="{{$category->name}}" style="width: 100px;height: 65px;"><img src="../images/icons/color/config.png" alt="" /><span style="@if($itemCategory->name == $category->name) color:red @endif">{{$category->name}}</span></a></li>
    @endforeach
</ul>
<div class="divider"><span></span></div>

{{ Form::open('item/add', 'POST', array('id' => 'validate')) }}

<fieldset>

    <div class="widget fluid">
        <div class="whead">
            <h6>Add Item {{$itemCategory->name}}</h6>

            <div class="clear"></div>
        </div>

        {{ Form::hidden('item_category_id', $itemCategory->id) }}

        {{ Form::nyelect('item_type_id', @$itemType, isset($item['item_type_id']) ? $item['item_type_id'] : 1, 'Item Type', array('class' => 'validate[required]')) }}

        {{ Form::nyelect('unit_id', @$unitType, isset($item['unit_id']) ? $item['unit_id'] : 1, 'Unit Type', array('class' => 'validate[required]')) }}

        {{ Form::nginput('text', 'name', @$item['name'], 'Name', array('class' => 'validate[required]')) }}

        {{ Form::nginput('text', 'code', @$item['code'], 'Code', array('class' => 'validate[required]')) }}

        @if($accountTransaction!=null)
        {{ Form::nyelect('account_transaction_id', @$accountTransaction, isset($item['account_transaction_id']) ? $item['account_transaction_id'] : null, 'Account Transaction', array('class' => 'validate[required]')) }}

        {{ Form::nginput('text', 'stock', @$item['stock'], 'Stock', array('class' => 'validate[required]')) }}
        @endif

        {{ Form::nginput('text', 'description', @$access['description'], 'Description', array('class' => 'validate[required]')) }}

        {{ Form::nginput('text', 'price', @$item['price'], 'Price', array('class' => 'validate[required,custom[onlyNumberSp]]')) }}

        {{ Form::nginput('text', 'vendor', @$item['vendor'], 'Vendor', array('class' => 'validate[required]')) }}

        {{ Form::nyelect('status', array(1 => 'Active', 0 => 'Inactive'), isset($item['status']) ? $item['status'] : 1, 'Status') }}

        <div class="formRow noBorderB">
            <div class="status" id="status3"></div>
            <div class="formSubmit">
                {{ HTML::link('item/list?category='.$itemCategory->id, 'Cancel', array( 'class' => 'buttonL bDefault mb10 mt5' )) }}
                {{ Form::submit('Save', array( 'class' => 'buttonL bGreen mb10 mt5' )) }}
            </div>
            <div class="clear"></div>
        </div>
    </div>

</fieldset>

{{ Form::close() }}

@endsection