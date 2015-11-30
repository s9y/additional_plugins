{* file: plugin_eventcal_cal.tpl - 2011-01-19, Ian *}

{if $is_eventcal_articleformat == true}
<div class="serendipity_Entry_Date">
  <h3 class="serendipity_date">{$CONST.PLUGIN_EVENTCAL_TITLE}</h3>
  {if $is_eventcal_headline == true}
  <h4 class="serendipity_title"><a href="{$plugin_eventcal_permalink}">{$plugin_eventcal_headline}</a></h4>
  {/if}

  <div class="serendipity_entry">
    <div class="serendipity_entry_body">
{/if}
      <br class="clear" />
      <div {if $plugin_eventcal_admin_add_path}class="ec_backend_table"{else}id="eventcal_wrapper"{/if}>
      
<!-- plugin_eventcal_cal.tpl start -->

{if $plugin_eventcal_cal_preface}
<div class="eventcal_intro">{$plugin_eventcal_cal_preface}</div>
{/if}

{if $is_eventcal_error}{if $is_eventcal_cal_admin_clear == true}<br />{/if}
<div class="serendipity_center eventcal_tpl_error">
    <div class="eventcal_tpl_error_inner">{$plugin_eventcal_error}</div>
</div>
{/if}

{if $is_eventcal_message}
<div class="serendipity_center eventcal_tpl_message">
    <div class="serendipity_center serendipity_msg_notice msg_notice">{$plugin_eventcal_cal_admin}</div>
    {foreach from=$plugin_eventcal_message item=message}
    <div class="eventcal_tpl_message_inner serendipity_msg_hint">{$message}</div>
    {/foreach}
</div>
{/if}

{if $admin_delete == true}
<div class="serendipity_center eventcal_tpl_message">
    <div class="eventcal_tpl_message_inner">{$CONST.CAL_EVENT_USER_FREE_SURE}<br /><br />
        <a href="{$admin_url}" class="serendipityPrettyButton">{$CONST.NOT_REALLY}</a>
        <a href="{$admin_target}" class="serendipityPrettyButton">{$CONST.DUMP_IT}</a><br /><br />
    </div>
</div>
{/if}

{if $admin_dodelete == true && $rip_entry}
    <div class="serendipity_center">{$rip_entry}</div>
{/if}


{if $is_eventcal_cal_debug_fdc}
    <div id="eventcal_error_surrounder">
        <div class="error_brand">&nbsp;&nbsp;function: {$is_eventcal_cal_debug_fdc} </div>
    </div>
{/if}

{if $is_eventcal_cal_debug_fcwe}
    <div id="eventcal_error_surrounder">
        <div class="error_brand">&nbsp;&nbsp;function: {$is_eventcal_cal_debug_fcwe} </div>
    </div>
{/if}

{if $is_eventcal_cal_debug_fs1}
    <div id="eventcal_error_surrounder">
        <div class="error_brand">&nbsp;&nbsp;function: {$is_eventcal_cal_debug_fs1} </div>
    </div>
{/if}

{if $is_eventcal_icalswitch == true}
<div class="serendipity_center eventcal_tpl_message">
    <div class="eventcal_tpl_message_inner">{$CONST.PLUGIN_EVENTCAL_ICAL_ICSURL_BLAH}<br /><br />
        <table align="center" class="questionaire">
         <tbody>
          <tr>
            {foreach key="icsktype" item="icsvtype" from=$plugin_eventcal_ical_types}
            <th>
                <form name="checkform" method="post" action="{$plugin_eventcal_cal_path}">
                    <input type="hidden" name="calendar[icseptarget]" value="{$serendipityHTTPPath}plugin/ics_export/{$plugin_eventcal_ical_id|default:0}/{$plugin_eventcal_ical_m}/{$plugin_eventcal_ical_y}/{$icsktype}/" />
                    {if $icsktype == 'ml'}
                    To: {$CONST.EMAIL} <input type="text" name="calendar[icstomail]" value="" />
                    <input type="submit" value="send as email" />
                    {else}
                    <input type="submit" value="{$icsvtype}" />
                    {/if}
                </form>
            </th>
            {/foreach}
          </tr>
         </tbody>
        </table>
    </div>
