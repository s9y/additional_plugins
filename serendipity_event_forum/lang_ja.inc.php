<?php # $Id: lang_ja.inc.php,v 1.3 2006/06/21 03:02:15 elf2000 Exp $

# (c) 2005 by Alexander 'dma147' Mieland, http://blog.linux-stats.org, <dma147@linux-stats.org>
# Contact me on IRC in #linux-stats, #archlinux, #archlinux.de, #s9y on irc.freenode.net

# japanese language file

/**
 *  @version $Revision: 1.3 $
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.8
 */

@define("PLUGIN_FORUM_TITLE", "ディスカッションフォーラム");
@define("PLUGIN_FORUM_DESC", "ユーザーに完全なディスカッションフォーラムを提供します。");
@define('PLUGIN_FORUM_PAGETITLE', 'ページの題名');
@define('PLUGIN_FORUM_PAGETITLE_BLAHBLAH', 'ページの題名です。');
@define('PLUGIN_FORUM_HEADLINE', 'ヘッドライン');
@define('PLUGIN_FORUM_HEADLINE_BLAHBLAH', 'ページのヘッドラインです。');
@define('PLUGIN_FORUM_PAGEURL', '静的 URL');
@define('PLUGIN_FORUM_PAGEURL_BLAHBLAH', 'ページの URL を定義します (index.php?serendipity[subpage]=name)');
@define("PLUGIN_FORUM_UPLOADDIR", "アップロードディレクトリへのサーバー上の絶対パス");
@define("PLUGIN_FORUM_UPLOADDIR_BLAHBLAH", "デフォルト: ".$serendipity['serendipityPath'].'files');
@define("PLUGIN_FORUM_DATEFORMAT", "エントリの実際の日付の書式を PHP の date() の値を用いて指定します。 (デフォルト: 「Y/m/d」)");
@define("PLUGIN_FORUM_TIMEFORMAT", "時間の書式");
@define("PLUGIN_FORUM_TIMEFORMAT_BLAHBLAH", "エントリの実際の日付の書式を PHP の date() の値を用いて指定します。 (デフォルト: 「h:ia」)");
@define("PLUGIN_FORUM_BGCOLOR_HEAD", "タイトルバーの背景色");
@define("PLUGIN_FORUM_BGCOLOR_HEAD_BLAHBLAH", "すべてのタイトルバーの背景色です。");
@define("PLUGIN_FORUM_BGCOLOR1", "1. 背景色");
@define("PLUGIN_FORUM_BGCOLOR2", "2. 背景色");
@define("PLUGIN_FORUM_APPLY_MARKUP", "マークアッププラグインを使うべきですか?");
@define("PLUGIN_FORUM_APPLY_MARKUP_BLAHBLAH", "「はい」の場合、すべてのマークアッププラグインがインストールされていた場合、投稿の書式に使えるでしょう (BB コード、表情文字、ギャラリー画像など...)");
@define("PLUGIN_FORUM_ITEMSPERPAGE", "ページ毎の項目数");
@define("PLUGIN_FORUM_ITEMSPERPAGE_BLAHBLAH", "1 ページ当たりどれ位項目を表示すべきかです。 (スレッド/投稿), デフォルト: 15");
@define("PLUGIN_FORUM_USE_CAPTCHAS", "スパムブロックを使う");
@define("PLUGIN_FORUM_USE_CAPTCHAS_BLAHBLAH", "スパムブロックプラグインを使うべきかどうかです (captcha)");
@define("PLUGIN_FORUM_UNREG_NOMARKUPS", "未登録ユーザーはマークアップしない");
@define("PLUGIN_FORUM_UNREG_NOMARKUPS_BLAHBLAH", "登録済ユーザーのみにマークアップを許可するべきか?");
@define("PLUGIN_FORUM_FILEUPLOAD_REGUSER", "登録済ユーザーのファイルアップロードを許可する");
@define("PLUGIN_FORUM_FILEUPLOAD_REGUSER_BLAHBLAH", "投稿へのファイルアップロードを登録済ユーザーに許可するべきか?");
@define("PLUGIN_FORUM_FILEUPLOAD_GUEST", "ゲストのファイルアップロードを許可する");
@define("PLUGIN_FORUM_FILEUPLOAD_GUEST_BLAHBLAH", "東京へのファイルアップロードをゲストに許可するべきか? (推奨しません!!!)");
@define("PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST", "ひとつの投稿での最大ファイル数");
@define("PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST_BLAHBLAH", "How many files at all should be allowed in one post?");
@define("FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING", "同時のファイルアップロード数");
@define("FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING_BLAHBLAH", "How many files can be uploaded when writing or editing a post");
@define("FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALL", "ユーザー当たりのファイルアップロード数");
@define("FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALLBLAHBLAH", "How many file-uploads at all should be allowed per registered user? Attention: if allowing file-uploads for guests, they will be able to upload as many files they want, because this option can not check the file-uploads of guests!!!");
@define("FORUM_PLUGIN_NOTIFYMAIL_FROM", "通知メール: 差出人電子メールアドレス");
@define("FORUM_PLUGIN_NOTIFYMAIL_FROM_BLAHBLAH", "通知メールを送信するときの差出人電子メールアドレスです (From フィールド)");
@define("FORUM_PLUGIN_NOTIFYMAIL_NAME", "通知メール: 差出人名");
@define("FORUM_PLUGIN_NOTIFYMAIL_NAME_BLAHBLAH", "通知メールの送信者の名前です (From フィールド)");
@define("FORUM_PLUGIN_ADMIN_NOTIFY", "管理者通知");
@define("FORUM_PLUGIN_ADMIN_NOTIFY_BLAHBLAH", "新規トピックか返信が投稿されたとき、管理者は通知メールを受け取るべきですか?");
@define("PLUGIN_FORUM_COLORTODAY", "「今日」の色");
@define("PLUGIN_FORUM_COLORYESTERDAY", "「昨日」の色");


