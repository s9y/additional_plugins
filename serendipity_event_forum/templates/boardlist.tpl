
<h3 class="serendipity_date">{$pagetitle}</h3>
<h4 class="serendipity_title"><a href="#">{$headline}</a></h4>
<br />

<div class="serendipity_entry">

    <span  class="serendipity_date"><b>{$MAINPAGE}</b></span><br />
    
    {if $noboards}
        <div align="center"><b>{$noboards}</b></div>
    {else}
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
            <tr style="background-color: {$bgcolor_head};">
                <td><b>{$CONST.PLUGIN_FORUM_BOARDS}</b></td>
                <td width="60" align="right"><b>{$CONST.PLUGIN_FORUM_THREADS}</b></td>
                <td width="60" align="right"><b>{$CONST.PLUGIN_FORUM_POSTS}</b></td>
                <td width="140"><b>{$CONST.PLUGIN_FORUM_LASTPOST}</b></td>
            </tr>
            
            {foreach name=boardlist item=board from=$boards}
                <tr style="background-color: {$board.color};">
                    <td><a href="./index.php?serendipity[subpage]={$pageurl}&amp;boardid={$board.boardid}"><b>{$board.name}</b></a><br />
                        <span class="serendipity_date">{$board.description}</span></td>
                    <td width="60" align="right">{$board.threads}</td>
                    <td width="60" align="right">{$board.posts}</td>
                    <td width="140" align="center"><span class="serendipity_date">{$board.lastpost}</span>
                    </td>
                </tr>
            {/foreach}
        </table>
    {/if}
    
</div>
