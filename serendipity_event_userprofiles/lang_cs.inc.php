<?php # lang_cs.inc.php 1.2 2009-02-15 21:33:23 VladaAjgl $

/**
 *  @version 1.2
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Czech translation to userprofiles plugin
 *  CS-Revision date: 1.3.2007
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 */

//
//  for serendipity_event_userprofiles.php
//
@define('PLUGIN_EVENT_USERPROFILES_DBVERSION',		'0.1');
@define('PLUGIN_EVENT_USERPROFILES_ILINK',		'<input class="direction_ltr" id="serendipity_event_userprofiles%s" type="radio" %s name="serendipity[profile%s]" value="%s" title="%s" />');
@define('PLUGIN_EVENT_USERPROFILES_LABEL',		'<label for="serendipity_event_userprofiles%s">%s</label>');

@define('PLUGIN_EVENT_USERPROFILES_CITY',		'Mìsto');
@define('PLUGIN_EVENT_USERPROFILES_COUNTRY',		'Zemì');
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
@define('PLUGIN_EVENT_USERPROFILES_SHOWCITY',		'Ukaž mìsto');
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
@define('PLUGIN_EVENT_USERPROFILES_TITLE',		'Profily uživatelù');
@define('PLUGIN_EVENT_USERPROFILES_DESC',		'Zobrazuje jednoduché profily uživatelù a dovoluje pøiložit jejich fotku.');
@define('PLUGIN_EVENT_USERPROFILES_SELECT',		'Vyber uživatele k editaci.');
@define('PLUGIN_EVENT_USERPROFILES_VCARD',		'Vytvoø vizitku');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_AT',		'Vizitka vytvoøena v %s');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_NOTE',		'Tuto vizitku naleznete v hnihovnì médií.');
@define('PLUGIN_EVENT_USERPROFILES_VCARDNOTCREATED',		'Nelze vytvoøit vizitku');

@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION',		'Pøípona souboru');
@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION_BLAHBLAH',		'Pøípona (typ - jpg, gif, ...) obrázkù autorù');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED',		'Zobrazit fotku uživatele v pøíspìvku?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED_DESC',		'Pokud je povoleno, fotka uživatele bude zobrazena u každého jeho pøíspìvku. Vizuálnì to ukazuje, kdo pøíspìvek napsal. Soubor s obrázkem musí být nejdøíve vložen do podadresáøe "img" vaší vybrané šablony (template) a musí být pojmenován stejnì jako je autorovo jméno. Všechny speciální znaky (uvozovky, mezery, ...) musí být ve jménì souboru nahrazeny znakem "_" (podtržítko).');

//
//  for serendipity_plugin_userprofiles.php
//
@define('PLUGIN_USERPROFILES_NAME',		'Serendipity Authors');
@define('PLUGIN_USERPROFILES_NAME_DESC',		'Zobrazuje rozšíøené profily autorù/uživatelù');
@define('PLUGIN_USERPROFILES_TITLE',		'Nadpis');
@define('PLUGIN_USERPROFILES_TITLE_DESC',		'Nadpis, který se bude zobrazovat v postranním panelu:');
@define('PLUGIN_USERPROFILES_TITLE_DEFAULT',		'Autoøi');

@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT',		'Zobrazit poèet komentáøù?');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_BLAHBLAH',		'Chcete zobrazit poèet komentáøù, které návštìvník napsal? Volba mùže být zakázána, nebo mùžete pøipojit pøed/za poèet komentáøù k tìlu komentáøe, anebo mùžete vložit poèet komentáøù kamkoliv se vám zlíbí, a to editací šablony comments.tpl. Text, který musíte vložit, je: {$comment.plugin_commentcount} . Mùžete upravit vzhled oblasti skrz css tøídu .serendipity_commentcount.');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_APPEND',		'Pøipojit za komentáø');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_PREPEND',		'Pøipojit pøed komentáø');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_SMARTY',		'Ruèní umístìní v šablonì');

@define('PLUGIN_USERPROFILES_GRAVATAR',		'Použij spíše Gravatar než místní obrázek?');
@define('PLUGIN_USERPROFILES_GRAVATAR_DESC',		'Použije Gravatar obrázek sdružený s vaší emailovou adresou.  Registrace na <a href="www.gravatar.com">www.gravatar.com</a>');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE',		'Velikost Gravatar obrázku');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE_DESC',		'Nastavuje velikost zobrazení obrázku Gravatar, ve ètvereèních pixelech. Max je 80.');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING',		'Maximální Gravatar hodnocení');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING_DESC',		'Nastavuje nejvyšší povolené hodnocení pro Gravatar.  G, PG, R nebo X.');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT',		'Umístìní defaultního Gravatar obrázku');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT_DESC',		'Upøesòuje umístìní obrázku k zobrazení, pokud uživatel nemá Gravatar.');

@define('PLUGIN_USERPROFILES_BIRTHDAYSNAME',		'Narozeniny uživatelù');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE',		'Narozeniny');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DESCRIPTION',		'Ukáže, kdy mají uživatelé narozeniny.');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DEFAULT',		'narozeniny');

@define('PLUGIN_USERPROFILES_BIRTHDAYIN',		'Narozeniny za %d dnù');
@define('PLUGIN_USERPROFILES_BIRTHDAYTODAY',		'Dnes slaví narozeniny.');

@define('PLUGIN_USERPROFILES_BIRTHDAYNUMBERS',		'Omez pøi zobrazení poèet lidí, kteøí mají narozeniny, na toto èíslo');
@define('PLUGIN_USERPROFILES_SHOWAUTHORS',		'Zobrazovat seznam uživatelù?');
@define('PLUGIN_USERPROFILES_SHOWGROUPS',		'Zobrazovat odkaz na podrobnosti o skupinách?');
