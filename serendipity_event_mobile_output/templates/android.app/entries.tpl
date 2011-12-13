{serendipity_hookPlugin hook="entries_header" addData="$entry_id"}

{foreach from=$entries item="dategroup"}
  {foreach from=$dategroup.entries item="entry"}
  	{if !$is_single_entry}
	<div class="eEntry">
		<div class="eTitleDate" onClick="toggleEntryBody('body{$entry.id|escape}')">
		<div class="eTitle"><img src="{serendipity_getFile file="img/arrow.gif"}" align="right" alt="read" onClick="loadUrl('{$entry.link}')"/><h3>{$entry.title|@default:$entry.body}</h3></div>
		<div class="eDate">{$dategroup.date|@formatTime:DATE_FORMAT_ENTRY}<br/>{$CONST.POSTED_BY} {$entry.author}</div>
		</div>
		<div class="eBody" id="body{$entry.id|escape}" style="display: none">
		{$entry.body}
		<div class="eExtend" onClick="loadUrl('{$entry.link}')"><img src="{serendipity_getFile file="img/arrow.gif"}" align="right" alt="read" onClick="loadUrl('{$entry.link}')"/><a href="{$entry.link}" class="eExtend">{$CONST.VIEW_EXTENDED_ENTRY|@sprintf:$entry.title}</a></div>
		</div>

	</div>
  	{/if}
  	
  	{if $is_single_entry}
	<div class="eEntry">
		<div class="eDate">{$dategroup.date|@formatTime:DATE_FORMAT_ENTRY}<br/>{$CONST.POSTED_BY} {$entry.author}</div>
		<div class="eBody">{$entry.body}</div>
		{if $entry.is_extended}
		<div class="eBody"><a id="extended"></a>{$entry.extended}</div>
		{/if}
		<h3>{$CONST.COMMENTS}</h3>
		{serendipity_printComments entry=$entry.id mode=$entry.viewmode}
	</div>
  	
		{if $is_comment_added}

                <br />
                <div class="msg_notice">{$CONST.COMMENT_ADDED}</div>

                {elseif $is_comment_moderate}

                <br />
                <div class="msg_notice">{$CONST.COMMENT_ADDED}<br />{$CONST.THIS_COMMENT_NEEDS_REVIEW}</div>

                {elseif not $entry.allow_comments}

                <br />
                <div class="msg_important">{$CONST.COMMENTS_CLOSED}</div>

                {else}

                <br />
                <div class="serendipity_section_commentform">
	                <div class="serendipity_commentsTitle">{$CONST.ADD_COMMENT}</div>
	                {$COMMENTFORM}
		</div>

                {/if}
	{/if}
  	
	{/foreach}
{/foreach}


