/**
 * @license Copyright (c) from 2013, Author: Ian. All rights reserved.
 */

/**
 * @fileOverview A Serendipity serendipity_event_ckeditor CKEDITOR custom config file: cke_config.js, v. 2.4, 2015-08-14
 */

/**
 * Substitute every config option to CKE in here
 */
CKEDITOR.editorConfig = function( config ) {

    // set Serendipity default lang
    config.language = CKECONFIG_LANG;

    /** SECTION: ACF
        Advanced Content Filter works in two modes:
            automatic - the filter is configured by editor features (like plugins, buttons, and commands) that are enabled with configuration options
                        such as CKEDITOR.config.plugins, CKEDITOR.config.extraPlugins, and CKEDITOR.config.toolbar,
            custom    - the filter is configured by the CKEDITOR.config.allowedContent option and only features that match this setting are activated.
        In both modes it is possible to extend the filter configuration by using the CKEDITOR.config.extraAllowedContent setting.
        If you want to disable Advanced Content Filter, set CKEDITOR.config.allowedContent to true.
        All available editor features will be activated and input data will not be filtered.
        Allowed content rules. This setting is used when instantiating CKEDITOR.editor.filter.
        The following values are accepted:
            CKEDITOR.filter.allowedContentRules - defined rules will be added to the CKEDITOR.editor.filter.
            true    - will disable the filter (data will not be filtered, all features will be activated).
            default - the filter will be configured by loaded features (toolbar items, commands, etc.).
            http://docs.ckeditor.com/?_escaped_fragment_=/guide/dev_allowed_content_rules-section-string-format#!/guide/dev_allowed_content_rules-section-string-format
        In all cases filter configuration may be extended by extraAllowedContent. This option may be especially useful,
        when you want to use the default allowedContent value along with some additional rules.
        Read more of this here:
            http://docs.ckeditor.com/?_escaped_fragment_=/guide/dev_acf#!/guide/dev_acf
    */


    /**
     Set ACF by serendipity_event_ckeditor plugin option - default (false)
     The automatic mode is on (false) when the CKEDITOR.config.allowedContent option is not set in your editor configuration.
     This is the default setting which means that from now on by default all CKEditor contents will be filtered.
    */
    if (CKECONFIG_ACF_OFF === true) {
        config.allowedContent = CKECONFIG_ACF_OFF;
    } else { // this is ACF ON by default

        /** List of regular expressions to be executed on ***input HTML***, indicating HTML source code, that, when matched, must not be available in the WYSIWYG mode for editing. */

        // allow <script> tags
        //config.protectedSource.push( /<(script)[^>]*>.*<\/script>/ig ); // already set as default in ckeditor.js [/<script[\s\S]*?<\/script>/gi,/<noscript[\s\S]*?<\/noscript>/gi]
        // allow imageselectorplus mediainsert tag codes
        config.protectedSource.push( /<(mediainsert)[^>]*>[\s\S]*?<\/mediainsert>/img );
        // allow a Smarty like {} tag syntax without inner whitespace, which would be some other code part.
        //config.protectedSource.push( /\{[a-zA-Z\$].*?\}/gi ); // Smarty markup protection disabled, since now being usable w/o setting ACF OFF
        // allow WP like [[mytag]] [[{$mytag}]] widget tags with >= 4.4.1 for an imaginable markup replacements S9y plugin
        //config.protectedSource.push(/\[\[([^\[\]])+\]\]/g); // WP-Smarty like markup protection disabled, since now being usable w/o setting ACF OFF

        /**
         CKEDITOR.protectedSource patterns used regex Escape sequences
                \s any whitespace character;
                \S any character that is not a whitespace character
                \t tab (hex 09);
                \r carriage return (hex 0D);
                \n newline (hex 0A);
         Pattern Modifiers
                /i caseless, match both upper and lower case letters
                /m treat as multiline
                /g be greedy
        */

        /** SECTION: Extra Allowed Content
            Set placeholder tag cases - elements [attributes]{styles}(classes) to protect ACF removements.
              - Allowed <mediainsert>, <gallery>, <media> tags (imageselectorplus galleries) - which tells ACF to not touch the code!
              - Allowed <div> is a need for Media Library inserts - which tells ACF to not touch the code!
              - Reset <img[height,width]> Media Library image inserts to avoid ACF OFF removement of height attributes. (Dependency in cke_plugin.js)
              - Allow <pre[*attributes](*classes)> for custom attributes/classes in codesnippet code blocks
        */
        // protect tags
        config.extraAllowedContent = 'mediainsert[*]{*}(*);gallery[*]{*}(*);media[*]{*}(*);script[*]{*}(*);audio[*]{*}(*);video[*];source[*];div[*]{*}(*);span[*]{*}(*);img[height,width];pre[*](*);';
        // do not use auto paragraphs added to these allowed tags.
        config.autoParagraph = false;
    }

    /** SECTION: Other behaviour config rules

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
    // Better learn to do this via keyboard commands, see cheatsheet toolbar button.
    */

    /**
      Whether to use HTML entities in storing and in the output.
      With v. 4.7.0, strictly let S9y handle this, since we need it for search result terms!
      Storing html entities to the database is no good for this case! You may only be hit by this if using Umlauts or very specialized chars.
      If you really are subjected to this search result issue for previous entries stored by this plugin editor,
      you will have to call and re-submit these entries again. Sorry!
    */
    config.entities = false; // defaults(true)
    config.htmlEncodeOutput = false; // defaults(true)


    /** SECTION: UI configurations
    config.uiColor = 'transparent'; // standard, but better disable config.uiColor at all
    // just some examples
    config.uiColor = '#CFD1CF'; // standard grey
    config.uiColor = '#f5f5f5'; // standard light grey
    config.uiColor = '#E6EDF3'; // extreme light blue
    config.uiColor = '#DFE8F6'; // very light blue
    config.uiColor = '#9AB8F3'; // light blue/violet
    config.uiColor = '#AADC6E'; // light green
    config.uiColor = '#FFDC6E'; // light gold
    config.uiColor = '#FF8040'; // mango
    config.uiColor = '#FF2400'; // scarlet red
    config.uiColor = '#14B8C4'; // light turquoise
    */
    config.skin    = 'moono'; // this is default
    config.height  = 400; // dito

    /**
     The previously used PBCKCODE CODE Editor was replaced by the codesnippet plugin , which was developed and enhanced during the development of the CKEDITOR 4 Series.
     It supports by default more code types, does not need any CDN, and uses less ressources being better integrated. But it uses a different highlighter js file (highlighter.pack.js).
     PLEASE NOTE: If having used the prettify output already in your entries, your need to set the new compat mode option to allow both.
    */

    /** SECTION: Custom Config Content Styles
        We can not use templates/xxx/admin/ as a path here, since we would need template and userTemplate path parts as dynamic vars
    */
    // Add custom Serendipity styles to ckeditor wysiwyg-mode, to repect S9y css image floats
    config.contentsCss = CKEDITOR_PLUGPATH + 'serendipity_event_ckeditor/wysiwyg-style.css';


    /** SECTION: Custom Plugin and Button behaviour configurations **/
    /**
    // Native spell check functionality is by default disabled in the editor, use this to enable it.
    // Do not wonder if this is not working on demand, since Browsers need to match spell checker settings, etc., you need to hit the correct place/word, and so on.
    //config.disableNativeSpellChecker = false;
    // [CRTL + right mouse click] gives access to Browsers contextmenu, else you need to disable and set these
    // The general idea is that you would need to remove all plugins that depend on the "contextmenu" one for removing the "contextmenu" one itself to work. But this has other sideeffects!
    //config.removePlugins = 'wsc,scayt,menubutton,liststyle,tabletools,contextmenu';
    //config.browserContextMenuOnCtrl = true;
    //config.wsc_lang = 'de_DE'; //Defaults to: 'en_US'
    //config.scayt_sLang = 'de_DE'; //Defaults to: 'en_US'
    */

    /**
    // Allow certain font sizes, eg.
    //config.fontSize_sizes = '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;15/15px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px' ;
    // Allow one(!) default font label, eg.
    //config.font_defaultLabel = 'Arial';
    // Add other font names to the list of fonts names to be displayed in the Font combo in the toolbar. - eg.
    //config.font_names = config.font_names +
    //    'Arial/Arial, Helvetica, sans-serif;' +
    //    'Times New Roman/Times New Roman, Times, serif;' +
    //    'Verdana';
    */


    // Remove custom toolbar buttons and plugins from all toolbars
    // A list of plugins that must not be loaded. This setting makes it possible to avoid loading some plugins defined in the CKEDITOR.config.plugins setting, without having to touch it and potentially break it.
    config.removePlugins = 'flash,iframe,forms'; // possible strict suggestions: 'flash,iframe,elementspath,save,font,showblocks,div,liststyle,pagebreak,smiley,specialchar,horizontalrule,indentblock,justify,pastefromword,newpage,preview,print,stylescombo'
    config.removeButtons = 'Preview,Styles,JustifyLeft'; // these buttons are useless or preset in Serendipity and therefore not set. Without even the toolbar Groups break better on screens.

    // Default theme of CKEDITOR codesnippet plugin - else use 'default' or 'monokai_sublime' or any of those described at https://highlightjs.org/static/test.html
    config.codeSnippet_theme = 'GitHub';
    /**
     PLEASE NOTE:
        Its default toolbar group changed away from 'insert' to new 'snippet' group name.
        The preset github.css theme was copied to this plugins serendipity_event_ckeditor directory and named highlighter.css for frontend binding.
    */


    /** SECTION: Certain Plugin Buttons
        We cheat ckeditor instances by adding all available button names (in s9ypluginbuttons) to "both" toolbar instances, in case of having two textareas.
        The instanciation will only take the ones being currently initiated in form pages source code, or in serendipity.admin.js in a 2.0 environment.
        The hooked and added extraPlugins in the cke_plugin.js file, do not become automatically true for preset toolbars (Basic, Standard, Full) like this, but will do for the fallback toolbarGroups later on.
    */
    // concat button arrays
    var s9ypluginbuttonsAll = s9ymediabuttons.concat(s9ypluginbuttons);


    /** SECTION: Build Preset Toolbars

        BASIC: Serendipity (basic)
        STANDARD: Serendipity (standard)
        FULL: Serendipity (full)

        PLEASE NOTE:
        1. In order to work properly within all toolbars, please do not remove the eg. { name: 'insert', items: [ 'Image' ] }, group and Image button, since then the s9ymediabutton does not properly insert!
           This ckeditor image widget is disabled/hidden by css (htmlarea/s9y_cketoolbar.css) and is only presented in the CKE PRESET toolbar.
        2. If you really configure your own toolbar, choose the named and selected toolbar which comes near to your idea and edit the one.
    */

    // in case of Serendipity toolbar : "Basic"
    config.toolbar_Basic = [
        { name: 'styles',      items : [ 'Format', ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Superscript' ] },
        { name: 'paragraph',   items : [ 'NumberedList', 'BulletedList', 'Blockquote' ] },
        { name: 's9yml',       items : s9ymediabuttons },
        { name: 'insert',      items : [ 'Image' ] },
        { name: 'links',       items : [ 'Link','Unlink' ] },
        { name: 'snippet',     items : [ 'CodeSnippet' ] },
        { name: 'mediaembed',  items : [ 'MediaEmbed' ] },
        { name: 'others',      items : s9ypluginbuttons },
        { name: 'document',    items : [ 'Source' ] }
    ];
//    console.log(JSON.stringify(config.toolbar_Basic));

    // in case of Serendipity toolbar : "Full"
    // Breaks apart long paragraph group to better float
    // Moved 'Source' and removed 'Font' buttons; 'Styles', 'Preview' and 'JustifyLeft' are disabled overall.
    if (CKECONFIG_TOOLBAR_BREAK) {
      config.toolbar_Full = [
        { name: 'styles',      items : [ 'Styles','Format',/*'Font',*/'FontSize' ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'colors',      items : [ 'TextColor','BGColor' ] },
        { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','CreateDiv' ] },
        { name: 'blocks',      items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
        { name: 'bidi',        items : [ 'BidiLtr','BidiRtl' ] },
        { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
        CKECONFIG_TOOLBAR_BREAK,
        { name: 's9yml', items : s9ymediabuttons },
        { name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
        { name: 'document',    items : [ /*'Source','-',*/'Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
        { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
        { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
        { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
        CKECONFIG_TOOLBAR_BREAK,
        { name: 'snippet', groups : [ 'snippet' ], items : [ 'CodeSnippet' ] },
        { name: 'mediaembed',  items : [ 'MediaEmbed' ] },
        { name: 'others',      items : s9ypluginbuttons },
        { name: 'document', groups : [ 'mode', 'document', 'doctools' ], items : [ 'Source' ] },
        { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-','About' ] },
        { name: 'cheatsheet',  items : ['CheatSheet'] }
      ];
    } else {
      config.toolbar_Full = [
        { name: 'styles',      items : [ 'Styles','Format',/*'Font',*/'FontSize' ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
        { name: 'document',    items : [ /*'Source','-',*/'Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
        { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
        { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
        { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','CreateDiv' ] },
        { name: 'blocks',      items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
        { name: 'bidi',        items : [ 'BidiLtr','BidiRtl' ] },
        { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
        { name: 's9yml', items : s9ymediabuttons },
        { name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
        { name: 'colors',      items : [ 'TextColor','BGColor' ] },
        { name: 'snippet', groups : [ 'snippet' ], items : [ 'CodeSnippet' ] },
        { name: 'mediaembed',  items : [ 'MediaEmbed' ] },
        { name: 'others',      items : s9ypluginbuttons },
        { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-','About' ] },
        { name: 'document', groups : [ 'mode', 'document', 'doctools' ], items : [ 'Source' ] },
        { name: 'cheatsheet',  items : ['CheatSheet'] }
      ];
    }
//    console.log(JSON.stringify(config.toolbar_Full));

    // in case of Serendipity toolbar : "Standard"
    config.toolbar_Standard = [
        { name: 'basicstyles', items : [ 'Format','-','Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'paragraph', groups: [ 'list', 'blocks', 'align' ], items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote' ] },
        { name: 'blocks',      items : [ 'JustifyCenter','JustifyRight','JustifyBlock' ] },
        { name: 's9yml',       items : s9ymediabuttons },
        { name: 'insert',      items : [ 'Image', '-', 'Table', 'HorizontalRule', 'SpecialChar'] },
        { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
        CKECONFIG_TOOLBAR_BREAK,
        { name: 'clipboard',   items : [ 'Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo'] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Scayt' ] },
        { name: 'snippet',     items : [ 'CodeSnippet' ] },
        { name: 'mediaembed',  items : [ 'MediaEmbed' ] },
        { name: 'others',      items : s9ypluginbuttons },
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
        { name: 'about',       items : [ 'About', ] },
        { name: 'cheatsheet',  items : ['CheatSheet'] },
        { name: 'tools',       items : [ 'Maximize' ] }
    ];
//    console.log(JSON.stringify(config.toolbar_Standard));


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

    /** SECTION: Howto add Custom Plugins into toolbars
        1. Adding additional CKEDITOR Plugins to the config
           Download the Plugin, check version matching to this ckeditor version and drop the plugin to the /ckeditor/plugins directory.
           Copy the directories plugin name, eg 'mediaembed'.
           Add the plugin name to the "extraPlugins" string.
           Now add this name to this files upper config.toolbarGroup, wherever you like it to have, eg. "{ name: 'mediaembed' }," if that plugin emits a button to be placed into the toolbar.
           Or as { name: 'pluginname', items: 'PluginName' } eg { name: 'mediaembed', items: 'MediaEmbed' } in one of the upper toolbars, if that plugin emits a button to be placed into the toolbar.
           The ckeditor plugin download procedure will give information about dependency plugins and naming conventions.
           After a browser reload, the newly added plugin should load into your textareas toolbars.
        2. PLEASE NOTE:
           Do not use any customized CKEditor Downloads, since this will only work with CKE PRESET toolbars!
    */
};
