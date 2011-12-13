
var liveCommentReq=false;var liveCommentLast="";var liveCommentIsIE=false;var liveCommentWarn=false;var lc_t=false;function lc_addLoadEvent(func){var oldonload=window.onload;if(typeof window.onload!='function'){window.onload=func;}else{window.onload=function(){oldonload();func();}}}
function liveAttach(tel,myevent,liveCommentKeyPress){if(navigator.userAgent.indexOf("Safari")>0){tel.addEventListener(myevent,liveCommentKeyPress,false);}else if(navigator.product=="Gecko"){tel.addEventListener(myevent,liveCommentKeyPress,false);}else{tel.attachEvent('on'+myevent,liveCommentKeyPress);liveCommentIsIE=true;}}
function liveCommentInit(){if(!document.getElementById('serendipity_replyTo')){return false;}
if(window.XMLHttpRequest){liveCommentReq=new XMLHttpRequest();}
myevent='keyup';tel=document.getElementById('serendipity_replyTo');pel=document.getElementById('serendipity_preview');liveAttach(tel,myevent,liveCommentKeyPress);liveAttach(pel,'click',liveCommentPreview);tel.style.color='green';liveCommentStart();}
function liveCommentPreview(event){if(!liveCommentIsIE){event.preventDefault();}
liveCommentDoSearch();return false;}
function liveGetSource(){rid=document.getElementById('serendipity_replyTo').value;if(rid==0||liveCommentWarn){return false;}
sourceel=document.getElementById('serendipityCommentForm');if(!sourceel){sourceel=document.getElementById('serendipity_comment_CommentForm');}
if(!sourceel&&!liveCommentWarn){alert('This template does not have #serendipityCommentForm. Live Comment Previewing disabled.');liveCommentWarn=true;return false;}
return sourceel;}
function liveCommentKeyPress(event){sourceel=liveGetSource();if(!sourceel)return false;fields=sourceel.cloneNode(true);sourceel.id='serendipityCommentFormOld';store_text=document.getElementById('serendipity_commentform_comment').value;store_replyTo=document.getElementById('serendipity_replyTo').value;liveAttach(fields,'click',liveCommentPreview);iNode=document.getElementById('serendipity_replyform_'+rid);iNode.parentNode.appendChild(fields);pNode=sourceel.parentNode;pNode.removeChild(sourceel);document.getElementById('serendipity_commentform_comment').value=store_text;document.getElementById('serendipity_replyTo').value=store_replyTo;return true;}
function liveCommentStart(){if(lc_t){window.clearTimeout(lc_t);}
lc_t=window.setTimeout("liveCommentDoSearch()",200);}
function liveCommentDoSearch(){if(liveCommentLast==document.getElementById('serendipity_commentform_comment').value){liveCommentStart();return true;}
if(liveCommentReq&&liveCommentReq.readyState<4){liveCommentReq.abort();}
if(window.XMLHttpRequest){}else if(window.ActiveXObject){liveCommentReq=new ActiveXObject("Microsoft.XMLHTTP");}
liveCommentReq.onreadystatechange=liveCommentProcessReqChange;liveCommentReq.open("POST",lcbase);liveCommentReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset='+lcchar);liveCommentReq.send('data='+document.getElementById('serendipity_commentform_comment').value);liveCommentLast=document.getElementById('serendipity_commentform_comment').value;}
function liveCommentProcessReqChange(){if(liveCommentReq.readyState==4){rid=document.getElementById('serendipity_replyTo').value;if(rid<1){rid=0;}
var res=document.getElementById("serendipity_replyform_"+rid);if(!res){sourceel=document.getElementById('serendipityCommentForm');if(!sourceel){sourceel=document.getElementById('serendipity_comment_CommentForm');}
if(!sourceel)return false;oldFeed=document.getElementById('serendipityPreviewFeedback');if(oldFeed){poldFeed=oldFeed.parentNode;poldFeed.removeChild(oldFeed);}
res=sourceel.cloneNode(true);res.id='serendipityPreviewFeedback';res.innerHTML='';sourceel.parentNode.insertBefore(res,sourceel);}
res.innerHTML=liveCommentReq.responseText;liveCommentStart();}}
lc_addLoadEvent(liveCommentInit);
