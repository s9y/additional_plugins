{* backend.dlm.rootpage.tpl last modified 2016-06-06 *}
{if $dlmgbl.thispage == 1 && $dlmact.addcat === true}
{* Add category to selectfield cat *}
<p id="dlm_addcat_header" class="dlm_backend_option"><a href="#" onclick="showConfig('dlm1'); return false" title="{$CONST.TOGGLE_OPTION}"><img src="{serendipity_getFile file="img/plus.png"}" id="optiondlm1" alt="+/-" /> {$CONST.PLUGIN_DOWNLOADMANAGER_ADD_CAT}</a></p>
<!-- // div container page {$dlmgbl.thispage} dlm(1) -->
<div id="dlm1" class="dlm_backend_newcat">
    <form name="newcatform" action="?" method="POST">
    <div>
        <input type="hidden" name="serendipity[adminModule]" value="event_display" />
        <input type="hidden" name="serendipity[adminAction]" value="downloadmanager" />
    </div>

    <div id="addcat">
        <div class="addcat_field">
            <label for="addcat_catname">{$CONST.PLUGIN_DOWNLOADMANAGER_CATNAME}</label>
            <input id="addcat_catname" type="text" name="serendipity[catname]" value="" />
        </div>

        <div class="addcat_field">
            <label for="addcat_childof">{$CONST.PLUGIN_DOWNLOADMANAGER_SUBCAT_OF}</label>
            <select id="addcat_childof" name="serendipity[childof]">
            {foreach from=$dlmact.selcatlist item="thiscat"}
                <option value="{$thiscat.cat.node_id}"{if $thiscat.cat.node_id == $id} selected{/if}>{if $thiscat.cat.node_id != 1}&nbsp;&nbsp;{/if}{if is_array( $thiscat.imgname )}{foreach from=$thiscat.imgname item="tab"}{if $tab == 'e'}&nbsp;&nbsp;&nbsp;&nbsp;{/if}{if $tab == 'l'}&nbsp;&nbsp;&nbsp;|{/if}{if $tab == 'b' || $tab == 'nb'}&nbsp;&nbsp;&nbsp;{/if}{/foreach}{/if}{$thiscat.cat.payload}</option>
            {/foreach}
            </select>
        </div>

        <input id="addcat_submit" class="serendipityPrettyButton input_button" type="submit" name="serendipity[dlmanAction]" value="{$CONST.GO}">
    </div>
    </form>
</div>
<script type="text/javascript">document.getElementById('dlm1').style.display = 'none';</script>
{/if}

{if $dlmgbl.thispage == 1 && $dlmcfs.catfiles === true}
{* Show all files in category *}
<p id="dlm_files_header" class="dlm_backend_option"><a href="#" onclick="showConfig('dlm2'); return false" title="{$CONST.TOGGLE_OPTION}"><img src="{if $dlmcfs.ddiv === true}{serendipity_getFile file="img/minus.png"}{else}{serendipity_getFile file="img/plus.png"}{/if}" id="optiondlm2" alt="+/-" /> {$CONST.PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT} [ root ]:</a> {if is_array( $dlmcfs.filelist )}{$dlmcfs.filelist|@count}{else}0{/if}</p>
<!-- // div container page {$dlmgbl.thispage} dlm(2) -->
<div id="dlm2" class="dlm_backend_file_box">
    <form name="filelistform" method="post" action="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;thiscat={$dlmgbl.thiscat}">
    <table id="catfiles" cellspacing="0">
    <thead>
        <tr>
            <th>{$dlmgbl.filename_field}</th>
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
{if $dlmcfs.ddiv === false}<script type="text/javascript">document.getElementById('dlm2').style.display = 'none';</script>{/if}
{/if}

{if $dlmgbl.thispage == 1 && $dlmhcs.hascats === true}

{* Show all subcategories of root level *}
<p id="dlm_cats_header" class="dlm_backend_option"><a href="#" onclick="showConfig('dlm3'); return false" title="{$CONST.TOGGLE_OPTION}"><img src="{if $dlmhcs.ddiv === true}{serendipity_getFile file="img/minus.png"}{else}{serendipity_getFile file="img/plus.png"}{/if}" id="optiondlm3" alt="+/-" /> {$CONST.PLUGIN_DOWNLOADMANAGER_CATEGORIES}:</a> {$dlmhcs.catsinccat}</p>
<!-- // div container page {$dlmgbl.thispage} dlm(3) -->
<div id="dlm3" class="dlm_backend_cats">
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
            <th>{$CONST.PLUGIN_DOWNLOADMANAGER_CATEGORIES}</th>
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
                <a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;delcat={$dlmhcs.catlist[cat].cat.node_id}"><img src="{$dlmgbl.httppath}img/del.png" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_DEL_CAT}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_DEL_CAT}" /></a>
            {else}
                <img src="{$dlmgbl.httppath}img/delch.png" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_DEL_CAT_NOT_ALLOWD}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_DEL_CAT_NOT_ALLOWD}" />
            {/if}
            {if $dlmhcs.catlist[cat].cat.hidden != 1}
                <a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;hidecat=1&amp;hide=1&amp;catid={$dlmhcs.catlist[cat].cat.node_id}"><img src="{$dlmgbl.httppath}img/hide2.png" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_HIDE_TREE}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_HIDE_TREE}" /></a>
            {else}
                <a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;hidecat=1&amp;hide=0&amp;catid={$dlmhcs.catlist[cat].cat.node_id}"><img src="{$dlmgbl.httppath}img/unhide2.png" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_UNHIDE_TREE}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_UNHIDE_TREE}" /></a>
            {/if}
            {foreach from=$dlmhcs.catlist[cat].imgname item="s"}<img src="{$dlmgbl.httppath}img/{$s}.gif" alt="tree" /> {/foreach}
            {if $dlmhcs.catlist[cat].cat.hidden != 1}
                <a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;thiscat={$dlmhcs.catlist[cat].cat.node_id}"><img src="{$dlmgbl.httppath}{if $dlmhcs.catlist[cat].cat.node_id == $dlmhcs.cn}img/fex.png{else}img/f.png{/if}" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_OPEN_CAT}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_OPEN_CAT}" /></a>
            {else}
                <a href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;thiscat={$dlmhcs.catlist[cat].cat.node_id}"><img src="{$dlmgbl.httppath}{if $dlmhcs.catlist[cat].cat.node_id == $dlmhcs.cn}img/hfex2.png{else}img/hf.png{/if}" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_OPEN_CAT}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_OPEN_CAT}" /></a>
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
{if $dlmhcs.ddiv === false}<script type="text/javascript">document.getElementById('dlm3').style.display = 'none';</script>{/if}
{/if}

{if $dlmgbl.thispage == 1 && $dlmapx.appendix === true}
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
    <h4><a href="#" onclick="showConfig('dlm4'); return false" title="{$CONST.TOGGLE_OPTION}"><img src="{serendipity_getFile file="img/plus.png"}" id="optiondlm4" alt="+/-" /> DLM Help:</a></h4>
    <!-- // div container page {$dlmgbl.thispage} dlm(4) -->
    <div id="dlm4" class="dlm_help_box">
        <ul>
        {foreach from=$dlmapx.helplist item='help'}
            <li>{$help}</li>
        {/foreach}
        </ul>
    </div>
</div>
<script type="text/javascript">document.getElementById('dlm4').style.display = 'none';</script>
{/if}
