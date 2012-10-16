@section('content')

@include('partial.notification')

<ul class="middleNavA">
    <li><a href="/account/account_payable" title="All Payable Account"><img src="/images/icons/color/refresh.png" alt=""><span>All</span></a></li>
    <li><a href="/account/invoice_in/C" title="Add invoice"><img src="/images/icons/color/plus.png" alt=""><span>Add invoice</span></a></li>
    <li><a href="/account/account_payable/unpaid" title="Awaiting payment"><img src="/images/icons/color/full-time.png" alt=""><span>Awaiting payment</span></a></li>
    <li><a href="/account/account_payable/paid" title="Paid invoice"><img src="/images/icons/color/cost.png" alt=""><span>Paid invoice</span></a></li>
</ul>
<div class="divider"><span></span></div>

<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>Account Payable List</h6>
        <div class="clear"></div>
    </div>
    <div id="dyn2" class="shownpars overflowtable">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTable">
            <thead>
            <tr>
                <th>Invoice No<span class="sorting" style="display: block;"></span></th>
                <th>Reference No</th>
                <th>From</th>
                <th>Input Date</th>
                <th>Invoice Date</th>
                <th>Due Date</th>
                <th>Paid</th>
                <th>Due</th>
                <th>Status</th>
                <th style="min-width: 79px">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($accounts as $account)
            <tr class="">
                <td>{{ $account->invoice_no }}</td>
                <td>{{ $account->reference_no }}</td>
                <td>{{ $account->subject }}</td>
                <td>{{ $account->input_date }}</td>
                <td>{{ $account->invoice_date }}</td>
                <td>{{ $account->due_date }}</td>
                <td>{{ $account->paid !== null ? 'IDR' : '' }} {{ $account->paid }}</td>
                <td>{{ $account->due !== null ? 'IDR' : '' }} {{ $account->due }}</td>
                <td>{{ $account->paid_date !== null ? 'paid' : 'awaiting payment' }}</td>
                <td class="tableActs" align="center">
                    <a href="/account/invoice_edit/{{ $accountTransType }}/{{ $account->id }}"
                       class="appconfirm tablectrl_small bDefault tipS"
                       original-title="Edit"
                       dialog-confirm-title="Update Confirmation">
                        <span class="iconb" data-icon=""></span>
                    </a>
                    <a href="/account/invoice_delete/{{ $accountTransType }}/{{ $account->id }}"
                       class="appconfirm tablectrl_small bDefault tipS"
                       original-title="Remove"
                       dialog-confirm-title="Remove Confirmation">
                        <span class="iconb" data-icon=""></span>
                    </a>
                    @if($account->due == 0 || $account->paid <> $account->due)
                        <a href="/account/pay_invoice/{{ $accountTransType }}/{{ $account->id }}"
                           class="appconfirm tablectrl_small bDefault tipS"
                           original-title="Pay Invoice"
                           dialog-confirm-title="Payment Confirmation">
                            <span class="iconb" data-icon=""></span>
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
</div>

<div class="fluid">
    <div class="grid2">
        <div class="wButton"><a href="/account/invoice_in/C" title="" class="buttonL bLightBlue first">
            <span class="icol-add"></span>
            <span>Add Account Payable</span>
        </a></div>
    </div>
</div>

@endsection
