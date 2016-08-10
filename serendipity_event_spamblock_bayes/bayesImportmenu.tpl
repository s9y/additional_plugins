<div id="bayesContent">
    {if $s9ybackend == 1}<p>{else}<span class="msg_hint"><span class="icon-help-circled"></span> {/if}{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORT_EXPLANATION}{if $s9ybackend == 1}</p>{else}</span>{/if}
        
    <form enctype="multipart/form-data" action="{$serendipityBaseURL}index.php?/plugin/spamblock_bayes_import" method="post">
    {if $s9ybackend != 1}
        <div class="form_field">
    {/if}
        <input name="importcsv" type="file" />
        <input class="serendipityPrettyButton input_button" type="submit" value="{$CONST.GO}" />
    {if $s9ybackend != 1}
        </div>
    {/if}
    </form>
    
    <h3>{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA}</h3>

    {if $s9ybackend == 1}<p>{else}<span class="msg_hint"><span class="icon-help-circled"></span> {/if}{$CONST.PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_EXPLANATION}{if $s9ybackend == 1}</p>{else}</span>{/if}

    <form{if $s9ybackend != 1} class="bayesTrojaButtons"{/if} action="{$serendipityBaseURL}index.php?/plugin/bayesTrojaRequestDB" method="post">
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
