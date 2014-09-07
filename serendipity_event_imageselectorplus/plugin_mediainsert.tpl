
<div class="serendipity_mediainsert_gallery">

{foreach from=$plugin_mediainsert_media item="medium" name="pmd"}

 {if isset($plugin_mediainsert_hideafter) && isset($plugin_mediainsert_picperrow) && $smarty.foreach.pmd.iteration <= $plugin_mediainsert_hideafter}
  {if !$smarty.foreach.pmd.first && $plugin_mediainsert_picperrow > 0 && $smarty.foreach.pmd.index % $plugin_mediainsert_picperrow == 0}
  <div style="clear:both">&nbsp;</div>
  {/if}
 {/if}
 {if isset($plugin_mediainsert_hideafter) && $smarty.foreach.pmd.iteration > $plugin_mediainsert_hideafter}
  <div class="serendipity_imageComment_left" style="width: 0px; height: 0px; display: none">
 {else}
  <div class="serendipity_imageComment_left" style="width: {$medium.thumbwidth}px">
 {/if}
      <div class="serendipity_imageComment_img">
      <a class="serendipity_image_link" href="{$serendipityHTTPPath}uploads/{$medium.path}{$medium.realname}">
       <!-- s9ymdb:{$medium.id} -->
        <img width="{$medium.thumbwidth}" height="{$medium.thumbheight}" src="{$serendipityHTTPPath}uploads/{$medium.path}{$medium.name}.{$medium.thumbnail_name}.{$medium.extension}" />
      </a>
      </div>
      <div class="serendipity_imageComment_txt">{$medium.comment1}</div>
  </div>
{/foreach}

</div>
