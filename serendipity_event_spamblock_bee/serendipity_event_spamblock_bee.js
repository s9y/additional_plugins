function SpamBee(loadData) {
    var that         = this;
    var inputCaptcha = document.getElementById("bee_captcha");
    var divCaptcha   = document.getElementById('serendipity_comment_beecaptcha');
    var method       = (loadData.method == 'json')           ? loadData.method : 'default';
    var url          = typeof loadData.url    != 'undefined' ? loadData.url    : null;
    var answer       = typeof loadData.answer != 'undefined' ? loadData.answer : null;
    
    if (typeof window.onload != 'function') {
        window.onload = function() {
            that.fillCaptcha();
        };
    } else {
        var oldonload = window.onload;
        window.onload = function() {
            if (oldonload) {
                oldonload();
            }
            that.fillCaptcha();
        }
    }
    
    this.fillCaptcha = function() {
        if ('default' == method && null !== answer) {
            inputCaptcha.value = answer;
            hideBeeElement();
            return;
        } else if ('json' == method && null !== url) {
            fetchJsonData();
            return;
        }
    }
    
    function fetchJsonData() {
        if (window.XMLHttpRequest) { // Mozilla, Safari, Opera, IE7
            var httpRequest = new XMLHttpRequest();
        } else if (window.ActiveXObject) { // IE6, IE5
            var httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
        }
        httpRequest.onreadystatechange = function() {
            fetchJsonDataReady(httpRequest);
        }
        httpRequest.open('POST', url, true);
        httpRequest.setRequestHeader('content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
        httpRequest.send();
    }

    function fetchJsonDataReady(httpRequest){
        if (null !== httpRequest && 4 == httpRequest.readyState && 200 == httpRequest.status) {
            
            var response     = httpRequest.responseText;
            var jsonResponse = (typeof JSON != 'undefined') ? JSON.parse(response) : eval('(' + response + ')');
            var answer       = jsonResponse.answer;
            
            if (typeof answer != 'string' || 'ERROR' != answer.toUpperCase()) {
                inputCaptcha.value = answer;
                hideBeeElement();
            }
        }
    }

    function hideBeeElement() {
        var elementClass = divCaptcha.getAttribute('class');
        if (null === elementClass.match(/\bspambeehidden\b/)) {
            divCaptcha.setAttribute('class', elementClass + ' spambeehidden');
        }
    }
}

new SpamBee(spamBeeData);