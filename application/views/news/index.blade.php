
@section('content')

@include('partial.notification')


<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>News List</h6>
        <div class="clear"></div>
    </div>
    <div id="dyn2" class="shownpars">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTable">
            <thead>
            <tr>
                <th>Title<span class="sorting" style="display: block;"></span></th>
                <th>Resume</th>
                <th>Create At</th>
                <th>Attribute</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($newslist as $news)
            <tr class="">
                <td>{{ $news->title }}</td>
                <td>{{ $news->resume }}</td>
                <td>{{ date('d F Y', strtotime($news->created_at)) }}</td>
                <td class="tableActs" align="center">
                    @if($news->status)
                    <a href="#" class="fs1 iconb tipS" original-title="Active" data-icon=""></a>
                    @endif
                </td>
                <td class="tableActs" align="center">
                    <a href="/news/edit/{{ $news->id }}"
                       class="appconfirm tablectrl_small bDefault tipS"
                       original-title="Edit"
                       dialog-confirm-title="Update Confirmation">
                        <span class="iconb" data-icon=""></span>
                    </a>
                    <a href="/news/delete/{{ $news->id }}"
                       class="appconfirm tablectrl_small bDefault tipS"
                       original-title="Remove"
                       dialog-confirm-title="Remove Confirmation">
                        <span class="iconb" data-icon=""></span>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
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
    