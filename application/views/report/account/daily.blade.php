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

            var content = new Array();
            var idx = 0;

            @foreach($accounts as $account)
            var d = [];
            d.push([
                "{{ date('Y-m-d', strtotime($account->invoice_date)) }}",
                toFixed("{{  number_format($account->paid, 2) }}", 2)
            ]);
            content[idx] = d;
            idx++;

            @endforeach

            //console.log(content);

            <?php
                $ct = array();
                $data = array();
                foreach($accounts as $account) {
                    if(!in_array($account->account->name, $ct))
                        array_push($ct, $account->account->name);
                }
                //echo print_r($ct, true) . "\n";
                foreach($ct as $c) {
                    echo "//satu ". $c. "\n";
                    foreach($accounts as $account) {
                        $idx = date('Y-m-d', strtotime($account->invoice_date));
                        echo "//idx ". $idx. "\n";
                        echo "//pre-sub ". @$data[$c][$idx] . "\n";
                        if($c === $account->account->name) {
                            echo "//dua ". $c . " sama \n";
                            if(array_key_exists($c, $data)) {
                                if(array_key_exists($idx, $data[$c])) {
                                    echo "//dua satu ". $idx . " ada \n";
                                    $data[$c][$idx] = $account->paid + $data[$c][$idx];
                                } else {
                                    echo "//dua dua ". $idx . " ga ada \n";
                                    $data[$c][$idx] = $account->paid;
                                }
                            } else {
                                echo "//dua tiga ". $c . " ga ada \n";
                                $data[$c][$idx] = $account->paid;
                            }
                        } else {
                            echo "//tiga ". $c . " ga sama \n";
                            if(array_key_exists($c, $data)) {
                                if(array_key_exists($idx, $data[$c])) {
                                    echo "//tiga satu ". $idx . " ada \n";
                                } else {
                                    echo "//tiga dua ". $idx . " ga ada \n";
                                    $data[$c][$idx] = 0;
                                }
                            } else {
                                echo "//tiga tiga ". $c . " ga ada \n";
                                $data[$c][$idx] = 0;
                            }
                        }
                        echo "//val ". $account->paid . "\n";
                        echo "//sub ". $data[$c][$idx] . "\n";
                        echo "\n";
                    }
                    echo "\n//-----\n";
                }

            ?>

            <?php
                /**
                 * format :
                 *      2012-01-01
                 *          cash in  : 9000
                 *          cash out : 4900
                 *      2012-01-02
                 *          cash in  : 5000
                 *          cash out : 3000
                 */
            ?>

            var datas = <?php echo json_encode($data) ?>;
            console.log(datas);


            var d1 = [];
            for (var i = 0; i <= 10; i += 1)
                d1.push([i, parseInt(Math.random() * 30)]);

            var d2 = [];
            for (var i = 0; i <= 10; i += 1)
                d2.push([i, parseInt(Math.random() * 30)]);

            var d3 = [];
            for (var i = 0; i <= 10; i += 1)
                d3.push([i, parseInt(Math.random() * 30)]);

//            d1 = [['5',2], ['6',20], ['7',21]];
//            d2 = [['5',3], ['6',21], ['7',22]];
//            d3 = [['5',2], ['6',24], ['7',12]];

            console.log(d1);
            console.log(d2);
            console.log(d3);

            var ds = new Array();

            ds.push({
                data:d1,
                bars: {
                    show: true,
                    barWidth: 0.2,
                    order: 1
                },
                label: "tes1"
            });
            ds.push({
                data:d2,
                bars: {
                    show: true,
                    barWidth: 0.2,
                    order: 2
                },
                label: "tes2"
            });
            ds.push({
                data:d3,
                bars: {
                    show: true,
                    barWidth: 0.2,
                    order: 3
                },
                label: "tes3"
            });

//            ds = new Array();
            var idx = 1;
            $.each(datas, function(i, obj) {
                console.log(i);
                console.log(obj);
                var d6 = [];
//                $.each(obj, function(j, d) {
//
//                }
//                ds.push({
//                    data:obj,
//                    bars: {
//                        show: true,
//                        barWidth: 0.2,
//                        order: idx
//                    }
//                });
                console.log(d6);
                console.log(idx);
                idx++;
            });

            console.log(ds);

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

            //Display graph
            $.plot($("#placeholder1"), ds, {
                grid:{
                    hoverable:true
                },
                legend: true
            });


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

                        var y = item.datapoint[1];

                        showTooltip(item.pageX+5, item.pageY+5,x + " = " + y);

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