var button_animation;
var button_animation_speed;
$(document).ready(function() {
    requestMarkups();
    //create header
    $('<div id="markupButtons"></div>').insertBefore('#serendipity_commentform_comment').hide();
    //insert buttons after a short delay to let the ajax-call complete
    if(typeof lctimeout != 'number') {
        lctimeout = 1500;
    }
    setTimeout("addButtons();", lctimeout);
    //start eventlistener
    jQuery.listen('click', '#markupBold', function(event){mark(event)});
    jQuery.listen('click', '#markupUnderline', function(event){mark(event)});
    jQuery.listen('click', '#markupItalic', function(event){mark(event)});
    //make sure images behave like button
    $('.markupIcon').hover(function () {
        $(this).css({'cursor' : 'pointer'});
    });
});
function addButtons() {
    if (s9ymarkup) {
        $('#markupButtons').html('<img id="markupBold" class="markupIcon" src="/plugins/serendipity_event_livecomment/img/bold.png" />');
        $('#markupButtons').append('<img id="markupUnderline" class="markupIcon" src="/plugins/serendipity_event_livecomment/img/underline.png" />');
    }
    if (bb) {
        $('#markupButtons').html('<img id="markupBold" class="markupIcon" src="/plugins/serendipity_event_livecomment/img/bold.png" />');
        $('#markupButtons').append('<img id="markupItalic" class="markupIcon" src="/plugins/serendipity_event_livecomment/img/italic.png" />');
        $('#markupButtons').append('<img id="markupUnderline" class="markupIcon" src="/plugins/serendipity_event_livecomment/img/underline.png" />');
    }
    if (textile) {
        $('#markupButtons').html('<img id="markupBold" class="markupIcon" src="/plugins/serendipity_event_livecomment/img/bold.png" />');
        $('#markupButtons').append('<img id="markupItalic" class="markupIcon" src="/plugins/serendipity_event_livecomment/img/italic.png" />');
        $('#markupButtons').append('<img id="markupUnderline" class="markupIcon" src="/plugins/serendipity_event_livecomment/img/underline.png" />');
        
    }
    if (markdown) {
        $('#markupButtons').html('<img id="markupBold" class="markupIcon" src="/plugins/serendipity_event_livecomment/img/bold.png" />');
        $('#markupButtons').append('<img id="markupItalic" class="markupIcon" src="/plugins/serendipity_event_livecomment/img/italic.png" />');
    }

    switch (button_animation) {
        case 'slideDown':
            $('#markupButtons').slideDown(button_animation_speed);
            break;
        case 'show':
            $('#markupButtons').show();
            break;
        case 'fadeIn':
            $('#markupButtons').fadeIn(button_animation_speed);
            break;
        }
}
 
function mark(event) {
    var scrollPos = $('#serendipity_commentform_comment').attr('scrollTop');
    if ($('#serendipity_commentform_comment').getSelection().text) {
        var pattern = $('#serendipity_commentform_comment').getSelection()
        switch(event.target.id) {
            case 'markupBold':
                if (s9ymarkup){
                    $('#serendipity_commentform_comment').replaceSelection(
                                            '*'+ pattern.text + '*'
                                            );
                }else if (bb) {
                    $('#serendipity_commentform_comment').replaceSelection(
                                            '[b]'+ pattern.text + '[/b]'
                                            );
                    }else if (textile) {
                        $('#serendipity_commentform_comment').replaceSelection(
                                            '*'+ pattern.text + '*'
                                            );
                        }else if (markdown) {
                            $('#serendipity_commentform_comment').replaceSelection(
                                            '**'+ pattern.text + '**'
                                            );
                            }
                break;
            case 'markupItalic':
                if (bb) {
                    $('#serendipity_commentform_comment').replaceSelection(
                                            '[i]'+ pattern.text + '[/i]'
                                            );
                    }else if (textile) {
                        $('#serendipity_commentform_comment').replaceSelection(
                                            '_'+ pattern.text + '_'
                                            );
                        }else if (markdown) {
                            $('#serendipity_commentform_comment').replaceSelection(
                                            '*'+ pattern.text + '*'
                                            );
                            }
                break;
            case 'markupUnderline':
                if (s9ymarkup){
                    $('#serendipity_commentform_comment').replaceSelection(
                                            '_'+ pattern.text + '_'
                                        );
                }else if (bb) {
                    $('#serendipity_commentform_comment').replaceSelection(
                                            '[u]'+ pattern.text + '[/u]'
                                            );
                    }else if (textile) {
                        $('#serendipity_commentform_comment').replaceSelection(
                                            '+'+ pattern.text + '+'
                                            );
                        }
                break;
            }
    }
    //format text instant after click 
    $('#serendipity_commentform_comment').trigger('keyup');
    
    $('#serendipity_commentform_comment').focus();
    $('#serendipity_commentform_comment').attr('scrollTop', scrollPos);
}
