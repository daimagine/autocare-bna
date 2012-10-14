

/**
 * Created with JetBrains PhpStorm.
 * User: root
 * Date: 9/30/12
 * Time: 11:51 AM
 * To change this template use File | Settings | File Templates.
 */
$(function() {

    var selectedUrl = '';
    //validation
    $("#formAutocare").validationEngine();

    //-====================== FORM DIALOG LIST CUSTOMER ========================//
    $('#form-dialog-').dialog({
        autoOpen: false,
        width: 930,
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

    $("#serviceType").change(function(event){
        //alert("Click event on Select has occurred!");
        $("option:selected", $(this)).each(function(){
            var obj = document.getElementById('serviceType').value;
            //            alert("selected value"+obj);
            $("textarea.desc-service").css("display", "none");
            $("#desc-"+obj).css("display", "inline");
        });
    });


    //===== Image gallery control buttons =====//

    $(".gallery ul li").hover(
        function() { $(this).children(".actions").show("fade", 200); },
        function() { $(this).children(".actions").hide("fade", 200); }
    );

    //===== Sortable columns =====//

    $("table").tablesorter();


    //===== Resizable columns =====//

    $("#resize, #resize2").colResizable({
        liveDrag:true,
        draggingClass:"dragging"
    });

    //===== Dynamic data table =====//

    var table=$('.dTable').val();
    console.log('id table define '+table);
//    if (table == 'undefined') {
        console.log('define new table jquery');
        oTable = $('.dTable').dataTable({
            "bJQueryUI": false,
            "bAutoWidth": false,
            "sPaginationType": "full_numbers",
            "sDom": '<"H"fl>t<"F"ip>'
        });
//    }


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

    //===== Tabs =====//
    $.fn.contentTabs = function(){
        $(this).find(".tab_content").hide(); //Hide all content
        $(this).find("ul.tabs li:first").addClass("activeTab").show(); //Activate first tab
        $(this).find(".tab_content:first").show(); //Show first tab content

        $("ul.tabs li").click(function() {
            $(this).parent().parent().find("ul.tabs li").removeClass("activeTab"); //Remove any "active" class
            $(this).addClass("activeTab"); //Add "active" class to selected tab
            $(this).parent().parent().find(".tab_content").hide(); //Hide all tab content
            var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
            $(activeTab).show(); //Fade in the active content
            return false;
        });

    };
    $("div[class^='widget']").contentTabs(); //Run function on any div with class name of "Content Tabs"

    //=========dialog confirmation=========//
    $('#closed_confirmation').dialog({
        autoOpen: false,
        width: 400,
        modal: true,
        resizable: false,
        buttons: {
            "Yes": function() {
                $( this ).dialog( "close" );
                if('' != jQuery.trim(selectedUrl)) {
                    window.location = selectedUrl;
                }
            },
            "Close": function() {
                $( this ).dialog( "close" );
            }
        }
    });

    $('a.buttonAction').click(function () {
        //edit/transactionId
        console.log('open confirmation');
        var mechanicField = $("#mechanicField").val();
        var serviceField = $("#serviceField").val();
        var workorderno = $("#workorderno").val();
        var transactionId = $("#transactionId").val();
        selectedUrl = $(this).attr('href');
        console.log("selectedUrl value "+selectedUrl);
        console.log("transactionId value "+transactionId);
        console.log("workorderno value "+workorderno);
        console.log("mechanicField value "+mechanicField);
        console.log("serviceField value "+serviceField);
        if (serviceField == 0) {
            $("#closed_confirmation").html('Sorry you cant closed this work order, since no<strong> mechanic </strong>assigned for this work order, press button <strong>Yes</strong> to edit this work order ?');
            selectedUrl = '../edit/'+transactionId;
        } else if (mechanicField == 0) {
            $("#closed_confirmation").html('Sorry you cant closed this work order, since no <strong> service </strong>assigned for this work order, press button <strong>Yes</strong> to edit this work order ?');
            selectedUrl = '../edit/'+transactionId;
        } else {
            $("#closed_confirmation").html('Are you sure want to closed workorder <strong> '+workorderno+' </strong> ?');
            selectedUrl = $(this).attr('href');
        }
        name = jQuery.trim(name);
        $("#closed_confirmation").dialog('open');
        return false;
    });

    //===== init customer dialog =====//
    WorkOrder.customer.initDialog();
    WorkOrder.service.initDialog();
    WorkOrder.items.initDialog();
    WorkOrder.mechanic.initDialog();
});


var WorkOrder = {};
WorkOrder.customer = {
    //selector helper
    _method : '#customer-method',
    _addkey : '#customer-addkey',
    _whead  : '#customer-whead',
    _body   : '#customer-body',
    _select : 'a.select',
    _notice : '#vehicle-addnotice',
    _rows   : '#vehicle-rows',
    _table  : '#vehicle-table',
    _tbody  : '#vehicle-tbody',
    _dialogvehicle : '#vehicle-dialog',
    _dialog : '#customer-dialog',
    _vehiclecustomername : '#vehicle-customer-name',
    _customernamefield : '#customer-name',
    _addvehicle : '#add-new-vehicle',

    //form selector helper
    _form   : {
        customerid : '#customerId',
        vehicleid : '#vehicleId',
        customername : '#customerName',
        memberstatus : '#memberStatus',
        no     : '#vehicle-no',
        type   : '#vehicle-type',
        color  : '#vehicle-color',
        model  : '#vehicle-model',
        brand  : '#vehicle-brand',
        desc   : '#vehicle-description'
    },
    //function to initialize dialog form
    initDialog : function() {
        $(this._dialog).dialog({
            autoOpen: false,
            modal: true,
            width: 800,
            buttons: {
                "Cancel": function () {
                    $( this ).dialog( "close" );
                }
            }
        })

        $(WorkOrder.customer._select).click(function () {
            var confirmesi= confirm("Do you want select this customer ??");
            if (confirmesi== true) {
                //-------------get value from table-----------------
                var vehicle_id = $(this).parent().parent().children('th.id').html();
                var vehicle_no = $(this).parent().parent().children('td.vehicleNo').html();
                var type = $(this).parent().parent().children('th.type').html();  // a.delete -> td -> tr -> td.name
                var color = $(this).parent().parent().children('th.color').html();
                var model = $(this).parent().parent().children('th.model').html();
                var brand = $(this).parent().parent().children('th.brand').html();
                var description = $(this).parent().parent().children('th.description').html();
                var customerName = $(this).parent().parent().children('td.customerName').html();
                var customerId = $(this).parent().parent().children('th.customerId').html();
                var customerStatus = $(this).parent().parent().children('th.status').html();

                $(WorkOrder.customer._method).val('list');
                var flag = $(WorkOrder.customer._method).val();
                console.log('============');
                console.log(customerName);
                console.log('============');
                WorkOrder.customer._putVehicle(vehicle_id,vehicle_no,type,color,model,brand,description);
                WorkOrder.customer._putCustomer(customerId,customerName,customerStatus);
                //display table
                var vnotice = $(WorkOrder.customer._notice);
                var vtable = $(WorkOrder.customer._table);
                var vaddlink = $(WorkOrder.customer._addvehicle);
                vnotice.hide();
                vaddlink.hide();
                vtable.show();
                $(WorkOrder.customer._dialog).dialog( "close" );
                console.log('close dialog');
            }else {
                console.log('customer not confirm');
            }
            return false;
        });

        $(this._dialogvehicle).dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            buttons: {
                "Save": function () {
                    var success = WorkOrder.customer.save();
                    if(success === true)
                        $(this).dialog('close');
                },
                "Cancel": function () {
                    $(this).dialog('close');
                }
            },
            close: function () {
                WorkOrder.customer.closeDialog();
            }
        });
    },

    //function to open up dialog form for
    openDialog_lst_customer : function(menu) {
        console.log('open up dialog list customer from menu '+menu);
        if (menu=='add') {
            $(this._dialog).load("lst_customer");
        } else if (menu=='edit') {
            $(this._dialog).load("../lst_customer");
        }
        $(this._dialog).dialog('open');
        return false;
    },

    //function to open up dialog form
    openDialog_vehicle : function() {
        $(this._method).val('add');
        console.log($(this._method));
        var vname = $(this._customername);
        vname.html($(this._customernamefield).val());
        console.log('open up dialog form');
        $(this._dialogvehicle).dialog('open');

        //clean up
        $(this._form.no).val('');
        $(this._form.type).val('');
        $(this._form.color).val('');
        $(this._form.model).val('');
        $(this._form.brand).val('');
        $(this._form.desc).val('');
        $(this._addkey).val('');
    },

    selectCustomer : function() {
        var confirmesi= confirm("Do you want select this customer ??");
        if (confirmesi== true) {
            this._putVehicle();
            this._putCustomer();
            this.run_again();
            //display table
            var vnotice = $(this._notice);
            var vtable = $(this._table);
            vnotice.hide();
            vtable.show();
            $(this._dialog).dialog('close');
            console.log('close dialog');
        }else {
            console.log('customer not confirm');
        }
    },
    _putCustomer : function(customerid,customername, customerstatus) {
        //put customer name and status
        $(this._form.customerid).val(customerid);
        $(this._form.customername).val(customername);
        $(this._form.memberstatus).val(customerstatus);
    },
    remove : function() {
        $('#v-rows').remove();
        var vnotice = $(WorkOrder.customer._notice);
        var vtable = $(WorkOrder.customer._table);
        var vaddlink = $(WorkOrder.customer._addvehicle);
        vnotice.show();
        vaddlink.show();
        vtable.hide();
    },
    //function to close dialog form
    closeDialog : function() {
        console.log('do closed procedures on dialog form');
        $(this._dialog).dialog('close');
    },
    _putVehicle : function(
        vehicle_id,
        vehicle_no,
        type,
        color,
        model,
        brand,
        description
        ) {
        this.remove();
        //next idx
        var vrows = $(this._rows);
        var vtable = $(this._table);
        var nextidx = vtable.find('tr').length - 1;
        if(vrows.val().trim() !== '0')
            nextidx = parseInt(vrows.val());
        console.log(nextidx);

        //warning : sequence is really important following thead order
        var td = $('<td class="v-no v-num">').append(vehicle_no);
        td.after($('<td class="v-type">').append(type));
        td.after($('<td class="v-color">').append(color));
        td.after($('<td class="v-model">').append(model));
        td.after($('<td class="v-brand">').append(brand));
        td.after($('<td class="v-desc">').append(description));

        var divv = '';
        var flag = $(this._method).val();
        if(flag=='add') {
            divv = $('<div>').append(
                $('<a>')
                    .attr('href', this._tbody)
                    .attr('onclick', 'WorkOrder.customer.edit("v-rows-' + nextidx + '", "' + nextidx + '")')
                    .text('edit | ')
                    .after(
                    $('<a>')
                        .attr('href', this._tbody)
                        .attr('onclick', 'WorkOrder.customer.remove()')
                        .text('remove')
                )
            );
        } else if (flag=='list') {
            divv = $('<div>').append(
                $('<a>')
                    .attr('href', this._tbody)
                    .attr('onclick', 'WorkOrder.customer.remove()')
                    .text('remove')
            );
        }

        td.after($('<td>').append(divv));

        //hidden input
        var hiddiv = $('<div>').css('display', 'none');
        hiddiv.append(
            $('<input>')
                .attr('class', 'v-id-hid')
                .attr('type', 'hidden')
                .attr('name','vehiclesid')
                .val(vehicle_id)
        );
        hiddiv.append(
            $('<input>')
                .attr('class', 'v-num-hid')
                .attr('type', 'hidden')
                .attr('name','vehiclesnumber')
                .val(vehicle_no)
        );
        hiddiv.append(
            $('<input>')
                .attr('class', 'v-type-hid')
                .attr('type', 'hidden')
                .attr('name','vehiclestype')
                .val(type)
        );
        hiddiv.append(
            $('<input>')
                .attr('class', 'v-color-hid')
                .attr('type', 'hidden')
                .attr('name','vehiclescolor')
                .val(color)
        );
        hiddiv.append(
            $('<input>')
                .attr('class', 'v-brand-hid-' + nextidx)
                .attr('type', 'hidden')
                .attr('name','vehiclesbrand')
                .val(brand)
        );
        hiddiv.append(
            $('<input>')
                .attr('class', 'v-desc-hid')
                .attr('type', 'hidden')
                .attr('name','vehiclesdescription')
                .val(description)
        );
        hiddiv.append(
            $('<input>')
                .attr('class', 'v-model-hid')
                .attr('type', 'hidden')
                .attr('name','vehiclesmodel')
                .val(model)
        );
        hiddiv.append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name','vehiclesstatus')
                .val(1)
        );
        td.after(hiddiv);

        //insert to tr
        var tr = $('<tr>').attr('id','v-rows').append(td);
        console.log(tr);
        //add dynamic rows to vehicle tbody based on submitted vehicle form
        var vtbody = $(this._tbody);
        vtbody.append(tr);

        //updating rows
        vrows.val(++nextidx);
        console.log('rows updated to ' + vrows.val());

    },


    //will be replace as select action
    save : function() {
        var flag = $(this._method).val();
        console.log(flag);
        if(flag == 'add')
            return this.add();
        if(flag == 'edit')
            return this.update();
    },

    add : function() {
        console.log('validate forms first');
        if(this._validateNull() !== true)
            return false;

        var vehicle_no =$(this._form.no).val();
        var type =$(this._form.type).val();
        var color = $(this._form.color).val();
        var model =$(this._form.model).val();
        var brand = $(this._form.brand).val();
        var description =$(this._form.desc).val();

        console.log('add dynamic rows to vehicle tbody');
        this._putVehicle(0,vehicle_no, type, color,model,brand,description);

        //display table
        var vnotice = $(this._notice);
        var vtable = $(this._table);
        var vaddlink = $(this._addvehicle);
        vnotice.hide();
        vaddlink.hide();
        vtable.show();

        return true;
    },

    _validateNull : function() {
        var msg = null;
        if($(this._form.no).val().trim() === '') {
            msg = 'Vehicle Number';
        }
        var required = 'Following fields are required : ' + msg;
        if(msg === null)
            return true;
        else
            alert(required);
        return false;
    },

    //function to open up edit dialog form
    edit : function(id, idx) {
        $(this._method).val('edit');
        var vname = $(this._customername);
        vname.html($(this._customernamefield).val());
        console.log('open up edit dialog form');
        $(this._dialogvehicle).dialog('open');

        console.log(id + ', ' + idx);
        var row = $('#'+id);
        $(this._addkey).val(id);

        //clean up
        $(this._form.no).val('');
        $(this._form.type).val('');
        $(this._form.color).val('');
        $(this._form.model).val('');
        $(this._form.brand).val('');
        $(this._form.desc).val('');
        $(this._addkey).val('');

        var num = $('td.v-no').html();
        var type = $('td.v-type').html();
        var color = $('td.v-color').html();
        var model = $('td.v-model').html();
        var brand = $('td.v-brand').html();
        var desc = $('td.v-desc').html();
        console.log('type '+type);

        //clean up
        $(this._form.no).val(num);
        $(this._form.type).val(type);
        $(this._form.color).val(color);
        $(this._form.model).val(model);
        $(this._form.brand).val(brand);
        $(this._form.desc).val(desc);
    },
    //function to add new vehicle
    update : function() {
        var id = $(this._addkey).val();
        console.log('update rows : ' + id);

        console.log('validate forms first');
        if(this._validateNull() !== true)
            return false;

        var row = $('#'+id);
        console.log(row);
//        var idx = id.slice(-1);

        $('td.v-num').html($(this._form.no).val());
        $('input.v-num-hid').val($(this._form.no).val());

        $('td.v-type').html($(this._form.type).val());
        $('input.v-type-hid').val($(this._form.type).val());

        $('td.v-color').html($(this._form.color).val());
        $('input.v-color-hid').val($(this._form.color).val());

        $('td.v-model').html($(this._form.model).val());
        $('input.v-model-hid').val($(this._form.model).val());

        $('td.v-brand').html($(this._form.brand).val());
        $('input.v-brand-hid').val($(this._form.brand).val());

        $('td.v-desc').html($(this._form.desc).val());
        $('input.v-desc-hid').val($(this._form.desc).val());

        return true;
    },

    run_again : function() {
        //===== Form elements styling =====//
        $("select, .check, .check :checkbox, input:radio, input:file").uniform();
        console.log('rerun select option');

    }
};

