{if $plugin_contactform_articleformat}
<div class="serendipity_Entry_Date">
    <h3 class="serendipity_date">{$plugin_contactform_name}</h3>
{/if}
    
<h4 class="serendipity_title"><a href="#">{$plugin_contactform_pagetitle}</a></h4>
            
{if $plugin_contactform_articleformat}
<div class="serendipity_entry"><div class="serendipity_entry_body">
{/if}

<div>
    {$plugin_contactform_preface}
</div>
<br /><br />

{if $is_contactform_sent}
<div class="serendipity_center serendipity_msg_notice">
    {$plugin_contactform_sent}
</div>
{else}

{if $is_contactform_error}
<div class="serendipity_center serendipity_msg_important">
    {$plugin_contactform_error}
</div>
<br /><br />

<!-- Needed for Captchas -->
{foreach from=$comments_messagestack item="message"}
<div class="serendipity_center serendipity_msg_important">{$message}</div>
{/foreach}
{/if}

<!-- This whole commentform style, including field names is needed for Captchas. The spamblock plugin relies on the field names [name], [email], [url], [comment]! -->
<div class="serendipityCommentForm">
    <a id="serendipity_CommentForm"></a>
    <form id="serendipity_comment" action="{$commentform_action}#feedback" method="post">
    <div>
        <input type="hidden" name="serendipity[subpage]" value="{$commentform_sname}" />
        <input type="hidden" name="serendipity[commentform]" value="true" />
    </div>
    <table border="0" width="100%" cellpadding="3">
        <tr>
            <td class="serendipity_commentsLabel"><label for="serendipity_commentform_name">{$CONST.NAME}</label></td>
            <td class="serendipity_commentsValue"><input type="text" id="serendipity_commentform_name" name="serendipity[name]" value="{$commentform_name}" size="30" /></td>
        </tr>

        <tr>
            <td class="serendipity_commentsLabel"><label for="serendipity_commentform_email">{$CONST.EMAIL}</label></td>
            <td class="serendipity_commentsValue"><input type="text" id="serendipity_commentform_email" name="serendipity[email]" value="{$commentform_email}" /></td>
        </tr>

        <tr>
            <td class="serendipity_commentsLabel"><label for="serendipity_commentform_url">{$CONST.HOMEPAGE}</label></td>
            <td class="serendipity_commentsValue"><input type="text" id="serendipity_commentform_url" name="serendipity[url]" value="{$commentform_url}" /></td>
        </tr>

        <tr>
            <td class="serendipity_commentsLabel"><label for="serendipity_commentform_comment">{$plugin_contactform_message}</label></td>
            <td class="serendipity_commentsValue">
                <textarea rows="10" cols="40" id="serendipity_commentform_comment" name="serendipity[comment]">{$commentform_data}</textarea><br />
                <!-- This is where the spamblock/Captcha plugin is called -->
                {serendipity_hookPlugin hook="frontend_comment" data=$commentform_entry}
            </td>
        </tr>

       <tr>
            <td>&#160;</td>
            <td><input type="submit" name="serendipity[submit]" value="{$CONST.SUBMIT_COMMENT}" /></td>
        </tr>
    </table>
    </form>
</div>
{/if}

{if $plugin_contactform_articleformat}
</div></div></div>
{/if}
