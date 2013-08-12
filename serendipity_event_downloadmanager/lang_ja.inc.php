<?php # 

# (c) 2005 by Alexander 'dma147' Mieland, http://blog.linux-stats.org, <dma147@linux-stats.org>
# Contact me on IRC in #linux-stats, #archlinux, #archlinux.de, #s9y on irc.freenode.net

# japanese language file

/**
 *  @version $Revision$
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.6
 */

@define("PLUGIN_DOWNLOADMANAGER_TITLE", "ダウンロードマネージャー");
@define("PLUGIN_DOWNLOADMANAGER_DESC", "
s9yに十分なダウンロードマネージャーの能力を提供します。インストール解除する時、関連するテーブルがすべて破棄されるでしょう!");
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE', 'ページの題名');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE_BLAHBLAH', 'ページの題名です。');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE', 'ヘッドライン');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE_BLAHBLAH', 'ページのヘッドラインです。');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL', '静的 URL');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL_BLAHBLAH', 'ページの URL を定義します (index.php?serendipity[subpage]=name)');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK', '固定リンク');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK_BLAHBLAH', 'Defines a custom permalink for the URL which can be much shorter than the Static URL. 絶対 HTTP パスの必要があり、最後に「.htm」か「.html」が必要です! (デフォルト: [http://blog/]downloads.html)');
@define("PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH", "受付データのパス");
@define("PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH_BLAHBLAH", "Full and absolute path to the directory in which you can upload bigger files to import them into your downloadmanager. (path must exist and be writeable for the server!)");
@define("PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH", "絶対ダウンロードデータパス");
@define("PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH_BLAHBLAH", "Full and absolute path to the directory in which the uploaded (and downloadable) files will be stored. (path must exist and be writeable for the server!)");
@define("PLUGIN_DOWNLOADMANAGER_HTTPPATH", "http path to plugin");
@define("PLUGIN_DOWNLOADMANAGER_HTTPPATH_BLAHBLAH", "absolute http path to plugin (usually \"/plugins/serendipity_event_downloadmanager\").");
@define("PLUGIN_DOWNLOADMANAGER_DATEFORMAT", "エントリの実際の日付の書式です、PHP の date() 関数の値を用います (デフォルト: \"Y/m/d, h:ia\")");
@define("PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE", "ファイルの日付を表示する");
@define("PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE_BLAHBLAH", "項目一覧でファイルの日付を表示すべきですか?");
@define("PLUGIN_DOWNLOADMANAGER_SHOWFILENAME", "ファイル名を表示する");
@define("PLUGIN_DOWNLOADMANAGER_SHOWFILENAME_BLAHBLAH", "項目一覧でファイルの名前を表示すべきですか?");
@define("PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE", "ファイルサイズを表示する");
@define("PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE_BLAHBLAH", "項目一覧でファイルのサイズを表示すべきですか?");
@define("PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS", "ダウンロードの # を表示する");
@define("PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS_BLAHBLAH", "項目一覧でファイルのダウンロード数を表示すべきですか?");
@define("PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD", "ファイル名項目のラベル");
@define("PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD_BLAHBLAH", "ここでファイル名の項目のラベルのラベルを変更します。");
@define("PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD", "ファイルサイズ項目のラベル");
@define("PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD_BLAHBLAH", "ここでファイルサイズの項目のラベルを変更します。");
@define("PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD", "ファイル日付項目のラベル");
@define("PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD_BLAHBLAH", "ここでファイルの日付の項目のラベルを変更します。");
@define("PLUGIN_DOWNLOADMANAGER_DLS_FIELD", "ダウンロード数項目のラベル");
@define("PLUGIN_DOWNLOADMANAGER_DLS_FIELD_BLAHBLAH", "ここで「このファイルのダウンロード数」の項目のラベルを変更します。");
@define("PLUGIN_DOWNLOADMANAGER_ICONWIDTH", "アイコンの幅");
@define("PLUGIN_DOWNLOADMANAGER_ICONWIDTHBLAH", "ファイル一覧のファイルタイプアイコンの幅です。");
@define("PLUGIN_DOWNLOADMANAGER_ICONHEIGHT", "アイコンの高さ");
@define("PLUGIN_DOWNLOADMANAGER_ICONHEIGHT_BLAHBLAH", "ファイル一覧のファイルタイプアイコンの高さです。");
@define("PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED", "登録ユーザーに隠しカテゴリを表示しますか?");
@define("PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED_BLAHBLAH", "Should hidden categories be shown to registered and logged in users?");

