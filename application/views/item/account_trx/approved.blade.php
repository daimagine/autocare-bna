@section('content')

@include('partial.notification')

<div class="widget">
    <div class="whead">
        <h6>List Item Approved</h6>
        <div class="clear"></div>
    </div>
    <div id="dyn2" class="shownpars">
        <a class="tOptions act" title="Options">{{ HTML::image('images/icons/options', '') }}</a>
        <table cellpadding="0" cellspacing="0" border="0" class="dTable">
            <thead>
            <tr>
                <th>Invoice<span class="sorting" style="display: block;"></span></th>
                <th>Ref No</th>
                <th>Description</th>
                <th>Input Date</th>
                <th>Due Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lstAte as $ate)
            <tr class="">
                <td>{{ $ate->invoice_no }}</td>
                <td>{{ $ate->reference_no }}</td>
                <td>{{ $ate->description }}</td>
                <td>{{ $ate->input_date }}</td>
                <td>{{ $ate->due_date }}</td>
                <td class="tableActs" align="center">
                    <a href="detailApproved/{{ $ate->id }}" class="tablectrl_small bDefault tipS" original-title="Process"><span class="iconb" data-icon=""></span></a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
</div>
@endsection