</div>
{/if}{* icalswitch end *}

<table align="left" class="eventborder">
 <tbody>
{if $plugin_eventcal_cal_monthviewnav}
<!-- navigation buttons in monthview start -->
 <tr>
  <th align="center">
        <table class="eventcal_monthbutton">
            <tbody>
            <tr>
                <td class="left" align="left">
                    <form method="post" action="{$plugin_eventcal_cal_path}">
                    <input type="hidden" name="calendar[nomarkup]" value="true" />
                    <input type="hidden" name="calendar[a]" value="{$plugin_eventcal_cal_a}" />
                    <input type="hidden" name="calendar[ap]" value="{$plugin_eventcal_cal_ap}" />
                    <input type="hidden" name="calendar[cm]" value="{$plugin_eventcal_cal_pm}" />
                    <input type="hidden" name="calendar[cy]" value="{$plugin_eventcal_cal_py}" />
                    <input type="submit" name="calendar[monthback]" value="{$plugin_eventcal_cal_back}" />
                    </form>
                </td>
                {if $plugin_eventcal_cal_sedweek}
                <td class="mid" align="center">
                    <form method="post" action="{$plugin_eventcal_cal_path}">
                    <input type="hidden" name="calendar[nomarkup]" value="true" />
                    <input type="hidden" name="calendar[a]" value="{$plugin_eventcal_cal_a}" />
                    <input type="hidden" name="calendar[ap]" value="{$plugin_eventcal_cal_ap}" />
                    <input type="hidden" name="calendar[cm]" value="{$plugin_eventcal_cal_m}" />
                    <input type="hidden" name="calendar[cy]" value="{$plugin_eventcal_cal_y}" />
                    <input type="submit" name="calendar[monthnext]" value="{$plugin_eventcal_cal_cmonth}" />
                    </form>
                </td>
                {else}
                <td class="mid" align="center"><b>{$plugin_eventcal_cal_cmonth}</b></td>
                {/if}
                <td class="right" align="right">
                    <form method="post" action="{$plugin_eventcal_cal_path}">
                    <input type="hidden" name="calendar[nomarkup]" value="true" />
                    <input type="hidden" name="calendar[a]" value="{$plugin_eventcal_cal_a}" />
                    <input type="hidden" name="calendar[ap]" value="{$plugin_eventcal_cal_ap}" />
                    <input type="hidden" name="calendar[cm]" value="{$plugin_eventcal_cal_nm}" />
                    <input type="hidden" name="calendar[cy]" value="{$plugin_eventcal_cal_ny}" />
                    <input type="submit" name="calendar[monthnext]" value="{$plugin_eventcal_cal_next}" />
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
  </th>
 </tr>
 <!-- navigation buttons in monthview end -->
{/if}{* monthviewnav end *}

