function hide_unhide(thing, path, lines, icons, bottom){
    nav=document.getElementById(thing).style
    if (lines) {
        if (bottom) {
            plus = path + '/img/plus.gif';
            minus= path + '/img/minus.gif';
         } else {
            plus = path + '/img/plusbottom.gif';
            minus= path + '/img/minusbottom.gif';
         }
    }else{
        plus = path + '/img/nolines_plus.gif';
        minus= path + '/img/nolines_minus.gif';        
    }
    if(nav.display=="none"){
        document.getElementById(thing+'_image').src=minus;
        nav.display='block';
        if (icons) {
            document.getElementById(thing+'_folder').src=path +'/img/folderopen.gif';
        }
    }else{
        document.getElementById(thing+'_image').src=plus;
        nav.display='none';
        if (icons) {
            document.getElementById(thing+'_folder').src=path +'/img/folder.gif';
        }
    }
}
