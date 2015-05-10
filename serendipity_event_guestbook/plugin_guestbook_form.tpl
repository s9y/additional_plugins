{*
  plugin_guestbook_form.tpl v.3.28 - 2015-05-10 ian
 *}

    <!-- Needed for Captchas -->
    {foreach from=$plugin_guestbook_messagestack item="message"}
    <p class="serendipity_center serendipity_msg_important">{$message}</p>
    {/foreach}

    <div id="comments" class="serendipity_comments serendipity_section_comments">
      <a id="serendipity_CommentForm"></a>
      <form id="serendipity_comment" action="{$is_guestbook_url}#feedback" method="post">
        <div>
            <input type="hidden" name="serendipity[subpage]" value="{$plugin_guestbook_sname}" />
            <input type="hidden" name="serendipity[guestbookform]" value="true" />
        </div>

        <div class="input-text">
            <label for="serendipity_commentform_name">{$CONST.NAME}</label>
            <input type="text" size="30" maxlength="39" name="serendipity[name]" value="{$plugin_guestbook_name}" id="serendipity_commentform_name" />
        </div>
        
       {if $is_show_mail}
        <div class="input-text">
            <label for="serendipity_commentform_email">{$CONST.EMAIL}</label>
            <input type="text" size="30" maxlength="99" name="serendipity[email]" value="{$plugin_guestbook_email}" id="serendipity_commentform_email" />
            <div class="guestbook_emailprotect">{$plugin_guestbook_emailprotect}</div>
        </div>
       {/if}

       {if $is_show_url}
        <div class="input-text">
            <label for="serendipity_commentform_url">{$CONST.TEXT_HOMEPAGE}</label>
            <input type="text" size="30" maxlength="99" name="serendipity[url]" value="{$plugin_guestbook_url}" id="serendipity_commentform_url" />
        </div>
       {/if}

        <div class="input-textarea">
            <label for="serendipity_commentform_comment">{$CONST.BODY}</label>
            <textarea cols="40" rows="10" name="serendipity[comment]" id="serendipity_commentform_comment">{$plugin_guestbook_comment}</textarea>
            {serendipity_hookPlugin hook="frontend_comment" data=$plugin_guestbook_entry}
        </div>

        <div id="directions">
             <div class="serendipity_commentDirection">{$plugin_guestbook_captcha}</div>
        </div>

        <div class="input-buttons">
             <input type="submit" name="serendipity[submit]" value="{$CONST.SUBMIT}" />
        </div>

      </form>
    </div>
