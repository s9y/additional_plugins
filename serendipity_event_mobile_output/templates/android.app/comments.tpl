<div id="comments">
{foreach from=$comments item=comment name="comments"}
	<hr/>
        <div class="comment_source">
		{if $comment.avatar}
                    {$comment.avatar}
                {else}
                    <img src="{$serendipityHTTPPath}templates/{$template}/img/comment_bubbles.png" alt="avatar" title="{$comment.author}" class="comment_avatar" />
                {/if}
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
        <div class="comment_body">
        {if $comment.body == 'COMMENT_DELETED'}
            {$CONST.COMMENT_IS_DELETED}
        {else}
            {$comment.body}
        {/if}
        </div>
	{if $entry.allow_comments AND $comment.body != 'COMMENT_DELETED'}
		<a class="comment_reply" href="#serendipity_CommentForm" id="serendipity_reply_{$comment.id}" onclick="document.getElementById('serendipity_replyTo').value='{$comment.id}'; {$comment_onchange}">{$CONST.REPLY}</a>
		<div id="serendipity_replyform_{$comment.id}"></div>
        {/if}
{foreachelse}
    <div class="comment_nocomments">{$CONST.NO_COMMENTS}</div>
{/foreach}
</div>
