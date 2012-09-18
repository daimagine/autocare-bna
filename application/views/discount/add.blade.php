@section('content')

@include('partial.notification')
<br>

{{ Form::open('/discount/add', 'POST') }}

<fieldset>

    <div class="widget fluid">
        <div class="whead">
            <h6>Discount Add</h6>

            <div class="clear"></div>
        </div>

        {{ Form::nginput('text', 'name', @$discount['name'], 'Name') }}

        {{ Form::nginput('text', 'value', @$discount['value'], 'Value') }}

        {{ Form::nyelect('status', array(1 => 'Active', 0 => 'Inactive'), isset($discount['status']) ? $discount['status'] : 1, 'Status') }}

        {{ Form::nginput('text', 'description', @$discount['description'], 'Description') }}

        <div class="formRow noBorderB">
            <div class="status" id="status3"></div>
            <div class="formSubmit">
                {{ HTML::link('discount/index', 'Cancel', array( 'class' => 'buttonL bDefault mb10 mt5' )) }}
                {{ Form::submit('Save', array( 'class' => 'buttonL bGreen mb10 mt5' )) }}
            </div>
            <div class="clear"></div>
        </div>
    </div>

</fieldset>

{{ Form::close() }}

@endsection