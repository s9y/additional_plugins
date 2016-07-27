<div id="bayesContent">
    <div id="bayesAnalysis">
        {if $s9ybackend == 1}
        <div class="bayesAnalysisTableNavigation">
        {else}
        <ul class="bayesAnalysisTableNavigation plainList clearfix">
        {/if}
            {if $commentpage > 0}
                {if $s9ybackend == 1}
                <a class="serendipityIconLink" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage-1}"><img src="{serendipity_getFile file="admin/img/previous.png"}"/>{$CONST.PREVIOUS}</a>
                {else}
                <li class="prev"><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage-1}" title="{$CONST.PREVIOUS}"><span class="icon-left-dir"></span><span class="visuallyhidden"> {$CONST.PREVIOUS}</span></a></li>
                {/if}
            {/if}

            {if $comments|@count > 20}
                {if $s9ybackend == 1}
                <a class="serendipityIconLinkRight" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage+1}">{$CONST.NEXT} <img src="{serendipity_getFile file="admin/img/next.png"}"/></a>
                {else}
                <li class="next"><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage+1}" title="{$CONST.NEXT}"><span class="visuallyhidden">{$CONST.NEXT} </span><span class="icon-right-dir"></span></a></li>
                {/if}
            {/if}
        {if $s9ybackend == 1}
        </div>
        {else}
        </ul>
        {/if}

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

        {if $s9ybackend == 1}
        <div class="bayesAnalysisTableNavigation">
        {else}
        <ul class="bayesAnalysisTableNavigation plainList clearfix">
        {/if}
            {if $commentpage > 0}
                {if $s9ybackend == 1}
                <a class="serendipityIconLink" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage-1}"><img src="{serendipity_getFile file="admin/img/previous.png"}"/>{$CONST.PREVIOUS}</a>
                {else}
                <li class="prev"><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage-1}" title="{$CONST.PREVIOUS}"><span class="icon-left-dir"></span><span class="visuallyhidden"> {$CONST.PREVIOUS}</span></a></li>
                {/if}
            {/if}

            {if $comments|@count > 20}
                {if $s9ybackend == 1}
                <a class="serendipityIconLinkRight" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage+1}">{$CONST.NEXT} <img src="{serendipity_getFile file="admin/img/next.png"}"/></a>
                {else}
                <li class="next"><a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=4&amp;serendipity[commentpage]={$commentpage+1}" title="{$CONST.NEXT}"><span class="visuallyhidden">{$CONST.NEXT} </span><span class="icon-right-dir"></span></a></li>
                {/if}
            {/if}
        {if $s9ybackend == 1}
        </div>
        {else}
        </ul>
        {/if}
    </div>
</div>