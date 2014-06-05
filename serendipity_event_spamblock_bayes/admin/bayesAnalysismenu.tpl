<div id="bayesContent">
    <span id="bayesAnalysis">
        <div class="bayesAnalysisTableNavigation">
            {if $commentpage > 0}
                 <a class="serendipityIconLink" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage-1}"><img src="{serendipity_getFile file="admin/img/previous.png"}"/>{$CONST.PREVIOUS}</a>
            {/if}

            {if $comments|@count > 20}
                <a class="serendipityIconLinkRight" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage+1}">{$CONST.NEXT} <img src="{serendipity_getFile file="admin/img/next.png"}"/></a>
            {/if}
        </div>

        <form action="{$serendipityBaseURL}index.php?/plugin/bayesAnalyse" method="post">
            <ul id="bayesAnalysisList" class="plainList">
                {foreach from=$comments item=comment }
                    <li>
                        <input type="checkbox" id="{$comment.id}" name="comments[{$comment.id}]" />
                        <label for="{$comment.id}">{$comment.id}:</label>
                        <div class="bayesComments">
                            {$comment.author|escape:"html"}, {$comment.body|escape:"html"}
                        </div>
                    </li>
                {/foreach}
                <input type="submit" class="serendipityPrettyButton input_button" id="bayesAnalysisButton" value="{$CONST.GO}" />
            </ul>
        </form>
        <script src="{$path}jquery.excerpt.js" type="text/javascript"></script>
        <script>shortenAll("bayesComments", 1)</script>
        <div class="bayesAnalysisTableNavigation">
            {if $commentpage > 0}
                 <a class="serendipityIconLink" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage-1}"><img src="{serendipity_getFile file="admin/img/previous.png"}"/>{$CONST.PREVIOUS}</a>
            {/if}
            {if ($commentpage+1)*20 < $comments|@count}
                <a class="serendipityIconLinkRight" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage+1}">{$CONST.NEXT} <img src="{serendipity_getFile file="admin/img/next.png"}"/></a>
            {/if}
        </div>
    </span>
</div>