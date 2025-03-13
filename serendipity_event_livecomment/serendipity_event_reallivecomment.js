
var storage = createSingleStorage();
jQuery.noConflict();
jQuery(document).ready(function() {
    //check if we are on a page containing a comment-form
    if(!document.getElementById('serendipity_commentform_comment')) {
        return;
    }
    //ask serendipity which markups are activated, which headline and which functions
    if (typeof inline == 'undefined') {
        requestConfiguration();
    }
    if(typeof lctimeout != 'number') {
        var lctimeout = 1500;
    }
    setTimeout("execCommentFunctions()", lctimeout);
});

function execCommentFunctions() {
    if (storage.preview) {
        addPreview();
    }
    if (storage.buttons) {
        markupComments();
    }
    if (storage.elastic) {
        elasticComments();
    }
}

function addPreview() {
    var $serendipity_commentform_comment = jQuery('#serendipity_commentform_comment');
    //create Container
    var $serendipity_comment_preview = jQuery("#serendipity_comment_preview");
    if ($serendipity_comment_preview.length == 0 ) {
        createContainer();
        $serendipity_commentform_comment.keyup();
        $serendipity_comment_preview = jQuery("#serendipity_comment_preview");
    }

    var $serendipity_preview_commentBody = jQuery("#serendipity_comment_preview > .serendipity_commentBody");
    //hide the whole Container for later fade in
    $serendipity_comment_preview.hide();
    
    jQuery("#serendipity_previewTitle").html(storage.preview_title);
    
    $serendipity_commentform_comment.focus(function() {
            //markup and show comment-text
            $serendipity_commentform_comment.keyup();
            //show if hidden
            switch (storage.preview_animation) {
                case 'fadeIn':
                    $serendipity_comment_preview.fadeIn(storage.preview_animation_speed);
                    break;
                case 'slideDown':
                    $serendipity_comment_preview.slideDown(storage.preview_animation_speed);
                    break;
                case 'show':
                    $serendipity_comment_preview.show();
                    break;
            }
            //fade in if greyed out
            $serendipity_comment_preview.fadeTo('fast', 1);
        });
    
    var serendipity_comment = '';
    //formate the input at keyrelease
    $serendipity_commentform_comment.keyup(function() {
        serendipity_comment = jQuery(this).val();
        
        //format according to activated markuplanguages
        if (storage.markdown) {		    
            var converter = new Showdown.converter();
            serendipity_comment = converter.makeHtml(serendipity_comment);
        }
        if (storage.bb) {
            serendipity_comment = bb2html(serendipity_comment);
        }
        if (storage.textile) {
            serendipity_comment = textile2html(serendipity_comment);
        }
        if (storage.nl2br || storage.nl2p) {
            serendipity_comment = serendipity_comment.replace(/\n/g, "<br />").replace(/\n\n+/g, '<br /><br />');
        }
        if (storage.s9ymarkup){
            serendipity_comment = s9y2html(serendipity_comment);
        }
        if (storage.liquid){
            serendipity_comment = liquid2html(serendipity_comment);
        }
        //finally produce the output
        $serendipity_preview_commentBody.html(serendipity_comment);
        });
    //grey the preview box out if not writing
    $serendipity_commentform_comment.blur(function() {
        $serendipity_comment_preview.fadeTo('fast', 0.75);
    });
}

function createContainer() {
    jQuery('#feedback').after('<div id=\u0022serendipity_comment_preview\u0022 class=\u0022serendipity_comment\u0022><div id=\u0022serendipity_previewTitle\u0022 class=\u0022serendipity_commentsTitle\u0022></div><div class=\u0022serendipity_commentBody serendipity_comment_author_unknown comment_oddbox\u0022></div></div>');
}

function markupComments() {
    //create header
    jQuery('<div id="markupButtons"></div>').insertBefore('#serendipity_commentform_comment').hide();
    addButtons();
    //start eventlistener
    jQuery(document).on('click', '#markupBold', function(event){mark(event)});
    jQuery(document).on('click', '#markupUnderline', function(event){mark(event)});
    jQuery(document).on('click', '#markupItalic', function(event){mark(event)});
    jQuery(document).on('click', '#markupLink', function(event){mark(event)});
}

function elasticComments() {
    jQuery('#serendipity_commentform_comment').elastic()
}

/*
*Check markups and functions activated for the comments 
*/
function requestConfiguration() {
    if (typeof storage.requesterRunned == 'undefined') {
        storage.requesterRunned = false;
    }
    if(!storage.requesterRunned) {
        jQuery.get(rlcbase,
                '',
                function(data){
                    interpretMarkups(data);
                },
                'text')
    }
    storage.requesterRunned = true;
}

