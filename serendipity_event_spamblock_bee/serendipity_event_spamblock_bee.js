(function() {
    function SpamBeeCaptcha(loadData) {
        var that         = this;
        var inputCaptcha = document.getElementById("bee_captcha");
        var divCaptcha   = document.getElementById('serendipity_comment_beecaptcha');
        var method       = loadData.method        == 'json'      ? loadData.method : 'default';
        var url          = typeof loadData.url    != 'undefined' ? loadData.url    : null;
        var answer       = typeof loadData.answer != 'undefined' ? loadData.answer : null;
        
        this.attachToLoadEvent = function() {
            var handlerCalled = false;
            var eventHandler = function() {
                // Since we use multiple handlers, only run this function once
                if (handlerCalled) return;
                handlerCalled = true;
                
                that.fillCaptcha();
                
                // We don't need any additional load events anymore
                if (document.addEventListener) {
                    document.removeEventListener('load', eventHandler, true);
                }
            }
            
            if (document.addEventListener) {
                // Use DOMContentLoaded for modern browsers, load for older ones
                document.addEventListener('DOMContentLoaded', eventHandler, true);
                document.addEventListener('load', eventHandler, true);
            } else if (window.attachEvent) {
                // Internet Exploder
                window.attachEvent('load', eventHandler);
            } else {
                // Very, very old browsers
                var oldOnload = typeof window.onload == 'function' ? window.onload : null;
                window.onload = function() {
                    if (null !== oldOnload) oldOnload();
                    eventHandler();
                }
            }
        }
        
        this.fillCaptcha = function() {
            if ('default' == method && null !== answer) {
                inputCaptcha.value = answer;
                this.hideBeeElement();
                return;
            } else if ('json' == method && null !== url) {
                fetchJsonData();
                return;
            }
        }
        
        this.hideBeeElement = function() {
            var elementClass = divCaptcha.getAttribute('class');
            if (null === elementClass.match(/\bspambeehidden\b/)) {
                divCaptcha.setAttribute('class', elementClass + ' spambeehidden');
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
                    this.hideBeeElement();
                }
            }
        }
    }

    var spamBeeObj = new SpamBeeCaptcha(spamBeeData);
    spamBeeObj.attachToLoadEvent();
})();