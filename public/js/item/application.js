//===== Wizards =====//
$(function() {


    // Dialog
    $('#formDialogNewItem').dialog({
        autoOpen: false,
        width: 700,
        modal:true
    });

    $('#dialogNewItem').click(function () {
        $('#formDialogNewItem').dialog('close');
        return false;
    });

    $('#formDialogListItem').dialog({
        autoOpen: false,
        width: 700,
        modal:true
    });

//    $('a.deleteConfirm').click(function () {
//        document.formBody.action.value = 'confirm';
//    });
    //===== closed approved dialog confirmation=====//
    $('#formDialogApproved').dialog({
        autoOpen: false,
        width: 400,
        modal: true,
        resizable: false,
        buttons: {
            "Yes I'm sure": function() {
                document.formAutocare.submit();
                $(this).dialog("close");
            },
            "Cancel": function() {
                $(this).dialog("close");
            }
        }
    });

    $('#buttonConfirmApproved').click(function () {
        $("#formDialogApproved").html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span>' +
            ' Are you sure the data is correct and you want to closed this approved invoice ?' +
            '<br/> <em>Please make sure you has write correct information message for accounting team on remarks field</em>' +
            '</p>');
        document.formAutocare.action.value = 'confirm';
        $("#formDialogApproved").dialog('open');
    });

    $('#buttonCloseApproved').click(function () {
        var name = $("textarea#remarks").val();
        if (name!='') {
            $("#formDialogApproved").html('<p>' +
                '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span> Are you sure want to reject this approved invoice ? ' +
                '<br/> <em>Please make sure you has write correct information message for accounting team on remarks box </em>' +
                '</p>');
            document.formAutocare.action.value = 'reject';
            $("#formDialogApproved").dialog('open');
        }
    });
    //===== Validation engine =====//

    $("#formAutocare").validationEngine();
//==============option==============//
//    var opts = {
//        'stockValue': {
//            decimal: 1,
//            min: 0,
//            start: 0
//        }
//    };
//
//    for (var n in opts)
//        $("#"+n).spinner(opts[n]);


    $('#confirm-dialog').dialog({
        autoOpen: false,
        width: 400,
        modal: true,
        resizable: false,
        buttons: {
            "Submit Form": function() {
                document.formAutocare.submit();
                $(this).dialog("close");
            },
            "Cancel": function() {
                $(this).dialog("close");
            }
        }
    });

    $('form#formAutocare').submit(function(){
//        e.preventDefault();
        var name = $("input#name").val();
        var stock = $("input#stock").val();
        var code = $("input#code").val();
        var price = $("input#sellingPrice").val();
        var purchase_price = $("input#purchasePrice").val();
        var vendor = $("input#vendor").val();
        console.log('name '+name);
        console.log('price '+price);
        console.log('purchase_price '+purchase_price);
        console.log('code '+code);
        if(name!='' && code!='' && price!='' && purchase_price!='') {
            $("span#itemName").html(name);
            $("span#itemCode").html(code);
            $("span#itemPrice").html(price);
            $("span#itemPurchasePrice").html(purchase_price);
            $('#confirm-dialog').dialog('open');
        }
        return false;
    });


});

function getListItem(categoryId){
    $('#formDialogListItem').load("../lst_item/"+categoryId);
    $('#formDialogListItem').dialog('open');

}

function formNewItem(categoryId){
    $('#formDialogNewItem').load("../putnewitem/"+categoryId);
    $('#formDialogNewItem').dialog('open');
}

function confirmApproved(){

}
