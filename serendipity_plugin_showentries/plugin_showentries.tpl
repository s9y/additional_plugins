{foreach from=$entries item="entry"}
{if $showtitle}
    <div class="serendipity_showentry_title">
    <h3><a href="{$entry.link}">{$entry.title|escape}</a></h3>
    </div>                
{/if}
            
<div class="serendipity_showentry_body">
{$entry.body}
</div>

{if $showext}
    <div class="serendipity_showentry_extended">
    {$entry.extended}
    </div>
{/if}

<div class="serendipity_showentry_separator"></div>
{/foreach}