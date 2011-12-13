AJS.fx={highlight:function(_1,_2){
var _3=new AJS.fx.Base();
_3.elm=AJS.$(_1);
_3.setOptions(_2);
_3.options.duration=600;
AJS.update(_3,{_shades:{0:"ff",1:"ee",2:"dd",3:"cc",4:"bb",5:"aa",6:"99"},increase:function(){
if(this.now==7){
_1.style.backgroundColor="transparent";
}else{
_1.style.backgroundColor="#ffff"+this._shades[Math.floor(this.now)];
}
}});
return _3.custom(6,0);
},fadeIn:function(_4,_5){
_5=_5||{};
if(!_5.from){
_5.from=0;
}
if(!_5.to){
_5.to=1;
}
return this._fade(_4,_5);
},fadeOut:function(_6,_7){
_7=_7||{};
if(!_7.from){
_7.from=1;
}
if(!_7.to){
_7.to=0;
}
return this._fade(_6,_7);
},_fade:function(_8,_9){
var _a=new AJS.fx.Base();
_a.elm=AJS.$(_8);
_9.transition=AJS.fx.Transitions.linear;
_a.setOptions(_9);
AJS.update(_a,{start:function(){
return this.custom(this.options.from,this.options.to);
},increase:function(){
AJS.setOpacity(this.elm,this.now);
}});
return _a.start();
},setWidth:function(_b,_c){
return this._setDimension(_b,"width",_c).start();
},setHeight:function(_d,_e){
return this._setDimension(_d,"height",_e).start();
},_setDimension:function(_f,dim,_11){
var _12=new AJS.fx.Base();
_12.elm=AJS.$(_f);
_12.setOptions(_11);
_12.elm.style.overflow="hidden";
_12.dimension=dim;
if(dim=="height"){
_12.show_size=_12.elm.scrollHeight;
}else{
_12.show_size=_12.elm.offsetWidth;
}
AJS.update(_12,{_getTo:function(){
if(this.dimension=="height"){
return this.options.to||this.elm.scrollHeight;
}else{
return this.options.to||this.elm.scrollWidth;
}
},start:function(){
if(this.dimension=="height"){
return this.custom(this.elm.offsetHeight,this._getTo());
}else{
return this.custom(this.elm.offsetWidth,this._getTo());
}
},increase:function(){
if(this.dimension=="height"){
AJS.setHeight(this.elm,this.now);
}else{
AJS.setWidth(this.elm,this.now);
}
}});
return _12;
}};
AJS.fx.Base=function(){
AJS.bindMethods(this);
};
AJS.fx.Base.prototype={setOptions:function(_13){
this.options=AJS.update({onStart:function(){
},onComplete:function(){
},transition:AJS.fx.Transitions.sineInOut,duration:500,wait:true,fps:50},_13||{});
},step:function(){
var _14=new Date().getTime();
if(_14<this.time+this.options.duration){
this.cTime=_14-this.time;
this.setNow();
}else{
setTimeout(AJS.$b(this.options.onComplete,this,[this.elm]),10);
this.clearTimer();
this.now=this.to;
}
this.increase();
},setNow:function(){
this.now=this.compute(this.from,this.to);
},compute:function(_15,to){
var _17=to-_15;
return this.options.transition(this.cTime,_15,_17,this.options.duration);
},clearTimer:function(){
clearInterval(this.timer);
this.timer=null;
return this;
},_start:function(_18,to){
if(!this.options.wait){
this.clearTimer();
}
if(this.timer){
return;
}
setTimeout(AJS.$p(this.options.onStart,this.elm),10);
this.from=_18;
this.to=to;
this.time=new Date().getTime();
this.timer=setInterval(this.step,Math.round(1000/this.options.fps));
return this;
},custom:function(_1a,to){
return this._start(_1a,to);
},set:function(to){
this.now=to;
this.increase();
return this;
}};
AJS.fx.Transitions={linear:function(t,b,c,d){
return c*t/d+b;
},sineInOut:function(t,b,c,d){
return -c/2*(Math.cos(Math.PI*t/d)-1)+b;
}};


script_loaded=true;