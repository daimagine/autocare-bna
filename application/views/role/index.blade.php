
@section('content')
@include('partial.notification')
    @if(isset($message))
    {{ $message_class . ' : ' . $message }}
    <br>
    @endif

    @foreach($roles as $role)
    {{ $role->name . ' ' . $role->description . ' ' . HTML::link('role/edit/'.$role->id) . ' ' . HTML::link('role/delete/'.$role->id) }} <br>
    @endforeach

    <br>
    {{ HTML::link('role/add') }}

@endsection