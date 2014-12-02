<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/16
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/02/02
 */

@define('PLUGIN_EVENT_ENTRYCHECK_TITLE',		'Pravidla vydávání pøíspìvkù');
@define('PLUGIN_EVENT_ENTRYCHECK_DESC',		'Provádí kontrolu pøíspìvku pøed jeho vydáním. Does not work with WYSIWYG-CKEDITOR!');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES',		'Povinné zaøazení do kategorie');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_DESC',		'Pokud je nastaveno "Ano", musí být pøíspìvek zaøazen alespoò do jedné kategorie.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_WARNING',		'Není povoleno vydat pøíspìvek, aniž by mìl pøiøazenou kategorii. Zaøaïte ho prosím do nìkteré z kategorií a znovu uložte!');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE',		'Zakázat prázdný nadpis');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_DESC',		'Pokud je nastaveno na "Ano", pak musí mít pøíspìvek nìjaký, ne prázdný nadpis.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_WARNING',		'Není povoleno vydat pøíspìvek, který nemá nadpis. Zadejte prosím nadpis pøíspìvku a znovu uložte!');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT',		'Pøednastavená kategorie');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT_DESC',		'Pokud autor nepøiøadí pøíspìvek do žádné kategorie, bude nastavena zde pøednastavená kategorie.');

@define('PLUGIN_EVENT_ENTRYCHECK_LOCKED',		'Pøíspìvek byl zamèen pro úpravy uživatelem %s dne %s');
@define('PLUGIN_EVENT_ENTRYCHECK_UNLOCK',		'Odemknout pøíspìvek');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCK_WARNING',		'Tento pøíspìvek byl zamèen a mùže být uložen pouze vlastníkem zámku, pokud pøíspìvek ruènì neodemknete.');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCKING',		'Povolit zamykání pøíspìvkù?');

// Next lines were translated on 2012/02/02
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY',		'Zakázat prázdné tìlo pøíspìvku');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_DESC',		'Pokud je nastaveno "ano", pak musí pøíspìvek mít nìco napsáno v tìle.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_WARNING',		'Není dovoleno publikovat pøíspìvky bez textu v tìle. Pøidejte prosím text do tìla pøíspìvku a znovu ho uložte!');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED',		'Zakázat prázdnou rozšíøenou textovou èást');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_DESC',		'Pokud je nastaveno "ano", pak musí pøíspìvek mít nìco napsáno v rozšíøené textové èásti.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_WARNING',		'Není dovoleno publikovat pøíspìvky bez textu v rozšíøené textové èásti. Pøidejte prosím text do rozšíøené textové èásti a znovu ho uložte!');