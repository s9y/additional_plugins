/**
 * @license Copyright (c) from 2013, Author: Ian. All rights reserved.
 */

/**
 * @fileOverview A Serendipity serendipity_event_ckeditor CKEDITOR custom config file: cke_config.js, v. 2.1, 2014-10-13
 */

/**
 * Substitute every config option to CKE in here
 */
CKEDITOR.editorConfig = function( config ) {

    // Advanced Content Filter works in two modes:
    //      automatic - the filter is configured by editor features (like plugins, buttons, and commands) that are enabled with configuration options
    //                  such as CKEDITOR.config.plugins, CKEDITOR.config.extraPlugins, and CKEDITOR.config.toolbar,
    //      custom    - the filter is configured by the CKEDITOR.config.allowedContent option and only features that match this setting are activated.
    // In both modes it is possible to extend the filter configuration by using the CKEDITOR.config.extraAllowedContent setting.
    // If you want to disable Advanced Content Filter, set CKEDITOR.config.allowedContent to true.
    // All available editor features will be activated and input data will not be filtered.
    // Allowed content rules. This setting is used when instantiating CKEDITOR.editor.filter.
    // The following values are accepted:
    //      CKEDITOR.filter.allowedContentRules - defined rules will be added to the CKEDITOR.editor.filter.
    //      true - will disable the filter (data will not be filtered, all features will be activated).
    //      default - the filter will be configured by loaded features (toolbar items, commands, etc.).
    // In all cases filter configuration may be extended by extraAllowedContent. This option may be especially useful,
    // when you want to use the default allowedContent value along with some additional rules.
    //
    // List of regular expressions to be executed on ***input HTML***, indicating HTML source code that, when matched, must not be available in the WYSIWYG mode for editing.

    // Set ACF by serendipity_event_ckeditor plugin option - default (false)
    // The automatic mode is on (false) when the CKEDITOR.config.allowedContent option is not set in your editor configuration.
    // This is the default setting which means that from now on by default all CKEditor contents will be filtered.
    if (CONFIG_ACF_OFF === true) {
        config.allowedContent = CONFIG_ACF_OFF;
    } else { // this is ACF ON by default

        // List of regular expressions to be executed on ***input HTML***, indicating HTML source code that, when matched, must not be available in the WYSIWYG mode for editing.

        // allow <script> tags
        //config.protectedSource.push( /<(script)[^>]*>.*<\/script>/ig ); // already set as default in ckeditor.js [/<script[\s\S]*?<\/script>/gi,/<noscript[\s\S]*?<\/noscript>/gi]
        // allow imageselectorplus mediainsert tag codes
        config.protectedSource.push( /<(mediainsert)[^>]*>[\s\S]*?<\/mediainsert>/img );
        // allow a Smarty like {} tag syntax without inner whitespace, which would be some other code part.
        config.protectedSource.push( /\{[a-zA-Z\$].*?\}/gi );
        // allow wp like [[mytag]] [[{$mytag}]] widget tags with >= 4.4.1
        config.protectedSource.push(/\[\[([^\[\]])+\]\]/g);

        // Set placeholder tag cases - elements [attributes]{styles}(classes) to protect ACF removements.
        // Allowed <mediainsert>, <gallery>, <media> tags (imageselectorplus galleries) - which tells ACF to not touch the code!
        // Allowed <div> is a need for Media Library inserts - which tells ACF to not touch the code!
        // <img[height,width]> This Media Library image is even needed to avoid ACF OFF removement of height attributes.
        // <pre[*attributes](*classes)> for previous used prettyprints by ckeditor plugin pbckcode
        config.extraAllowedContent = 'mediainsert[*]{*}(*);gallery[*]{*}(*);media[*]{*}(*);script[*]{*}(*);audio[*]{*}(*);div[*]{*}(*);img[height,width];pre[*](*);';

        // CKEDITOR.protectedSource patterns used regex Escape sequences
        //            \s any whitespace character; 
        //            \S any character that is not a whitespace character
        //            \t tab (hex 09); 
        //            \r carriage return (hex 0D); 
        //            \n newline (hex 0A); 
        // Pattern Modifiers
        //            /i caseless, match both upper and lower case letters
        //            /m treat as multiline
        //            /g be greedy

    }

    // Prevent filler nodes in all empty blocks. - case switching source and wysiwyg mode multiple times
    //config.fillEmptyBlocks = false; // default (true) - switches <p>&nbsp;</p> to <p></p>
    //config.ignoreEmptyParagraph = false; // default(true) - Whether the editor must output an empty value ('') if it's contents is made by an empty paragraph only. (Extends to config.fillEmptyBlocks)
    // It will still generate an empty <p></p> though.
    //config.autoParagraph = false; // defaults(true)
    // DEV NOTES: Please note that since CKEditor 4.4.5 the config.autoParagraph configuration option was marked deprecated, since changing the default value might introduce unpredictable usability issues and so it is highly unrecommended.

    // The configuration setting that controls the ENTER mode is "config.enterMode" and it offers three options:
    // (1) The default creates a paragraph element each time the "enter" key is pressed:
    //config.enterMode = CKEDITOR.ENTER_P; // inserts <p></p>
    // (2) You can choose to create a "div" element instead of a paragraph:
    //config.enterMode = CKEDITOR.ENTER_DIV; // inserts <div></div>
    // (3) If you prefer to not wrap the text in anything, you can choose to insert a line break tag:
    //config.enterMode = CKEDITOR.ENTER_BR; // inserts <br />
    // You can always use SHIFT+ENTER to set a br in the P-mode default option or change the SHIFT-mode to something else
    //config.shiftEnterMode = CKEDITOR.ENTER_BR;
    // Better learn to do it via keyboard commands, see cheatsheet toolbar button.

    // Whether to use HTML entities in the output.
    //config.entities = false; // defaults(true)

    //config.htmlEncodeOutput = false; // defaults(true)

    // ui configurations - just some examples to play around
    //config.uiColor = 'transparent'; // standard, but better disable config.uiColor all
    //config.uiColor = '#CFD1CF'; // standard grey
    //config.uiColor = '#f5f5f5'; // standard light grey
    //config.uiColor = '#E6EDF3'; // extreme light blue
    //config.uiColor = '#DFE8F6'; // very light blue
    //config.uiColor = '#9AB8F3'; // light blue/violet
    //config.uiColor = '#AADC6E'; // light green
    //config.uiColor = '#FFDC6E'; // light gold
    //config.uiColor = '#FF8040'; // mango
    //config.uiColor = '#FF2400'; // scarlet red
    //config.uiColor = '#14B8C4'; // light turquoise
    config.skin    = 'moono';
    config.height  = 400;

    // The previously used PBCKCODE CODE Editor was replaced by the codesnippet plugin , which was developed and enhanced during the development of the CKEDITOR 4 Series.
    // It has by default more code types, does not need any CDN, and uses less ressources being better integrated. But it uses a different highlighter js file (highlighter.pack.js).
    // If having used the prettify output already in your entries, your need to set the new compat mode option to allow both.

    // Allow certain font sizes, eg.
    //config.fontSize_sizes = '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;15/15px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px' ;
    // Allow one(!) default font label, eg.
    //config.font_defaultLabel = 'Arial';
    // Add other font names to the list of fonts names to be displayed in the Font combo in the toolbar. - eg.
    //config.font_names = config.font_names + 
    //    'Arial/Arial, Helvetica, sans-serif;' +
    //    'Times New Roman/Times New Roman, Times, serif;' +
    //    'Verdana';

    // Native spell check functionality is by default disabled in the editor, use this to enable it.
    // Do not wonder if not working on demand, since Browsers need to match spell checker settings, etc., you need to hit the correct place/word, and so on.
    //config.disableNativeSpellChecker = false;
    // [CRTL + right mouse click] gives access to Browsers contextmenu, else you need to disable and set these
    // The general idea is that you would need to remove all plugins that depend on the "contextmenu" one for removing the "contextmenu" one itself to work. But this has other sideeffects!
    //config.removePlugins = 'wsc,scayt,menubutton,liststyle,tabletools,contextmenu';
    //config.browserContextMenuOnCtrl = true;
    //config.wsc_lang = 'de_DE'; //Defaults to: 'en_US'
    //config.scayt_sLang = 'de_DE'; //Defaults to: 'en_US'

    // Add custom Serendipity styles to ckeditor wysiwyg-mode, to repect S9y css image floats
    config.contentsCss = CKEDITOR_PLUGPATH + 'serendipity_event_ckeditor/wysiwyg-style.css';

    // Remove custom toolbar buttons and plugins from all toolbars
    // A list of plugins that must not be loaded. This setting makes it possible to avoid loading some plugins defined in the CKEDITOR.config.plugins setting, without having to touch it and potentially break it.
    config.removePlugins = 'flash,iframe,forms'; // possible strict suggestions: 'flash,iframe,elementspath,save,font,showblocks,div,liststyle,pagebreak,smiley,specialchar,horizontalrule,indentblock,justify,pastefromword,newpage,preview,print,stylescombo'
    config.removeButtons = 'Preview,Styles'; // these buttons are useless in Serendipity and therefore not set. Without even the toolbar Groups break better on screens.

    // Default theme of CKEDITOR codesnippet plugin - else use 'default' or 'monokai_sublime' or any of those described at https://highlightjs.org/static/test.html
    config.codeSnippet_theme = 'GitHub';
    // Its default toolbar group changed away from 'insert' to new 'snippet' group.
    // The preset github.css theme was copied to this plugins serendipity_event_ckeditor named as highlighter.css for frontend binding.

    // We cheat ckeditor instances by adding all available button names (in s9ypluginbuttons) to "both" toolbar instances, in case of having two textareas.
    // The instanciation will only take the ones being currently initiated in wysiwyg_init.tpl output, in the source code.
    // The hooked and added extraPlugins in wysiwyg_init become not automatically true for preset toolbars (Basic, Standard, Full) like this, but do for the fallback toolbarGroups later on.
    var s9ypluginbuttonsAll = s9ymediabuttons.concat(s9ypluginbuttons);

    // in case of toolbar : Basic
    config.toolbar_Basic = [
        ['Format'],['Bold','Italic','Underline','Superscript','-','NumberedList','BulletedList','Blockquote'],['JustifyBlock','JustifyCenter','JustifyRight'],['Image','-','Link','Unlink'],['CodeSnippet'],['MediaEmbed'], s9ypluginbuttonsAll, ['Source']
    ];

    // in case of toolbar : Full (moved 'Source' button)
    config.toolbar_Full = [
        { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'colors',      items : [ 'TextColor','BGColor' ] },
        { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','CreateDiv' ] },
        { name: 'blocks',      items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
        { name: 'bidi',        items : [ 'BidiLtr','BidiRtl' ] },
        { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
        CONFIG_TOOLBAR_BREAK,
        { name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
        { name: 'document',    items : [ 'Save','NewPage','DocProps','Print','-','Templates' ] },
        { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
        { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
        { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
        CONFIG_TOOLBAR_BREAK,
        { name: 'snippet', groups : [ 'snippet' ], items : [ 'CodeSnippet' ] },
        { name: 'mediaembed',  items : [ 'MediaEmbed' ] },
        { name: 'others',      items : s9ypluginbuttonsAll },
        { name: 'document', groups : [ 'mode', 'document', 'doctools' ], items : [ 'Source' ] },
        { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-','About' ] },
        { name: 'cheatsheet',  items : ['CheatSheet'] }
    ];
//    console.log(JSON.stringify(config.toolbar_Full));

    config.toolbar_Standard = [
        { name: 'basicstyles', items : [ 'Format','-','Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'paragraph',  groups: [ 'list', 'blocks', 'align' ], items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote' ] },
        { name: 'blocks',      items : [ 'JustifyCenter','JustifyRight','JustifyBlock' ] },
        { name: 'insert', items: [ 'Image', '-', 'Table', 'HorizontalRule', 'SpecialChar'] },
        { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
        CONFIG_TOOLBAR_BREAK,
        { name: 'clipboard',   items : [ 'Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo'] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Scayt' ] },
        { name: 'snippet', items : [ 'CodeSnippet' ] },
        { name: 'mediaembed', items : [ 'MediaEmbed' ] },
        { name: 'others', items: s9ypluginbuttonsAll },
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
        { name: 'about', items: [ 'About', ] },
        { name: 'cheatsheet', items : ['CheatSheet'] }
    ];

    // set the serendipity_event_ckeditor custom toolbar group
    // Note: Groups indent and forms are disabled, while mediaembed and codesnippet plugins are set. The procurator placeholders for "protected Source" is buttonless.
    //       when plugins config options denies codebutton, there is no need to disable it in here too (this is possibly done automatically if not set in extraPlugins list)
    // This is a tweaked toolbarGroups fallback, which does not need any extras manually filled in 'others', since done automatically by ckeditor.js or by the other named toolbars
    config.toolbarGroups = [
        { name: 'styles' },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
//    	{ name: 'forms' },
        { name: 'colors' },
        { name: 'paragraph', groups: [ 'list', /*'indent', */'blocks', 'align', 'bidi' ] },
        { name: 'links' },

        { name: 's9yml' },
        { name: 'insert' },
//        { name: 'ident' },
        { name: 'document', groups: [ /*'mode', */'document', 'doctools' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },

        { name: 'snippet', groups: [ 'codesnippet', 'snippet' ] },
        { name: 'mediaembed' },
        { name: 'others' },
        { name: 'tools' },
        { name: 'about' },
        { name: 'mode' },
        { name: 'cheatsheet' }
    ];

};
