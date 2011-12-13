{* 
 Ein Kommentar mit Smarty
 Wie in PHP wird dieser dann von dem Smarty-System
 ignoriert. Der Browser bekommt dann diesen Kommentar
 auch nicht zu sehen, obwohl er direkt im Template steht.
 file: plugin_eventcal_add.tpl - 2010-07-15, ian 
 *}
 
<!-- plugin_eventcal_add.tpl start -->

<tr>
    <td align="left">
        {if $is_eventcal_add_debug_fda}
        <div id="eventcal_error_surrounder">
            <div class="error_brand">&nbsp;&nbsp;function: {$is_eventcal_add_debug_fda} </div>
        </div>
        {/if}
        
        <form name="eventcalEntry" id="eventcalEntry" method="post" action="{$plugin_eventcal_add_path}{$plugin_eventcal_admin_add_path}">
            <input type="hidden" name="calendar[nomarkup]" value="true" />
            <input type="hidden" name="calendar[eventcalform]" value="true" />
            <input type="hidden" name="calendar[id]" value="{$plugin_eventcal_add_id}" />
            <input type="hidden" name="calendar[ap]" value="{$plugin_eventcal_add_ap}" />
            <input type="hidden" name="calendar[cm]" value="{$plugin_eventcal_add_cm}" />
            <input type="hidden" name="calendar[cy]" value="{$plugin_eventcal_add_cy}" />
            <input type="hidden" name="calendar[ts]" value="{$plugin_eventcal_add_ts}" />
            
            <table class="eventcal_form">
                <tbody>
                <tr class="e0">
                    <th class="eventformtitle">{$CONST.CAL_EVENT_FORM_LEFT_SINGLE}</th>
                    <td class="eventformdesc">
                        <select name="calendar[smonth]">
                            {foreach from=$plugin_eventcal_add_array_opt1 item=i} {if $i} {$i} {/if} {/foreach}
                        </select><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="2" height="2" />
                        <select name="calendar[sday]">
                            {foreach from=$plugin_eventcal_add_array_opt7 item=i} {if $i} {$i} {/if} {/foreach}
                        </select><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="3" height="2" />
                        <select name="calendar[syear]" size="1">
                            {foreach from=$plugin_eventcal_add_array_opt2 item=i} {if $i} {$i} {/if} {/foreach}
                        </select>
                    </td>
                    <td class="eventformdesc">
                        <input type="radio" name="calendar[type]" value="single" {$plugin_eventcal_add_tipo1} /><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="3" height="2" />{$CONST.CAL_EVENT_FORM_RIGHT_SINGLE} <b class="eventcal_reiter">({$CONST.CAL_EVENT_FORM_RIGHT_SINGLE_NOEND})</b> <abbr title="{$CONST.CAL_EVENT_FORM_RIGHT_HELP_SINGLE}"><input type="button" class="serendipityPrettyButton info" name="info" value="i" /></abbr>
                    </td>
                </tr>
                <tr class="e0">
                    <th class="eventformtitle">{$CONST.CAL_EVENT_FORM_LEFT_MULTI}</th>
                    <td class="eventformdesc">
                        <select name="calendar[emonth]">
                            {foreach from=$plugin_eventcal_add_array_opt3 item=i} {if $i} {$i} {/if} {/foreach}
                        </select><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="2" height="2" />
                        <select name="calendar[eday]">
                            {foreach from=$plugin_eventcal_add_array_opt8 item=i} {if $i} {$i} {/if} {/foreach}
                        </select><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="3" height="2" />
                        <select name="calendar[eyear]" size="1">
                            {foreach from=$plugin_eventcal_add_array_opt4 item=i} {if $i} {$i} {/if} {/foreach}
                        </select>
                    </td>
                    <td class="eventformdesc">
                        <input type="radio" name="calendar[type]" value="multi" {$plugin_eventcal_add_tipo2} /><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="3" height="2" />{$CONST.CAL_EVENT_FORM_RIGHT_MULTI} <abbr title="{$CONST.CAL_EVENT_FORM_RIGHT_HELP_MULTI}"><input type="button" class="serendipityPrettyButton info" name="info" value="i" /></abbr>
                    </td>
                </tr>
                <tr class="e0">
                    <th class="eventformtitle">{$CONST.CAL_EVENT_FORM_LEFT_RECUR}</th>
                    <td class="eventformdesc">
                        <select name="calendar[recur]">
                            {foreach from=$plugin_eventcal_add_array_opt5 item=i} {if $i} {$i} {/if} {/foreach}
                        </select>
                        <select name="calendar[recur_day]">
                            {foreach from=$plugin_eventcal_add_array_opt6 item=i} {if $i} {$i} {/if} {/foreach}
                        </select><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="2" height="2" />
                    </td>
                    <td class="eventformdesc">
                        <input type="radio" name="calendar[type]" value="recur" {$plugin_eventcal_add_tipo3} /><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="3" height="2" />{$CONST.CAL_EVENT_FORM_RIGHT_RECUR} <b class="eventcal_reiter">({$CONST.CAL_EVENT_FORM_RIGHT_RECUR_MONTH})</b> <abbr title="{$CONST.CAL_EVENT_FORM_RIGHT_HELP_MONTH}"><input type="button" class="serendipityPrettyButton info" name="info" value="i" /></abbr>
                    </td>
                </tr>
                <tr class="e0">
                    <th class="eventformtitle">&nbsp;</th>
                    <td class="eventformdesc">&nbsp;<sub>{$CONST.CAL_EVENT_FORM_RIGHT_RECURSTRICT1}</sub></td>
                    <td class="eventformdesc">
                        <input type="radio" name="calendar[type]" value="weekly" {$plugin_eventcal_add_tipo4} /><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="3" height="2" />{$CONST.CAL_EVENT_FORM_RIGHT_RECUR} <b class="eventcal_reiter">({$CONST.CAL_EVENT_FORM_RIGHT_RECUR_WEEK})</b> <abbr title="{$CONST.CAL_EVENT_FORM_RIGHT_HELP_WEEK}"><input type="button" class="serendipityPrettyButton info" name="info" value="i" /></abbr>
                    </td>
                </tr>
                <tr class="e0">
                    <th class="eventformtitle">&nbsp;</th>
                    <td class="eventformdesc">&nbsp;<sup>{$CONST.CAL_EVENT_FORM_RIGHT_RECURSTRICT2}</sup></td>
                    <td class="eventformdesc">
                        <input type="radio" name="calendar[type]" value="biweekly" {$plugin_eventcal_add_tipo5} /><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="3" height="2" />{$CONST.CAL_EVENT_FORM_RIGHT_RECUR} <b class="eventcal_reiter">({$CONST.CAL_EVENT_FORM_RIGHT_RECUR_BIWEEK})</b> <abbr title="{$CONST.CAL_EVENT_FORM_RIGHT_HELP_BIWEEK}"><input type="button" class="serendipityPrettyButton info" name="info" value="i" /></abbr>
                    </td>
                </tr>
                <tr class="e0">
                    <th class="eventformtitle">{$CONST.CAL_EVENT_FORM_LEFT_AUTHOR}</th>
                    <td class="eventformdesc">
                        <input type="text" name="calendar[app_by]" value="{$plugin_eventcal_add_app_by}" size='16' maxlength='16' /><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="8" height="2" /><font class="eventcal_reiter">{$CONST.CAL_EVENT_FORM_RIGHT_SHORTMAX}</font>
                    </td>
                    <td class="eventformdesc">
                        <input type="radio" name="calendar[type]" value="yearly" {$plugin_eventcal_add_tipo6} /><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="3" height="2" />{$CONST.CAL_EVENT_FORM_RIGHT_RECUR} <b class="eventcal_reiter">({$CONST.CAL_EVENT_FORM_RIGHT_RECUR_YEAR})</b> <abbr title="{$CONST.CAL_EVENT_FORM_RIGHT_HELP_YEAR}"><input type="button" class="serendipityPrettyButton info" name="info" value="i" /></abbr>
                    </td>
                </tr>
                <tr class="e0">
                    <th class="eventformtitle">{$CONST.CAL_EVENT_FORM_LEFT_TITLE}</th>
                    <td class="eventformdesc">
                        <input type="text" name="calendar[sdesc]" value="{$plugin_eventcal_add_sdesc}" size='16' maxlength='16' /><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="8" height="2" /><font class="eventcal_reiter">{$CONST.CAL_EVENT_FORM_RIGHT_SHORTMAX}</font>
                    </td>
                    <td align="center" class="eventformdesc eventformbutton"><input class="SerendipityPrettyButton" type="submit" value=" {$CONST.CAL_EVENT_FORM_BUTTON_SUBMIT} " name="calendar[new_submit]" /></td>
                </tr>
                <tr class="e0">
                    <th class="eventformtitle">{$CONST.CAL_EVENT_FORM_LEFT_LINK}</th>
                    <td colspan="2" class="eventformdesc eventformlink">
                        <input type="text" name="calendar[url]" size='30' maxlength='128' value="{$plugin_eventcal_add_url}" /><img src="{serendipity_getFile file="img/blank.png"}" alt="blank" border="0" width="3" height="2" /><sub>{$CONST.CAL_EVENT_FORM_RIGHT_URLDESC} </sub><b class="eventcal_reiter">({$CONST.CAL_EVENT_FORM_RIGHT_URL})</b><sub> {$CONST.CAL_EVENT_FORM_RIGHT_OR} </sub><b class="eventcal_reiter">({$CONST.CAL_EVENT_FORM_RIGHT_MAIL})</b>
                    </td>
                </tr>
                <tr class="e0">
                    <th class="eventformtitle">{$CONST.CAL_EVENT_FORM_LEFT_DESC}</th>
                    <td align="left" class="eventformdesc formfield">
                        <textarea name="calendar[ldesc]" id="calendarLdesc" cols='38' rows='10'>{$plugin_eventcal_add_ldesc}</textarea>
                    </td>
                    <td class="eventformdesc"><sup>{$CONST.CAL_EVENT_FORM_RIGHT_DETAILDESC}</sup>
                    {if $is_logged_in}<br /><br /><sup>{$CONST.CAL_EVENT_FORM_RIGHT_BBC}</sup><br />
                        <input type="button" class="serendipityPrettyButton bbc_i" name="insI" value="I" accesskey="i" onclick="wrapSelection(document.forms['eventcalEntry']['calendar[ldesc]'],'[i]','[/i]')" />
                        <input type="button" class="serendipityPrettyButton bbc_b" name="insB" value="B" accesskey="b" onclick="wrapSelection(document.forms['eventcalEntry']['calendar[ldesc]'],'[b]','[/b]')" />
                        <input type="button" class="serendipityPrettyButton bbc_u" name="insU" value="U" accesskey="u" onclick="wrapSelection(document.forms['eventcalEntry']['calendar[ldesc]'],'[u]','[/u]')" />
                        <input type="button" class="serendipityPrettyButton bbc_s" name="insS" value="S" accesskey="s" onclick="wrapSelection(document.forms['eventcalEntry']['calendar[ldesc]'],'[s]','[/s]')" />
                    {/if}
                    </td>
                </tr>
                
                {if !$is_logged_in && $is_show_captcha == true}
                
                <tr class="e0">
                    <th class="eventformtitle">{$CONST.CAL_EVENT_FORM_LEFT_SPAM}</th>
                    <td align="left" colspan="2" class="eventformdesc">
                        <!-- This is where the spamblock/Captcha plugin is called -->
                        {serendipity_hookPlugin hook="frontend_comment" data="$plugin_eventcal_cal_entry"}
                    </td>
                </tr>
                
                {/if}
                </tbody>
            </table>
        </form>
        {if $is_logged_in}
        <script type="text/javascript" language="JavaScript" src="{$serendipityHTTPPath}serendipity_editor.js"></script>
        {/if}
    </td>
</tr>

<!-- plugin_eventcal_add.tpl end -->
