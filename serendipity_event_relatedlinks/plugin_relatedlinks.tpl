<h4 class="serendipity_relatedlinks serendipity_title">{$plugin_relatedentries_html_intro}</h4>

<div class="serendipity_entry serendipity_relatedlinks">
    <ul id="serendipity_relatedlinks_list">
    {foreach from=$plugin_relatedentries_links item="links"}
    	<li><a href="{$links.url}" title="{$links.title}">{$links.title}</a></li>
    {/foreach}
    </ul>
</div>