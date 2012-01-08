var httpRequest;
var lastID;

function ham(id) {
    if (window.XMLHttpRequest) { // Mozilla, Safari, Opera, IE7
        httpRequest = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // IE6, IE5
        httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var copyId = id;
    httpRequest.onreadystatechange = function() {
        setMessage(copyId);
    }
    lastID = id;
    // Method, url, Async = true / Sync = false
    httpRequest.open('POST', learncommentPath, true);
    httpRequest.setRequestHeader('content-Type', 'application/x-www-form-urlencoded; charset='+bayesCharset);
    if (id.constructor == Array) {
        var length = id.length
        for (var i=0;i<length;i++) {
            setLoadIndicator(id[i]);
        }
        id = id.join(';');
    } else {
        setLoadIndicator(id);
    }
    httpRequest.send('id='+id+'&category=ham'); // Start request
}

function spam(id) {
    if (window.XMLHttpRequest) { // Mozilla, Safari, Opera, IE7
        httpRequest = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // IE6, IE5
        httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
    //ids will be changed later on if an array, but we want the array
    var copyId = id;
    httpRequest.onreadystatechange = function() {
        deleteComment(copyId);
    }
    lastID = id;
    httpRequest.open('POST', learncommentPath, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset='+bayesCharset);
    if (id.constructor == Array) {
        var length = id.length
        for (var i=0;i<length;i++) {
            setLoadIndicator(id[i]);
        }
        id = id.join(';');
    } else {
        setLoadIndicator(id);
    }
    httpRequest.send('id='+id+'&category=spam'); // Start request
    
}

function setLoadIndicator(id) {
    var imgElement = document.createElement("img");
    imgElement.src=bayesLoadIndicator;
    document.getElementById('comment_'+id).appendChild(imgElement);
}

function setMessage(ids) {
    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        getAllRatings();
        if (! (ids.constructor == Array)) {
            //without the use of id, the new ids would be undefined
            var id = ids;
            ids = new Array();
            //push as workaround, Array(id) produces errors
            ids.push(id);
        }
        var length = ids.length;
        for (var i=0;i<length;i++) {
            var textElement = document.createElement("p");
            textElement.appendChild(document.createTextNode(bayesDone));
            //update ratings to make the effect visible
            getAllRatings();
            //remove load-indicator:
            var comment = document.getElementById('comment_'+ids[i]);
            comment.removeChild(comment.lastChild);
            comment.appendChild(textElement);
        }
    }
}

function deleteComment(ids) {
    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        if (! (ids.constructor == Array)) {
            //without the use of id, the new ids would be undefined
            var id = ids;
            ids = new Array();
            //push as workaround, Array(id) produces errors
            ids.push(id);
        }
        var length = ids.length;
        for (var i=0;i<length;i++) {
            var comment = document.getElementById('comment_'+ids[i]);
            //by default, there is a hr below the comment and a message above
            var divider = nextObject(comment.parentNode);
            var message = previousObject(comment.parentNode);
            
            remove(comment)
            remove(message);
            remove(divider);
            getAllRatings();
        }
    }
}

//help selecting the various commentelements
function nextObject (n) {
    do
        n = n.nextSibling;
    while (n && n.nodeType != 1);
    return n;
}

function previousObject (p) {
    do
        p = p.previousSibling;
    while (p && p.nodeType != 1);
    return p;
 }

function remove(p) {
    p.parentNode.removeChild(p);
}

/*Rating-display*/

function getRating(id)  {
    var httpRequest;
    if (window.XMLHttpRequest) { // Mozilla, Safari, Opera, IE7
        httpRequest = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // IE6, IE5
        httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }

    //define the callback here to make it possible to have a local httpRequest
    //which is needed for the multiple requests we are sending
    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState == 4 && httpRequest.status == 200) {
            var response = httpRequest.responseText.split(';');
            var length = response.length;
            for (var i=0; i < length; i=i+2) {
                updateRating(response[i+1], response[i]);
            }
        }
    }
    httpRequest.open('POST', ratingPath, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset='+bayesCharset);

    //fetch all ratings of all ids in one step to be faster
    if (id.constructor == Array) {
        id = id.join(';');
    }
    httpRequest.send('id='+id); // Start request
}

