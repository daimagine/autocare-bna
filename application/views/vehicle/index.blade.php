@section('content')

@include('partial.notification')

<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>Vehicle List</h6>
        <div class="clear"></div>
    </div>
    <div id="dyn2" class="shownpars">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTable">
            <thead>
            <tr>
                <th>Customer<span class="sorting" style="display: block;"></span></th>
                <th>Number</th>
                <th>Type</th>
				<th>Color</th>
				<th>Model</th>
				<th>Brand</th>
				<th>Description</th>
				<th>Status</th>
				<th>Actions</td>
            </tr>
            </thead>
            <tbody>
            @foreach($vehicles as $vehicle)
            <tr class="">
				<td>{{ $vehicle->owner }}</td>
                <td>{{ $vehicle->number }}</td>
                <td>{{ $vehicle->type }}</td>
                <td>{{ $vehicle->color }}</td>
                <td>{{ $vehicle->model }}</td>
                <td>{{ $vehicle->brand }}</td>
                <td>{{ $vehicle->description }}</td>
                <td class="tableActs" align="center">
                    @if($vehicle->status)
                    	<a href="#" class="fs1 iconb tipS" original-title="Active" data-icon=""></a>
                    @endif
                </td>
                <td class="tableActs" align="center">
                    <a href="/vehicle/edit/{{ $vehicle->id }}" class="tablectrl_small bDefault tipS" original-title="Edit"><span class="iconb" data-icon=""></span></a>
                    <a href="/vehicle/delete/{{ $vehicle->id }}" class="tablectrl_small bDefault tipS" original-title="Remove"><span class="iconb" data-icon=""></span></a>
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
        <div class="wButton"><a href="/vehicle/add" title="" class="buttonL bLightBlue first">
            <span class="icol-add"></span>
            <span>Add Vehicle</span>
        </a></div>
    </div>
</div>

@endsection


