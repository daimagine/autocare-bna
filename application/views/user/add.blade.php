@section('content')

@include('partial.notification')
<br>


{{ Form::open('user/add', 'POST') }}
<fieldset>
    <div class="widget fluid">
        <div class="whead">
            <h6>User Add</h6>

            <div class="clear"></div>
        </div>
        {{ Form::nginput('text', 'login_id', @$user['login_id'], 'Login ID') }}

        {{ Form::nginput('password', 'password',  @$user['password'], 'Password') }}

        {{ Form::nginput('password', 'retype_password', null, 'Retype Password') }}

        {{ Form::nyelect('role_id', @$roles, isset($user['role_id']) ? $user['role_id'] : 1, 'Role') }}

        {{ Form::nyelect('status', array(1 => 'Active', 0 => 'Inactive'), isset($user['status']) ? $user['status'] : 1, 'Status') }}

        {{ Form::nginput('text', 'name', @$user['name'], 'Name') }}

        {{ Form::nginput('text', 'staff_id', @$user['staff_id'], 'Staff ID')}}

        {{ Form::nginput('text', 'address1', @$user['address1'], 'Address 1')}}

        {{ Form::nginput('text', 'address2', @$user['address2'], 'Address 2')}}

        {{ Form::nginput('text', 'city', @$user['city'], 'City')}}

        {{ Form::nginput('text', 'phone1', @$user['phone1'], 'Phone 1')}}

        {{ Form::nginput('text', 'phone2', @$user['phone2'], 'Phone 2')}}


        <div class="formRow noBorderB">
            <div class="status" id="status3"></div>
            <div class="formSubmit">
                {{ HTML::link('user/index', 'Cancel', array( 'class' => 'buttonL bDefault mb10 mt5' )) }}
                {{ Form::submit('Save', array( 'class' => 'buttonL bGreen mb10 mt5' )) }}
            </div>
            <div class="clear"></div>
        </div>

    </div>
</fieldset>
{{ Form::close() }}

@endsection