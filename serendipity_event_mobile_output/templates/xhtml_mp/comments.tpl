<div id="comments">
{foreach from=$comments item=comment name="comments"}
        <div class="serendipity_comment_source">
            <span class="comment_source_date">{$comment.timestamp|@formatTime:$CONST.DATE_FORMAT_SHORT}</span>
            <span class="comment_source_author">
            {if $comment.email}
                <a href="mailto:{$comment.email}">{$comment.author|@default:$CONST.ANONYMOUS}</a>
            {else}
                {$comment.author|@default:$CONST.ANONYMOUS}
            {/if}
            </span>
            {if $comment.url}
                (<a class="comment_source_url" href="{$comment.url}" title="{$comment.url|@escape}">{$CONST.HOMEPAGE}</a>)
            {/if}
        </div>
        <div class="serendipity_commentBody">
        {if $comment.body == 'COMMENT_DELETED'}
            {$CONST.COMMENT_IS_DELETED}
        {else}
            {$comment.body}
        {/if}
        </div>
	<hr/>
{foreachelse}
    <div class="serendipity_center nocomments">{$CONST.NO_COMMENTS}</div>
{/foreach}
</div>