<!-- Tabs -->
<script src="http://autocare-bna.dev/js/wo/application.js" type="text/javascript"></script>
<div class="fluid">
    <div class="widget" style="margin-top: 0px;">
        <ul class="tabs">
            @foreach($lstItemCategory as $category)
                <li><a href="#{{$category->id}}">{{$category->name}}</a></li>
            @endforeach
        </ul>

        <div class="tab_container">
            @foreach($lstItemCategory as $category)
            <div id="{{$category->id}}" class="tab_content">
                <div id="dyn{{$category->id}}" class="shownpars">
                    <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
                    <table cellpadding="0" cellspacing="0" border="0" class="dTable">
                        <thead>
                        <tr>
                            <th style="display: none" ></th>
                            <th>Name<span class="sorting" style="display: block;"></span></th>
                            <th>Code</th>
                            <th>Stock</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Vendor</th>
                            <th>Type</th>
                            <th>Unit</th>
                            <th>Exp Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lstItems as $item)
                            @if($item->item_category->id === $category->id)
                                <tr class="">
                                    <th style="display: none" class="item-id">{{$item->id}}</th>
                                    <td class="name">{{ $item->name }}</td>
                                    <td class="code">{{ $item->code }}</td>
                                    <td class="stock">{{ $item->stock }}</td>
                                    <td class="desc">{{ $item->description }}</td>
                                    <td class="price">{{ $item->price }}</td>
                                    <td class="vendor">{{ $item->vendor }}</td>
                                    <td class="type">{{ $item->item_type->name}}</td>
                                    <td class="unit">{{ $item->item_unit->name}}</td>
                                    <td>{{ $item->expiry_date }}</td>
                                    <td align="center" class="tableActs "><a href="#" class="select-item fs1 iconb tipS" original-title="Select This" data-icon=""></a></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
        <div class="clear"></div>
    </div>
</div>
</div>