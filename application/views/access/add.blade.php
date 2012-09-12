@include('partial.notification')
<br>
    
{{ Form::open('access/add', 'POST') }}

{{ Form::label('name', 'Name') }}
{{ Form::text('name', @$access['name']) }}

{{ Form::label('status', 'Status') }}
{{ Form::select('status', array(1 => 'Active', 0 => 'Inactive'), isset($access['status']) ? $access['status'] : 1) }}

{{ Form::label('description', 'Description') }}
{{ Form::text('description', @$access['description']) }}

{{ Form::label('viewable', 'Viewable') }}
{{ Form::select('viewable', array(1 => 'Viewable Navigation', 0 => 'Background process'), isset($access['viewable']) ? $access['viewable'] : 1) }}

{{ Form::label('url', 'Access URL') }}
{{ Form::text('url', @$access['url']) }}

{{ Form::label('parent_id', 'Parent Access') }}
{{ Form::select('parent_id', $accesses, isset($access['parent_id']) ? $access['parent_id'] : 0) }}

{{ Form::submit('save') }}

{{ HTML::link('access/index') }}

{{ Form::close() }}