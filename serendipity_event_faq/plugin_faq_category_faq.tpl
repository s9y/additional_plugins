
<!-- plugin_faq_category_faq.tpl start -->

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

<h3>{$faq_plugin.this_faq.category}</h3>

<p><b>{$smarty.const.FAQ_QUESTION}:</b> {$faq_plugin.this_faq.question}</p>
<p><b>{$smarty.const.FAQ_ANSWER}:</b> {$faq_plugin.this_faq.answer}</p>


<p>{$smarty.const.FAQ_PREVOUS} <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$faq_plugin.prev_faq.categoryid}/{$faq_plugin.prev_faq.faqid}">{$faq_plugin.prev_faq.question|truncate:30:'...'}</a></p>
<p>{$smarty.const.FAQ_NEXT} <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$faq_plugin.next_faq.categoryid}/{$faq_plugin.next_faq.faqid}">{$faq_plugin.next_faq.question|truncate:30:'...'}</a></p>

<!-- plugin_faq_category_faq.tpl end -->
