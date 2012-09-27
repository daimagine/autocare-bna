<script type="text/javascript">
    $(function() {
        $('#dialogNewItem').click(function () {
            $('#formDialogNewItem').dialog('close');
            return false;
        });
    });
    $("#usualValidate").validate({
        rules: {
            firstname: "required",
            stock: {
                required: true,
                digits: true
            },
            price: {
                required: true,
                digits: true
            },
            agree: "required"
        },
        messages: {
            customMessage: {
                required: "Bazinga! This message is editable",
            },
            agree: "Please accept our policy"
        }
    });
</script>

{{ Form::open('item/putnewitem', 'POST', array('id' => 'usualValidate')) }}
{{ Form::hidden('item_category_id', $itemCategory->id) }}
{{ Form::hidden('status', 1) }}

<fieldset class="step" id="w1first">
    <div class="fluid">
        <div class="grid6">
            {{ Form::nyelect('item_type_id', @$itemType, isset($item['item_type_id']) ? $item['item_type_id'] : 1, 'Item Type', array('class' => 'validate[required]')) }}

            {{ Form::nginput('text', 'name', @$item['name'], 'Name', array('class' => 'required'))  }}

            {{ Form::nginput('text', 'code', @$item['code'], 'Code', array('class' => 'required'))  }}

            {{ Form::nginput('text', 'stock', @$item['stock'], 'Stock', array('class' => 'required')) }}

        </div>
        <div class="grid6">
            {{ Form::nyelect('unit_id', @$unitType, isset($item['unit_id']) ? $item['unit_id'] : 1, 'Unit Type', array('class' => 'required ')) }}

            {{ Form::nginput('text', 'description', @$access['description'], 'Description', array('class' => 'required')) }}

            {{ Form::nginput('text', 'price', @$item['price'], 'Price', array('class' => 'required')) }}

            {{ Form::nginput('text', 'vendor', @$item['vendor'], 'Vendor', array('class' => 'required'))  }}
        </div>
        <div class="grid11">
            <div class="formRow noBorderB">
                <div class="status" id="status3"></div>
                <div class="formSubmit">
                    {{ HTML::link('#', 'Cancel', array( 'class' => 'buttonL bDefault mb10 mt5', 'id' => 'dialogNewItem' )) }}
                    {{ Form::submit('Save', array( 'class' => 'buttonL bGreen mb10 mt5' )) }}
                </div>
                <div class="clear"></div>
            </div>
        </div>

    </div>
</fieldset>
{{ Form::close() }}