<!-- ENTRIES START -->

{if $entries}
{$CONST.STATICPAGE_NEW_HEADLINES}

<ul>
    {foreach from=$entries item="dategroup"}
            {foreach from=$dategroup.entries item="entry"}
			<li class="static-entries">
        		({$dategroup.date|date_format:"%d.%m.%Y"}) <a href="{$entry.link}">{$entry.title|@default:$entry.id}</a>
			</li>
            {/foreach}
   {/foreach}
</ul>


{*  for normal static pages  *}
&raquo; <a href="{$serendipityBaseURL}{getCategoryLinkByID cid=$staticpage_related_category_id}
">{$CONST.STATICPAGE_ARTICLE_OVERVIEW}</a><br />

{* for a staticpage as startpage  *}
{* &raquo; <a href="{$serendipityArchiveURL}/P1.html">{$CONST.STATICPAGE_ARTICLE_OVERVIEW}</a><br />  *}

{/if}
<!-- ENTRIES END -->