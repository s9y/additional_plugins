{*
 plugin_guestbook_backend_dbc.tpl v.3.57 2015-08-20 Ian
 *}

<!-- plugin_guestbook_backend_dbc start -->

<div id="wrapGB" class="clearfix">

{include file='./plugin_guestbook_backend_header.tpl'}

    <div class="gb_head">
        {if $gb_view}<h2>{$CONST.PLUGIN_GUESTBOOK_ADMIN_VIEW}</h2> {$CONST.PLUGIN_GUESTBOOK_ADMIN_VIEW_DESC}{/if}
        {if $gb_app}<h2>{$CONST.PLUGIN_GUESTBOOK_ADMIN_APP}</h2> {$CONST.PLUGIN_GUESTBOOK_ADMIN_APP_DESC}{/if}
        {if $gb_add}<h2>{$CONST.PLUGIN_GUESTBOOK_ADMIN_ADD}</h2>{/if}
        {if $gb_db}<h2>{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC}</h2>{/if}
    </div>

{foreach from=$plugin_guestbook_messagestack item="message"}
    <div class="msg_notice">{$message}</div>
{/foreach}

{if $is_guestbook_message}{$msg_header=$error_occured}{call feedback}{/if}

{if $plugin_gb_dropmsg === true}
    <h2>{$CONST.PLUGIN_GUESTBOOK_ADMIN_ERASE}</h2>
{/if}

    <div class="clearfix dbcnav">
        <ul>
            <li class="dbcnavtab"{$plugin_gb_dump}><a href="{$plugin_gb_adminpath}&serendipity[guestbookdbclean]=dbdump" title="{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DESC}">{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP}</a></li>
            <li class="dbcnavtab"{$plugin_gb_insert}><a href="{$plugin_gb_adminpath}&serendipity[guestbookdbclean]=dbinsert" title="{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_DESC}">{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT}</a></li>
            <li class="dbcnavtab"{$plugin_gb_erase}><a href="{$plugin_gb_adminpath}&serendipity[guestbookdbclean]=dberase" title="{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_DESC}">{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE}</a></li>
            <li class="dbcnavtab"{$plugin_gb_download}><a href="{$plugin_gb_adminpath}&serendipity[guestbookdbclean]=dbdownload" title="{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_DESC}">{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD}</a></li>
        </ul>
    </div>
    {if $plugin_gb_ilogerror === true}
        <div class="msg_error"><h3><span class="icon-attention" aria-hidden="true"></span> {$CONST.PLUGIN_GUESTBOOK_ADMIN_LOG_ERROR}</h3></div>
    {/if}
    {if $is_guestbook_admin_backup === true}
        <h3>{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_TITLE|upper}</h3>
        <div class="msg_success"><span class="icon-ok" aria-hidden="true"></span> {$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_DUMP_DONE}</div>
    {elseif $is_guestbook_admin_backup === false}
        <div class="msg_error"><span class="icon-attention" aria-hidden="true"></span> {$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_NOBACKUP}</div>
    {/if}
    {if $is_guestbook_admin_insert}
        <h3>{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_TITLE|upper}</h3>
        <div class="msg_notice"><span class="icon-attention" aria-hidden="true"></span> {$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_INSERT_MSG}</div>
    {/if}
    {if $is_guestbook_admin_erase}
        <h3>{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_ERASE_TITLE|upper}</h3>
        {if $is_guestbook_admin_erase_msg}
        <div class="msg_notice"><span class="icon-attention" aria-hidden="true"></span> {$plugin_gb_dbc_message}</div>
        {/if}
    {/if}
    {if $is_guestbook_admin_download}
        <h3>{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_TITLE|upper}</h3>
        {if $is_guestbook_admin_download_msg === true}
        <div class="msg_hint">templates_c/guestbook/ <b><u>backup files</u></b></div>
        {$gb_read_backup_dir}
        {elseif $is_guestbook_admin_download_msg === false}
        <div class="msg_error"><span class="icon-attention" aria-hidden="true"></span> {$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_DOWNLOAD_MSG}</div>
        {/if}
    {/if}
    {if $is_guestbook_admin_insfile_msg || $is_guestbook_admin_delfile_msg}
        <div class="msg_success"><span class="icon-ok" aria-hidden="true"></span> {$plugin_gb_dbc_message}!</div>
    {/if}
    {if $is_guestbook_admin_dbempty}
        <h3>{$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_TITLE|upper}</h3>
        <div class="msg_error"><span class="icon-attention" aria-hidden="true"></span> {$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_DESC}!</div>
    {/if}
    {if $is_plugin_gb_questionaire}
        <div class="msg_hint"><span class="icon-attention" aria-hidden="true"></span> {$plugin_gb_questionaire_text}</div>
        <div class="serendipity_center form_field">
            <a href="{$plugin_gb_questionaire_url}{$plugin_gb_questionaire_addno}" class="button_link state_cancel">{$CONST.NOT_REALLY}</a>
            <a href="{$plugin_gb_questionaire_url}{$plugin_gb_questionaire_addyes}" class="button_link state_submit">{$CONST.DUMP_IT}</a>
        </div>
    {/if}

</div><!-- #wrapGB tpl end -->