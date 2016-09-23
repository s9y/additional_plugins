{* dlmanager.catlist.tpl last modified 2016-07-06 *}
<div id="downloadmanager" class="serendipity_Entry_Date">
<!-- dlmanager.catlist.tpl start -->
    <h3 class="serendipity_date">{$pagetitle}</h3>
    <h4 class="serendipity_title">{$headline}</h4>
    {if !empty($dlm_intro)}<div class="dlm_intro">{$dlm_intro}</div>{/if}

    {if $dlm_is_registered == false || $is_logged_in}
        {if $categories_found}

        <table id="catlist" cellspacing="0">
        <thead>
            <tr>
                <th>{$CONST.PLUGIN_DOWNLOADMANAGER_CATEGORIES}</th>
                <th class="last_column">{$CONST.PLUGIN_DOWNLOADMANAGER_NUMBER_OF_DOWNLOADS}</th>
            </tr>
        </thead>
        <tbody>
        {section name="cat" loop=$catlist}

            <tr class="dlm_subcat {cycle name="cycle1" values="odd,even"}">
                <td>{foreach from=$catlist[cat].imgname item="s"}<img src="{$httppath}img/{$s}.gif" width="20" height="20" alt="" />{/foreach}<img src="{$httppath}img/f.png" width="20" height="20" alt="{$CONST.CATEGORY}" /> <a href="{$catlist[cat].path}">{$catlist[cat].cat.payload}{* $catlist[cat].catname *}</a></td>
                <td class="last_column">{$catlist[cat].filenum}</td>
            </tr>
        {/section}
        </tbody>
        </table>
        {else}
        <div class="error">{$CONST.PLUGIN_DOWNLOADMANAGER_NO_CATS_FOUND}</div>
        {/if}
    {else}
        <div class="dlm_info">{$CONST.PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_ERROR}</div>
    {/if}
<!-- dlmanager.catlist.tpl end -->
</div>
