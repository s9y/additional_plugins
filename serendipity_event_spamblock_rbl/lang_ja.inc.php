<?php # $Id: lang_ja.inc.php,v 1.2 2005/11/16 13:11:43 elf2000 Exp $

/**
 *  @version $Revision: 1.2 $
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.2
 */

@define('PLUGIN_EVENT_SPAMBLOCK_RBL_TITLE', 'スパムプロテクター (RBL)');
@define('PLUGIN_EVENT_SPAMBLOCK_RBL_DESC', 'URL に記録されたホストが作成したコメントを拒否します。これはプロキシユーザーやダイアルアップユーザーに影響することに注意してください。');
@define('PLUGIN_EVENT_SPAMBLOCK_ERROR_RBL', 'スパム保護: あなたの IP アドレスはオープンリレーとして記録されています。ISP に連絡してください!');
@define('PLUGIN_EVENT_SPAMBLOCK_RBLLIST', 'どの RBL を紹介するべきか');
@define('PLUGIN_EVENT_SPAMBLOCK_RBLLIST_DESC', '提供された RBL 一覧に基づいたコメントブロックを行います。動的ホストの記録は無効です。');
@define('PLUGIN_EVENT_SPAMBLOCK_REASON_RBL', 'RBL ブロック');

?>
