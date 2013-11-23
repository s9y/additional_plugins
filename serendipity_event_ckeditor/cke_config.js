/**
 * This is the serendipity_event_ckeditor plugins CKEDITOR custom config.js file
 * Substitute every config option to CKE in here
 */
CKEDITOR.editorConfig = function( config ) {

    // KCFinder integration - 2013-05-04
    config.filebrowserBrowseUrl      = CKEDITOR_BASEPATH +'../kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl = CKEDITOR_BASEPATH +'../kcfinder/browse.php?type=images';
    config.filebrowserFlashBrowseUrl = CKEDITOR_BASEPATH +'../kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl      = CKEDITOR_BASEPATH +'../kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl = CKEDITOR_BASEPATH +'../kcfinder/upload.php?type=images';
    config.filebrowserFlashUploadUrl = CKEDITOR_BASEPATH +'../kcfinder/upload.php?type=flash';

    // Set ACF by serendipity_event_ckeditor plugin option - default (false)
    // The automatic mode is on (false) when the CKEDITOR.config.allowedContent option is not set in your editor configuration. 
    // This is the default setting which means that from now on by default all CKEditor contents will be filtered.
    // Advanced Content Filter works in two modes:
    //   automatic � the filter is configured by editor features (like plugins, buttons, and commands) that are enabled with configuration options 
    //               such as CKEDITOR.config.plugins, CKEDITOR.config.extraPlugins, and CKEDITOR.config.toolbar,
    //   custom    � the filter is configured by the CKEDITOR.config.allowedContent option and only features that match this setting are activated.
    // In both modes it is possible to extend the filter configuration by using the CKEDITOR.config.extraAllowedContent setting.
    // If you want to disable Advanced Content Filter, set CKEDITOR.config.allowedContent to true. All available editor features will be activated and input data will not be filtered. 
    // Allowed content rules. This setting is used when instantiating CKEDITOR.editor.filter.
    // The following values are accepted:
    //     CKEDITOR.filter.allowedContentRules � defined rules will be added to the CKEDITOR.editor.filter.
    //     true � will disable the filter (data will not be filtered, all features will be activated).
    //     default � the filter will be configured by loaded features (toolbar items, commands, etc.).
    // In all cases filter configuration may be extended by extraAllowedContent. This option may be especially useful when you want to use the default allowedContent value along with some additional rules.
    // console.log('Double check - ACF is boolean: '+CONFIG_ACF_OFF);
    if (CONFIG_ACF_OFF === true) {
        config.allowedContent = CONFIG_ACF_OFF;
    } else { // this is ACF default

        // List of regular expressions to be executed on ***input HTML***, indicating HTML source code that, when matched, must not be available in the WYSIWYG mode for editing. 

        // allow <script> tags
        config.protectedSource.push( /<(script)[^>]*>.*<\/script>/ig ); // set default in ckeditor.js [/<script[\s\S]*?<\/script>/gi,/<noscript[\s\S]*?<\/noscript>/gi]
        // allow imageselectorplus mediainsert tag code
        config.protectedSource.push( /<(mediainsert)[^>]*>[\s\S]*?<\/mediainsert>/img );
        // allow a Smarty like {} tag syntax without starting whitespace, which would be some other code part.
        config.protectedSource.push( /\{[a-zA-Z\$].*?\}/gi );

        // set placeholder tag cases - elements [attributes]{styles}(classes)
        config.extraAllowedContent = 'mediainsert[*]{*}(*);script[*]{*}(*)'; // changed to ACF right order: attr style class

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

    // remove custom toolbar buttons and plugins
    //config.removePlugins = 'flash,iframe';
    config.removeButtons = 'Styles';

    // set the serendipity_event_ckeditor custom toolbar group
    // Note: indent is disabled, mediaembed and pbckcode plugins are set here, and procurator placeholders for "protected Source" is buttonless
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
        { name: 'about' }
    ];

};
