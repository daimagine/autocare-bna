@include('partial.notification')
<br>

{{ Form::open('access/edit', 'POST') }}

{{ Form::text('id', $access->id) }}

{{ Form::label('name', 'Name') }}
{{ Form::text('name', $access->name) }}

{{ Form::label('status', 'Status') }}
{{ Form::select('status', array(1 => 'Active', 0 => 'Inactive'), $access->status) }}

{{ Form::label('description', 'Description') }}
{{ Form::text('description', $access->description) }}

{{ Form::submit('save') }}

{{ HTML::link('access/index') }}

{{ Form::close() }}