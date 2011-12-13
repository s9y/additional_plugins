
<!-- plugin_faq_category_faqs.tpl start -->

<div id="serendipityFAQNav">
<p><a href="{$serendipityBaseURL}">{$smarty.const.ADMIN_FRONTPAGE}</a> &gt; <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}">{$smarty.const.FAQ_CATEGORIES}</a>

{foreach from=$cat_tree item=cat}
&gt; {if $cat.id != $faq_plugin.catid}
<a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$cat.id}">
{/if}
{$cat.category}
{if $cat.id != $faq_plugin.catid}
</a>
{/if}
{/foreach}
</p>
</div>

<h3>{$faq_plugin.category}</h3>
{if $faq_plugin.introduction}<p>{$faq_plugin.introduction}</p>{/if}

{if is_array($faq_plugin.subcategories)}
<ul>
{foreach from=$faq_plugin.subcategories item=subcat}
<li><a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$subcat.id}">{$subcat.category}</a></li>
{/foreach}
</ul>
{/if}

{if is_array($faq_plugin.faqs)}
<ul>
{foreach from=$faq_plugin.faqs item=faq}
<li><a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$faq.cid}/{$faq.id}">{$faq.question}</a> {$faq.status}</li>
{/foreach}
</ul>
{/if}

<!-- plugin_faq_category_faqs.tpl end -->
