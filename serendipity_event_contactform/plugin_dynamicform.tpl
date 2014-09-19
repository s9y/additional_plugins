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
         {foreach name="field" from=$commentform_dynamicfields item="field"}
            {if $field.type == "hidden"}
                <input type="hidden" name="serendipity[{$field.id}]" value="{$field.default}" />
            {/if}
         {/foreach}
    </div>
    <table border="0" width="100%" cellpadding="3">
       {foreach name="field" from=$commentform_dynamicfields item="field"}
          {if $field.type != "hidden"}
           <tr>
              <td class="serendipity_commentsLabel">{if $field.required}<sup>*</sup>{/if}<label for="serendipity_commentform_{$field.id}">{$field.name}</label></td>
              <td class="serendipity_commentsValue">
                 {if $field.type == "checkbox"}
                       <input type="checkbox" name="{$field.id}" id="{$field.id}" {$field.default} /><label for="{$field.id}">{$field.message}</label>
                 {elseif $field.type == "radio"}
                    {foreach name="radio_option" from=$field.options item="option"}
                       <input type="radio" name="{$field.id}" id="{$field.id}.{$option.id}" value="{$option.value}" {$option.default} /><label for="{$field.id}.{$option.id}">{$option.name}</label>
                    {/foreach}
                 {elseif $field.type == "select"}<select name="{$field.id}">
                    {foreach name="radio_option" from=$field.options item="option"}
                       <option name="{$field.id}" id="{$field.id}.{$option.id}" value="{$option.value}" {$option.default} >{$option.name}</option>
                    {/foreach}</select>
                 {elseif $field.type == "password"}
                     <input type="password" id="serendipity_commentform_{$field.id}" name="serendipity[{$field.id}]" value="{$field.default}" size="30" />
                 {elseif $field.type == "textarea"}
                     <textarea rows="10" cols="40" id="serendipity_commentform_{$field.id}" name="serendipity[{$field.id}]">{$field.default}</textarea><br />
                 {else}
                     <input type="text" id="serendipity_commentform_{$field.id}" name="serendipity[{$field.id}]" value="{$field.default}" size="30" />
                 {/if}
              </td>
           </tr>
          {/if}
        {/foreach}

        <tr>
            <td>&#160;</td>
            <td>
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
