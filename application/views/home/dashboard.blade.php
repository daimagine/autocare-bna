@section('content')

@include('partial.notification')

<div class="fluid">

    <div class="grid8">

        <div class="searchLine">
            <div>
                <span class="icos-archive"></span>
                <h6 style="margin-bottom: 5px;">Recent News</h6>
            </div>
            <div class="clear"></div>

            <div class="relative">
                <input id="searchInputNews" type="text" name="search" class="ac" placeholder="Enter search text...">
                <button id="searchInputBtn" type="submit" name="find" value="">
                    <span class="icos-search"></span>
                </button>
            </div>
            <div class="sResults">
                <span class="arrow"></span>
                <ul class="updates">
                    @foreach($news as $n)
                    <li class="newsline">
                                <span class="uNotice">
                                    <a href="#detail" onclick="detailNews('{{ $n->id }}')">{{ $n->title }}</a>
                                    <span>{{ $n->resume }} ...</span>
                                </span>
                                <span class="uDate"><span>{{ date('d', strtotime($n->created_at)) }}</span>
                                    {{ date('M', strtotime($n->created_at)) }}</span>
                        <span class="clear"></span>
                    </li>
                    @endforeach
                    <li>
                            <span class="">
                                <a href="/news/all" title="">Show All News</a>
                            </span>
                        <span class="clear"></span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="widget">
            <div class="whead">
                <h6>Recent Membership</h6>
                <div class="titleOpt">
                    <a href="#" data-toggle="dropdown"><span class="iconb" data-icon=""></span><span class="clear"></span></a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="member/index" class=""><span class="icon-list"></span>All Membership List</a></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <table cellpadding="0" cellspacing="0" width="100%" class="tAlt">
                <thead>
                <tr>
                    <td width="">Vehicle</td>
                    <td>Customer</td>
                    <td width="">Membership</td>
                </tr>
                </thead>
                <tbody>
                @foreach($members as $m)
                <tr>
                    <td align="center"><a href="#" title="" class="webStatsLink">{{ $m->vehicle->number }}</a></td>
                    <td>{{ $m->customer->name }}</td>
                    <td align=""><span class="icos-postcard"></span>{{ $m->description }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>


    <div class="grid4">

        <div class="widget">
            <div class="whead">
                <h6>Settlement Notices</h6>
                <div class="clear"></div>
            </div>
            <div class="body">
                <ul class="wInvoice">
                    <li style="width:50%"><h4 class="red">{{ number_format($settlements[SettlementState::UNSETTLED]) }}</h4><span class="red">Unsettled</span></li>
                    <li style="width:50%"><h4 class="blue">{{ number_format($settlements[SettlementState::SETTLED_UNMATCH]) }}</h4><span class="blue">Unmatch</span></li>
                </ul>
                <div class="clear"></div>

                <div class="invList fluid">
                    <a href="settlement/list" title="" class="floatR buttonS bLightBlue">Process Settlement</a>
                </div>
                <div class="clear"></div>
            </div>
        </div>

        <!--        <div class="widget">-->
<!--            <div class="whead">-->
<!--                <h6>Invoices statistics</h6>-->
<!--                <div class="titleOpt">-->
<!--                    <a href="#" data-toggle="dropdown"><span class="iconb" data-icon=""></span><span class="clear"></span></a>-->
<!--                    <ul class="dropdown-menu pull-right">-->
<!--                        <li><a href="#" class=""><span class="icon-plus"></span>Add</a></li>-->
<!--                        <li><a href="#" class=""><span class="icon-remove"></span>Remove</a></li>-->
<!--                        <li><a href="#" class=""><span class="icon-pen_alt2"></span>Edit</a></li>-->
<!--                        <li><a href="#" class=""><span class="icon-heart"></span>Do whatever you like</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--                <div class="clear"></div>-->
<!--            </div>-->
<!--            <div class="body">-->
<!--                <ul class="wInvoice">-->
<!--                    <li><h4 class="green">63,456</h4><span>amount paid</span></li>-->
<!--                    <li><h4 class="blue">218,518</h4><span>in queue</span></li>-->
<!--                    <li><h4 class="red">16,542</h4><span>total taxes</span></li>-->
<!--                </ul>-->
<!--                <div class="clear"></div>-->
<!---->
<!--                <div class="invList fluid">-->
<!--                    <a href="#" title="" class="buttonS bGreen grid6">Print invoices</a>-->
<!--                    <a href="#" title="" class="buttonS bLightBlue grid6">Generate report</a>-->
<!--                </div>-->
<!--                <div class="clear"></div>-->
<!--            </div>-->
<!--        </div>-->

    </div>

</div>

<div id="detailNews" class="dialog" title="Detail News" ></div>


@endsection