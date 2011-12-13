<!-- Darstellung nach: {$customarchive_filter} -->

<form action="?" method="post">
<input type="hidden" name="serendipity[subpage]" value="{$staticpage_pagetitle}" />
<input type="hidden" name="serendipity[filter]" value="{$customarchive_filter}" />
<input type="hidden" name="serendipity[mode]" value="{$customarchive_mode}" />

{foreach from=$customarchive_search item="searchdata" key="searchfield"}
    <label for="key_{$searchdata.key}">{$searchfield}</label><br />

    {if $searchdata.type == 'text'}
    <input id="key{$searchdata.key}" type="text" name="serendipity[search][{$searchdata.key}]" value="{pickKey array=$customarchive_searchdata key=$searchdata.key}" />
    {elseif $searchdata.type == 'int'}
    <input id="key{$searchdata.key}" type="text" name="serendipity[search][{$searchdata.key}][from]" value="{pickKey array=$customarchive_searchdata_from key=$searchdata.key}" />
    bis
    <input type="text" name="serendipity[search][{$searchdata.key}][to]" value="{pickKey array=$customarchive_searchdata_to key=$searchdata.key}" />
    {/if}
    <br />
{/foreach}

<input type="submit" name="go" value="Suchen" />
</form>

<table id="ap_liste">
<tr>
{foreach from=$customarchive_props key="propkey" item="prop"}
    <th align="center">
    <a href="{$serendipityBaseURL}{$serendipityIndexFile}?serendipity[subpage]={$staticpage_pagetitle}&amp;serendipity[filter]={$propkey|@replace:'ep_':''}&amp;serendipity[mode]={if $propkey|@replace:'ep_':'' == $customarchive_filter}{$customarchive_nextmode}{else}ASC{/if}">{$prop}
    &nbsp;<img src="{$serendipityBaseURL}plugins/serendipity_event_customarchive/{if $propkey|@replace:'ep_':'' == $customarchive_filter}{$customarchive_nextmode}{else}asc{/if}.gif" /></a>
    </th>
{/foreach}
</tr>

{foreach from=$customarchive_entries item="dategroup"}

    {foreach from=$dategroup.entries item="entry"}
    <tr style="background-color:#F7F7F7;font-weight:bold;">
        {foreach from=$customarchive_props key="propkey" item="prop"}
            <td>
                <div style="margin: 3px 5px">
                    {pickKey array=$entry.properties key=$propkey default='Leer'}{pickKey array=$customarchive_infoprops key=$propkey default=''}
                </div>
            </td>
        {/foreach}
    </tr>

    <tr>
        <td colspan="{$customarchive_props|@count}">
        <div style="margin: 5px 5px;">
            <a href="{$entry.link}"><img style="float: left; margin: 3px" src="{pickKey array=$entry.properties key=$customarchive_picture}" /></a>
            <a href="{$entry.link}">{$entry.title}</a><br />

            {pickKey array=$entry.properties key=$customarchive_teaser}
        </div>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    {/foreach}
{/foreach}

</table>