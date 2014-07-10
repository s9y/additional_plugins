{if !$quickblog.html5}
<a class="serendipity_image_link" href="{$quickblog.fullimage}"{$quickblog.target}>{if $quickblog.imageid}<!-- s9ymdb:{$quickblog.imageid} -->{/if}<img src="{$quickblog.image}" /></a>
<br />
{else}
<a class="serendipity_image_link" href="{$quickblog.fullimage}"{$quickblog.target}>{if $quickblog.imageid}<!-- s9ymdb:{$quickblog.imageid} -->{/if}<img src="{$quickblog.image}"></a>
{/if}
{$quickblog.body}

{if $quickblog.exif_mode == 'internal'}
{if !$quickblog.html5}
<br />
Taken on: {$quickblog.exif.FileDateTime|@formatTime:DATE_FORMAT_ENTRY}<br />
Copyright: {$quickblog.exif.COMMENT.0}<br />
{else}
<br>
Taken on: {$quickblog.exif.FileDateTime|@formatTime:DATE_FORMAT_ENTRY}<br>
Copyright: {$quickblog.exif.COMMENT.0}<br>
{/if}
{else if $quickblog.exif_mode == 'jhead'}
{if !$quickblog.html5}
File date    : {$quickblog.exif.File_date}<br />
Camera make  : {$quickblog.exif.Camera_make}<br />
Camera model : {$quickblog.exif.Camera_model}<br />
Date/Time    : {$quickblog.exif.Date_Time}<br />
Resolution   : {$quickblog.exif.Resolution}<br />
Flash used   : {$quickblog.exif.Flash_used}<br />
Focal length : {$quickblog.exif.Focal_length}<br />
Exposure time: {$quickblog.exif.Exposure_time}<br />
Aperture     : {$quickblog.exif.Aperture}<br />
Whitebalance : {$quickblog.exif.Whitebalance}<br />
Metering Mode: {$quickblog.exif.MeteringMode}<br />
Comment      : {$quickblog.exif.Comment}<br />
{else}
File date    : {$quickblog.exif.File_date}<br>
Camera make  : {$quickblog.exif.Camera_make}<br>
Camera model : {$quickblog.exif.Camera_model}<br>
Date/Time    : {$quickblog.exif.Date_Time}<br>
Resolution   : {$quickblog.exif.Resolution}<br>
Flash used   : {$quickblog.exif.Flash_used}<br>
Focal length : {$quickblog.exif.Focal_length}<br>
Exposure time: {$quickblog.exif.Exposure_time}<br>
Aperture     : {$quickblog.exif.Aperture}<br>
Whitebalance : {$quickblog.exif.Whitebalance}<br>
Metering Mode: {$quickblog.exif.MeteringMode}<br>
Comment      : {$quickblog.exif.Comment}<br>
{/if}
{/if}