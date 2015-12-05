{* file: plugin_eventcal_app.tpl - 2015-12-04, Ian *}
 
<!-- plugin_eventcal_app.tpl start -->

<tr>
  <td>
{literal}
<script type="text/javascript">
/* <![CDATA[ */
function chkAll(frm, arr, mark) {
  for (i = 0; i <= frm.elements.length; i++) {
   try {
     if(frm.elements[i].name == arr) {
       frm.elements[i].checked = mark;
     }
   } catch (err) {}
  }
}
/* ]]> */
</script>
{/literal}
<form name="checkform" method="post" action="{$plugin_eventcal_app_path}{$plugin_eventcal_admin_add_path}">
    <input type="hidden" name="calendar[nomarkup]" value="true" />
    <input type="hidden" name="calendar[a]" value="{$plugin_eventcal_app_a}" />
    <input type="hidden" name="calendar[cm]" value="{$plugin_eventcal_app_m}" />
    <input type="hidden" name="calendar[cy]" value="{$plugin_eventcal_app_y}" />
    <table class="eventcal_appform">
        <tbody>
        <tr class="f0">
            <th>&nbsp;</th>
            <th class="eventcal_appform_title_lft">{$CONST.CAL_EVENT_FORM_TITLE_DATE}</th>
            <th class="eventcal_appform_title_lft">{$CONST.CAL_EVENT_FORM_TITLE_TITLE}</th>
            <th class="eventcal_appform_title_lft">{$CONST.CAL_EVENT_FORM_TITLE_DESC}</th>
            <th class="eventcal_appform_title_lft">{$CONST.CAL_EVENT_FORM_TITLE_URL}</th>
            <th class="eventcal_appform_title_rgt">{$CONST.CAL_EVENT_FORM_TITLE_OK}</th>
            <th class="eventcal_appform_title_rgt">{$CONST.CAL_EVENT_FORM_TITLE_EDIT}</th>
            <th class="eventcal_appform_title_rgt">{$CONST.CAL_EVENT_FORM_TITLE_DEL}</th>
        </tr>
        {foreach from=$plugin_eventcal_app_array_events item="e"}
        <tr class="{if $plugin_eventcal_app_admin_tipocolor}{if $e.tipo == 1 || $e.tipo == 6}mono{elseif $e.tipo == 2}multi{elseif $e.tipo == 3}recm{elseif $e.tipo == 4 || $e.tipo == 5}recw{/if}{else}f0{/if}">
            <td class="eventcal_appform_validation"><input type="checkbox" name="calendar[entries][]" value="{$e.id}" /></td>
            <td class="eventcal_appform_validation eventcal_appdate">{$e.tipodate}{if $e.tipo == 5} ({$CONST.CAL_EVENT_FORM_RIGHT_RECUR_BIWEEK}){/if}</td>
            <td class="eventcal_appform_validation">{$e.sdesc}</td>
            <td class="eventcal_appform_validation eventcal_appldesc">{$e.ldesc|truncate:63:" [&hellip;]"|strip_tags}{if $e.ldesc|count_characters:true > 63} <abbr title="{$e.ldesc|replace:"\n":" "|strip_tags}"></abbr>{/if}<br />{$CONST.CAL_EVENT_FORM_LEFT_AUTHOR|strip_tags:false}: {$e.app_by}</td>
            <td class="eventcal_appform_validation">{if $e.url} <a href="{$e.url}" target="_blank">go</a>{else}&nbsp;{/if}</td>
            {if $is_eventcal_cal_admin_noapp != true}
            <td class="eventcal_appform_validation">&nbsp;&nbsp;<input type="image" class="eventcal_appform_move" src="{$plugin_eventcal_cal_imgpath}img/notes-approve.gif" name="Approve_Selected" alt="notes-approve" title=" Approve " align="bottom" />&nbsp;&nbsp;</td>
            {else}
            <td class="eventcal_appform_validation">&nbsp;&nbsp;<img class="eventcal_appform_move" src="{$plugin_eventcal_cal_imgpath}img/notes-checkmark.gif" name="Approve_Selected" alt="notes-approve" title=" is approved already - no action " align="bottom" />&nbsp;&nbsp;</td>
            {/if}
            <td class="eventcal_appform_validation">&nbsp;&nbsp;<input type="image" class="eventcal_appform_move" src="{$plugin_eventcal_cal_imgpath}img/notes-change.gif" name="Change_Selected" alt="notes-change" title=" Change " align="bottom" />&nbsp;&nbsp;</td>
            <td class="eventcal_appform_validation">&nbsp;&nbsp;<input type="image" class="eventcal_appform_move" src="{$plugin_eventcal_cal_imgpath}img/notes-delete.gif" name="Reject_Selected" alt="notes-delete" title=" Reject " align="bottom" />&nbsp;&nbsp;</td>
        </tr>
        {/foreach}
        <tr class="f0">
            <td align="left" colspan="8" class="eventcal_appform_validation eventcal_appform_validation_last">
                <input type="checkbox" name="ca" value="1" onclick="chkAll(this.form, 'calendar[entries][]', this.checked)" />{$CONST.CAL_EVENT_FORM_BUTTON_MARK}
            </td>
        </tr>
        </tbody>
    </table>
    </form>
  </td>
</tr>

<!-- plugin_eventcal_app.tpl end -->
