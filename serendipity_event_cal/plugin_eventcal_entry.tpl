{* file: plugin_eventcal_entry.tpl - 2015-12-05, Ian *}
 
<!-- plugin_eventcal_entry.tpl start -->

{if $is_eventcal_entry_debug_fdw}
<tr>
    <td>
        <div id="eventcal_error_surrounder">
            <div class="error_brand">&nbsp;&nbsp;function: {$is_eventcal_entry_debug_fdw} </div>
        </div>
    </td>
</tr>
{/if}

<tr>
    <td>
        <table class="eventtext_entry">
            <tbody>
            <tr>
                <th>{$plugin_eventcal_entry_event.sdesc}</th>
                <td rowspan="{if $is_logged_in}5{else}4{/if}" class="entry">{$plugin_eventcal_entry_ldesc}
                {if $plugin_eventcal_entry_event.url}
                    <br /><b>URL/MAIL</b>: <a href="{$plugin_eventcal_entry_event.url}" target="_blank">{$plugin_eventcal_entry_event.url}</a>
                {/if}</td>
            </tr>
            <tr>
                <th>{$plugin_eventcal_entry_sformat}</th>
            </tr>
            <tr>
                <th>{$plugin_eventcal_entry_event.app_by}</th>
            </tr>
            {if $is_logged_in}
            <tr>
                <th class="entryadmin eventcal_links">
                    <form method="post" name="checkform" action="{$plugin_eventcal_entry_path}{$plugin_eventcal_admin_add_path}">
                      <span class="left">
                        <input type="hidden" name="calendar[entries][]" value="{$plugin_eventcal_entry_event.id}" />
                        <input type="hidden" name="calendar[a]" value="1" />
                        <input type="hidden" name="calendar[cm]" value="{$plugin_eventcal_entry_cm}" />
                        <input type="hidden" name="calendar[cy]" value="{$plugin_eventcal_entry_cy}" />
                        <input type="image" src="{$plugin_eventcal_cal_imgpath}img/notes-change.gif" name="Change_Selected" alt="notes-change" title=" {$CONST.CAL_EVENT_FORM_BUTTON_EDIT_SED} " />
                        <sup>{$CONST.CAL_EVENT_FORM_TITLE_EDIT|nl2br|spacify}</sup>
                      </span>
                    </form>
                    <form method="post" name="checkform" action="{$plugin_eventcal_entry_path}{$plugin_eventcal_admin_add_path}">
                      <span class="right">
                        <sup>{$CONST.CAL_EVENT_FORM_TITLE_DEL|nl2br|spacify}</sup>
                        <input type="hidden" name="calendar[entries][]" value="{$plugin_eventcal_entry_event.id}" />
                        <input type="hidden" name="calendar[a]" value="{$plugin_eventcal_entry_a}" />
                        <input type="hidden" name="calendar[cm]" value="{$plugin_eventcal_entry_cm}" />
                        <input type="hidden" name="calendar[cy]" value="{$plugin_eventcal_entry_cy}" />
                        <input type="image" src="{$plugin_eventcal_cal_imgpath}img/notes-delete.gif" name="Reject_Selected" alt="notes-delete" title=" {$CONST.CAL_EVENT_FORM_BUTTON_REJECT_SED} " />
                      </span>
                    </form>
                </th>
            </tr>
            {/if}
            <tr>
                <th class="eventcal_links center">{if $is_eventcal_ical} <a href="{if $plugin_eventcal_icsdl == 'ud'}{$plugin_eventcal_cal_path}?serendipity[ics_export]=1&amp;calendar[cm]={$plugin_eventcal_cal_m}&amp;calendar[cy]={$plugin_eventcal_cal_y}&amp;calendar[ev]={$plugin_eventcal_entry_event.id|default:0}{else}{$serendipityHTTPPath}plugin/ics_export/{$plugin_eventcal_entry_event.id|default:0}/{$plugin_eventcal_cal_m}/{$plugin_eventcal_cal_y}/{$plugin_eventcal_icsdl}{/if}" target="_{if $plugin_eventcal_icsdl == 'wc'}blank{else}self{/if}"><img src="{$plugin_eventcal_cal_imgpath}img/icalw.png" alt="ical single feed" /></a>{else}&nbsp;{/if}</th>
            </tr>
            </tbody>
        </table>
    </td>
</tr>

<!-- plugin_eventcal_entry.tpl end -->
