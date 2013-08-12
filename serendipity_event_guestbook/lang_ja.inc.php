<?php # 

/**
 *  @version $Revision$
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.1
 */

//
//  serendipity_event_guestbook.php
//
@define('GUESTBOOK_HEADLINE', 'ヘッドライン');
@define('GUESTBOOK_HEADLINE_BLAHBLAH', 'ページのヘッドラインです。');
@define('GUESTBOOK_TITLE', 'ゲストブック');
@define('GUESTBOOK_TITLE_BLAHBLAH', '通常のブログデザインの内側にゲストブックを表示します。');
@define('GUESTBOOK_PAGETITLE', 'ページの題名');
@define('GUESTBOOK_PAGETITLE_BLAHBLAH', 'ページの題名です。');
@define('GUESTBOOK_PAGEURL', '静的 URL');
@define('GUESTBOOK_PAGEURL_BLAHBLAH', 'ページの URL を定義します( index.php?serendipity[subpage]=name )');
@define('GUESTBOOK_SESSIONLOCK', 'セッションのロック');
@define('GUESTBOOK_SESSIONLOCK_BLAHBLAH', 'If active, only one entry per session(user). Sometimes good, sometimes not good, because maybe someone forgot something and want to post another entry!!!');
@define('GUESTBOOK_TIMELOCK', 'time lock');
@define('GUESTBOOK_TIMELOCK_BLAHBLAH', 'ユーザーエントリは何秒後に別の投稿ができるか指定します。ダブルクリックによっる複数投稿の回避かスパムロボットの妨害に効果的です。');
@define('GUESTBOOK_EMAILADMIN', '電子メール管理');
@define('GUESTBOOK_EMAILADMIN_BLAHBLAH', '「はい」にすると各新規エントリの度に管理者は電子メールを受け取ります。');
@define('GUESTBOOK_TARGETMAILADMIN', '管理者の電子メールアドレス');

@define('GUESTBOOK_NUMBER', 'ページ毎のエントリ数');
@define('GUESTBOOK_NUMBER_BLAHBLAH', 'ページ毎にどれくらいのエントリを表示したいですか?');
@define('GUESTBOOK_WORDWRAP', '1 行辺りの文字数');
@define('GUESTBOOK_WORDWRAP_BLAHBLAH', '何文字の後で自動的に次の行に改行しますか?');
@define('GUESTBOOK_SHOWHOMEPAGE', 'ユーザーの URL を表示しますか?');
@define('GUESTBOOK_SHOWEMAIL', 'ユーザーの電子メールを表示しますか?');
@define('GUESTBOOK_DATEFORMAT', '日付の書式');

@define('SUBMIT', 'エントリの送信');
@define('GUESTBOOK_NEXTPAGE', '次のページ');
@define('GUESTBOOK_PREVPAGE', '前のページ');
@define('TEXT_DELETE', '削除');
@define('TEXT_SAY', 'said');
@define('TEXT_EMAIL', '電子メール');
@define('TEXT_NAME', '名前');
@define('TEXT_HOMEPAGE', 'ホームページ');
@define('TEXT_COMMENT', 'テキスト');
@define('TEXT_EMAILSUBJECT', 'ブログ: 新規ゲストブックエントリ');
@define('TEXT_EMAILTEXT', '%s さんがゲストブックにちょうど書き込みました:\n%s');
@define('ERROR_TIMELOCK', '2 つのエントリの間は少なくとも %s 秒必要です!');
@define('ERROR_NAMEEMPTY', '名前を入力してください。');
@define('ERROR_TEXTEMPTY', 'テキストを入力してください。');
@define('ERROR_OCCURRED', 'いくつかのエラーです:');
@define('QUESTION_DELETE', '本当に %s のエントリを削除しますか?');

//
//  serendipity_plugin_guestbook.php
//
@define('PLUGIN_GUESTSIDE_NAME', 'ゲストブックサイドバー');
@define('PLUGIN_GUESTSIDE_BLAHBLAH', 'サイドバーに最新のゲストブックの項目を表示します。');
@define('PLUGIN_GUESTSIDE_TITLE', '項目の題名');
@define('PLUGIN_GUESTSIDE_TITLE_BLAHBLAH', 'サイドバー項目の題名を設定します。');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL', '電子メールを表示する');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL_BLAHBLAH', '書き込み人の電子メールアドレスを表示するべきですか?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE', 'ホームページを表示する');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE_BLAHBLAH', '書き込み人のホームページを表示するべきですか?');
@define('PLUGIN_GUESTSIDE_MAXCHARS', '最大文字数');
@define('PLUGIN_GUESTSIDE_MAXCHARS_BLAHBLAH', '内容の最大文字長です。');
@define('PLUGIN_GUESTSIDE_MAXITEMS', '最大項目数');
@define('PLUGIN_GUESTSIDE_MAXITEMS_BLAHBLAH', '表示する項目の数を設定します。');

?>
