/**
 * Created by Administrator on 13/12/2557.
 */

$(document).on("submit", "#frm_employer_register", function (e) {
    var data = $(this).serialize();
    var url = $(this).attr('action');
    showImgLoading();
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (result) {
            if (result != 'success') {
                alert(result);
            } else {
                alert(result);
            }
            hideImgLoading();
        },
        error: function (result) {
            alert("Error:\n" + result.responseText);
            hideImgLoading();
        }
    });
    return false;
});