var $ = jQuery.noConflict();
$(function () {

    $("#query_post").submit(function(){
        $("#result").text('Process...');
        $.ajax({
            type: "POST",
            //cache: false,
            //dataType: 'json',
            url: '',
            data: $(this).serialize(),
            success: function (data) {
                $("#result").text(data);
            }
        })
            .fail(function () {
                alert("เกิดข้อผิดพลาด");
            });
        /*$.post( "", $(this).serialize())
            .done(function( data ) {
                $("#result").text(data);
            });*/
        return false;
    });
});
