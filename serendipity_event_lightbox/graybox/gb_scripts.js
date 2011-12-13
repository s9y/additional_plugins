var GB_CURRENT=null;
GB_hide=function(){
GB_CURRENT.hide();
};
GreyBox=new AJS.Class({init:function(_1){
this.type="page";
this.overlay_click_close=false;
this.salt=0;
this.root_dir=GB_ROOT_DIR;
this.callback_fns=[];
this.reload_on_close=false;
this.src_loader=this.root_dir+"loader_frame.html";
AJS.update(this,_1);
},addCallback:function(fn){
if(fn){
this.callback_fns.push(fn);
}
},show:function(_3){
GB_CURRENT=this;
this.url=_3;
var _4=[AJS.$bytc("object"),AJS.$bytc("embed")];
if(AJS.isIe()){
_4.push(AJS.$bytc("select"));
}
AJS.map(AJS.flattenList(_4),function(_5){
_5.style.visibility="hidden";
});
this.createElements();
return false;
},hide:function(){
this.onHide();
if(AJS.fx){
var _6=this.overlay;
AJS.fx.fadeOut(this.overlay,{onComplete:function(){
AJS.removeElement(_6);
_6=null;
},duration:300});
AJS.removeElement(this.g_window);
}else{
AJS.removeElement(this.g_window,this.overlay);
}
this.removeFrame();
AJS.REV(window,"scroll",_GB_setOverlayDimension);
AJS.REV(window,"resize",_GB_update);
if(AJS.isIe()){
AJS.map(AJS.$bytc("select"),function(_7){
_7.style.visibility="visible";
});
}
AJS.map(AJS.$bytc("object"),function(_8){
_8.style.visibility="visible";
});
var _9=this.callback_fns;
if(_9!=[]){
AJS.map(_9,function(fn){
fn();
});
}
GB_CURRENT=null;
if(this.reload_on_close){
window.location.reload();
}
},update:function(){
this.setOverlayDimension();
this.setFrameSize();
this.setWindowPosition();
},createElements:function(){
this.initOverlay();
this.g_window=AJS.DIV({"id":"GB_window"});
AJS.hideElement(this.g_window);
AJS.getBody().insertBefore(this.g_window,this.overlay.nextSibling);
this.initFrame();
this.initHook();
this.update();
var me=this;
if(AJS.fx){
AJS.fx.fadeIn(this.overlay,{duration:300,to:0.7,onComplete:function(){
me.onShow();
AJS.showElement(me.g_window);
me.startLoading();
}});
}else{
AJS.setOpacity(this.overlay,0.7);
AJS.showElement(this.g_window);
this.onShow();
this.startLoading();
}
AJS.AEV(window,"scroll",_GB_setOverlayDimension);
AJS.AEV(window,"resize",_GB_update);
},removeFrame:function(){
try{
AJS.removeElement(this.iframe);
}
catch(e){
}
this.iframe=null;
},startLoading:function(){
this.iframe.src=this.src_loader+"?s="+this.salt++;
AJS.showElement(this.iframe);
},setOverlayDimension:function(){
var _c=AJS.getWindowSize();
if(AJS.isMozilla()||AJS.isOpera()){
AJS.setWidth(this.overlay,"100%");
}else{
AJS.setWidth(this.overlay,_c.w);
}
var _d=Math.max(AJS.getScrollTop()+_c.h,AJS.getScrollTop()+this.height);
if(_d<AJS.getScrollTop()){
AJS.setHeight(this.overlay,_d);
}else{
AJS.setHeight(this.overlay,AJS.getScrollTop()+_c.h);
}
},initOverlay:function(){
this.overlay=AJS.DIV({"id":"GB_overlay"});
if(this.overlay_click_close){
AJS.AEV(this.overlay,"click",GB_hide);
}
AJS.setOpacity(this.overlay,0);
AJS.getBody().insertBefore(this.overlay,AJS.getBody().firstChild);
},initFrame:function(){
if(!this.iframe){
var d={"name":"GB_frame","class":"GB_frame","frameBorder":0};
this.iframe=AJS.IFRAME(d);
this.middle_cnt=AJS.DIV({"class":"content"},this.iframe);
this.top_cnt=AJS.DIV();
this.bottom_cnt=AJS.DIV();
AJS.ACN(this.g_window,this.top_cnt,this.middle_cnt,this.bottom_cnt);
}
},onHide:function(){
},onShow:function(){
},setFrameSize:function(){
},setWindowPosition:function(){
},initHook:function(){
}});
_GB_update=function(){
if(GB_CURRENT){
GB_CURRENT.update();
}
};
_GB_setOverlayDimension=function(){
if(GB_CURRENT){
GB_CURRENT.setOverlayDimension();
}
};
AJS.preloadImages(GB_ROOT_DIR+"indicator.gif");
script_loaded=true;
var GB_SETS={};
function decoGreyboxLinks(){
var as=AJS.$bytc("a");
AJS.map(as,function(a){
if(a.getAttribute("href")&&a.getAttribute("rel")){
var rel=a.getAttribute("rel");
if(rel.indexOf("gb_")==0){
var _12=rel.match(/\w+/)[0];
var _13=rel.match(/\[(.*)\]/)[1];
var _14=0;
var _15={"caption":a.title||"","url":a.href};
if(_12=="gb_pageset"||_12=="gb_imageset"){
if(!GB_SETS[_13]){
GB_SETS[_13]=[];
}
GB_SETS[_13].push(_15);
_14=GB_SETS[_13].length;
}
if(_12=="gb_pageset"){
a.onclick=function(){
GB_showFullScreenSet(GB_SETS[_13],_14);
return false;
};
}
if(_12=="gb_imageset"){
a.onclick=function(){
GB_showImageSet(GB_SETS[_13],_14);
return false;
};
}
if(_12=="gb_image"){
a.onclick=function(){
GB_showImage(_15.caption,_15.url);
return false;
};
}
if(_12=="gb_page"){
a.onclick=function(){
var sp=_13.split(/, ?/);
GB_show(_15.caption,_15.url,parseInt(sp[1]),parseInt(sp[0]));
return false;
};
}
if(_12=="gb_page_fs"){
a.onclick=function(){
GB_showFullScreen(_15.caption,_15.url);
return false;
};
}
if(_12=="gb_page_center"){
a.onclick=function(){
var sp=_13.split(/, ?/);
GB_showCenter(_15.caption,_15.url,parseInt(sp[1]),parseInt(sp[0]));
return false;
};
}
}
}
});
}
AJS.AEV(window,"load",decoGreyboxLinks);
GB_showImage=function(_18,url,_1a){
var _1b={width:300,height:300,type:"image",fullscreen:false,center_win:true,caption:_18,callback_fn:_1a};
var win=new GB_Gallery(_1b);
return win.show(url);
};
GB_showPage=function(_1d,url,_1f){
var _20={type:"page",caption:_1d,callback_fn:_1f,fullscreen:true,center_win:false};
var win=new GB_Gallery(_20);
return win.show(url);
};
GB_Gallery=GreyBox.extend({init:function(_22){
this.parent({});
this.img_close=this.root_dir+"g_close.gif";
AJS.update(this,_22);
this.addCallback(this.callback_fn);
},initHook:function(){
AJS.addClass(this.g_window,"GB_Gallery");
var _23=AJS.DIV({"class":"inner"});
this.header=AJS.DIV({"class":"GB_header"},_23);
AJS.setOpacity(this.header,0);
AJS.getBody().insertBefore(this.header,this.overlay.nextSibling);
var _24=AJS.TD({"id":"GB_caption","class":"caption","width":"40%"},this.caption);
var _25=AJS.TD({"id":"GB_middle","class":"middle","width":"20%"});
var _26=AJS.IMG({"src":this.img_close});
AJS.AEV(_26,"click",GB_hide);
var _27=AJS.TD({"class":"close","width":"40%"},_26);
var _28=AJS.TBODY(AJS.TR(_24,_25,_27));
var _29=AJS.TABLE({"cellspacing":"0","cellpadding":0,"border":0},_28);
AJS.ACN(_23,_29);
if(this.fullscreen){
AJS.AEV(window,"scroll",AJS.$b(this.setWindowPosition,this));
}else{
AJS.AEV(window,"scroll",AJS.$b(this._setHeaderPos,this));
}
},setFrameSize:function(){
var _2a=this.overlay.offsetWidth;
var _2b=AJS.getWindowSize();
if(this.fullscreen){
this.width=_2a-40;
this.height=_2b.h-80;
}
AJS.setWidth(this.iframe,this.width);
AJS.setHeight(this.iframe,this.height);
AJS.setWidth(this.header,_2a);
},_setHeaderPos:function(){
AJS.setTop(this.header,AJS.getScrollTop()+10);
},setWindowPosition:function(){
var _2c=this.overlay.offsetWidth;
var _2d=AJS.getWindowSize();
AJS.setLeft(this.g_window,((_2c-50-this.width)/2));
if(!this.center_win){
AJS.setTop(this.g_window,AJS.getScrollTop()+55);
}else{
var fl=((_2d.h-this.height)/2)-20+AJS.getScrollTop();
if(fl<0){
fl=0;
}
AJS.setTop(this.g_window,fl);
}
this._setHeaderPos();
},onHide:function(){
AJS.removeElement(this.header);
AJS.removeClass(this.g_window,"GB_Gallery");
},onShow:function(){
if(AJS.fx){
AJS.fx.fadeIn(this.header,{to:1});
}else{
AJS.setOpacity(this.header,1);
}
}});
AJS.preloadImages(GB_ROOT_DIR+"g_close.gif");
GB_showFullScreenSet=function(set,_30,_31){
var _32={type:"page",fullscreen:true,center_win:false};
var _33=new GB_Sets(_32,set);
_33.addCallback(_31);
_33.showSet(_30-1);
return false;
};
GB_showImageSet=function(set,_35,_36){
var _37={type:"image",fullscreen:false,center_win:true,width:300,height:300};
var _38=new GB_Sets(_37,set);
_38.addCallback(_36);
_38.showSet(_35-1);
return false;
};
GB_Sets=GB_Gallery.extend({init:function(_39,set){
this.parent(_39);
if(!this.img_next){
this.img_next=this.root_dir+"next.gif";
}
if(!this.img_prev){
this.img_prev=this.root_dir+"prev.gif";
}
this.current_set=set;
},showSet:function(_3b){
this.current_index=_3b;
var _3c=this.current_set[this.current_index];
this.show(_3c.url);
this._setCaption(_3c.caption);
this.btn_prev=AJS.IMG({"class":"left",src:this.img_prev});
this.btn_next=AJS.IMG({"class":"right",src:this.img_next});
AJS.AEV(this.btn_prev,"click",AJS.$b(this.switchPrev,this));
AJS.AEV(this.btn_next,"click",AJS.$b(this.switchNext,this));
GB_STATUS=AJS.SPAN({"class":"GB_navStatus"});
AJS.ACN(AJS.$("GB_middle"),this.btn_prev,GB_STATUS,this.btn_next);
this.updateStatus();
},updateStatus:function(){
AJS.setHTML(GB_STATUS,(this.current_index+1)+" / "+this.current_set.length);
if(this.current_index==0){
AJS.addClass(this.btn_prev,"disabled");
}else{
AJS.removeClass(this.btn_prev,"disabled");
}
if(this.current_index==this.current_set.length-1){
AJS.addClass(this.btn_next,"disabled");
}else{
AJS.removeClass(this.btn_next,"disabled");
}
},_setCaption:function(_3d){
AJS.setHTML(AJS.$("GB_caption"),_3d);
},updateFrame:function(){
var _3e=this.current_set[this.current_index];
this._setCaption(_3e.caption);
this.url=_3e.url;
this.startLoading();
},switchPrev:function(){
if(this.current_index!=0){
this.current_index--;
this.updateFrame();
this.updateStatus();
}
},switchNext:function(){
if(this.current_index!=this.current_set.length-1){
this.current_index++;
this.updateFrame();
this.updateStatus();
}
}});
AJS.AEV(window,"load",function(){
AJS.preloadImages(GB_ROOT_DIR+"next.gif",GB_ROOT_DIR+"prev.gif");
});
GB_show=function(_3f,url,_41,_42,_43){
var _44={caption:_3f,height:_41||500,width:_42||500,fullscreen:false,callback_fn:_43};
var win=new GB_Window(_44);
return win.show(url);
};
GB_showCenter=function(_46,url,_48,_49,_4a){
var _4b={caption:_46,center_win:true,height:_48||500,width:_49||500,fullscreen:false,callback_fn:_4a};
var win=new GB_Window(_4b);
return win.show(url);
};
GB_showFullScreen=function(_4d,url,_4f){
var _50={caption:_4d,fullscreen:true,callback_fn:_4f};
var win=new GB_Window(_50);
return win.show(url);
};
GB_Window=GreyBox.extend({init:function(_52){
this.parent({});
this.img_header=this.root_dir+"header_bg.gif";
this.img_close=this.root_dir+"w_close.gif";
this.show_close_img=true;
AJS.update(this,_52);
this.addCallback(this.callback_fn);
},initHook:function(){
AJS.addClass(this.g_window,"GB_Window");
this.header=AJS.TABLE({"class":"header"});
this.header.style.backgroundImage="url("+this.img_header+")";
var _53=AJS.TD({"class":"caption"},this.caption);
var _54=AJS.TD({"class":"close"});
if(this.show_close_img){
var _55=AJS.IMG({"src":this.img_close});
var _56=AJS.SPAN("Close");
var btn=AJS.DIV(_55,_56);
AJS.AEV([_55,_56],"mouseover",function(){
AJS.addClass(_56,"on");
});
AJS.AEV([_55,_56],"mouseout",function(){
AJS.removeClass(_56,"on");
});
AJS.AEV([_55,_56],"mousedown",function(){
AJS.addClass(_56,"click");
});
AJS.AEV([_55,_56],"mouseup",function(){
AJS.removeClass(_56,"click");
});
AJS.AEV([_55,_56],"click",GB_hide);
AJS.ACN(_54,btn);
}
tbody_header=AJS.TBODY();
AJS.ACN(tbody_header,AJS.TR(_53,_54));
AJS.ACN(this.header,tbody_header);
AJS.ACN(this.top_cnt,this.header);
AJS.AEV(window,"scroll",AJS.$b(this.setWindowPosition,this));
},setFrameSize:function(){
if(this.fullscreen){
var _58=AJS.getWindowSize();
overlay_h=_58.h;
this.width=Math.round(this.overlay.offsetWidth-(this.overlay.offsetWidth/100)*10);
this.height=Math.round(overlay_h-(overlay_h/100)*10);
}
AJS.setWidth(this.header,this.width+6);
AJS.setWidth(this.iframe,this.width);
AJS.setHeight(this.iframe,this.height);
},setWindowPosition:function(){
var _59=AJS.getWindowSize();
AJS.setLeft(this.g_window,((_59.w-this.width)/2)-13);
if(!this.center_win){
AJS.setTop(this.g_window,AJS.getScrollTop());
}else{
var fl=((_59.h-this.height)/2)-20+AJS.getScrollTop();
if(fl<0){
fl=0;
}
AJS.setTop(this.g_window,fl);
}
}});
AJS.preloadImages(GB_ROOT_DIR+"w_close.gif",GB_ROOT_DIR+"header_bg.gif");

