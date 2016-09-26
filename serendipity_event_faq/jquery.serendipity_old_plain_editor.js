;(function($){
    /**
     * Some vanilla serendipity_editor functions converted to jQuery Closures
     * to make PLAIN Editor actions run in Serendipity 1.7 Series
     **/

    if (typeof getSelection !== 'function') {
        // Returns "position" of selection in textarea
        // Used internally by wrapSelectionWithLink()
        getSelection = function($txtarea) {
            var start = $txtarea[0].selectionStart;
            var end = $txtarea[0].selectionEnd;
            return $txtarea.val().substring(start, end);
        }
    }

    if (typeof wrapSelection !== 'function') {
        // Used by non-wysiwyg editor toolbar buttons to wrap selection
        // in a element associated with toolbar button
        wrapSelection = function(txtarea, openTag, closeTag) {
            scrollPos = false;

            if (txtarea.scrollTop) {
                scrollPos = txtarea.scrollTop;
            }

            // http://stackoverflow.com/questions/1712417/jquery-wrap-selected-text-in-a-textarea
            var $txtarea = $(txtarea);

            if (!$txtarea.length) {
                return;
            }

            var len = $txtarea.val().length;
            var start = $txtarea[0].selectionStart;
            var end = $txtarea[0].selectionEnd;
            var selectedText = $txtarea.val().substring(start, end);
            var replacement = openTag + selectedText + closeTag;
            $txtarea.val($txtarea.val().substring(0, start) + replacement + $txtarea.val().substring(end, len));

            $txtarea[0].selectionStart = start + replacement.length;
            $txtarea[0].selectionEnd = start + replacement.length;

            if (scrollPos) {
                txtarea.focus();
                txtarea.scrollTop = scrollPos;
            }
        }
    }

    if (typeof wrapSelectionWithLink !== 'function') {
        // Used by non-wysiwyg editor toolbar buttons to wrap selection
        // in <a> element (only)
        wrapSelectionWithLink = function(txtarea) {
            var my_link = prompt("Enter URL:","http://");

            if (my_link) {
                if (getSelection($(txtarea) ) == "") {
                    var my_desc = prompt("Enter Description", '');
                }
                var my_title = prompt("Enter title/tooltip:", "");
            }

            html_title = "";

            if (my_title != "" && my_title != null) {
                html_title = ' title="' + my_title + '"';
            }

            if (my_link != null) {
                lft = "<a href=\"" + my_link + "\"" + html_title + ">";

                if (my_desc != null && my_desc != "") {
                    rgt = my_desc + "</a>";
                } else {
                    rgt = "</a>";
                }

                wrapSelection(txtarea, lft, rgt);
            }

            return;
        }
    }

    if (typeof insertText !== 'function') {
        // Adds img element to selected text
        // Used internally by wrapInsImage()
        insertText = function(txtarea, str) {
            $txtarea = $(txtarea);
            var selLength = $txtarea.val().length;
            var selStart = $txtarea[0].selectionStart;
            var selEnd = $txtarea[0].selectionEnd;

            if (selEnd==1 || selEnd==2) {
                selEnd=selLength;
            }

            var before = $txtarea.val().substring(0,selStart);
            var after = $txtarea.val().substring(selStart);

            $txtarea.val(before + str + after);

            $txtarea[0].selectionStart = selStart + str.length
            $txtarea[0].selectionEnd = selStart + str.length
        }
    }

    if (typeof wrapInsImage !== 'function') {
        // Used by non-wysiwyg editor toolbar buttons to wrap selection
        // in <img> element (only); does not really "wrap", merely inserts
        // an <img> element before selected text
        wrapInsImage = function(txtarea) {
            var loc = prompt('Enter the image location: ');

            if (loc) {
                var alttxt = prompt('Enter alternative text for this image: ');
                insertText(txtarea,'<img src="'+ loc + '" alt="' + alttxt + '" />');
            }
        }
    }

    if (typeof noWysiwygAdd !== 'function') {
        // The noWysiwygAdd JS function is the vanila serendipity_imageSelector_addToBody js function which works fine in NO WYSIWYG mode
        // NOTE: the serendipity_imageSelector_addToBody could add any valid HTML string to the textarea
        noWysiwygAdd = function( str, textarea )
        {
            textarea = decodeURIComponent(textarea);
            // console.log('FAQnoWysiwygAdd: '+textarea);
            // default case: no wysiwyg editor
            eltarget = '';
            if (document.forms['serendipityEntry'] && document.forms['serendipityEntry']['serendipity['+ textarea +']']) {
                eltarget = document.forms['serendipityEntry']['serendipity['+ textarea +']'];
            } else if (document.forms['serendipityEntry'] && document.forms['serendipityEntry'][textarea]) {
                eltarget = document.forms['serendipityEntry'][textarea];
            } else {
                //eltarget = document.forms[0].elements[0]; // this did not work in staticpages textareas
                var elements = document.getElementsByTagName("textarea");
                for (var i = 0; i < elements.length; ++i) {
                    if (elements[i].getAttribute("name") == urldecode(textarea)) {
                        eltarget = elements[i];
                    }
                } if (eltarget=='') eltarget = document.forms[0].elements[0];
            }
            // console.log('FAQnoWysiwygAdd: '+eltarget);
            wrapSelection(eltarget, str, '');
            eltarget.focus();
        }
    }

    if (typeof serendipity_imageSelector_addToBody !== 'function') {
        // Since we are in a jquery closure we have to add the wrapper method to the global namespace!
        serendipity_imageSelector_addToBody = function(str, textarea)
        {
            // case oEditor == undefined
            noWysiwygAdd(str, textarea);
            // console.log('FAQclassAddToBody: oEditor undefined');
        }
    }
})(jQuery);