jQuery(document).ready(function() {
    var entryId = jQuery("input[name^='serendipity[entry_id]']").val();
    rtcinterval = rtcinterval * 1000;
    setTimeout("requestCommentsAgain("+entryId+")", rtcinterval);
});

function requestComments(entryId) {
    var base = rtcbase + 'rtcomments_pull';
    jQuery.ajax({
        type: "POST",
        url: base,
        data: 'entryId='+entryId,
        success: function(msg){
                if (msg != '' && typeof msg != 'undefined') {
                    $comments = jQuery('<div>');
                    $comments.html(msg);

                    var ids = new Array();
                    var i = 0;
                    jQuery.each($comments.find('div'), function() {
                            var id = jQuery(this).attr('id');
                            if (id != '') {
                                ids[i] = id.replace('serendipity_comment_', '');
                                i++;
                            }                        
                        });
                    for(var j=0; j<i; j++) {
                        if(notSet(ids[j])) {
                            placeComment($comments, ids[j]);
                        }
                    }
                }
            },
        dataType: "text"
        });
}

function notSet(commentId) {
    var $comment = jQuery('#c'+commentId);
    if ($comment.length > 0) {
        return false;
    } else {
        return true;
    }
}

function placeComment($comments, id) {
    var comment = document.createDocumentFragment();
    var commentDiv;

    $comments.find('a').each(function() {
            if (jQuery(this).attr('id') == 'c'+id) {
                comment.appendChild(this);
            }
        }
    );
    $comments.find('div').each(function() {
            if (jQuery(this).attr('id') == 'serendipity_comment_'+id) {
                commentDiv = this;
                comment.appendChild(this);
            }
        }
    );
    $commentDiv = jQuery(commentDiv);
    $commentDiv.hide();
    addDetails($commentDiv, id);
    jQuery('#feedback').before(comment);
    $commentDiv.fadeIn('slow');
}

function addDetails($commentDiv, id) {
    //TODO: that's not a good way, since we totally ignore nested comments
    //but at the moment better then to fight with regexp (or to respect the parentid)
    var pos = jQuery('.serendipity_comment').length;
    $commentDiv.find('a').each(function() {
            if (jQuery(this).hasClass('comment_source_trace')) {
                jQuery(this).html('#'+pos);
            }
        });

    var commentFooter = '';
    $commentDiv.find('div').each(function() {
        if (jQuery(this).hasClass('serendipity_comment_source')) {
            commentFooter = jQuery(this).text();
        }
    });
        
    $commentDiv.find('div').each(function() {
        if (jQuery(this).hasClass('serendipity_comment_source')) {
            jQuery(this).html(jQuery(this).html() +
                '(<a class="comment_reply" href="#serendipity_CommentForm" id="serendipity_reply_'+ id +'" onclick="document.getElementById(\'serendipity_replyTo\').value='+id+'; ">'+rtcreply+'</a>)'
                )
        }
    });
    
    jQuery('#serendipity_replyTo').append('<option value="'+id+'">' + commentFooter +'</option>');
}

function requestCommentsAgain(entryId) {
    requestComments(entryId);
    setTimeout("requestCommentsAgain("+entryId+")", rtcinterval);
}
