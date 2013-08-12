<?php # 

/**
 *  @version 
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.10
 */

//
//  for serendipity_event_userprofiles.php
//
@define('PLUGIN_EVENT_USERPROFILES_DBVERSION', '0.1');
@define('PLUGIN_EVENT_USERPROFILES_ILINK','<input class="direction_ltr" id="serendipity_event_userprofiles%s" type="radio" %s name="serendipity[profile%s]" value="%s" title="%s" />');
@define('PLUGIN_EVENT_USERPROFILES_LABEL','<label for="serendipity_event_userprofiles%s">%s</label>');

@define('PLUGIN_EVENT_USERPROFILES_CITY',               '都市名');
@define('PLUGIN_EVENT_USERPROFILES_COUNTRY',            '国名');
@define('PLUGIN_EVENT_USERPROFILES_URL',                'ホームページ');
@define('PLUGIN_EVENT_USERPROFILES_OCCUPATION',         '職業');
@define('PLUGIN_EVENT_USERPROFILES_HOBBIES',            '趣味');
@define('PLUGIN_EVENT_USERPROFILES_YAHOO',              'Yahoo');
@define('PLUGIN_EVENT_USERPROFILES_AIM',                'AIM');
@define('PLUGIN_EVENT_USERPROFILES_JABBER',             'Jabber');
@define('PLUGIN_EVENT_USERPROFILES_ICQ',                'ICQ');
@define('PLUGIN_EVENT_USERPROFILES_MSN',                'MSN');
@define('PLUGIN_EVENT_USERPROFILES_SKYPE',               'Skype');
@define('PLUGIN_EVENT_USERPROFILES_STREET',             '住所');
@define('PLUGIN_EVENT_USERPROFILES_BIRTHDAY',           '誕生日');

@define('PLUGIN_EVENT_USERPROFILES_SHOWEMAIL',          '電子メールアドレスを表示する');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCITY',           '都市名を表示する');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCOUNTRY',        '国名を表示する');
@define('PLUGIN_EVENT_USERPROFILES_SHOWURL',            'ホームページを表示する');
@define('PLUGIN_EVENT_USERPROFILES_SHOWOCCUPATION',     '職業を表示する');
@define('PLUGIN_EVENT_USERPROFILES_SHOWHOBBIES',        '趣味を表示する');
@define('PLUGIN_EVENT_USERPROFILES_SHOWYAHOO',          'Yahoo を表示する');
@define('PLUGIN_EVENT_USERPROFILES_SHOWAIM',            'AIM を表示する');
@define('PLUGIN_EVENT_USERPROFILES_SHOWJABBER',         'JabberM を表示する');
@define('PLUGIN_EVENT_USERPROFILES_SHOWICQ',            'ICQM を表示する');
@define('PLUGIN_EVENT_USERPROFILES_SHOWMSN',            'MSNM を表示する');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSKYPE',          'Skype を表示する');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSTREET',         '住所を表示する');

@define('PLUGIN_EVENT_USERPROFILES_SHOW',               '選択した著者のユーザープロフィールを表示します:');
@define('PLUGIN_EVENT_USERPROFILES_TITLE',              'ユーザープロフィール');
@define('PLUGIN_EVENT_USERPROFILES_DESC',               '簡単なユーザープロフィールを表示します。');
@define('PLUGIN_EVENT_USERPROFILES_SELECT',             '編集するプロフィールを選択してください。');
@define('PLUGIN_EVENT_USERPROFILES_VCARD',              'vCard を作成する');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_AT',    '%s の vCard を作成しました。');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_NOTE',  'アップロードディレクトリにこの vCard を見つけることができます。');
@define('PLUGIN_EVENT_USERPROFILES_VCARDNOTCREATED',    'vCard を作成できません。');

@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION', 'ファイル拡張子');
@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION_BLAHBLAH', 'Which file extension do the images of the authors have?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED', 'エントリ中にユーザーの写真を表示しますか?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED_DESC', 'If enabled, a picture for the user will be shown within each entry to visually indicate who has written the entry. The image file must be placed in the "img" Subfolder of your selected template and be called like the authorname. All special characters (quotes, spaces, ...) must be replaced by an "_" inside the filename.');

//
//  for serendipity_plugin_userprofiles.php
//
@define('PLUGIN_USERPROFILES_NAME',          "Serendipity 著者");
@define('PLUGIN_USERPROFILES_NAME_DESC',     "全著者の一覧を表示する");
@define('PLUGIN_USERPROFILES_TITLE',         "題名");
@define('PLUGIN_USERPROFILES_TITLE_DESC',    "表示するサイドバーの題名を入力します:");
@define('PLUGIN_USERPROFILES_TITLE_DEFAULT', "著者");

@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT', 'コメント数を表示しますか?');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_BLAHBLAH', 'Do you want to show the number of comments a visitor made? It can either be disabled, or you can append/prepend the comment count to the comment body, or you can place the commentcount anyplace you like by editing your comments.tpl template and placing {$comment.plugin_commentcount} at the place you want. You can customize the look of the container via the .serendipity_commentcount CSS class.');        
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_APPEND', 'コメント本文の後に追加する');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_PREPEND', 'コメント本文の前に追加する');        
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_SMARTY', '手動で Smarty テンプレートを編集');        

@define('PLUGIN_USERPROFILES_GRAVATAR', 'ローカルの画像ではなく Gravatar を使用しますか?');
@define('PLUGIN_USERPROFILES_GRAVATAR_DESC', 'Uses Gravatar image associated with your email address.  Register at www.gravatar.com');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE', 'Gravatar の写真サイズ');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE_DESC', 'Sets the display size for your Gravatar userpic, in square pixels. 最大は 80 です。');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING', 'Gravatar の最大評価');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING_DESC','Gravatar を許可する最大評価を設定します。値は G、PG、R か X です。');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT', 'デフォルトの Gravatar 画像の場所');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT_DESC', 'ユーザーが Gravatar を持っていない場合に表示、表示する画像の場所を指定します。');

@define('PLUGIN_USERPROFILES_BIRTHDAYSNAME', 'Birthdays of users');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE', 'Birthdays');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DESCRIPTION', 'Show when the users have the next birthday.');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DEFAULT', 'birthdays');

@define('PLUGIN_USERPROFILES_BIRTHDAYIN', 'Birthday in %d days');
@define('PLUGIN_USERPROFILES_BIRTHDAYTODAY', '今日は誕生日');

@define('PLUGIN_USERPROFILES_BIRTHDAYNUMBERS', 'Limit display of people having birthday to this number');
@define('PLUGIN_USERPROFILES_SHOWAUTHORS', 'ユーザー一覧を表示しますか?');
@define('PLUGIN_USERPROFILES_SHOWGROUPS', 'グループの詳細へのリンクを表示しますか?');
