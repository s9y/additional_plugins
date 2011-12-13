{* backend.dlm.subpage.tpl last modified 2010-09-23 *}
{if $dlmgbl.thispage == 2 && $dlmcfs.catfiles === true}
{* Show all files in category *}
<p id="dlm_files_header" class="dlm_backend_option"><a href="#" onclick="showConfig('dlm1'); return false" title="{$CONST.TOGGLE_OPTION}"><img src="{if $dlmcfs.ddiv === true}{serendipity_getFile file="img/minus.png"}{else}{serendipity_getFile file="img/plus.png"}{/if}" id="optiondlm1" alt="+/-" /> {$CONST.PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT}[ {$dlmgbl[0].cat.payload} ]:</a> {$dlmgbl[0].cat.num}</p>
<!-- // div container page {$dlmgbl.thispage} dlm(1) -->
<div id="dlm1" class="dlm_backend_file_box">
    <form name="filelistform" method="post" action="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;thiscat={$dlmgbl.thiscat}">
    <table id="catfiles" cellspacing="0">
    <thead>
        <tr>
            <th><img src="{serendipity_getFile file="img/blank.png"}" width="84" height="4" />{$dlmgbl.filename_field}</th>
            <th>{$dlmgbl.filenums_field}</th>
            <th>{$dlmgbl.filesize_field}</th>
            <th>{$dlmgbl.filedate_field}</th>
        </tr>
    </thead>
    {if is_array( $dlmcfs.filelist )}
    <tbody>
    {foreach from=$dlmcfs.filelist item="file"}
        <tr class="{cycle name="cycle1" values="odd,even"}">
            <td>
                <input name="dlm[files][]" value="{$file.id}" type="checkbox">
                <a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;thiscat={$dlmgbl.thiscat}&amp;delfile={$file.id}"><img src="{$dlmgbl.httppath}img/del.png" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_DEL_FILE}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_DEL_FILE}" /></a>
                <a href="{$dlmcfs.downloadpath}{$file.id}"><img src="{$dlmgbl.httppath}img/dl.png" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_DOWNLOAD_FILE}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_DOWNLOAD_FILE}" /></a>
                <img src="{$file.mime.ICON}" width="16" height="16" alt="{$file.mime.TYPE}" title="{$file.mime.TYPE}" />
                <a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;thiscat={$dlmgbl.thiscat}&amp;editfile={$file.id}">{$file.realfilename}</a>
            </td>
            <td>{$file.dlcount}</td>
            <td>{$file.filesize}</td>
            <td>{$file.filedate}</td>{* this is defined in dlm config *}
        </tr>
    {/foreach}
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">
                <input name="dlm[chkFileMove]" value="1" onclick="chkAll(this.form, 'dlm[files][]', this.checked)" type="checkbox" /> {$CONST.PLUGIN_DOWNLOADMANAGER_BUTTON_MARK}&#160;&#160;
                <input type="image" src="{$dlmgbl.httppath}img/notes-delete.gif" name="Reject_Selected" alt="notes-delete" title=" Reject " /> {$CONST.PLUGIN_DOWNLOADMANAGER_BUTTON_MARK_TITLE}
            </td>
        </tr>
    </tfoot>
    {else}
    <tfoot>
        <tr>
            <td id="no_files_uploaded" colspan="4">{$CONST.PLUGIN_DOWNLOADMANAGER_NO_FILES_UPLOADED}</td>
        </tr>
    </tfoot>
    {/if}
    </table>
    </form>
</div>
{if $dlmcfs.ddiv === false}<script type="text/javascript" language="JavaScript">document.getElementById('dlm1').style.display = 'none';</script>{/if}
{/if}

