<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
           "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>{$blogTitle}</title>
    <meta http-equiv="Content-Type" content="text/html; charset={$head_charset}" />
    <meta name="Powered-By" content="Serendipity v.{$head_version}" />
    <link rel="stylesheet" type="text/css" href="{$head_link_stylesheet}" />
</head>

<body id="serendipity_loginform">

{if $close_window}

<script type="text/javascript">
if (window && window.opener && window.opener.focus)
    window.opener.focus();
{if $is_logged_in}
alert('{$CONST.USER_SELF_INFO|@sprintf:$loginform_user:$loginform_mail}');
{/if}
self.close();
</script>

{elseif $is_logged_in}

<div>
    {$CONST.USER_SELF_INFO|@sprintf:$loginform_user:$loginform_mail}

    <form action="{$loginform_url}" method="post">
        <input type="hidden" name="serendipity[action]" value="logout" />
        <input type="hidden" name="serendipity[logout]" value="logout" />

        <table cellspacing="10" cellpadding="0" border="0" align="center">
            <tr>
                <td colspan="2" align="right"><input type="submit" name="serendipity[submit]" value="{$CONST.LOGOUT} &gt;" class="serendipityPrettyButton" /></td>
            </tr>
        </table>
    </form>
</div>

{else}
    <div id="login_instructions">
        {$CONST.PLEASE_ENTER_CREDENTIALS}
        {$loginform_add.header}
    </div>

    {if $is_error}
        <div class="login_error">{$CONST.WRONG_USERNAME_OR_PASSWORD}</div>
    {/if}

    <form action="{$loginform_url}" method="post">
        <input type="hidden" name="serendipity[action]" value="login" />
        <table cellspacing="10" cellpadding="0" border="0" align="center">
            <tr>
                <td>{$CONST.USERNAME}</td>
                <td><input type="text" name="serendipity[user]" /></td>
            </tr>
            <tr>
                <td>{$CONST.PASSWORD}</td>
                <td><input type="password" name="serendipity[pass]" /></td>
            </tr>
            <tr>
                <td colspan="2"><input id="autologin" type="checkbox" name="serendipity[auto]" /><label for="autologin"> {$CONST.AUTOMATIC_LOGIN}</label></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><input type="submit" name="submit" value="{$CONST.LOGIN} &gt;" class="serendipityPrettyButton" /></td>
            </tr>
            {$loginform_add.table}
        </table>
    </form>
{/if}

</body>