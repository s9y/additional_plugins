
<h3 class="serendipity_date">{$pagetitle}</h3>
<h4 class="serendipity_title"><a href="#">{$threadtitle}</a></h4>
<br />

<div class="serendipity_entry">
    
    
    {if $ERRORMSG}
        <div align="center"><span style="color: #ff0000; font-weight: bolder;">{$ERRORMSG}</span></div><br /><br />
    {/if}
    
    {if $paging || $notify}
        <table class="serendipity_date" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="serendipity_date">
                {if $notify}<td align="left"><span class="serendipity_date">
                    {if $notify eq 1}<a href="{$subscribeurl}">{$CONST.PLUGIN_FORUM_SUBSCRIBE}</a>
                    {elseif $notify eq 2}<a href="{$unsubscribeurl}">{$CONST.PLUGIN_FORUM_UNSUBSCRIBE}</a>
                    {/if}</span></td>{/if}
                {if $paging}<td align="right"><span class="serendipity_date">{$paging}</span></td>{/if}
            </tr>
        </table><br />
    {/if}
    
    <span class="serendipity_date"><b>{$MAINPAGE} &gt; {$THREADLIST} &gt; {$POSTS}</b></span><br />
    
    {if $noposts}
        <div align="center"><b>{$noposts}</b></div>
    {else}
    
    <table width="100%" cellspacing="1" cellpadding="2" border="0">
        <tr style="background-color: {$bgcolor_head};">
            <th width="100" height="26" nowrap="nowrap">{$CONST.PLUGIN_FORUM_AUTHOR}</th>
            <th nowrap="nowrap">{$CONST.PLUGIN_FORUM_MESSAGE}</th>
        </tr>
        
        {foreach name=postlist item=post from=$posts}
        
            <tr style="background-color: {$post.color};">
                <td width="100" align="left" valign="top">
                    <a name="{$post.postid}"></a><b>{$post.authorname}</b><br />
                    <br />{if $post.gravatar}
                    {$post.gravatar}<br /><br />
                    {/if}{if $post.authordetails}
                    <span class="serendipity_date">{$post.authordetails}</span><br />{/if}
                </td>
                <td width="100%" height="28" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="100%">
                                {$post.postdate} &nbsp; <b>{$post.title}</b>
                            </td>
                        </tr>
                        <tr>
                            <td><hr /></td>
                        </tr>
                        <tr>
                            <td>{if $post.uploads}
                                <table class="forum-filebox" width="120" align="right" border="0" cellpadding="2" cellspacing="2">
                                    {foreach name=uploadlist item=upload from=$post.upload}
                                        
                                        <tr>
                                            <td align="center" class="serendipity_date" nowrap="nowrap">
                                                <span class="serendipity_date">
                                                {$upload.fileicon}&nbsp;&nbsp;&nbsp;<b>{$upload.filename}</b>&nbsp;&nbsp;&nbsp;{$upload.delbutton}<br />
                                                {$upload.filesize}<br />
                                                {$upload.filetype}<br />
                                                {$CONST.PLUGIN_FORUM_DOWNLOADCOUNT} {$upload.dlcount}
                                                </span>
                                            </td>
                                        </tr>
                                        
                                    {/foreach}
                                </table>
                            {/if}{$post.message}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="background-color: {$post.color}">
                <td width="100" align="left" valign="middle">
                    <a href="#top" class="nav">{$CONST.PLUGIN_FORUM_BACKTOTOP}</a>
                </td>
                <td width="100%" height="28" valign="bottom" nowrap="nowrap">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" height="18" width="18">
                        <tr>
                            <td valign="absmiddle" align="right" nowrap="nowrap">
                                {$post.postbuttons}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        {/foreach}
        
    </table><br />
    
    {/if}
    
    {if $paging || $notify}
        <table class="serendipity_date" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="serendipity_date">
                {if $notify}<td align="left"><span class="serendipity_date">
                    {if $notify eq 1}<a href="{$subscribeurl}">{$CONST.PLUGIN_FORUM_SUBSCRIBE}</a>
                    {elseif $notify eq 2}<a href="{$unsubscribeurl}">{$CONST.PLUGIN_FORUM_UNSUBSCRIBE}</a>
                    {/if}</span></td>{/if}
                {if $paging}<td align="right"><span class="serendipity_date">{$paging}</span></td>{/if}
            </tr>
        </table>
    {/if}
    
    <div align="center">{$THREADBUTTONS}</div>
    
</div>
