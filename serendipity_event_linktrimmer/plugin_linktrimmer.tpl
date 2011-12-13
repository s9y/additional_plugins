{if $linktrimmer_external}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_MEDIA_BUTTON}</title>
        <meta http-equiv="Content-Type" content="text/html; charset={$CONST.LANG_CHARSET}" />

        <link rel="stylesheet" type="text/css" href="{$serendipityBaseURL}serendipity.css.php?serendipity[css_mode]=serendipity_admin.css" />

        <style type="text/css">
        {$linktrimmer_css}
        </style>
    </head>

    <body id="serendipity_admin_page" class="serendipity_linktrimmer_page">
        <div id="serendipityAdminMainpane">
{/if}

<div class="linktrimmer">
<form action="?" method="post">
<input type="hidden" name="txtarea" value="{$linktrimmer_txtarea|@escape:url}" />
<fieldset>
    <legend>{$CONST.PLUGIN_LINKTRIMMER_NAME}</legend>

    {if $linktrimmer_error}
        <div class="serendipity_msg_error">{$CONST.PLUGIN_LINKTRIMMER_ERROR}</div>
    {/if}

    <label for="linkname">{$CONST.PLUGIN_LINKTRIMMER_ENTER}</label>
        <input type="text" id="linktrimmer_url" class="input_textbox" name="linktrimmer_url" value="" />

    <label for="linkname">{$CONST.PLUGIN_LINKTRIMMER_HASH}</label>
        <input type="text" id="linktrimmer_hash" class="input_textbox" name="linktrimmer_hash" value="" />

        <input type="submit" name="submit" value="{$CONST.GO}" class="serendipityPrettyButton input_button" />

{if $linktrimmer_url != '' && $linktrimmer_external}
    <script type="text/javascript">
    self.opener.serendipity_imageSelector_addToBody('<a href="{$linktrimmer_url|@escape}" title="{$linktrimmer_origurl|@escape}">{$linktrimmer_origurl|@escape}</a>', '{$linktrimmer_txtarea|@escape}');
    self.close();
    </script>
{elseif $linktrimmer_url != ''}
    <label for="linkresult">{$CONST.PLUGIN_LINKTRIMMER_RESULT}</label>
        <input id="linktrimmer_result" type="text" class="input_textbox" name="linktrimmer_result" value="{$linktrimmer_url|@escape}" />
        <script type="text/javascript">
                document.getElementById('linktrimmer_result').select();
                document.getElementById('linktrimmer_result').focus();
        </script>
{else}
        <script type="text/javascript">
                document.getElementById('linktrimmer_url').select();
                document.getElementById('linktrimmer_url').focus();
        </script>
{/if}
</fieldset>
</form>
</div>

{if $linktrimmer_external}
</div>
</body>
</html>
{/if}
