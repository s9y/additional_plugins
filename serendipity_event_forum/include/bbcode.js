<!-- // Hide from older browsers
/* $Id: bbcode.js,v 1.2 2005/10/10 08:40:14 dma147 Exp $ */
/*
# Copyright (c) 2003-2005, Jannis Hermanns (on behalf the Serendipity Developer Team)
# All rights reserved.  See LICENSE file for licensing details
*/


/*
    Written by chris wetherell
    http://www.massless.org
    chris [THE AT SIGN] massless.org

    warning: it only works for IE4+/Win and Moz1.1+
    feel free to take it for your site
    if there are any problems, let chris know.
*/

var thisForm;

function getMozSelection(txtarea) {
    var selLength = txtarea.textLength;
    var selStart = txtarea.selectionStart;
    var selEnd = txtarea.selectionEnd;

    if (selEnd==1 || selEnd==2) {
        selEnd=selLength;
    }
    return (txtarea.value).substring(selStart, selEnd);
}

function getIESelection(txtarea) {
    return document.selection.createRange().text;
}

function mozWrap(txtarea, lft, rgt) {
    var selLength = txtarea.textLength;
    var selStart = txtarea.selectionStart;
    var selEnd = txtarea.selectionEnd;

    if (selEnd==1 || selEnd==2) selEnd=selLength;
    var s1 = (txtarea.value).substring(0,selStart);
    var s2 = (txtarea.value).substring(selStart, selEnd)
    var s3 = (txtarea.value).substring(selEnd, selLength);
    txtarea.value = s1 + lft + s2 + rgt + s3;
}

function IEWrap(txtarea, lft, rgt) {
    strSelection = document.selection.createRange().text;
    if (strSelection != "") {
        document.selection.createRange().text = lft + strSelection + rgt;
    } else {
        txtarea.value = txtarea.value + lft + rgt;
    }
}

function wrapSelection(txtarea, lft, rgt) {
    if (document.all) {
        IEWrap(txtarea, lft, rgt);
    } else if (document.getElementById) {
        mozWrap(txtarea, lft, rgt);
    }
}

function wrapSelectionWithLink(txtarea) {
    var my_link = prompt("Enter URL:","http://");

    if (document.all && getIESelection(txtarea) == "" ||
         document.getElementById && getMozSelection(txtarea) == "") {
        var my_desc = prompt("Enter Description", '');
    }
    
    if (my_link != null) {
        lft = "[url=" + my_link + "]";
        if (my_desc != null && my_desc != "") {
            rgt = my_desc + "[/url]";
        } else {
            rgt = "[/url]";
        }
        wrapSelection(txtarea, lft, rgt);
    }

    return;
}
/* end chris w. script */

function pickColor(color) {
    if (color != null) {
        lft = "[color=" + color + "]";
        rgt = "[/color]";
        
        if (document.all) {
            strSelection = document.selection.createRange().text;
            if (strSelection != "") {
                document.selection.createRange().text = lft + strSelection + rgt;
            } else {
                ColorPicker_targetInput.value = ColorPicker_targetInput.value + lft + rgt;
            }
        } else if (document.getElementById) {
            var selLength = ColorPicker_targetInput.textLength;
            var selStart = ColorPicker_targetInput.selectionStart;
            var selEnd = ColorPicker_targetInput.selectionEnd;
            if (selEnd==1 || selEnd==2) selEnd=selLength;
            var s1 = (ColorPicker_targetInput.value).substring(0,selStart);
            var s2 = (ColorPicker_targetInput.value).substring(selStart, selEnd)
            var s3 = (ColorPicker_targetInput.value).substring(selEnd, selLength);
            ColorPicker_targetInput.value = s1 + lft + s2 + rgt + s3;
        }
    }
}

function wrapSelectionWithColor(txtarea) {
    var cp = new ColorPicker('window');
    cp.select(txtarea,'insC');
    return;
}

function mozInsert(txtarea, str) {
    var selLength = txtarea.textLength;
    var selStart = txtarea.selectionStart;
    var selEnd = txtarea.selectionEnd;
    if (selEnd==1 || selEnd==2) {
        selEnd=selLength;
    }
    var s1 = (txtarea.value).substring(0,selStart);
    var s2 = (txtarea.value).substring(selStart, selEnd)
    var s3 = (txtarea.value).substring(selEnd, selLength);
    txtarea.value = s1 + str + s2 + s3;
}

function wrapInsImage(area) {
    var loc = prompt('Enter the Image Location: ');
    if (!loc) {
        return;
    }
    mozInsert(area,'[img]'+ loc + '[/img]');
}

/* end Better-Editor functions */

function serendipity_insImage (area) {
    var loc = prompt('Enter the Image Location: ');
    if (!loc) {
        area.focus();
        return;
    }

    area.value = area.value + '<[img]' + loc + '[/img]';
    area.focus();
}

function serendipity_insBasic (area, tag) {
    area.value = area.value + "[" + tag + "][/" + tag + "]";
    area.focus();
}

function serendipity_insLink (area) {
    var loc      = prompt('Enter URL Location: ');
    var text     = prompt('Enter Description: ');
    if (!loc) {
        area.focus();
        return;
    }

    area.value = area.value + '[url=' + loc + ']' + (text ? text : loc) + '[/url]';
    area.focus();
}

// -->
