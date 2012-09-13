@include('partial.notification')
<br>
    
{{ Form::open('access/add', 'POST') }}

{{ Form::label('name', 'Name') }}
{{ Form::text('name', @$access['name']) }}

{{ Form::label('status', 'Status') }}
{{ Form::select('status', array(1 => 'Active', 0 => 'Inactive'), isset($access['status']) ? $access['status'] : 1) }}

{{ Form::label('description', 'Description') }}
{{ Form::text('description', @$access['description']) }}

{{ Form::submit('save') }}

{{ HTML::link('access/index') }}

{{ Form::close() }}