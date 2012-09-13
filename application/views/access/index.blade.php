@section('content')

@include('partial.notification')

<br>
@foreach($access as $access)
{{ $access->name . ' ' . $access->description . ' ' . HTML::link('access/edit/'.$access->id) . ' ' . HTML::link('access/delete/'.$access->id) }} <br>
@endforeach

<br>
{{ HTML::link('access/add') }}

@endsection