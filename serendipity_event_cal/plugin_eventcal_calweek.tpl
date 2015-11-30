{* file: plugin_eventcal_calweek.tpl - 2010-02-08, Ian *}
   
  {if $plugin_eventcal_cal_sedweek}
  
  <!-- plugin_eventcal_calweek.tpl start -->

    {* navigate through this months calendar weeks only *}

    <table class="eventcal_weeknav eventcal_weeknav_top">
        <tbody>
        <tr class="d0">
            <td class="eventcal_weeknav eventcal_rgt">{* cwnm gt = greater than in php write > cwnm_first *}
                {if $plugin_eventcal_cal_sedweek.0.cwnm gt $plugin_eventcal_cal_sedweek.0.cwnm_first}
                
                <form method="post" action="{$plugin_eventcal_cal_path}">
                    <input type="hidden" name="calendar[cm]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_m}" />
                    <input type="hidden" name="calendar[cy]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_y}" />
                    <input type="hidden" name="calendar[cw]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_prev}" />
                    <input type="hidden" name="calendar[cw_prev]" value="true" />
                    <input name="calendar[weekback]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_prev} &laquo;&laquo; {$CONST.PREVIOUS}" type="submit" />
                </form>
                {/if}
                
            </td>
            <td class="eventcal_weekly_title">{$CONST.PLUGIN_EVENTCAL_TEXT_CW}&#8470;: {$plugin_eventcal_cal_sedweek.0.cwnm}<br />{$plugin_eventcal_cal_cmonth}</td>
            <td class="eventcal_weeknav eventcal_lft">{* cwnm_month eq = equal in php write == eventcal_month *}
                {if $plugin_eventcal_cal_sedweek.0.cwnm_m eq $plugin_eventcal_cal_m}
                
                <form method="post" action="{$plugin_eventcal_cal_path}">
                    <input type="hidden" name="calendar[cm]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_m}" />
                    <input type="hidden" name="calendar[cy]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_y}" />
                    <input type="hidden" name="calendar[cw]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_next}" />
                    <input type="hidden" name="calendar[cw_next]" value="true" />
                    <input name="calendar[weekback]" value="{$CONST.NEXT} &raquo;&raquo; {$plugin_eventcal_cal_sedweek.0.cwnm_next}" type="submit" />
                </form>
                {/if}
                
            </td>
        </tr>
        </tbody>
    </table>
    
    <!--- table eventcal weekview start -->
    <table class="innereventborder">
        <tbody>
    
    {foreach from=$plugin_eventcal_cal_sedweek.0.days item=day name=weeknum}

    <!-- {$smarty.foreach.weeknum.iteration}. Weekday start -->

    {if $plugin_eventcal_cal_sedweek.0.cwnm_days[$smarty.foreach.weeknum.iteration] != 0}
    <!-- set weekday {$smarty.foreach.weeknum.iteration} header start -->
        <tr class="a0">
            <td colspan="8" class="eventcal_weekly_daytitel">{$CONST.PLUGIN_EVENTCAL_TEXT_CW}&#8470;: {$plugin_eventcal_cal_sedweek.0.cwnm} :: {$plugin_eventcal_cal_sedweek.0.head[$smarty.foreach.weeknum.iteration]}, {if $plugin_eventcal_cal_sedweek.0.cwnm_days[$smarty.foreach.weeknum.iteration] le $plugin_eventcal_cal_sedweek.0.cwnm_lastday}{$plugin_eventcal_cal_sedweek.0.cwnm_days[$smarty.foreach.weeknum.iteration]}{/if}</td>
        </tr>
    <!-- set weekday {$smarty.foreach.weeknum.iteration} header end -->
    {/if}
  
        {if $day.arrdata}
        {foreach from=$day.arrdata item=ad name=daynum}

        <tr class="f0">
            <td class="eventcal_weekly_eventlabel">{$smarty.foreach.daynum.iteration}</td>
            <td class="eventcal_weekly_eventtitle" colspan="3"><strong>{$ad.sdesc}</strong></td>
            <td class="eventcal_weekly_eventical eventcal_ical">{if $is_eventcal_ical} <a href="{if $plugin_eventcal_icsdl == 'ud'}{$plugin_eventcal_cal_path}?serendipity[ics_export]=1&amp;calendar[cm]={$plugin_eventcal_cal_m}&amp;calendar[cy]={$plugin_eventcal_cal_y}&amp;calendar[ev]={$ad.id}{else}{$serendipityHTTPPath}plugin/ics_export/{$ad.id}/{$plugin_eventcal_cal_m}/{$plugin_eventcal_cal_y}/{$plugin_eventcal_icsdl}{/if}" target="_{if $plugin_eventcal_icsdl == 'wc'}blank{else}self{/if}"><img src="{$plugin_eventcal_cal_imgpath}img/icalw.png" alt="ical single feed" /></a>{else}&nbsp;{/if}</td>
            <td colspan="2" class="eventcal_weekly_eventdate{if $ad.tipo == 1 || $ad.tipo == 6} mono{elseif $ad.tipo == 2} multi{elseif $ad.tipo == 3} recm{elseif $ad.tipo == 4 || $ad.tipo == 5} recw{/if}">{$ad.sdato}{if $ad.tipo > 1  }{if $ad.tipo == 6} {$CONST.PLUGIN_EVENTCAL_TEXT_INTERVAL}: {$CONST.PLUGIN_EVENTCAL_TEXT_YEARLY}{else} {$CONST.PLUGIN_EVENTCAL_TEXT_TO} {$ad.edato}{/if}{if $ad.tipo == 5} {$CONST.PLUGIN_EVENTCAL_TEXT_INTERVAL}: {$CONST.PLUGIN_EVENTCAL_TEXT_BIWEEK}{/if}{/if}</td>
            <td class="eventcal_weekly_eventappby">{$ad.app_by}</td>
        </tr>
  
        <tr class="f0">
            <td class="eventcal_weekly_eventlabel"></td>
            <td class="eventcal_weekly_eventtext" colspan="7">{$ad.ldesc|nl2br}{if $ad.url}<div class="eventcal_weekly_eventurl"><a href="{$ad.url}" target="_blank" title="{$ad.url}">&laquo; EVENT-URL &raquo;</a></div>{/if}</td>
        </tr>
  
        <tr class="a0">
            <td width="100%" colspan="8"></td>
        </tr>

        {/foreach}
        {else}
        
        <tr class="a0">
            <td width="100%" colspan="8"></td>
        </tr>
        
        {/if}
        
    <!-- {$smarty.foreach.weeknum.iteration}. Weekday end -->
    
    {/foreach}
    
        <tr class="d0">
            <td width="100%" colspan="8">
                <table class="eventcal_weeknav">
                    <tbody>
                    <tr>
                        <td class="eventcal_weeknav eventcal_rgt">{* cwnm gt = greater than in php write > cwnm_first *}
                        {if $plugin_eventcal_cal_sedweek.0.cwnm gt $plugin_eventcal_cal_sedweek.0.cwnm_first}
                            
                            <form method="post" action="{$plugin_eventcal_cal_path}">
                                <input type="hidden" name="calendar[cm]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_m}" />
                                <input type="hidden" name="calendar[cy]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_y}" />
                                <input type="hidden" name="calendar[cw]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_prev}" />
                                <input type="hidden" name="calendar[cw_prev]" value="true" />
                                <input name="calendar[weekback]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_prev} &laquo;&laquo; {$CONST.PREVIOUS}" type="submit" />
                            </form>
                        {/if}
                        
                        </td>
                        <td class="eventcal_weekly_title">{$CONST.PLUGIN_EVENTCAL_TEXT_CW}&#8470;: {$plugin_eventcal_cal_sedweek.0.cwnm}<br />{$plugin_eventcal_cal_cmonth}</td>
                        <td class="eventcal_weeknav eventcal_lft">{* cwnm_month eq = equal in php write == eventcal_month *}
                        {if $plugin_eventcal_cal_sedweek.0.cwnm_m eq $plugin_eventcal_cal_m}
                            
                            <form method="post" action="{$plugin_eventcal_cal_path}">
                                <input type="hidden" name="calendar[cm]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_m}" />
                                <input type="hidden" name="calendar[cy]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_y}" />
                                <input type="hidden" name="calendar[cw]" value="{$plugin_eventcal_cal_sedweek.0.cwnm_next}" />
                                <input type="hidden" name="calendar[cw_next]" value="true" />
                                <input name="calendar[weekback]" value="{$CONST.NEXT} &raquo;&raquo; {$plugin_eventcal_cal_sedweek.0.cwnm_next}" type="submit" />
                            </form>
                        {/if}
                        
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        
    {* now build the selected week like it is in month table *}
        
        <tr class="a0">
        <!--build weekdaynames start  -->
        <th class="a0"></th>
        {foreach from=$plugin_eventcal_cal_sedweek.0.head item=r}
            <th class="a0 eventcal_weekhead">{$r}</th>
        {/foreach}
        <!--build weekdaynames end -->
        </tr>
        {foreach from=$plugin_eventcal_cal_sedweek item="week"}
        {if $week.days}
        <!-- eventcal table row start -->
        <tr class="a0">
        
        <!-- build calendar week number {$week.cwnm} start -->
            <td class="eventcal_week_cw weekcw rec0" align="left">
                <a href="{$plugin_eventcal_cal_path}{$eventcal_permalink_add}calendar[cy]={$week.cwnm_y}&amp;calendar[cw]={$week.cwnm}">{$week.cwnm}</a>
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
                        
                    {foreach from=$day.arrdata item=r start=1}
                    
                            <span class="{if $r.tipo == 1 || $r.tipo == 6}mono{elseif $r.tipo == 2}multi{elseif $r.tipo == 3}recm{elseif $r.tipo == 4 || $r.tipo == 5}recw{/if} eventtype">
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
    
    <!-- table eventcal weekview end -->
    
    <!-- plugin_eventcal_calweek.tpl end -->
    
    {/if}