{if $dlmgbl.thispage == 2 && $dlmtfp.thisftp === true}
{* Show all ftp/trash files in income dir *}
<p id="dlm_ftp_header" class="dlm_backend_option"><a href="#" onclick="showConfig('dlm2'); return false" title="{$CONST.TOGGLE_OPTION}"><img src="{if $dlmtfp.ddiv === true}{serendipity_getFile file="img/minus.png"}{else}{serendipity_getFile file="img/plus.png"}{/if}" id="optiondlm2" alt="+/-" /> {$CONST.PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE}</a> {$dlmtfp.ftpfiles|@count}</p>
<!-- // div container page {$dlmgbl.thispage} dlm(2) -->
<div id="dlm2" class="dlm_backend_ftp_box">
    <form name="ftpcheckform" method="post" action="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;thiscat={$dlmgbl.thiscat}{if $dlmtfp.ct === true}&amp;cleantrash=1{/if}">
    {* // TRASH BOX - show, if multi files from file folder were erased (eg moved to this ftp folder)  *}
    {if true === ( $dlmtfp.ct || $dlmtfp.movedtoftp )}
    <div id="dlm_trash_ftp">
        <input name="dlm[cleartrash]" value="1" type="hidden">
        <input type="image" src="{$dlmgbl.httppath}img/trash_32.png" width="32" height="32" title="{$CONST.PLUGIN_DOWNLOADMANAGER_CLEAR_TRASH}" />
    </div>
    {/if}
    {* this info text constant contains brs while there are 3 lines of information to understand *}
    <p class="dlm_backend_info">{$CONST.PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE_BLAHBLAH} {$dlmtfp.ftppath}</p>
    
    <table id="ftpfiles" cellspacing="0">
    <thead>
    {if is_array( $dlmtfp.ftpfiles )}
        <tr class="dlm_backend_tr dlm_backend_bold">
            <th><img src="{serendipity_getFile file="img/blank.png"}" width="84" height="4" />{$dlmgbl.filename_field}</th>
            <th>{$dlmgbl.filesize_field}</th>
            <th>{$dlmgbl.filedate_field}</th>
        </tr>
    </thead>
    <tbody>
    {foreach from=$dlmtfp.ftpfiles item="ifile"}
        <tr class="{cycle name="cycle1" values="odd,even"}">
            <td>
                <input name="dlm[ifiles][]" value="{$ifile.filename}" type="checkbox">
                <a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;delifile={$ifile.filename}&amp;thiscat={$dlmgbl.thiscat}"><img src="{$dlmgbl.httppath}img/del.png" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_DEL_FILE}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_DEL_FILE}" /></a>
                <a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;importfile={$ifile.filename}&amp;thiscat={$dlmgbl.thiscat}"><img src="{$dlmgbl.httppath}img/importfile.gif" height="16" width="16" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_IMPORT_FILE}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_IMPORT_FILE}" /></a>
                <img src="{$ifile.filemime.ICON}" alt="{$ifile.filemime.TYPE}" title="{$ifile.filemime.TYPE}" height="16" width="16" />
                {$ifile.filename}
            </td>
            <td>{$ifile.filesize}</td>
            <td>{$ifile.filedate}</td>
        </tr>
    {/foreach}
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="dlm_fileform_validation">
                <input name="dlm[thiscat]" value="{$dlmgbl.thiscat}" type="hidden" />
                <input name="dlm[chkFtpMove]" value="1" onclick="chkAll(this.form, 'dlm[ifiles][]', this.checked)" type="checkbox">&nbsp;{$CONST.PLUGIN_DOWNLOADMANAGER_BUTTON_MARK}&#160;&#160;
                <input src="{$dlmgbl.httppath}img/notes-checkmark.gif" name="Move_Selected" alt="notes-move" title=" Move " type="image">&nbsp;{$CONST.PLUGIN_DOWNLOADMANAGER_BUTTON_MOVE_TITLE}
            </td>
        </tr>
    </tfoot>
    {else}
    <tfoot>
        <tr>
            <td id="no_ftp_files" colspan="3">{$CONST.PLUGIN_DOWNLOADMANAGER_NO_FILES_UPLOADED}</td>
        </tr>
    </tfoot>
    {/if}
    </table>
    </form>
</div>
{if $dlmtfp.ddiv === false}<script type="text/javascript" language="JavaScript">document.getElementById('dlm2').style.display = 'none';</script>{/if}
{/if}

{if $dlmgbl.thispage == 2 && $dlmtsl.thissml === true}
{* Show all media library files in /uploads dir *}
<p id="dlm_s9ml_header" class="dlm_backend_option"><a href="#" onclick="showConfig('dlm3'); return false" title="{$CONST.TOGGLE_OPTION}"><img src="{if $dlmtsl.ddiv === true}{serendipity_getFile file="img/minus.png"}{else}{serendipity_getFile file="img/plus.png"}{/if}" id="optiondlm3" alt="+/-" /> {$CONST.PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY}</a></p>
<!-- // div container page {$dlmgbl.thispage} dlm(3) -->
<div id="dlm3" class="dlm_backend_s9ml_box">
    {* Erm ... shouldn't this be a form?!? No, this is single file movement only! We do not need multi file movement in media library. *}
    <p class="dlm_backend_info">{$CONST.PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY_BLAHBLAH} {$dlmtsl.smlpath}</p>
    
    <table id="smlfiles" cellspacing="0">
    <thead>
    {if $dlmtsl.issmlarr === true}    
        <tr>
            <th><img src="{serendipity_getFile file="img/blank.png"}" width="84" height="4" />{$dlmgbl.filename_field}</th>
            <th>{$dlmgbl.filesize_field}</th>
            <th>{$dlmgbl.filedate_field}</th>
        </tr>
    </thead>
    <tbody>
    {* header of serendipity directories in media library *}
    {if !empty( $dlmtsl.extrapath )}
        <tr>
            <td colspan="3">
                <img src="{serendipity_getFile file="img/blank.png"}" width="60" height="20" alt="" />
                <img src="{$dlmgbl.httppath}img/fex.png" width="16" height="16" alt="" />
                <a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;smlpath={$dlmtsl.backpath}&amp;thiscat={$dlmgbl.thiscat}">{$CONST.PLUGIN_DOWNLOADMANAGER_BACK}</a>
            </td>
        </tr>
    {/if}
    {* array of serendipity directories in media library *}
    {foreach from=$dlmtsl.smldirs item="smlda"}
        <tr class="{cycle name="cycle1" values="odd,even"}">
            <td colspan="3">
                <img src="{serendipity_getFile file="img/blank.png"}" width="60" height="20" alt="" />
                <img src="{$dlmgbl.httppath}img/f.png" width="16" height="16" alt="" />
                <a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;smlpath={$smlda.filepath}/{$smlda.filename}&amp;thiscat={$dlmgbl.thiscat}">{$smlda.filename}</a>
            </td>
        </tr>
    {/foreach}
    {* array of serendipity files in media library *}
    {foreach from=$dlmtsl.smlfiles item="smlfa"}
        <tr class="{cycle name="cycle1" values="odd,even"}">
            <td>
                <img src="{serendipity_getFile file="img/blank.png"}" width="40" height="20" alt="" /><a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;medialib=1&amp;smlpath={$smlfa.filepath}{$dlmtsl.extrapath}&amp;ifile={$smlfa.filename}&amp;thiscat={$dlmgbl.thiscat}"><img src="{$dlmgbl.httppath}img/s9yml2.png" width="20" height="20" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_IMPORT_FILE}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_IMPORT_FILE}" /></a>
                <img src="{$smlfa.filemime.ICON}" width="16" height="16" alt="{$smlfa.filemime.TYPE}" title="{$smlfa.filemime.TYPE}" />
                {$smlfa.filename}
            </td>
            <td>{$smlfa.filesize}</td>
            <td>{$smlfa.filedate}</td>
        </tr>
    {/foreach}
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="">&#160;</td>
        </tr>
    </tfoot>
    {else}
    <tfoot>
        <tr>
            <td id="no_ml_files" colspan="3">{$CONST.PLUGIN_DOWNLOADMANAGER_NO_FILES_UPLOADED}</td>
        </tr>
    </tfoot>
    {/if}
    </table>
</div>
{if $dlmtsl.ddiv === false}<script type="text/javascript" language="JavaScript">document.getElementById('dlm3').style.display = 'none';</script>{/if}
{/if}

{if $dlmgbl.thispage == 2 && $dlmhcs.hascats === true}
{* Show all subcategories of root level *}
<p id="dlm_cats_header" class="dlm_backend_option"><a href="#" onclick="showConfig('dlm4'); return false" title="{$CONST.TOGGLE_OPTION}"><img src="{if $dlmhcs.ddiv === true}{serendipity_getFile file="img/minus.png"}{else}{serendipity_getFile file="img/plus.png"}{/if}" id="optiondlm4" alt="+/-" /> {$CONST.PLUGIN_DOWNLOADMANAGER_CATEGORIES}:</a> {$dlmhcs.catsinccat}</p>
<!-- // div container page {$dlmgbl.thispage} dlm(4) -->
<div id="dlm4" class="dlm_backend_cats">
{if is_array( $dlmhcs.catlist )}
    <form name="catnameform" action="?" method="POST">
    <div>
        <input type="hidden" name="serendipity[adminModule]" value="event_display" />
        <input type="hidden" name="serendipity[adminAction]" value="downloadmanager" />
    </div>
    {* <pre>{$dlmhcs.catlist|print_r}</pre> *}
    <table id="catlist" cellspacing="0">
    <thead>
        <tr>
            <th><img src="{serendipity_getFile file="img/blank.png"}" width="40" height="4" />{$CONST.PLUGIN_DOWNLOADMANAGER_CATEGORIES}</th>
            <th>{$CONST.PLUGIN_DOWNLOADMANAGER_NUMBER_OF_DOWNLOADS}</th>
        </tr>
    </thead>
    <tbody>
    {section name="cat" loop=$dlmhcs.catlist}
    {* exclude cat[payload] = root being generated here! *}
    {if $dlmhcs.catlist[cat].cat.payload != 'root'}        
        <tr>
            <td>
            {if $dlmhcs.catlist[cat].cat.subcats <= 0}
                <a href=./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;delcat={$dlmhcs.catlist[cat].cat.node_id}><img src="{$dlmgbl.httppath}img/del.png" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_DEL_CAT}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_DEL_CAT}" /></a>
            {else}
                <img src="{$dlmgbl.httppath}img/delch.png" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_DEL_CAT_NOT_ALLOWD}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_DEL_CAT_NOT_ALLOWD}" />
            {/if}
            {if $dlmhcs.catlist[cat].cat.hidden != 1}
                <a href=./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;hidecat=1&amp;hide=1&amp;catid={$dlmhcs.catlist[cat].cat.node_id}><img src="{$dlmgbl.httppath}img/hide2.png" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_HIDE_TREE}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_HIDE_TREE}" /></a>
            {else}
                <a href=./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;hidecat=1&amp;hide=0&amp;catid={$dlmhcs.catlist[cat].cat.node_id}><img src="{$dlmgbl.httppath}img/unhide2.png" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_UNHIDE_TREE}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_UNHIDE_TREE}" /></a>
            {/if}
            {foreach from=$dlmhcs.catlist[cat].imgname item="s"}<img src="{$dlmgbl.httppath}img/{$s}.gif" alt="tree" /> {/foreach}
            {if $dlmhcs.catlist[cat].cat.hidden != 1}   
                <a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;thiscat={$dlmhcs.catlist[cat].cat.node_id}"><img src="{$dlmgbl.httppath}{if $dlmhcs.catlist[cat].cat.node_id == $dlmhcs.cn}img/fex.png{else}img/f.png{/if}"  alt="{$CONST.PLUGIN_DOWNLOADMANAGER_OPEN_CAT}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_OPEN_CAT}" /></a>
            {else}
                <a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;thiscat={$dlmhcs.catlist[cat].cat.node_id}"><img src="{$dlmgbl.httppath}{if $dlmhcs.catlist[cat].cat.node_id == $dlmhcs.cn}img/hfex2.png{else}img/hf.png{/if}"  alt="{$CONST.PLUGIN_DOWNLOADMANAGER_OPEN_CAT}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_OPEN_CAT}" /></a>
            {/if}
                {* this input element changes the catname on the fly *}
                <input class="catlist_catname_input{if $dlmhcs.catlist[cat].cat.node_id == $dlmhcs.cn} catlist_cats_selected{/if}" type="text" style="width:{$dlmhcs.catlist[cat].cat.inputsize}px" name="catname[{$dlmhcs.catlist[cat].cat.node_id}]" value="{$dlmhcs.catlist[cat].cat.payload}" />
            </td>
            <td class="catlist_numoffiles">{$dlmhcs.catlist[cat].filenum}</td>
        </tr>
    {/if}
    {/section}
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><input id="catname_submit" class="serendipityPrettyButton input_button" type="submit" name="serendipity[catnamAction]" value="{$CONST.GO}"></td>
        </tr>
    </tfoot>
    </table>
    </form>
{else}
    <p class="serendipityAdminMsgError">{$CONST.PLUGIN_DOWNLOADMANAGER_NO_CATS_FOUND}</p>
{/if}
</div>
{if $dlmhcs.ddiv === false}<script type="text/javascript" language="JavaScript">document.getElementById('dlm4').style.display = 'none';</script>{/if}
{/if}

