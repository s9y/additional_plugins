<?php # $Id$

/**
 *  @version $Revision$
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.2
 */

@define('PLUGIN_EVENT_TODOLIST_TITLE', 'ToDo/プロジェクト一覧');
@define('PLUGIN_EVENT_TODOLIST_DESC', 'Maintain a list of projects and their percentage completion.');
@define('PLUGIN_EVENT_TODOLIST_PROJECT', 'プロジェクト');
@define('PLUGIN_EVENT_TODOLIST_PROJECT_NAME', '名前');
@define('PLUGIN_EVENT_TODOLIST_HIDDEN', '
');
@define('PLUGIN_EVENT_TODOLIST_PERCENTDONE', '% 完了');
@define('PLUGIN_EVENT_TODOLIST_BLOGENTRY', 'ブログエントリ');
@define('PLUGIN_EVENT_TODOLIST_ADMINPROJECT', 'プロジェクト管理');
@define('PLUGIN_EVENT_TODOLIST_ORDER', 'プロジェクトの並べ替え基準:');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DESC', 'プロジェクトを表示する順番の方法を選択します。');
@define('PLUGIN_EVENT_TODOLIST_ORDER_NUM_ORDER', 'カスタム');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DATE_ACS', '日付 (過去から未来)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DATE_DESC', '日付 (未来から過去)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_ASC', '進行 (least complete at top)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_DESC', '進行 (most complete at top)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_CATEGORY', 'カテゴリ順');
@define('PLUGIN_EVENT_TODOLIST_ORDER_JSCATEGORY', 'カテゴリ順, with Javascript');
@define('PLUGIN_EVENT_TODOLIST_ORDER_ALPHA', 'アルファベット順');
@define('PLUGIN_EVENT_TODOLIST_PROJECTS', 'プロジェクト管理');
@define('PLUGIN_EVENT_TODOLIST_NOPROJECTS', '一覧にプロジェクトがありません');
@define('PLUGIN_EVENT_TODOLIST_TITLEDESC','プラグインのタイトルです。The value is passed to sidebar wrapper.');
@define('PLUGIN_EVENT_TODOLIST_COLOR1', '内側の色');
@define('PLUGIN_EVENT_TODOLIST_COLOR2', '外側の色');
@define('PLUGIN_EVENT_TODOLIST_COLORCONFIG', 'プログレスバーのデフォルトの色');
@define('PLUGIN_EVENT_TODOLIST_COLORCONFIGDESC', 'Pick default color of progress bars.  You can add to or modify these colors from the "Manage Colors" page.  This will only be effective if you have the PHP GD libraries installed.');
@define('PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLOR', 'プログレスバーの背景色');
@define('PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLORDESC', 'Enter a 6 digit hexadecimal color code for the background of the progress bars.  Use FFFFFF for white.  This will only be effective if you have the PHP GD libraries installed.');
@define('PLUGIN_EVENT_TODOLIST_WHITETEXTBORDER', 'Outline text in white');
@define('PLUGIN_EVENT_TODOLIST_WHITETEXTBORDERDESC', 'You may want to outline the text of the progress bar in white if your color bars are dark and obscure the text.');
@define('PLUGIN_EVENT_TODOLIST_OUTSIDETEXT', 'Place text outside of progress bar.');
@define('PLUGIN_EVENT_TODOLIST_OUTSIDETEXTDESC', 'This option will write the progress percentage to the right of the progress bar instead of in the middle of the progress bar.');
@define('PLUGIN_EVENT_TODOLIST_BARLENGTH', 'プログレスバーの長さ');
@define('PLUGIN_EVENT_TODOLIST_BARLENGTHDESC', 'Length of progress bar in pixels when the bars are not sorted categorically.このオプションは GD ライブラリを要求します。');
@define('PLUGIN_EVENT_TODOLIST_BARHEIGHT', 'プログレスバーの高さ');
@define('PLUGIN_EVENT_TODOLIST_BARHEIGHTDESC', 'ピクセル単位でのプログレスバーの高さです。このオプションは GD ライブラリを要求します。');
@define('PLUGIN_EVENT_TODOLIST_FONTSIZE', 'フォントサイズ');
@define('PLUGIN_EVENT_TODOLIST_FONTSIZEDESC', 'ピクセル単位でのフォントサイズです。このオプションは GD ライブラリを要求します。');
@define('PLUGIN_EVENT_TODOLIST_FONT', 'フォント');
@define('PLUGIN_EVENT_TODOLIST_FONTDESC', 'Pick a font for the progress bar text.  You can add additional fonts in the '.dirname(__FILE__).'/fonts/ directory.  The fonts must be TrueType fonts.  このオプションは GD ライブラリを要求します。');
@define('PLUGIN_EVENT_TODOLIST_CATBARLENGTH', 'プログレスバーの長さ (categorical sort)');
@define('PLUGIN_EVENT_TODOLIST_CATBARLENGTHDESC', 'Length of progress bar in pixels when the bars are sorted categorically.  You may want this to be shorter because of the room taken up by hierarchical categories.このオプションは GD ライブラリを要求します。');
@define('PLUGIN_EVENT_TODOLIST_CACHEIMAGE', '生成済画像をキャッシュする');
@define('PLUGIN_EVENT_TODOLIST_CACHEIMAGEDESC', 'Cache a copy of all generated progress bar graphics and serve them up statically.  This will result in faster load times for clients, and reduced load on your server.このオプションは GD ライブラリを要求します。');
@define('PLUGIN_EVENT_TODOLIST_NUMENTRIES', '表示するブログエントリの数');
@define('PLUGIN_EVENT_TODOLIST_NUMENTRIESDESC', 'Show this many recent blog entries when selecting a blog entry to link to from a given project progress bar.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY', 'カテゴリを使う');
@define('PLUGIN_EVENT_TODOLIST_CATEGORYDESC','プロジェクトを構成するためにカテゴリーを使用します。');
@define('PLUGIN_EVENT_TODOLIST_ADDPROJECT','プロジェクトを追加する');
@define('PLUGIN_EVENT_TODOLIST_EDITPROJECT','プロジェクトの編集');
@define('PLUGIN_EVENT_TODOLIST_PERCENTAGECOMPLETE','プロジェクト完了の割合');
@define('PLUGIN_EVENT_TODOLIST_PROJECTDESC','プロジェクトの詳細');
@define('PLUGIN_EVENT_TODOLIST_DEFAULT_NOTE','Please note, this is an event plugin and must either use the Event Output Wrapper, or a custom Sidebar to show sidebar list.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME','使用するカテゴリシステム:');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DESC','You can choose to use the blog category system, or the custom categories provided with this plugin.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_CUSTOM','カスタム');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DEFAULT','デフォルト');
@define('PLUGIN_EVENT_TODOLIST_CATDB_WARNING','
カスタムカテゴリを使用するように設定していますが、データベースにカテゴリが存在しません。データベースを作成するためにここをクリックしてください。');
@define('PLUGIN_EVENT_TODOLIST_ADD_CAT','カテゴリ管理');
@define('PLUGIN_EVENT_TODOLIST_ADD_COLOR','色を追加する');
@define('PLUGIN_EVENT_TODOLIST_MANAGE_COLORS','色管理');
@define('PLUGIN_EVENT_TODOLIST_CAT_NAME','カテゴリ名');
@define('PLUGIN_EVENT_TODOLIST_PARENT_CATEGORY','親カテゴリ');
@define('PLUGIN_EVENT_TODOLIST_ADMINCAT','カテゴリ管理');
@define('PLUGIN_EVENT_TODOLIST_CACHE_NAME','サイドバーキャッシュ');
@define('PLUGIN_EVENT_TODOLIST_CACHE_DESC','サイドバーの結果をキャッシュに入れることで、ページの速度を増加させます。');
@define('PLUGIN_EVENT_TODOLIST_NOGDLIB', 'PHP GD ライブラリがインストールされていないように見えます。Static images have been provided on the 5% marks, so completion rates will be rounded down to the nearest 5% mark.');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_NAME', '色名 (ドロップダウンボックスで使う)');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR1', 'バーの内側の色 (ff3333 のような 16 進数色表記)バーの内部は薄い色が好まれるかもしれません。');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR2', 'バーの外側の色 (ff3333 のような 16 進数色表記)');
@define('PLUGIN_EVENT_TODOLIST_COLOR', '色');
@define('PLUGIN_EVENT_TODOLIST_SAMPLE', 'サンプル');
@define('PLUGIN_EVENT_TODOLIST_COLORWHEEL', '色ホイール');
@define('PLUGIN_EVENT_TODOLIST_COLORWHEEL_INSTRUCTIONS', 'Hover over the color wheel or hue square to view colors.  Click to choose a color.  Copy and Paste six digit color codes into color manager fields.');

?>
