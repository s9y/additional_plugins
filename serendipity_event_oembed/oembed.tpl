{* oembed.tpl last modified 2011-12-01 *}
{if $oembed.type=='rich'}		{* =================================================== RICH *}
<div class="serendipity_oembed_rich">
{if $oembed.provider_name=="Wikipedia"}
<blockquote>{$oembed.html}</blockquote>
{elseif $oembed.provider_name=="IMDB"} {* beautify noembed.com IMDB content *}
<blockquote>{$oembed.html|replace:"<h2>":"<strong>"|replace:"</h2>":"</strong>"|replace:"<img":"<img align='right'"}</blockquote>
{elseif $oembed.provider-name=="Soundcloud"} {* beautify SoundCloud *}
{$oembed.html|replace:"</object>":"</object><br/>"}
{else}
{$oembed.html}
{/if}
</div>
{elseif $oembed.type=='video'}	{* =================================================== VIDEO *}
<div class="serendipity_oembed_video">
{$oembed.html}
</div>
{elseif $oembed.type=='image'}	{* =================================================== IMAGE *}
<div class="serendipity_oembed_photo">
<a href="{$oembed.url}"><img src="{$oembed.thumbnail_url}""{if $oembed.title} title="{$oembed.title}" alt="{$oembed.title}"{/if}/></a>
</div>
{elseif $oembed.type=='photo'}	{* =================================================== PHOTO *}
<div class="serendipity_oembed_photo">
<img src="{$oembed.url}"{if $oembed.title} title="{$oembed.title}" alt="{$oembed.title}"{/if}/>
</div>
{elseif $oembed.type=='link'}	{* =================================================== LINK *}
<div class="serendipity_oembed_link">
{if $oembed.provider_name=="Wikipedia"}<blockquote>{/if}
{if $oembed.description}{if $oembed.title}<strong>{$oembed.title}</strong><br/>{/if}
<p>{if $oembed.thumbnail_url}<img src="{$oembed.thumbnail_url}" align="left" style="padding-right: 1em"{if $oembed.title} alt="{$oembed.title}" title="{$oembed.title}"{/if}>{/if}{$oembed.description}{if $oembed.url} [<a href="{$oembed.url}" target="_blank">link</a>]{/if}</p>
{elseif $oembed.title}
<a href="{$oembedurl}" title="{$oembed.title}">{if $oembed.author_name}{$oembed.author_name}: {/if}{$oembed.title}</a>
{elseif $oembed.thumbnail_url}
<a href="{$oembedurl}" title="{$oembed.title}"><img src="{$oembed.thumbnail_url}"></a>
{else}
<a href="{$oembedurl}" title="{$oembed.title}">{$oembedurl}</a>
{/if}
{if $oembed.provider_name=="Wikipedia"}</blockquote>{/if}
</div>
{else}  {* Link type finishes *}
<div class="serendipity_oembed">
<a href="{$oembedurl}" target="_blank">{if $oembed.error}{$oembed.error}{else}{$oembedurl}{/if}</a>
</div>
{/if}
