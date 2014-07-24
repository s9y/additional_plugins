
<div class="serendipity_mediainsert_gallery">

{foreach from=$plugin_mediainsert_media item="medium"}
  <div class="serendipity_imageComment_left" style="width: {$medium.thumbwidth}px">
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