WorkOrder.service = {
    //selector helper
    _isselect : new Boolean(),
    _servicetype : '#serviceType',
    _rows   : '#service-rows',
    _table  : '#service-table',
    _tbody  : '#service-tbody',
    _dialogservice : '#service-dialog',
    _addservice : '#add-service',

    //form selector helper
    _form_service   : {
        no     : '#service-no',
        name   : '#service-name',
        price  : '#service-price-',
        desc  : '#desc-'
    },

    initDialog : function() {
        $(this._dialogservice).dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            buttons: {
                "Save": function () {
                    var s_id = $('#serviceType').val();
                    console.log('service type id is '+s_id);
                    var success = WorkOrder.service._addRow(s_id);
                    if(success === true)
                        $(this).dialog('close');
                },
                "Cancel": function () {
                    $(this).dialog('close');
                }
            }
        });

        $(WorkOrder.service._addservice).click(function () {
            var s_id = $('#serviceType').val();
            if (s_id > 0) {
                if(WorkOrder.service._validateDuplicate(s_id) !== true)
                    return false;
                var serviceName = $("#serviceType option:selected").text();
                $(WorkOrder.service._dialogservice).html('Are you sure want add service '+serviceName+' ?');
                $(WorkOrder.service._dialogservice).dialog('open');
            } else {
                alert('please select service first');
            }
            return false;
        });
    },
    _validateDuplicate : function(id) {
        var msg = null;
        console.log('id is '+id);
        $(this._tbody).each(function(index) {
            console.log('masuk loop 1');
            $('tr .s-no').each(function(index) {
                console.log('masuk loop '+index);
                    var test = 'input.s-no-hid-'+index;
                    console.log('value '+test);
                    if($(test).val() === id) {
                        msg = 'Service Number';
                    }
            });
        });
        var required = 'Following fields are unique : ' + msg;
        if(msg === null)
            return true;
        else
            alert(required);
        return false;
    },
   _addRow : function(s_id) {
       //next idx
       var vrows = $(this._rows);

       var vtable = $(this._table);
       var nextidx = vtable.find('tr').length - 1;
       if(vrows.val().trim() !== '0'){
           nextidx = parseInt(vrows.val());}
       console.log(nextidx);
       var no = nextidx+1;

       var servicename = $(this._servicetype+' option:selected').text();
       var serviceprice = $(this._form_service.price+s_id).val();
       var servicedesc = $(this._form_service.desc+s_id).val();

       //warning : sequence is really important following thead order
       var td = $('<td class="s-no s-num-' + nextidx + '">').append(no);
       td.after($('<td class="s-name-' + nextidx + '">').append(servicename));
       td.after($('<td class="s-price-' + nextidx + '">').append(serviceprice));
       td.after($('<td class="s-desc-' + nextidx + '">').append(servicedesc));

       var divv = $('<div>').append(
           $('<a>')
               .attr('href', this._tbody)
               .attr('onclick', 'WorkOrder.service.remove("s-rows-' + nextidx + '")')
               .text('remove')
       );
       td.after($('<td>').append(divv));

       //hidden input
       var hiddiv = $('<div>').css('display', 'none');
       hiddiv.append(
           $('<input>')
               .attr('class', 's-no-hid-' + nextidx)
               .attr('type', 'hidden')
               .attr('name','services[' + nextidx + '][service_formula_id]')
               .val(s_id)
       );
       td.after(hiddiv);

       //insert to tr
       var tr = $('<tr>').attr('id','s-rows-' + nextidx).append(td);
       console.log(tr);
       //add dynamic rows to vehicle tbody based on submitted vehicle form
       var vtbody = $(this._tbody);
       vtbody.append(tr);

       //updating rows
       vrows.val(++nextidx);
       console.log('rows updated to ' + vrows.val());
       return true;
   },
    remove : function(id) {
        $('#'+id).remove();
        var row = $(this._table).find('tr').length - 1;
    }
};


