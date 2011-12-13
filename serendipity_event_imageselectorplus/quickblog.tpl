<a href="{$quickblog.fullimage}"><img src="{$quickblog.image}" /></a>
<br />
{$quickblog.body}

{if $quickblog.exif_mode == 'internal'}
<br />
Taken on: {$quickblog.exif.FileDateTime|@formatTime:DATE_FORMAT_ENTRY}<br />
Copyright: {$quickblog.exif.COMMENT.0}<br />
{else if $quickblog.exif_mode == 'jhead'}
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

{/if}