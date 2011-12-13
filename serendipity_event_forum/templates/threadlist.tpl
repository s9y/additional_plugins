
<h3 class="serendipity_date">{$pagetitle}</h3>
<h4 class="serendipity_title"><a href="#">{$headline}</a></h4>
<br />

<div class="serendipity_entry">
    <div align="right"><a href="{$newthreadurl}"><img src="{$relpath}/img/new_thread.png" alt="{$CONST.FORUM_PLUGIN_NEW_THREAD}" title="{$CONST.FORUM_PLUGIN_NEW_THREAD}" border="0" /></a></div>
    {if $paging}
        <br /><div align="right"><span class="serendipity_date">{$paging}</span></div><br />
    {/if}
    <span class="serendipity_date"><b>{$MAINPAGE} &gt; {$THREADLIST}</b></span><br />
    
    {if $nothreads}
        <div align="center"><b>{$nothreads}</b></div>
    {else}
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
        
        <tr style="background-color: {$bgcolor_head};">
            <td width="20">&nbsp;</td>
            <td><b>{$CONST.PLUGIN_FORUM_THREADTITLE}</b></td>
            <td width="60" align="right"><b>{$CONST.PLUGIN_FORUM_REPLIES}</b></td>
            <td width="60" align="right"><b>{$CONST.PLUGIN_FORUM_VIEWS}</b></td>
            <td width="140"><b>{$CONST.PLUGIN_FORUM_LASTREPLY}</b></td>
        </tr>
        
        {foreach name=threadlist item=thread from=$threads}
            <tr style="background-color: {$thread.color};">
                <td width="20">{$thread.icon}</td>
                <td><a href="./index.php?serendipity[subpage]={$pageurl}&amp;boardid={$thread.boardid}&amp;threadid={$thread.threadid}"><b>{$thread.title}</b></a>{if $thread.paging}<br /><span class="serendipity_date">{$thread.paging}</span>{/if}</td>
                <td width="60" align="right">{$thread.replies}</td>
                <td width="60" align="right">{$thread.views}</td>
                <td width="140" align="center"><span class="serendipity_date">{$thread.lastpost}</span></td>
            </tr>
            {if $thread.trenner}
                <tr style="background-color: {$bgcolor_head};">
                    <td colspan="5" height="10"><img src="{$relpath}/img/blanc.png" height="10" border="0" /></td>
                </tr>
            {/if}
        {/foreach}
        
    </table>
    {/if}
    
    <br />
    {if $paging}
        <div align="right"><span class="serendipity_date">{$paging}</span></div><br />
    {/if}
    <div align="right"><a href="{$newthreadurl}"><img src="{$relpath}/img/new_thread.png" alt="{$CONST.FORUM_PLUGIN_NEW_THREAD}" title="{$CONST.FORUM_PLUGIN_NEW_THREAD}" border="0" /></a></div>
    
</div>
