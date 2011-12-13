function tweeter_char_count(){
    var tweet = document.getElementById("tweeter_tweet"), chars = 140;
    //This version counts encoded. Twitter API says, it would count like this, but it doesn't seem to be that way!
    //var count = chars - escape(tweet.value.replace(/ /g, "1").replace(/\r\n/g, "\n")).length;
    var count = chars - tweet.value.replace(/\r\n/g, "\n").length;
    
    if(count < 0){
        tweet.value = tweet.value.substr(0, chars);

        count = 0;
    }
    document.getElementById("tweeeter_charcount").innerHTML = count;
    return true;
}

function tweeter_reply( receiver ) {
    var tweet = document.getElementById("tweeter_tweet");
    tweet.value = "@" + receiver + " " + tweet.value;
    tweeter_char_count();
}

function tweeter_dm( receiver ) {
    var tweet = document.getElementById("tweeter_tweet");
    tweet.value = "D " + receiver + " " + tweet.value;
    tweeter_char_count();
}

function tweeter_retweet( receiver, what ) {
    what = what.replace(/#quot1;/g,"'").replace(/#quot2;/g,'"');
    var tweet = document.getElementById("tweeter_tweet");
    tweet.value = "RT @" + receiver + " " + what;
    tweeter_char_count();
}
