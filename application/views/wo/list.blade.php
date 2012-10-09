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
                <td class="name">{{ $trx->workorder_no }}</td>
                <td>{{ $trx->vehicle->customer->name }}</td>
                <td>{{ $trx->vehicle->model }}</td>
                <td>{{ $trx->vehicle->number }}</td>
                <td>{{ $trx->date }}</td>
                <td>{{ ($trx->status == 'O' ? 'Open' : ($trx->status == 'D' ? 'Closed' : 'Canceled')) }}</td>
                <td class="tableActs" align="center">
                    <a href="detail/{{ $trx->id }}" class="tablectrl_small bBlue tipS" original-title="Detail"><span class="iconb" data-icon=""></span></a>
                    @if($trx->status == 'O')
                    <a href="edit/{{ $trx->id }}" class="tablectrl_small bRed tipS" original-title="Update"><span class="iconb" data-icon=""></span></a>
                    <a href="close/{{ $trx->id }}" class="tablectrl_small bGreen tipS" original-title="Close"><span class="iconb"  data-icon=""></span></a>
                    <a href="cancel/{{ $trx->id }}" class="tablectrl_small bGreyish tipS" original-title="Cancel"><span class="iconb"  data-icon=""></span></a>
                    @endif
                    @if($trx->status == 'D' or $trx->status == 'O')
                    <a href="invoice/{{ $trx->id }}" class="tablectrl_small bGold tipS" original-title="Invoice"><span class="iconb"  data-icon=""></span></a>
                    @endif
                    @if($trx->status == 'C' or $trx->status == 'D')
                    <a href="reopen/{{ $trx->id }}" class="tablectrl_small bSea tipS" original-title="Reopen"><span class="iconb"  data-icon=""></span></a>
                    @endif
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