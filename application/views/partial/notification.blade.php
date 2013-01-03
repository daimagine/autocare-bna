
@if (isset($errors) && count($errors->all()) > 0)
<div class="nNote nFailure">
    @foreach ($errors->all('<p>:message</p>') as $message)
    {{ $message }}
    @endforeach
</div>
@elseif (!is_null(Session::get('message_error')))
<div class="nNote nFailure">
    @if (is_array(Session::get('message_error')))
    @foreach (Session::get('message_error') as $error)
    <p>{{ $error }}</p>
    @endforeach
    @else
    <p>{{ Session::get('message') }}</p>
    @endif
</div>
@endif

@if (!is_null(Session::get('message')))
<div class="nNote nSuccess">
    @if (is_array(Session::get('message')))
    @foreach (Session::get('message') as $success)
    <p>{{ $success }}</p>
    @endforeach
    @else
    <p>{{ Session::get('message') }}</p>
    @endif
</div>
@endif