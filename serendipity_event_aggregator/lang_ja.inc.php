<?php # 

/**
 *  @version $Revision$
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.7
 */

@define('PLUGIN_AGGREGATOR_TITLE', 'RSS アグリゲータ');
@define('PLUGIN_AGGREGATOR_DESC', 'Display entries from multiple RSS feeds ("Planet"). IMPORTANT NOTE: Updating and "feeding" your Aggregator must currently still happen manually via Cronjobs or similar. Call this URL with your custom timing interval: ' . $serendipity['baseURL'] . 'index.php?/plugin/aggregator');
@define('PLUGIN_AGGREGATOR_DESC', '複数の RSS フィード(Planet)からエントリを表示します。重要な注意: アグリゲータの「フィード」と更新は Cronjob、あるいはそれに似たものによって手動で起動しなければなりません。この URL をカスタムのタイミング間隔で呼びます: ' . $serendipity['baseURL'] . 'index.php?/plugin/aggregator');
@define('PLUGIN_AGGREGATOR_FEEDNAME', 'フィード名');
@define('PLUGIN_AGGREGATOR_FEEDNAME_DESC', 'このフィードの名前です。');
@define('PLUGIN_AGGREGATOR_FEEDURI', 'フィード URI');
@define('PLUGIN_AGGREGATOR_FEEDURI_DESC', 'フィードのアドレスです。');
@define('PLUGIN_AGGREGATOR_HTMLURI', 'ホームページ URI');
@define('PLUGIN_AGGREGATOR_HTMLURI_DESC', 'フィードの HTML アドレスです。');
@define('PLUGIN_AGGREGATOR_CATEGORIES','カテゴリ');

@define('PLUGIN_AGGREGATOR_FEEDLIST', 'これは利用可能なフィードの一覧です。フィードを手動でひとつの入力し、そして「GO」ボタンを押す、あるいは全体の OPML ファイルをインポートすることができます。フィードは、空のフィード名あるいは空のフィードURLの設定により削除することができます。新しいフィードは、テーブルの最後の列に挿入することができます。');
@define('PLUGIN_AGGREGATOR_FEEDUPDATE', '最終更新');
@define('PLUGIN_AGGREGATOR_FEED_MISSINGDATA', 'フィード名と URL を指定しなければなりません。');
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST', 'OPML フィード一覧をエクスポートする');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST', 'OPML フィード一覧をインポートする');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_DESC', 'フィード一覧をインポート OPML への URL を入力します(既存の購読フィードは、インポートされた購読によって取り消され、上書きされるでしょう!)オプション「カテゴリをインポートする」をチェックしていた場合、OPML からウェブログまでカテゴリー構造をインポート処理するでしょう。');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_BUTTON', 'OPML をインポートする!');
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST_BUTTON', 'OPML をエクスポートする!');
@define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES', 'カテゴリをインポートする');
@define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES2', '自分自身のカテゴリに書くフィードを置く');
@define('PLUGIN_AGGREGATOR_CATEGORYSKIPPED', '既に存在するのでカテゴリ「%s」の作成を飛ばします。');

@define('PLUGIN_AGGREGATOR_EXPIRE', '期限切れの内容');
@define('PLUGIN_AGGREGATOR_EXPIRE_BLAHBLAH', '内容は n 日の後にデータベースで期限切れになるするでしょう (0 = 期限切れなし)');
@define('PLUGIN_AGGREGATOR_EXPIRE_MD5', '期限切れのチェックサム');
@define('PLUGIN_AGGREGATOR_EXPIRE_MD5_BLAHBLAH', 'チェックサムは、日付のない記事に対しての複製を確認するために使用されます。チェックサムは何日後に期限切れになりますか? (90 = 推奨, 0 = しない).');
@define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES', '依存するエントリを削除しますか?');
@define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES_DESC', '入力が登録を取り消され、このオプションが有効な場合、この入力への関連するエントリーがすべて削除されます。');
@define('PLUGIN_AGGREGATOR_DEBUG', 'デバグ出力');
@define('PLUGIN_AGGREGATOR_DEBUG_BLAHBLAH', 'ログにデバグ出力を有効にしますか?');
@define('PLUGIN_AGGREGATOR_IGNORE_UPDATES', '更新を無視しますか?');
@define('PLUGIN_AGGREGATOR_IGNORE_UPDATES_DESC', '記事テキストが後ほど変更されても更新を無視しますか?');

@define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE', 'RSS パーサーを選択する');
@define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE_DESC', 'Onyx は BSD ライセンスですが、ATOM フィードをサポートしていません。MagpieRSS は GPL ライセンスですが、 ATOM フィードとより多くの機能をサポートしています。SimplePie はモダンでメンテナンスもされており、BSD ライセンスです。');

@define('PLUGIN_AGGREGATOR_PUBLISH', 'Save aggregated entries as...');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE', 'アグリゲートしたエントリーのマークアップ プラグオンを無効にする');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE_DESC', 'グリゲートされたエントリーに適用したくないマークアップ プラグインをハイライトにします。');

@define('PLUGIN_AGGREGATOR_FEEDICON', 'フィード アイコンの URL');
