/**
 * @license Copyright (c) from 2013, Author: Ian. All rights reserved.
 */

/**
 * @fileOverview A Serendipity serendipity_event_ckeditor CKEDITOR custom config file: cke_config.js, v. 1.9, 2014-06-24
 */

/**
 * Substitute every config option to CKE in here
 */
CKEDITOR.editorConfig = function( config ) {

    // KCFinder integration
    if (CONFIG_KCFD_ON === true) {
        config.filebrowserBrowseUrl      = CKEDITOR_BASEPATH +'../kcfinder/browse.php?type=files';
        config.filebrowserImageBrowseUrl = CKEDITOR_BASEPATH +'../kcfinder/browse.php?type=images';
        config.filebrowserFlashBrowseUrl = CKEDITOR_BASEPATH +'../kcfinder/browse.php?type=flash';
        config.filebrowserUploadUrl      = CKEDITOR_BASEPATH +'../kcfinder/upload.php?type=files';
        config.filebrowserImageUploadUrl = CKEDITOR_BASEPATH +'../kcfinder/upload.php?type=images';
        config.filebrowserFlashUploadUrl = CKEDITOR_BASEPATH +'../kcfinder/upload.php?type=flash';
    }

    // Advanced Content Filter works in two modes:
    //      automatic – the filter is configured by editor features (like plugins, buttons, and commands) that are enabled with configuration options
    //                  such as CKEDITOR.config.plugins, CKEDITOR.config.extraPlugins, and CKEDITOR.config.toolbar,
    //      custom    – the filter is configured by the CKEDITOR.config.allowedContent option and only features that match this setting are activated.
    // In both modes it is possible to extend the filter configuration by using the CKEDITOR.config.extraAllowedContent setting.
    // If you want to disable Advanced Content Filter, set CKEDITOR.config.allowedContent to true.
    // All available editor features will be activated and input data will not be filtered.
    // Allowed content rules. This setting is used when instantiating CKEDITOR.editor.filter.
    // The following values are accepted:
    //      CKEDITOR.filter.allowedContentRules – defined rules will be added to the CKEDITOR.editor.filter.
    //      true – will disable the filter (data will not be filtered, all features will be activated).
    //      default – the filter will be configured by loaded features (toolbar items, commands, etc.).
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
        // allow wp like [[mytag]] tags with >= 4.4.1
        config.protectedSource.push(/\[\[[^\]]*?\]\]/g);

        // Set placeholder tag cases - elements [attributes]{styles}(classes)
        // Allowed mediainsert, gallery, media tags (imageselectorplus galleries) - which tells ACF to not touch the code!
        // Allowed div is a need for Media Library inserts - which tells ACF to not touch the code!
        // img[height] is even needed to avoid ACF OFF removement of height attributes
        config.extraAllowedContent = 'mediainsert[*]{*}(*);gallery[*]{*}(*);media[*]{*}(*);script[*]{*}(*);audio[*]{*}(*);div[*]{*}(*);img[height,width];';

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

    } // do we need to put config.autoParagraph in here too?

    // Prevent filler nodes in all empty blocks. - case switching source and wysiwyg mode multiple times
    //config.fillEmptyBlocks = false; // default (true) - switches <p>&nbsp;</p> to <p></p>
    //config.ignoreEmptyParagraph = false; // default(true) - Whether the editor must output an empty value ('') if it's contents is made by an empty paragraph only. (extends to config.fillEmptyBlocks)
    // It will still generate an empty <p></p> though.
    config.autoParagraph = false; // but this one definitely prevents adding multiple empty paragraphs when switching source mode!!!

    // The configuration setting that controls the ENTER mode is "config.enterMode" and it offers three options:
    // (1) The default creates a paragraph element each time the "enter" key is pressed:
    //config.enterMode = CKEDITOR.ENTER_P; // inserts <p></p>
    // (2) You can choose to create a "div" element instead of a paragraph:
    //config.enterMode = CKEDITOR.ENTER_DIV; // inserts <div></div>
    // (3) If you prefer to not wrap the text in anything, you can choose to insert a line break tag:
    //config.enterMode = CKEDITOR.ENTER_BR; // inserts <br />
    // You can always use SHIFT+ENTER to set a br in the P-mode default option or change the SHIFT-mode to something else
    //config.shiftEnterMode = CKEDITOR.ENTER_BR;

    // Whether to use HTML entities in the output. Default Value: true
    //config.entities = false;

    //config.htmlEncodeOutput = false;

    // The configuration setting that controls the ENTER mode is "config.enterMode" and it offers three options:
    // (1) The default creates a paragraph element each time the "enter" key is pressed:
    //config.enterMode = CKEDITOR.ENTER_P; // inserts <p></p>
    // (2) You can choose to create a "div" element instead of a paragraph:
    //config.enterMode = CKEDITOR.ENTER_DIV; // inserts <div></div>
    // (3) If you prefer to not wrap the text in anything, you can choose to insert a line break tag:
    //config.enterMode = CKEDITOR.ENTER_BR; // inserts <br />
    // You can always use SHIFT+ENTER to set a br in the P-mode default option or change the SHIFT-mode to something else
    //config.shiftEnterMode = CKEDITOR.ENTER_BR;

    //config.entities = false;
    //config.htmlEncodeOutput = false;

    // ui configurations - just some examples
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
    config['skin'] = 'moono';
    config['height'] = 400;

    // Allow certain font sizes, eg.
    //config.fontSize_sizes = '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;15/15px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px' ;
    // Allow one(!) default font label, eg.
    //config.font_defaultLabel = 'Arial';
    // Add other font names to the list of fonts names to be displayed in the Font combo in the toolbar. - eg.
    //config.font_names = config.font_names + 
    //    'Arial/Arial, Helvetica, sans-serif;' +
    //    'Times New Roman/Times New Roman, Times, serif;' +
    //    'Verdana';

    // Add custom Serendipity styles to ckeditor wysiwyg-mode, to repect S9y css image floats
    config.contentsCss = CKEDITOR_PLUGPATH + 'serendipity_event_ckeditor/wysiwyg-style.css';

    // remove custom toolbar buttons and plugins
    //config.removePlugins = 'flash,iframe';
    config.removeButtons = 'Styles'; // this button is quite useless in a blog and the toolbar Groups break better on screens

    config.toolbar_Simple = [['Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat']];
    config.toolbar_Basic = [['Bold','Italic','Underline','Superscript','-','NumberedList','BulletedList','Outdent','Blockquote','-','Format'],['JustifyLeft','JustifyCenter','JustifyRight'],['Link','Unlink','Source']];

    // set the serendipity_event_ckeditor custom toolbar group
    // Note: indent is disabled, mediaembed and pbckcode plugins are set here, and procurator placeholders for "protected Source" is buttonless
    //       when plugins config options denies codebutton, there is no need to disable it in here too (this is possibly done automatically if not set in extraPlugins list)
    config.toolbarGroups = [
        { name: 'styles' },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', /*'indent', */'blocks', 'align', 'bidi' ] },
        { name: 'links' },
        { name: 'insert' },
        CONFIG_TOOLBAR_BREAK,
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'pbckcode' },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
        { name: 'others' },
        { name: 'mediaembed' },
        { name: 'tools' },
        { name: 'about' },
        { name: 'cheatsheet' }
    ];

    // A list of plugins that must not be loaded. This setting makes it possible to avoid loading some plugins defined in the CKEDITOR.config.plugins setting, without having to touch it and potentially break it.
    //config.removePlugins = 'elementspath,save,font';

};
