{if $plugin_mymood_location == "title"}
 {$plugin_mymood_intro}
{foreach from=$plugin_mymood_mood_list item="mood_name"}
 {$mood_name}
{/foreach}
{$plugin_mymood_outro}
{elseif $plugin_mymood_location == "body"}
<div class="mymood_body_dsp">
	{$plugin_mymood_intro}
	<ul>
	{foreach from=$plugin_mymood_mood_list item="mood_name"}
		<li>{$mood_name}</li>
	{/foreach}
	</ul>
	{$plugin_mymood_outro}
</div>
{elseif $plugin_mymood_location == "footer"}
	{$plugin_mymood_intro}
	{foreach from=$plugin_mymood_mood_list item="mood_name"}
	{$mood_name}
	{/foreach}
	{$plugin_mymood_outro}
{/if}
