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

{{ Form::label('viewable', 'Viewable') }}
{{ Form::select('viewable', array(1 => 'Viewable Navigation', 0 => 'Background process'), $access->viewable) }}

{{ Form::label('url', 'Access URL') }}
{{ Form::text('url', $access->url) }}

{{ Form::label('parent_id', 'Parent Access') }}
{{ Form::select('parent_id', $accesses, $access->parent_id ) }}

{{ Form::submit('save') }}

{{ HTML::link('access/index') }}

{{ Form::close() }}