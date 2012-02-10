<?php # lang_cz.inc.php 1.1 2012-02-02 20:36:44 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/16
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/02/02
 */

@define('PLUGIN_EVENT_ENTRYCHECK_TITLE',		'Pravidla vydávání pøíspìvkù');
@define('PLUGIN_EVENT_ENTRYCHECK_DESC',		'Provádí kontrolu pøíspìvku pøed jeho vydáním');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES',		'Povinné zaøazení do kategorie');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_DESC',		'Pokud je nastaveno "Ano", musí být pøíspìvek zaøazen alespoò do jedné kategorie.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_WARNING',		'Není povoleno vydat pøíspìvek, ani¾ by mìl pøiøazenou kategorii. Zaøaïte ho prosím do nìkteré z kategorií a znovu ulo¾te!');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE',		'Zakázat prázdný nadpis');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_DESC',		'Pokud je nastaveno na "Ano", pak musí mít pøíspìvek nìjaký, ne prázdný nadpis.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_WARNING',		'Není povoleno vydat pøíspìvek, který nemá nadpis. Zadejte prosím nadpis pøíspìvku a znovu ulo¾te!');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT',		'Pøednastavená kategorie');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT_DESC',		'Pokud autor nepøiøadí pøíspìvek do ¾ádné kategorie, bude nastavena zde pøednastavená kategorie.');

@define('PLUGIN_EVENT_ENTRYCHECK_LOCKED',		'Pøíspìvek byl zamèen pro úpravy u¾ivatelem %s dne %s');
@define('PLUGIN_EVENT_ENTRYCHECK_UNLOCK',		'Odemknout pøíspìvek');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCK_WARNING',		'Tento pøíspìvek byl zamèen a mù¾e být ulo¾en pouze vlastníkem zámku, pokud pøíspìvek ruènì neodemknete.');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCKING',		'Povolit zamykání pøíspìvkù?');

// Next lines were translated on 2012/02/02
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY',		'Zakázat prázdné tìlo pøíspìvku');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_DESC',		'Pokud je nastaveno "ano", pak musí pøíspìvek mít nìco napsáno v tìle.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_WARNING',		'Není dovoleno publikovat pøíspìvky bez textu v tìle. Pøidejte prosím text do tìla pøíspìvku a znovu ho ulo¾te!');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED',		'Zakázat prázdnou roz¹íøenou textovou èást');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_DESC',		'Pokud je nastaveno "ano", pak musí pøíspìvek mít nìco napsáno v roz¹íøené textové èásti.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_WARNING',		'Není dovoleno publikovat pøíspìvky bez textu v roz¹íøené textové èásti. Pøidejte prosím text do roz¹íøené textové èásti a znovu ho ulo¾te!');