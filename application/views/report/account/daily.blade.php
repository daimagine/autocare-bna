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
            <h6>Account Report :: Daily</h6>
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
                    <th>Account Name</th>
                    <th>Due Date</th>
                    <th>Invoice No</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Input By</th>
                    <th style="min-width: 79px">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accounts as $account)
                <tr class="">
                    <td>{{ date('Y-m-d', strtotime($account->invoice_date)) }}</td>
                    <td>{{ $account->account->name }}</td>
                    <td>{{ date('Y-m-d', strtotime($account->due_date)) }}</td>
                    <td>{{ $account->invoice_no }}</td>
                    <td>IDR {{  number_format($account->paid, 2) }}</td>
                    <td>{{ $account->type === AUTOCARE_ACCOUNT_TYPE_DEBIT ? 'Debit'  : 'Credit' }}</td>
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

    <!-- Bars chart -->
    <div class="widget grid6 chartWrapper">
        <div class="whead"><h6>Statistics Overview</h6><div class="clear"></div></div>
        <div class="body"><div class="bars" id="placeholder1"></div></div>
    </div>


@endsection



@section('additional_js')

    <script type="text/javascript">

        $(function () {
            var previousPoint;

            /**
             * <?php //echo htmlentities(print_r($graphData, true)); ?>
             */

<!--            var datas = --><?php //echo json_encode($graphData) ?><!--;-->
<!--            console.log('data');-->
<!--            console.log(datas);-->

            var ds = new Array();
            var d = new Array();
            var dmin = new Date('2012-09-30').getTime();
            var dmax = new Date('2012-10-5').getTime();
            <?php foreach($graphData as $key => $d) : ?>
                d[0] = '<?php echo $key ?>';
                d[1] = new Array();
                <?php foreach($d as $date => $val) : ?>
                    if(dmin > new Date('<?php echo $date ?>').getTime()) {
                        dmin = new Date('<?php echo $date ?>').getTime();
                    }
                    if(dmax < new Date('<?php echo $date ?>').getTime()) {
                        dmax = new Date('<?php echo $date ?>').getTime();
                    }
                    d[1].push([ new Date('<?php echo $date ?>').getTime(), parseFloat(<?php echo $val ?>) ]);
                <?php endforeach; ?>
                console.log(d);
                ds.push(d);
                d = new Array();
            <?php endforeach; ?>
            console.log('data store');
            console.log(ds);

            var dsa = new Array();
            $.each(ds, function(i, obj) {
                console.log("ds ke " + i);
                console.log(obj[0]);
                console.log(obj[1]);
                dsa.push(
                    {
                        data: obj[1],
                        bars: {
                            show: true,
                            barWidth: 1 * 60 * 60 * 1000,
                            order: i
                        },
                        label: obj[0]
                    }
                );
            });
            //Display graph
            $.plot($("#placeholder1"), dsa, {
                grid:{
                    hoverable:true
                },
                legend: true,
                xaxis: {
                    mode: "time",
                    minTickSize: [1, "day"],
                    min: dmin,
                    max: dmax
                }
            });

            //tooltip function
            function showTooltip(x, y, contents, areAbsoluteXY) {
                var rootElt = 'body';

                $('<div id="tooltip2" class="tooltip">' + contents + '</div>').css( {
                    position: 'absolute',
                    display: 'none',
                    top: y - 35,
                    left: x - 5,
                    'z-index': '9999',
                    'color': '#fff',
                    'font-size': '11px',
                    opacity: 0.8
                }).prependTo(rootElt).show();
            }

            //add tooltip event
            $("#placeholder1").bind("plothover", function (event, pos, item) {
                if (item) {
                    if (previousPoint != item.datapoint) {
                        previousPoint = item.datapoint;

                        //delete de prГ©cГ©dente tooltip
                        $('.tooltip').remove();

                        var x = item.datapoint[0];

                        //All the bars concerning a same x value must display a tooltip with this value and not the shifted value
                        if(item.series.bars.order){
                            for(var i=0; i < item.series.data.length; i++){
                                if(item.series.data[i][3] == item.datapoint[0])
                                    x = item.series.data[i][0];
                            }
                        }
                        var d = new Date(x);
                        x = $.datepicker.formatDate('dd MM yy', d);;
                        var y = "IDR " + item.datapoint[1];

                        showTooltip(item.pageX+5, item.pageY+5, x + " = " + y);

                    }
                }
                else {
                    $('.tooltip').remove();
                    previousPoint = null;
                }

            });


        });
    </script>

@endsection