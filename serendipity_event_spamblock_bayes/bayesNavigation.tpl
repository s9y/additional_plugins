{if $jquery_needed == true}
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
{/if}
<style> {$css} </style>
<script src="{$path}serendipity_event_spamblock_bayes.js" type="text/javascript"></script>
{if $s9ybackend != 1}
<h2>{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME}</h2>
{/if}
<div id="bayesNav">
    <ul>
        <li{if $subpage == 1 && $s9ybackend != 1} class="current"{/if}>{if $subpage == 1 && $s9ybackend == 1}<h3>{/if}
            <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=1">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_RECYCLER}</a>
            {if $subpage == 1 && $s9ybackend == 1}</h3>{/if}
        </li>
        <li{if $subpage == 2 && $s9ybackend != 1} class="current"{/if}>{if $subpage == 2 && $s9ybackend == 1}<h3>{/if}
            <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=2">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DATABASE}</a>
            {if $subpage == 2 && $s9ybackend == 1}</h3>{/if}
        </li>
        <li{if $subpage == 3 && $s9ybackend != 1} class="current"{/if}>{if $subpage == 3 && $s9ybackend == 1}<h3>{/if}
            <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=3">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_LEARN}</a>
            {if $subpage == 3 && $s9ybackend == 1}</h3>{/if}
        </li>
        <li{if $subpage == 4 && $s9ybackend != 1} class="current"{/if}>{if $subpage == 4 && $s9ybackend == 1}<h3>{/if}
            <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=4">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_ANALYSIS}</a>
            {if $subpage == 4 && $s9ybackend == 1}</h3>{/if}
        </li>
        <li{if $subpage == 5 && $s9ybackend != 1} class="current"{/if}>{if $subpage == 5 && $s9ybackend == 1}<h3>{/if}
            <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes&serendipity[subpage]=5">{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_IMPORT}</a>
            {if $subpage == 5 && $s9ybackend == 1}</h3>{/if}
        </li>
    </ul>
</div>
