<?php # 

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_TEXTLINKADS_TITLE', 'Embed Ads (TextLinkAds.com, Custom)');
@define('PLUGIN_EVENT_TEXTLINKADS_DESC', 'Embeds Ads into your page.');
@define('PLUGIN_EVENT_TEXTLINKADS_INFO', '<p>You need to edit the Smarty .tpl file of your template to indicate where the ad should be placed, else it will not appear on your site. Use this Smarty code to place a TextLinkAd.com Ad: {serendipity_hookPlugin hook="external_service_tla" hookAll="true"}. If you want to use a custom ad method, you can use this Smarty function call:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="X:Y"}</p>
<p>Replace "X" with the name of the subdirectory (relative to the plugins base directory) where you want the Ad-Snippets to appear in. The plugin will then cycle that subdirectory with the given frequency of Y ("weekly", "daily", "hourly", "half-hour", "per-call") and pick one random .html file to display.</p>
<p>For example, you have a subdirectory "headers" and "footers". In the "headers" subdirectory you have the file "nice.html", "nifty.html" and "great.html". In the "footers" subdirectory you have the file "great.html" and "awesome.html". Then you edit your Template index.tpl file and place this code at the top:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="headers:daily"}</p>
<p>and this piece of code in the footer section:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="footers:weekly"}</p>
<p>Then when you call your blog, you will see contents of one random .html file placed in there, and it will only change after the frequency of the ad has been reached. Inside the HTML files you can place any HTML code you like (like JavaScript, GoogleAdSense etc)');
@define('PLUGIN_EVENT_TEXTLINKADS_HTMLID', '(For TextLinkAds) The CSS ID of the HTML element with your textads');
@define('PLUGIN_EVENT_TEXTLINKADS_XMLFILENAME', '(For TextLinkAds) The local filename where to store the textlink');
