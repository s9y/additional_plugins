{*
     plugin_guestbook_backend_entries.tpl for v.3.53 - 2014-12-29 Ian
*}

<!-- plugin_guestbook_backend_entries start -->

<div id="wrapGB" class="clearfix">

{include file='./plugin_guestbook_backend_header.tpl'}

{if $gb_gbadd_approve}
    <div class="gb_head">
    {if !empty($msg_header)}
        {call feedback}
    {else}
        <h2>{$CONST.PLUGIN_GUESTBOOK_ADMIN_APP}</h2>
        {$CONST.PLUGIN_GUESTBOOK_ADMIN_APP_DESC}
    {/if}
    </div>
{elseif $gb_gbadd_view}
    <div class="gb_head">
    {if !empty($msg_header)}
        {call feedback}
    {else}
        <h2>{$CONST.PLUGIN_GUESTBOOK_ADMIN_VIEW}</h2>
        {$CONST.PLUGIN_GUESTBOOK_ADMIN_VIEW_DESC}
    {/if}
    </div>
{elseif $gb_gbadd_add}
    <div class="gb_head">
    {if !empty($msg_header)}
        {call feedback}
    {else}
        <h2>{$CONST.PLUGIN_GUESTBOOK_ADMIN_ADD}</h2>
    {/if}
    </div>
{/if}

{if $is_guestbook_message}{$msg_header=$error_occured}{call feedback}{/if}

{if $is_gbadmin_noappresult}
    <div class="msg_error"><span class="icon-attention-circled"></span> {$CONST.PLUGIN_GUESTBOOK_ADMIN_APP_NORESULT}</div>
{/if}
{if $is_gbadmin_noviewresult}
    <div class="msg_error"><span class="icon-attention-circled"></span> {$CONST.PLUGIN_GUESTBOOK_ADMIN_VIEW_NORESULT}</div>
{/if}
{if $is_gbadmin_nodbcdb}
    <div class="msg_error"><span class="icon-attention-circled"></span> {$CONST.PLUGIN_GUESTBOOK_ADMIN_DBC_NIXDA_DESC}</div>
{/if}

{if $guestbook_entries}

    <div class="gb_paginator">
        {$guestbook_paginator}
    </div>

    <div class="entries_pane">
        <ul id="entries_list" class="plainList zebra_list">
    {foreach $guestbook_entries as $entry}
            <li id="entry_{$entry.id}" class="clearfix {cycle values="odd,even"}">
                <form name="checkform" method="post" action="{$plugin_guestbook_backend_path}">
                <div>
                    <input type="hidden" name="guestbook[id]" value="{$entry.id}">
                    {if $entry.approved == 0}<input type="hidden" name="serendipity[guestbook_category]" value="gbapp">{/if}
                    {if isset($smarty.get.serendipity.guestbooklimit)}<input type="hidden" name="serendipity[guestbooklimit]" value="{$smarty.get.serendipity.guestbooklimit}">{/if}

                </div>

                <div class="gb_entryhead">
                    <span>
                        <a href="mailto:{$entry.email}">{$entry.name}</a>
                        {$CONST.PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY} <span class="icon-clock" title="{$CONST.TEXT_IMG_LASTMODIFIED}: {$entry.timestamp}"></span>
                    </span>
                {if $is_guestbook_admin_noapp != true}

                    <span class="gb_validation"><input type="image" class="gb_move" src="{$entry.pluginpath}img/notes-approve.gif" name="Approve_Selected" alt="notes-approve" title=" Approve " align="bottom"></span>
                {else}

                    <span class="gb_validation"><img class="gb_move" src="{$entry.pluginpath}img/notes-checkmark.gif" name="Approve_Selected" alt="notes-approve" title=" is approved already - no action " align="bottom"></span>
                {/if}

                    <span class="gb_validation"><input type="image" class="gb_move" src="{$entry.pluginpath}img/notes-change.gif" name="Change_Selected" alt="notes-change" title=" Change " align="bottom"></span>
                    <span class="gb_validation"><input type="image" class="gb_move" src="{$entry.pluginpath}img/notes-delete.gif" name="Reject_Selected" alt="notes-delete" title=" Reject immediately " align="bottom"></span>
                {if $entry.homepage}

                    <span>
                        {$CONST.TEXT_USERS_HOMEPAGE}: <a href="{$entry.homepage}" title="{$entry.homepage}" target="_blank">{$entry.homepage|truncate:24:'&hellip;'}</a>
                    </span>
                {/if}

                </div>

                <div class="gb_entrybody">
                    <label for="show">
                        <span class="icon-show"></span>
                    </label>
                    <input type=radio id="show" name="group">
                    <input type=radio id="hide" name="group">
                    <span class="gbboxfull">{$entry.body|replace:'&amp;quot;':'&quot;'}</span>
                    <span class="gbsummary">{$entry.body|strip|replace:'<br />':''|replace:'&amp;quot;':'&quot;'|truncate:50}</span>
                </div>
                </form>
            </li>
    {/foreach}
        </ul>
    </div>

    <div class="gb_paginator">
        {$guestbook_paginator}
    </div>

{/if}

<script>

jQuery(document).ready(function ($) {
    // hide all
    $('.gbboxfull').hide('fast');
    // shows the entry
    $('.icon-show').click(function() {
        $this = $(this);
        //console.log($this);
        $this.parent().siblings('.gbboxfull').toggle('slow');
        $this.parent().siblings('.gbsummary').toggle('slow');
        $this.toggleClass('icon-hide');
        return false;
    });
});

</script>


</div><!-- #wrapGB tpl end -->