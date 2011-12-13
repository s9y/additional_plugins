<?xml version="1.0" encoding="{$head_charset}"?>
<!DOCTYPE html PUBLIC "-//OPENWAVE//DTD XHTML Mobile 1.0//EN" "http://www.openwave.com/dtd/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>{$head_title|@default:$blogTitle} {if $head_subtitle} - {$head_subtitle}{/if}</title>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset={$head_charset}"/>
		<meta name="generator" content="Serendipity XHTML MP Output - http://c.mobile-seo.de/"/>
    <link rel="stylesheet" type="text/css" href="{$head_link_stylesheet}"/>
	</head>
	<body>
		
		{$debug}
		
		<div id="header">
			<div id="title"><h1>{$head_title|@default:$blogTitle}</h1></div>
			<div id="headline"><h2>{$head_subtitle|@default:$blogDescription}</h2></div>
			<div id="nl"><a class="n" href="#n">{$CONST.PLUGIN_EVENT_MOBILE_OUTPUT_NAVIGATION}</a></div>
		</div>
		
		<div id="content">
			{$CONTENT}
		</div>
		
		<div id="footer">
			<a id="n"></a>
			<div id="nav">
				{if $footer_next_page}
		 			<div class="navItem"><span class="naviItemAK">[#]</span> <a accesskey="#" href="{$footer_next_page}">{$CONST.NEXT_PAGE}</a></div>
		 		{/if}
 				{if $footer_prev_page}
					<div class="navItem"><span class="naviItemAK">[*]</span> <a accesskey="*" href="{$footer_prev_page}">{$CONST.PREVIOUS_PAGE}</a></div>
		 		{/if}
				<div class="navItem"><span class="naviItemAK">[0]</span> <a accesskey="0" href="{$serendipityBaseURL}">{$CONST.HOMEPAGE}</a></div>
				{foreach from=$categories item="plugin_category"}
					<div class="navItem">
						{if $plugin_category.access_key <= 9}
							<span class="naviItemAK">[{$plugin_category.access_key}]</span> 
							<a accesskey="{$plugin_category.access_key}" href="{$plugin_category.categoryURL}">{$plugin_category.category_name|escape}</a>
						{else}
							<span class="naviItemAK">[&#160;&#160;]</span> 
							<a href="{$plugin_category.categoryURL}">{$plugin_category.category_name|escape}</a>
						{/if}
					</div>
				{/foreach}
			</div>
		</div>
	</body>
</html>
