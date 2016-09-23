{* dlmanager.filedetails.tpl last modified 2016-07-06 *}
<div id="downloadmanager" class="serendipity_Entry_Date">
<!-- dlmanager.filedetails.tpl start -->
    <h3 class="serendipity_date">{$pagetitle}</h3>
    <h4 class="serendipity_title">{$headline}</h4>
    {if !empty($dlm_intro)}<div class="dlm_intro">{$dlm_intro}</div>{/if}

    {if $dlm_is_registered == false || $is_logged_in}
        {if $showfile}

        <ul class="plainList">
            <li><strong>{$CONST.PLUGIN_DOWNLOADMANAGER_CATEGORY}: {$catname}</strong> [<a href="{$basepage}?serendipity[subpage]={$pageurl}&amp;thiscat={$catid}">{$CONST.PLUGIN_DOWNLOADMANAGER_BACK}&hellip;</a>]</li>
            <li><strong>{$CONST.PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES}:</strong> {$num_subcats}</li>
            <li><strong>{$CONST.PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT}:</strong> {$num_files}</li>
        </ul>

        <h5>{$CONST.PLUGIN_DOWNLOADMANAGER_THIS_FILE}:</h5>
        {* $thisfile is a single array without index - no need for loops *}
        {if is_array($thisfile)}

        <dl>
            <dt><img src="{$thisfile.iconfile}" width="{$thisfile.iconwidth}" height="{$thisfile.iconheight}" alt="{$thisfile.icontype}" title="{$thisfile.icontype}" /> {$thisfile.filename}</dt>
            <dd><strong>{$CONST.PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC}:</strong> {$thisfile.description|strip_tags}</dd>
            <dd><strong>{$CONST.PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS_BLAH}:</strong> {$thisfile.dlcount}</dd>
            <dd><strong>{$thisfile.filesize_field}:</strong> {$thisfile.filesize}</dd>
            <dd><strong>{$thisfile.filedate_field}:</strong> {$thisfile.filedate}</dd>
        </dl>

        <h5>{$CONST.PLUGIN_DOWNLOADMANAGER_DOWNLOAD_FILE}</h5>

        <div id="dlm_button"><a href="{$thisfile.dlurl}"><img src="{$httppath}/img/download.png" alt="Download" /></a></div>
        {/if}
        {/if}
    {else}

        <div class="dlm_info">{$CONST.PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_ERROR}</div>
    {/if}

<!-- dlmanager.filedetails.tpl end -->
</div>