WorkOrder.items = {
    //selector helper
    _addkey : '#item-addkey',
    _whead  : '#item-whead',
    _body   : '#item-body',
    _select : 'a.select-item',
    _notice : '#item-addnotice',
    _rows   : '#item-rows',
    _table  : '#item-table',
    _tbody  : '#item-tbody',
    _dialogitems : '#item-dialog',

    //function to initialize dialog form
    initDialog : function() {
        $(this._dialogitems).dialog({
            autoOpen: false,
            modal: true,
            width: 800,
            buttons: {
                "Done": function () {
                    $( this ).dialog( "close" );
                }
            }
        });

        $(WorkOrder.items._select).click(function () {
            var confirmesi= confirm("Do you want select this items ??");
            var item_id = $(this).parent().parent().children('th.item-id').html();

            //check duplicate id
            if(WorkOrder.items._validateDuplicate(item_id) !== true)
                return false

            if (confirmesi== true) {
                //-------------get value from table-----------------
                var type = $(this).parent().parent().children('td.type').html();  // a.delete -> td -> tr -> td.name
                var unit = $(this).parent().parent().children('td.unit').html();
                var code = $(this).parent().parent().children('td.code').html();
                var name = $(this).parent().parent().children('td.name').html();
                var vendor = $(this).parent().parent().children('td.vendor').html();
                var price = $(this).parent().parent().children('td.price').html();
                var total = $(this).parent().parent().children('th.total').html();
                console.log('============');
                console.log(name);
                console.log('============');
                WorkOrder.items._addRow(item_id,type,unit,code,name,vendor,price,total);
                //display table
                var vnotice = $(WorkOrder.items._notice);
                var vtable = $(WorkOrder.items._table);
                vnotice.hide();
                vtable.show();
                alert('success add items '+name);
//                $(WorkOrder.customer._dialog).dialog( "close" );
//                console.log('close dialog');
            }else {
                console.log('customer not confirm');
            }
            return false;
        });
    },

    //function to open up dialog items list
    openDialog_lst_items : function(menu) {
        console.log('open up dialog form list items');
        if (menu=='add') {
            $(this._dialogitems).load("lst_items");
        } else if (menu=='edit') {
            $(this._dialogitems).load("../lst_items");
        }
        $(this._dialogitems).dialog('open');
        return false;
    },

    _validateDuplicate : function(id) {
        var msg = null;
        console.log('id is '+id);
        $(this._tbody).each(function(index) {
            console.log('masuk loop 1');
            $('tr .i-no').each(function(index) {
                console.log('masuk loop '+index);
                var test = 'input.i-no-hid-'+index;
                console.log('value '+test);
                if($(test).val() === id) {
                    msg = 'Service Number';
                }
            });
        });
        var required = 'Following fields are unique : ' + msg;
        if(msg === null)
            return true;
        else
            alert(required);
        return false;
    },

    _addRow : function(item_id,type,unit,code,name,vendor,price,total) {
        //next idx
        var irows = $(this._rows);
        var stable = $(this._table);
        var nextidx = stable.find('tr').length - 1;
        if(irows.val().trim() !== '0'){
            nextidx = parseInt(irows.val());}
        console.log(nextidx);

        //warning : sequence is really important following thead order
        var td = $('<td class="i-no i-type-' + nextidx + '">').append(type);
        td.after($('<td class="i-unit-' + nextidx + '">').append(unit));
        td.after($('<td class="i-code-' + nextidx + '">').append(code));
        td.after($('<td class="i-name-' + nextidx + '">').append(name));
        td.after($('<td class="i-vendor-' + nextidx + '">').append(vendor));
        td.after($('<td class="i-price-' + nextidx + '">').append(price));
        td.after($('<td class="i-total-' + nextidx + '">').append(1)); //just temporary

        var divv = $('<div>').append(
            $('<a>')
                .attr('href', this._tbody)
                .attr('onclick', 'WorkOrder.items.remove("i-rows-' + nextidx + '")')
                .text('remove')
        );
        td.after($('<td>').append(divv));

        //hidden input
        var hiddiv = $('<div>').css('display', 'none');
        hiddiv.append(
            $('<input>')
                .attr('class', 'i-no-hid-' + nextidx)
                .attr('type', 'hidden')
                .attr('name','items[' + nextidx + '][item_id]')
                .val(item_id)
        );
        hiddiv.append(
            $('<input>')
                .attr('class', 'i-qty-hid-' + nextidx)
                .attr('type', 'hidden')
                .attr('name','items[' + nextidx + '][quantity]')
                .val(item_id)
        );
        td.after(hiddiv);

        //insert to tr
        var tr = $('<tr>').attr('id','i-rows-' + nextidx).append(td);
        console.log(tr);
        //add dynamic rows to vehicle tbody based on submitted vehicle form
        var vtbody = $(this._tbody);
        vtbody.append(tr);

        //updating rows
        irows.val(++nextidx);
        console.log('rows updated to ' + irows.val());
        return true;
    },
    remove : function(id) {
        $('#'+id).remove();
        var row = $(this._table).find('tr').length - 1;
    }
};

