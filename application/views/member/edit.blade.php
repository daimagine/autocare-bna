@section('content')


@include('partial.notification')
<br>

{{ Form::open('member/edit', 'POST') }}

<fieldset>

    <div class="widget fluid">
        <div class="whead">
            <h6>Member Add</h6>

            <div class="clear"></div>
        </div>

        {{ Form::hidden('id', $member->id) }}

        {{ Form::nginput('text', 'number', $member->number, 'Number') }}

        {{ Form::nyelect('status', array(1 => 'Active', 0 => 'Inactive'), $member->status, 'Status') }}

        <div class="formRow noBorderB">
            <div class="status" id="status3"></div>
            <div class="formSubmit">
                {{ HTML::link('member/index', 'Cancel', array( 'class' => 'buttonL bDefault mb10 mt5' )) }}
                {{ Form::submit('Save', array( 'class' => 'buttonL bGreen mb10 mt5' )) }}
            </div>
            <div class="clear"></div>
        </div>
    </div>

</fieldset>

{{ Form::close() }}

@endsection