{if $dlmgbl.thispage == 2 && $dlmapx.appendix === true}
{* Append helptip and trash box button to clean trash in ftp/trash directory *}
<div id="dlm_trash_box">
{if $dlmapx.cleanme === true}
    <form name="cattrashform" action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;thiscat={$dlmgbl.thiscat}&amp;cleantrash=1" method="POST">
        <input type="hidden" name="dlm[cleartrash]" value="1" />
        <input type="image" src="{$dlmgbl.httppath}img/trash_32.png" width="32" height="32" title="{$CONST.PLUGIN_DOWNLOADMANAGER_CLEAR_TRASH}" />
    </form>
{else}
    <img src="{$dlmgbl.httppath}img/trash_clean_32.png" width="32" height="32" title="{$CONST.PLUGIN_DOWNLOADMANAGER_NO_TRASH}" />
{/if}
</div>
<div id="dlm_help">
    <h4><a href="#" onclick="showConfig('dlm5'); return false" title="{$CONST.TOGGLE_OPTION}"><img src="{serendipity_getFile file="img/plus.png"}" id="optiondlm5" alt="+/-" /> DLM Help:</a></h4>
    <!-- // div container page {$dlmgbl.thispage} dlm(4) -->
    <div id="dlm5">
        <ul>
        {foreach from=$dlmapx.helplist item='help'}
            <li>{$help}</li>
        {/foreach}
        </ul>
    </div>
</div>
<script type="text/javascript" language="JavaScript">document.getElementById('dlm5').style.display = 'none';</script>
{/if}
