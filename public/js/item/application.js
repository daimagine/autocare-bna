
//===== Wizards =====//
$(function() {
//    $("#wizard1").formwizard({
//        formPluginEnabled: true,
//        validationEnabled: false,
//        focusFirstInput : false,
//        disableUIStyles : true,
//
//        formOptions :{
//            success: function(data){$("#status1").fadeTo(500,1,function(){ $(this).html("<span>Form was submitted!</span>").fadeTo(5000, 0); })},
//            beforeSubmit: function(data){$("#w1").html("<span>Form was submitted with ajax. Data sent to the server: " + $.param(data) + "</span>");},
//            resetForm: true
//        }
//    });

    // Dialog
    $('#formDialog').dialog({
        autoOpen: false,
        width: 400,
        buttons: {
            "Nice stuff": function () {
                $(this).dialog("close");
            },
            "Cancel": function () {
                $(this).dialog("close");
            }
        }
    });

    // Dialog Link
    $('#formDialog_open').click(function () {
        $('#formDialog').dialog('open');
        return false;
    });

    $('#formDialogListItem').dialog({
        autoOpen: false,
        width: 400,
        buttons: {
            "Nice stuff": function () {
                $(this).dialog("close");
            },
            "Cancel": function () {
                $(this).dialog("close");
            }
        }
    });

    $('#formDialogWizard_open').click(function () {
        $('#formDialogListItem').dialog('open');
        return false;
    });
});
