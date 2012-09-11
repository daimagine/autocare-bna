@if(isset($message))
{{ $message_class . ' : ' . $message }}
<br>
@endif

@if( isset( $this->errors ) )
{{ implode( '<br />', $this->errors->all( ) ) }}
@endif

{{ Form::open('role/add', 'POST') }}

{{ Form::label('name', 'Name') }}
{{ Form::text('name', @$role['name']) }}

{{ Form::label('status', 'Status') }}
{{ Form::select('status', array(1 => 'Active', 0 => 'Inactive'), isset($role['status']) ? $role['status'] : 1) }}

{{ Form::label('description', 'Description') }}
{{ Form::text('description', @$role['description']) }}

{{ Form::submit('save') }}

{{ HTML::link('role/index') }}

{{ Form::close() }}