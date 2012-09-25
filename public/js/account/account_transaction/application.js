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

});