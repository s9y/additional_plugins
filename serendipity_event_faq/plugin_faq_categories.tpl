
<!-- plugin_faq_categories.tpl start -->

<div id="serendipityFAQNav">
<p><a href="{$serendipityBaseURL}">{$smarty.const.ADMIN_FRONTPAGE}</a> &gt; {$smarty.const.FAQ_CATEGORIES}</p>
</div>
<div class="serendipity_Entry_Date">
<h3 class="serendipity_date">{$smarty.const.FAQ_CATEGORIES}</h3>
</div>

{if is_array($faq_plugin.categories)}
<ul>
{foreach from=$faq_plugin.categories item=cat}
{if $cat.depth == 0}
<li><a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$cat.id}">{$cat.category}</a></li>
{/if}
{/foreach}
</ul>
{/if}

<!-- plugin_faq_categories.tpl end -->