function interpretMarkups(message) {
    var markups = message.split(";");
    storage.s9ymarkup = eval(markups[0]);
    storage.nl2br = eval(markups[1]);
    storage.textile = eval(markups[2]);
    storage.bb = eval(markups[3]);
    storage.markdown = eval(markups[4]);
    storage.nl2p = eval(markups[5]);
    storage.liquid = eval(markups[6]);
    storage.preview_animation = markups[7];
    storage.preview_animation_speed = markups[8];
    if (isInt(storage.preview_animation_speed)){
        storage.preview_animation_speed = parseInt(storage.preview_animation_speed)
    }
    storage.button_animation = markups[9];
    storage.button_animation_speed = markups[10];
    if (isInt(storage.preview_animation_speed)){
        storage.button_animation_speed = parseInt(storage.button_animation_speed);
    }
    storage.bold = markups[11];
    storage.italic = markups[12];
    storage.underline = markups[13];
    storage.url = markups[14];
    storage.preview = eval(markups[15]);
    storage.buttons = eval(markups[16]);
    storage.elastic = eval(markups[17]);
    storage.imgpath = markups[18];
    storage.preview_title = markups[19];
}

/*
 * Storage for the golbal variables used by reallivecomment and commentmarkup
 * */
function globalStorage() {
    this.s9ymarkup = null;
    this.nl2br = null;
    this.textile = null;
    this.bb = null;
    this.markdown = null;
    this.nl2p = null;
    this.liquid = null;
    this.preview_animation = null;
    this.preview_animation_speed = null;
    this.requesterRunned = null;
    this.button_animation = null;
    this.button_animation_speed = null;
    this.bold = null;
    this.italic = null;
    this.underline = null;
    this.url = null;
    this.preview = null;
    this.buttons = null;
    this.elastc = null;
    this.imgpath = null;
    this.preview_title = null;
}

var singleStorage;
function createSingleStorage() {
    if (typeof singleStorage == 'undefined') {
        singleStorage = new globalStorage();
    }
    return singleStorage;
}

function isInt(x) {
   var y=parseInt(x);
   if (isNaN(y)) return false;
   return x==y && x.toString()==y.toString();
 }
    

function addButtons() {
    var bold = storage.bold;
    var italic = storage.italic;
    var underline = storage.underline;
    var url = storage.url;
    var s9ymarkup = storage.s9ymarkup;
    var bb = storage.bb;
    var textile = storage.textile;
    var markdown = storage.markdown;
    var liquid = storage.liquid;
    var button_animation = storage.button_animation;
    var button_animation_speed = storage.button_animation_speed;
    var imgpath = storage.imgpath;
    if (s9ymarkup) {
        jQuery('#markupButtons').html('<img id="markupBold" class="markupIcon" src="' + imgpath + 'bold.png" alt="' + bold + '" title="' + bold + '"/>');
        jQuery('#markupButtons').append('<img id="markupUnderline" class="markupIcon" src="' + imgpath + 'underline.png" alt="' + underline + '" title="' + underline + '"/>');
    }
    if (bb) {
        jQuery('#markupButtons').html('<img id="markupBold" class="markupIcon" src="' + imgpath + 'bold.png" alt="' + bold + '" title="' + bold + '"/>');
        jQuery('#markupButtons').append('<img id="markupItalic" class="markupIcon" src="' + imgpath + 'italic.png" alt="' + italic + '" title="' + italic + '"/>');
        jQuery('#markupButtons').append('<img id="markupUnderline" class="markupIcon" src="' + imgpath + 'underline.png" alt="' + underline + '" title="' + underline + '"/>');
        jQuery('#markupButtons').append('<img id="markupLink" class="markupIcon" src="' + imgpath + 'world.png" alt="' + url + '" title="' + url + '"/>');
    }
    if (textile) {
        jQuery('#markupButtons').html('<img id="markupBold" class="markupIcon" src="' + imgpath + 'bold.png" alt="' + bold + '" title="' + bold + '"/>');
        jQuery('#markupButtons').append('<img id="markupItalic" class="markupIcon" src="' + imgpath + 'italic.png" alt="' + italic + '" title="' + italic + '"/>');
        jQuery('#markupButtons').append('<img id="markupUnderline" class="markupIcon" src="' + imgpath + 'underline.png" alt="' + underline + '" title="' + underline + '"/>');
        jQuery('#markupButtons').append('<img id="markupLink" class="markupIcon" src="' + imgpath + 'world.png" alt="' + url + '" title="' + url + '"/>');
    }
    if (markdown) {
        jQuery('#markupButtons').html('<img id="markupBold" class="markupIcon" src="' + imgpath + 'bold.png" alt="' + bold + '" title="' + bold + '"/>');
        jQuery('#markupButtons').append('<img id="markupItalic" class="markupIcon" src="' + imgpath + 'italic.png" alt="' + italic + '" title="' + italic + '"/>');
        jQuery('#markupButtons').append('<img id="markupLink" class="markupIcon" src="' + imgpath + 'world.png" alt="' + url + '" title="' + url + '"/>');
    }
    if (liquid) {
        jQuery('#markupButtons').html('<img id="markupBold" class="markupIcon" src="' + imgpath + 'bold.png" alt="' + bold + '" title="' + bold + '"/>');
        jQuery('#markupButtons').append('<img id="markupItalic" class="markupIcon" src="' + imgpath + 'italic.png" alt="' + italic + '" title="' + italic + '"/>');
        jQuery('#markupButtons').append('<img id="markupLink" class="markupIcon" src="' + imgpath + 'world.png" alt="' + url + '" title="' + url + '"/>');
    }

    switch (button_animation) {
        case 'slideDown':
            jQuery('#markupButtons').slideDown(button_animation_speed);
            break;
        case 'show':
            jQuery('#markupButtons').show();
            break;
        case 'fadeIn':
            jQuery('#markupButtons').fadeIn(button_animation_speed);
            break;
        }

    //make sure images behave like button
    jQuery('.markupIcon').mouseover(function () {
        jQuery(this).css('cursor','pointer');
    });
}
 
