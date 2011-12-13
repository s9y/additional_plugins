
<!-- plugin_faq_categories.tpl start -->
<!-- modifications January 2007 to duplicate design of entry page -->

<div class="serendipity_Entry_Date">
     <h3 class="serendipity_date">{$smarty.const.FAQ_NAME}</h3>
     <h4 class="serendipity_title"><a href="#">{$smarty.const.FAQ_CATEGORIES}</a></h4>
     <div class="serendipity_entry">
          <div class="serendipity_entry_body">
               <div id="serendipityFAQNav">
                    <p><a href="{$serendipityBaseURL}">{$smarty.const.ADMIN_FRONTPAGE}</a> &gt; {$smarty.const.FAQ_CATEGORIES}</p>
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
          </div>
     </div>
</div>
<div class='serendipity_entryFooter' style="text-align: center">
</div>
<!-- plugin_faq_categories.tpl end -->