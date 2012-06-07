<div id="bayesContent">
    <form action="{$serendipityBaseUrl}index.php?/plugin/bayesRecycler" method="post">
        <div id="bayesControls">
                <input type="submit" class="serendipityPrettyButton input_button" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_RESTORE}" name="restore"/>
                <input type="submit" class="serendipityPrettyButton input_button" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY}" name="empty" />
        </div>

        <span id="bayesRecycler">
            <div class="bayesRecyclerTableNavigation">
                {if $commentpage > 0}
                     <a class="serendipityIconLink" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=1&amp;serendipity[commentpage]={$commentpage-1}">
                     <img src="{serendipity_getFile file="admin/img/previous.png"}"/>{$CONST.PREVIOUS}</a>
                {/if}

                {if $comments|@count > 20}
                   <a class="serendipityIconLinkRight" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=1&amp;serendipity[commentpage]={$commentpage+1}">{$CONST.NEXT} <img src="{serendipity_getFile file="admin/img/next.png"}"/></a>
                {/if}
            </div>
            
            {foreach from=$comments item=comment}
                <details class="bayesRecyclerItem">
                    <summary>
                        <input type="checkbox" class="bayesRecyclerSelectBox" name="serendipity[selected][{$comment.id}]" />
                        <input type="hidden" name="serendipity[comments][{$comment.id}]" />
                        <table class="bayesRecyclerSummary">
                            <thead>
                                <tr>
                                    <th>{$CONST.Autor}</th>
                                    <th>{$CONST.Comment}</th>
                                    <th>{$CONST.Date}</th>
                                    <th>{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_RATING}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{$comment.author|truncate:20:"..."|escape:"html"}</td>
                                    <td>{$comment.body|truncate:20:"..."|escape:"html"}</td>
                                    <td>{$comment.timestamp|date_format:"%d.%m.%y, %R"}</td>
                                    <td>{$comment.rating|regex_replace:"/\..*/":""}%</td>
                                </tr>
                            </tbody>
                        </table>
                    </summary>
                    <dl class="bayesRecyclerList">
                    {foreach from=$types item=type}
                        <dt>{$type}</dt>
                        <dd>{$comment.$type|escape:"html"}</dd>
                    {/foreach}
                    <dt>{$CONST.Article}</dt>
                    <dd><a href="{$comment.article_link}" target="_blank">{$comment.article_title}</a></dd>
                    </dl>
                   
                </details>
            {/foreach}
            <div class="bayesRecyclerTableNavigation">
                {if $commentpage > 0}
                     <a class="serendipityIconLink" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=1&amp;serendipity[commentpage]={$commentpage-1}"><img src="{serendipity_getFile file="admin/img/previous.png"}"/>{$CONST.PREVIOUS}</a>
                {/if}
                {if ($commentpage+1)*20 < $comments|@count}
                    <a class="serendipityIconLinkRight" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=spamblock_bayes&amp;serendipity[subpage]=1&amp;serendipity[commentpage]={$commentpage+1}">{$CONST.NEXT} <img src="{serendipity_getFile file="admin/img/next.png"}"/></a>
                {/if}
            </div>
        </span>
    </form>
    <script src="{$path}details.polyfill.min.js" type="text/javascript"></script>
</div>