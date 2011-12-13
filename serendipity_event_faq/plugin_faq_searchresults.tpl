<div class="faq_results" style="text-align: left">
    <p class="faq_result_header">{$smarty.const.FAQ_SEARCHRESULTS|sprintf:$faq_searchresults}</p>

    <ul class="faq_result">
    {foreach from=$faq_results item="result"}
        <li><strong><a href="{$serendipityBaseURL}{$faq_pluginpath}/{$result.cid}/{$result.id}" title="{$result.question|@truncate:50:" ... "|@escape}">{$result.question|truncate:50:" ... "}</a></strong><br />
        {$result.answer|@truncate:200:" ... "}</li>
    {/foreach}
    </ul>
</div>
