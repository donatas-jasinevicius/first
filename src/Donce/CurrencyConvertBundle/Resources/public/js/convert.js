//$(function () {
//
//    function init_datepicker() {
//        $(".datepicker").datepicker({ dateFormat: "yy-mm-dd" });
//    }
//
//    init_datepicker();
//
//    $('#convert_form_container').bind('submit', '#currency_convert_submit', function (e) {
//        var $form = $("#convert_form");
//
//        $.ajax({
//            type: "POST",
//            url: $form.attr("action"),
//            data: $form.serialize(),
//            dataType: "html",
//            success: function (response) {
//                $("#convert_form_container").html(response);
//                init_datepicker();
//            }
//        });
//
//        return false;
//
//    });
//});