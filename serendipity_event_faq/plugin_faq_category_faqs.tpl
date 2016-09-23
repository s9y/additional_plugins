
<!-- plugin_faq_category_faqs.tpl start -->

<div id="serendipity_faq_plugin" class="clearfix serendipity_entry faq-categoryfaqs">
    <div id="serendipityFAQNav" class="faq-nav">
        <div>
            <a href="{$serendipityBaseURL}">{$CONST.ADMIN_FRONTPAGE}</a> &gt; <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}">{$CONST.FAQ_CATEGORIES}</a>

        {foreach $cat_tree AS $cat}
            &gt; {if $cat.id != $faq_plugin.catid}<a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$cat.id}">{/if}{$cat.category}{if $cat.id != $faq_plugin.catid}</a>{/if}
        {/foreach}
        </div>
    </div>

    <h3>{$faq_plugin.category}</h3>
    {if $faq_plugin.introduction}<div>{$faq_plugin.introduction}</div>{/if}

    {if is_array($faq_plugin.subcategories)}
        <ul>
        {foreach $faq_plugin.subcategories AS $subcat}
            <li><a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$subcat.id}">{$subcat.category}</a></li>
        {/foreach}
        </ul>
    {/if}

    {if is_array($faq_plugin.faqs)}
        <ul class="faq-faqs">
        {foreach $faq_plugin.faqs AS $faq}
            <li><icon class="faq_question-icon"></icon> <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$faq.cid}/{$faq.id}">{$faq.question}</a> <em class="faq-status{if $faq.status == $CONST.FAQ_NEW} faq-new{/if}">{$faq.status}</em></li>
        {/foreach}
        </ul>
    {/if}
</div>

<!-- plugin_faq_category_faqs.tpl end -->
