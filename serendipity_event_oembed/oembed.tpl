{* oembed.tpl last modified 2011-12-01 *}
{if $oembed.type=='rich'}		{* =================================================== RICH *}
<span class="serendipity_oembed_rich">
{if $oembed.provider_name=="Wikipedia"}
<blockquote>{$oembed.html}</blockquote>
{elseif $oembed.provider_name=="IMDB"} {* beautify noembed.com IMDB content *}
<blockquote>{$oembed.html|replace:"<h2>":"<strong>"|replace:"</h2>":"</strong>"|replace:"<img":"<img align='right'"}</blockquote>
{elseif $oembed.provider-name=="Soundcloud"} {* beautify SoundCloud *}
{$oembed.html|replace:"</object>":"</object><br/>"}
{else}
{$oembed.html}
{/if}
</span>
{elseif $oembed.type=='video'}	{* =================================================== VIDEO *}
<span class="serendipity_oembed_video">
{$oembed.html}
</span>
{elseif $oembed.type=='image'}	{* =================================================== IMAGE *}
<span class="serendipity_oembed_photo">
<a href="{$oembed.url}"><img src="{$oembed.thumbnail_url}""{if $oembed.title} title="{$oembed.title}" alt="{$oembed.title}"{/if}/></a>
</span>
{elseif $oembed.type=='photo'}	{* =================================================== PHOTO *}
<span class="serendipity_oembed_photo">
<img src="{$oembed.url}"{if $oembed.title} title="{$oembed.title}" alt="{$oembed.title}"{/if}/>
</span>
{elseif $oembed.type=='link'}	{* =================================================== LINK *}
<span class="serendipity_oembed_link">
{if $oembed.provider_name=="Wikipedia"}<blockquote>{/if}
{if $oembed.description}
{if $oembed.title}<strong>{$oembed.title}</strong><br/>{/if}
<p>{if $oembed.thumbnail_url}<img src="{$oembed.thumbnail_url}" align="left" style="padding-right: 1em"{if $oembed.title} alt="{$oembed.title}" title="{$oembed.title}"{/if}>{/if}{$oembed.description}{if $oembed.url} [<a href="{$oembed.url}" target="_blank">link</a>]{/if}</p>
{else}
<a href="{$oembedurl}" title="{$oembed.title}">{$oembed.author_name}</a>
{/if}
{if $oembed.provider_name=="Wikipedia"}</blockquote>{/if}
</span>
{else}  {* Link type finishes *}
<span class="serendipity_oembed">
<a href="{$oembedurl}" target="_blank">{if $oembed.error}{$oembed.error}{else}{$oembedurl}{/if}</a>
</span>
{/if}
