var $ = jQuery.noConflict();
$(function () {

    $("#other_setting_post").submit(function(){
        $.ajax({
            type: "GET",
            cache: false,
            dataType: 'json',
            url: '',
            data: $(this).serialize(),
            success: function (data) {
                if (data.error) {
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            }
        })
            .fail(function () {
                alert("เกิดข้อผิดพลาด");
            });
        return false;
    });
});
