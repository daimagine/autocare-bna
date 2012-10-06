@section('content')

@include('partial.notification')
<br>

{{ Form::open('/account/invoice_in', 'POST') }}

{{ Form::hidden('type', $accountTransType) }}

<fieldset>

    <div class="widget fluid">
        <div class="whead">
            <h6>Add Invoice {{ $accountTransType === 'D' ? 'Account Receivable' : 'Account Payable' }}</h6>

            <div class="clear"></div>
        </div>

        {{ Form::nginput('text', 'subject', Input::old('subject'), $accountTransType === 'D' ? 'To *' : ($accountTransType === 'C' ? 'From *' : 'Subject *') ) }}

        {{ Form::nginput('text', 'invoice_no', $invoiceNumber, 'Invoice', array( 'readonly' => 'readonly' )) }}

        {{ Form::nginput('text', 'reference_no', Input::old('reference_no'), 'Reference *') }}

        <div class="formRow">
            <div class="grid3"><label>Invoice Date *</label></div>
            <div class="grid9">
                <ul class="timeRange">
                    <li><input name="invoice_date" type="text" class="datepicker" value="{{ Input::old('invoice_date') }}" /></li>
                    <li class="sep">-</li>
                    <li><input name="invoice_time" type="text" class="timepicker" size="10" value="{{ Input::old('invoice_time') }}" />
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
                    <li><input name="due_date" type="text" class="datepicker" value="{{ Input::old('due_date') }}" /></li>
                    <li class="sep">-</li>
                    <li><input name="due_time" type="text" class="timepicker" size="10" value="{{ Input::old('due_time') }}" />
                        <span class="ui-datepicker-append">(hh:mm:ss)</span>
                    </li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>

        {{ Form::nyelect('status', array(1 => 'Active', 0 => 'Inactive'), Input::old('subject') !== null ? Input::old('status') : 1, 'Status') }}

        {{ Form::nginput('text', 'description', Input::old('description'), 'Description') }}

        <div class="formRow noBorderB">
            <div class="status" id="status3"></div>
            <div class="formSubmit">
                {{ HTML::link( $accountTransType === 'D' ? 'account/account_receivable' : 'account/account_payable', 'Cancel', array( 'class' => 'buttonL bDefault mb10 mt5' )) }}
                {{ Form::submit('Save', array( 'class' => 'buttonL bGreen mb10 mt5' )) }}
            </div>
            <div class="clear"></div>
        </div>
    </div>

</fieldset>

{{ Form::close() }}

@endsection