var inputCaptcha = document.getElementById("bee_captcha");

function fetch_captcha_answer() {
    if (window.XMLHttpRequest) { // Mozilla, Safari, Opera, IE7
        httpRequest = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // IE6, IE5
        httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
    httpRequest.onreadystatechange = function() {
    	fetch_answer_ready(httpRequest);
    }
    httpRequest.open('POST', spambee_fcap, true); // spambee_fcap was set earlier.
    httpRequest.setRequestHeader('content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    httpRequest.send("test"); // Start request
}

function fetch_answer_ready(httpRequest){
	//alert(httpRequest.readyState);
    if (httpRequest!=null && httpRequest.readyState == 4 && httpRequest.status == 200) {
    	//alert("H1, ic=" + inputCaptcha + " r=" + httpRequest.responseText);
        if (inputCaptcha==null) return;
        var response = httpRequest.responseText;
        var jsonResponse = eval('(' + response + ')');
        var answer = jsonResponse.answer;
        if ("ERROR" != answer) {
            inputCaptcha.value = answer;
        	divCaptcha = document.getElementById('serendipity_comment_beecaptcha');
            if (divCaptcha!=null) hideBeeElement(divCaptcha);
        }
    }
}

function hideBeeElement(element) {
	var elementClass = element.getAttribute("class");
	elementClass = elementClass.replace( /(?:^|\s)spambeehidden(?!\S)/ , '' );
	element.setAttribute("class", elementClass + ' spambeehidden');
}

// initialise on page loaded events
function addLoadEvent(func) {
	  var oldonload = window.onload;
	  if (typeof window.onload != 'function') {
	    window.onload = func;
	  } else {
	    window.onload = function() {
	      if (oldonload) {
	        oldonload();
	      }
	      func();
	    }
	  }
	}
addLoadEvent(fetch_captcha_answer);
