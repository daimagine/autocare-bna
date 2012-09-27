<script type="text/javascript">
    $(function() {
        $('#dialogItem').click(function () {
            $('#formDialogListItem').dialog('close');
            return false;
        });
        $("#usualValidate").validate({
            rules: {
                firstname: "required",
                quantity: {
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
    });
</script>
{{ Form::open('item/add_apporved_item', 'POST', array('id' => 'usualValidate'))  }}
   <fieldset class="step" id="w1first">
       <div class="fluid">
       {{ Form::hidden('sub_account_trx_id', $sub_account_trx_id) }}

       {{ Form::nyelect('item_id', @$selectionItem, isset($item['id']) ? $item['id'] : 1, 'Unit Type', array('class' => 'required')) }}

       {{ Form::nginput('text', 'quantity', @$item['quantity'], 'New Quantity', array('class' => 'required')) }}

           <div class="formRow noBorderB">
               <div class="status" id="status3"></div>
               <div class="formSubmit">
                   {{ HTML::link('#', 'Cancel', array( 'class' => 'buttonL bDefault mb10 mt5', 'id' => 'dialogItem' )) }}
                   {{ Form::submit('Save', array( 'class' => 'buttonL bGreen mb10 mt5' )) }}
               </div>
               <div class="clear"></div>
           </div>
       </div>
   </fieldset>
{{ Form::close() }}
