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

    $('#buttonReject').click(function () {
        document.formBody.action.value = 'reject';
    });

    $('#buttonConfirm').click(function () {
        document.formBody.action.value = 'confirm';
    });

    //===== Usual validation engine=====//

    $("#usualValidate").validate({
        rules: {
            firstname: "required",
            minChars: {
                required: true,
                minlength: 3
            },
            maxChars: {
                required: true,
                maxlength: 6
            },
            mini: {
                required: true,
                min: 3
            },
            maxi: {
                required: true,
                max: 6
            },
            range: {
                required: true,
                range: [6, 16]
            },
            emailField: {
                required: true,
                email: true
            },
            urlField: {
                required: true,
                url: true
            },
            dateField: {
                required: true,
                date: true
            },
            digitsOnly: {
                required: true,
                digits: true
            },
            enterPass: {
                required: true,
                minlength: 5
            },
            repeatPass: {
                required: true,
                minlength: 5,
                equalTo: "#enterPass"
            },
            customMessage: "required",
            topic: {
                required: "#newsletter:checked",
                minlength: 2
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

    //===== Validation engine =====//

    $("#validate").validationEngine();

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
