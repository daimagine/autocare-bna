@if(isset($message))
    {{ $message_class . ' : ' . $message }}
    <br>
@endif

@if( isset( $this->errors ) )
    {{ implode( '<br />', $this->errors->all( ) ) }}
@endif

{{ Form::open('user/add', 'POST') }}

{{ Form::label('login_id', 'Login ID') }}
{{ Form::text('login_id', @$user['login_id']) }}

{{ Form::label('password', 'Password') }}
{{ Form::password('password') }}

{{ Form::label('role_id', 'User Role') }}
{{ Form::select('role_id', $roles, isset($user['role_id']) ? $user['role_id'] : 0) }}

{{ Form::label('status', 'Status') }}
{{ Form::select('status', array(1 => 'Active', 0 => 'Inactive'), isset($user['status']) ? $user['status'] : 1) }}

{{ Form::label('name', 'Name') }}
{{ Form::text('name', @$user['name']) }}

{{ Form::label('staff_id', 'Staff ID') }}
{{ Form::text('staff_id', @$user['staff_id']) }}

{{ Form::label('address1', 'Address 1') }}
{{ Form::text('address1', @$user['address1']) }}

{{ Form::label('address2', 'Address 2') }}
{{ Form::text('address2', @$user['address2']) }}

{{ Form::label('city', 'City') }}
{{ Form::text('city', @$user['city']) }}

{{ Form::label('phone1', 'Phone 1') }}
{{ Form::text('phone1', @$user['phone1']) }}

{{ Form::label('phone2', 'Phone 2') }}
{{ Form::text('phone2', @$user['phone2']) }}

{{ Form::submit('save') }}

{{ HTML::link('user/index') }}

{{ Form::close() }}