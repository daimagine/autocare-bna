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
        <h6>Account Report :: Monthly</h6>
        <div class="clear"></div>
    </div>

    <form method="get" id="formList">
        <div class="fluid grid">
            <div class="formRow noBorderB">
                <div class="grid6">
                    <ul class="timeRange">
                        <li style="width:120px; margin-top:2px;">Start Date</li>
                        <li>
                            <input name="startdateDisplay" type="text" class="monthpicker" value="{{ date('F Y', strtotime($startdate)) }}" data-mask="startdate"/>
                            <input type="hidden" id="startdate" name="startdate" value="{{ $startdate }}"/>
                        </li>
                    </ul>
                    <div class="clear"></div>
                    <ul class="timeRange fixoptTime">
                        <li style="width:120px;">Type</li>
                        <li>
                            <select name="type">
                                <option value="">All</option>
                                <option value="{{ AUTOCARE_ACCOUNT_TYPE_DEBIT }}"
                                {{ $type == AUTOCARE_ACCOUNT_TYPE_DEBIT ? 'selected="selected"' : '' }}>Income</option>
                                <option value="{{ AUTOCARE_ACCOUNT_TYPE_CREDIT }}"
                                {{ $type == AUTOCARE_ACCOUNT_TYPE_CREDIT ? 'selected="selected"' : '' }}>Expenditur</option>
                            </select>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>

                <div class="grid6">
                    <ul class="timeRange">
                        <li style="width:120px; margin-top:2px;">End Date</li>
                        <li>
                            <input name="enddateDisplay" type="text" class="monthpicker" value="{{ date('F Y', strtotime($enddate)) }}" data-mask="enddate"/>
                            <input type="hidden" id="enddate" name="enddate" value="{{ $enddate }}"/>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>
        </div>
        <div class="fluid grid">
            <div class="formRow noBorderB">
                <div class="grid">
                    <ul class="timeRange">
                        <li><input type="submit" class="buttonS bLightBlue" value="Search"></li>
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
                <th>Year<span class="sorting" style="display: block;"></span></th>
                <th>Month<span class="sorting" style="display: block;"></span></th>
                <th>Account Name</th>
                <th>Count</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($accounts as $account)
            <tr class="">
                <td>{{ $account->year }}</td>
                <td>{{ $account->monthname }}</td>
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

<style type="text/css">
    .ui-datepicker-calendar {
        display: none;
    }
</style>

@endsection