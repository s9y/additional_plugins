{foreach from=$serendipity_event_picasa_images item=image}
	<a href="{$image.itemLargeImage}"
        {if $serendipity_event_picasa_use_jswindow}
            onClick="window.open('{$image.itemLargeImage}', 'picasa', 'height={$image.itemHeight+20}, width={$image.itemWidth+20}, resizable=no, scrollbars=no, toolbar=no, status=no, menubar=no, location=no')"
        {/if}
        target="picasa"><img 
            border="0" 
            src="{$image.itemThumbnailImage}" 
            height="{$image.itemThumbnailHeight}" 
            width="{$image.itemThumbnailWidth}" 
            alt="{$image.itemCaption}" /></a><br>
{/foreach}
