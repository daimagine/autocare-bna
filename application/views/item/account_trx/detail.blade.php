
@section('content')

@include('partial.notification')

<!-- Table with opened toolbar -->
{{ Form::open('/item/invoice_in', 'POST') }}


<fieldset>
    <div class="widget fluid">
        <div class="whead"><h6>Detail Approved</h6><div class="clear"></div></div>
        <div class="formRow">
            <div class="grid3"><label>Invoice:</label></div>
            <div class="grid9"><input type="text" name="regular" readonly="readonly" value="{{$accountTrx->invoice_no}}"></div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <div class="grid3"><label>Reference No:</label></div>
            <div class="grid9"><input type="text" name="pass" readonly="readonly" value="{{$accountTrx->reference_no}}"></div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <div class="grid3"><label>Input Date:</label></div>
            <div class="grid9"><input type="text" name="placeholder" readonly="readonly" value="{{$accountTrx->input_date}}"></div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <div class="grid3"><label>Due Date:</label></div>
            <div class="grid9"><input type="text" name="readonly" readonly="readonly" value="{{$accountTrx->due_date}}"></div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <div class="grid3"><label>Create By:</label></div>
            <div class="grid9"><input type="text" name="regular" readonly="readonly"></div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <div class="grid3"><label>Description:</label></div>
            <div class="grid9"><textarea rows="8" cols="" name="textarea" value="{{$accountTrx->description}}"></textarea> </div>
            <div class="clear"></div>
        </div>
        <div class="formRow noBorderB">
            <table cellpadding="0" cellspacing="0" width="100%" class="tDark">
                <thead>
                <tr>
                    <td>Item Name</td>
                    <td>Code</td>
                    <td>New Quantity</td>
                    <td>Current Stock</td>
                    <td>Vendor</td>
                    <td>Last Update</td>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{$item->item->name }}</td>
                    <td>{{$item->item->code }}</td>
                    <td>{{$item->quantity }}</td>
                    <td>{{$item->item->stock }}</td>
                    <td>{{$item->item->vendor }}</td>
                    <td>{{$item->item->updated_at }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding: 19px 16px">
            <div class="formSubmit">
                <input class="buttonM bDefault ui-wizard-content ui-formwizard-button" id="back1" value="Back" type="reset" disabled="disabled">
                <input class="buttonM bRed ml10 ui-wizard-content ui-formwizard-button" id="next1" value="Next" type="submit">
                <div class="clear"></div>
            </div>
            <div class="btn-group dropup" style="display: inline-block; margin-bottom: -4px;">
                <a class="buttonM bBlack" data-toggle="dropdown" href="#"><span class="icol-add"></span><span>Put Item</span><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#" id="formDialog_open"><span class="icos-folder"></span>Select Item</a></li>
                    <li><a href="#" class="" id="formDialogWizard_open"><span class="icos-add"></span>New Item</a></li>
                </ul>
            </div>
            <!-- Dialog content -->
            <div id="formDialog" class="dialog" title="Dialog with form elements">
                <form action="">
                    <label>Text field:</label>
                    <input type="text" name="sampleInput" class="clear" placeholder="Enter something" />
                    <div class="divider"><span></span></div>
                    <div class="dialogSelect m10">
                        <label>Select:</label>
                        <select name="select2" >
                            <option value="opt1">Usual select box</option>
                            <option value="opt2">Option 2</option>
                            <option value="opt3">Option 3</option>
                            <option value="opt4">Option 4</option>
                            <option value="opt5">Option 5</option>
                            <option value="opt6">Option 6</option>
                            <option value="opt7">Option 7</option>
                            <option value="opt8">Option 8</option>
                        </select>
                    </div>
                    <div class="divider"><span></span></div>
                    <label>Textarea:</label>
                    <textarea rows="8" cols="" name="textarea" class="auto" placeholder="This textarea is elastic"></textarea>
                    <div>
                        <span class="floatL"><input type="radio" name="dialogRadio" /><label>Radio</label></span>
                        <span class="floatR"><input type="checkbox" class="check" name="dialogCheck" checked="checked" /><label>Checkbox</label></span>
                        <span class="clear"></span>
                    </div>
                </form>
            </div>

            <div id="formDialogListItem" class="dialog" title="Dialog with form elements">
                <form id="wizard1" method="post" action="submit.html" class="main">
                    <fieldset class="step" id="w1first">
                        <h1>First step description</h1>
                        <div class="formRow">
                            atat
                        </div>
                    </fieldset>
                    <fieldset id="w1confirmation" class="step">
                        <h1>Second step description</h1>
                        <div class="formRow">
                            ttest
                        </div>
                    </fieldset>
                    <div class="formRow">
                        <div class="status" id="status1"></div>
                        <div class="formSubmit">
                            <input class="buttonM bDefault" id="back1" value="Back" type="reset" />
                            <input class="buttonM bRed ml10" id="next1" value="Next" type="submit" />
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</fieldset>

{{ Form::close() }}
@endsection