function updateRating(id, rating) {
    if (typeof id == 'undefined') {
        return;
    }
    var ratingElement = document.getElementById(id+'_rating');
    if (ratingElement != null) {
        ratingElement.innerHTML = rating;
    } else {
        var textElement = document.createElement('span');
        textElement.setAttribute('class', 'spamblockBayesRating');
        ratingElement = document.createElement('span');
        ratingElement.setAttribute('id', id+'_rating');
        ratingElement.appendChild(document.createTextNode(rating));
        textElement.appendChild(ratingElement);
        var help = document.createElement('img');
        help.setAttribute('src', bayesHelpImage);
        textElement.setAttribute('title', bayesHelpTitle);
        textElement.appendChild(help);
        //id_mail only will exist in s9y 1.6
        var ratingLocation = document.getElementById(id+'_mail');
        if (ratingLocation == null) {
            ratingLocation = document.getElementById('comment_'+id);
        }
        if (ratingLocation != null) {
            ratingLocation.appendChild(textElement);
        }
    }
}

function removeRatings() {
    //reduce number of searched elements via expensive getElementByClass
    var form = document.getElementById('formMultiDelete');
    var ratings = getElementByClass('spamblockBayesRating', form);
    length = ratings.length
    for (var i=0; i < length; i++) {
         ratings[i].parentNode.removeChild(ratings[i]);
    }
}

function getAllRatings() {
    var form = document.getElementById('formMultiDelete');
    //We need them to fetch the comment-ids
    var controls = getElementByClass('spamblockBayesControls', form, 'a');
    var length = controls.length;
    var ids = new Array()
    for (var i=0; i < length; i++) {
        if (controls[i].getAttribute('id').indexOf('spam') != -1) {
            ids.push(controls[i].getAttribute('id').replace('spam', ''));
        }
    }
    length = ids.length;
    //giving 10000s of comments to classify() will probably 
    //produce a timeout - so split it in smaller pieces
    var size = 100;
    var blocks = Math.ceil(length / size);
    for (i=0; i < blocks; i++) {
        getRating(ids.slice(i*size, (i*size)+size));
    }
}

//Something like this don't exist in Javascript
function getElementByClass(className, node, tag) {
    if (node == null) {
        node = document;
    }
    if (tag == null) {
        tag = "*";
    }
    var allHTMLTags = node.getElementsByTagName(tag);
    var classes = new Array();
    var length = allHTMLTags.length;
    for (var i=0; i < length; i++) {
        //multiple classes are in the same string, so search carefully
        if (allHTMLTags[i].className.indexOf(className) != -1) {
            classes.push(allHTMLTags[i]);
        }
    }
    return classes;
}

function placeSpambutton() {
    var groupBayes = document.createElement('fieldset');
    var groupNormal = document.createElement('fieldset');
    var legendBayes = document.createElement('legend');
    legendBayes.innerHTML = bayesPlugin;
    var legendNormal = document.createElement('legend');
    var buttonSpam = document.createElement('input');
    buttonSpam.setAttribute('type', 'button');
    buttonSpam.setAttribute('name', 'toogle');
    buttonSpam.setAttribute('value', bayesSpambutton);
    buttonSpam.setAttribute('class', 'serendipityPrettyButton input_button');
    buttonSpam.setAttribute('onclick', 'markAllSpam()');

    var buttonHam = document.createElement('input');
    buttonHam.setAttribute('type', 'button');
    buttonHam.setAttribute('name', 'toogle');
    buttonHam.setAttribute('value', bayesHambutton);
    buttonHam.setAttribute('class', 'serendipityPrettyButton input_button');
    buttonHam.setAttribute('onclick', 'markAllHam()');
    
    groupBayes.appendChild(legendBayes);
    groupBayes.appendChild(buttonHam);
    groupBayes.appendChild(buttonSpam);
    groupNormal.appendChild(legendNormal);
    
    var existingButtons = document.getElementsByName('toggle');
    groupNormal.appendChild(existingButtons[0].cloneNode(true));
    groupNormal.appendChild(existingButtons[1].cloneNode(true));
    existingButtons[1].parentNode.replaceChild(groupNormal, existingButtons[1]);
    remove(existingButtons[0]);
    existingButtons[0].parentNode.appendChild(groupBayes);
}

function markAllSpam() {
    var ids = getChecked();
    var length = ids.length;
    spam(ids);
}

function markAllHam() {
    var ids = getChecked();
    var length = ids.length;
    ham(ids);
}

function getChecked() {
    var form = document.getElementById('formMultiDelete');
    var checkboxes = getElementByClass('input_checkbox', form, 'input');
    var length = checkboxes.length;
    var ids = new Array()
    for (var i=0; i < length; i++) {
        if (checkboxes[i].checked) {
           var id = checkboxes[i].name.split('[')[2];
           id = id.substr(0, id.length-1);
           ids.push(id);
        }
    }
    return ids;
}

addLoadEvent(placeSpambutton);
