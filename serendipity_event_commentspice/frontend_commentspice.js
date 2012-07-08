var inputCommentEmail = document.getElementById("serendipity_commentform_email");
var inputCommentUrl = document.getElementById("serendipity_commentform_url");
var inputCommentText = document.getElementById("serendipity_commentform_comment");
var submitPreview = document.getElementById("serendipity_preview");
var form = document.getElementById("serendipity_comment");
var divSelectRss = document.getElementById("serendipity_commentspice_rss");

var lastUrlChecked = null;
var lastEmailChecked = null;

function fetch_rss() {
	var url = inputCommentUrl.value;
	if(!url.match(/^http/)) {
		var divSelectRss = document.getElementById("serendipity_commentspice_rss");
		hideSpiceElement(divSelectRss);
		//divSelectRss.style.display='none';
		lastUrlChecked = null;
		return;
	}
	var email = inputCommentEmail.value;
	if (url == lastUrlChecked && email == lastEmailChecked) return;
	var divSelectRss = document.getElementById("serendipity_commentspice_rss");
	
    if (window.XMLHttpRequest) { // Mozilla, Safari, Opera, IE7
        httpRequest = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // IE6, IE5
        httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
    httpRequest.onreadystatechange = function() {
    	fetch_rss_ready(httpRequest);
    }
    // Method, url, Async = true / Sync = false
    httpRequest.open('POST', comentspice_fetchrss, true); // comentspice_fetchrss was set earlier.
    httpRequest.setRequestHeader('content-Type', 'application/x-www-form-urlencoded; charset='+s9yCharset);
    httpRequest.send('coment_url='+url+'&coment_email='+email + '&entryid=' + comentspice_entryid); // Start request
}

function fetch_rss_ready(httpRequest){
    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        var response = httpRequest.responseText;
        var jsonResponse = eval('(' + response + ')');
        var divSelectRss = document.getElementById("serendipity_commentspice_rss");
        var selectRss = document.getElementById("serendipity_commentform_rss");
        if (selectRss==null) return;
        var divDescription = document.getElementById("serendipity_commentspice_rss_desc");
        var articles = jsonResponse.articles;
        if (!comentspice_fetchrss_emailchanges && lastUrlChecked == jsonResponse.url) {
        	// nothing to do
            lastEmailChecked = jsonResponse.email;
        	return;
        }
        selectRss.options.length = 0;
        if (articles==null || articles.length==0) {
        	hideSpiceElement(divSelectRss);
        	if (divDescription!=null) hideSpiceElement(divDescription);
        }
        else {
	        for (idx in articles) {
	        	var article = articles[idx];
				var option = document.createElement('option');
				option.text = article.title;
				option.value = article.url;
				try {
					selectRss.add(option, null); // standards compliant; doesn't work in IE
				}
				catch(ex) {
					selectRss.add(option); // IE only
				}
	        }
	        selectRss.selectedIndex = 0;
	        showSpiceElement(divSelectRss);
        	if (divDescription!=null) showSpiceElement(divDescription);
	        reloadSelection();
        }
        lastUrlChecked = jsonResponse.url;
        lastEmailChecked = jsonResponse.email;
    }
}

function showSpiceElement(element) {
	var elementClass = element.getAttribute("class");
	elementClass = elementClass.replace( /(?:^|\s)spicehidden(?!\S)/ , '' ).replace( /(?:^|\s)spicerevealed(?!\S)/ , '' );
	element.setAttribute("class", elementClass + ' spicerevealed');
}
function hideSpiceElement(element) {
	var elementClass = element.getAttribute("class");
	elementClass = elementClass.replace( /(?:^|\s)spicehidden(?!\S)/ , '' ).replace( /(?:^|\s)spicerevealed(?!\S)/ , '' );
	element.setAttribute("class", elementClass + ' spicehidden');
}

function createCookie(name,value) {
	var date = new Date();
	date.setTime(date.getTime()+(60*60*1000)); // save 1h 
	var expires = "; expires="+date.toGMTString();
	document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	var value = '';
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) {
			value = c.substring(nameEQ.length,c.length); // Let last one return.
		}
	}
	return value;
}

function eraseCookie(name) {
	var date = new Date();
	date.setTime(date.getTime()-1);  
	var expires = "; expires="+date.toGMTString();
	document.cookie = name+"="+value+expires+"; path=/";
}


function rememberSelection() {
	var selectRss = document.getElementById("serendipity_commentform_rss");
	if (selectRss!=null) {
		createCookie("commentspice[promo]",selectRss.selectedIndex);
	}
	var inputBoo = document.getElementById("serendipity_commentform_boo");
	if (inputBoo!=null) {
		createCookie("commentspice[boo]",inputBoo.value);
	}
	var inputTwitter = document.getElementById("serendipity_commentform_twitter");
	if (inputTwitter!=null) {
		createCookie("commentspice[twitter]",inputTwitter.value);
	}
	return true;
}
function reloadSelection() {
	// reload former inputs on preview / message mode only
	if ('#feedback' != window.location.hash) return;
	var selectRss = document.getElementById("serendipity_commentform_rss");
	if (selectRss!=null) {
		cookieval = getCookie("commentspice[promo]");
		if (cookieval!='') {
			selectRss.selectedIndex = cookieval;
		}
	}
	var inputBoo = document.getElementById("serendipity_commentform_boo");
	if (inputBoo!=null) {
		cookieval = getCookie("commentspice[boo]");
		if (cookieval!='') {
			inputBoo.value = cookieval;
		}
	}
	var inputTwitter = document.getElementById("serendipity_commentform_twitter");
	if (inputTwitter!=null) {
		cookieval = getCookie("commentspice[twitter]");
		if (cookieval!='') {
			inputTwitter.value = cookieval;
		}
	}
}
function forgetSelection() {
	eraseCookie("commentspice[promo]");
	eraseCookie("commentspice[boo]");
	eraseCookie("commentspice[twitter]");
	return true;
}


inputCommentEmail.onblur = fetch_rss;
inputCommentUrl.onblur = fetch_rss;
inputCommentText.onfocus = fetch_rss;
submitPreview.onclick = rememberSelection;
form.onsubmit= rememberSelection;
fetch_rss();
