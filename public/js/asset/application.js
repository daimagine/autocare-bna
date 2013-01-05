//===== Wizards =====//
$(function() {
    //===== closed approved dialog confirmation=====//
    $('#formDialogApproved').dialog({
        autoOpen: false,
        width: 400,
        modal: true,
        resizable: false,
        buttons: {
            "Yes I'm sure": function() {
                var $action = $('#action').val()
                if ($action==='reject') {
                    $('#assetName').val('-');
                    $('#assetDesc').val('-');
                    $('#assetVendor').val('-');
                    $('#assetLocation').val('-');
                }
                document.formAutocare.submit();
                $(this).dialog("close");
            },
            "Cancel": function() {
                $(this).dialog("close");
            }
        }
    });

    $('#buttonConfirmApproved').click(function () {
        var $nameField = $('#assetName');
        var $descField = $('#assetDesc');
        var $vendorField = $('#assetVendor');
        var $remarksField = $('#remarks');
        var $reqField = $('.cssOnBox.reqField');
        var $status = false;
//        console.log($reqField);
        $reqField.each(function() {
            console.log('-'+$(this).val());
            if ($(this).val() != ''){
                $status = true;
            } else {
                $status = false;
                return false;
            }
        });

        if ($descField != '' && $nameField!='' && $vendorField!='' && $remarksField!='') {
            $status = true;
        }

        if ($status) {
        $("#formDialogApproved").html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span>' +
            ' Are you sure the data is correct and you want to closed this approved print ?' +
            '<br/> <em>Please make sure you has write correct information message for accounting team on remarks field</em>' +
            '</p>');
        document.formAutocare.action.value = 'confirm';
        $("#formDialogApproved").dialog('open');
        }
    });

    $('#buttonUpdate').click(function () {
        var $reqField = $('.reqField');
        var $status = false;
        $reqField.each(function() {
            console.log('-'+$(this).val());
            if ($(this).val() != ''){
                $status = true;
            } else {
                $status = false;
                return false;
            }
        });

        if ($status) {
            var $statusField = $('#status').val();
            if ($statusField == 1){
                $("#formDialogApproved").html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span>' +
                    ' Are you sure the data is correct and you want to Update this asset ?');
            } else if($statusField == 0) {
                $("#formDialogApproved").html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span>' +
                    'Your action cannot be undone. Are you sure want <strong> INACTIVE </strong>this asset. ?');
            }
            $("#formDialogApproved").dialog('open');
        }

    });

    $('a.closeApproved').click(function () {
        var name = $("textarea#remarks").val();
        if (name!='') {
            $("#formDialogApproved").html('<p>' +
                '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span> Are you sure want to reject this approved print ? ' +
                '<br/> <em>Please make sure you has write correct information message for accounting team on remarks box </em>' +
                '</p>');
            document.formAutocare.action.value = 'reject';
            $("#formDialogApproved").dialog('open');
        } else {
            console.log('adfaf');
            $("#asset-dialog-notif").html('<p>' +
                '<em>Please add reason on remarks box </em>' +
                '</p>');
            $("#asset-dialog-notif").dialog('open');
        }
        return false;
    });
    //===== Validation engine =====//

    $("#formAutocare").validationEngine();

    $('#asset-dialog-notif').dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        buttons: {
            "Close": function() {
                $(this).dialog("close");
            }
        }
    });

    $('form#formAutocare').submit(function(){
        return false;
    });

    //===== Sortable columns =====//
    $("table").tablesorter();
    //===== Resizable columns =====//
    $("#resize, #resize2").colResizable({
        liveDrag:true,
        draggingClass:"dragging"
    });
    //===== Dynamic table toolbars =====//
    $('#dyn .tOptions').click(function () {
        $('#dyn .tablePars').slideToggle(200);
    });
    $('#dyn2 .tOptions').click(function () {
        $('#dyn2 .tablePars').slideToggle(200);
    });
    $('.tOptions').click(function () {
        $(this).toggleClass("act");
    });

});
