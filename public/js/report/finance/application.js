/**
 * Created with JetBrains PhpStorm.
 * User: adi
 * Date: 11/4/12
 * Time: 2:57 PM
 * To change this template use File | Settings | File Templates.
 */

$(function() {

    $( ".datepicker" ).datepicker({
        showOtherMonths:true,
        autoSize: true,
        appendText: '(dd-mm-yyyy)',
        dateFormat: 'dd-mm-yy',
        minDate: '-5Y'
    });

    $('.monthpicker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        minDate: '-5Y',
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
            console.log($(this).attr('data-mask'));
            var id = $(this).attr('data-mask');
            month = parseInt(month) + 1;
            $('#'+id).val( 1 + "-" + month + "-" + year );
            console.log($('#'+id));
        }
    });

    //===== Dynamic data table =====//

    oTable = $('.dTableTransaction').dataTable({
        "bJQueryUI": false,
        "bAutoWidth": true,
        "sPaginationType": "full_numbers",
        "sDom":  'T<"clear"><"H"lf>rt<"F"ip>',
//        "sDom": '<"H"fl>t<"F"ip>',
//        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
            "sSwfPath": "../../media/swf/copy_csv_xls_pdf.swf",
            "mColumns": "visible",
            "aButtons":    [
                {
                    "sExtends":    "copy",
                    "bSelectedOnly": "true",
                    "sButtonText": "Copy To Cliboard"
                },
                {
                    "sExtends": "xls",
                    "sPdfOrientation": "landscape",
                    "sButtonText": "Save to Excel"
                },
                {
                    "sExtends": "pdf",
                    "sPdfOrientation": "landscape",
                    "sButtonText": "Save to PDF"
                }
            ]
        },
        "sScrollX": "100%",
        "sScrollXInner": "160%"
    });

    try {
        if(oTable) {
//            console.log(oTable.attr('dtable-sortlist'));
            if(oTable.attr('dtable-sortlist')) {
                oTable.fnSort( eval(oTable.attr('dtable-sortlist')) );
            }
        }
    } catch (err) {
        console.log(err);
    }


    oTableMin = $('.dTableTransactionMin').dataTable({
        "bJQueryUI": false,
        "bAutoWidth": true,
        "sPaginationType": "full_numbers",
        "sDom":  'T<"clear"><"H"lf>rt<"F"ip>',
//        "sDom": '<"H"fl>t<"F"ip>',
//        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
            "sSwfPath": "../../media/swf/copy_csv_xls_pdf.swf",
            "mColumns": "visible",
            "aButtons":    [
                {
                    "sExtends":    "copy",
                    "bSelectedOnly": "true",
                    "sButtonText": "Copy To Cliboard"
                },
                {
                    "sExtends": "xls",
                    "sPdfOrientation": "landscape",
                    "sButtonText": "Save to Excel"
                },
                {
                    "sExtends": "pdf",
                    "sPdfOrientation": "landscape",
                    "sButtonText": "Save to PDF"
                }
            ]
        },
        "sScrollX": "100%",
        "sScrollXInner": "100%"
    });

    try {
        if(oTableMin) {
            console.log(oTableMin.attr('dtable-sortlist'));
            if(oTableMin.attr('dtable-sortlist')) {
                oTableMin.fnSort( eval(oTableMin.attr('dtable-sortlist')) );
            }
        }
    } catch (err) {
        console.log(err);
    }

});


