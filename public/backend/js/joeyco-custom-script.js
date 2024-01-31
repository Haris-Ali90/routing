/*--Show Session alert--*/
function ShowSessionAlert(type = 'success' , massage = 'No Massage Set In script ! :-) ') {

    // checking any alert already exist if it is removed
    if($(".x_content").find('.alert').length)
    {
        $(".x_content").find('.alert').remove();
    }

    let session_alert_html =` 
        <div class="alert alert-${type}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            ${massage}
        </div>`;

    $(".x_content").prepend(session_alert_html);

}

/*window loader*/
$(window).load(function() {
    hideLoader();
});

/*loader show hide function*/
function showLoader() {
    $('.loader-mian-wrap').addClass('show');
}

function hideLoader() {
    $('.loader-mian-wrap').removeClass('show');
}

function toggleLoader() {
    $('.loader-mian-wrap').toggleClass('show');
}

function make_option_selected_trigger(el , val = "")
{
    $(el).val(val);
    $(el).change();
}

/*progress bar functions */

function showProgressBar() {
    $('.progress-main-wrap').find('.progress-bar').css({"width":'0%'});
    $('.progress-main-wrap').find('.progress-bar').text('0%');
    $('.progress-main-wrap').addClass('show');
}

function hideProgressBar() {
    $('.progress-main-wrap').find('.progress-bar').css({"width":'0%'});
    $('.progress-main-wrap').find('.progress-bar').text('0%');
    $('.progress-main-wrap').removeClass('show');
}

function toggleProgressBar() {
    $('.progress-main-wrap').toggleClass('show');
}

function updateProgressBar(data) {
    $('.progress-main-wrap').find('.progress-bar').css({"width":data+'%'});
    $('.progress-main-wrap').find('.progress-bar').text(data+'%');
}

function progressBarErrorShow() {
    $('.progress-main-wrap').find('.error-report').css({"display":"block"});
}

function progressBarErrorHide() {
    $('.progress-main-wrap').find('.error-report').css({"display":"none"});
}