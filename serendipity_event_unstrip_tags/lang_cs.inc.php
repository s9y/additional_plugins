<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/26
 */

@define('PLUGIN_EVENT_UNSTRIP_NAME',		'Transformace HTML v komentáøích');
@define('PLUGIN_EVENT_UNSTRIP_DESC',		'Umožòuje vkládat HTML tagy do komentáøù k pøíspìvkùm (místo jejich odstranìní, bez tohoto modulu jsou pøevádìny na HTML entity). Musí být první ze všech znaèkovacích (markup) pluginù v seznamu pluginù událostí!');
@define('PLUGIN_EVENT_UNSTRIP_TRANSFORM',		'HTML tagy budou pøevedeny na entity.');