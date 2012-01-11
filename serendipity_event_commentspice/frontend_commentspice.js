var inputComentUrl = document.getElementById("serendipity_commentform_url");
var inputComentText = document.getElementById("serendipity_commentform_comment");

function fetch_rss() {
	var url = inputComentUrl.value;
	if(!url.match(/^http/)) return;
	var divSelectRss = document.getElementById("serendipity_commentspice_rss");
	if (divSelectRss.style.display!='none') return; // allready done
	
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
    httpRequest.send('coment_url='+url); // Start request
}

function fetch_rss_ready(httpRequest){
    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        var response = httpRequest.responseText;
        //alert("response: " + response);
        var jsonResponse = eval('(' + response + ')');
        var divSelectRss = document.getElementById("serendipity_commentspice_rss");
        var selectRss = document.getElementById("serendipity_commentform_rss");
        for (idx in jsonResponse) {
        	var article = jsonResponse[idx];
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
}

// Intialisation
inputComentUrl.onblur = fetch_rss;
inputComentText.onfocus = fetch_rss;
