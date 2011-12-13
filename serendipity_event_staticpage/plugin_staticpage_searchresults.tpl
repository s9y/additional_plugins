<div class="staticpage_results" style="text-align: left">
    <p class="staticpage_result_header">{$CONST.STATICPAGE_SEARCHRESULTS|sprintf:$staticpage_searchresults}</p>

    {if $staticpage_results}
    <ul class="staticpage_result">
    {foreach from=$staticpage_results item="result"}
        <li><strong><a href="{$result.permalink|@escape}" title="{$result.pagetitle|@escape}">{$result.headline}</a></strong> ({$result.realname})<br />
        {$result.content|@strip_tags|@strip|@truncate:200:" ... "}</li>
    {/foreach}
    </ul>
    {/if}
</div>
