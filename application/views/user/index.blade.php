@section('content')
@include('partial.notification')

@foreach($users as $user)
{{ $user->login_id . ' ' . $user->name . ' ' . HTML::link('user/edit/'.$user->id) . ' ' . HTML::link('user/delete/'.$user->id) }} <br>
@endforeach

<br>
{{ HTML::link('user/add') }}
@endsection