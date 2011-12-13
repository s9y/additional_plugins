<?php # lang_cs.inc.php 1.1 2009-08-26 20:52:12 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/26
 */

@define('PLUGIN_EVENT_UNSTRIP_NAME',		'Transformace HTML v komentářích');
@define('PLUGIN_EVENT_UNSTRIP_DESC',		'Umožňuje vkládat HTML tagy do komentářů k příspěvkům (místo jejich odstranění, bez tohoto modulu jsou převáděny na HTML entity). Musí být první ze všech značkovacích (markup) pluginů v seznamu pluginů událostí!');
@define('PLUGIN_EVENT_UNSTRIP_TRANSFORM',		'HTML tagy budou převedeny na entity.');