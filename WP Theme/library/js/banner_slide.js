/**
 * Created with JetBrains PhpStorm.
 * User: Administrator
 * Date: 19/2/2557
 * Time: 2:03 น.
 * To change this template use File | Settings | File Templates.
 */

if (!window.jQuery) {
    var script = document.createElement('script');
    var jqvar = document.getElementById('getjqpath').value;
    script.type = "text/javascript";
    script.src = jqvar;
    document.getElementsByTagName('head')[0].appendChild(script);
}
var $ = jQuery.noConflict(), swithEd = null, tabcurrent = '#tab1', sbasepath, uploadID = '', uploadImg = '', storeSendToEditor = '', newSendToEditor = '', updatestage = false;
var post_page = "banner_slide";
$(document).ready(function () {
    sbasepath = $('#getbasepath').val();
    reloadByHash();
    storeSendToEditor = window.send_to_editor;
    newSendToEditor = function (html) {
        imgurl = jQuery('img', html).attr('src');
        $(uploadID).val(imgurl);
        if (uploadImg) {
            $(uploadImg).attr('src', imgurl);
            uploadImg = '';
        }
        tb_remove();
        window.send_to_editor = storeSendToEditor;
    };
    getEventTabClick();
});
function getEventTabClick() {
    $('li#tab1').click(function () {
        window.location.hash = '#tab1';
        reloadByHash();
        return false;
    });
    $('li#tab2').click(function () {
        window.location.hash = '#tab2';
        reloadByHash();
        return false;
    });
    $('li#tab3').click(function () {
        window.location.hash = '#tab3';
        reloadByHash();
        return false;
    });
}
function reloadByHash() {
    checkEventTab();
}
/* Event Image Gallery function */
function getEventImageGallery() {
    getGalleryList();
    $('#gallery-post').submit(function () {
        if (checkFormInput()) {
            getJsonAdd();
        }
        return false;
    });
}

function getGalleryList(url) {
    var myurl = url ? url : $('input#siteurl').val();
    $('div#slidelist-stage').html(getLoadingPage());
    /*$.ajax({
     url: myurl,
     async: false,
     jsonpCallback: 'jsonCallback',
     contentType: "application/json",
     dataType: 'jsonp',
     data: {
     post_page: post_page,
     ran: Math.random(),
     typePost: 'json_banner_slide',
     callback: 'jsonCallback'
     },
     success: function (data) {alert(data)
     if (data.data) {
     var mytxt = '<ul>';
     $.each(data.data, function (index, value) {
     mytxt += listMenuGallery(value.image_path, value.id, value.title);
     });
     mytxt += '</ul><div class="clear"></div><div class="pagination">' + data.pagination + '</div>';
     $('div#slidelist-stage').html(mytxt);
     delete mytxt;
     getGalleryEvent();
     } else {
     $('div#slidelist-stage').html('<h3 style="text-align:center">ยังไม่มีข้อมูล</h3>');
     }
     }, error: function(){
     $('div#slidelist-stage').html('<h3 style="text-align:center">เกิดข้อผิดพลาด</h3>');
     }
     });*/
    $.ajax({
        type: "POST",
        cache: false,
//        contentType: "application/json",
        dataType: 'json',
        url: myurl,
        data: {
            post_page: post_page,
            ran: Math.random(),
            typePost: 'json_banner_slide',
            callback: 'jsonCallback'
        },
        success: function (data) {//alert(data);return true;
            if (data.data) {
                var mytxt = '<ul id="sortable">';
                $.each(data.data, function (index, value) {
                    mytxt += listMenuGallery(value.image_path, value.id, '');
                });
                mytxt += '</ul><div class="clear"></div><div class="pagination">' + data.pagination + '</div>';
                $('div#slidelist-stage').html(mytxt);
                delete mytxt;
                getGalleryEvent();
                $('#sortable').sortable();
//                $('#draggables li').draggable({
//                    connectToSortable: '#sortable',
//                    helper: 'clone',
//                    revert: 'invalid',
//                    cursor: 'move'
//                });
//                ​$('#sortable').sortable('disable');
                // disable the *sortable* functionality while retaining the *droppable*
                $('#sortable').droppable({
                    drop: function(ev, ui){
                        $(ui.draggable).html('<div>' + ui.draggable.text() + '</div>');
                    }
                });
            } else {
                $('div#slidelist-stage').html('<h3 style="text-align:center">ยังไม่มีข้อมูล</h3>');
            }
        }
    })
        .done(function () {
            //alert("second success");
        })
        .fail(function () {
            $('div#slidelist-stage').html('<h3 style="text-align:center">เกิดข้อผิดพลาด</h3>');
        })
        .always(function () {
            //alert("finished");
        });
    return false;
}