@define("PLUGIN_DOWNLOADMANAGER_NO_CATS_FOUND", "カテゴリがありません!");
@define("PLUGIN_DOWNLOADMANAGER_CATEGORIES", "カテゴリ");
@define("PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES", "サブカテゴリ");
@define("PLUGIN_DOWNLOADMANAGER_CATEGORY", "カテゴリ");
@define("PLUGIN_DOWNLOADMANAGER_NUMBER_OF_DOWNLOADS", "# ファイル");
@define("PLUGIN_DOWNLOADMANAGER_CATNAME", "カテゴリ名:");
@define("PLUGIN_DOWNLOADMANAGER_SUBCAT_OF", "Sub-category of:");
@define("PLUGIN_DOWNLOADMANAGER_ADD_CAT", "新規カテゴリの追加:");
@define("PLUGIN_DOWNLOADMANAGER_DEL_FILE", "このファイルを削除する...");
@define("PLUGIN_DOWNLOADMANAGER_DEL_CAT", "このカテゴリを削除する (and all files in it!)...");
@define("PLUGIN_DOWNLOADMANAGER_DEL_CAT_NOT_ALLOWD", "削除は許可されていません - サブカテゴリがあります!");
@define("PLUGIN_DOWNLOADMANAGER_DELETE_NOT_ALLOWED", "This category can not be deleted, because it contains at least one subcategory!");
@define("PLUGIN_DOWNLOADMANAGER_CAT_NOT_FOUND", "カテゴリが見つかりません!");
@define("PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT", "このカテゴリをダウンロードする");
@define("PLUGIN_DOWNLOADMANAGER_BACK", "戻る...");
@define("PLUGIN_DOWNLOADMANAGER_FILENAME", "ファイル名");
@define("PLUGIN_DOWNLOADMANAGER_FILESIZE", "ファイルサイズ");
@define("PLUGIN_DOWNLOADMANAGER_FILEDATE", "日付");
@define("PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS", "ダウンロード数");
@define("PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS_BLAH", "ダウンロードされた数です。");
@define("PLUGIN_DOWNLOADMANAGER_IMPORT_FILE", "Import this file from your incoming directory into this actual category...");
@define("PLUGIN_DOWNLOADMANAGER_COPY_NOT_ALLOWED", "Can not copy the new file from your incoming directory to the download directory!<br />This could happen if there is safe_mode activated in your php.ini.<br />Please deactivate the php safe_mode to use this feature!");
@define("PLUGIN_DOWNLOADMANAGER_DELETE_IN_INCOMING_NOT_ALLOWED", "I'm not allowed to delete the file from your incoming directory! Please delete this one file manually and then set the file permissions that I can delete all further files for you.");
@define("PLUGIN_DOWNLOADMANAGER_DELETE_IN_DOWNLOADDIR_NOT_ALLOWED", "I'm not allowed to delete the file from your download directory! Please set the file permissions that I can delete this file.");
@define("PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE", "受け付けディレクトリ:");
@define("PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE_BLAHBLAH", "Use this directory to upload files via FTP if you are not allowed to upload this file with the php-upload feature. This can happen if your file is too big than the maximum value in your php.ini or if file_uploads are deactivated in your php.ini.<br />現在のディレクトリ: ");
@define("PLUGIN_DOWNLOADMANAGER_THIS_FILE", "選択済ファイル");
@define("PLUGIN_DOWNLOADMANAGER_EDIT_FILE", "このファイルを編集する");
@define("PLUGIN_DOWNLOADMANAGER_MOVE_TO_CAT", "次にファイルを移動する:");
@define("PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC", "ファイルの説明");
@define("PLUGIN_DOWNLOADMANAGER_FILE_EDITED", "File successfully edited and saved!");
@define("PLUGIN_DOWNLOADMANAGER_DOWNLOAD_FILE", "このファイルをダウンロードする");
@define("PLUGIN_DOWNLOADMANAGER_UPLOAD_FILE", "ファイルのアップロード...");
@define("PLUGIN_DOWNLOADMANAGER_FILE", "ファイル");
@define("PLUGIN_DOWNLOADMANAGER_UPLOAD_NOT_ALLOWED", "ファイルのアップロードが許可されていません!<br />php.ini の中で許可します (項目名: file_uploads)!");
@define("PLUGIN_DOWNLOADMANAGER_ERRORS_OCCOURED", "ファイルアップロードの間にいくつかのエラーが発生しました!");
@define("PLUGIN_DOWNLOADMANAGER_ERRORS_NOTCOPIED", "これらのファイルをコピーできませんでした:");
@define("PLUGIN_DOWNLOADMANAGER_ERRORS_TOOBIG", "これらのファイルは大きすぎます:");
@define("PLUGIN_DOWNLOADMANAGER_NO_FILES_UPLOADED", "アップロード済ファイルが見つかりません!");
@define("PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY", "メディアライブラリからのファイル");
@define("PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY_BLAHBLAH", "You can import already uploaded files from the media library to your downloadmanager. Note: These files will not be moved, they will only be copied!<br />Current directory: ");
@define("PLUGIN_DOWNLOADMANAGER_HIDE_TREE", "Hide this and the complete subtree below this category...");
@define("PLUGIN_DOWNLOADMANAGER_UNHIDE_TREE", "Unhide this and the complete subtree below this category...");
@define("PLUGIN_DOWNLOADMANAGER_OPEN_CAT", "ファイルのアップロードか修正するこのカテゴリを開くためにクリックしてください...");

?>
