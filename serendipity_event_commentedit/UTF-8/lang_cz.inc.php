<?php # lang_cz.inc.php 1.1 2013-04-14 12:46:26 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/08
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/14
 */

@define('PLUGIN_EVENT_COMMENTEDIT_NAME',     'Editace komentářů');
@define('PLUGIN_EVENT_COMMENTEDIT_DESC',     'Povoluje uživatelům měnit vlastní komentáře i poté, co již byly odeslány.');
@define('PLUGIN_EVENT_COMMENTEDIT_PATH',     'Cesta k pluginu');
@define('PLUGIN_EVENT_COMMENTEDIT_PATH_DESC','Pokud je zde zadána cesta, není určována dynamicky, což zvyšuje výkon blogu. Příklad: http://www.mujblog.cz/plugins/serendipity_event_commentedit/ (na konci musí být lomítko!).');
@define('PLUGIN_EVENT_COMMENTEDIT_TIMEOUT',  'Čas úpravy');
@define('PLUGIN_EVENT_COMMENTEDIT_TIMEOUT_DESC', 'Jak dlouhý má být čas k editaci komentáře? (v sekundách)');
@define('PLUGIN_EVENT_COMMENTEDIT_EDITTOOLTIP',  'Klikněte pro editace');
@define('PLUGIN_EVENT_COMMENTEDIT_EDITTIMER',  'Čas zbývající k dokončení úprav');
@define('PLUGIN_EVENT_COMMENTEDIT_MAIL',     'Mailové oznámení');
@define('PLUGIN_EVENT_COMMENTEDIT_MAIL_DESC','Posílat oznámení mailem po editaci komentáře?');