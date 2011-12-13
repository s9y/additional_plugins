<?php # $Id: lang_ja.inc.php,v 1.12 2006/08/17 15:15:13 elf2000 Exp $

/**
 *  @version $Revision: 1.12 $
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.6
 */

//
//  serendipity_event_staticpage.php
//
@define('STATICPAGE_HEADLINE', 'ヘッドライン');
@define('STATICPAGE_HEADLINE_BLAHBLAH', 'Shows a headline above the content which is rendered as every other headline in your blog');
@define('STATICPAGE_TITLE', '静的ページ');
@define('STATICPAGE_TITLE_BLAHBLAH', 'デザインとすべての書式化されたブログとウェブログ内部に静的ページを表示します。管理インターフェースに新しいメニューを追加します。');
@define('CONTENT_BLAHBLAH', 'ページの内容です。');
@define('STATICPAGE_PERMALINK', '固定リンク');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'URL のために固定リンクを定義します。絶対 HTTP パスと拡張子が「.html」か「.html」である必要があります!');
@define('STATICPAGE_PAGETITLE', 'URL ショートハンド名 (下位互換性)');
@define('STATICPAGE_ARTICLEFORMAT', '記事として清書しますか?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', '「はい」の場合、自動的に記事として(色、境界線など)初期化され、出力します  (デフォルト: はい)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', '記事として初期化の時のページタイトル');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', '記事の書式を使用すると、テキストの表示とウェブログの日付が記事に表示されることを選択できます。');
@define('STATICPAGE_SELECT', '作成か編集する静的ページを選択してください。');
@define('STATICPAGE_PASSWORD_NOTICE', 'このページはパスワードプロテクトされています。承認されたパスワードを入力してください: ');
@define('STATICPAGE_PARENTPAGES_NAME', '親ページ');
@define('STATICPAGE_PARENTPAGE_DESC', '親ページの選択');
@define('STATICPAGE_PARENTPAGE_PARENT', '親ですか?');
@define('STATICPAGE_AUTHORS_NAME', '著者の名前');
@define('STATICPAGE_AUTHORS_DESC', 'この著者はこのページの所有者です。');
@define('STATICPAGE_FILENAME_NAME', 'テンプレート (Smarty)');
@define('STATICPAGE_FILENAME_DESC', 'このページに使用されるべきテンプレートのファイル名を入力します。その Smarty テンプレートファイルは、このプラグインのディレクトリに、あるいはのテンプレートディレクトリへ置くことができます。');
@define('STATICPAGE_SHOWCHILDPAGES_NAME', '子ページの表示');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', '現時のページのすべての子ページをリンク一覧として表示します。');
@define('STATICPAGE_PRECONTENT_NAME', '前置きコンテンツ');
@define('STATICPAGE_PRECONTENT_DESC', '子ページの一覧の前にこの内容を表示します。');
@define('STATICPAGE_CANNOTDELETE_MSG', 'このページは削除できません。子ページがデータベースにあります。はじめにそれらを削除してください。');
@define('STATICPAGE_IS_STARTPAGE', 'このページを Serendipity のフロントページに作成する');
@define('STATICPAGE_IS_STARTPAGE_DESC', 'Instead of showing the default Serendipity startpage, this static page will show up. Only define one page as frontpage! If you want to link to your usual Serendipity Frontpage, you need to use "index.php?frontpage". If you want to use this feature, you need to make sure that no other permalink-plugin (like voting, guestbook) are placed before the staticpage plugin in the Serendipity Plugin Configuration Event Queue.');
@define('STATICPAGE_TOP', 'トップ');
@define('STATICPAGE_NEXT', '次へ');
@define('STATICPAGE_PREV', '前へ');
@define('STATICPAGE_LINKNAME', '編集する');

@define('STATICPAGE_ARTICLETYPE', '記事の種類');
@define('STATICPAGE_ARTICLETYPE_DESC', '静止のページになる種類を選択します。');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'ページの順序');
@define('STATICPAGE_CATEGORY_PAGES', 'ページの編集');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'ページの種類');
@define('STATICPAGE_CATEGORY_PAGEADD', 'その他のプラグイン');

@define('PAGETYPES_SELECT', 'Select a page type to select.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', '説明:');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'ページの種類の説明です。');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'テンプレート名:');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', 'テンプレートからの名前です。それは静ページプラグイン、あるいはデフォルトテンプレートのディレクトリにある場合があります。');
@define('STATICPAGE_ARTICLETYPE_IMAGE', '画像パス:');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', '画像への URL です。');

@define('STATICPAGE_SHOWNAVI', 'ナビゲーションを表示する');
@define('STATICPAGE_SHOWNAVI_DESC', 'このページにナビゲーションを表示します。');
@define('STATICPAGE_SHOWONNAVI', 'サイドバーナビゲーションに表示する');
@define('STATICPAGE_SHOWONNAVI_DESC', 'サイドバーナビゲーションにこのページを表示します。');

