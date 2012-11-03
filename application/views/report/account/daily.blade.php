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
            <h6>Account Report</h6>
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
            <table cellpadding="0" cellspacing="0" border="0" class="dTableAccount" dtable-sortlist="[[0,'desc']]">
                <thead>
                <tr>
                    <th>Invoice Date<span class="sorting" style="display: block;"></span></th>
                    <th>Due Date</th>
                    <th>Invoice No</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Account Name</th>
                    <th>Description</th>
                    <th>Input By</th>
                    <th style="min-width: 79px">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accounts as $account)
                <tr class="">
                    <td>{{ date('Y-m-d', strtotime($account->invoice_date)) }}</td>
                    <td>{{ date('Y-m-d', strtotime($account->due_date)) }}</td>
                    <td>{{ $account->invoice_no }}</td>
                    <td>IDR {{  number_format($account->paid, 2) }}</td>
                    <td>{{ $account->type === AUTOCARE_ACCOUNT_TYPE_DEBIT ? 'Debit'  : 'Credit' }}</td>
                    <td>{{ $account->account->name }}</td>
                    <td>{{ $account->description }}</td>
                    <td>{{ $account->user->name }}</td>
                    <td class="tableActs" align="center">
                        <a href="/account/invoice_edit/{{ $account->type }}/{{ $account->id }}"
                           class="appconfirm tablectrl_small bDefault tipS"
                           original-title="Edit"
                           dialog-confirm-title="Update Confirmation">
                            <span class="iconb" data-icon=""></span>
                        </a>
                        <a href="/account/pay_invoice/{{ $account->type }}/{{ $account->id }}"
                           class="appconfirm tablectrl_small bDefault tipS"
                           original-title="Pay Invoice"
                           dialog-confirm-title="Payment Confirmation">
                            <span class="iconb" data-icon=""></span>
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="clear"></div>
    </div>

@endsection