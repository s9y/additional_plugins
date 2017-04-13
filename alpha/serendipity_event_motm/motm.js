var poll_count = 0;
var slidetime;
var slidetime2;
var secsnow;
var secstotal;
var content;

// refresh the iframe, it will call do_refresh()
function refresh()
{
    var iframe = document.getElementById('motm_iframe');
    iframe.src = _iframe_url;
}

function do_refresh()
{
    var container = document.getElementById('motm_container');
    
    // if we go over, refresh to remove progress bar
    if (secsnow > secstotal && poll_count == 0)
    {
        poll_count++;
        container.innerHTML = content;
        setTimeout('refresh()',5*60*1000);
    }
    // keep refreshing in case a new track is played
    else if (secsnow > secstotal)
    {
        poll_count++;
        setTimeout('refresh()',5*60*1000);
    }
    // new track, yay!
    else
    {
        poll_count = 0;
        container.innerHTML = content;
        slidetime = (new Date()).getTime();
        slidetime2 = (new Date()).getTime();
        slide(secsnow,secstotal);
    }
}

function slide(secsnow,secstotal) {
    var track = document.getElementById('serendipity_motm_track');
    var tracktime = document.getElementById('serendipity_motm_tracktime');
    var slider = document.getElementById('serendipity_motm_slider');
    var debug = document.getElementById('motm_debug');
    trackw = track.style.width;
    trackw = trackw.replace(/px/g,"");
    trackw = trackw - 2;
    
    // running slip total, averaged
    //  accomidate for setTimeout lag, keeps everything more accurate, big problem on large tracks
    //  usually accruate within 1 second vs 30+ seconds on a 10 minute track
    var new_slidetime = (new Date()).getTime();
    var slidetime_slip = 1000 - (new_slidetime - slidetime2)/2;
    if (slidetime_slip > 500)
        slidetime_slip = 0;
    slidetime2 = slidetime;
    slidetime = new_slidetime;
    
    
    if (secsnow > secstotal && (secsnow - secstotal) <= 4)
    {
        // refresh in 5 seconds
        slider.innerHTML = "(" + (5 - (secsnow - secstotal)) + ")";
        secsnow++;
        setTimeout('slide('+secsnow+','+secstotal+')', 1000 + slidetime_slip);
    }
    else if (secsnow > secstotal && (secsnow - secstotal) > 4)
    {
        slider.innerHTML = "(" + (5 - (secsnow - secstotal)) + ")";
        refresh();
    }
    else 
    {
        // refresh every seconds
        pctcomplete = secsnow / secstotal;
        slidelen = pctcomplete * trackw;
        slider.style.width = slidelen + 'px';
        slider.innerHTML = stime(secsnow);
        secsnow++;
        setTimeout('slide('+secsnow+','+secstotal+')', 1000 + slidetime_slip);
    }
}

function stime(secs) {
    smin = secs >= 60 ? Math.floor(secs / 60) : 0;
    ssec = secs - 60 * smin;
    ssec = ssec < 10 ? '0'+ssec : ssec;
    return smin+':'+ssec;   
}