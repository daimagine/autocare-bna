/**
 * Created with JetBrains PhpStorm.
 * User: root
 * Date: 9/30/12
 * Time: 12:35 AM
 * To change this template use File | Settings | File Templates.
 */
$(function() {

    //validation
    $("#formAutocare").validationEngine();

    $('#dialogAdd').dialog({
        autoOpen: false,
        width: 400,
        modal: true,
        resizable: false,
        buttons: {
            "Submit Form": function() {
                document.formAutocare.submit();
                $("#formAutocare").validationEngine();
                $(this).dialog("close");
            },
            "Cancel": function() {
                $(this).dialog("close");
            }
        }
    });

    $('form#formAutocare').submit(function(e){
        e.preventDefault();
        var name = $("input#name").val();
        var price = $("input#price").val();
        var desc = $("input#description").val();
        if(name!='' && desc!='' && price!='' ) {
            $("span#serviceName").html(name);
            $("span#servicePrice").html(price);
            $('#dialogAdd').dialog('open');
        }
        return false;
    });


});