/**
 * Created by Administrator on 22/02/2558.
 */
var data_candidate = null;
$(document).ready(function () {

    $("#frm_search_candidate").submit(function(){
        showImgLoading();
        $.ajax({
//            dataType: 'json',
//            cache: false,
            type: "GET",
            url: '',
            data: $(this).serialize(),
            success: function (result) {
                hideImgLoading();
                $("#list_search_candidate").html(result);
            },
            error: function (result) {
                showModalMessage(result.responseText, "Error");
                hideImgLoading();
            }
        });
        return false;
    });
});

function setDataCandidate() {
    $("#show_can_name").html(data_candidate.can_name);
    $("#show_can_degree").html(data_candidate.degree);
    $("#sho_can_university").html(data_candidate.university);
    $("#show_skill").html(data_candidate.japanese_skill);
}

function addRequestProfile() {

    var data = $.param({
        employer_post: 'true',
        post_type: 'request_profile',
        candidate_id: data_candidate.can_id,
        employer_id: employer_id
    });
    showImgLoading();
    $.ajax({
        dataType: 'json',
        cache: false,
        type: "GET",
        url: '',
        data: data,
        success: function (result) {
            hideImgLoading();
            if (!result.error) {
                $("#frm_search_candidate").submit();
            }
            showModalMessage(result.msg, "Message");
        },
        error: function (result) {
            showModalMessage(result.responseText, "Error");
            hideImgLoading();
        }
    });
}