@define("PLUGIN_FORUM_NO_BOARDS", "掲示板が定義されていません!");
@define("PLUGIN_FORUM_NO_ENTRIES", "スレッドがありません");
@define("PLUGIN_FORUM_BOARDS", "掲示板");
@define("PLUGIN_FORUM_THREADS", "スレッド数");
@define("PLUGIN_FORUM_POSTS", "投稿数");
@define("PLUGIN_FORUM_LASTPOST", "最終投稿");
@define("PLUGIN_FORUM_LASTREPLY", "最終返信");
@define("PLUGIN_FORUM_NO_THREADS", "スレッドが見つかりません");
@define("PLUGIN_FORUM_THREADTITLE", "スレッドの題名");
@define("PLUGIN_FORUM_POSTTITLE", "ヘッドライン");
@define("PLUGIN_FORUM_REPLIES", "返信数");
@define("PLUGIN_FORUM_VIEWS", "閲覧数");
@define("PLUGIN_FORUM_NO_REPLIES", "返信がありません");
@define("PLUGIN_FORUM_AUTHOR", "著者");
@define("PLUGIN_FORUM_MESSAGE", "メッセージ");
@define("PLUGIN_FORUM_BACKTOTOP", "トップに戻る");
@define("PLUGIN_FORUM_ALT_REOPEN", "このスレッドを再開する...");
@define("PLUGIN_FORUM_ALT_CLOSE", "このスレッドを閉じる...");
@define("PLUGIN_FORUM_ALT_MOVE", "このスレッドを別の掲示板に移動する...");
@define("PLUGIN_FORUM_ALT_DELETE", "このスレッドを削除する...");
@define("PLUGIN_FORUM_ALT_DELETE_POST", "この返信を削除する...");
@define("PLUGIN_FORUM_ALT_REPLY", "このスレッドに返信する...");
@define("PLUGIN_FORUM_ALT_QUOTE", "Reply to this thread by quoting this post...");
@define("PLUGIN_FORUM_ALT_EDIT", "返信を編集する...");
@define("PLUGIN_FORUM_ALT_DELETE", "この返信を削除する...");
@define("PLUGIN_FORUM_ALT_UNREAD", "not read before or new replies were made...");
@define("PLUGIN_FORUM_ALT_READ", "既に読んでいます...");
@define("PLUGIN_FORUM_ALT_DIRECTGOTOPOST", "直接投稿に移動する...");
@define("PLUGIN_FORUM_MARKUPS", "
もし管理者によって有効にされている場合、次のマークアップを使うことができます:<br />&nbsp; - <a href=\"http://www.s9y.org/forums/faq.php?mode=bbcode\" target=\"_blank\">BBCode</a><br />&nbsp; - 顔文字<br />&nbsp; - ギャラリー画像<br />");
@define("PLUGIN_FORUM_GUEST", "ゲスト");
@define("PLUGIN_FORUM_CONFIRM_DELETE_POST", "本当にこの投稿を削除しますか?");
@define("PLUGIN_FORUM_ORDER", "順番変更");
@define("PLUGIN_FORUM_BOARDNAME", "掲示板名");
@define("PLUGIN_FORUM_BOARDDESC", "説明");
@define("PLUGIN_FORUM_REALLY_DELETE_BOARDS", "Are you really sure, that you want to delete {num} board(s)?");
@define("PLUGIN_FORUM_REALLY_DELETE_THREAD", "Are you really sure, that you want to delete the thread");
@define("PLUGIN_FORUM_DELETE_OR_MOVE", "Should the threads be deleted or moved to another board?");
@define("PLUGIN_FORUM_WHERE_TO_MOVE", "Choose the board or delete them:");
@define("PLUGIN_FORUM_ADD_BOARD", "新規掲示板を追加する");
@define("PLUGIN_FORUM_PAGES", "Pages");
@define("PLUGIN_FORUM_MOVE_THREAD", "To which board do you want to move the thread");
@define("PLUGIN_FORUM_MOVE", "移動する");
@define("PLUGIN_FORUM_FROM_BOARD", "from board");
@define("PLUGIN_FORUM_TO_BOARD", "to board");
@define("PLUGIN_FORUM_SUBMIT", "送信する");
@define("PLUGIN_FORUM_RESET", "リセット");
@define("PLUGIN_FORUM_REG_USER", "登録済ユーザー");
@define("PLUGIN_FORUM_POSTS", "投稿数");
@define("PLUGIN_FORUM_VISITS", "訪問数");
@define("PLUGIN_FORUM_UPLOAD_FILE","ファイルアップロード");
@define("PLUGIN_FORUM_DOWNLOADCOUNT", "ダウンロード数:");
@define("PLUGIN_FORUM_REST_UPLOAD_USER", "ユーザーに残されたアップロード可能な数");
@define("PLUGIN_FORUM_REST_UPLOAD_POST", "この投稿にユーザーに残されたアップロード可能な数");
@define("PLUGIN_FORUM_ANNOUNCEMENT", "これを告知しますか?");
@define("PLUGIN_FORUM_SUBSCRIBE", "このスレッドを購読しますか?");
@define("PLUGIN_FORUM_UNSUBSCRIBE", "このスレッドの購読を止めますか?");
@define("PLUGIN_FORUM_TODAY", "今日");
@define("PLUGIN_FORUM_YESTERDAY", "昨日");
@define("PLUGIN_FORUM_UPLOAD_OVERWRITE", "上書き");
@define("PLUGIN_FORUM_UPLOAD_OVERWRITE_BLAHBLAH", "Should an already existent upload be overwritten with this upload?<br />Attention: This will overwrite *all* files with the same name and which are owned by you!");

