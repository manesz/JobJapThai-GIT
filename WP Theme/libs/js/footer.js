
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
    title = title | "Error";
    $("#modal_show_message .modal-body").html(msg);
    $("#modal_show_message #myModalMassage").html(title);
    $('#modal_show_message').modal('show');
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
            e.preventDefault()
            $(this).tab('show', 'fast');
        });
    },
    onready: function () {
        wppage.init();
        return false;
    }
};
$(document).ready(wppage.onready);