$(function() {

    var deleteTheSelectedUrl = '';
// Dialog confirmation delete
    $('#confirmDelete').dialog({
        autoOpen: false,
        width: 400,
        modal:true,
        buttons: {
            "Yes, I'm sure": function() {
                $( this ).dialog( "close" );
                if('' != jQuery.trim(deleteTheSelectedUrl)) {
                    window.location = deleteTheSelectedUrl;
                }
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        }

    });

    $('a.classConfirmDelete').click(function () {
        deleteTheSelectedUrl = $(this).attr('href');
        var name = $(this).parent().parent().children('td.name').html();  // a.delete -> td -> tr -> td.name
        name = jQuery.trim(name);
        $("#confirmDelete").html('Are you sure want to delete item ' + name + ' ?');
        $("#confirmDelete").dialog('open');
        return false;
    });

});