{* backend.dlm.index.tpl last modified 2016-07-06 *}

{* PLEASE READ CAREFULLY:
   The DownLoadManagers (dlm) backend template vars have their own array name to be unique in global context of Serendipity blog.

   1. GloBaL      =  $dlmgbl  :  Global vars we need everywhere - set in function ADMIN_showDownloads()
   2. AddCaT      =  $dlmact  :  The addcategory array in backend function
   3. UpLoadForm  =  $dlmulf  :  The uploadform array in backend function
   4. CatFileS    =  $dlmcfs  :  The database(files) catfiles array in backend function
   5. ThisFtP     =  $dlmtfp  :  The ftp/trash folder files array in backend function
   6. ThisSmL     =  $dlmtsl  :  The Serendipity Media Library files array in backend function
   7. HasCatS     =  $dlmhcs  :  The hascats categories array in backend function
   8. ApPendiX    =  $dlmapx  :  The appendix array in backend function
   9. ErRoR       =  $dlmerr  :  The error and status messages
*}

{* we need to set a single string var with our $downloadmanager.global.thispath array to get included files the right way - else smarty will hesitate to continue *}
{assign var="path" value=$dlmgbl.thispath}

<script type="text/javascript">
    var dlm_plus = '{serendipity_getFile file="img/plus.png"}';
    var dlm_minus = '{serendipity_getFile file="img/minus.png"}';
</script>

<script type="text/javascript" src="{$dlmgbl.httppath}dlm_functions.js"></script>

<div id="backend_downloadmanager">
{if $dlmerr.thiserror === true}
    <{$div|default:'span'} id="dlm_messages">
    {if $dlmerr.errormsg}
    {foreach from=$dlmerr.errormsg item="msg"}
        <{$tag|default:'span'} class="serendipityAdminMsgError msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> {$msg}</{$tag|default:'span'}>
    {/foreach}
    {elseif $dlmerr.successmsg}
    {foreach from=$dlmerr.successmsg item="msg"}
        <{$tag|default:'span'} class="serendipityAdminMsgNotice msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> {$msg}</{$tag|default:'span'}>
    {/foreach}
    {elseif $dlmerr.statusmsg}
    {foreach from=$dlmerr.statusmsg item="msg"}
        <{$tag|default:'span'} class="serendipityAdminMsgNotice msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> {$msg}</{$tag|default:'span'}>
    {/foreach}
    {/if}
    </{$div|default:'span'}>
{/if}
{if !$dlmefe.thistype && !$dlmulf.thistype}
    <p id="dlm_toggle_optionall"><a href="#" onclick="showConfigAll({if $dlmgbl.thispage == 1}3{else}4{/if})" title="{$CONST.TOGGLE_ALL}"><img src="{serendipity_getFile file="img/plus.png"}" id="optionall" alt="+/-" />&nbsp;{$CONST.TOGGLE_ALL}</a></p>
{/if}
    <h3>{$CONST.PLUGIN_DOWNLOADMANAGER_BACKEND_TITLE|replace:"%s":$dlmgbl.thisversion}</h3>

{if $dlmgbl.thispage == 1}
    {if true === ( $dlmact.addcat || $dlmcfs.catfiles || $dlmhcs.hascats || $dlmapx.appendix )}
    {* include div body part of page 1, which includes the add category, the files in category, the subcats of root and the appendix (helptip and cleartrash) section *}
    {include file="$path/backend.dlm.rootpage.tpl" title="Downloadmanager Root Page 1"}
    {/if}
{/if}

