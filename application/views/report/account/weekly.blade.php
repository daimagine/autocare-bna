@section('content')

@include('partial.notification')

@include('partial.report.middlenav')

<div class="clear"></div>
<div class="divider"><span></span></div>

@include('partial.report.account_middlenav')

<div class="clear"></div>
<div class="divider"><span></span></div>


<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>Account Report :: Weekly</h6>
        <div class="clear"></div>
    </div>

    <form method="get">
        <div class="fluid">
            <div class="formRow">
                <div class="grid">
                    <ul class="timeRange">
                        <li style="margin-top:2px;">Start Date&nbsp;&nbsp;&nbsp;</li>
                        <li><input name="startdate" type="text" class="datepicker" value="{{ $startdate }}" /></li>

                        <li style="margin-top:2px;">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;End Date&nbsp;&nbsp;&nbsp;</li>
                        <li><input name="enddate" type="text" class="datepicker" value="{{ $enddate }}" /></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div class="formRow">
                <div class="grid">
                    <ul class="timeRange">
                        <li>Type&nbsp;&nbsp;&nbsp;</li>
                        <li>
                            <select name="type">
                                <option value="">All</option>
                                <option value="{{ AUTOCARE_ACCOUNT_TYPE_DEBIT }}"
                                {{ $type == AUTOCARE_ACCOUNT_TYPE_DEBIT ? 'selected="selected"' : '' }}>Income</option>
                                <option value="{{ AUTOCARE_ACCOUNT_TYPE_CREDIT }}"
                                {{ $type == AUTOCARE_ACCOUNT_TYPE_CREDIT ? 'selected="selected"' : '' }}>Expenditur</option>
                            </select>
                        </li>
                        <li style="margin-left: 50px;"><input type="submit" class="buttonS bLightBlue" value="Search"></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </form>

    <div class="divider"><span></span></div>

    <div id="dyn2" class="shownpars overflowtable">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTableAccountMin" dtable-sortlist="[[0,'desc']]">
            <thead>
            <tr>
                <th>Date Range<span class="sorting" style="display: block;"></span></th>
                <th>Account Name</th>
                <th>Count</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($accounts as $account)
            <tr class="">
                <td>{{ date('Y-m-d', strtotime($account->week_start)) }} - {{ date('Y-m-d', strtotime($account->week_end)) }}</td>
                <td>{{ $account->name }}</td>
                <td>{{ $account->count }}</td>
                <td>IDR {{  number_format($account->amount, 2) }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
</div>

@endsection