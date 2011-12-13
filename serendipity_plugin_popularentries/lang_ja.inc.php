<?php # $Id: lang_ja.inc.php,v 1.5 2006/08/15 04:41:45 elf2000 Exp $

/**
 *  @version $Revision: 1.5 $
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.3
 */ 

@define('PLUGIN_POPULARENTRIES_TITLE', '人気のエントリ');
@define('PLUGIN_POPULARENTRIES_BLAHBLAH', '多くコメントされたエントリによって計算された最も人気のあるエントリのコメントの題名と数を表示します。');
@define('PLUGIN_POPULARENTRIES_NUMBER', 'エントリの数');
@define('PLUGIN_POPULARENTRIES_NUMBER_BLAHBLAH', 'どれくらいのエントリを表示しますか? (デフォルト: 10)');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM', 'フロントページエントリで省略する');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_DESC', 'フロントページにない最近のエントリだけが表示されるでしょう (デフォルト: 最後の ' . $serendipity['fetchLimit'] . ' 個が飛ばされるでしょう)');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_ALL', 'すべて表示');
@define('PLUGIN_POPULARENTRIES_NUMBER_FROM_RADIO_POPULAR', 'フロントページ項目は省略する');
@define('PLUGIN_POPULARENTRIES_SORTBY', 'エントリのソート基準:');
@define('PLUGIN_POPULARENTRIES_SORTBY_COMMENTS', 'コメント数');
@define('PLUGIN_POPULARENTRIES_SORTBY_KARMAVOTES', 'カルマ [カルマプラグインが必要です]');
@define('PLUGIN_POPULARENTRIES_SORTBY_EXITS', 'トップ退出 [退出追跡プラグインが必要です]');

?>
