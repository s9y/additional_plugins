{serendipity_hookPlugin hook="entries_header" addData="$entry_id"}

{foreach from=$entries item="dategroup"}
  {foreach from=$dategroup.entries item="entry"}
  	{if !$is_single_entry}
    	    <li>
		<a href="{$entry.link}" target="_ajax">{$entry.title|@default:$entry.body}<br/>
		<span class="small">{$dategroup.date|@formatTime:DATE_FORMAT_ENTRY}</span></a>
	    </li>
 	{/if}
  	
  	{if $is_single_entry}
	    <div class="entry">
    		<h1>{$entry.title}</h1>
		<h3>{$dategroup.date|@formatTime:DATE_FORMAT_ENTRY} {$CONST.POSTED_BY} {$entry.author}</h3>
		<div class="entryBody">{$entry.body}</div>
		{if $entry.is_extended}
		<div class="entryBody"><a id="extended"></a>{$entry.extended}</div>
		{/if}
		<h3>Kommentare</h3>
		{serendipity_printComments entry=$entry.id mode=$entry.viewmode}
	    </div>
  	{/if}
    {/foreach}
{/foreach}
