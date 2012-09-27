@section('content')

@include('partial.notification')

<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>Membership List</h6>
        <div class="clear"></div>
    </div>
    <div id="dyn2" class="shownpars">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTable">
            <thead>
            <tr>
                <th>Name<span class="sorting" style="display: block;"></span></th>
				<th>Addres</th>
				<th>Vehicle No</th>
				<th>Status</th>
				<th>Expiry date</th>
                <th>Membership</th>
            </tr>
            </thead>
            <tbody>
            @foreach($member as $member)
            <tr class="">
                <td>{{ $member->name }}</td>
				<td>{{ $member->address1 . ' ' . $member->address2 }}</td>
				<td></td>
                <td class="tableActs" align="center">
                    @if($member->status)
                    <a href="#" class="fs1 iconb tipS" original-title="Active" data-icon=""></a>
                    @endif
                </td>
				<td>
					@if($member->membership != null)
						{{ $member->membership->expiry_date }}
					@endif
				</td>
				
				@if($member->membership != null)
					<td>
                        <a href="#memberDetail" onclick="detailMember('{{ $member->membership->id }}')">{{ $member->membership->description }}</a>
						<!-- {{ HTML::link('/member/delete/'.$member->membership->id, $member->membership->description) }} -->
					</td>
				@else
					<td class="tableActs" align="center">
						<a id="formDialog_open" href="#assign" 
							data-value="{{ $member->id }}" 
							additional-value="{{$member->name}};{{$member->created_at}}">Assign Membership</a>
					</td>
				@endif
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
</div>

<!-- Dialog content -->
<div id="formDialog" class="dialog" title="Assign New Membership">
	<form action="/member/assign" id="memberAssignForm" method="post">
		<input type="hidden" id="customerId" value="0" name="id"/>
		<div class="messageTo">
			<span> Assign membership to <strong><span id="customerName"></span></strong></span>
			<a href="#" class="uEmail">customer since : <span id="customerSince"></span></a>
		</div>
		<div class="divider"><span></span></div>
		<div class="dialogSelect m10">
			<label>Select membership</label>
			<select name="discount_id" >
				@foreach($discounts as $id => $desc)
					<option value="{{ $id }}">{{ $desc }}</option>
				@endforeach
			</select>
		</div>
	</form>
</div>

<!-- Detail Membership -->
<div id="detailMember" class="dialog" title="Detail Membership" ></div>

@endsection
