{* oembed.tpl last modified 2011-12-01 *}
<span class="serendipity_oembed">
{if $oembed.type=='rich'}
{$oembed.html}
{elseif $oembed.type=='video'}
{$oembed.html}
{elseif $oembed.type=='image'}
<a href="{$oembed.url}"><img src="{$oembed.thumbnail_url}""{if $oembed.title} title="{$oembed.title}" alt="{$oembed.title}"{/if}/></a>
{elseif $oembed.type=='photo'}
<img src="{$oembed.url}"{if $oembed.title} title="{$oembed.title}" alt="{$oembed.title}"{/if}/>
{elseif $oembed.type=='link'}
<a href="{$oembedurl}" title="{$oembed.title}">{$oembed.author_name}</a>
{else}
<a href="{$oembedurl}" target="_blank">{$oembedurl}</a>
{/if}
</span>