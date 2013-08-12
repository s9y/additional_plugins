<?php # 

/**
 *  @version 
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.3
 */

@define('PLUGIN_EVENT_RELATEDLINKS_TITLE', '関連エントリとリンク');
@define('PLUGIN_EVENT_RELATEDLINKS_DESC', 'エントリ毎に関連リンク・エントリを挿入します。For flexibility you can edit the "plugin_relatedlinks.tpl" Smarty-Template file to adjust the output. Note that this plugin only outputs data in the detailed/full entry view.');
@define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC', '表示したい関連リンクを入力します。ひとつの URL (HTML コードではありません!) を 1 行に書きます (意味: 改行で分ける)もし説明を入力したい場合、この書式を使用します: http://example.com/link.html=Example Link. 「=」の後はすべて説明に使用します。入力しなかった場合、リンクのみが題名として表示されるでしょう');
@define('PLUGIN_EVENT_RELATEDLINKS_LIST', '関連リンク:');

@define('PLUGIN_EVENT_RELATEDLINKS_POSITION', '関連エントリ・リンクの位置');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC', 'Smarty テンプレートを使うか、フッターへの関連リンクの一覧を追加しますか? Smarty テンプレートを有効にした場合、テンプレート「entries.tpl」内の $entry の foreach ループ内にこの行を挿入する必要があります (例えばコメント、トラックバックや拡張エントリの表示) : {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER', 'エントリフッターの場所');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY', 'エントリ本文の場所');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY', 'Smarty コールを使う');

@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR', 'リンクを分割する文字');
@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR_DESC', 'エントリの URL と説明を分割する文字を入力します。Be careful to choose one character that does neither exist in the URL nor the title, like "|".');

?>
