{* dlmanager.filelist.tpl last modified 2016-07-14 *}
<div id="downloadmanager" class="serendipity_Entry_Date">
<!-- dlmanager.filelist.tpl start -->
    <h3 class="serendipity_date">{$pagetitle}</h3>
    <h4 class="serendipity_title">{$headline}</h4>
    {if !empty($dlm_intro)}<div class="dlm_intro">{$dlm_intro}</div>{/if}

    {if $dlm_is_registered == false || $is_logged_in}

        <ul class="plainList">
            <li><strong>{$CONST.PLUGIN_DOWNLOADMANAGER_CATEGORY}: {$catname}</strong> [<a href="{$basepage}?serendipity[subpage]={$pageurl}">{$CONST.PLUGIN_DOWNLOADMANAGER_BACK}&hellip;</a>]</li>
            <li>{$CONST.PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES}: {$numsubcats}</li>
            <li>{$CONST.PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT}: {$numdls}</li>
        </ul>
        {if $has_subcats}

        <table id="subcatlist" cellspacing="0">
        <thead>
            <tr>
                <th>{$CONST.PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES}</th>
                <th>{$CONST.PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES}</th>
                <th class="last_column">{$CONST.PLUGIN_DOWNLOADMANAGER_NUMBER_OF_DOWNLOADS}</th>
            </tr>
        </thead>
        <tbody>
            {section name="cat" loop=$sclist}{* <pre>{$sclist[cat]|print_r}</pre> *}

            <tr class="dlm_subcat {cycle name="cycle1" values="odd,even"}">
                <td><img src="{$httppath}img/f.png" width="20" height="20" alt=""/> <a href="{$sclist[cat].node.path}">{$sclist[cat].subcat.payload}</a></td>
                <td>{$sclist[cat].subcat.subcats}</td>
                <td class="last_column">{$sclist[cat].num}</td>
            </tr>
            {/section}

        </tbody>
        </table>
        {/if}

        <table id="filelist" cellspacing="0">
        <thead>
            <tr>
            {if $filename_field}

                <th class="dlm_filelist_name">{$filename_field}</th>
            {/if}
            {if $dls_field}

                <th class="dlm_filelist_dls">{$dls_field}</th>
            {/if}
            {if $filesize_field}

                <th class="dlm_filelist_size"> {$filesize_field}</th>
            {/if}
            {if $filedate_field}

                <th class="dlm_filelist_date"> {$filedate_field}</th>
            {/if}

            </tr>
        </thead>
        <tbody>
        {section name="file" loop=$fltable}

            <tr class="dlm_file {cycle name="cycle2" values="odd,even"}">
                <td class="dlm_filename">
                    <a href="{$fltable[file].info.iconurl}" class="dlm_fileicon"><img src="{$fltable[file].info.iconfile}" width="{$fltable[file].info.iconwidth}" height="{$fltable[file].info.iconheight}" alt="{$fltable[file].info.icontype}" title="{$fltable[file].info.icontype}" /></a>{if $fltable[file].is.showfilename} <a href="{$fltable[file].info.nameurl}" class="dlm_filename" title="{$fltable[file].file.realfilename}">{$fltable[file].file.realfilename}</a>{/if}{if $fltable[file].is.showdesc_inlist && $fltable[file].info.file_desc} <span class="dlm_filedesc">{$fltable[file].info.file_desc}{/if}

                </td>
                {if $fltable[file].is.showdownloads}

                <td class="dlm_filedlds">{$fltable[file].file.dlcount}</td>
                {/if}
                {if $fltable[file].is.showfilesize}

                <td class="dlm_filesize">{$fltable[file].info.filesize}</td>
                {/if}
                {if $fltable[file].is.showdate}

                <td class="dlm_filedate">{$fltable[file].info.filedate}</td>
                {/if}

            </tr>
        {/section}

        </tbody>
        </table>
    {else}

        <div class="dlm_info">{$CONST.PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_ERROR}</div>
    {/if}

<!-- dlmanager.filelist.tpl end -->
</div>
