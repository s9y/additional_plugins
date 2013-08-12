<?php # 

/**
 *  @version $Revision$
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.3
 */

//
//  serendipity_event_mycalendar.php
//
@define('PLUGIN_MYCALENDAR_TITLE', '自分のカレンダー');
@define('PLUGIN_MYCALENDAR_DESC', '個人カレンダーの管理をします。');
@define('PLUGIN_MYCALENDAR_EVENT_MISSINGDATA', 'ユーザの入力が足りません');
@define('PLUGIN_MYCALENDAR_EVENTLIST', 'これは近く公開のイベントのリストです。イベントを削除するためには、両方のフィールドを単に空にしてください。');
@define('PLUGIN_MYCALENDAR_EVENTNAME', 'イベント名');
@define('PLUGIN_MYCALENDAR_EVENTURI', 'これへのリンク可能な URL');
@define('PLUGIN_MYCALENDAR_EVENTURI_TITLE', 'リンクの題名');
@define('PLUGIN_MYCALENDAR_EVENTDATE', 'イベント日');

//
//  serendipity_plugin_mycalendar.php
//
@define('PLUGIN_MYCALENDAR_SIDE_NAME',          '自分のカレンダー');
@define('PLUGIN_MYCALENDAR_SIDE_DESC',          'X の近く公開の予定されたイベントを含めた個人のカレンダーを表示します。');
@define('PLUGIN_MYCALENDAR_SIDE_ITEMS',         '項目の量');
@define('PLUGIN_MYCALENDAR_SIDE_ITEMS_DESC',    'どれくらい項目を表示しますか?');
@define('PLUGIN_MYCALENDAR_SIDE_SHOWTIME',      'イベントの期間');
@define('PLUGIN_MYCALENDAR_SIDE_SHOWTIME_DESC', 'イベント日の後どれ位の日数イベントを表示するべきか');
@define('PLUGIN_MYCALENDAR_SIDE_PRUNE',         '除去');
@define('PLUGIN_MYCALENDAR_SIDE_PRUNE_DESC',    'それらが起こった後にイベントを削除しますか?');
@define('PLUGIN_MYCALENDAR_SIDE_COUNTDOWN',         'カウントダウン');
@define('PLUGIN_MYCALENDAR_SIDE_COUNTDOWN_DESC',    '目的の日までの日数を表示しますか?');
@define('PLUGIN_MYCALENDAR_SIDE_SKIPFIRSTFUTURE',         'はじめての未来のエントリのカウントダウン時間を飛ばしますか?');

@define('PLUGIN_MYCALENDAR_EVENTDATE2', 'イベントの終了日');
@define('PLUGIN_MYCALENDAR_RSS', 'RSS 2.0 のリンクを表示する');