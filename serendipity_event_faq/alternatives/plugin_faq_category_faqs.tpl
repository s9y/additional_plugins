
<!-- plugin_faq_category_faqs.tpl start -->
<!-- modifications January 2007 to duplicate design of entry page -->
<!-- modifications September 2016 for Smarty3 usage - though not being futher touched compared with the new plugin frontend template file modifications -->

<div class="serendipity_Entry_Date">
     <h3 class="serendipity_date">{$CONST.FAQ_NAME}</h3>
     <h4 class="serendipity_title"><a href="#">{$faq_plugin.category}</a></h4>
     <div class="serendipity_entry">
          <div class="serendipity_entry_body">
               <div id="serendipityFAQNav">
                    <p><a href="{$serendipityBaseURL}">{$CONST.ADMIN_FRONTPAGE}</a> &gt; <a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}">{$CONST.FAQ_CATEGORIES}</a>
                         {foreach $cat_tree AS $cat} &gt;
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
          {foreach $faq_plugin.subcategories AS $subcat}
               <li><a href="{$serendipityBaseURL}{$faq_plugin.plugin_url}/{$subcat.id}">{$subcat.category}</a></li>
          {/foreach}
     </ul>
{/if}

{if is_array($faq_plugin.faqs)}
     <ul>
          {foreach $faq_plugin.faqs AS $faq}
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
