@if(isset($message))
{{ $message_class . ' : ' . $message }}
<br>
@endif

{{ Form::open('role/edit', 'POST') }}

{{ Form::text('id', $role->id) }}

{{ Form::label('name', 'Name') }}
{{ Form::text('name', $role->name) }}

{{ Form::label('status', 'Status') }}
{{ Form::select('status', array(1 => 'Active', 0 => 'Inactive'), $role->status) }}

{{ Form::label('description', 'Description') }}
{{ Form::text('description', $role->description) }}

{{ Form::submit('save') }}

{{ HTML::link('role/index') }}

{{ Form::close() }}