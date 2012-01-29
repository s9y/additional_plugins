var inputCommentEmail = document.getElementById("serendipity_commentform_email");
var inputCommentUrl = document.getElementById("serendipity_commentform_url");
var inputCommentText = document.getElementById("serendipity_commentform_comment");

var lastUrlChecked = null;
var lastEmailChecked = null;

function fetch_rss() {
	var url = inputCommentUrl.value;
	if(!url.match(/^http/)) {
		var divSelectRss = document.getElementById("serendipity_commentspice_rss");
		divSelectRss.style.display='none';
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
    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        var response = httpRequest.responseText;
        var jsonResponse = eval('(' + response + ')');
        var divSelectRss = document.getElementById("serendipity_commentspice_rss");
        var selectRss = document.getElementById("serendipity_commentform_rss");
        if (selectRss==null) return;
        var articles = jsonResponse.articles;
        if (!comentspice_fetchrss_emailchanges && lastUrlChecked == jsonResponse.url) {
        	// nothing to do
            lastEmailChecked = jsonResponse.email;
        	return;
        }
        selectRss.options.length = 0;
        if (articles.length==0) {
            divSelectRss.style.display='none';
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
	        divSelectRss.style.display='';
        }
        lastUrlChecked = jsonResponse.url;
        lastEmailChecked = jsonResponse.email;
    }
}

// Intialisation
inputCommentEmail.onblur = fetch_rss;
inputCommentUrl.onblur = fetch_rss;
inputCommentText.onfocus = fetch_rss;
fetch_rss();