
<!-- plugin_faq_category_faqs.tpl start -->
<!-- modifications January 2007 to duplicate design of entry page -->

<div class="serendipity_Entry_Date">
     <h3 class="serendipity_date">{$smarty.const.FAQ_NAME}</h3>
     <h4 class="serendipity_title"><a href="#">{$faq_plugin.category}</a></h4>
     <div class="serendipity_entry">
          <div class="serendipity_entry_body">
               <div id="serendipityFAQNav">
                    <p><a href="{$serendipityBaseURL}">{$smarty.const.ADMIN_FRONTPAGE}</a> &gt; <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}">{$smarty.const.FAQ_CATEGORIES}</a>
                         {foreach from=$cat_tree item=cat} &gt;
                              {if $cat.id != $faq_plugin.catid}
                                   <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$cat.id}">
                              {/if}
                              {$cat.category}
                              {if $cat.id != $faq_plugin.catid}
                                   </a>
                              {/if}
                         {/foreach}
                    </p>
               </div>
<!-- line below is redundant with h4 title above, but some users might like to include it anyway -->
<!-- <h3>{$faq_plugin.category}</h3> -->
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

          </div>
     </div>
</div>

<div class='serendipity_entryFooter' style="text-align: center">
</div>
<!-- plugin_faq_category_faqs.tpl end -->
