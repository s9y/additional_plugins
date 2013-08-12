<?php # 

/**
 *  @version 
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.2
 */

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKLIST_TITLE', 'リンク集');
@define('PLUGIN_LINKLIST_DESC', '表示するリンク集の維持をします。');
@define('PLUGIN_LINKLIST_LINK', 'リンク');
@define('PLUGIN_LINKLIST_LINK_NAME', '名前');
@define('PLUGIN_LINKLIST_ADMINLINK', 'リンク管理');
@define('PLUGIN_LINKLIST_ORDER', 'リンクの整理基準:');
@define('PLUGIN_LINKLIST_ORDER_DESC', '表示するリンクの整理基準を選択します。');
@define('PLUGIN_LINKLIST_ORDER_NUM_ORDER', 'カスタム');
@define('PLUGIN_LINKLIST_ORDER_DATE_ACS', '日付 (過去から未来)');
@define('PLUGIN_LINKLIST_ORDER_DATE_DESC', '日付 (未来から過去)');
@define('PLUGIN_LINKLIST_ORDER_CATEGORY', 'Categorically');
@define('PLUGIN_LINKLIST_ORDER_ALPHA', 'アルファベット順');
@define('PLUGIN_LINKLIST_LINKS', 'リンク管理');
@define('PLUGIN_LINKLIST_NOLINKS', '一覧にリンクがありません');
@define('PLUGIN_LINKLIST_CATEGORY', 'カテゴリを使う');
@define('PLUGIN_LINKLIST_CATEGORYDESC','リンクの組み立てにカテゴリを使用します。');
@define('PLUGIN_LINKLIST_ADDLINK','リンクを追加する');
@define('PLUGIN_LINKLIST_LINK_EXAMPLE','例: http://www.s9y.org or http://www.s9y.org/forums/');
@define('PLUGIN_LINKLIST_EDITLINK','リンクを編集する');
@define('PLUGIN_LINKLIST_LINKDESC','リンクの説明');
@define('PLUGIN_LINKLIST_CATEGORY_NAME','使用するカテゴリシステム:');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DESC','ブログのカテゴリシステムか、このプラグインで提供するカスタムカテゴリを使用するか選択することができます。');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM','カスタム');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT','デフォルト');
@define('PLUGIN_LINKLIST_ADD_CAT','カテゴリ管理');
@define('PLUGIN_LINKLIST_CAT_NAME','カテゴリ名');
@define('PLUGIN_LINKLIST_PARENT_CATEGORY','親カテゴリ');
@define('PLUGIN_LINKLIST_ADMINCAT','カテゴリ管理');
@define('PLUGIN_LINKLIST_CACHE_NAME','サイドバーのキャッシュ');
@define('PLUGIN_LINKLIST_CACHE_DESC','サイドバーをキャッシュし、ページ表示の速度を向上させます。Cache is only updated when links are added through the admin interface.');
@define('PLUGIN_LINKLIST_ENABLED_NAME','有効');
@define('PLUGIN_LINKLIST_ENABLED_DESC','プラグインは有効です。');
@define('PLUGIN_LINKLIST_DELETE_WARN','When a category is deleted all its entries will be moved to the root category.');

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKS_NAME', 'リンク集');
@define('PLUGIN_LINKS_BLAHBLAH', 'リンク管理 - サイドバーにお気に入りのリンク集を表示します。');
@define('PLUGIN_LINKS_TITLE', '題名');
@define('PLUGIN_LINKS_TITLE_BLAHBLAH', 'ここのリンクの題名です。');
@define('PLUGIN_LINKS_TOP_LEVEL', 'トップレベルのテキスト');
@define('PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH', 'Type any text you wish to appear on the top level here (it may be left blank)');
@define('PLUGIN_LINKS_DIRECTXML', 'XML を直接入力:');
@define('PLUGIN_LINKS_DIRECTXML_BLAHBLAH', 'xmlデータを直接入力するか、あるいはリンクを管理するためにウェブ・ページを使用するでしょう。');
@define('PLUGIN_LINKS_LINKS', 'リンク一覧');
@define('PLUGIN_LINKS_LINKS_BLAHBLAH', 'XML を使います!! - ディレクトリには "<dir name="dirname"> と閉じるために </dir> を使います - リンクには "<link name="linkname" link="http://link.com/" /> を使います');
@define('PLUGIN_LINKS_OPENALL', '「すべて開く」のテキスト');
@define('PLUGIN_LINKS_OPENALL_BLAHBLAH', '「すべて開く」リンクへの文字列を入力します。');
@define('PLUGIN_LINKS_OPENALL_DEFAULT', 'すべて開く');
@define('PLUGIN_LINKS_CLOSEALL', '「すべて閉じる」のテキスト');
@define('PLUGIN_LINKS_CLOSEALL_BLAHBLAH', '「すべて閉じる」リンクへの文字列を入力します。');
@define('PLUGIN_LINKS_CLOSEALL_DEFAULT', 'すべて閉じる');
@define('PLUGIN_LINKS_SHOW', '「開く」と「閉じる」のリンクを表示しますか?');
@define('PLUGIN_LINKS_SHOW_BLAHBLAH', '「すべて開く」と「すべて閉じる」のリンクを見えるようにしたいですか?');
@define('PLUGIN_LINKS_LOCATION', '「すべて開く」と「すべて閉じる」リンクの場所');
@define('PLUGIN_LINKS_LOCATION_BLAHBLAH', '「すべて開く」と「すべて閉じる」リンクの場所の場所を指定します。');
@define('PLUGIN_LINKS_LOCATION_TOP', '上');
@define('PLUGIN_LINKS_LOCATION_BOTTOM', '下');
@define('PLUGIN_LINKS_SELECTION', '選択を使いますか?');
@define('PLUGIN_LINKS_SELECTION_BLAHBLAH', 'もし「はい」なら、ノードを選択することができます(ハイライトされます)');
@define('PLUGIN_LINKS_COOKIE', 'Cookie を使いますか?');
@define('PLUGIN_LINKS_COOKIE_BLAHBLAH', 'もし「はい」なら、Cookie を用いてツリーの状態を覚えます。');
@define('PLUGIN_LINKS_LINE', '線を使いますか?');
@define('PLUGIN_LINKS_LINE_BLAHBLAH', 'もし「はい」なら、ツリーは線を描画します。');
@define('PLUGIN_LINKS_ICON', 'アイコンを使う');
@define('PLUGIN_LINKS_ICON_BLAHBLAH', 'もし「はい」なら、ツリーはアイコンを描画します。');
@define('PLUGIN_LINKS_STATUS', '状態テキストを使う');
@define('PLUGIN_LINKS_STATUS_BLAHBLAH', 'もし「はい」なら、URL の代わりにステータスバーにノード名を表示します。');
@define('PLUGIN_LINKS_CLOSELEVEL', '同じレベルを閉じる');
@define('PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH', 'もし「はい」なら、親のうちのひとつのノードだけが同時に開くことができます。「すべて開く」と「すべて閉じる」が有効の場合、何もしません。親の内の1つのノードだけが同時に拡張することができます。');
@define('PLUGIN_LINKS_TARGET', '対象(target 属性)');
@define('PLUGIN_LINKS_TARGET_BLAHBLAH', 'リンクの対象(target 属性) - 「_blank」「_self」「_top」「_parent」かフレーム名のみ指定できます。');
@define('PLUGIN_LINKS_IMGDIR', 'プラグインディレクトリ画像を使う');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'If set to "yes" the plugin will assume images will be in the plugins folder. If set to "no" the plugin will point image paths to "/templates/default/img/". Turning plugin image path off is necessary for shared installs, but will require the images be moved manually');
@define('PLUGIN_LINKS_STYLE', '「dtree」スタイルを使う');
@define('PLUGIN_LINKS_STYLE_BLAHBLAH', 'dtree スタイルの使用はより清潔な外観を提供しますが、リンクがロボットによって解析されることは許可しません。');

?>
