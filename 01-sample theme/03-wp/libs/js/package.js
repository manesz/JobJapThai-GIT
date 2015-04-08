/**
 * Created by Administrator on 8/3/2558.
 */

if (!window.jQuery) {
    var script = document.createElement('script');
    var jqvar = document.getElementById('getjqpath').value;
    script.type = "text/javascript";
    script.src = jqvar;
    document.getElementsByTagName('head')[0].appendChild(script);
}
var $ = jQuery.noConflict();
var check_from_post = false;
$(document).ready(function () {
    $("#frm_package").submit(function () {
        if (!check_from_post) {
            var data = $(this).serialize();
            $.ajax({
                type: "GET",
                dataType: 'json',
                cache: false,
                url: '',
                data: data,
                success: function (result) {
                    alert(result.msg);
                    if (!result.error) {
                        window.location.reload();
                    }
                    check_from_post = false;
                },
                error: function (result) {
                    alert("Error:\n" + result.responseText);
                    hideImgLoading();
                    check_from_post = false;
                }
            });
        }
        check_from_post = true;
        return false;
    });
});

function validateNum(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = /[0-9]/;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault)
            theEvent.preventDefault();
    }
}

function setValuePackage(data) {
    $("#p_count").val(data.count);
    $("#package_id").val(data.id);
    $("#type_post").val('admin_edit');
    //$("#p_title").val(data.title);
    $("#p_text").val(data.text).focus();
    $("#p_value").val(data.value);
    $("#p_price").val(data.price.replace('.00', ''));
    var require = data.require == 1 ? true : false;
    $('#p_require').prop('checked', require);
    $("#btn_cancel").fadeIn();
}

function cancelForm() {
    $("#p_count").val("");
    $("#package_id").val(0);
    $("#type_post").val('admin_add');
    //$("#p_title").val('');
    $("#p_text").val('').focus();
    $("#p_value").val('');
    $("#p_price").val('');
    $('#p_require').prop('checked', false);
    $("#btn_cancel").fadeOut();
}

function deletePackage(id) {
    if (!check_from_post) {
        if (!confirm("ต้องการลบข้อมูล ใช่หรือไม่"))
            return false;
        var data = {
            post_package: 'true',
            package_id: id,
            type_post: 'admin_delete'
        };
        $.ajax({
            type: "GET",
            dataType: 'json',
            cache: false,
            url: '',
            data: data,
            success: function (result) {
                alert(result.msg);
                if (!result.error) {
                    window.location.reload();
                }
                check_from_post = false;
            },
            error: function (result) {
                alert("Error:\n" + result.responseText);
                hideImgLoading();
                check_from_post = false;
            }
        });
    }
    check_from_post = true;
}