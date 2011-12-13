<h4 class='serendipity_event_picasa'>{$serendipity_event_picasa_albumName}</h4>
{if $serendipity_event_picasa_albumCaption}
    <h5 class='serendipity_event_picasa'>{$serendipity_event_picasa_albumCaption}</h5>
{/if}

<table width="100%">
    <tr>
        <td style="vertical-align:top">
        {foreach from=$serendipity_event_picasa_images item=image}
           <img 
	       style="cursor:pointer"
               onClick="serendipity_event_picasa_galleryimg.src='{$image.itemLargeImage}'"
               src="{$image.itemThumbnailImage}" 
               height="{$image.itemThumbnailHeight}" 
               width="{$image.itemThumbnailWidth}" 
               alt="{$image.itemCaption}" />
        {/foreach}
        </td>
        <td style="vertical-align:top">
            <img id="serendipity_event_picasa_galleryimg" src="{$serendipity_event_picasa_images[0].firstImage}" alt="" />
        </td>
    </tr>
</table>
