@section('content')

@include('partial.notification')
<br>


{{ Form::open('item/edit', 'POST', array('id' => 'validate')) }}

<fieldset>

    <div class="widget fluid">
        <div class="whead">
            <h6>Edit Item {{$category->name}}</h6>

            <div class="clear"></div>
        </div>

        {{ Form::hidden('id', $item->id) }}

        {{ Form::hidden('item_category_id', $category->id) }}

        {{ Form::nyelect('item_type_id', $itemType, $item->item_type_id, 'Item Type', array('class' => 'validate[required]')) }}

        {{ Form::nyelect('unit_id', $unitType, $item->unit_id, 'Unit Type', array('class' => 'validate[required]')) }}

        {{ Form::nginput('text', 'name', $item->name, 'Name', array('class' => 'validate[required]')) }}

        {{ Form::nginput('text', 'code', $item->code, 'Code', array('class' => 'validate[required]')) }}

        {{ Form::nginput('text', 'description', $item->description, 'Description', array('class' => 'validate[required]')) }}

        {{ Form::nginput('text', 'price', $item->price, 'Price', array('class' => 'validate[required,custom[onlyNumberSp]]')) }}

        {{ Form::nginput('text', 'vendor', $item->vendor, 'Vendor', array('class' => 'validate[required]')) }}

        {{ Form::nyelect('status', array(1 => 'Active', 0 => 'Inactive'), $item->status, 'Status', array('class' => 'validate[required]')) }}

        <div class="formRow noBorderB">
            <div class="status" id="status3"></div>
            <div class="formSubmit">
                {{ HTML::link('item/list?category='.$category->id, 'Cancel', array( 'class' => 'buttonL bDefault mb10 mt5' )) }}
                {{ Form::submit('Save', array( 'class' => 'buttonL bGreen mb10 mt5' )) }}
            </div>
            <div class="clear"></div>
        </div>
    </div>

</fieldset>

{{ Form::close() }}

@endsection