function mark(event) {
    var bold = storage.bold;
    var italic = storage.italic;
    var underline = storage.underline;
    var url = storage.url;
    var s9ymarkup = storage.s9ymarkup;
    var bb = storage.bb;
    var textile = storage.textile;
    var markdown = storage.markdown;
    var liquid = storage.liquid;

    $serendipity_commentform_comment = jQuery('#serendipity_commentform_comment');
    
    var scrollPos = $serendipity_commentform_comment.attr('scrollTop');
    var cursorPos = $serendipity_commentform_comment.attr('selectionStart');
    var input = document.getElementById('serendipity_commentform_comment');

    var pattern = $serendipity_commentform_comment.getSelection()
    switch(event.target.id) {
        case 'markupBold':
            var middle = bold;
            if (s9ymarkup){
                if (pattern.text) {
                    middle = pattern.text;
                } else {
                    var opening = '*';
                }
                $serendipity_commentform_comment.replaceSelection(
                                        '*'+ middle + '*'
                                        );
            }else if (bb) {
                    if (pattern.text) {
                        middle = pattern.text;
                    } else {
                        var opening = '[b]';
                    }
                    $serendipity_commentform_comment.replaceSelection(
                                        '[b]'+ middle + '[/b]'
                                        );
                }else if (textile) {
                        if (pattern.text) {
                            middle = pattern.text;
                        } else {
                            var opening = '*';
                        }
                        $serendipity_commentform_comment.replaceSelection(
                                                '*'+ middle + '*'
                                                );
                    }else if (markdown || liquid) {
                            if (pattern.text) {
                                middle = pattern.text;
                            } else {
                                var opening = '**';
                            }
                            $serendipity_commentform_comment.replaceSelection(
                                                    '**'+ middle + '**'
                                                    );
                        }
            break;
        case 'markupItalic':
            var middle = italic;
             if (bb) {
                    if (pattern.text) {
                        middle = pattern.text;
                    } else {
                        var opening = '[i]';
                    }
                    $serendipity_commentform_comment.replaceSelection(
                                        '[i]'+ middle + '[/i]'
                                        );
                }else if (textile) {
                        if (pattern.text) {
                            middle = pattern.text;
                        } else {
                            var opening = '_';
                        }
                        $serendipity_commentform_comment.replaceSelection(
                                                '_'+ middle + '_'
                                                );
                    }else if (markdown || liquid) {
                            if (pattern.text) {
                                middle = pattern.text;
                            } else {
                                var opening = '*';
                            }
                            $serendipity_commentform_comment.replaceSelection(
                                                    '*'+ middle + '*'
                                                    );
                        }
            break;
        case 'markupUnderline':
            var middle = underline;
            if (s9ymarkup){
                if (pattern.text) {
                    middle = pattern.text;
                } else {
                    var opening = '_';
                }
                $serendipity_commentform_comment.replaceSelection(
                                        '_'+ middle + '_'
                                        );
            }else if (bb) {
                    if (pattern.text) {
                        middle = pattern.text;
                    } else {
                        var opening = '[u]';
                    }
                    $serendipity_commentform_comment.replaceSelection(
                                        '[u]'+ middle + '[/u]'
                                        );
                }else if (textile) {
                        if (pattern.text) {
                            middle = pattern.text;
                        } else {
                            var opening = '+';
                        }
                        $serendipity_commentform_comment.replaceSelection(
                                                '+'+ middle + '+'
                                                );
                                            }
            break;
        case 'markupLink':
            var middle = url;
            if (bb) {
                    if (pattern.text) {
                        middle = pattern.text;
                    } else {
                        var opening = '[url=http://]';
                    }
                    $serendipity_commentform_comment.replaceSelection(
                                        '[url=http://]'+ middle + '[/url]'
                                        );
            }else if (textile) {
                        if (pattern.text) {
                            middle = pattern.text;
                        } else {
                            var opening = '"';
                        }
                        $serendipity_commentform_comment.replaceSelection(
                                                '"'+ middle + '":http://'
                                                );
                                                '['+ pattern.text + '](http://)'
                }else if (markdown) {
                            if (pattern.text) {
                                middle = pattern.text;
                            } else {
                                var opening = '[';
                            }
                            $serendipity_commentform_comment.replaceSelection(
                                                    '['+ middle + '](http://)'
                                                    );
                    } else if (liquid) {
                            if (pattern.text) {
                                middle = pattern.text;
                            } else {
                                var opening = '[http:// ';
                            }
                            $serendipity_commentform_comment.replaceSelection(
                                                    '[http:// '+ middle + ']'
                                                    );
                    }
            break;
    }
    //format text instant after click 
    $serendipity_commentform_comment.trigger('keyup');

    $serendipity_commentform_comment.focus();
    if (opening) {
        input.selectionStart = cursorPos + opening.length;
        input.selectionEnd = cursorPos + opening.length + middle.length;
    }
    
    $serendipity_commentform_comment.attr('scrollTop', scrollPos);
}

