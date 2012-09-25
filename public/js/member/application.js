
//===== Wizards =====//
$(function() {

    // Dialog
    $('#formDialog').dialog({
        autoOpen: false,
        width: 400,
        buttons: {
            "Save": function () {
				$('#memberAssignForm').submit();
                $(this).dialog("close");
            }
        }
    });

    // Dialog Link
    $('#formDialog_open').click(function () {
		var data = $(this).attr('additional-value').split(';');
		console.log(data);
		$('#customerId').val($(this).attr('data-value'));
		$('#customerName').html(data[0]);
		$('#customerSince').html(data[1]);
        $('#formDialog').dialog('open');
        return false;
    });

});
