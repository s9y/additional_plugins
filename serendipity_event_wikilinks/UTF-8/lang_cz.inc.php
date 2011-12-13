<?php # lang_cz.inc.php 1.0 2009-06-26 18:42:14 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 */

@define('PLUGIN_EVENT_WIKILINKS_NAME', 'Wiki odkazy v příspěvcích');
@define('PLUGIN_EVENT_WIKILINKS_DESC', 'V příspěvcích můžete zadat odkazy na existující/nové příspěvky pomocí [[nadpis příspěvku]], na statické stránky pomocí ((nadpis stránky)) a na obojí pomocí {{nadpis}}.');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH', 'Cesta k obrázkům');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH_DESC', 'Zadejte cestu, na které jsou umístěny ikony wiki odkazů.');

@define('PLUGIN_EVENT_WIKILINKS_EDIT_INTERNAL', 'Upravit příspěvek');
@define('PLUGIN_EVENT_WIKILINKS_EDIT_STATICPAGE', 'Upravit statickou stránku');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_INTERNAL', 'Vytvořit příspěvek');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_STATICPAGE', 'Vytvořit statickou stránku');

@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY', 'Odkaz na příspěvek');
@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY_DESC', 'Vyberte příspěvek, na který chcete odkazovat.');

@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_NAME', 'Vytvořit odkazy na koncepty?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_DESC', 'Mají se tvořit odkazy na příspěvky, které jsou ve stavu "koncept"?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_NAME', 'Vytvářet odkazy na budoucí příspěvky?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_DESK', 'Mají se vytvářet odkazy na příspěvky, jejichž datum vydání je v budoucnosti?');