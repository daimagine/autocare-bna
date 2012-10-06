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

        {{ Form::nginput('text', 'subject', $account->subject, $accountTransType === 'D' ? 'To *' : ($accountTransType === 'C' ? 'From *' : 'Subject *') ) }}

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