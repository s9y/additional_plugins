http_count_replacer = /(http):\/\/\S+/;
https_count_replacer = /(https):\/\/\S+/;

function startswith(input, check) {
	return input.substring(0, check.length) === check;
}
function accountChanged()  {
	tweeter_char_count();
}
function tweeter_char_count(){
    var tweet = document.getElementById("tweeter_tweet"), chars = 140;
    var selAccount = document.getElementById("tweeter_account");
    account_name = selAccount.options[selAccount.selectedIndex].text;
    is_twitter_account = startswith(account_name,"twitter");
    
    //This version counts encoded. Twitter API says, it would count like this, but it doesn't seem to be that way!
    //var count = chars - escape(tweet.value.replace(/ /g, "1").replace(/\r\n/g, "\n")).length;
    test = tweet.value.replace(/\r\n/g, "\n");
    if (is_twitter_account) {
    	test = test.replace(http_count_replacer,twitter_http_length_str).replace(https_count_replacer,twitter_https_length_str);
    }
    var count = chars - test.length;
    
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
