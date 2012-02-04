<?php # lang_cz.inc.php 1.1 2012-02-02 20:36:44 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/16
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/02/02
 */

@define('PLUGIN_EVENT_ENTRYCHECK_TITLE',		'Pravidla vydávání příspěvků');
@define('PLUGIN_EVENT_ENTRYCHECK_DESC',		'Provádí kontrolu příspěvku před jeho vydáním');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES',		'Povinné zařazení do kategorie');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_DESC',		'Pokud je nastaveno "Ano", musí být příspěvek zařazen alespoň do jedné kategorie.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_WARNING',		'Není povoleno vydat příspěvek, aniž by měl přiřazenou kategorii. Zařaďte ho prosím do některé z kategorií a znovu uložte!');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE',		'Zakázat prázdný nadpis');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_DESC',		'Pokud je nastaveno na "Ano", pak musí mít příspěvek nějaký, ne prázdný nadpis.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_WARNING',		'Není povoleno vydat příspěvek, který nemá nadpis. Zadejte prosím nadpis příspěvku a znovu uložte!');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT',		'Přednastavená kategorie');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT_DESC',		'Pokud autor nepřiřadí příspěvek do žádné kategorie, bude nastavena zde přednastavená kategorie.');

@define('PLUGIN_EVENT_ENTRYCHECK_LOCKED',		'Příspěvek byl zamčen pro úpravy uživatelem %s dne %s');
@define('PLUGIN_EVENT_ENTRYCHECK_UNLOCK',		'Odemknout příspěvek');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCK_WARNING',		'Tento příspěvek byl zamčen a může být uložen pouze vlastníkem zámku, pokud příspěvek ručně neodemknete.');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCKING',		'Povolit zamykání příspěvků?');

// Next lines were translated on 2012/02/02
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY',		'Zakázat prázdné tělo příspěvku');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_DESC',		'Pokud je nastaveno "ano", pak musí příspěvek mít něco napsáno v těle.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_WARNING',		'Není dovoleno publikovat příspěvky bez textu v těle. Přidejte prosím text do těla příspěvku a znovu ho uložte!');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED',		'Zakázat prázdnou rozšířenou textovou část');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_DESC',		'Pokud je nastaveno "ano", pak musí příspěvek mít něco napsáno v rozšířené textové části.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_WARNING',		'Není dovoleno publikovat příspěvky bez textu v rozšířené textové části. Přidejte prosím text do rozšířené textové části a znovu ho uložte!');