@section('content')

@include('partial.notification')

@include('partial.report.middlenav')

<div class="clear"></div>
<div class="divider"><span></span></div>

@include('partial.report.finance_middlenav')

<div class="clear"></div>
<div class="divider"><span></span></div>


@include('partial.report.finance_part_middlenav')

<div class="clear"></div>
<div class="divider"><span></span></div>


<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>Finance Report :: Daily Parts</h6>
        <div class="clear"></div>
    </div>

    <form method="get" id="formList">
        <div class="fluid grid">
            <div class="formRow noBorderB">
                <div class="grid6">
                    <ul class="timeRange">
                        <li style="width:120px; margin-top:2px;">Start Date</li>
                        <li><input name="startdate" type="text" class="datepicker" value="{{ $startdate }}" /></li>
                    </ul>
                    <div class="clear"></div>
                    <ul class="timeRange fixoptTime">
                        <li style="width:120px;">Part Type</li>
                        <li>
                            <select name="part_type">
                                <option value="">All</option>
                                @foreach($part_type_opt as $key => $val)
                                    <option value="{{ $key }}" {{ $key == $part_type ? 'selected="selected"' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
                        </li>
                    </ul>
                    <div class="clear"></div>
                    <ul class="timeRange fixoptTime">
                        <li style="width:120px;">Unit Type</li>
                        <li>
                            <select name="part_unit">
                                <option value="">All</option>
                                @foreach($part_unit_opt as $key => $val)
                                    <option value="{{ $key }}" {{ $key == $part_unit ? 'selected="selected"' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>

                <div class="grid6">
                    <ul class="timeRange">
                        <li style="width:120px; margin-top:2px;">End Date</li>
                        <li><input name="enddate" type="text" class="datepicker" value="{{ $enddate }}" /></li>
                    </ul>
                    <div class="clear"></div>
                    <ul class="timeRange fixoptTime">
                        <li style="width:120px;">Part Category</li>
                        <li>
                            <select name="part_category">
                                <option value="">All</option>
                                @foreach($part_category_opt as $key => $val)
                                    <option value="{{ $key }}" {{ $key == $part_category ? 'selected="selected"' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
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
        <table cellpadding="0" cellspacing="0" border="0" class="dTableTransactionMin" dtable-sortlist="[[0,'desc']]">
            <thead>
            <tr>
                <th>Date<span class="sorting" style="display: block;"></span></th>
                <th>Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>Vendor</th>
                <th>Unit</th>
                <th>Count</th>
                <th>Amount</th>
            </tr>
            </thead>

            <tbody>
            @foreach($parts as $part)
            <tr class="">
                <td>{{ date('Y-m-d', strtotime($part->part_date)) }}</td>
                <td>{{ $part->part_code }}</td>
                <td>{{ $part->part_desc }}</td>
                <td>{{ $part->part_category }}</td>
                <td>{{ $part->part_vendor }}</td>
                <td>{{ $part->unit_type }}</td>
                <td>{{ $part->part_count }}</td>
                <td>IDR {{  number_format($part->amount, 2) }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
</div>

@endsection

