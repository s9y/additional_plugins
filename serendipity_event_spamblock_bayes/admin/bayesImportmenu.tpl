<div id="bayesContent">
    <p>{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORT_EXPLANATION}</p>
        
    <form enctype="multipart/form-data" action="{$serendipityBaseURL}index.php?/plugin/spamblock_bayes_import" method="post">
         <input name="importcsv" type="file" />
         <input class="serendipityPrettyButton input_button" type="submit" value="{$CONST.GO}" />
    </form>
    
    <h3>{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA}</h3>
    <p>{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_EXPLANATION}</p>
    <form action="{$serendipityBaseURL}index.php?/plugin/bayesTrojaRequestDB" method="post">
        <input id="trojaImport" class="serendipityPrettyButton input_button" type="submit" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_IMPORT}" />
    </form>
     {if $trojaRegistered}
        <form class="bayesTrojaButtons" action="{$serendipityBaseURL}index.php?/plugin/bayesTrojaRemove" method="post">
            <input class="serendipityPrettyButton input_button" type="submit" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REMOVE}" />
        </form>
    {else}
        <form class="bayesTrojaButtons" action="{$serendipityBaseURL}index.php?/plugin/bayesTrojaRegister" method="post">
            <input class="serendipityPrettyButton input_button" type="submit" value="{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REGISTER}" />
        </form>
    {/if}
</div>