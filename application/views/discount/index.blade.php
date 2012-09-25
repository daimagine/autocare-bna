@section('content')

@include('partial.notification')

<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>Discount List</h6>
        <div class="clear"></div>
    </div>
    <div id="dyn2" class="shownpars">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTable">
            <thead>
            <tr>
                <th>Code<span class="sorting" style="display: block;"></span></th>
                <th>Value</th>
				<th>Charge</th>
				<th>Duration</th>
                <th>Description</th>
                <th>Attribute</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($discount as $discount)
            <tr class="">
                <td>{{ $discount->code }}</td>
                <td>{{ $discount->value }}%</td>
                <td>IDR {{ $discount->registration_fee }}</td>
				<td>{{ $discount->duration }} {{ $discount->duration_period == 'M' ? 'Month' : ( $discount->duration_period == 'Y' ? 'Year' : '' ) }} </td>
                <td>{{ $discount->description }}</td>
                <td class="tableActs" align="center">
                    @if($discount->status)
                    <a href="#" class="fs1 iconb tipS" original-title="Active" data-icon=""></a>
                    @endif
                </td>
                <td class="tableActs" align="center">
                    <a href="edit/{{ $discount->id }}" class="tablectrl_small bDefault tipS" original-title="Edit"><span class="iconb" data-icon=""></span></a>
                    <a href="delete/{{ $discount->id }}" class="tablectrl_small bDefault tipS" original-title="Remove"><span class="iconb" data-icon=""></span></a>
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
        <div class="wButton"><a href="add" title="" class="buttonL bLightBlue first">
            <span class="icol-add"></span>
            <span>Add Discount</span>
        </a></div>
    </div>
</div>

@endsection
