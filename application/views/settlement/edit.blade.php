@section('content')

@include('partial.notification')
<br>

{{ Form::open('settlement/edit', 'POST', array( 'name' => 'formSettlement' ) ) }}

{{ Form::hidden('id', $settlement->id) }}

<fieldset>
    <div class="widget fluid">
        <div class="whead">
            <h6>Transaction Settlement</h6>

            <div class="clear"></div>
        </div>

        <div class="inContainer">
            <div class="fluid">
                <div class="grid6">
                    <div class="inFrom" style="width: 90%; margin-bottom: 0px;">
                        <h5>Settlement Date : <strong class="red">{{ date('d F Y', strtotime($settlement->settlement_date)) }}</strong></h5>
<!--                        <span class="black">Total from Transaction <a href="#">IDR {{ number_format($total_transaction, 2) }}</a></span>-->
                        <span>Settlement is <strong id="settlement-state">Unmatch</strong></span>
                    </div>

                    <div class="total-left">
                        <span>Trans Amount</span>
                        <strong class="greyBack textR" id="total-transaction-amount">{{ number_format($total_transaction, 2) }}</strong>
                    </div>

                    <div class="total-left">
                        <span>Total Amount</span>
                        <strong class="greenBack textR" id="total-amount">{{ number_format($settlement->amount_cash, 2) }}</strong>
                        <em><a href="#recalculate" onclick="Settlement.recalculateAmount();">recalculate</a></em>
                    </div>
                </div>
                <div class="grid6">
                    <div class="inFrom" style="width: 90%;">

                        {{ Form::hidden('state', SettlementState::SETTLED) }}

                        {{ Form::hidden('settlement_date', date('Y-m-d', strtotime($settlement->settlement_date))) }}

                        {{ Form::nginput('text', 'amount_cash',  $settlement->amount_cash, 'Amount in Cash', array( 'class' => 'calculate-total', 'id' => 'amount-cash' )) }}

                        {{ Form::nginput('text', 'amount_non_cash',  $settlement->amount_non_cash, 'Amount non Cash', array( 'class' => 'calculate-total', 'id' => 'amount-non-cash' )) }}

                        <em>Amount information above will be summarized into total transaction on the left side. Click <strong>recalculate</strong> if total transaction is not updated automatically</em>
                    </div>
                </div>
            </div>

            <div class="clear"></div>
        </div>

        <div class="divider"></div>

        <div class="fluid">
            <div class="grid6">

                <div class="formRow">
                    <div class="grid3"><label>IDR 100,000</label></div>
                    <div class="grid9">
                        <input name="fraction_100000" type="text" class="fraction" value="{{ $settlement->fraction_100000 }}" />
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <div class="grid3"><label>IDR 50,000</label></div>
                    <div class="grid9">
                        <input name="fraction_50000" type="text" class="fraction" value="{{ $settlement->fraction_50000 }}" />
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <div class="grid3"><label>IDR 20,000</label></div>
                    <div class="grid9">
                        <input name="fraction_20000" type="text" class="fraction" value="{{ $settlement->fraction_20000 }}" />
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <div class="grid3"><label>IDR 10,000</label></div>
                    <div class="grid9">
                        <input name="fraction_10000" type="text" class="fraction" value="{{ $settlement->fraction_10000 }}" />
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <div class="grid3"><label>IDR 5,000</label></div>
                    <div class="grid9">
                        <input name="fraction_5000" type="text" class="fraction" value="{{ $settlement->fraction_5000 }}" />
                    </div>
                    <div class="clear"></div>
                </div>

            </div>

            <div class="grid6">

                <div class="formRow">
                    <div class="grid3"><label>IDR 2,000</label></div>
                    <div class="grid9">
                        <input name="fraction_2000" type="text" class="fraction" value="{{ $settlement->fraction_2000 }}" />
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <div class="grid3"><label>IDR 1,000</label></div>
                    <div class="grid9">
                        <input name="fraction_1000" type="text" class="fraction" value="{{ $settlement->fraction_1000 }}" />
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <div class="grid3"><label>IDR 500</label></div>
                    <div class="grid9">
                        <input name="fraction_500" type="text" class="fraction" value="{{ $settlement->fraction_500 }}" />
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <div class="grid3"><label>IDR 100</label></div>
                    <div class="grid9">
                        <input name="fraction_100" type="text" class="fraction" value="{{ $settlement->fraction_100 }}" />
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <div class="grid3"><label>IDR 50</label></div>
                    <div class="grid9">
                        <input name="fraction_50" type="text" class="fraction" value="{{ $settlement->fraction_50 }}" />
                    </div>
                    <div class="clear"></div>
                </div>

            </div>
        </div>

        <div class="formRow noBorderB">
            <div class="status" id="status3"></div>
            <div class="formSubmit">
                {{ HTML::link('settlement/index', 'Cancel', array( 'class' => 'buttonL bDefault mb10 mt5' )) }}

                <input class="appconfirm buttonL bGreen mb10 mt5" type="submit" value="Save"
                       original-title="Confirmation"
                       dialog-confirm-title="Settlement Confirmation"
                       dialog-confirm-content="Please reassure that information is valid. Any unmatching data is your current responsibilities and may cause you to pay the for mismatch amount"
                       dialog-confirm-callback="document.forms.formSettlement.submit()">
            </div>
            <div class="clear"></div>
        </div>

    </div>
</fieldset>
{{ Form::close() }}

@endsection