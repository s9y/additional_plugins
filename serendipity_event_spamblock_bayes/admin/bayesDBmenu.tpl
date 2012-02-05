<div id="bayesContent">
    <div id="bayesControls">
        <form action="{$serendipityBaseURL}index.php?/plugin/bayesSetupDatabase" method="post">
            <input type="submit" class="serendipityPrettyButton input_button" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_CREATEDB}" name="submit"/>
        </form>
        <form action="{$serendipityBaseURL}index.php?/plugin/bayesLearnFromOld" method="post">
            <input type="submit" class="serendipityPrettyButton input_button" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_LEARNOLD}" name="submit"/>
        </form>
        <form id="bayesDeleteDB" action="{$serendipityBaseURL}index.php?/plugin/bayesDeleteDatabase" method="post">
            <input type="submit" class="serendipityPrettyButton input_button" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_ERASEDB}" name="submit"/>
        </form>
        <form action="{$serendipityBaseURL}index.php?/plugin/bayesExportDatabase" method="post">
            <input type="submit" class="serendipityPrettyButton input_button" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_EXPORTDB}" name="submit"/>
        </form>
        <form action="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=5" method="post">
            <input type="submit" class="serendipityPrettyButton input_button" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORTDB}" name="submit"/>
        </form>
    </div>
    
    <div id="bayesDatabase">
        <table id="bayesDatabaseTable">
            <caption>{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DATABASE}</caption>
            <thead>
                <tr>
                    <th>token</th>
                    <th>ham</th>
                    <th>spam</th>
                    <th>type</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$bayesTable item=row}
                    <tr>
                        {foreach from=$row item=value}
                            <td>
                                {$value}
                            </td>
                        {/foreach}
                    </tr>
                {/foreach}
            </tbody>
        </table>
        {if $pages > 1}
            <div id="bayesDatabaseTablePagination">
                {if $curpage > 2}
                    <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=2&serendipity[commentpage]=0" title="{$CONST.Page}">1</a>
                    ...
                {elseif $curpage > 1}
                    <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=2&serendipity[commentpage]=0" title="{$CONST.Page}">1</a>
                {/if}
                
                {section name=page start=1 loop=$pages+1}
                    {if $curpage == $smarty.section.page.index -1}
                        <a class="curpage" href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=2&serendipity[commentpage]={$smarty.section.page.index-1}" title="{$CONST.Page}">{$smarty.section.page.index}</a>
                    {/if}
                    {if $curpage == $smarty.section.page.index -2 || $curpage == $smarty.section.page.index}
                        <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=2&serendipity[commentpage]={$smarty.section.page.index-1}" title="{$CONST.Page}">{$smarty.section.page.index}</a>
                    {/if}
                {/section}
                
                {if $curpage < $pages -3}
                    ...
                    <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=2&serendipity[commentpage]={$pages-1}" title="{$CONST.Page}">{$pages}</a>
                {elseif $curpage < $pages -2}
                    <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=2&serendipity[commentpage]={$pages-1}" title="{$CONST.Page}">{$pages}</a>
                {/if}
            </div>
        {/if}

    <div id="bayesSavedValues">
        <table id="bayesSavedValuesTable">
            <caption>{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_SAVEDVALUES}</caption>
            <thead>
                <tr>
                    <th colspan="2">{$CONST.NAME}</th>
                    <th colspan="2">{$CONST.HOMEPAGE}</th>
                    <th colspan="2">{$CONST.EMAIL}</th>
                    <th colspan="2">{$CONST.IP}</th>
                    <th colspan="2">{$CONST.REFERER}</th>
                    <th colspan="2">{$CONST.COMMENT}</th>
                </tr>
                <tr>
                    {section name=i  loop=6 start=0}
                        <th>{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM}</th>
                        <th>{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM}</th>
                    {/section}
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$author_ham}</td>
                    <td>{$author_spam}</td>
                    <td>{$url_ham}</td>
                    <td>{$url_spam}</td>
                    <td>{$email_ham}</td>
                    <td>{$email_spam}</td>
                    <td>{$ip_ham}</td>
                    <td>{$ip_spam}</td>
                    <td>{$referer_ham}</td>
                    <td>{$referer_spam}</td>
                    <td>{$body_ham}</td>
                    <td>{$body_spam}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="{$path}jquery.heatcolor.js" type="text/javascript"></script>
    <script src="{$path}jquery.tablesorter.js" type="text/javascript"></script>
    <script>$("#bayesDatabaseTable").tablesorter();
    sortwithcolor(2);</script>
</div>
