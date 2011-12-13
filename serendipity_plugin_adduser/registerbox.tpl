{* This variable is hardcoded in the template currently. Set it to TRUE
   if you want this form to require the user to accept some kind of
   Terms of Use before he can be registered. *}
{assign var="registerbox_termsofuse" value="false"}
{assign var="registerbox_termsofuse_error" value="You must accept the terms of use before continuing."}
{capture name="registerbox_termsofuse_text"}
I agree to the <a href="#">Terms of Use</a>.
{/capture}


{* Form starts here *}
<form id="adduserform" action="{$registerbox_url}#adduser" method="post" {if $registerbox_termsofuse == 'true'}onsubmit="if (document.getElementById('registerbox_termsofuse').checked != true) {ldelim} alert('{$registerbox_termsofuse_error|@escape:javascript}'); return false {rdelim}"{/if}>
    <div>
    {foreach from=$registerbox_hidden item="val" key="key"}
        <input type="hidden" name="serendipity[{$key}]" value="{$val|@escape}" />
    {/foreach}
    
    <div>
        {$registerbox_instructions}
    </div>
    
    <br />
    
    <div>
        <label for="registerbox_username">{$CONST.USERNAME}</label> <input id="registerbox_username" type="text" name="serendipity[adduser_user]" maxlength="40" value="{$registerbox_username|@escape}" /><br />
        <label for="registerbox_password">{$CONST.PASSWORD}</label> <input id="registerbox_password" type="password" name="serendipity[adduser_pass]" maxlength="32" value="{$registerbox_password|@escape}" /><br />
        <label for="registerbox_email">{$CONST.EMAIL}</label>       <input id="registerbox_email" type="text" name="serendipity[adduser_email]" value="{$registerbox_email|@escape}" /><br />
    </div>

    {if $registerbox_termsofuse == 'true'}
    <div>
        <input type="checkbox" name="serendipity[adduser_termsofuse]" value="true" id="registerbox_termsofuse" style="display:inline; width: auto" /> <label for="registerbox_termsofuse">{$smarty.capture.registerbox_termsofuse_text}</label>
    </div>
    {/if}
    
    {if $registerbox_captcha == 'true'}
    <div>
        <!-- This is where the spamblock/Captcha plugin is called -->
        {serendipity_hookPlugin hook="frontend_comment" data=$registerbox_url}
    </div>
    {/if}
    
    <input type="submit" name="serendipity[adduser_action]" value="{$CONST.GO} &gt;" />
    </div>
</form>