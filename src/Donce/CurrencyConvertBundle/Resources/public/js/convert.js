$(function () {
    function init_datepicker() {
        $(".datepicker").datepicker({ dateFormat: "yy-mm-dd" });
    }

    init_datepicker();

    $('#convert_form_container').bind('submit change', '#currency_convert_submit', function (e) {
        var $form = $("#convert_form");

        if (0 < $('#currency_convert_amount').val().length && 0 < $('#currency_convert_date').val().length) {
            $.ajax({
                type: "POST",
                url: $form.attr("action"),
                data: $form.serialize(),
                dataType: "html",
                success: function (response) {
                    $("#convert_form_container").html(response);
                    init_datepicker();
                }
            });
        }
        return false;

    });
});