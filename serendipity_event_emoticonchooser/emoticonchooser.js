function emoticonchooser(instance_name, this_instance, cke_txtarea) {
    if (!instance_name) var instance_name = '';
    if (!this_instance) var this_instance = '';
    if (!cke_txtarea)   var cke_txtarea   = '';

    var editor_instance = 'editor'+instance_name;
    var use_emoticon    = 'use_emoticon_'+instance_name;
    var toggle_emobar   = 'toggle_emoticon_bar_'+instance_name;
    var drop_handler    = 'drop_handler_'+instance_name;

    window[toggle_emobar] = function () {
        el = document.getElementById('serendipity_emoticonchooser_'+instance_name+'');
        if (el.style.display == 'none') {
            el.style.display = 'inline-block';
        } else {
            el.style.display = 'none';
        }
    }

    window[use_emoticon] = function (img) {
        if(typeof(CKEDITOR) != 'undefined') {
            var oEditor = CKEDITOR.instances[cke_txtarea];
            oEditor.insertHtml(img);
        } else if(typeof(FCKeditorAPI) != 'undefined') {
            var oEditor = FCKeditorAPI.GetInstance(this_instance) ;
            oEditor.InsertHtml(img);
        } else if(typeof(xinha_editors) != 'undefined') {
            if(typeof(xinha_editors[this_instance]) != 'undefined') {
                // this is good for the two default editors (body & extended)
                xinha_editors[this_instance].insertHTML(img);
            } else if(typeof(xinha_editors[instance_name]) != 'undefined') {
                // this should work in any other cases than previous one
                xinha_editors[instance_name].insertHTML(img);
            } else {
                // this is the last chance to retrieve the instance of the editor !
                // editor has not been registered by the name of it's textarea
                // so we must iterate over editors to find the good one
                for (var editorName in xinha_editors) {
                    if(this_instance == xinha_editors[editorName]._textArea.name) {
                        xinha_editors[editorName].insertHTML(img);
                        return;
                    }
                }
                // not found ?!?
            }
        } else if(typeof(HTMLArea) != 'undefined') {
            if(typeof(editor_instance) != 'undefined')
                editor_instance.insertHTML(img);
            else if(typeof(htmlarea_editors) != 'undefined' && typeof(htmlarea_editors[instance_name]) != 'undefined')
                htmlarea_editors[instance_name].insertHTML(img);
        } else if(typeof(TinyMCE) != 'undefined') {
            //tinyMCE.execCommand('mceInsertContent', false, img);
            tinyMCE.execInstanceCommand(this_instance, 'mceInsertContent', false, img);
        } else  {
            // default case: no wysiwyg editor
            txtarea = document.getElementById(cke_txtarea); // must be this, since staticpages and entryforms set the [id] different
            if (txtarea.createTextRange && txtarea.caretPos) {
                caretPos = txtarea.caretPos;
                caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + ' ' + img + ' ' : caretPos.text + ' ' + img + ' ';
            } else {
                txtarea.value  += ' ' + img + ' ';
            }

            // alert(obj);
            txtarea.focus();
        }
    }

    if (window.jQuery && typeof(CKEDITOR) !== 'undefined') { jQuery(function ($) {
        window[drop_handler] = function (emo, target) {
            var rdata = CKEDITOR.instances[target].getSnapshot(); // this is equal to emo!!! while .getData() changes attributes order!!
            var rdata = rdata.replace(rdata.match(/<a href="javascript:use_emoticon_.*>.*<\/a>/g), emo); // [OK]
            CKEDITOR.instances[target].setData(rdata);
            return true;
        }
        // fake drag&drop
        var mouse_button = false;
        $('#serendipity_emoticonchooser_'+instance_name+'').find('img')
            .mousedown(function() {
                mouse_button = true;
            })
            .mouseup(function() {
                mouse_button = false;
            })
            .mouseout(function() {
                if (mouse_button) {
                    window[drop_handler]($(this)[0].outerHTML, cke_txtarea);
                    mouse_button = false;
                }
            });
        });
    }
}
