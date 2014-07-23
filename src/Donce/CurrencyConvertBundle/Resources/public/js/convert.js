$(function() {
    $( ".datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });

    $('#convert_form').submit(function(e) {

        var url = $(this).attr("action");

        $.ajax({
            type: "POST",
            url: url, // Or your url generator like Routing.generate('discussion_create')
            data: $(this).serialize(),
            dataType: "html",
            success: function(msg){

                alert("Success!");

            }
        });

        return false;

    });
});