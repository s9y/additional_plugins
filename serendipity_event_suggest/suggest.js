function wrapSelection(txtarea, lft, rgt) {
    if (document.all) {
        IEWrap(txtarea, lft, rgt);
    } else if (document.getElementById) {
        mozWrap(txtarea, lft, rgt);
    }
}

function getIESelection(txtarea) {
    return document.selection.createRange().text;
} 

function wrapSelectionWithLink(txtarea) {
    var my_link = prompt("Geben Sie den Link ein:","http://");

    if (document.all && getIESelection(txtarea) == "" ||
         document.getElementById && getMozSelection(txtarea) == "") {
        var my_desc = prompt("Geben Sie eine Beschreibung ein", '');
    }

    if (my_link != null) {
        lft = "<a href=\"" + my_link + "\">";
        if (my_desc != null && my_desc != "") {
            rgt = my_desc + "</a>";
        } else {
            rgt = "</a>";
        }
        wrapSelection(txtarea, lft, rgt);
    }

    return;
}

function IEWrap(txtarea, lft, rgt) {
    strSelection = document.selection.createRange().text;
    if (strSelection != "") {
        document.selection.createRange().text = lft + strSelection + rgt;
    } else {
        txtarea.value = txtarea.value + lft + rgt;
    }
}

function mozWrap(txtarea, lft, rgt) {
    var selLength = txtarea.textLength;
    var selStart = txtarea.selectionStart;
    var selEnd = txtarea.selectionEnd;

    if (txtarea.setSelectionRange) {
        if (selEnd==1 || selEnd==2) selEnd=selLength;
        var s1 = (txtarea.value).substring(0,selStart);
        var s2 = (txtarea.value).substring(selStart, selEnd)
        var s3 = (txtarea.value).substring(selEnd, selLength);
        txtarea.value = s1 + lft + s2 + rgt + s3;
    } else {
        txtarea.value = txtarea.value + ' ' + lft + rgt + ' ';
    }
}

function getMozSelection(txtarea) {
    var selLength = txtarea.textLength;
    var selStart = txtarea.selectionStart;
    var selEnd = txtarea.selectionEnd;

    if (selEnd==1 || selEnd==2) {
        selEnd=selLength;
    }
    return (txtarea.value).substring(selStart, selEnd);
}

function checkSuggest() {
    return true;
}