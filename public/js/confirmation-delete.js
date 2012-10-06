/**
 * Created with JetBrains PhpStorm.
 * User: root
 * Date: 9/30/12
 * Time: 1:46 AM
 * To change this template use File | Settings | File Templates.
 */

$(function () {

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
        $("#confirmDelete").html('Are you sure want to inactive field <b>' + name + ' </b> ?');
        $("#confirmDelete").dialog('open');
        return false;
    });
});
