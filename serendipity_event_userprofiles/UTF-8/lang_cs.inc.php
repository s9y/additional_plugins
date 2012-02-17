<?php # lang_cs.inc.php 1.3 2009-02-23 17:24:30 VladaAjgl $

/**
 *  @version 1.3
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Czech translation to userprofiles plugin
 *  CS-Revision date: 1.3.2007
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/23
 */

//
//  for serendipity_event_userprofiles.php
//
@define('PLUGIN_EVENT_USERPROFILES_DBVERSION',		'0.1');
@define('PLUGIN_EVENT_USERPROFILES_ILINK',		'<input class="direction_ltr" id="serendipity_event_userprofiles%s" type="radio" %s name="serendipity[profile%s]" value="%s" title="%s" />');
@define('PLUGIN_EVENT_USERPROFILES_LABEL',		'<label for="serendipity_event_userprofiles%s">%s</label>');

@define('PLUGIN_EVENT_USERPROFILES_CITY',		'Město');
@define('PLUGIN_EVENT_USERPROFILES_COUNTRY',		'Země');
@define('PLUGIN_EVENT_USERPROFILES_URL',		'Web');
@define('PLUGIN_EVENT_USERPROFILES_OCCUPATION',		'Povolání');
@define('PLUGIN_EVENT_USERPROFILES_HOBBIES',		'Zájmy a záliby');
@define('PLUGIN_EVENT_USERPROFILES_YAHOO',		'Yahoo');
@define('PLUGIN_EVENT_USERPROFILES_AIM',		'AIM');
@define('PLUGIN_EVENT_USERPROFILES_JABBER',		'Jabber');
@define('PLUGIN_EVENT_USERPROFILES_ICQ',		'ICQ');
@define('PLUGIN_EVENT_USERPROFILES_MSN',		'MSN');
@define('PLUGIN_EVENT_USERPROFILES_SKYPE',		'Skype');
@define('PLUGIN_EVENT_USERPROFILES_STREET',		'Ulice');
@define('PLUGIN_EVENT_USERPROFILES_BIRTHDAY',		'Den narození');

@define('PLUGIN_EVENT_USERPROFILES_SHOWEMAIL',		'Ukaž e-maily');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCITY',		'Ukaž město');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCOUNTRY',		'Ukaž zemi');
@define('PLUGIN_EVENT_USERPROFILES_SHOWURL',		'Ukaž web');
@define('PLUGIN_EVENT_USERPROFILES_SHOWOCCUPATION',		'Ukaž povolání');
@define('PLUGIN_EVENT_USERPROFILES_SHOWHOBBIES',		'Ukaž záliby');
@define('PLUGIN_EVENT_USERPROFILES_SHOWYAHOO',		'Ukaž Yahoo');
@define('PLUGIN_EVENT_USERPROFILES_SHOWAIM',		'Ukaž AIM');
@define('PLUGIN_EVENT_USERPROFILES_SHOWJABBER',		'Ukaž Jabber');
@define('PLUGIN_EVENT_USERPROFILES_SHOWICQ',		'Ukaž ICQ');
@define('PLUGIN_EVENT_USERPROFILES_SHOWMSN',		'Ukaž MSN');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSKYPE',		'Ukaž Skype');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSTREET',		'Ukaž ulici');

@define('PLUGIN_EVENT_USERPROFILES_SHOW',		'Zobraz uživatelský profil vybraného autora:');
@define('PLUGIN_EVENT_USERPROFILES_TITLE',		'Profily uživatelů');
@define('PLUGIN_EVENT_USERPROFILES_DESC',		'Zobrazuje jednoduché profily uživatelů a dovoluje přiložit jejich fotku.');
@define('PLUGIN_EVENT_USERPROFILES_SELECT',		'Vyber uživatele k editaci.');
@define('PLUGIN_EVENT_USERPROFILES_VCARD',		'Vytvoř vizitku');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_AT',		'Vizitka vytvořena v %s');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_NOTE',		'Tuto vizitku naleznete v hnihovně médií.');
@define('PLUGIN_EVENT_USERPROFILES_VCARDNOTCREATED',		'Nelze vytvořit vizitku');