function getJsonAdd() {
    statusUpdate('Loading...', '#0C6');
    /*$.ajax({
        //url: $('input#siteurl').val() + '?tabPage=tab1',
        url: "",
        async: false,
        jsonpCallback: 'jsonCallback',
        contentType: "application/json",
        dataType: 'jsonp',
        data: {
            post_page: post_page,
            ran: Math.random(),
            gtitle: $('div#formstage input#gtitle').val(),
            glink: $('div#formstage input#glink').val(),
            pathimg: $('div#formstage input#pathImg').val(),
            gsort: $('div#formstage input#gsort').val(),
            gdesc: $('div#formstage textarea#gsort2').val(),
            typePost: 'add',
            callback: 'jsonCallback'},
        success: function (data) {
            if (data.data == 'success') {
                statusUpdate('เพิ่มเรียบร้อย', '#06C');
                clearTab1();
            } else {
                statusUpdate('ข้อมูลผิดพราดกรุณาลองใหม่', '#F00');
            }
        }
    });*/

    var myurl = $('input#siteurl').val();
    $.ajax({
        type: "POST",
        cache: false,
//        contentType: "application/json",
        dataType: 'json',
        url: myurl,
        data: {
            post_page: post_page,
            ran: Math.random(),
            typePost: 'add',
            callback: 'jsonCallback',
            gtitle: $('div#formstage input#gtitle').val(),
            glink: $('div#formstage input#glink').val(),
            pathimg: $('div#formstage input#pathImg').val(),
            gsort: $('div#formstage input#gsort').val(),
            gdesc: $('div#formstage textarea#gsort2').val()
        },
        success: function (data) {
            if (data.data == 'success') {
                statusUpdate('เพิ่มเรียบร้อย', '#06C');
                clearTab1();
            } else {
                statusUpdate('ข้อมูลผิดพราดกรุณาลองใหม่' + data, '#F00');
            }
        }
    })
        .done(function () {
            //alert("second success");
        })
        .fail(function () {
            statusUpdate('ข้อมูลผิดพราดกรุณาลองใหม่2', '#F00');
        })
        .always(function () {
            //alert("finished");
        });
}
function clearTab1() {
    $('form#gallery-post input[type="text"],textarea').val('');
    $('form#gallery-post textarea').text('');
    $('form#gallery-post input#gsort').val('1');
    enableTab1Input();
}
function disibleTab1Input() {
    $('form#gallery-post input,form#gallery-post textarea').prop('disabled', false);
}
function enableTab1Input() {
    $('form#gallery-post input,form#gallery-post textarea').removeAttr('disabled');
    getGalleryList();
}
function checkFormInput() {
    var validate = true;
    if ($('input#gtitle').val() == '') {
        alert('ยังไม่ได้กรอกข้อมูล Title');
        $('input#gtitle').focus();
        return false;
    }
    if ($('input#glink').val() == '') {
        alert('ยังไม่ได้ใส่ Link');
        $('input#glink').focus();
        return false;
    }
    if ($('input#pathImg').val() == '') {
        alert('ยังไม่ได้เลือกรูป');
        $('input#pathImg').focus();
        return false;
    }
    return validate;
}
function listMenuGallery(img, id, title) {
    var listtxt = '<li ondrop="dragImage(event);" draggable="true" class="image_list" data="'+id+
        '" ><a href="#" class="img-edit" rel="' + id + '"><img title="' + title +
        '" src="' + img + '" alt="" width="165" height="110" onerror="defaultImage(this);" /></a>' +
        '<a href="#" class="remove-slide" rel="' + id + '"><i class="icon-cancel-2"></i></a></li>';
    return listtxt;
}
function getGalleryEvent() {
    $('div#slidelist-stage ul li a.img-edit').click(function () {
        geEditForm($(this).attr('rel'));
        return false
    });
    $('div#slidelist-stage ul li a.remove-slide').click(function () {
        if (confirm('ต้องการลบรูปนี้หรือไม่')) {
            $.ajax({
                url: $('input#siteurl').val(),
                async: false,
                jsonpCallback: 'jsonCallback',
                contentType: "application/json",
                dataType: 'jsonp',
                data: {
                    post_page: post_page,
                    ran: Math.random(),
                    typePost: 'del',
                    galleryid: $(this).attr('rel'),
                    callback: 'jsonCallback'
                },
                success: function (data) {
                    if (data.data == 'success') {
                        alert('ลบข้อมูลเรียบร้อย');
                        getGalleryList();
                    } else {
                        alert('ข้อมูลผิดพราดกรุณาลองใหม่');
                    }
                }
            });
        }
        return false
    });
    $('div.pagination a').click(function () {
        getGalleryList($(this).attr('href'));
        return false;
    });
}
function geEditForm(sid) {
    $('div#formupdate').html(getLoadingPage());
    $.ajax({
        url: $('input#siteurl').val(), type: 'POST',
        data: {
            post_page: post_page,
            ran: Math.random(),
            typePost: 'editform',
            galleryid: sid,
            callback: 'jsonCallback'
        },
        success: function (data) {
            $('div#formupdate').html(data);
            $('div#formstage').slideUp('fast', function () {
                $('div#formupdate').slideDown('fast');
                scrollToID('div#formupdate');
            });
            updatestage = true;
            togleGalleryDel();
            getEventEditForm();
        }
    });
}
function togleGalleryDel() {
    if (updatestage) {
        $('a.remove-slide i').css('display', 'none');
    } else {
        $('a.remove-slide i').css('display', 'block');
    }
}
function getEventEditForm() {
    $('form#gallery-post-edit').submit(function () {
        getJsonEdit();
        return false;
    });
    $('input#cancelform').click(function () {
        $('div#formupdate').slideUp('fast', function () {
            $('div#formupdate').html('');
            $('div#formstage').slideDown('fast');
            updatestage = false;
            togleGalleryDel();
            scrollToID('#formstage');
        });
        return false;
    });
}
function getJsonEdit() {
    statusUpdate('Loading...', '#0C6');
    $.ajax({
        url: $('input#siteurl').val(),
        async: false,
        jsonpCallback: 'jsonCallback',
        contentType: "application/json",
        dataType: 'jsonp',
        data: {
            post_page: post_page,
            ran: Math.random(),
            gtitle: $('div#formupdate input#gtitle').val(),
            glink: $('div#formupdate input#glink').val(),
            pathimg: $('div#formupdate input#pathImg').val(),
            gsort: $('div#formupdate input#gsort').val(),
            gdesc: $('div#formupdate textarea#gsort2').val(),
            typePost: 'edit', galleryid: $('div#formupdate input#galleryid').val(),
            callback: 'jsonCallback'
        },
        success: function (data) {
            if (data.data == 'success') {
                statusUpdate('แก้ไขข้อมูลเรียบร้อย', '#06C');
                getGalleryList();
                $('div#formupdate').slideUp('fast', function () {
                    $('div#formupdate').html('');
                    $('div#formstage').slideDown('fast');
                    scrollToID('#formstage');
                });
            } else {
                statusUpdate('ข้อมูลผิดพราดกรุณาลองใหม่', '#F00');
            }
        }
    });
}
/* Tool function*/
function checkEventTab(tabid) {
    getEventImageGallery();
}
function getLoadingPage() {
    return '<center><img src="' + sbasepath + '/library/images/332.gif" alt="Loading" /></center>';
}
function imageUploader(id) {
    window.send_to_editor = newSendToEditor;
    uploadID = id;
    formfield = jQuery('.upload').attr('name');
    tb_show('เลือกไฟล์', 'media-upload.php?type=image&TB_iframe=true');
    return false;
}
function imageUploaderAll(id, img) {
    window.send_to_editor = newSendToEditor;
    uploadID = id;
    uploadImg = img;
    formfield = jQuery('.upload').attr('name');
    tb_show('เลือกไฟล์', 'media-upload.php?type=image&TB_iframe=true');
    return false;
}
function statusUpdate(txt, color) {/*#F00#0C6#06C*/
    $('#showstatus').html('<h4 style="color:' + color + '">' + txt + '</h4>');
    $('#showstatus').fadeIn('fast', function () {
        setTimeout(function () {
            $('#showstatus').fadeOut('fast');
        }, 2000);
    });
}
function scrollToID(id) {
    $("html, body").animate({scrollTop: $(id).offset().top}, 1000);
}

function defaultImage(img)
{
    img.onerror = "";
    img.src = sbasepath + '/lib/images/no_image.jpg';
}

var isDragging = false;
$(document).ready(function () {


});

var checkClickImage = false;
function dragImage(ev) {
    ev.preventDefault();alert(5)
    $("#slidelist-stage").append(5)
}

function mouseOutImage() {
    if (checkClickImage) {
        alert("drag")
    } else {
        checkClickImage = false;
    }
}

//$('.image_list').on('onmouseout', function(e) {
//    alert(5)
//});
//$('.image_list').on('mousedown', function(e) {
//    $(this).data('p0', { x: e.pageX, y: e.pageY });
//}).on('mouseup', function(e) {
//    var p0 = $(this).data('p0'),
//        p1 = { x: e.pageX, y: e.pageY },
//        d = Math.sqrt(Math.pow(p1.x - p0.x, 2) + Math.pow(p1.y - p0.y, 2));
//
//    if (d < 4) {
//        alert('clicked');
//    }
//});