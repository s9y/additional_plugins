var inputCommentEmail = document.getElementById("serendipity_commentform_email");
var inputCommentUrl = document.getElementById("serendipity_commentform_url");
var inputCommentText = document.getElementById("serendipity_commentform_comment");
var submitPreview = document.getElementById("serendipity_preview");

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
    httpRequest.send('coment_url='+url+'&coment_email='+email); // Start request
}

function fetch_rss_ready(httpRequest){
    var divSelectRss = document.getElementById("serendipity_commentspice_rss");
    
    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        var response = httpRequest.responseText;
        var jsonResponse = eval('(' + response + ')');
        var selectRss = document.getElementById("serendipity_commentform_rss");
        if (selectRss==null) return;
        var articles = jsonResponse.articles;
        if (!comentspice_fetchrss_emailchanges && lastUrlChecked == jsonResponse.url) {
        	// nothing to do
            lastEmailChecked = jsonResponse.email;
        	return;
        }
        selectRss.options.length = 0;
        if (articles==null || articles.length==0) {
        	hideSpiceElement(divSelectRss);
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
	        showSpiceElement(divSelectRss);
	        reloadSelection();
        }
        lastUrlChecked = jsonResponse.url;
        lastEmailChecked = jsonResponse.email;
    }
    else {
    	hideSpiceElement(divSelectRss);
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

function setCookie(c_name,value)
{
	var exdate=new Date();
	var c_value=escape(value);
	document.cookie=c_name + "=" + c_value;
}
function getCookie(c_name)
{
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
{
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}
function rememberSelection() {
	var selectRss = document.getElementById("serendipity_commentform_rss");
	if (selectRss!=null) {
		//alert("save: " + selectRss.value);
		setCookie("commentspice[promo]",selectRss.value);
	}
	return true;
}
function reloadSelection() {
	//alert("Reload");
	var selectRss = document.getElementById("serendipity_commentform_rss");
	if (selectRss!=null) {
		cookieval = getCookie("commentspice[promo]");
		if (cookieval!='') {
			selectRss.value = cookieval;
			//setCookie("promotevalue",'');
		}
	}
}

// Intialisation
inputCommentEmail.onblur = fetch_rss;
inputCommentUrl.onblur = fetch_rss;
inputCommentText.onfocus = fetch_rss;
submitPreview.onclick = rememberSelection;
fetch_rss();