/**
 * Created with JetBrains PhpStorm.
 * User: root
 * Date: 11/7/12
 * Time: 3:07 AM
 * To change this template use File | Settings | File Templates.
 */


$(function() {

    //===== Dynamic data table =====//

    oTable = $('.dTableWarehouseItem').dataTable({
        "bJQueryUI": false,
        "bAutoWidth": true,
        "sPaginationType": "full_numbers",
        "sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
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

    console.log(oTable.attr('dtable-sortlist'));
    try {
        if(oTable) {
            //console.log(oTable.attr('dtable-sortlist'));
            if(oTable.attr('dtable-sortlist')) {
                oTable.fnSort( eval(oTable.attr('dtable-sortlist')) );
            }
        }
    } catch (err) {
        console.log(err);
    }


    oTableMin = $('.dTableWarehouseItemMin').dataTable({
        "bJQueryUI": false,
        "bAutoWidth": true,
        "sPaginationType": "full_numbers",
        "sDom": '<"H"fl>t<"F"ip>',
        "sScrollX": "100%",
        "sScrollXInner": "100%"
    });

//    console.log(oTableMin.attr('dtable-sortlist'));
    try {
        if(oTableMin) {
            //console.log(oTableMin.attr('dtable-sortlist'));
            if(oTableMin.attr('dtable-sortlist')) {
                oTableMin.fnSort( eval(oTableMin.attr('dtable-sortlist')) );
            }
        }
    } catch (err) {
        console.log(err);
    }

//    $("#itemCategory").change(function(event){
//        $("option:selected", $(this)).each(function(){
//            var obj = document.getElementById('itemCategory').value;
//            console.log('Object value is '+obj);
//            $("#divType").load("lst_unit_type/"+obj);
//        });
//    });

});
