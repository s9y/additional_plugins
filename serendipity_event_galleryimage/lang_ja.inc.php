<?php # 

/**
 *  @version $Revision$
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.2
 */

@define('PLUGIN_EVENT_GALLERYIMAGE_NAME',     'マークアップ: Gallery 画像');
@define('PLUGIN_EVENT_GALLERYIMAGE_DESC',     'Gallery アルバムか画像を用いたマークアップテキストの挿入です。');
@define('PLUGIN_EVENT_GALLERYIMAGE_GALLERY_BASE',     'Galleryの URL');
@define('PLUGIN_EVENT_GALLERYIMAGE_GALLERY_BASE_BLAHBLAH',     'Galleryをインストールしたアルバムリンクの基準 URLです');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_BASE',     'Galleryアルバムディレクトリの URL');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_BASE_BLAHBLAH',     '<img> タグのアルバム URL です。 (for Gallery 2.x this is used to get the imagesizes correctly!)');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXPOPUPSIZE',     'Maximum dimension for popup window.');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXPOPUPSIZE_BLAHBLAH',     'Horizontal or vertical, default is 640.');      
@define('PLUGIN_EVENT_GALLERYIMAGE_VERSION',        'Which version of Gallery are you using?');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXTHUMBSIZE',     'Maximum dimension for thumbnailed pictures (Only used for Gallery 2.x versions!)');
@define('PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXTHUMBSIZE_BLAHBLAH',     'Horizontal or vertical, default is 120.');      
@define("PLUGIN_EVENT_GALLERYIMAGE_ALBUM_ABS", "Absolute album-path (Only used for Gallery 2.x versions!)");
@define("PLUGIN_EVENT_GALLERYIMAGE_ALBUM_ABS_BLAHBLAH", "The absolute server-path to the album directory. The ./tmp directory in this album directory has to be writeable for the webserver!");
@define("PLUGIN_EVENT_GALLERYIMAGE_GALLERY_ABS", "Galleryの絶対パス (Only used for Gallery 2.x versions!)");
@define("PLUGIN_EVENT_GALLERYIMAGE_GALLERY_ABS_BLAHBLAH", "The absolute server-path to the gallery directory.");

?>