{if $is_eventcal_cal_admin_clear != true}
<tr>
  <td>
  {if $plugin_eventcal_cal_sed}
    <!--- TABLE eventcal START -->
      <table class="innereventborder">
        <thead>
        <tr>
            <th class="a0"></th>
            <!--build weekdaynames start -->
            
            {foreach item=r from=$plugin_eventcal_cal_sed}
            <th class="a0 eventcal_weekhead">{$r.head}</th>
            {/foreach}
        
            <!--build weekdaynames end -->
        </tr>
        </thead>
        
        <tbody>
       {foreach from=$plugin_eventcal_cal_sed item="week"}
        {if $week.days}
        <!-- eventcal table row start -->
        <tr>
        
            <!-- build calendar week number {$week.cwnm} start -->
            <td class="eventcal_week_cw rec0" align="left">
                <a href="{$plugin_eventcal_cal_path}{$eventcal_permalink_add}calendar[cm]={$plugin_eventcal_cal_m}&amp;calendar[cy]={$plugin_eventcal_cal_y}&amp;calendar[cw]={$week.cwnm}">{$week.cwnm}</a>
            </td>
            <!-- build calendar week number {$week.cwnm} end -->
            
            {foreach from=$week.days item="day"}
            
            <td class="eventcal_day eventcal_{$day.bcol} eventcal_lft{cycle values=" rec1, rec2, rec3, rec4, rec5, rec6, rec7"}">
                <table class="eventcal_{$day.col}">
                    <tbody>
                    <tr>
                        <td class="eventcal_{$day.col} eventcal_lft">{if $day.today == 'today'}<div class="eventcal_todaycell">{$CONST.CAL_EVENT_TODAY}</div>{elseif $day.today == 'blank'} {else}&nbsp;{/if}</td>
                        <td class="eventcal_{$day.col} eventcal_rgt">{$day.label|default:'&nbsp;'}</td>
                    </tr>
                    <tr>
                        <td class="eventcal_{$day.col} eventcal_lft" colspan="2">{if !$day.arrdata}&nbsp;{/if}
                        
                        {foreach from=$day.arrdata item=r}{* start=1 *}
                        
                            <span{if $r.tipo == 1 || $r.tipo == 6} class="mono{elseif $r.tipo == 2} class="multi{elseif $r.tipo == 3} class="recm{elseif $r.tipo == 4 || $r.tipo == 5} class="recw{/if} eventtype">
                                <a class="small_eventcal_link" href="{$plugin_eventcal_cal_path}{$eventcal_permalink_add}calendar[a]={$r.a}&amp;calendar[ap]={$r.ap}&amp;calendar[cm]={$r.m}&amp;calendar[cy]={$r.y}&amp;calendar[ev]={$r.id}" title="open event entry {$r.sdesc}"><b class="eventcal_tab">{$r.sdesc}</b></a><br />
                            </span>
                        {/foreach}
                        
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
            {/foreach}
        </tr>
        <!-- eventcal table row end -->        
        {/if}    
        {/foreach}
        </tbody>
    </table>
    <!-- TABLE eventcal END -->
    {/if}{* sed end *}
    
    {* now we include the weekly event table if there is - plugin_eventcal_calweek.tpl *}
        
    {if $plugin_eventcal_cal_buildweektable}
        {$plugin_eventcal_cal_buildweektable}
    {/if}
    
  </td>