function s9y2html (text) {
    search = new Array(
                       /_(.*?)_/g,
                       /\^(.*?)\^/g,
                       /@(.*?)@/g,
                       /\*(.*?)\*/g);
    replace = new Array(
                        "<u>$1</u>",
                        "<sup>$1</sup>",
                        "<sub>$1</sub>",
                        "<strong>$1</strong>");	        
    for(i = 0; i < search.length; i++) {
        text = text.replace(search[i],replace[i]);
    }
    return text
}

function liquid2html (text) {
        search = new Array(
                        /\*\*(.*?)\*\*/g,
                        /\*(.*?)\*/g,
                        /\[(.*?) (.*?)\]/g);
        replace = new Array(
                        "<strong>$1</strong>",
                        "<em>$1</em>",
                        "<a href=\"$1\">$2</a>");	        
        for(i = 0; i < search.length; i++) {
            text = text.replace(search[i],replace[i]);
        }
        return text;
}

function bb2html (text) {
    search = new Array(
                       /\[img\](.*?)=\1\[\/img\]/g,
                       /\[url=([\w]+?:\/\/[^ \\"\n\r\t<]*?)\](.*?)\[\/url\]/g,
          /\[url\]((www|ftp|)\.[^ \\"\n\r\t<]*?)\[\/url\]/g,
                       /\[url=((www|ftp|)\.[^ \\"\n\r\t<]*?)\](.*?)\[\/url\]/g,
          /\[email\](([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+))\[\/email\]/g,
          /\[b\](.*?)\[\/b\]/g,
          /\[url\](http:\/\/[^ \\"\n\r\t<]*?)\[\/url\]/g,
                       /\[i\](.*?)\[\/i\]/g,
                       /\[u\](.*?)\[\/u\]/g,
                       /\[center\](.*?)\[\/center\]/g,
                       /\[strike\](.*?)\[\/strike\]/g);
                       
                       replace = new Array(
                        "<img src=\"$1\" alt=\"An image\">",
                        "<a href=\"$1\" target=\"blank\">$2</a>",
                        "<a href=\"http://$1\" target=\"blank\">$1</a>",
                        "<a href=\"$1\" target=\"blank\">$1</a>",
                        "<a href=\"mailto:$1\">$1</a>",
                        "<span style=\"font-weight:bold\">$1</span>",
                        "<a href=\"$1\" target=\"blank\">$1</a>",
                        "<span style=\"font-style:italic\">$1</span>",
                        "<span style=\"text-decoration:underline\">$1</span>",
                        "<div style=\"text-align:center\">$1</div>",
                        "<span style=\"text-decoration:line-through\">$1</span>");
                       
                                                                              

    for(i = 0; i < search.length; i++) {
        text = text.replace(search[i],replace[i]);
    }
    return text
        }

function textile2html(s) {
    var r = s;
    // quick tags first
    qtags = [['\\*', 'strong'],
             ['\\?\\?', 'cite'],
             ['\\+', 'ins'],  //fixed
             ['~', 'sub'],   
             ['\\^', 'sup'], // me
             ['@', 'code']];
    for (var i=0;i<qtags.length;i++) {
        ttag = qtags[i][0]; htag = qtags[i][1];
        re = new RegExp(ttag+'\\b(.+?)\\b'+ttag,'g');
        r = r.replace(re,'<'+htag+'>'+'$1'+'</'+htag+'>');
    }
    // underscores count as part of a word, so do them separately
    re = new RegExp('\\b_(.+?)_\\b','g');
    r = r.replace(re,'<em>$1</em>');
	
	//jeff: so do dashes
    re = new RegExp('[\s\n]-(.+?)-[\s\n]','g');
    r = r.replace(re,'<del>$1</del>');

    // links
    re = new RegExp('"\\b(.+?)\\(\\b(.+?)\\b\\)":([^\\s]+)','g');
    r = r.replace(re,'<a href="$3" title="$2">$1</a>');
    re = new RegExp('"\\b(.+?)\\b":([^\\s]+)','g');
    r = r.replace(re,'<a href="$2">$1</a>');

    // images
    re = new RegExp('!\\b(.+?)\\(\\b(.+?)\\b\\)!','g');
    r = r.replace(re,'<img src="$1" alt="$2">');
    re = new RegExp('!\\b(.+?)\\b!','g');
    r = r.replace(re,'<img src="$1">');
    
    // block level formatting
	
    // Jeff's hack to show single line breaks as they should.
    // insert breaks - but you get some....stupid ones
    re = new RegExp('(.*)\n([^#\*\n].*)','g');
    r = r.replace(re,'$1<br />$2');
    // remove the stupid breaks.
    re = new RegExp('\n<br />','g');
    r = r.replace(re,'\n');
	
    lines = r.split('\n');
    nr = '';
    for (var i=0;i<lines.length;i++) {
        line = lines[i].replace(/\s*$/,'');
        changed = 0;
        if (line.search(/^\s*bq\.\s+/) != -1) { 
			line = line.replace(/^\s*bq\.\s+/,'\t<blockquote>')+'</blockquote>'; 
			changed = 1; 
		}
		
		// jeff adds h#.
        if (line.search(/^\s*h[1|2|3|4|5|6]\.\s+/) != -1) { 
	    	re = new RegExp('h([1|2|3|4|5|6])\.(.+)','g');
	    	line = line.replace(re,'<h$1>$2</h$1>');
			changed = 1; 
		}
		
		if (line.search(/^\s*\*\s+/) != -1) { line = line.replace(/^\s*\*\s+/,'\t<liu>') + '</liu>'; changed = 1; } // * for bullet list; make up an liu tag to be fixed later
        if (line.search(/^\s*#\s+/) != -1) { line = line.replace(/^\s*#\s+/,'\t<lio>') + '</lio>'; changed = 1; } // # for numeric list; make up an lio tag to be fixed later
        if (!changed && (line.replace(/\s/g,'').length > 0)) line = '<p>'+line+'</p>';
        lines[i] = line + '\n';
    }
	
    // Second pass to do lists
    inlist = 0; 
	listtype = '';
    for (var i=0;i<lines.length;i++) {
        line = lines[i];
        if (inlist && listtype == 'ul' && !line.match(/^\t<liu/)) { line = '</ul>\n' + line; inlist = 0; }
        if (inlist && listtype == 'ol' && !line.match(/^\t<lio/)) { line = '</ol>\n' + line; inlist = 0; }
        if (!inlist && line.match(/^\t<liu/)) { line = '<ul>' + line; inlist = 1; listtype = 'ul'; }
        if (!inlist && line.match(/^\t<lio/)) { line = '<ol>' + line; inlist = 1; listtype = 'ol'; }
        lines[i] = line;
    }

    r = lines.join('\n');
	// jeff added : will correctly replace <li(o|u)> AND </li(o|u)>
    r = r.replace(/li[o|u]>/g,'li>');

    return r;
}

var Showdown={};
Showdown.converter=function(){
    var _1;
    var _2;
    var _3;
    var _4=0;
    this.makeHtml=function(_5){
        _1=new Array();
        _2=new Array();
        _3=new Array();
        _5=_5.replace(/~/g,"~T");
        _5=_5.replace(/\$/g,"~D");
        _5=_5.replace(/\r\n/g,"\n");
        _5=_5.replace(/\r/g,"\n");
        _5="\n\n"+_5+"\n\n";
        _5=_6(_5);
        _5=_5.replace(/^[ \t]+$/mg,"");
        _5=_7(_5);
        _5=_8(_5);
        _5=_9(_5);
        _5=_a(_5);
        _5=_5.replace(/~D/g,"$$");
        _5=_5.replace(/~T/g,"~");
        return _5;
    };
    var _8=function(_b){
        var _b=_b.replace(/^[ ]{0,3}\[(.+)\]:[ \t]*\n?[ \t]*<?(\S+?)>?[ \t]*\n?[ \t]*(?:(\n*)["(](.+?)[")][ \t]*)?(?:\n+|\Z)/gm,function(_c,m1,m2,m3,m4){
            m1=m1.toLowerCase();
            _1[m1]=_11(m2);
            if(m3){
                return m3+m4;
            }else{
                if(m4){
                    _2[m1]=m4.replace(/"/g,"&quot;"); 
                }
            }
            return "";
        });
    return _b;
};
var _7=function(_12){
    _12=_12.replace(/\n/g,"\n\n");
    var _13="p|div|h[1-6]|blockquote|pre|table|dl|ol|ul|script|noscript|form|fieldset|iframe|math|ins|del";
    var _14="p|div|h[1-6]|blockquote|pre|table|dl|ol|ul|script|noscript|form|fieldset|iframe|math";
    _12=_12.replace(/^(<(p|div|h[1-6]|blockquote|pre|table|dl|ol|ul|script|noscript|form|fieldset|iframe|math|ins|del)\b[^\r]*?\n<\/\2>[ \t]*(?=\n+))/gm,_15);
    _12=_12.replace(/^(<(p|div|h[1-6]|blockquote|pre|table|dl|ol|ul|script|noscript|form|fieldset|iframe|math)\b[^\r]*?.*<\/\2>[ \t]*(?=\n+)\n)/gm,_15);
    _12=_12.replace(/(\n[ ]{0,3}(<(hr)\b([^<>])*?\/?>)[ \t]*(?=\n{2,}))/g,_15);
    _12=_12.replace(/(\n\n[ ]{0,3}<!(--[^\r]*?--\s*)+>[ \t]*(?=\n{2,}))/g,_15);
    _12=_12.replace(/(?:\n\n)([ ]{0,3}(?:<([?%])[^\r]*?\2>)[ \t]*(?=\n{2,}))/g,_15);
    _12=_12.replace(/\n\n/g,"\n");
    return _12;
};
var _15=function(_16,m1){
    var _18=m1;
    _18=_18.replace(/\n\n/g,"\n");
    _18=_18.replace(/^\n/,"");
    _18=_18.replace(/\n+$/g,"");
    _18="\n\n~K"+(_3.push(_18)-1)+"K\n\n";
    return _18;
};
var _9=function(_19){
    _19=_1a(_19);
    var key=_1c("<hr />");
    _19=_19.replace(/^[ ]{0,2}([ ]?\*[ ]?){3,}[ \t]*$/gm,key);
    _19=_19.replace(/^[ ]{0,2}([ ]?\-[ ]?){3,}[ \t]*$/gm,key);
    _19=_19.replace(/^[ ]{0,2}([ ]?\_[ ]?){3,}[ \t]*$/gm,key);
    _19=_1d(_19);
    _19=_1e(_19);
    _19=_1f(_19);
    _19=_7(_19);
    _19=_20(_19);
    return _19;
};
var _21=function(_22){
    _22=_23(_22);
    _22=_24(_22);
    _22=_25(_22);
    _22=_26(_22);
    _22=_27(_22);
    _22=_28(_22);
    _22=_11(_22);
    _22=_29(_22);
    _22=_22.replace(/  +\n/g," <br />\n");
    return _22;
};
var _24=function(_2a){
    var _2b=/(<[a-z\/!$]("[^"]*"|'[^']*'|[^'">])*>|<!(--.*?--\s*)+>)/gi;
_2a=_2a.replace(_2b,function(_2c){
        var tag=_2c.replace(/(.)<\/?code>(?=.)/g,"$1`");
        tag=_2e(tag,"\\`*_");
        return tag;
    });
return _2a;
};
var _27=function(_2f){
    _2f=_2f.replace(/(\[((?:\[[^\]]*\]|[^\[\]])*)\][ ]?(?:\n[ ]*)?\[(.*?)\])()()()()/g,_30);
    _2f=_2f.replace(/(\[((?:\[[^\]]*\]|[^\[\]])*)\]\([ \t]*()<?(.*?)>?[ \t]*((['"])(.*?)\6[ \t]*)?\))/g,_30); 
    _2f=_2f.replace(/(\[([^\[\]]+)\])()()()()()/g,_30);
    return _2f;
};
var _30=function(_31,m1,m2,m3,m4,m5,m6,m7){
    if(m7==undefined){
        m7="";
    }
    var _39=m1;
    var _3a=m2;
    var _3b=m3.toLowerCase();
    var url=m4;
    var _3d=m7;
    if(url==""){
        if(_3b==""){
            _3b=_3a.toLowerCase().replace(/ ?\n/g," ");
        }
        url="#"+_3b;
        if(_1[_3b]!=undefined){
            url=_1[_3b];
            if(_2[_3b]!=undefined){
                _3d=_2[_3b];
            }
        }else{
            if(_39.search(/\(\s*\)$/m)>-1){
                url="";
            }else{
                return _39;
            }
        }
    }
    url=_2e(url,"*_");
    var _3e="<a href=\""+url+"\"";
    if(_3d!=""){
        _3d=_3d.replace(/"/g,"&quot;");
_3d=_2e(_3d,"*_");
_3e+=" title=\""+_3d+"\"";
}
_3e+=">"+_3a+"</a>";
return _3e;
};
var _26=function(_3f){
_3f=_3f.replace(/(!\[(.*?)\][ ]?(?:\n[ ]*)?\[(.*?)\])()()()()/g,_40);
_3f=_3f.replace(/(!\[(.*?)\]\s?\([ \t]*()<?(\S+?)>?[ \t]*((['"])(.*?)\6[ \t]*)?\))/g,_40);
return _3f;
};
var _40=function(_41,m1,m2,m3,m4,m5,m6,m7){
    var _49=m1;
    var _4a=m2;
    var _4b=m3.toLowerCase();
    var url=m4;
    var _4d=m7;
    if(!_4d){
        _4d="";
    }
    if(url==""){
        if(_4b==""){
            _4b=_4a.toLowerCase().replace(/ ?\n/g," ");
        }
        url="#"+_4b;
        if(_1[_4b]!=undefined){
            url=_1[_4b];
            if(_2[_4b]!=undefined){
                _4d=_2[_4b];
            }
        }else{
            return _49;
        }
    }
    _4a=_4a.replace(/"/g,"&quot;");
									      url=_2e(url,"*_");
									      var _4e="<img src=\""+url+"\" alt=\""+_4a+"\"";
									      _4d=_4d.replace(/"/g,"&quot;");
    _4d=_2e(_4d,"*_");
    _4e+=" title=\""+_4d+"\"";
    _4e+=" />";
    return _4e;
};
var _1a=function(_4f){
    _4f=_4f.replace(/^(.+)[ \t]*\n=+[ \t]*\n+/gm,function(_50,m1){
            return _1c("<h1>"+_21(m1)+"</h1>");
        });
    _4f=_4f.replace(/^(.+)[ \t]*\n-+[ \t]*\n+/gm,function(_52,m1){
            return _1c("<h2>"+_21(m1)+"</h2>");
        });
    _4f=_4f.replace(/^(\#{1,6})[ \t]*(.+?)[ \t]*\#*\n+/gm,function(_54,m1,m2){
            var _57=m1.length;
            return _1c("<h"+_57+">"+_21(m2)+"</h"+_57+">");
        });
    return _4f;
};
var _58;
var _1d=function(_59){
    _59+="~0";
    var _5a=/^(([ ]{0,3}([*+-]|\d+[.])[ \t]+)[^\r]+?(~0|\n{2,}(?=\S)(?![ \t]*(?:[*+-]|\d+[.])[ \t]+)))/gm;
    if(_4){
        _59=_59.replace(_5a,function(_5b,m1,m2){
                var _5e=m1;
                var _5f=(m2.search(/[*+-]/g)>-1)?"ul":"ol";
                _5e=_5e.replace(/\n{2,}/g,"\n\n\n");
                var _60=_58(_5e);
                _60=_60.replace(/\s+$/,"");
                _60="<"+_5f+">"+_60+"</"+_5f+">\n";
                return _60;
            });
    }else{
        _5a=/(\n\n|^\n?)(([ ]{0,3}([*+-]|\d+[.])[ \t]+)[^\r]+?(~0|\n{2,}(?=\S)(?![ \t]*(?:[*+-]|\d+[.])[ \t]+)))/g;
        _59=_59.replace(_5a,function(_61,m1,m2,m3){
                var _65=m1;
                var _66=m2;
                var _67=(m3.search(/[*+-]/g)>-1)?"ul":"ol";
                var _66=_66.replace(/\n{2,}/g,"\n\n\n");
                var _68=_58(_66);
                _68=_65+"<"+_67+">\n"+_68+"</"+_67+">\n";
                return _68;
            });
    }
    _59=_59.replace(/~0/,"");
    return _59;
};
_58=function(_69){
    _4++;
    _69=_69.replace(/\n{2,}$/,"\n");
    _69+="~0";
    _69=_69.replace(/(\n)?(^[ \t]*)([*+-]|\d+[.])[ \t]+([^\r]+?(\n{1,2}))(?=\n*(~0|\2([*+-]|\d+[.])[ \t]+))/gm,function(_6a,m1,m2,m3,m4){
            var _6f=m4;
            var _70=m1;
            var _71=m2;
            if(_70||(_6f.search(/\n{2,}/)>-1)){
                _6f=_9(_72(_6f));
            }else{
                _6f=_1d(_72(_6f));
                _6f=_6f.replace(/\n$/,"");
                _6f=_21(_6f);
            }
            return "<li>"+_6f+"</li>\n";
        });
    _69=_69.replace(/~0/g,"");
    _4--;
    return _69;
};
var _1e=function(_73){
    _73+="~0";
    _73=_73.replace(/(?:\n\n|^)((?:(?:[ ]{4}|\t).*\n+)+)(\n*[ ]{0,3}[^ \t\n]|(?=~0))/g,function(_74,m1,m2){
            var _77=m1;
            var _78=m2;
            _77=_79(_72(_77));
            _77=_6(_77);
            _77=_77.replace(/^\n+/g,"");
            _77=_77.replace(/\n+$/g,"");
            _77="<pre><code>"+_77+"\n</code></pre>";
            return _1c(_77)+_78;
        });
    _73=_73.replace(/~0/,"");
    return _73;
};
var _1c=function(_7a){
    _7a=_7a.replace(/(^\n+|\n+$)/g,"");
    return "\n\n~K"+(_3.push(_7a)-1)+"K\n\n";
};
var _23=function(_7b){
    _7b=_7b.replace(/(^|[^\\])(`+)([^\r]*?[^`])\2(?!`)/gm,function(_7c,m1,m2,m3,m4){
            var c=m3;
            c=c.replace(/^([ \t]*)/g,"");
            c=c.replace(/[ \t]*$/g,"");
            c=_79(c);
            return m1+"<code>"+c+"</code>";
        });
    return _7b;
};
var _79=function(_82){
    _82=_82.replace(/&/g,"&amp;");
    _82=_82.replace(/</g,"&lt;");
    _82=_82.replace(/>/g,"&gt;");
    _82=_2e(_82,"*_{}[]\\",false);
    return _82;
};
var _29=function(_83){
    _83=_83.replace(/(\*\*|__)(?=\S)([^\r]*?\S[*_]*)\1/g,"<strong>$2</strong>");
    _83=_83.replace(/(\*|_)(?=\S)([^\r]*?\S)\1/g,"<em>$2</em>");
    return _83;
};
var _1f=function(_84){
    _84=_84.replace(/((^[ \t]*>[ \t]?.+\n(.+\n)*\n*)+)/gm,function(_85,m1){
            var bq=m1;
            bq=bq.replace(/^[ \t]*>[ \t]?/gm,"~0");
            bq=bq.replace(/~0/g,"");
            bq=bq.replace(/^[ \t]+$/gm,"");
            bq=_9(bq);
            bq=bq.replace(/(^|\n)/g,"$1  ");
            bq=bq.replace(/(\s*<pre>[^\r]+?<\/pre>)/gm,function(_88,m1){
                    var pre=m1;
                    pre=pre.replace(/^  /mg,"~0");
                    pre=pre.replace(/~0/g,"");
                    return pre;
                });
            return _1c("<blockquote>\n"+bq+"\n</blockquote>");
        });
    return _84;
};
var _20=function(_8b){
    _8b=_8b.replace(/^\n+/g,"");
    _8b=_8b.replace(/\n+$/g,"");
    var _8c=_8b.split(/\n{2,}/g);
    var _8d=new Array();
    var end=_8c.length;
    for(var i=0;i<end;i++){
        var str=_8c[i];
        if(str.search(/~K(\d+)K/g)>=0){
            _8d.push(str);
        }else{
            if(str.search(/\S/)>=0){
                str=_21(str);
                str=str.replace(/^([ \t]*)/g,"<p>");
                str+="</p>";
                _8d.push(str);
            }
        }
    }
    end=_8d.length;
    for(var i=0;i<end;i++){
        while(_8d[i].search(/~K(\d+)K/)>=0){
            var _91=_3[RegExp.$1];
            _91=_91.replace(/\$/g,"$$$$");
            _8d[i]=_8d[i].replace(/~K\d+K/,_91);
        }
    }
    return _8d.join("\n\n");
};
var _11=function(_92){
    _92=_92.replace(/&(?!#?[xX]?(?:[0-9a-fA-F]+|\w+);)/g,"&amp;");
    _92=_92.replace(/<(?![a-z\/?\$!])/gi,"&lt;");
    return _92;
};
var _25=function(_93){
    _93=_93.replace(/\\(\\)/g,_94);
    _93=_93.replace(/\\([`*_{}\[\]()>#+-.!])/g,_94);
    return _93;
};
var _28=function(_95){
    _95=_95.replace(/<((https?|ftp|dict):[^'">\s]+)>/gi,"<a href=\"$1\">$1</a>"); 
    _95=_95.replace(/<(?:mailto:)?([-.\w]+\@[-a-z0-9]+(\.[-a-z0-9]+)*\.[a-z]+)>/gi,function(_96,m1){
            return _98(_a(m1));
        });
    return _95;
};
var _98=function(_99){
    function char2hex(ch){
        var _9b="0123456789ABCDEF";
        var dec=ch.charCodeAt(0);
        return (_9b.charAt(dec>>4)+_9b.charAt(dec&15));
    }
    var _9d=[function(ch){
            return "&#"+ch.charCodeAt(0)+";";
        },function(ch){
            return "&#x"+char2hex(ch)+";";
        },function(ch){
            return ch;
        }];
    _99="mailto:"+_99;
    _99=_99.replace(/./g,function(ch){
            if(ch=="@"){
                ch=_9d[Math.floor(Math.random()*2)](ch);
            }else{
                if(ch!=":"){
					var r=Math.random();
					ch=(r>0.9?_9d[2](ch):r>0.45?_9d[1](ch):_9d[0](ch));
                }
            }
            return ch;
        });
    _99="<a href=\""+_99+"\">"+_99+"</a>";
    _99=_99.replace(/">.+:/g,"\">"); 
    return _99;
};
var _a=function(_a3){
    _a3=_a3.replace(/~E(\d+)E/g,function(_a4,m1){
            var _a6=parseInt(m1);
            return String.fromCharCode(_a6);
        });
    return _a3;
};
var _72=function(_a7){
    _a7=_a7.replace(/^(\t|[ ]{1,4})/gm,"~0");
    _a7=_a7.replace(/~0/g,"");
    return _a7;
};
var _6=function(_a8){
    _a8=_a8.replace(/\t(?=\t)/g,"    ");
    _a8=_a8.replace(/\t/g,"~A~B");
    _a8=_a8.replace(/~B(.+?)~A/g,function(_a9,m1,m2){
            var _ac=m1;
            var _ad=4-_ac.length%4;
            for(var i=0;i<_ad;i++){
                _ac+=" ";
            }
            return _ac;
        });
    _a8=_a8.replace(/~A/g,"    ");
    _a8=_a8.replace(/~B/g,"");
    return _a8;
};
var _2e=function(_af,_b0,_b1){
    var _b2="(["+_b0.replace(/([\[\]\\])/g,"\\$1")+"])";
    if(_b1){
        _b2="\\\\"+_b2;
    }
    var _b3=new RegExp(_b2,"g");
    _af=_af.replace(_b3,_94);
    return _af;
};
var _94=function(_b4,m1){
    var _b6=m1.charCodeAt(0);
    return "~E"+_b6+"E";
};
};
