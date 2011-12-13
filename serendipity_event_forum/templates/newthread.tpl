
<h3 class="serendipity_date">{$pagetitle}</h3>
<h4 class="serendipity_title"><a href="{$ACTUALURL}">{$boardname}</a></h4>
<br />

<div class="serendipity_entry">
    
    {if $ERRORMSG}
        <div align="center"><span style="color: #ff0000; font-weight: bolder;">{$ERRORMSG}</span></div><br />
    {/if}
    
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <form id="serendipity_comment" name="postform" action="{$ACTUALURL}" method="POST"{if $uploadform} enctype="multipart/form-data"{/if}>
            <input type="hidden" name="serendipity[action]" value="edit" />
            <input type="hidden" name="serendipity[boardid]" value="{$boardid}" />
            <input type="hidden" name="serendipity[action]" value="newthread" />
            <input type="hidden" name="serendipity[commentform]" value="true" />
            {if $uploadform}<input type="hidden" name="serendipity[uploaded]" value="1" />{/if}
        
        
        <tr style="background-color: {$bgcolor2};">
            <td width="100">{$CONST.PLUGIN_FORUM_AUTHOR}</td>
            <td><input style="width: 95%;" width="95%" type="text" name="serendipity[authorname]" value="{$POST_AUTHORNAME}" /></td>
        </tr>
        
        
        <tr style="background-color: {$bgcolor2};">
            <td width="100">{$CONST.PLUGIN_FORUM_POSTTITLE}</td>
            <td><input style="width: 95%;" width="95%" type="text" name="serendipity[title]" value="{$POST_TITLE}" /></td>
        </tr>
        
        
        <tr style="background-color: {$bgcolor2};">
            <td rowspan="2" width="100" valign="top">{$CONST.PLUGIN_FORUM_MESSAGE}<br />
                <br />
                <br />
                <br />
                <span class="serendipity_date">{$CONST.PLUGIN_FORUM_MARKUPS}</span>
            </td>
            <td align="center">
                <script type="text/javascript" language="JavaScript" src="serendipity_define.js.php"></script>
                <script type="text/javascript" language="JavaScript" src="{$relpath}/include/ColorPicker2.js"></script>
                <script type="text/javascript" language="JavaScript" src="{$relpath}/include/bbcode.js"></script>
                {$bbcode}
            </td>
        </tr>
        <tr style="background-color: {$bgcolor2};">
            <td><textarea style="width: 95%;" rows="12" width="95%" id="serendipity[comment]" name="serendipity[comment]">{$POST_MESSAGE}</textarea><br />
                {if $commentform_entry}{serendipity_hookPlugin hook="frontend_comment" data=$commentform_entry}{/if}</td>
        </tr>
        
        
        {if $announcement}
            <tr style="background-color: {$bgcolor2};">
                <td width="100">{$CONST.PLUGIN_FORUM_ANNOUNCEMENT}</td>
                <td><input type="checkbox" name="serendipity[announcement]" value="1" /></td>
            </tr>
        {/if}
        
        
        {if $uploadform}
            {foreach name=uploadfields item=upload from=$uploads}
                <tr style="background-color: {$bgcolor2};">
                    <td width="100">{$upload}. {$CONST.PLUGIN_FORUM_UPLOAD_FILE}</td>
                    <td><input type="hidden" name="MAX_FILE_SIZE" value="{$MAX_FILE_SIZE}" />
                        <input style="width: 95%;" width="95%" size="42" type="file" name="forum_upload[]" /></td>
                </tr>
            {/foreach}
		<tr style="background-color: {$bgcolor2};">
			<td width="100" valign="top">{$CONST.PLUGIN_FORUM_UPLOAD_OVERWRITE}</td>
			<td><input type="checkbox" name="serendipity[upload_overwrite]" value="1" /> {$CONST.PLUGIN_FORUM_UPLOAD_OVERWRITE_BLAHBLAH}</td>
		</tr>
        <tr style="background-color: {$bgcolor2};">
            <td colspan="2" align="center">
                <table width="270" border="0" cellspacing="0" cellpadding="2" align="center">
                    <tr>
                        <td>
                            {$uploads_post_left} {$CONST.PLUGIN_FORUM_REST_UPLOAD_POST}<br />
                            {$uploads_user_left} {$CONST.PLUGIN_FORUM_REST_UPLOAD_USER}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        {/if}
        
        <tr style="background-color: {$bgcolor2};">
            <td colspan="2" align="center"><input type="submit" name="serendipity[submit]" value="{$CONST.PLUGIN_FORUM_SUBMIT}" /> &nbsp; &nbsp; <input type="reset" name="reset" value="{$CONST.PLUGIN_FORUM_RESET}" /></td>
        </tr>
        
        
        </form>
    </table>
    
</div>
