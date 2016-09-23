
<!-- plugin_faq_categories.tpl start -->
<!-- modifications January 2007 to duplicate design of entry page -->
<!-- modifications September 2016 for Smarty3 usage - though not being futher touched compared with the new plugin frontend template file modifications -->

<div class="serendipity_Entry_Date">
     <h3 class="serendipity_date">{$CONST.FAQ_NAME}</h3>
     <h4 class="serendipity_title"><a href="#">{$CONST.FAQ_CATEGORIES}</a></h4>
     <div class="serendipity_entry">
          <div class="serendipity_entry_body">
               <div id="serendipityFAQNav">
                    <p><a href="{$serendipityBaseURL}">{$CONST.ADMIN_FRONTPAGE}</a> &gt; {$CONST.FAQ_CATEGORIES}</p>
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
     </div>
</div>
<div class='serendipity_entryFooter' style="text-align: center">
</div>
<!-- plugin_faq_categories.tpl end -->