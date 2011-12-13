{*
 plugin_guestbook_backend_form start v.3.27 2011-06-27 ian
 *}

{foreach from=$plugin_guestbook_messagestack item="message"}
    <div class="serendipity_center serendipity_msg_important">{$message}</div>
{/foreach}

{if $is_guestbook_message}
<div class="backend_guestbook_noresult serendipity_center serendipity_msg_important">
    <h3>{$attention}{$error_occured}</h3>

    {if $guestbook_messages}
    <ul>
    {foreach from=$guestbook_messages item="messages"}
        <li class="guestbook_errors">{$messages}</li>
    {/foreach}
    </ul>
    {/if}
</div>
{/if}

<div class="backend_guestbook_entrywrapper">
        
    <div class="guestbook_backend_form">
      <a id="serendipity_CommentForm"></a>
      <form name="guestbookEntry" id="guestbookEntry" action="{$plugin_guestbook_backend_path}" method="post">
        <div>
          <input type="hidden" name="guestbook[id]" value="{$plugin_guestbook_id}" /> 
          <input type="hidden" name="guestbook[ip]" value="{$plugin_guestbook_ip}" /> 
          <input type="hidden" name="guestbook[timestamp]" value="{$plugin_guestbook_ts}" /> 
          <input type="hidden" name="guestbook[approved]" value="{$plugin_guestbook_app}" /> 
          <input type="hidden" name="serendipity[guestbookform]" value="true" />
        </div>

        <div class="input-text">
          <label for="serendipity_guestbookform_name">{$CONST.NAME}</label>
          <input id="serendipity_guestbookform_name" name="serendipity[name]" value="{$plugin_guestbook_name}" size="60" maxlength="29" type="text" />
        </div>

       {if $is_show_mail}
        <div class="input-text">
            <label for="serendipity_commentform_email">{$CONST.EMAIL}</label>
            <input type="text" size="60" maxlength="99" name="serendipity[email]" value="{$plugin_guestbook_email}" id="serendipity_commentform_email" />
            <div class="serendipity_commentform_email guestbook_emailprotect">{$CONST.PLUGIN_GUESTBOOK_PROTECTION}</div>
        </div>
       {/if}

       {if $is_show_url}
        <div class="input-text">
            <label for="serendipity_commentform_email">{$CONST.URL}</label>
            <input type="text" size="60" maxlength="99" name="serendipity[url]" value="{$plugin_guestbook_url}" id="serendipity_commentform_url" />
        </div>
       {/if}

        <div class="input-textarea">
            <label for="serendipity_commentform_comment">{$CONST.BODY}</label>
            <textarea cols="100" rows="8" name="serendipity[comment]" id="serendipity_commentform_comment">{$plugin_guestbook_comment}</textarea>
            {serendipity_hookPlugin hook="frontend_comment" data=$plugin_guestbook_entry}
        </div>

        {if $plugin_guestbook_id}
        <div class="input-buttons guestbookformdesc">
          <div class="">
            {if $is_logged_in && $plugin_guestbook_id}<br /><br /><sup>{$CONST.PLUGIN_GUESTBOOK_FORM_RIGHT_BBC}</sup><br />
            <input type="button" class="serendipityPrettyButton bbc_i" name="insI" value="I" accesskey="i" onclick="wrapSelection(document.forms['guestbookEntry']['serendipity[admincomment]'],'[i]','[/i]')" />
            <input type="button" class="serendipityPrettyButton bbc_b" name="insB" value="B" accesskey="b" onclick="wrapSelection(document.forms['guestbookEntry']['serendipity[admincomment]'],'[b]','[/b]')" />
            <input type="button" class="serendipityPrettyButton bbc_u" name="insU" value="U" accesskey="u" onclick="wrapSelection(document.forms['guestbookEntry']['serendipity[admincomment]'],'[u]','[/u]')" />
            <input type="button" class="serendipityPrettyButton bbc_s" name="insS" value="S" accesskey="s" onclick="wrapSelection(document.forms['guestbookEntry']['serendipity[admincomment]'],'[s]','[/s]')" />
            <input type="button" class="serendipityPrettyButton bbc_q" name="insQ" value="Q" accesskey="q" onclick="wrapSelection(document.forms['guestbookEntry']['serendipity[admincomment]'],'[q]','[/q]')" />
            {/if}
          <div>
        </div>

        <div class="input-textarea">
            <label for="serendipity_commentform_comment">{$CONST.PLUGIN_GUESTBOOK_ADMINBODY}</label>
            <textarea cols="100" rows="6" name="serendipity[admincomment]" id="serendipity_guestbookform_admincomment">{$plugin_guestbook_ac_comment}</textarea>
        </div>
        {/if}

        <div class="input-buttons">
             <input type="submit" class="serendipityPrettyButton" name="serendipity[submit]" value="{$CONST.SUBMIT}" />
        </div>

       {if $is_logged_in}
       <script type="text/javascript" language="JavaScript" src="{$serendipityHTTPPath}serendipity_editor.js"></script>
       {/if}

      </form>
    </div>
        
</div><!-- // class:backend_guestbook_entrywrapper end -->
