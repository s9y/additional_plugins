<?php # 

/**
 *  @version 
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.25
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'エントリーのタグ');
@define('PLUGIN_EVENT_FREETAG_DESC', 'エントリーの自由なタグを許可します。');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'いくつかのタグをエントリーに適用します。カンマ(「,」)で複数のタグを分割します。');
@define('PLUGIN_EVENT_FREETAG_LIST', 'このエントリーに定義されたタグ: %s');
@define('PLUGIN_EVENT_FREETAG_USING', '「%s」としてタグ付けされたエントリー');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'タグ「%s」に関連したタグ');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED','関連したタグはありません。');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'すべての定義済みタグ');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'タグの管理');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'すべてのタグを管理する');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', '「空」のタグを管理する');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'タグがないエントリーの一覧');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', '「空」タグのエントリーの一覧');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'エントリーはタグがありません!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'タグ');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', '重み');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', '操作');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', '名称変更');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', '分割');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', '削除');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'タグ「%s」を本当に削除しますか?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'カンマで区切ったタグを使用する:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', '関連タグへのタグ クラウドを表示しますか?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'X-FreeTag-HTTP-Headers を送信する');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST', 'エントリーを書いたとき、全タグの一覧をクリックできるように表示する');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT', 'Activate Find-tags-as-you-type');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'エントリータグの表示');
@define('PLUGIN_FREETAG_BLAHBLAH', 'エントリーの既存タグの一覧を表示します。');
@define('PLUGIN_FREETAG_NEWLINE', '各タグの後に改行を入れますか?');
@define('PLUGIN_FREETAG_XML', 'XML アイコンを表示しますか?');
@define('PLUGIN_FREETAG_SCALE','(Technorati、flickr のように)タグのフォントサイズを人気度に依存して変化させますか?');
@define('PLUGIN_FREETAG_UPGRADE1_2','エントリー番号の %d 個のタグをアップグレード中: %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'いくつのタグを表示するべきですか?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'How many occurences must a tag have in order to be shown?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'タグ クラウドの最小フォントサイズ(単位:パーセント)');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'タグ クラウドの最大フォントサイズ(単位:パーセント)');

@define('PLUGIN_EVENT_FREETAG_USE_FLASH', 'タグ クラウドの表示に Flash を使いますか?');
@define('PLUGIN_EVENT_FREETAG_FLASH_TAG_COLOR', 'Flash タグの色 (rrggbb)');
@Define('PLUGIN_EVENT_FREETAG_FLASH_TRANSPARENT', 'Flash タグ クラウドの背景色を透過にしますか?');
@define('PLUGIN_EVENT_FREETAG_FLASH_BG_COLOR', 'Flash タグ クラウドの背景色 (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_WIDTH', 'Flash タグ クラウドの幅');
@define('PLUGIN_EVENT_FREETAG_FLASH_SPEED', 'Flash タグ クラウドのモーション速度');


@define('PLUGIN_FREETAG_META_KEYWORDS', 'HTML ソースに埋め込む meta keywords の数 (0: 無効)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'タグに関連するエントリー一覧:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','タグによる関連エントリーを表示しますか?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','関連エントリーをいくつ表示しますか?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'フッターでタグを表示しますか?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'If enabled, the tags will be shown in the footer of an entry. If disabled, the tags will be put inside the body/extended part of your entries.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', '半角英字は小英字(ABC ではなく abc)に');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', '関連タグ');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'タグ リンク');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'すべてのカテゴリーに関連するタグを作成しますか?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'If enabled, all categories that an entry is assigned to will be added as tags to your entry. You can set all category associations of all your existing entries within the "Manage Tags" menu of your Administration Suite.');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE', 'サイドバーテンプレート');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION', 'If set the template is used to render the tag sidebar. In the template there is a variable <tags> available which contains the list of tags in the format <tagName> => array(href => <tagLink>, count => <tagCount>)');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', '存在するエントリーに割り当てられたすべてのカテゴリーをタグに変換する');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', 'エントリー #%d のカテゴリーを変換しました(%s): %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'すべてのカテゴリーをタグに変換します。');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Automatted keywords');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'You can assign keywords (separated by ",") for each tag. Whenever you use those keywords in the text of your entries, the corresponding tag is assigned to your entry. Note that many automatted keywords may increase the time taken for saving an entry.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'キーワード <strong>%s</strong> を見つけました。自動的にタグ <strong><em>%s</em></strong> に割り当てました。<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', '%d から %d のエントリーの取得中');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (合計 %d 個のエントリー)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'エントリーの次のバッチの取得中...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Reparse all automatted keywords');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Warning: This function will fetch and re-save every single one of your entries. This will take some time, and it might even damage existing articles. It is suggested you first backup your database! Click on "CANCEL" to abort this action.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', 'タグ名');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', 'タグ数');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE',    'XML 画像の画像に関するテンプレートのパス');

@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2', 'If set to "Smarty", then a smarty variable {$entry.freetag} will be created that you can place anywhere in your entries.tpl template file.');

@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY', 'Extended Smarty');
@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY_DESC', 'Emit seperate Smarty-variables for later use in a template. This will override the other settings. An example for later use can be found in the Readme.');