</tr>
{/if}{* admin clear end *}
    
    {*    now we include the separate build single event day entry - plugin_eventcal_entry.tpl *}
    
    {if $plugin_eventcal_cal_buildsetable}
        {$plugin_eventcal_cal_buildsetable}
    {/if}
        
    {*    now we include the the open/close form button and the open/close lookout for unapproved events table *}
    
    {if $is_eventcal_cal_buildbuttons == true}
    
    {if $is_eventcal_cal_buildbuttonadd == true}
    {if $is_eventcal_cal_admin_clear != true}
    <!-- open form button start -->
    <tr>
        <th align="left" class="eventcal_button">
            <a href="{$plugin_eventcal_cal_path}{$eventcal_permalink_add}calendar[a]={if $plugin_eventcal_cal_a}0{else}1{/if}&amp;calendar[ap]={$plugin_eventcal_cal_ap}&amp;calendar[cm]={$plugin_eventcal_cal_m}&amp;calendar[cy]={$plugin_eventcal_cal_y}"><img src="{$plugin_eventcal_cal_imgpath}{if $plugin_eventcal_cal_a==1}img/notes-reject.gif{else}img/notes-add.gif{/if}" alt="notes-add-reject" border="0" title="{if $plugin_eventcal_cal_a}{$CONST.CAL_EVENT_FORM_BUTTON_CLOSE}{else}{$CONST.CAL_EVENT_FORM_BUTTON_OPEN}{/if}" /></a>
            <b class="eventcal_tab"> {$CONST.CAL_EVENT_FORM_BUTTON_ADD_EVENT}</b>
        </th>
    </tr>
    <!-- open form button end -->
    {/if}{* admin clear end *}
    
    {*    now we include the open form table - plugin_eventcal_add.tpl *}
    
    {if $plugin_eventcal_cal_buildaddtable}
        {$plugin_eventcal_cal_buildaddtable}
    {/if}
    
    {/if}{* buildbuttonadd end *}
    
    {if $is_eventcal_cal_buildbuttonapp == true}
    {if $is_eventcal_cal_admin_clear != true}
    <!-- unapproved event table button start -->
    <tr>
        <th align="left" class="eventcal_button">
            <a href="{$plugin_eventcal_cal_path}{$eventcal_permalink_add}calendar[ap]={if $plugin_eventcal_cal_ap}0{else}1{/if}&amp;calendar[a]={$plugin_eventcal_cal_a}&amp;calendar[cm]={$plugin_eventcal_cal_m}&amp;calendar[cy]={$plugin_eventcal_cal_y}"><img src="{$plugin_eventcal_cal_imgpath}{if $plugin_eventcal_cal_ap==1}img/notes-reject.gif{else}img/notes-add.gif{/if}" border="0" alt="notes-add-reject" title="{if $plugin_eventcal_cal_ap}{$CONST.CAL_EVENT_FORM_BUTTON_CLOSE}{else}{$CONST.CAL_EVENT_FORM_BUTTON_OPEN}{/if}" /></a>
            <b class="eventcal_tab"><span class="eventcal_tab_dim">{$CONST.CAL_EVENT_FORM_BUTTON_APPROVE_EVENT} [ </span>{$plugin_eventcal_cal_crs} <span class="eventcal_tab_dim">{$CONST.CAL_EVENT_FORM_BUTTON_TOAPPROVE} ]</span></b>
        </th>
    </tr>
    <!-- unapproved event table button end -->
    {/if}{* admin clear end *}
    
    {* now we include the lookout for unapproved events table - plugin_eventcal_app.tpl *}
    
    {if $plugin_eventcal_cal_buildapptable}
        {$plugin_eventcal_cal_buildapptable}
    {/if}
    
    {/if}{* buildbuttonapp end *}
    
    {/if}{* buildbuttons end *}
    
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tbody>
                <tr>
                    <td class="eventcal_helptip"><span class="mono tip"> Single Events </span></td>
                    <td class="eventcal_helptip"><span class="multi tip"> Multi Events </span></td>
                    <td class="eventcal_helptip"><span class="recm tip"> Monthly Events </span></td>
                    <td class="eventcal_helptip"><span class="recw tip"> Weekly Events </span></td>
                    {if $is_eventcal_ical && !$plugin_eventcal_cal_sedweek}
                    {* now we create the monthly ical link, depending on config settings *}
                    {if $plugin_eventcal_icsdl == 'ud'}
                    <td class="eventcal_ical"><a href="{$plugin_eventcal_cal_path}?serendipity[ics_export]=1&amp;calendar[cm]={$plugin_eventcal_cal_m}&amp;calendar[cy]={$plugin_eventcal_cal_y}" target="_{if $plugin_eventcal_icsdl == 'wc'}blank{else}self{/if}"><img src="{$plugin_eventcal_cal_imgpath}img/icalm.png" alt="ical month feed" title="{$CONST.CAL_EVENT_FORM_BUTTON_HELP_ICALM}" /></a></td>
                    {else}
                    <td class="eventcal_ical"><a href="{$serendipityHTTPPath}plugin/ics_export/0/{$plugin_eventcal_cal_m}/{$plugin_eventcal_cal_y}/{$plugin_eventcal_icsdl}" target="_{if $plugin_eventcal_icsdl == 'wc'}blank{else}self{/if}"><img src="{$plugin_eventcal_cal_imgpath}img/icalm.png" alt="ical month feed" title="{$CONST.CAL_EVENT_FORM_BUTTON_HELP_ICALM}" /></a></td>
                    {/if}
                    {/if}
                    
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    {* placeholder admin links *}
 </tbody>
</table>

<!-- plugin_eventcal_cal.tpl end -->

      </div> <!-- eventcal_wrapper end -->
      <br class="clear" />
{if $is_eventcal_articleformat == true}
    </div> <!-- serendipity_entry_body -->
  </div> <!-- serendipity_entry -->
</div> <!-- serendipity_Entry_Date -->
{/if}{* articleformat end *}