{if $dlmgbl.thispage == 2}
    {if true === ( $dlmcfs.catfiles || $dlmtfp.thisftp || $dlmtsl.thissml || $dlmhcs.hascats || $dlmapx.appendix )}
    {* header section page 2 normally *}
    <div class="dlm_page_header">
        <div class="dlm_back_root"><a id="back" class="button_link" href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager" title="{$CONST.BACK}&hellip;"><img src="{$dlmgbl.httppath}img/f.png" alt="{$CONST.BACK}&hellip;" /> {$CONST.BACK}</a></div>

        <h4>{$CONST.PLUGIN_DOWNLOADMANAGER_CATEGORY}: {$dlmgbl[0].cat.payload}</h4>

        <ul>
            <li><strong>{$CONST.PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES}:</strong> {$dlmgbl[0].cat.subcats}</li>
            <li><strong>{$CONST.PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT}:</strong> {$dlmgbl[0].cat.num} <span class="dlm_upload_to"><a class="button_link" href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;thiscat={$dlmgbl.thiscat}&amp;upload=1">{$CONST.PLUGIN_DOWNLOADMANAGER_UPLOAD_FILE}&hellip;</a></span></li>
        </ul>
    </div>
    {* include div body part of page 2, which includes the header, the files in category, the ftp/trash files, the Serendipity media library files, the subcats of root and section the appendix (helptip and cleartrash) section *}
    {include file="$path/backend.dlm.subpage.tpl" title="Downloadmanager Sub Page 2"}
    {/if}

    {if $dlmulf.thistype == 'uploadform'}
    {* header section page 2 uploaddform *}
    <div class="dlm_page_header">
        <div class="dlm_back_root"><a id="back" class="button_link" href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager" title="{$CONST.BACK}&hellip;"><img src="{$dlmgbl.httppath}img/f.png" alt="{$CONST.BACK}&hellip;" />&nbsp;{$CONST.BACK}</a></div>

        <h4>{$CONST.PLUGIN_DOWNLOADMANAGER_CATEGORY}: {$dlmgbl[0].cat.payload}</h4>

        <div class="dlm_back_up"><a id="back" class="button_link" href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;thiscat={$dlmgbl.thiscat}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_BACK_CURRENT}&hellip;"><img src="{$dlmgbl.httppath}img/fex.png" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_BACK_CURRENT}&hellip;" /> {$CONST.PLUGIN_DOWNLOADMANAGER_BACK_CURRENT}</a></div>

        <ul>
            <li><strong>{$CONST.PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES}:</strong> {$dlmgbl[0].cat.subcats}</li>
            <li><strong>{$CONST.PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT}:</strong> {$dlmgbl[0].cat.num}</li>
        </ul>
    </div>
    {* include div body part of page 2, which includes a personal header and the upload to selected category form  *}
    {include file="$path/backend.dlm.upload.tpl" title="Downloadmanager Upload Form"}
    {/if}

    {if $dlmefe.thistype == 'editfile'}
    {* header section page 2 editfile *}
    <div class="dlm_page_header">
        <div class="dlm_back_root"><a id="back" class="button_link" href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager" title="Root category..."><img src="{$dlmgbl.httppath}img/f.png" alt="Root category..." />&nbsp;{$CONST.BACK}</a></div>

        <h4>{$CONST.PLUGIN_DOWNLOADMANAGER_THIS_FILE}: <img src="{$dlmefe.mime.ICON}" width="16" height="16" alt="{$dlmefe.mime.TYPE}" title="{$dlmefe.mime.TYPE}" /> {$dlmefe.realfilename}</h4>

        <div class="dlm_back_up"><a id="back" class="button_link" href="./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=downloadmanager&amp;thiscat={$dlmgbl.thiscat}" title="{$CONST.PLUGIN_DOWNLOADMANAGER_BACK_CURRENT}&hellip;"><img src="{$dlmgbl.httppath}img/fex.png" alt="{$CONST.PLUGIN_DOWNLOADMANAGER_BACK_CURRENT}&hellip;" /> {$CONST.PLUGIN_DOWNLOADMANAGER_BACK_CURRENT}</a></div>

        <ul>
            <li><strong>{$CONST.PLUGIN_DOWNLOADMANAGER_CATEGORY}:</strong> {$dlmgbl[0].cat.payload}</li>
            <li><strong>{$CONST.PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES}:</strong> {$dlmgbl[0].cat.subcats}</li>
            <li><strong>{$CONST.PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT}:</strong> {$dlmgbl[0].cat.num}</li>
        </ul>
    </div>
    {* include div body part of page 2, which includes a personal header and the edit file form *}
    {include file="$path/backend.dlm.filepage.tpl" title="Downloadmanager Edit File"}
    {/if}
{/if}
</div><!-- backend_downloadmanager end -->