@section('content')

@include('partial.notification')

<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>Membership List</h6>
        <div class="clear"></div>
    </div>
    <div id="dyn2" class="shownpars">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTable">
            <thead>
            <tr>
                <th>Number<span class="sorting" style="display: block;"></span></th>
                <th>Attribute</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($member as $member)
            <tr class="">
                <td>{{ $member->number }}</td>
                <td class="tableActs" align="center">
                    @if($member->status)
                    <a href="#" class="fs1 iconb tipS" original-title="Active" data-icon=""></a>
                    @endif
                </td>
                <td class="tableActs" align="center">
                    <a href="edit/{{ $member->id }}" class="tablectrl_small bDefault tipS" original-title="Edit"><span class="iconb" data-icon=""></span></a>
                    <a href="delete/{{ $member->id }}" class="tablectrl_small bDefault tipS" original-title="Remove"><span class="iconb" data-icon=""></span></a>
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
            <span>Add Membership</span>
        </a></div>
    </div>
</div>

@endsection
