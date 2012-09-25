$(function() {

    $( ".datepicker" ).datepicker({
        showOtherMonths:true,
        autoSize: true,
        appendText: '(dd-mm-yyyy)',
        dateFormat: 'dd-mm-yy'
    });

    //===== Time picker =====//

    $('.timepicker').timeEntry({
        show24Hours: true, // 24 hours format
        showSeconds: true, // Show seconds?
        spinnerImage: '/images/elements/ui/spinner.png', // Arrows image
        spinnerSize: [19, 26, 0], // Image size
        spinnerIncDecOnly: true // Only up and down arrows
    });

    //===== init vehicle dialog =====//
    Customer.Vehicle.initDialog();

});

var Customer = {};
Customer.Vehicle = {
    //selector helper
    _whead  : '#vehicle-whead',
    _body   : '#vehicle-body',
    _notice : '#vehicle-addnotice',
    _rows   : '#vehicle-rows',
    _table  : '#vehicle-table',
    _tbody  : '#vehicle-tbody',
    _dialog : '#vehicle-dialog',
    _customername : '#vehicle-customer-name',
    _customernamefield : '#customer-name',

    //form selector helper
    _form   : {
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
            width: 400,
            buttons: {
                "Save": function () {
                    var success = Customer.Vehicle.add();
                    if(success === true)
                        $(this).dialog('close');
                },
                "Cancel": function () {
                    $(this).dialog('close');
                }
            },
            close: function () {
                Customer.Vehicle.closeDialog();
            }
        });
    },

    //function to open up dialog form
    openDialog : function() {
        var vname = $(this._customername);
        vname.html($(this._customernamefield).val());
        console.log('open up dialog form');
        $(this._dialog).dialog('open');

        //clean up
        $(this._form.no).val('');
		$(this._form.type).val('');
        $(this._form.color).val('');
        $(this._form.model).val('');
        $(this._form.brand).val('');
        $(this._form.desc).val('');
    },

    //function to close dialog form
    closeDialog : function() {
        console.log('do closed procedures on dialog form');
        var vnotice = $(this._notice);
        var vtable = $(this._table);
        var vrows = $(this._rows);
        if(vrows.val() == '0') {
            console.log('no vehicle registered, show notice again');
            vnotice.show();
            vtable.hide();
        }
        //clean up
        $(this._customername).html('');
    },

    //function to add new vehicle
    add : function() {
        console.log('validate forms first');
        if(this._validateNull() !== true)
            return false;

        if(this._validateDuplicate() !== true)
            return false;

        console.log('add dynamic rows to vehicle tbody');
        this._addRow();

        //display table
        var vnotice = $(this._notice);
        var vtable = $(this._table);
        vnotice.hide();
        vtable.show();

        return true;
    },

    _addRow : function() {
        //next idx
        var vrows = $(this._rows);
        var vtable = $(this._table);
		var nextidx = vtable.find('tr').length - 1;
		if(vrows.val().trim() !== '0')
			nextidx = parseInt(vrows.val());
        console.log(nextidx);

        //warning : sequence is really important following thead order
        var td = $('<td class="v-no">').append($(this._form.no).val());
        td.after($('<td>').append($(this._form.type).val()));
        td.after($('<td>').append($(this._form.color).val()));
        td.after($('<td>').append($(this._form.model).val()));
        td.after($('<td>').append($(this._form.brand).val()));
        td.after($('<td>').append($(this._form.desc).val()));
        td.after($('<td>').append(
            $('<a>')
                .attr('href', this._tbody)
                .attr('onclick', 'Customer.Vehicle.remove("v-rows-' + nextidx + '")')
                .text('remove')
        ));

        //hidden input
        var hiddiv = $('<div>').css('display', 'none');
        hiddiv.append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name','vehicles[' + nextidx + '][number]')
                .val($(this._form.no).val())
        );
        hiddiv.append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name','vehicles[' + nextidx + '][type]')
                .val($(this._form.type).val())
        );
        hiddiv.append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name','vehicles[' + nextidx + '][color]')
                .val($(this._form.color).val())
        );
        hiddiv.append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name','vehicles[' + nextidx + '][model]')
                .val($(this._form.model).val())
        );
        hiddiv.append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name','vehicles[' + nextidx + '][brand]')
                .val($(this._form.brand).val())
        );
        hiddiv.append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name','vehicles[' + nextidx + '][description]')
                .val($(this._form.desc).val())
        );
        td.after(hiddiv);

        //insert to tr
        var tr = $('<tr>').attr('id','v-rows-' + nextidx).append(td);
        console.log(tr);
        //add dynamic rows to vehicle tbody based on submitted vehicle form
        var vtbody = $(this._tbody);
        vtbody.append(tr);

        //updating rows
        vrows.val(++nextidx);
        console.log('rows updated to ' + vrows.val());

        //appending hidden fields

    },

    remove : function(id) {
        $('#'+id).remove();
        var row = $(this._table).find('tr').length - 1;
        if(row <= 0) {
            $(this._notice).show();
            $(this._table).hide();
            $(this._rows).val(0);
        }
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

    _validateDuplicate : function() {
        var msg = null;
        $(this._tbody).each(function(index) {
            $('tr .v-no').each(function(index) {
                if($(this).text() === $(Customer.Vehicle._form.no).val().trim())
                    msg = 'Vehicle Number';
            });
        });
        var required = 'Following fields are unique : ' + msg;
        if(msg === null)
            return true;
        else
            alert(required);
        return false;
    }
};