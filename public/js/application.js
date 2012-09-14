/**
 * Created with JetBrains PhpStorm.
 * User: adikurniawan
 * Date: 9/14/12
 * Time: 12:38 AM
 * To change this template use File | Settings | File Templates.
 */

$(function() {

    //===== Left navigation styling =====//

    $('.subNav li a.this').parent('li').addClass('activeli');


    //===== Login pic hover animation =====//

    $(".loginPic").hover(
        function() {

            $('.logleft, .logback').animate({left:10, opacity:1},200);
            $('.logright').animate({right:10, opacity:1},200); },

        function() {
            $('.logleft, .logback').animate({left:0, opacity:0},200);
            $('.logright').animate({right:0, opacity:0},200); }
    );


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

    oTable = $('.dTable').dataTable({
        "bJQueryUI": false,
        "bAutoWidth": false,
        "sPaginationType": "full_numbers",
        "sDom": '<"H"fl>t<"F"ip>'
    });


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


    //== Adding class to :last-child elements ==//

    $(".subNav li:last-child a, .formRow:last-child, .userList li:last-child, table tbody tr:last-child td, .breadLinks ul li ul li:last-child, .fulldd li ul li:last-child, .niceList li:last-child").addClass("noBorderB")


    //===== Add classes for sub sidebar detection =====//

    if ($('div').hasClass('secNav')) {
        $('#sidebar').addClass('with');
        //$('#content').addClass('withSide');
    }
    else {
        $('#sidebar').addClass('without');
        $('#content').css('margin-left','100px');//.addClass('withoutSide');
        $('#footer > .wrapper').addClass('fullOne');
    };


    //===== Breadcrumbs =====//

    $('#breadcrumbs').xBreadcrumbs();


    //===== User nav dropdown =====//

    $('a.leftUserDrop').click(function () {
        $('.leftUser').slideToggle(200);
    });
    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (! $clicked.parents().hasClass("leftUserDrop"))
            $(".leftUser").slideUp(200);
    });


    //===== Tooltips =====//

    $('.tipN').tipsy({gravity: 'n',fade: true, html:true});
    $('.tipS').tipsy({gravity: 's',fade: true, html:true});
    $('.tipW').tipsy({gravity: 'w',fade: true, html:true});
    $('.tipE').tipsy({gravity: 'e',fade: true, html:true});


    //===== Add class on #content resize. Needed for responsive grid =====//

    $('#content').resize(function () {
        var width = $(this).width();
        if (width < 769) {
            $(this).addClass('under');
        }
        else { $(this).removeClass('under') }
    }).resize(); // Run resize on window load


    //===== Button for showing up sidebar on iPad portrait mode. Appears on right top =====//

    $("ul.userNav li a.sidebar").click(function() {
        $(".secNav").toggleClass('display');
    });

    //===== Form elements styling =====//
    $("select, .check, .check :checkbox, input:radio, input:file").uniform();

});