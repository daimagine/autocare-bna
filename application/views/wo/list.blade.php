@section('content')

@include('partial.notification')
<!-- Table with opened toolbar -->
<div class="widget">
    <div class="whead">
        <h6>List Work Order</h6>
        <div class="clear"></div>
    </div>
    <div id="dyn2" class="shownpars">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTable">
            <thead>
            <tr>
                <th>WO Id<span class="sorting" style="display: block;"></span></th>
                <th>Customer Name</th>
                <th>Vehicle Name</th>
                <th>Vehicle No</th>
                <th>Service Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            @foreach($transactions as $trx)
            <tr class="">
                <td class="name">{{ $trx->id }}</td>
                <td>{{ $trx->vehicle->customer->name }}</td>
                <td>{{ $trx->vehicle->model }}</td>
                <td>{{ $trx->vehicle->number }}</td>
                <td>{{ $trx->date }}</td>
                <td>{{ ($trx->status == 'O' ? 'Open' : ($trx->status == 'D' ? 'Closed' : 'Canceled')) }}</td>
                <td class="tableActs" align="center">
                    <a href="edit/{{ $trx->id }}" class="tablectrl_small bDefault tipS" original-title="Edit"><span class="iconb" data-icon=""></span></a>
                    <a href="delete/{{ $trx->id }}" class="classConfirmDelete tablectrl_small bDefault tipS" original-title="Remove">
                        <span class="iconb" data-icon=""></span>
                        <!-- Dialog modal confirmation delete item-->
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
        <div class="wButton">
            <a href="add" title="" class="buttonL bLightBlue first">
                <span class="icol-add"></span>
                <span>Add WO</span>
            </a>
        </div>
    </div>
</div>

<div id="confirmDelete" class="dialog" title="Confirmation Delete" ></div>

</div>

@endsection