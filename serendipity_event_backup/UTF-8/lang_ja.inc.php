<?php # $Id$

/**
 *  @version $Revision$
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.4
 */

@define("PLUGIN_BACKUP_TITLE", "バックアップインターフェース");
@define("PLUGIN_BACKUP_DESC", "
自動的に s9y のデータベース内テーブル、データベース全体およびファイルからバックアップを作る能力を提供します。現在 MySQL(i) データベースのみサポートしています。警告: このプラグインは大きなデータベースやディレクトリーでは正しく処理できません。");
@define("PLUGIN_BACKUP_ABSPATH_BACKUPDIR", "バックアップディレクトリへの絶対パス");
@define("PLUGIN_BACKUP_ABSPATH_BACKUPDIR_BLAHBLAH", "このディレクトリはウェブサイトのドキュメントルートの外にあるべきです。それは存在し、ウェブサーバには書き込み可能でなければなりません!");
@define("PLUGIN_BACKUP_NOT_FOUND", "バックアップが見つかりません");
@define("PLUGIN_BACKUP_SQL_RECOVERED", "SQL バックアップが回復しました");
@define("PLUGIN_BACKUP_AUTO_SQL_BACKUP_STARTED", "自動 SQL バックアップが開始しました");
@define("PLUGIN_BACKUP_AUTO_SQL_BACKUP_STOPPED", "自動 SQL バックアップが停止しました");
@define("PLUGIN_BACKUP_AUTO_SQL_DELETE_STARTED", "自動 SQL 削除が開始しました");
@define("PLUGIN_BACKUP_AUTO_SQL_DELETE_STOPPED", "自動 SQL 削除が停止しました");
@define("PLUGIN_BACKUP_SQL_SAVED", "実際の SQL バックアップが保存されました");
@define("PLUGIN_BACKUP_HTML_RECOVERED", "HTML バックアップが回復しました");
@define("PLUGIN_BACKUP_AUTO_HTML_BACKUP_STARTED", "自動 HTML バックアップが開始しました");
@define("PLUGIN_BACKUP_AUTO_HTML_BACKUP_STOPPED", "自動 HTML バックアップが停止しました");
@define("PLUGIN_BACKUP_AUTO_HTML_DELETE_STARTED", "自動 HTML 削除が開始しました");
@define("PLUGIN_BACKUP_AUTO_HTML_DELETE_STOPPED", "自動 HTML 削除が停止しました");
@define("PLUGIN_BACKUP_HTML_SAVED", "実際の HTML バックアップが保存されました");
@define("PLUGIN_BACKUP_PLEASE_CHOOSE", "選択してください");
@define("PLUGIN_BACKUP_STRUCT_AND_DATA", "構造とデータ");
@define("PLUGIN_BACKUP_ONLY_STRUCT", "構造のみ");
@define("PLUGIN_BACKUP_ONLY_DATA", "データのみ");
@define("PLUGIN_BACKUP_WITH_DROP_TABLE", "一緒にテーブルを破棄する");
@define("PLUGIN_BACKUP_ZIPPED", "gzip 圧縮");
@define("PLUGIN_BACKUP_WHOLE_DATABASE", "データベース全体");
@define("PLUGIN_BACKUP_START_BACKUP", "バックアップを開始する...");
@define("PLUGIN_BACKUP_MINUTES", "分間毎");
@define("PLUGIN_BACKUP_HOUR", "1 時間毎");
@define("PLUGIN_BACKUP_HOURS", "時間毎");
@define("PLUGIN_BACKUP_DAYS", "日間毎");
@define("PLUGIN_BACKUP_WEEKS", "週間毎");
@define("PLUGIN_BACKUP_EVERY", "");
@define("PLUGIN_BACKUP_MONTHS", "ヶ月毎");
@define("PLUGIN_BACKUP_AUTO_BACKUP", "自動バックアップ");
@define("PLUGIN_BACKUP_ACTIVATE_AUTO_BACKUP", "自動バックアップを起動する");
@define("PLUGIN_BACKUP_TIME_BET_BACKUPS", "バックアップ間の時間");
@define("PLUGIN_BACKUP_DEL_OLD_BACKUPS", "より古いバックアップを削除する");
@define("PLUGIN_BACKUP_ACTIVATE_AUTO_DELETE", "古いバックアップを削除を自動起動する");
@define("PLUGIN_BACKUP_OLDER_THAN", "バックアップが");
@define("PLUGIN_BACKUP_WILL_BE_DELETED", "より古い場合に削除");
@define("PLUGIN_BACKUP_FILENAME", "ファイル名");
@define("PLUGIN_BACKUP_FILESIZE", "ファイルサイズ");
@define("PLUGIN_BACKUP_DATE", "日付");
@define("PLUGIN_BACKUP_OPTION", "オプション");
@define("PLUGIN_BACKUP_RECOVER_THIS", "このバックアップとデータベースを回復する...");
@define("PLUGIN_BACKUP_DELETE", "削除する");
@define("PLUGIN_BACKUP_NO_BACKUPS", "バックアップがありません");
@define("PLUGIN_BACKUP_WHOLE_BLOG", "s9y 全体");
@define("PLUGIN_BACKUP_SQL_BACKUP", "SQL バックアップ");
@define("PLUGIN_BACKUP_HTML_BACKUP", "HTML バックアップ");

?>