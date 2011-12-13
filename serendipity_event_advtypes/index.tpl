{if $is_embedded != true}
{if $is_xhtml}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
           "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{else}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
           "http://www.w3.org/TR/html4/loose.dtd">
{/if}

<html>
<head>
    <title>{$head_title|@default:$blogTitle} {if $head_subtitle} - {$head_subtitle}{/if}</title>
    <meta http-equiv="Content-Type" content="text/html; charset={$head_charset}" />
    <meta name="Powered-By" content="Serendipity v.{$head_version}" />
    <link rel="stylesheet" type="text/css" href="{$head_link_stylesheet}" />
    <link rel="alternate"  type="application/rss+xml" title="{$blogTitle} RSS feed" href="{$serendipityBaseURL}{$serendipityRewritePrefix}feeds/index.rss2" />
    <link rel="alternate"  type="application/x.atom+xml"  title="{$blogTitle} Atom feed"  href="{$serendipityBaseURL}{$serendipityRewritePrefix}feeds/atom.xml" />
{if $entry_id}
    <link rel="pingback" href="{$serendipityBaseURL}comment.php?type=pingback&amp;entry_id={$entry_id}" />
{/if}
{if $template_option.header_img}
<style type="text/css">
  #serendipity_banner {ldelim}
    background-image:url("{$template_option.header_img}") !important;
  {rdelim}
</style>
{/if}

{serendipity_hookPlugin hook="frontend_header"}
</head>

<body id="{if $head_version < 1.1}{else}{$template_option.colorset}{/if}">
{else}
{serendipity_hookPlugin hook="frontend_header"}
{/if}

{if $is_raw_mode != true}
<div id="serendipity_banner"><a id="topofpage"></a>
    <div id="identity"><h1><a class="homelink1" href="{$serendipityBaseURL}">{$head_title|@default:$blogTitle|truncate:60:" ..."}</a></h1>
    <h2><a class="homelink2" href="{$serendipityBaseURL}">{$head_subtitle|@default:$blogDescription}</a></h2></div>
	<div id="navbar">
				<ul>
				{if $head_version < 1.1}
				<!-- ****** Change navbar links here ****** -->
    				<li><a href="#">About</a></li>
    				<li><a href="#">Photos</a></li>
    				<li><a href="#">Projects</a></li>
    				<li><a href="#">Music</a></li>
    				<li><a href="#">Contact</a></li>
				{else}
        {foreach from=$navlinks item="navlink"}
        <li><a href="{$navlink.href}" title="{$navlink.title}">{$navlink.title}</a></li>
        {/foreach}
				{/if}
				</ul>
			</div>
</div>

<!-- sliding faux columns, part 1 -->
{if $leftSidebarElements > 0 && $rightSidebarElements > 0}
<!-- Case 1: 3 columns -->
<div class="sfc1">
<div class="sfc2">
{/if}
{if $leftSidebarElements > 0 && $rightSidebarElements == 0}
<!-- Case 2: 2 columns, sidebar left -->
<div class="sfc1">
{/if}
{if $leftSidebarElements == 0 && $rightSidebarElements > 0}
<!-- Case 3: 2 columns, sidebar right -->
<div class="sfc2">
{/if}
<!-- we don't need another case for no columns, that'll work anyhow -->
<!-- closed below -->

<!-- MAINPANE -->
<div id="mainpane">

{if $leftSidebarElements > 0 && $rightSidebarElements > 0}
<!-- Case 1: 3 columns -->
<div id="content" class="withboth">{$CONTENT}</div>
<div id="serendipityLeftSideBar" class="leftandright">{serendipity_printSidebar side="left"}</div>
<div id="serendipityRightSideBar">{serendipity_printSidebar side="right"}</div>
{/if}

{if $leftSidebarElements > 0 && $rightSidebarElements == 0}
<!-- Case 2: 2 columns, sidebar left -->
<div id="content" class="withleft">{$CONTENT}</div>
<div id="serendipityLeftSideBar" class="leftonly">{serendipity_printSidebar side="left"}</div>
{/if}

{if $leftSidebarElements == 0 && $rightSidebarElements > 0}
<!-- Case 3: 2 columns, sidebar right -->
<div id="content" class="withright">{$CONTENT}</div>
<div id="serendipityRightSideBar">{serendipity_printSidebar side="right"}</div>
{/if}

{if $leftSidebarElements == 0 && $rightSidebarElements == 0}
<!-- Case 4: 1 column, no sidebars -->
<div id="content" class="nosidebars">{$CONTENT}</div>
{/if}

</div><!-- END MAINPANE -->

<!-- sliding faux columns, part 2 -->
{if $leftSidebarElements > 0 && $rightSidebarElements > 0}
<!-- Case 1: 3 columns -->
</div><!-- closes .sfc2 -->
</div><!-- closes .sfc1 -->
{/if}
{if $leftSidebarElements > 0 && $rightSidebarElements == 0}
<!-- Case 2: 2 columns, sidebar left -->
</div><!-- closes .sfc1 -->
{/if}
{if $leftSidebarElements == 0 && $rightSidebarElements > 0}
<!-- Case 3: 2 columns, sidebar right -->
</div><!-- closes .sfc2 -->
{/if}
<!-- end sfc -->

{/if}
{$raw_data}
{serendipity_hookPlugin hook="frontend_footer"}
{if $is_embedded != true}
<div id="footer">
<p>{$CONST.POWERED_BY} <a href="http://www.s9y.org">s9y</a> - Design by <a href="http://www.carlgalloway.com">Carl</a> and <a href="http://www.yellowled.de">YellowLed</a></p>
</div>
</body>
</html>
{/if}
