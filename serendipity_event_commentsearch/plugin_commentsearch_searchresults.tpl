<div class="comment_results">
    <p class="comment_result_header">{$CONST.COMMENT_SEARCHRESULTS|sprintf:$comment_searchresults}</p>

    <ul class="comment_result plainList">
    {foreach from=$comment_results item="result"}
        <li>{$result.ctimestamp|@formatTime:DATE_FORMAT_ENTRY}:
        {if $result.type == 'TRACKBACK'}
            <a href="{$result.url|@escape}">{$result.author|@escape}</a> - <a href="{$result.permalink|@escape}">{$result.title|@escape}</a>
        {else}
            {$result.author|@escape} - <a href="{$result.permalink|@escape}">{$result.title|@escape}</a>
        {/if}
            <br />
            {$result.comment|@truncate:200:" ..."}</li>
    {/foreach}
    </ul>
</div>
