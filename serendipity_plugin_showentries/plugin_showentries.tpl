{foreach from=$entries item="entry"}
{if $showtitle}
    <div class="serendipity_showentry_title">
    {$entry.title|escape}
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