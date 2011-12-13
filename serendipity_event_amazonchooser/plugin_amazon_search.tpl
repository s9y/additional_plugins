<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_MEDIA_BUTTON}</title>
        <meta http-equiv="Content-Type" content="text/html; charset={$CONST.LANG_CHARSET}" />
        <link rel="stylesheet" type="text/css" href="{$plugin_amazonchooser_css}" />
        <script type="text/javascript" src="{$plugin_amazonchooser_js}"></script>
    </head>

    <body id="serendipity_admin_page">
        <div id="serendipityAdminMainpane">
            <h2>{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_MEDIA_BUTTON}</h2>
            <div class="serendipityAdminContent">
            <div class="serendipity_amazonchr_body_list">
            {if $plugin_amazonchooser_page eq 'Search'}
              {if ($plugin_amazonchooser_item_count gt 0) and ($plugin_amazonchooser_return_count gt 0)}
                  <input type="button" class="serendipityPrettyButton input_button"  value="{$CONST.BACK}" onclick=window.location.href="{$plugin_amazonchooser_search_url}" />
                    <div class="serendipity_amazonchr_body_count">
                       <span class="serendipity_amazonchr_pagecount">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_DISPLAYING} {$CONST.PLUGIN_EVENT_AMAZONCHOOSER_PAGE} {$plugin_amazonchooser_currentpage} {$CONST.PLUGIN_EVENT_AMAZONCHOOSER_OF} {$plugin_amazonchooser_totalpages} {$CONST.PLUGIN_EVENT_AMAZONCHOOSER_PAGES} ({$CONST.PLUGIN_EVENT_AMAZONCHOOSER_PAGELIMIT}).</span>
                    </div>
                    <div class="serendipity_amazonchr_page_buttons">
                       {if isset($plugin_amazonchooser_previouspage)}
                       <span class="serendipity_amazonchr_nextbutton"><input type="button" class="serendipityPrettyButton input_button"  value="{$CONST.PREVIOUS}" onclick=window.location.href="{$plugin_amazonchooser_this_url}{$plugin_amazonchooser_previouspage}" /></span>
                       {/if}
                       {if isset($plugin_amazonchooser_nextpage)}
                       <span class="serendipity_amazonchr_previousbutton"><input type="button" class="serendipityPrettyButton input_button"  value="{$CONST.NEXT}" onclick=window.location.href="{$plugin_amazonchooser_this_url}{$plugin_amazonchooser_nextpage}" /></span>
                       {/if}
                    </div>
                 {foreach from=$plugin_amazonchooser_items item=thingy}
                    {include file=$plugin_amazonchooser_displaytemplate } 
                 {/foreach}
                    <div class="serendipity_amazonchr_page_buttons">
                       {if isset($plugin_amazonchooser_previouspage)}
                       <span class="serendipity_amazonchr_nextbutton"><input type="button" class="serendipityPrettyButton input_button"  value="{$CONST.PREVIOUS}" onclick=window.location.href="{$plugin_amazonchooser_this_url}{$plugin_amazonchooser_previouspage}" /></span>
                       {/if}
                       {if isset($plugin_amazonchooser_nextpage)}
                       <span class="serendipity_amazonchr_previousbutton"><input type="button" class="serendipityPrettyButton input_button"  value="{$CONST.NEXT}" onclick=window.location.href="{$plugin_amazonchooser_this_url}{$plugin_amazonchooser_nextpage}" /></span>
                       {/if}
                    </div>
                    </div>
             {else}
                 <br />
                 <br />
                 <div>
                 <span>{$plugin_amazonchooser_error_message}</span>
                 <br />
                 <span>{$plugin_amazonchooser_error_result}</span>
                 </div>
                 <br />
              {/if}
              <div class="serendipity_amazonchr_body_list">
                  <input type="button" class="serendipityPrettyButton input_button"  value="{$CONST.BACK}" onclick=window.location.href="{$plugin_amazonchooser_search_url}" />              </div>
            {elseif $plugin_amazonchooser_page eq 'Lookup'}
              {if ($plugin_amazonchooser_item_count == 1 and $plugin_amazonchooser_return_count == 1) }
                    <h3>{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_CHOSE} - {$thingy.strings.title}</h3>
                       {include file=$plugin_amazonchooser_displaytemplate }  
                    <form action="#" method="get" name="serendipity[selForm]" >
                        <input type="hidden" name="asin" value="{$thingy.strings.ASIN}" />
                        <input type="hidden" name="searchmode" value="{$plugin_amazonchooser_searchmode}" />

                        <div>
                           <input type="button" class="serendipityPrettyButton input_button"  value="{$CONST.BACK}" onclick="history.go(-1);" />
                        {if ($plugin_amazonchooser_simple == '1') }
                           <input type="button" class="serendipityPrettyButton input_button"  value="{$CONST.DONE}" onclick="serendipity_amazonSelector_simpledone('{$plugin_amazonchooser_txtarea}')"/>
                        {else}
                           <input type="button" class="serendipityPrettyButton input_button"  value="{$CONST.DONE}" onclick="serendipity_amazonSelector_done('{$plugin_amazonchooser_txtarea}')"/>
                        {/if}
                        </div>
                    </form>
             {else}
            <h3><{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_CHOSE}</h3>
                 <br />
                 <br />
                 <div>
                    <span>{$plugin_amazonchooser_error_message}</span>
                    <br />
                    <span>{$plugin_amazonchooser_error_result}</span>
                 </div>
                 <input type="button" class="serendipityPrettyButton input_button"  value="{$CONST.BACK}" onclick="history.go(-1);" />

                 <br />
              {/if}

            {else}
               {$CONST.PLUGIN_EVENT_AMAZONCHOOSER_SEARCH_DESC}
               <div>
                <form name="serendipity[selForm]" onsubmit="serendipity_amazonSelector_next(); return false;" >
                   <input type="hidden" name="step"  value="1" />
                   <input type="hidden" name="url"  value="{$plugin_amazonchooser_link}" />
                   <input type="hidden" name="txtarea"  value="{$plugin_amazonchooser_txtarea}" />
                   <input type="hidden" name="simple" value="{$plugin_amazonchooser_simple}" />
                   <select name="mode">
                        {foreach from=$plugin_amazonchooser_mode key=type item=mode_names}
                          {if $plugin_amazonchooser_defaultmode eq $type}
                          <option value="{$type}" selected="selected">{$mode_names}
                          {else}
                          <option value="{$type}">{$mode_names}
                          {/if}
                        {/foreach}
                    </select>
                   
                   <div><input class="input_textbox" type="text" name="keyword" value="{$plugin_amazonchooser_keyword}"/>    <br />
                   <input type="button" class="serendipityPrettyButton input_button"  value="{$CONST.SEARCH}" onclick="serendipity_amazonSelector_next()" /></div>
                 </form>
               </div>
            {/if}
          </div>
          </div>
         </div>
    </body>
</html>