WorkOrder.mechanic = {
    //selector helper
    _isselect : new Boolean(),
    _mechanic : '#mechanic',
    _mechanicname : '#mechanic option:selected',
    _rows   : '#mechanic-rows',
    _table  : '#mechanic-table',
    _tbody  : '#mechanic-tbody',
    _dialogmechanic : '#mechanic-dialog',
    _addmechanic : '#add-mechanic',


    initDialog : function() {
        $(this._dialogmechanic).dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            buttons: {
                "Save": function () {
                    var s_id =  $(WorkOrder.mechanic._mechanic).val();
                    console.log('mechanic id is '+s_id);
                    var success = WorkOrder.mechanic._addRow(s_id);
                    if(success === true)
                        $(this).dialog('close');
                },
                "Cancel": function () {
                    $(this).dialog('close');
                }
            }
        });

        $(WorkOrder.mechanic._addmechanic).click(function () {
            var s_id = $(WorkOrder.mechanic._mechanic).val();
            if (s_id > 0) {
                if(WorkOrder.mechanic._validateDuplicate(s_id) !== true)
                    return false;
                var mechanicName = $(WorkOrder.mechanic._mechanicname).text();
                $(WorkOrder.mechanic._dialogmechanic).html('Are you sure want assign mechanic '+mechanicName+' ?');
                $(WorkOrder.mechanic._dialogmechanic).dialog('open');
            } else {
                alert('please select Mechanic first');
            }
            return false;
        });
    },
    _validateDuplicate : function(id) {
        var msg = null;
        console.log('id is '+id);
        $(this._tbody).each(function(index) {
            console.log('masuk loop 1');
            $('tr .m-no').each(function(index) {
                console.log('masuk juga loop '+index);
                var test = 'input.m-no-hid-'+index;
                console.log('value '+test);
                if($(test).val() === id) {
                    msg = 'Mechanic Number';
                }
            });
        });
        var required = 'Following fields are unique : ' + msg;
        if(msg === null)
            return true;
        else
            alert(required);
        return false;
    },
    _addRow : function(s_id) {
        //next idx
        var mrows = $(this._rows);
        var mtable = $(this._table);
        var nextidx = mtable.find('tr').length - 1;
        if(mrows.val().trim() !== '0'){
            nextidx = parseInt(mrows.val());}
        console.log(nextidx);
        var no = nextidx+1;

        var mechanicName = $(this._mechanicname).text();

        //warning : sequence is really important following thead order
        var td = $('<td class="m-no m-num-' + nextidx + '">').append(no);
        td.after($('<td class="m-name-' + nextidx + '">').append(mechanicName));

        var divv = $('<div>').append(
            $('<a>')
                .attr('href', this._tbody)
                .attr('onclick', 'WorkOrder.mechanic.remove("m-rows-' + nextidx + '")')
                .text('remove')
        );
        td.after($('<td>').append(divv));

        //hidden input
        var hiddiv = $('<div>').css('display', 'none');
        hiddiv.append(
            $('<input>')
                .attr('class', 'm-no-hid-' + nextidx)
                .attr('type', 'hidden')
                .attr('name','users[' + nextidx + '][user_id]')
                .val(s_id)
        );
        td.after(hiddiv);

        //insert to tr
        var tr = $('<tr>').attr('id','m-rows-' + nextidx).append(td);
        console.log(tr);
        //add dynamic rows to vehicle tbody based on submitted vehicle form
        var vtbody = $(this._tbody);
        vtbody.append(tr);

        //updating rows
        mrows.val(++nextidx);
        console.log('rows updated to ' + mrows.val());
        return true;
    },
    remove : function(id) {
        $('#'+id).remove();
        var row = $(this._table).find('tr').length - 1;
    }
}