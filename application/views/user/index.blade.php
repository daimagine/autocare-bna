@section('content')

@include('partial.notification')

<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>User List</h6>
        <div class="clear"></div>
    </div>
    <div id="dyn2" class="shownpars">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTable">
            <thead>
            <tr>
                <th>Staff ID<span class="sorting" style="display: block;"></span></th>
				<th>Name</th>
				<th>Login ID</th>
				<th>Phone Number</th>
				<th>Role</th>
				<th>Status</th>
				<th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr class="">
                <td>{{ $user->staff_id }}</td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->login_id }}</td>
				<td>{{ $user->phone1 }}</td>
				<td>{{ $user->role->name }}</td>
                <td class="tableActs" align="center">
                    @if($user->status)
						<a href="#" class="fs1 iconb tipS" original-title="Active" data-icon=""></a>
                    @endif
                </td>
                <td class="tableActs" align="center">
                    <a href="/user/edit/{{ $user->id }}" 
						class="appconfirm tablectrl_small bDefault tipS" 
						original-title="Edit"
						dialog-confirm-title="Update Confirmation">
							<span class="iconb" data-icon=""></span>
					</a>
                    <a href="/user/delete/{{ $user->id }}{{ $user->status == 1 ? '' : '/purge' }}"
                       class="appconfirm tablectrl_small bDefault tipS"
                       original-title="Remove"
                       dialog-confirm-title="Remove Confirmation"
                       dialog-confirm-content="{{ $user->status == 1 ? 'This action will make this user to be inactive. Are you sure?' : 'This user is inactive. Removing will purge all data and information linked with this user. Are you sure?' }}">
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
        <div class="wButton"><a href="/user/add" title="" class="buttonL bLightBlue first">
            <span class="icol-add"></span>
            <span>Add User</span>
        </a></div>
    </div>
</div>

@endsection

onclick="return App.confirm(this);" 