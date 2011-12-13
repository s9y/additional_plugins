<?xml version="1.0" encoding="{$head_charset}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
         "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>{$head_title|@default:$blogTitle} {if $head_subtitle} - {$head_subtitle}{/if}</title>
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset={$head_charset}"/>
		<meta name="generator" content="Serendipity Android Output"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="{$head_link_stylesheet}"/>
<script type="text/javascript" charset="utf-8">
{literal}var imgSizer = {
	Config : {
		imgCache : []{/literal} 
		,spacer : "{serendipity_getFile file="img/spacer.gif"}"{literal}
	}

	,collate : function(aScope) {
		var isOldIE = (document.all && !window.opera && !window.XDomainRequest) ? 1 : 0;
		if (isOldIE && document.getElementsByTagName) {
			var c = imgSizer;
			var imgCache = c.Config.imgCache;

			var images = (aScope && aScope.length) ? aScope : document.getElementsByTagName("img");
			for (var i = 0; i < images.length; i++) {
				images[i].origWidth = images[i].offsetWidth;
				images[i].origHeight = images[i].offsetHeight;

				imgCache.push(images[i]);
				c.ieAlpha(images[i]);
				images[i].style.width = "100%";
			}

			if (imgCache.length) {
				c.resize(function() {
					for (var i = 0; i < imgCache.length; i++) {
						var ratio = (imgCache[i].offsetWidth / imgCache[i].origWidth);
						imgCache[i].style.height = (imgCache[i].origHeight * ratio) + "px";
					}
				});
			}
		}
	}

	,ieAlpha : function(img) {
		var c = imgSizer;
		if (img.oldSrc) {
			img.src = img.oldSrc;
		}
		var src = img.src;
		img.style.width = img.offsetWidth + "px";
		img.style.height = img.offsetHeight + "px";
		img.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + src + "', sizingMethod='scale')"
		img.oldSrc = src;
		img.src = c.Config.spacer;
	}

	// Ghettomodified version of Simon Willison's addLoadEvent() -- http://simonwillison.net/2004/May/26/addLoadEvent/
	,resize : function(func) {
		var oldonresize = window.onresize;
		if (typeof window.onresize != 'function') {
			window.onresize = func;
		} else {
			window.onresize = function() {
				if (oldonresize) {
					oldonresize();
				}
				func();
			}
		}
	}
}

addLoadEvent(function() {
	imgSizer.collate();
});

function addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof window.onload != 'function') {
		window.onload = func;
	} else {
		window.onload = function() {
			if (oldonload) {
				oldonload();
			}
			func();
		}
	}
}

function toggleEntryBody(divId) {
	var ele = document.getElementById(divId);
	if(ele.style.display == "block") {
    		ele.style.display = "none";
  	}
	else {
		ele.style.display = "block";
	}
	return false;
}
function loadUrl(aUrl){
	if (self.location.href!=aUrl) self.location.href=aUrl;
}
{/literal}  
</script>

	</head>
	<body>
		{$debug}
		<div id="header" onClick="loadUrl('{$serendipityBaseURL}')">
			<div id="title"><h1><a href="{$serendipityBaseURL}" class="header">{$head_title|@default:$blogTitle}</a></h1>
			<h2><a href="{$serendipityBaseURL}" class="header">{$head_subtitle|@default:$blogDescription}</a></h2></div>
		</div>
		
		<div id="content">
			{$CONTENT}
		</div>
		<div id="footer">
			<a id="n"></a>
			<div id="nav">
				<div class="navItem">
<table border="0" width="100%">
<tr>
<td>{if $footer_prev_page}<a href="{$footer_prev_page}"><img src="{serendipity_getFile file="img/arrow_prev.gif"}" align="left" alt="{$CONST.PREVIOUS_PAGE}"/></a>{else}<img src="{serendipity_getFile file="img/spacer.gif"}" width="38" align="left" alt="{$CONST.PREVIOUS_PAGE}" class="navItemSpacer"/>{/if}</td>
<td align="center"><a href="{$serendipityBaseURL}" align="center">{$CONST.HOMEPAGE}</a></td>
<td>{if $footer_next_page}
<a href="{$footer_next_page}"><img src="{serendipity_getFile file="img/arrow.gif"}" align="right" alt="{$CONST.NEXT_PAGE}"/></a>{else}<img src="{serendipity_getFile file="img/spacer.gif"}" width="38" align="left" alt="{$CONST.NEXT_PAGE}" class="navItemSpacer"/>{/if}</td>
</tr>
{if $categories}
<tr><td colspan="3" align="center">
{foreach from=$categories item="plugin_category"}
	<div class="navItem">
		<a href="{$plugin_category.categoryURL}">{$plugin_category.category_name|escape}</a>
	</div>
{/foreach}
</td></tr>
{/if}
</table>
				</div>
 				
				

			</div>
		</div>
	</body>
</html>
