
<!-- plugin_faq_categories.tpl start -->

<div id="serendipity_faq_plugin" class="clearfix serendipity_entry faq-categories">
    <div id="serendipityFAQNav" class="faq-nav">
        <div><a href="{$serendipityBaseURL}">{$CONST.ADMIN_FRONTPAGE}</a> &gt; {$CONST.FAQ_CATEGORIES}</div>
    </div>
    <div class="serendipity_Entry_Date">
        <h3 class="serendipity_date">{$CONST.FAQ_CATEGORIES}</h3>
    </div>

{if is_array($faq_plugin.categories)}
    <ul>
    {foreach $faq_plugin.categories AS $cat}
        {if $cat.depth == 0}
        <li><a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$cat.id}">{$cat.category}</a></li>
        {/if}
    {/foreach}
    </ul>
{/if}
</div>

<!-- plugin_faq_categories.tpl end -->