@define('STATICPAGE_SHOWNAVI_DEFAULT', 'ナビゲーションを表示する');
@define('STATICPAGE_DEFAULT_DESC', '新規ページのデフォルト設定です。');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', 'サイドバーナビゲーション上でページを表示する');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', 'マークアップを表示する');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', '記事として整形する');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', '子ページ群を表示する');

@define('STATICPAGE_PAGEORDER_DESC', 'ここで、静止のページの順序を変更することができます。');
@define('STATICPAGE_PAGEADD_DESC', '静止のページのナビゲーションに含みたいプラグインを選択します。');
@define('STATICPAGE_PAGEADD_PLUGINS', '次のプラグインを静的ページのサイドバーに含むことが出来ます。');

@define('STATICPAGE_PUBLISHSTATUS', '公開状態');
@define('STATICPAGE_PUBLISHSTATUS_DESC', 'このページの公開の状態です。');
@define('STATICPAGE_PUBLISHSTATUS_DRAFT', '草稿');
@define('STATICPAGE_PUBLISHSTATUS_PUBLISHED', '公開済');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', 'ヘッドラインかナビゲーションに「前へ/次へ」を表示する');
@define('STATICPAGE_SHOWTEXTORHEADLINE_DESC', '');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', 'テキスト: 前へ/次へ');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', 'ヘッドライン');

@define('STATICPAGE_LANGUAGE', '言語');
@define('STATICPAGE_LANGUAGE_DESC', 'この再度の言語を選択します。');

@define('STATICPAGE_PLUGINS_INSTALLED', 'プラグインはインストール済です');
@define('STATICPAGE_PLUGIN_AVAILABLE', 'プラグインは利用できますが、インストールされていません。');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE', 'プラグインは利用できません');

@define('STATICPAGE_SEARCHRESULTS', '%d の静的ページが見つかりました:');

@define('LANG_ALL', 'すべての言語');
@define('LANG_EN', '英語');
@define('LANG_DE', 'ドイツ語');
@define('LANG_DA', 'デンマーク語');
@define('LANG_ES', 'スペイン語');
@define('LANG_FR', 'フランス語');
@define('LANG_FI', 'フィンランド語');
@define('LANG_CS', 'チェコ語 (Win-1250)');
@define('LANG_CZ', 'チェコ語 (ISO-8859-2)');
@define('LANG_NL', 'オランダ語');
@define('LANG_IS', 'アイスランド語');
@define('LANG_PT', 'ブラジル系ポルトガル語');
@define('LANG_BG', 'ブルガリア語');
@define('LANG_NO', 'ノルウェー語');
@define('LANG_RO', 'ルーマニア語');
@define('LANG_IT', 'イタリア語');
@define('LANG_RU', 'ロシア語');
@define('LANG_FA', 'ペルシア語');
@define('LANG_TW', '繁体字中国語 (Big5)');
@define('LANG_TN', '繁体字中国語 (UTF-8)');
@define('LANG_ZH', '簡体字中国語 (GB2312)');
@define('LANG_CN', '簡体字中国語 (UTF-8)');
@define('LANG_JA', '日本語');
@define('LANG_KO', '韓国語');

@define('STATICPAGE_STATUS', '状態');

//
//  serendipity_plugin_staticpage.php
//

@define('PLUGIN_STATICPAGELIST_NAME',                   '静的ページ一覧');
@define('PLUGIN_STATICPAGELIST_NAME_DESC',              'このプラグインは静的ページの一覧の設定します。これは静的プラグインバージョン 1.2.22 以上を要求します。');
@define('PLUGIN_STATICPAGELIST_TITLE',                  '題名');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',             '表示するサイドバーのタイトルを入力します。:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',          '静的ページ');
@define('PLUGIN_STATICPAGELIST_LIMIT',                  '表示の数');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',             '表示する静的ページの数を入力思案す。0 は制限なしを意味します。');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',         'フロントページのリンクを表示する');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',         'フロントページへのリンクを表示します。');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME',     'フロントページ');
@define('PLUGIN_LINKS_IMGDIR',                          'プラグインの画像ディレクトリを使用する');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',                 'Tell the URL path to use for accessing the tree structure images. The "img" subfolder needs to be in this directory, and is delivered with this plugin.');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME',         'アイコンかただのテキスト');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC',         'ツリー構造かただのテキストメニューを表示します．');
@define('PLUGIN_STATICPAGELIST_ICON',                   'ツリー');
@define('PLUGIN_STATICPAGELIST_TEXT',                   'ただのテキスト');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY',            '親ページのみ表示しますか?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC',       '有効の場合、親ページのみ表示します。無効の場合、子ページも表示するでしょう。');
@define('PLUGIN_STATICPAGELIST_IMG_NAME',               'ツリー構造で画像を有効にする');

?>
