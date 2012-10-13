
@section('content')

@include('partial.notification')

<div class="widget">
    <div class="whead"><h6>Some news</h6><div class="clear"></div></div>
    <ul class="updates">
        @if(sizeof($newslist) <= 0)
            <li>
                <div class="wNews">
                    <div class="announce">
                        <span>News list is empty</span>
                    </div>
                </div>
                <span class="clear"></span>
            </li>
        @else
            @foreach($newslist as $news)
            <li>
                <div class="wNews">
                    <div class="announce">
                        <a href="#newsDetail" title="" class="newsDetail"onclick="detailNews('{{ $news->id }}')">{{ $news->title }}</a>
                        <span>{{ $news->resume }} ...</span>
                    </div>
                </div>
                <span class="uDate" style="width:80px;"><span>{{ date('d', strtotime($news->created_at)) }}</span>{{ date('F', strtotime($news->created_at)) }}</span>
                <span class="clear"></span>
            </li>
            @endforeach
        @endif
    </ul>
</div>

<div class="fluid">
    <div class="grid2">
        <div class="wButton"><a href="add" title="" class="buttonL bLightBlue first">
            <span class="icol-add"></span>
            <span>Add News</span>
        </a></div>
    </div>
</div>

<div id="detailNews" class="dialog" title="Detail News" ></div>

@endsection
    