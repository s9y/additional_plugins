var remainingTime = 0;
var language = 0;
var runs = 0;
var timer = null;
jQuery.noConflict();
function makeEditable(commentNumber, entryid) {
    //we have to prevent this function to be executed twice, but the
    //serendipity_event calling this function is executed twice

    getLanguage();
    var commentIDSelector = 'serendipity_comment_' + commentNumber;
    var commentID2k11Selector = 'c' + commentNumber;
    var base = cebase + 'commentedit';
    var loadbase = base + '_load';
    var formatted_comment = '';
    if (getRemainingTime() != 0 ) {
        jQuery("#"+commentIDSelector+" > .serendipity_commentBody,#"+commentID2k11Selector+" > .serendipity_commentBody").editable(
             base, {
             submitdata : { 'cid': commentNumber,
                         'entry_id': entryid },
             name : 'comment',
             type    : 'textarea',
             tooltip   : language.edittooltip,
             submit  : language.editsubmit,
             cancel: language.editcancel,
             onblur : 'ignore',
             rows   : 5,
             loadurl: loadbase,
             loadtype: 'POST',
             loaddata: { 'cid': commentNumber,
                         'entry_id': entryid }
        });
        markEditable(commentNumber);
        msRemainingTime = getRemainingTime() * 1000;
        timeoutFunction = "makeUneditable('"+commentNumber+"')"
        window.setTimeout(timeoutFunction, msRemainingTime)      
    }
    
}

function makeUneditable(commentNumber) {
    var commentIDSelector = 'serendipity_comment_' + commentNumber;
    var commentID2k11Selector = 'c' + commentNumber;
    
    var $source = jQuery("#"+commentIDSelector+" > .serendipity_comment_source,#"+commentID2k11Selector+" > footer").clone();
    var text = jQuery("#"+commentIDSelector+" > .serendipity_commentBody > * > *:input:first,#"+commentID2k11Selector+" > .serendipity_commentBody > * > *:input:first").val();
    //text is undefined if currently the editarea wasn't displayed
    if(typeof text == 'undefined') {
        text = jQuery("#"+commentIDSelector+" > .serendipity_commentBody,#"+commentID2k11Selector+" > .serendipity_commentBody").html();
    }
    jQuery("#"+commentIDSelector+" > .serendipity_commentBody,#"+commentID2k11Selector+" > .serendipity_commentBody").fadeOut('slow').remove();
    jQuery("#"+commentIDSelector+",#"+commentID2k11Selector).html('<div class="serendipity_commentBody">'+text+'</div>');
    jQuery("#"+commentIDSelector+",#"+commentID2k11Selector).append($source);
    jQuery('#commentedit').fadeOut('slow').remove()
}

function markEditable(commentNumber) {
    var timeLeft = getRemainingTime();
    var commentIDSelector = 'serendipity_comment_' + commentNumber;
    var commentID2k11Selector = 'c' + commentNumber;

    jQuery("#"+commentIDSelector+" > .serendipity_comment_source,#"+commentID2k11Selector+" > footer").append(
                                    '(<a id="commentedit">'+language.editlink+'<a>)'
                                    );
    jQuery('#commentedit').click(function() {
        jQuery("#"+commentIDSelector+" > .serendipity_commentBody,#"+commentID2k11Selector+" > .serendipity_commentBody").click();
    });
    jQuery('#commentedit').css("cursor", "pointer");
    jQuery("#"+commentIDSelector+" > .serendipity_comment_source,#"+commentID2k11Selector+" > footer").append(
                '<div id="commentedit_timer">'+language.edittimer+': <span class="commentedit_timer">'+timeLeft+'</span></div>'
                );
    //Pass timer to updateTime to get rid of performance-critical dom-traversing
    //which would otherwise occur in every update
    $timer = jQuery('.commentedit_timer');
    timer = setInterval("updateTime($timer)", 1000);
}

function updateTime($time) {
    var time = $time.html();
    time--;
    $time.html(time);
    if(time <= 0) {
        clearInterval(timer);
        $time.html(0);
    }
}

function getRemainingTime() {
    var base = cebase + 'commentedit_time';
    jQuery.ajax({
        type: "GET",
        async: false,
        url: base,
        success: function(data){
            remainingTime=data;
        }
    });
    return remainingTime;
}

function getLanguage() {
    var base = cebase + 'commentedit_language';
    jQuery.ajax({
        type: "GET",
        async: false,
        url: base,
        dataType: 'json',
        success: function(data){
            language=data;
        }
    });
    return language;
}
