@section('content')

@include('partial.notification')
<!-- Rounded buttons -->
<ul class="middleNavA">
    @foreach($item_category as $category)
    <li><a href="index?category={{$category->id}}" title="{{$category->name}}" style="width: 100px;height: 65px;"><img src="../images/icons/color/config.png" alt="" /><span style="@if($item_category_name == $category->name) color:red @endif">{{$category->name}}</span></a></li>
    @endforeach
</ul>
<div class="divider"><span></span></div>

<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>List Item {{$item_category_name}}</h6>
        <div class="clear"></div>
    </div>
    <div id="dyn2" class="shownpars">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTable">
            <thead>
            <tr>
                <th>Name<span class="sorting" style="display: block;"></span></th>
                <th>Code</th>
                <th>Stock</th>
                <th>Description</th>
                <th>Price</th>
                <th>Vendor</th>
                <th>Date</th>
                <th>Expiry Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($item as $item)
            <tr class="">
                <td>{{ $item->name }}</td>
                <td>{{ $item->code }}</td>
                <td>{{ $item->stock }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->vendor }}</td>
                <td>{{ $item->date }}</td>
                <td>{{ $item->expiry_date }}</td>
                <td class="tableActs" align="center">
                    <a href="edit/{{ $item->id }}" class="tablectrl_small bDefault tipS" original-title="Edit"><span class="iconb" data-icon=""></span></a>
                    <a href="delete/{{ $item->id }}" class="tablectrl_small bDefault tipS" original-title="Remove"><span class="iconb" data-icon=""></span></a>
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
        <div class="wButton"><a href="add?category={{$category->id}}" title="" class="buttonL bLightBlue first">
            <span class="icol-add"></span>
            <span>Add New</span>
        </a></div>
    </div>
</div>

@endsection
