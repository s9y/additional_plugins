<div class="comment_results" style="text-align: left">
    <p class="comment_result_header">{$CONST.COMMENT_SEARCHRESULTS|sprintf:$comment_searchresults}</p>

    <ul class="comment_result">
    {foreach from=$comment_results item="result"}
        <li>
        {$result.ctimestamp|@formatTime:DATE_FORMAT_ENTRY}:
        {if $result.type == 'TRACKBACK'}
        <strong><a href="{$result.url|@escape}">{$result.author|@escape}</a></strong> - <a href="{$result.permalink|@escape}">{$result.title|@escape}</a><br />
        {else}
        <strong>{$result.author|@escape}</strong> - <a href="{$result.permalink|@escape}">{$result.title|@escape}</a><br />
        {/if}
        {$result.comment|@truncate:200:" ... "}</li>
    {/foreach}
    </ul>
</div>