@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION',		'Přípona souboru');
@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION_BLAHBLAH',		'Přípona (typ - jpg, gif, ...) obrázků autorů');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED',		'Zobrazit fotku uživatele v příspěvku?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED_DESC',		'Pokud je povoleno, fotka uživatele bude zobrazena u každého jeho příspěvku. Vizuálně to ukazuje, kdo příspěvek napsal. Soubor s obrázkem musí být nejdříve vložen do podadresáře "img" vaší vybrané šablony (template) a musí být pojmenován stejně jako je autorovo jméno. Všechny speciální znaky (uvozovky, mezery, ...) musí být ve jméně souboru nahrazeny znakem "_" (podtržítko).');

//
//  for serendipity_plugin_userprofiles.php
//
@define('PLUGIN_USERPROFILES_NAME',		'Serendipity Authors');
@define('PLUGIN_USERPROFILES_NAME_DESC',		'Zobrazuje rozšířené profily autorů/uživatelů');
@define('PLUGIN_USERPROFILES_TITLE',		'Nadpis');
@define('PLUGIN_USERPROFILES_TITLE_DESC',		'Nadpis, který se bude zobrazovat v postranním panelu:');
@define('PLUGIN_USERPROFILES_TITLE_DEFAULT',		'Autoři');

@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT',		'Zobrazit počet komentářů?');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_BLAHBLAH',		'Chcete zobrazit počet komentářů, které návštěvník napsal? Volba může být zakázána, nebo můžete připojit před/za počet komentářů k tělu komentáře, anebo můžete vložit počet komentářů kamkoliv se vám zlíbí, a to editací šablony comments.tpl. Text, který musíte vložit, je: {$comment.plugin_commentcount} . Můžete upravit vzhled oblasti skrz css třídu .serendipity_commentcount.');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_APPEND',		'Připojit za komentář');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_PREPEND',		'Připojit před komentář');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_SMARTY',		'Ruční umístění v šabloně');

@define('PLUGIN_USERPROFILES_GRAVATAR',		'Použij spíše Gravatar než místní obrázek?');
@define('PLUGIN_USERPROFILES_GRAVATAR_DESC',		'Použije Gravatar obrázek sdružený s vaší emailovou adresou.  Registrace na <a href="www.gravatar.com">www.gravatar.com</a>');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE',		'Velikost Gravatar obrázku');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE_DESC',		'Nastavuje velikost zobrazení obrázku Gravatar, ve čtverečních pixelech. Max je 80.');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING',		'Maximální Gravatar hodnocení');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING_DESC',		'Nastavuje nejvyšší povolené hodnocení pro Gravatar.  G, PG, R nebo X.');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT',		'Umístění defaultního Gravatar obrázku');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT_DESC',		'Upřesňuje umístění obrázku k zobrazení, pokud uživatel nemá Gravatar.');

@define('PLUGIN_USERPROFILES_BIRTHDAYSNAME',		'Narozeniny uživatelů');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE',		'Narozeniny');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DESCRIPTION',		'Ukáže, kdy mají uživatelé narozeniny.');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DEFAULT',		'narozeniny');

@define('PLUGIN_USERPROFILES_BIRTHDAYIN',		'Narozeniny za %d dnů');
@define('PLUGIN_USERPROFILES_BIRTHDAYTODAY',		'Dnes slaví narozeniny.');

@define('PLUGIN_USERPROFILES_BIRTHDAYNUMBERS',		'Omez při zobrazení počet lidí, kteří mají narozeniny, na toto číslo');
@define('PLUGIN_USERPROFILES_SHOWAUTHORS',		'Zobrazovat seznam uživatelů?');
@define('PLUGIN_USERPROFILES_SHOWGROUPS',		'Zobrazovat odkaz na podrobnosti o skupinách?');
