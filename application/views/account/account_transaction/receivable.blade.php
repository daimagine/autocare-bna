@section('content')

@include('partial.notification')

<ul class="middleNavA">
    <li><a href="/account/account_receivable" title="All Receivable Account"><img src="/images/icons/color/refresh.png" alt=""><span>All</span></a></li>
    <li><a href="/account/invoice_in" title="Add invoice"><img src="/images/icons/color/plus.png" alt=""><span>Add invoice</span></a></li>
    <li><a href="/account/account_receivable/unpaid" title="Awaiting payment"><img src="/images/icons/color/full-time.png" alt=""><span>Awaiting payment</span></a></li>
    <li><a href="/account/account_receivable/paid" title="Paid invoice"><img src="/images/icons/color/cost.png" alt=""><span>Paid invoice</span></a></li>
</ul>
<div class="divider"><span></span></div>

<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>Account Receivable List</h6>
        <div class="clear"></div>
    </div>
    <div id="dyn2" class="shownpars">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTable">
            <thead>
            <tr>
                <th>Invoice No<span class="sorting" style="display: block;"></span></th>
                <th>Reference No</th>
                <th>To</th>
                <th>Input Date</th>
                <th>Invoice Date</th>
                <th>Due Date</th>
                <th>Paid</th>
                <th>Due</th>
                <th>Attributes</th>
                <th>Action</th>
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
                <td class="tableActs" align="center">
                    @if($account->status)
                    <a href="#" class="fs1 iconb tipS" original-title="Active" data-icon=""></a>
                    @endif
                </td>
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
        <div class="wButton"><a href="/account/invoice_in" title="" class="buttonL bLightBlue first">
            <span class="icol-add"></span>
            <span>Add Account Receivable</span>
        </a></div>
    </div>
</div>

@endsection
