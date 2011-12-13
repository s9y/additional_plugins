{if $staticpage_articleformat}
<div class="serendipity_Entry_Date">
    <h3 class="serendipity_date">{$staticpage_articleformattitle|@escape}</h3>
{/if}

    <h4 class="serendipity_title"><a href="#">{$staticpage_headline|@escape}</a></h4>

{if $staticpage_navigation}
    <table border="0" cellpadding="2" cellspacing="2" width="100%" class="staticpage_navigation">
        <tr>
            <td class="staticpage_navigation_left"   style="width: 20%"><a href="{$staticpage_navigation.prev.link}" title="prev">{$staticpage_navigation.prev.name|@escape}</a></td>
            <td class="staticpage_navigation_center" style="width: 60%; text-align: center"><a href="{$staticpage_navigation.top.link}" title="top">{$staticpage_navigation.top.name|@escape}</a></td>
            <td class="staticpage_navigation_right"  style="width: 20%; text-align: right"><a href="{$staticpage_navigation.next.link}" title="next">{$staticpage_navigation.next.name|@escape}</a></td>
        </tr>
    </table>
{/if}

{if $staticpage_articleformat}
    <div class="serendipity_entry">
        <div class="serendipity_entry_body">
{/if}

{if $staticpage_pass AND $staticpage_form_pass != $staticpage_pass}
        {$CONST.STATICPAGE_PASSWORD_NOTICE}<br /><br />
        <form action="{$staticpage_form_url}" method="post">
            <div>
                <input type="password" name="serendipity[pass]" value="" />
                <input type="submit" name="submit" value="{$CONST.GO}" />
             </div>
        </form>
{else}

<table border="0" width="100%">
{foreach from=$staticpage_extchildpages item="child"}
<tr>
<td width="200">
        {if $child.image}
        <img src="{$child.image}" alt="" />
        {/if}
</td>
<td>
        <a href="{$child.permalink}">{$child.pagetitle}</a><br />
        {$child.precontent|truncate:200:"...":true}

</td>
</tr>
{/foreach}
</table>

{/if}

{if $staticpage_articleformat}
        </div>
    </div>
</div>
{/if}

{if $staticpage_author}
    <div class="staticpage_author">{$staticpage_author|@escape}</div>
{/if}

    <div class="staticpage_metainfo">
{if $staticpage_lastchange}
    <span class="staticpage_metainfo_lastchange">{$staticpage_lastchange|date_format:"%Y-%m-%d"}</span>
{/if}

{if $staticpage_adminlink AND $staticpage_adminlink.page_user}
    | <a class="staticpage_metainfo_editlink" href="{$staticpage_adminlink.link_edit}">{$staticpage_adminlink.link_name|@escape}</a>
{/if}
    </div>



