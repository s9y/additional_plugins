{*
 plugin_guestbook_backend_form.tpl v.3.50 2014-06-14 Ian
 *}

<!-- plugin_guestbook_backend_form start -->

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


    <div class="guestbook_backend_form">
      <a id="serendipity_CommentForm"></a>
      <form name="guestbookEntry" id="guestbookEntry" action="{$plugin_guestbook_backend_path}" method="post">
        <div>
          <input type="hidden" name="guestbook[id]" value="{$plugin_guestbook_id}">
          <input type="hidden" name="guestbook[ip]" value="{$plugin_guestbook_ip}">
          <input type="hidden" name="guestbook[timestamp]" value="{$plugin_guestbook_ts}">
          <input type="hidden" name="guestbook[approved]" value="{$plugin_guestbook_app}">
          <input type="hidden" name="serendipity[guestbookform]" value="true">
        </div>

        <div class="input-text">
          <label for="serendipity_guestbookform_name">{$CONST.NAME}</label>
          <input id="serendipity_guestbookform_name" name="serendipity[name]" value="{$plugin_guestbook_name}" size="60" maxlength="29" type="text">
        </div>

       {if $is_show_mail}
        <div class="input-text">
            <label for="serendipity_commentform_email">{$CONST.EMAIL}</label>
            <input type="text" size="60" maxlength="99" name="serendipity[email]" value="{$plugin_guestbook_email}" id="serendipity_commentform_email">
            <div class="guestbook_emailprotect">{$CONST.PLUGIN_GUESTBOOK_PROTECTION}</div>
        </div>
       {/if}

       {if $is_show_url}
        <div class="input-text">
            <label for="serendipity_commentform_url">{$CONST.URL}</label>
            <input type="text" size="60" maxlength="99" name="serendipity[url]" value="{$plugin_guestbook_url}" id="serendipity_commentform_url">
        </div>
       {/if}

        <div class="input-textarea">
            <label for="serendipity_commentform_comment">{$CONST.BODY}</label>
            <textarea cols="100" rows="8" name="serendipity[comment]" id="serendipity_commentform_comment">{$plugin_guestbook_comment}</textarea>
            {serendipity_hookPlugin hook="frontend_comment" data=$plugin_guestbook_entry}
        </div>

        {if $plugin_guestbook_id}
        <div class="input-buttons">
            {if $is_logged_in && $plugin_guestbook_id}<br><sup>{$CONST.PLUGIN_GUESTBOOK_FORM_RIGHT_BBC}</sup><br>
            <input type="button" class="input_button bbc_i" name="insI" value="I" accesskey="i" onclick="serendipity.wrapSelection(document.forms['guestbookEntry']['serendipity[admincomment]'],'[i]','[/i]')">
            <input type="button" class="input_button bbc_b" name="insB" value="B" accesskey="b" onclick="serendipity.wrapSelection(document.forms['guestbookEntry']['serendipity[admincomment]'],'[b]','[/b]')">
            <input type="button" class="input_button bbc_u" name="insU" value="U" accesskey="u" onclick="serendipity.wrapSelection(document.forms['guestbookEntry']['serendipity[admincomment]'],'[u]','[/u]')">
            <input type="button" class="input_button bbc_s" name="insS" value="S" accesskey="s" onclick="serendipity.wrapSelection(document.forms['guestbookEntry']['serendipity[admincomment]'],'[s]','[/s]')">
            <input type="button" class="input_button bbc_q" name="insQ" value="Q" accesskey="q" onclick="serendipity.wrapSelection(document.forms['guestbookEntry']['serendipity[admincomment]'],'[q]','[/q]')">
            {/if}
        </div>

        <div class="input-textarea">
            <label for="serendipity_commentform_comment">{$CONST.PLUGIN_GUESTBOOK_ADMINBODY}</label>
            <textarea cols="100" rows="6" name="serendipity[admincomment]" id="serendipity_guestbookform_admincomment">{$plugin_guestbook_ac_comment}</textarea>
        </div>
        {/if}

        <div class="input-buttons">
             <input type="submit" class="input_button state_submit" name="serendipity[submit]" value="{$CONST.SUBMIT}">
        </div>

      </form>
    </div>
        
</div><!-- #wrapGB tpl end -->