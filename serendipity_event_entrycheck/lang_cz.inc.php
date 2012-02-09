<?php # lang_cz.inc.php 1.1 2012-02-02 20:36:44 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/16
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/02/02
 */

@define('PLUGIN_EVENT_ENTRYCHECK_TITLE',		'Pravidla vyd�v�n� p��sp�vk�');
@define('PLUGIN_EVENT_ENTRYCHECK_DESC',		'Prov�d� kontrolu p��sp�vku p�ed jeho vyd�n�m');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES',		'Povinn� za�azen� do kategorie');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_DESC',		'Pokud je nastaveno "Ano", mus� b�t p��sp�vek za�azen alespo� do jedn� kategorie.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_WARNING',		'Nen� povoleno vydat p��sp�vek, ani� by m�l p�i�azenou kategorii. Za�a�te ho pros�m do n�kter� z kategori� a znovu ulo�te!');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE',		'Zak�zat pr�zdn� nadpis');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_DESC',		'Pokud je nastaveno na "Ano", pak mus� m�t p��sp�vek n�jak�, ne pr�zdn� nadpis.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_WARNING',		'Nen� povoleno vydat p��sp�vek, kter� nem� nadpis. Zadejte pros�m nadpis p��sp�vku a znovu ulo�te!');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT',		'P�ednastaven� kategorie');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT_DESC',		'Pokud autor nep�i�ad� p��sp�vek do ��dn� kategorie, bude nastavena zde p�ednastaven� kategorie.');

@define('PLUGIN_EVENT_ENTRYCHECK_LOCKED',		'P��sp�vek byl zam�en pro �pravy u�ivatelem %s dne %s');
@define('PLUGIN_EVENT_ENTRYCHECK_UNLOCK',		'Odemknout p��sp�vek');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCK_WARNING',		'Tento p��sp�vek byl zam�en a m��e b�t ulo�en pouze vlastn�kem z�mku, pokud p��sp�vek ru�n� neodemknete.');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCKING',		'Povolit zamyk�n� p��sp�vk�?');

// Next lines were translated on 2012/02/02
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY',		'Zak�zat pr�zdn� t�lo p��sp�vku');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_DESC',		'Pokud je nastaveno "ano", pak mus� p��sp�vek m�t n�co naps�no v t�le.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_WARNING',		'Nen� dovoleno publikovat p��sp�vky bez textu v t�le. P�idejte pros�m text do t�la p��sp�vku a znovu ho ulo�te!');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED',		'Zak�zat pr�zdnou roz���enou textovou ��st');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_DESC',		'Pokud je nastaveno "ano", pak mus� p��sp�vek m�t n�co naps�no v roz���en� textov� ��sti.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_WARNING',		'Nen� dovoleno publikovat p��sp�vky bez textu v roz���en� textov� ��sti. P�idejte pros�m text do roz���en� textov� ��sti a znovu ho ulo�te!');