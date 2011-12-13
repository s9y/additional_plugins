<?php # $Id: lang_ja.inc.php,v 1.5 2011/01/22 17:08:17 elf2000 Exp $

/**
 *  @version $Revision: 1.5 $
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.3
 */

@define('PLUGIN_EVENT_FORGOTPASSWORD_NAME', 'パスワード忘れ');
@define('PLUGIN_EVENT_FORGOTPASSWORD_DESC', '選択したユーザーのパスワードを変更します');
@define('PLUGIN_EVENT_FORGOTPASSWORD_LOST_PASSWORD', 'パスワード忘れ?');
@define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_USERNAME', 'ここに忘れたアカウントのユーザー名を入力する');
@define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_PASSWORD', '希望のパスワードを入力する');
@define('PLUGIN_EVENT_FORGOTPASSWORD_SEND_EMAIL', '電子メールを送信する');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SUBJECT', 'パスワード忘れ');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_BODY', "誰か(おそらく自分自身)がウェブログのアカウントパスワードのリセットを希望しました。\nパスワードのリセットを希望する場合、次のリンクをクリックしてください。:\n");
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR', 'データベースに接続できません');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_CANNOT_SEND', "電子メールを送信できません。これは php.ini の SMTP 設定が悪いか、プロファイルの電子メールアドレスが正しくない為です。");
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SENT', '電子メールの送信に成功しました。メールボックスを確認してください。');
@define('PLUGIN_EVENT_FORGOTPASSWORD_CHANGE_PASSWORD', 'パスワードを変更する');
@define('PLUGIN_EVENT_FORGOTPASSWORD_PASSWORD_CHANGED', 'パスワードの変更に成功しました。');
@define('PLUGIN_EVENT_FORGOTPASSWORD_USER_NOT_EXIST', '希望のユーザー名は、データベースに存在しません。戻って再度試してください。');

@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAIL', 'ユーザーがメールアドレスなしでパスワードを変更しようとした際、メールの通知を送信しますか?');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT', '通知メールの内容');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT_DEFAULT', 'User "%s" tried to login, but no mail address is assigned. Please create a new password and contact this user manually.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER', 'Error message if no mail address exists.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_DEFAULT', 'No mail address has been configured for that author. A new password cannot be sent.');

?>
