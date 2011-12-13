jQuery(document).ready(function() {
    jQuery('.templateEditorDelete').click(function(event) {
        event.preventDefault();
        $link = jQuery(jQuery(event.target).parent().get(0));
        var file = $link.parent().text().trim().replace(/\./g, '_');
        var file = 'DELETE_SURE_'+file;
        file = eval(file);
        if (confirm(file)) {
            window.location = $link.attr('href');
        }
    });
    if (typeof CodeMirror != "undefined") {
        var editor = CodeMirror.fromTextArea("template_editor", {
            parserfile: ["parsecss.js"],
            path: pluginPath + "codemirror/",
            stylesheet: pluginPath + "codemirror/csscolors.css",
            height: "40em",
            indentUnit: "4"
        });
    }
    jQuery('.templateEditorListItem').hover(function() {
        activateHighlightWithDelay($(this));
    }, function() {
        deactivateHighlightTimer($(this));
    });
});

/* Rename:
 * Hover over filename for 2 seconds
 * Press F2?
 * Enter new Name
 * Press Enter
 * */

function activateHighlightWithDelay($file) {
    this.templateTimer = setTimeout(function() {
        highlight($file)
        },
        2000);
}
 
function deactivateHighlightTimer($file) {
    if (this.templateTimer) {
        clearTimeout(this.templateTimer);
    }
}

function highlight($file) {
    $file.unbind();
    $file.addClass('templateEditorHighlight');
    //note that closest('li') will find the correct parent regardless
    //wether there is an a-element before or not
    $file.closest('li').prepend($file);
    $file.click(function(event) {
        $file = $(this);
        //prevent display-errors with the border:
        $file.css('border', '0');
        //prevent second relocation:
        $file.unbind();
        var base = '/index.php?/plugin/template_editor_rename';
        $file.editable(base, {
            submitdata : { 'file': $file.text(),
                'curDir': curDir
                 },
                 type    : 'text',
                 onblur : 'cancel',
                 callback : function(value, setting) {
                     unlight($(this));
                 },
                 onreset : function(settings, original) {
                     unlight($(original));
                 },
                 //seems to get better sized results in firefox, probably
                 //because of the bigger fontsize in input
                 width: 'none',
                 height: 'none'
        }).click();
    });
    $file.mouseleave(function() {
        unlight($(this));
    });
}

function unlight($file) {
    $file.removeClass('templateEditorHighlight');
    $file.unbind('click');
    $file.siblings('a').first().prepend($file);
    $file.hover(function() {
        activateHighlightWithDelay($(this));
    }, function() {
        deactivateHighlightTimer($(this));
    });
}

