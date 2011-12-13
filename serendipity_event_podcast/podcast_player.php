<?php

/*
 * This file contains all players used by the Easy Podcast Plugin and default extensions
 * 
 */

@DEFINE('PLUGIN_PODCAST_QTEXT_DEFAULT'      ,'3gp,mov,mp4,mqv,qt');
@DEFINE('PLUGIN_PODCAST_WMEXT_DEFAULT'      ,'avi,mpg,mpeg,wmv');
@DEFINE('PLUGIN_PODCAST_MFEXT_DEFAULT'      ,'swf');
@DEFINE('PLUGIN_PODCAST_AUEXT_DEFAULT'      ,'ogg,m3u,pls,m4b');
@DEFINE('PLUGIN_PODCAST_XSPFEXT_DEFAULT'    ,'mp3,xspf');
@DEFINE('PLUGIN_PODCAST_FLOWEXT_DEFAULT'    ,'flv');
@DEFINE('PLUGIN_PODCAST_HTML5_AUDIO_DEFAULT','');
@DEFINE('PLUGIN_PODCAST_HTML5_VIDEO_DEFAULT','');


// Quicktime Player
@DEFINE('PLUGIN_PODCAST_QUICKTIMEPLAYER'    ,'
<!--[if !IE]> -->
<object type="video/quicktime"
    class="qtplayer"
    data="#url#"
    #height# #width# #align#>
<!-- <![endif]-->
<!--[if IE]>
<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"
    codebase="http://www.apple.com/qtactivex/qtplugin.cab"
    class="qtplayer"
    #height# #width# #align#>
<!--><!---->
    <param name="src" value="#url#"/>
    <param name="autoplay" value="false"/>
    <param name="controller" value="true"/>
    <param name="scale" value="ASPECT"/>
</object>
<!-- <![endif]-->
');

// Windows Media Player
@DEFINE('PLUGIN_PODCAST_WMPLAYER'           ,'
<!--[if !IE]> -->
<object type="application/x-mplayer2"
    class="wmplayer"
    data="#url#"
    #height# #width# #align#>
<!-- <![endif]-->
<!--[if IE]>
<object classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95"
    codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701"
    standby="Media is loading..." type="application/x-oleobject"
    class="wmplayer"
    #height# #width# #align#>
<!--><!---->
    <param name="fileName" value="#url#" />
    <param name="animationatStart" value="true" />
    <param name="transparentatStart" value="false" />
    <param name="autoStart" value="0" />
    <param name="showControls" value="1" />
    <param name="showstatusbar" value="0" />
    <param name="showtracker" value="1" />
    <param name="loop" value="0" /> 
</object>
<!-- <![endif]-->
');

@DEFINE('PLUGIN_PODCAST_FLASHPLAYER'        ,'
<!--[if !IE]> -->
<object type="application/x-shockwave-flash"
    data="#url#"
    class="flashplayer"
    #height# #width# #align#>
<!-- <![endif]-->
<!--[if IE]>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
    codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
    class="flashplayer"
    #height# #width# #align#>
    <param name="movie" value="#url#" />
<!--><!---->
    <param name="quality" value="high" />
    <param name="menu" value="true" />
    <param name="scale" value="noorder" />
    <param name="bgcolor" value="#FFFFFF" />
    <param name="loop" value="false" />
</object>
<!-- <![endif]-->
');

@DEFINE('PLUGIN_PODCAST_MP3PLAYER'          ,'
<!--[if !IE]> -->
<object type="video/quicktime"
    data="#url#"
    class="qtsmallplayer"
    width="50" height="15" #align#>
<!-- <![endif]-->
<!--[if IE]>
<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" 
    codebase="http://www.apple.com/qtactivex/qtplugin.cab"
    class="qtsmallplayer"
    width="50" height="15" #align#>
<!--><!---->
    <param name="src" value="#url#"/>
    <param name="autoplay" value="false"/>
    <param name="controller" value="true"/>
    <param name="scale" value="ASPECT"/>
</object>
<!-- <![endif]-->
');

@DEFINE('PLUGIN_PODCAST_XSPFPLAYER'          ,'
<!--[if !IE]> -->
<object type="application/x-shockwave-flash"
    data="#plugin#/player/xspf/xspf_player_slim.swf?song_url=#url#&amp;song_title=#filename#"
    class="xspfplayer"
    height="15" width="200" #align#>
<!-- <![endif]-->
<!--[if IE]>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
    codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
    class="xspfplayer"
    height="15" width="200" #align#>
    <param name="movie" value="#plugin#/player/xspf/xspf_player_slim.swf?song_url=#url#&amp;song_title=#filename#" />
<!--><!---->
    <param name="player_title" value="Easy Podcasting Plugin" />
    <param name="song_title" value="#filename#" />
    <param name="quality" value="high" />
    <param name="menu" value="true" />
    <param name="scale" value="noorder" />
    <param name="bgcolor" value="#FFFFFF" />
    <param name="loop" value="false" />
</object>
<!-- <![endif]-->
');

@DEFINE('PLUGIN_PODCAST_FLVPLAYER'          ,'
<p class="podcasting" id="podcast_#htmlid#"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player. JavaScript is also needed to see this player.</p>
<script type="text/javascript">
    var s1 = new SWFObject("#plugin#/player/flvplayer.swf","single","#intwidth#","#intheight#","7");
    s1.addParam("allowfullscreen","true");
    s1.addVariable("file","#url#");
    s1.addVariable("image","#url_noext#.jpg");
    s1.write("podcast_#filename#");
</script>
');

@DEFINE('PLUGIN_PODCAST_FLOWPLAYER', '
<a href="#url#" class="podcastplayer" id="podcast_#htmlid#"></a>
<script type="text/javascript">
flowplayer("podcast_#htmlid#", "#plugin#/player/flowplayer/flowplayer-3.2.7.swf", {
clip: {
    onStart: function(clip) {
        pel = document.getElementById(\'podcast_#htmlid#\').style;
        pel.width  = clip.metaData.width + \'px\';
        pel.height = clip.metaData.height + \'px\';
    }
}
});
</script>
');

@DEFINE('PLUGIN_PODCAST_HTML5_AUDIOPLAYER', '
<audio controls preload="none">
    <source src="#url#" type="#mime#" />
    ' . PLUGIN_PODCAST_FLOWPLAYER . '
</audio>
');

@DEFINE('PLUGIN_PODCAST_HTML5_VIDEOPLAYER', '
<video controls preload="none">
    <source src="#url#" type="#mime#" />
    ' . PLUGIN_PODCAST_FLOWPLAYER . '
</video>
');