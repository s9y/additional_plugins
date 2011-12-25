AJS={BASE_URL:"",drag_obj:null,drag_elm:null,_drop_zones:[],_cur_pos:null,setTop:function(){
var _1=AJS.flattenList(arguments);
var t=_1.pop();
AJS.map(_1,function(_3){
_3.style.top=AJS.getCssDim(t);
});
},getScrollTop:function(){
var t;
if(document.documentElement&&document.documentElement.scrollTop){
t=document.documentElement.scrollTop;
}else{
if(document.body){
t=document.body.scrollTop;
}
}
return t;
},_getRealScope:function(fn,_6,_7,_8){
var _9=window;
_6=AJS.$A(_6);
if(fn._cscope){
_9=fn._cscope;
}
return function(){
var _a=[];
var i=0;
if(_7){
i=1;
}
AJS.map(arguments,function(_c){
_a.push(_c);
},i);
_a=_a.concat(_6);
if(_8){
_a=_a.reverse();
}
return fn.apply(_9,_a);
};
},setHTML:function(_d,_e){
_d.innerHTML=_e;
return _d;
},preloadImages:function(){
AJS.AEV(window,"load",AJS.$p(function(_f){
AJS.map(_f,function(src){
var pic=new Image();
pic.src=src;
});
},arguments));
},_createDomShortcuts:function(){
var _12=["ul","li","td","tr","th","tbody","table","input","span","b","a","div","img","button","h1","h2","h3","br","textarea","form","p","select","option","iframe","script","center","dl","dt","dd","small","pre"];
var _13=function(elm){
var _15="return AJS.createDOM.apply(null, ['"+elm+"', arguments]);";
var _16="function() { "+_15+"    }";
eval("AJS."+elm.toUpperCase()+"="+_16);
};
AJS.map(_12,_13);
AJS.TN=function(_17){
return document.createTextNode(_17);
};
},setHeight:function(){
var _18=AJS.flattenList(arguments);
var h=_18.pop();
AJS.map(_18,function(elm){
elm.style.height=AJS.getCssDim(h);
});
},getWindowSize:function(doc){
doc=doc||document;
var _1c,_1d;
if(self.innerHeight){
_1c=self.innerWidth;
_1d=self.innerHeight;
}else{
if(doc.documentElement&&doc.documentElement.clientHeight){
_1c=doc.documentElement.clientWidth;
_1d=doc.documentElement.clientHeight;
}else{
if(doc.body){
_1c=doc.body.clientWidth;
_1d=doc.body.clientHeight;
}
}
}
return {"w":_1c,"h":_1d};
},removeClass:function(){
var _1e=AJS.flattenList(arguments);
var cls=_1e.pop();
var _20=function(o){
o.className=o.className.replace(new RegExp("\\s?"+cls),"");
};
AJS.map(_1e,function(elm){
_20(elm);
});
},bindMethods:function(_23){
for(var k in _23){
var _25=_23[k];
if(typeof (_25)=="function"){
_23[k]=AJS.$b(_25,_23);
}
}
},_unloadListeners:function(){
if(AJS.listeners){
AJS.map(AJS.listeners,function(elm,_27,fn){
AJS.REV(elm,_27,fn);
});
}
AJS.listeners=[];
},partial:function(fn){
var _2a=AJS.forceArray(arguments);
return AJS.$b(fn,null,_2a.slice(1,_2a.length).reverse(),false,true);
},getIndex:function(elm,_2c,_2d){
for(var i=0;i<_2c.length;i++){
if(_2d&&_2d(_2c[i])||elm==_2c[i]){
return i;
}
}
return -1;
},isDefined:function(o){
return (o!="undefined"&&o!=null);
},isArray:function(obj){
return obj instanceof Array;
},appendChildNodes:function(elm){
if(arguments.length>=2){
AJS.map(arguments,function(n){
if(AJS.isString(n)){
n=AJS.TN(n);
}
if(AJS.isDefined(n)){
elm.appendChild(n);
}
},1);
}
return elm;
},isOpera:function(){
return (navigator.userAgent.toLowerCase().indexOf("opera")!=-1);
},isString:function(obj){
return (typeof obj=="string");
},setOpacity:function(elm,p){
elm.style.opacity=p;
elm.style.filter="alpha(opacity="+p*100+")";
},createArray:function(v){
if(AJS.isArray(v)&&!AJS.isString(v)){
return v;
}else{
if(!v){
return [];
}else{
return [v];
}
}
},swapDOM:function(_37,src){
_37=AJS.getElement(_37);
var _39=_37.parentNode;
if(src){
src=AJS.getElement(src);
_39.replaceChild(src,_37);
}else{
_39.removeChild(_37);
}
return src;
},isMozilla:function(){
return (navigator.userAgent.toLowerCase().indexOf("gecko")!=-1&&navigator.productSub>=20030210);
},setLeft:function(){
var _3a=AJS.flattenList(arguments);
var l=_3a.pop();
AJS.map(_3a,function(elm){
elm.style.left=AJS.getCssDim(l);
});
},_listenOnce:function(elm,_3e,fn){
var _40=function(){
AJS.removeEventListener(elm,_3e,_40);
fn(arguments);
};
return _40;
},createDOM:function(_41,_42){
var i=0,_44;
elm=document.createElement(_41);
if(AJS.isDict(_42[i])){
for(k in _42[0]){
_44=_42[0][k];
if(k=="style"){
elm.style.cssText=_44;
}else{
if(k=="class"||k=="className"){
elm.className=_44;
}else{
elm.setAttribute(k,_44);
}
}
}
i++;
}
if(_42[0]==null){
i=1;
}
AJS.map(_42,function(n){
if(n){
if(AJS.isString(n)||AJS.isNumber(n)){
n=AJS.TN(n);
}
elm.appendChild(n);
}
},i);
return elm;
},getElementsByTagAndClassName:function(_46,_47,_48){
var _49=[];
if(!AJS.isDefined(_48)){
_48=document;
}
if(!AJS.isDefined(_46)){
_46="*";
}
var els=_48.getElementsByTagName(_46);
var _4b=els.length;
var _4c=new RegExp("(^|\\s)"+_47+"(\\s|$)");
for(i=0,j=0;i<_4b;i++){
if(_4c.test(els[i].className)||_47==null){
_49[j]=els[i];
j++;
}
}
return _49;
},flattenList:function(_4d){
var r=[];
var _4f=function(r,l){
AJS.map(l,function(o){
if(AJS.isArray(o)){
_4f(r,o);
}else{
r.push(o);
}
});
};
_4f(r,_4d);
return r;
},addEventListener:function(elm,_54,fn,_56,_57){
if(!_57){
_57=false;
}
var _58=AJS.$A(elm);
AJS.map(_58,function(_59){
if(_56){
fn=AJS._listenOnce(_59,_54,fn);
}
if(AJS.isIn(_54,["submit","load","scroll","resize"])){
var old=elm["on"+_54];
elm["on"+_54]=function(){
if(old){
fn(arguments);
return old(arguments);
}else{
return fn(arguments);
}
};
return;
}
if(AJS.isIn(_54,["keypress","keydown","keyup"])){
var _5b=fn;
fn=function(e){
e.key=e.keyCode?e.keyCode:e.charCode;
switch(e.key){
case 63232:
e.key=38;
break;
case 63233:
e.key=40;
break;
case 63235:
e.key=39;
break;
case 63234:
e.key=37;
break;
}
return _5b.apply(null,arguments);
};
}
if(_59.attachEvent){
_59.attachEvent("on"+_54,fn);
}else{
if(_59.addEventListener){
_59.addEventListener(_54,fn,_57);
}
}
AJS.listeners=AJS.$A(AJS.listeners);
AJS.listeners.push([_59,_54,fn]);
});
},isNumber:function(obj){
return (typeof obj=="number");
},isIe:function(){
return (navigator.userAgent.toLowerCase().indexOf("msie")!=-1&&navigator.userAgent.toLowerCase().indexOf("opera")==-1);
},showElement:function(){
var _5e=AJS.flattenList(arguments);
AJS.map(_5e,function(elm){
elm.style.display="";
});
},map:function(_60,fn,_62,_63){
var i=0,l=_60.length;
if(_62){
i=_62;
}
if(_63){
l=_63;
}
for(i;i<l;i++){
fn.apply(null,[_60[i],i]);
}
},removeEventListener:function(elm,_67,fn,_69){
if(!_69){
_69=false;
}
if(elm.removeEventListener){
elm.removeEventListener(_67,fn,_69);
if(AJS.isOpera()){
elm.removeEventListener(_67,fn,!_69);
}
}else{
if(elm.detachEvent){
elm.detachEvent("on"+_67,fn);
}
}
},getCssDim:function(dim){
if(AJS.isString(dim)){
return dim;
}else{
return dim+"px";
}
},hideElement:function(elm){
var _6c=AJS.flattenList(arguments);
AJS.map(_6c,function(elm){
elm.style.display="none";
});
},bind:function(fn,_6f,_70,_71,_72){
fn._cscope=_6f;
return AJS._getRealScope(fn,_70,_71,_72);
},forceArray:function(_73){
var r=[];
AJS.map(_73,function(elm){
r.push(elm);
});
return r;
},update:function(l1,l2){
for(var i in l2){
l1[i]=l2[i];
}
return l1;
},getBody:function(){
return AJS.$bytc("body")[0];
},addClass:function(){
var _79=AJS.flattenList(arguments);
var cls=_79.pop();
var _7b=function(o){
if(!new RegExp("(^|\\s)"+cls+"(\\s|$)").test(o.className)){
o.className+=(o.className?" ":"")+cls;
}
};
AJS.map(_79,function(elm){
_7b(elm);
});
},getElement:function(id){
if(AJS.isString(id)||AJS.isNumber(id)){
return document.getElementById(id);
}else{
return id;
}
},setWidth:function(){
var _7f=AJS.flattenList(arguments);
var w=_7f.pop();
AJS.map(_7f,function(elm){
elm.style.width=AJS.getCssDim(w);
});
},removeElement:function(){
var _82=AJS.flattenList(arguments);
AJS.map(_82,function(elm){
AJS.swapDOM(elm,null);
});
},isDict:function(o){
var _85=String(o);
return _85.indexOf(" Object")!=-1;
},isIn:function(elm,_87){
var i=AJS.getIndex(elm,_87);
if(i!=-1){
return true;
}else{
return false;
}
}};
AJS.$=AJS.getElement;
AJS.$$=AJS.getElements;
AJS.$f=AJS.getFormElement;
AJS.$p=AJS.partial;
AJS.$b=AJS.bind;
AJS.$A=AJS.createArray;
AJS.DI=AJS.documentInsert;
AJS.ACN=AJS.appendChildNodes;
AJS.RCN=AJS.replaceChildNodes;
AJS.AEV=AJS.addEventListener;
AJS.REV=AJS.removeEventListener;
AJS.$bytc=AJS.getElementsByTagAndClassName;
AJS.addEventListener(window,"unload",AJS._unloadListeners);
AJS._createDomShortcuts();
AJS.Class=function(_89){
var fn=function(){
if(arguments[0]!="no_init"){
return this.init.apply(this,arguments);
}
};
fn.prototype=_89;
AJS.update(fn,AJS.Class.prototype);
return fn;
};
AJS.Class.prototype={extend:function(_8b){
var _8c=new this("no_init");
for(k in _8b){
var _8d=_8c[k];
var cur=_8b[k];
if(_8d&&_8d!=cur&&typeof cur=="function"){
cur=this._parentize(cur,_8d);
}
_8c[k]=cur;
}
return new AJS.Class(_8c);
},implement:function(_8f){
AJS.update(this.prototype,_8f);
},_parentize:function(cur,_91){
return function(){
this.parent=_91;
return cur.apply(this,arguments);
};
}};
AJS.$=AJS.getElement;
AJS.$$=AJS.getElements;
AJS.$f=AJS.getFormElement;
AJS.$b=AJS.bind;
AJS.$p=AJS.partial;
AJS.$A=AJS.createArray;
AJS.DI=AJS.documentInsert;
AJS.ACN=AJS.appendChildNodes;
AJS.RCN=AJS.replaceChildNodes;
AJS.AEV=AJS.addEventListener;
AJS.REV=AJS.removeEventListener;
AJS.$bytc=AJS.getElementsByTagAndClassName;
AJSDeferred=function(req){
this.callbacks=[];
this.errbacks=[];
this.req=req;
};
AJSDeferred.prototype={excCallbackSeq:function(req,_94){
var _95=req.responseText;
while(_94.length>0){
var fn=_94.pop();
var _97=fn(_95,req);
if(_97){
_95=_97;
}
}
},callback:function(){
this.excCallbackSeq(this.req,this.callbacks);
},errback:function(){
if(this.errbacks.length==0){
alert("Error encountered:\n"+this.req.responseText);
}
this.excCallbackSeq(this.req,this.errbacks);
},addErrback:function(fn){
this.errbacks.unshift(fn);
},addCallback:function(fn){
this.callbacks.unshift(fn);
},addCallbacks:function(fn1,fn2){
this.addCallback(fn1);
this.addErrback(fn2);
},sendReq:function(_9c){
if(AJS.isObject(_9c)){
this.req.send(AJS.queryArguments(_9c));
}else{
if(AJS.isDefined(_9c)){
this.req.send(_9c);
}else{
this.req.send("");
}
}
}};
script_loaded=true;


script_loaded=true;