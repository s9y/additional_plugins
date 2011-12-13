<h3>{$CONST.USERCONF_GROUPS}</h3>

<div>
<form action="?" method="get">
    <input type="hidden" name="serendipity[subpage]" value="userprofiles" />
    <select name="serendipity[groupid]">
    {foreach from=$userprofile_groups item="group"}
    <option value="{$group.id}" {if $selected_group == $group.id}selected="selected"{/if}>{$group.name|@escape}</option>
    {/foreach}
    </select> <input type="submit" name="submit" value="{$CONST.GO}" />
</form>
</div>

{if $selected_group > 0}
<div>
    <h4>{$selected_group_data.name|@escape}</h4>
    <table>
        <tr>
            <th>{$CONST.USERNAME}</th>
            <th>{$CONST.ENTRIES}</th>
            <th>{$CONST.USERCONF_REALNAME}</th>
            <th>E-Mail</th>
        </tr>
        
        {foreach from=$selected_members item="member}
        <tr>
            <td>{$member.username}</td>
            <td>{$member.posts}</td>
            <td>{$member.realname}</td>
            <td>{$member.email}</td>
        </tr>
        {/foreach}
    </table>
</div>
{/if}