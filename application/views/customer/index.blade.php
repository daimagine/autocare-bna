@section('content')

@include('partial.notification')

<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>Customer List</h6>
        <div class="clear"></div>
    </div>
    <div id="dyn2" class="shownpars">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTable">
            <thead>
            <tr>
                <th>Name<span class="sorting" style="display: block;"></span></th>
				<th>Addres</th>
				<th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
            <tr class="">
                <td>{{ $customer->name }}</td>
				<td>{{ $customer->address1 . ' ' . $customer->address2 }}</td>
                <td class="tableActs" align="center">
                    @if($customer->status)
                    <a href="#" class="fs1 iconb tipS" original-title="Active" data-icon=""></a>
                    @endif
                </td>
                <td class="tableActs" align="center">
                    <a href="/customer/edit/{{ $customer->id }}" 
						class="appconfirm tablectrl_small bDefault tipS" 
						original-title="Edit"
						dialog-confirm-title="Update Confirmation">
							<span class="iconb" data-icon=""></span>
					</a>
                    <a href="/customer/delete/{{ $customer->id }}" 
						class="appconfirm tablectrl_small bDefault tipS" 
						original-title="Remove"
						dialog-confirm-title="Remove Confirmation">
							<span class="iconb" data-icon=""></span>
					</a>
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
            <span>Add Customer</span>
        </a></div>
    </div>
</div>

@endsection
