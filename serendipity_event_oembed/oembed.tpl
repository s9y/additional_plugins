{* oembed.tpl last modified 2011-12-01 *}
<span class="serendipity_oembed">
{if $oembed.type=='rich'}		{* =================================================== RICH *}
{if $oembed.provider_name=="Wikipedia"}
<blockquote>{$oembed.html}</blockquote>
{elseif $oembed.provider_name=="IMDB"} {* beautify IMDB content *}
<blockquote>{$oembed.html|replace:"<h2>":"<strong>"|replace:"</h2>":"</strong>"|replace:"<img":"<img align='right'"}</blockquote>
{elseif $oembed.provider-name=="Soundcloud"} {* beautify SoundCloud *}
{$oembed.html|replace:"</object>":"</object><br/>"}
{else}
{$oembed.html}
{/if}
{elseif $oembed.type=='video'}	{* =================================================== VIDEO *}
{$oembed.html}
{elseif $oembed.type=='image'}	{* =================================================== IMAGE *}
<a href="{$oembed.url}"><img src="{$oembed.thumbnail_url}""{if $oembed.title} title="{$oembed.title}" alt="{$oembed.title}"{/if}/></a>
{elseif $oembed.type=='photo'}	{* =================================================== PHOTO *}
<img src="{$oembed.url}"{if $oembed.title} title="{$oembed.title}" alt="{$oembed.title}"{/if}/>
{elseif $oembed.type=='link'}	{* =================================================== LINK *}
{if $oembed.provider_name=="Wikipedia"}<blockquote>{/if}
{if $oembed.description}
{if $oembed.title}<strong>{$oembed.title}</strong><br/>{/if}
<p>{if $oembed.thumbnail_url}<img src="{$oembed.thumbnail_url}" align="left">{/if}{$oembed.description}{if $oembed.url}<br/>[<a href="{$oembed.url}" target="_blank">link</a>]{/if}</p>
{else}
<a href="{$oembedurl}" title="{$oembed.title}">{$oembed.author_name}</a>
{/if}
{if $oembed.provider_name=="Wikipedia"}</blockquote>{/if}
{else}  {* Link type finishes *}
<a href="{$oembedurl}" target="_blank">{if $oembed.error}{$oembed.error}{else}{$oembedurl}{/if}</a>
{/if}
</span>