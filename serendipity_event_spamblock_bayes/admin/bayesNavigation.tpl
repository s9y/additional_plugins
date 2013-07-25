
{if $jquery_needed == true}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
{/if}
<style> {$css} </style>
<script src="{$path}serendipity_event_spamblock_bayes.js" type="text/javascript"></script>

<div id="bayesNav">
    <ul>
        {if $subpage == 1}
            <li>
                <h3><a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=1">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_RECYCLER}</a></h3>
            </li>
        {else}
            <li>
                <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=1">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_RECYCLER}</a>
            </li>
        {/if}
        {if $subpage == 2}
            <li>
                <h3><a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=2">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DATABASE}</a></h3>
            </li>
        {else}
            <li>
                <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=2">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DATABASE}</a>
            </li>
        {/if}
        {if $subpage == 3}
            <li>
                <h3><a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=3">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_LEARN}</a></h3>
            </li>
        {else}
            <li>
                <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=3">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_LEARN}</a>
            </li>
        {/if}
       
        {if $subpage == 4}
            <li>
                <h3><a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=4">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_ANALYSIS}</a></h3>
            </li>
        {else}
            <li>
                <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=4">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_ANALYSIS}</a>
            </li>
        {/if}
        {if $subpage == 5}
            <li>
                <h3><a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=5">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_IMPORT}</a></h3>
            </li>
        {else}
            <li>
                <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=5">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_IMPORT}</a>
            </li>
        {/if}
    </ul>
</div>