@define("PLUGIN_FORUM_ERR_MISSING_THREADTITLE", "エラー: スレッドの題名が無いか短すぎます (最短 4 文字)! エントリは保存されませんでした!");
@define("PLUGIN_FORUM_ERR_MISSING_MESSAGE", "エラー: スレッドのテキストが無いか文字か過ぎます (最短 4 文字)! エントリは保存されませんでした!");
@define("PLUGIN_FORUM_ERR_THREAD_CLOSED", "エラー: 返信しようとしているスレッドが閉じられています! エントリは保存されませんでした!");
@define("PLUGIN_FORUM_ERR_EDIT_NOT_ALLOWED", "エラー: この投稿の編集は許可されませんでした! エントリは保存されませんでした!");
@define("PLUGIN_FORUM_ERR_DELETE_NOT_ALLOWED", "エラー: この投稿の削除は許可されませんでした! エントリは保存されませんでした!");
@define("PLUGIN_FORUM_ERR_DOUBLE_THREAD", "エラー: このスレッドは既に送信しています! エントリは保存されませんでした!");
@define("PLUGIN_FORUM_ERR_DOUBLE_POST", "エラー: この返信は既に送信しています! エントリは保存されませんでした!");
@define("PLUGIN_FORUM_ERR_POST_INTERVAL", "エラー: 投稿の間隔が短すぎます! エントリは保存されませんでした!");
@define("PLUGIN_FORUM_ERR_WRONG_CAPTCHA_STRING", "エラー: 間違ったcaptcha文字列を供給しました! エントリは保存されませんでした!");
@define("PLUGIN_FORUM_ERR_FILE_TOO_BIG", "ファイルが大きすぎます! (保存しませんでした!)");
@define("PLUGIN_FORUM_ERR_FILE_NOT_COPIED", "ファイルをコピーできません! (理由は不明です)");


// email notify
@define("PLUGIN_FORUM_EMAIL_NOTIFY_SUBJECT", "{blogurl} のフォーラムに {postauthor} さんが新規投稿をしました!");

@define("PLUGIN_FORUM_EMAIL_NOTIFY_PART1", "こんにちは,

{postauthor} がスレッドに新規返信を書き込みました。
スレッドタイトル:
{threadtitle}
フォーラム URL:
{forumurl}

");

@define ("PLUGIN_FORUM_EMAIL_NOTIFY_PART2", "This is, what he wrote:

----------------------------------------------------------------------
\"{replytext}\"
----------------------------------------------------------------------

");

@define ("PLUGIN_FORUM_EMAIL_NOTIFY_PART3", "次のリンクをクリックすることでスレッドに訪問することができます:
{posturl}

");










/* vim: set sts=4 ts=4 expandtab : */
?>
