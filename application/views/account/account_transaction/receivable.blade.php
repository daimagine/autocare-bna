@section('content')

@include('partial.notification')

<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>Account Payable List</h6>
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
                <td>IDR {{ $account->paid }}</td>
                <td>IDR {{ $account->due }}</td>
                <td class="tableActs" align="center">
                    @if($account->status)
                    <a href="#" class="fs1 iconb tipS" original-title="Active" data-icon=""></a>
                    @endif
                </td>
                <td class="tableActs" align="center">
                    <a href="/account/invoice_edit/{{ $accountTransType }}/{{ $account->id }}" class="tablectrl_small bDefault tipS" original-title="Edit"><span class="iconb" data-icon=""></span></a>
                    <a href="/account/invoice_delete/{{ $accountTransType }}/{{ $account->id }}" class="tablectrl_small bDefault tipS" original-title="Remove"><span class="iconb" data-icon=""></span></a>
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
            <span>Add Account Payable</span>
        </a></div>
    </div>
</div>

@endsection