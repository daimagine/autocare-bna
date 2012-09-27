@section('content')

@include('partial.notification')
<!-- Rounded buttons -->
<ul class="middleNavA">
    @foreach($item_category as $c)
    <li><a href="list_history?category={{$c->id}}" title="{{$c->name}}" style="width: 100px;height: 65px;"><img src="../images/icons/color/config.png" alt="" /><span style="@if($category->name == $c->name) color:red @endif">{{$c->name}}</span></a></li>
    @endforeach
</ul>
<div class="divider"><span></span></div>

<!-- Table history price -->
<div class="widget">
    <div class="whead">
        <h6>List History Price Item {{$category->name}}</h6>
        <div class="clear"></div>
    </div>
    <div id="dyn1" class="shownpars">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTable">
            <thead>
            <tr>
                <th>Item Name<span class="sorting" style="display: block;"></span></th>
                <th>Price</th>
                <th>Status</th>
                <th>Created at</th>
                <th>Expired at</th>
                <th>configured by</th>
            </tr>
            </thead>
            <tbody>

            @foreach($listItemPrice as $price)
            <tr class="">
                <td>{{ $price->item->name }}</td>
                <td>{{ $price->price }}</td>
                <td>{{ ($price->status == '1' ? 'Active' : 'Expired') }}</td>
                <td>{{ $price->date }}</td>
                <td>{{ $price->expiry_date }}</td>
                <td>{{ $price->users->name }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
</div>

@endsection
