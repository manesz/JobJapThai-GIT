
function showImgLoading() {
    hideImgLoading();
    $("body").append(str_loading);
    $('<div id="screenBlock"></div>').appendTo('body');
    $('#screenBlock').css( { opacity: 0, width: $(document).width(), height: $(document).height() } );
    $('#screenBlock').addClass('blockDiv');
    $('#screenBlock').animate({opacity: 0.7}, 200);
}

function hideImgLoading() {
    $(".img_loading").remove();
    $('#screenBlock').animate({opacity: 0}, 200, function() {
        $('#screenBlock').remove();
    });
}

function scrollToTop(fade_in) {
    fade_in = fade_in || false;
    $("body, html").animate({
            scrollTop: $("body").position().top
        },
        500,
        function () {
            if (fade_in)
                $(fade_in).fadeIn();
        });
}

function showModalMessage(msg, title) {
    title = title || "Message";
    $("#modal_show_message .modal-body").html(msg);
    $("#modal_show_message #myModalMassage").html(title);
    $('#modal_show_message').modal('show');
}

function closeModalMessage() {
    $('#modal_show_message').modal('hide');
}
var wppage = {
    init: function () {
        wppage.addEvent();
        if (typeof jshook !== 'undefined') {
            jshook.init();
        }
    },
    addEvent: function () {
        $('.carousel').carousel({
            interval: 5000
        });
        $('#myTab a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show', 'fast');
        });
    },
    onready: function () {
        wppage.init();
        return false;
    }
};
$(document).ready(wppage.onready);

var post_lost_pass = false;
$(document).ready(function(){
//    $("#lost_password").load(url_lost_password);
    $("#lostpasswordform").submit(function(){
        if (!post_lost_pass) {
            showImgLoading();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                cache: false,
                dataType: 'json',
                success: function (result) {
                    if (result.error) {
                        $("#message_lost_password").html(result.msg);
                    }else {
                        $('#user_login').val('');
                        $("#message_lost_password").html(result.msg);
                    }
                    hideImgLoading();
                    post_lost_pass = false;
                },
                error: function (result) {
                    showModalMessage(result.responseText, 'Error');
                    hideImgLoading();
                    post_lost_pass = false;
                }
            });
        }
        post_lost_pass = true;
        return false;
    });
});