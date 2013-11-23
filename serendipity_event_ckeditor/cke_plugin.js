/*
 * Get the instance ready event and set global instance var
 * This is read by serendipity_editor.js and in case of serendipity_html_nugget_plugin by below serendipity_imageSelector_addToBody()
 */
CKEDITOR.on( 'instanceReady', function( event ) {
    event.editor.on( 'focus', function() {
        isinstance = this;
    });
});

/*
 * Create a prototyp foreach array function
 * This is faster than using ckeditor.js internal forEach() implementation or even using plain for()
 **/
if (!Array.prototype.forEach) {
    Array.prototype.forEach = function (fn, scope) {
        'use strict';
        var i, len;
        for (i = 0, len = this.length; i < len; ++i) {
            if (i in this) {
                fn.call(scope, this[i], i, this);
            }
        }
    };
}

/*
 * ExecutionCommand string replacement function
 * Used in CKEDITOR.plugins.add(), to get ready to execute (eval) the button command passed by Serendipity plugins
 * @param   string  string
 * @return  string  string
 **/
function ecfit(str) {
    str = str.replace('function() { ', '');
    str = str.replace(' }', '');
    str = str.replace(S9Y_BASEURL, '');
    return str;
}

/*
 * This was previously a nugget only area, spawned by head! (textareas of staticpage nuggets, html nugget plugins, etc.)
 * called via Spawnnugget(), set by real plugins like staticpages and cores functions_plugins_admin.inc in case of $ev['skip_nuggets'] === false
 * 
 * NOW it is used by all textareas!
 * 
 * @param string        $eventData['item']
 * @param string        $eventData['jsname']
 * @param array/object  jsEventData/json_encode($eventData['buttons'])
 **/
function Spawnnuggets(item = null, addEP = null, jsED = null) {

    var textarea_instance = !isNaN(item) ? 'nuggets' + item : item;
    var name_extraPlugins = (addEP !== null) ? addEP : textarea_instance;
    var jsEventData       = (jsED  !== null) ? jsED  : window.jsEventData; // global set by 'backend_wysiwyg_finish' hook
    var extraPluginList   = (CONFIG_ACF_OFF === true) ? name_extraPlugins+',mediaembed,pbckcode' : name_extraPlugins+',mediaembed,pbckcode,procurator'; // no spaces allowed!

    if (document.getElementById(textarea_instance)) {
        CKEDITOR.replace(textarea_instance, {
            // Load our specific configuration file.
            customConfig : CKEDITOR_PLUGPATH+'serendipity_event_ckeditor/cke_config.js',

            // or do and set
            // Reset toolbar Groups settings
            // toolbarGroups: null
            // or any other configuration option here
            // uiColor : '#AADC6E', // light green example
            // language: 'fr', // lang set example

            // set all plugins at once - no spaces allowed!
            extraPlugins: extraPluginList,

            // Set the startup mode view [OK]
            // startupMode: 'source',

            // listen on load - do I need this still?
            on: {
                loaded: function( evt ) {
                    var editor = evt.editor,
                        rules = {
                            elements: {
                                mediainsert: function( element ) {
                                    if (CONFIG_ACF_OFF !== true) {
                                        // XHTML output instead of HTML - but this does not react on trailing slash eg <media "blah" />
                                        // editor.dataProcessor.writer.selfClosingEnd = ' />';

                                        //avoid line breaks with special block elements
                                        var tags = ['mediainsert', 'gallery', 'media'];

                                        for (var key in tags) {
                                            editor.dataProcessor.writer.setRules(tags[key],
                                            {
                                                // Indicates that this tag causes indentation on line breaks inside of it.
                                                indent : true,
                                                // Inserts a line break before the element opening tag.
                                                breakBeforeOpen : true,
                                                // Inserts a line break after the element opening tag.
                                                breakAfterOpen : false,
                                                // Inserts a line break before the element closing tag.
                                                breakBeforeClose : true,
                                                // Inserts a line break after the element closing tag.
                                                breakAfterClose : false
                                            });
                                        }
                                    }
                                }
                            }
                        };
                    // It's good to set both filters - dataFilter is used when loading data and htmlFilter when retrieving.
                    editor.dataProcessor.htmlFilter.addRules( rules );
                    editor.dataProcessor.dataFilter.addRules( rules );
                }
            }
        });

        CKEDITOR.plugins.add(name_extraPlugins, {
            init: function(editor) {
                if(typeof jsEventData !== 'undefined') {
                    jsEventData.forEach( function(k, i) {
                        var execcom = ecfit(jsEventData[i].javascript);
                        editor.addCommand( jsEventData[i].id, {
                            exec: function( editor ) {
                                eval(execcom); // [OK] only way this code is executable
                            }
                        });
                        editor.ui.addButton(jsEventData[i].id, {
                            label:    jsEventData[i].name,
                            title:    jsEventData[i].name+' Plugin',
                            icon:     CKEDITOR_PLUGPATH+jsEventData[i].img_path,
                            iconName: jsEventData[i].id+'_icon',
                            command:  jsEventData[i].id
                        });
                    });
                }
                editor.addCommand( 'openML', {
                    exec : function( editor ) {
                        window.open('serendipity_admin_image_selector.php', 'ImageSel', 'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1');
                    }
                });
                editor.ui.addButton('openML', {
                    label:    'S9yMedia',
                    title:    'Serendipity Media Library',
                    icon:     CKEDITOR_MLIMGPATH,
                    iconName: 'openML_icon',
                    command:  'openML'
                });
            }
        });
    }
}

/*
 * Clone a serendipity_editor.js function, to avoid a 
 * TypeError: parent.self.opener.serendipity_imageSelector_addToBody is not a function
 * in case of serendipity_html_nugget_plugin textarea (nuggets3) usage in S9y 1.7 Series
 */
function serendipity_imageSelector_addToBody (str, textarea) {
    var oEditor = isinstance;
    if (oEditor.mode == "wysiwyg") {
        oEditor.insertHtml(str);
    }
}
