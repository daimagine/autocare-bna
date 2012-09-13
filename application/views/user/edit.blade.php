@section('content')
@include('partial.notification')
{{ Form::open('user/edit', 'POST') }}

{{ Form::text('id', $user->id) }}

{{ Form::label('login_id', 'Login ID') }}
{{ Form::text('login_id', $user->login_id) }}

{{ Form::label('role_id', 'User Role') }}
{{ Form::select('role_id', $roles, $user->role_id) }}

{{ Form::label('status', 'Status') }}
{{ Form::select('status', array(1 => 'Active', 0 => 'Inactive'), $user->status) }}

{{ Form::label('name', 'Name') }}
{{ Form::text('name', $user->name) }}

{{ Form::label('staff_id', 'Staff ID') }}
{{ Form::text('staff_id', $user->staff_id) }}

{{ Form::label('address1', 'Address 1') }}
{{ Form::text('address1', $user->address1) }}

{{ Form::label('address2', 'Address 2') }}
{{ Form::text('address2', $user->address2) }}

{{ Form::label('city', 'City') }}
{{ Form::text('city', $user->city) }}

{{ Form::label('phone1', 'Phone 1') }}
{{ Form::text('phone1', $user->phone1) }}

{{ Form::label('phone2', 'Phone 2') }}
{{ Form::text('phone2', $user->phone2) }}

{{ Form::submit('save') }}

{{ HTML::link('user/index') }}

{{ Form::close() }}
@endsection