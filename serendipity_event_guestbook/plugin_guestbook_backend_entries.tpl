{*
     plugin_guestbook_backend_entries v.3.40 - 2013-08-21 Ian
*}
<!-- plugin_guestbook_backend_entries start -->

{if $is_guestbook_message}
<div class="serendipity_center serendipity_msg_important guestbook_errorbundled">{$error_occured}
    {if $guestbook_messages}
        <ul>
        {foreach from=$guestbook_messages item="messages"}
            <li class="guestbook_errors">{$messages}</li>
        {/foreach}
        </ul>
    {/if}
</div><br />
{/if}

{if $guestbook_entries}

{if $guestbook_message_header !== true}
<div class="backend_guestbook_noresult"></div>
{/if}


<div class="backend_guestbook_paginator">

{$guestbook_paginator}

</div>

{foreach from=$guestbook_entries item="entry"}
<div id="guestbook_entrybundle_x">
    <div class="guestbook_entrytop">
        <form name="checkform" method="post" action="{$plugin_guestbook_backend_path}">
            <div>
                <input type="hidden" name="guestbook[id]" value="{$entry.id}" />
                {if $entry.approved == 0}<input type="hidden" name="serendipity[guestbook_category]" value="gbapp" />{/if}

            </div>

            <dl class="guestbook_entries">
                <dt>
                    <a href="mailto:{$entry.email}">{$entry.name}</a>
                    {$CONST.PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY} <img src="{$entry.pluginpath}img/shorttime.gif" width="14" height="17" onfocus="this.blur();" align="absmiddle" alt="{$CONST.TEXT_IMG_LASTMODIFIED}" title="{$CONST.TEXT_IMG_LASTMODIFIED}" />&nbsp;
                    {$entry.timestamp}
                </dt>
                {if $is_guestbook_admin_noapp != true}

                <dd class="guestbook_validation"><input type="image" class="guestbook_move" src="{$entry.pluginpath}img/notes-approve.gif" name="Approve_Selected" alt="notes-approve" title=" Approve " align="bottom" /></dd>
                {else}

                <dd class="guestbook_validation"><img class="guestbook_move" src="{$entry.pluginpath}img/notes-checkmark.gif" name="Approve_Selected" alt="notes-approve" title=" is approved already - no action " align="bottom" /></dd>
                {/if}

                <dd class="guestbook_validation"><input type="image" class="guestbook_move" src="{$entry.pluginpath}img/notes-change.gif" name="Change_Selected" alt="notes-change" title=" Change " align="bottom" /></dd>
                <dd class="guestbook_validation"><input type="image" class="guestbook_move" src="{$entry.pluginpath}img/notes-delete.gif" name="Reject_Selected" alt="notes-delete" title=" Reject immediately " align="bottom" /></dd>
                {if $entry.homepage}

                <dt>
                    {$CONST.TEXT_USERS_HOMEPAGE}: <a href="{$entry.homepage}" target="_blank">{$entry.homepage|truncate:24:'...'}</a>
                </dt>
                {/if}

            </dl>

            <dl class="guestbook_entrybottom">
                <dt>
                    {$entry.body}
                </dt>
            </dl>
    </form>
  </div> <!-- //- class:guestbook_entrytop end -->
</div> <!-- //- id:guestbook_entrybundle_x end -->

{/foreach}

<div class="backend_guestbook_paginator">

{$guestbook_paginator}

</div>

{/if}
