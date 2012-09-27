
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

    // Dialog
    $('#detailMember').dialog({
        autoOpen: false,
        width: 500,
        modal: true
    });

});


function detailMember(id){
    console.log('open detail membership of id ' + id);
    $('#detailMember').load("/member/detail/" + id);
    $('#detailMember').dialog('open');
    $('#detailMember').dialog("option", "position", ['center', 'center'] );
}

