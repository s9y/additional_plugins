<script type="text/javascript" src="{$serendipityHTTPPath}plugins/serendipity_event_suggest/suggest.js"></script>

<div class="serendipity_Entry_Date">
    <h3 class="serendipity_date">{$plugin_suggest_name}</h3>
    
    <h4 class="serendipity_title"><a href="#">{$plugin_suggest_name}</a></h4>
                
    <div class="serendipity_entry">
        <div class="serendipity_entry_body">

{if $suggest_validation_success}

            <div class="serendipity_center serendipity_msg_notice">
            	{$CONST.PLUGIN_SUGGEST_VALIDATE}.<br />
            </div>

{elseif $suggest_validation_error}

            <div class="serendipity_center serendipity_msg_notice">
            	{$CONST.PLUGIN_SUGGEST_VALIDATE_ERROR}
            </div>

{elseif $is_suggest_sent}
            <div class="serendipity_center serendipity_msg_notice">
            	{$CONST.PLUGIN_SUGGEST_NOTE}
            </div>
{else}
        	{if $is_suggest_error}
            <div class="serendipity_center serendipity_msg_important">
    	        {$plugin_suggest_error}
            </div>
            <br /><br />
            
            <!-- Needed for Captchas -->
            {foreach from=$comments_messagestack item="message"}
            <div class="serendipity_center serendipity_msg_important">
                {$message}
            </div>
            {/foreach}
    	    {/if}

            <div class="info">
                <p>{$CONST.PLUGIN_SUGGEST_INTRO}</p>
            </div>

            <!-- This whole suggest style, including field names is needed for Captchas. The spamblock plugin relies on the field names [name], [email], [url], [comment]! -->
            <div class="serendipitySuggest">
                <a id="serendipity_SuggestForm"></a>
                <form onsubmit="return checkSuggest()" id="serendipity_comment" action="{$suggest_action}#feedback" method="post">
                    <div>
                    	<input type="hidden" name="serendipity[subpage]" value="{$suggest_sname}" />
                		<input type="hidden" name="serendipity[suggestform]" value="true" />
                	</div>
        
                    <table border="0" width="100%" cellpadding="3">
                        <tr>
                            <td class="serendipity_commentsLabel"><label for="serendipity_suggest_name">{$CONST.NAME}</label></td>
                            <td class="serendipity_commentsValue"><input type="text" id="serendipity_suggest_name" name="serendipity[name]" value="{$suggest_name}" size="30" /></td>
                        </tr>
                
                        <tr>
                            <td class="serendipity_commentsLabel"><label for="serendipity_suggest_email">{$CONST.EMAIL}</label></td>
                            <td class="serendipity_commentsValue"><input type="text" id="serendipity_suggest_email" name="serendipity[email]" value="{$suggest_email}" /></td>
                        </tr>
                
                        <tr>
                            <td class="serendipity_commentsLabel"><label for="serendipity_suggest_title">{$CONST.TITLE}</label></td>
                            <td class="serendipity_commentsValue"><input type="text" id="serendipity_suggest_title" name="serendipity[entry_title]" value="{$suggest_entry_title}" /></td>
                        </tr>
                
                        <tr>
                            <td class="serendipity_commentsLabel"><label for="serendipity_suggest_comment">{$CONST.ENTRY_BODY}</label></td>
                            <td class="serendipity_commentsValue">
                              <script type="text/javascript">
                                    document.write('<div class="toolbar">');
                                    document.write('<input type="button" class="serendipityPrettyButton" name="insB"   value="B"   accesskey="b" style="font-weight: bold" onclick="wrapSelection(document.getElementById(\'serendipity_suggest_article\'), \'<strong>\', \'</strong>\')" />');
                                    document.write('<input type="button" class="serendipityPrettyButton" name="insURL" value="URL" accesskey="l" onclick="wrapSelectionWithLink(document.getElementById(\'serendipity_suggest_article\'))" />');
                                    document.write('</div>');
                              </script>

                                <textarea rows="20" cols="50" id="serendipity_suggest_article" name="serendipity[comment]">{$suggest_data}</textarea><br />
                                <!-- This is where the spamblock/Captcha plugin is called -->
                                {serendipity_hookPlugin hook="frontend_comment" data=$suggest_entry}
                            </td>
                        </tr>
                
                        <tr>
                            <td>&#160;</td>
                            <td>
                                <input type="submit" name="serendipity[submit]" value="{$CONST.PLUGIN_SUGGEST_SEND}" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
{/if}
        </div>
    </div>
</div>
