<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/17
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/25
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/11/29
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/04/12
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/01/11
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/07/05
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/05/13
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/20
 */

//
//  serendipity_event_freetag.php
//

@define('PLUGIN_EVENT_FREETAG_TITLE',		'Kl��ov� slova');
@define('PLUGIN_EVENT_FREETAG_DESC',		'Umo��uje libovoln� p�id�v�n� kl��ov�ch slov k p��sp�vk�m');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC',		'Vlo�te libovoln� mno�stv� kl��ov�ch slov, kter� se k �l�nku vztahuj�. Odd�lujte ��rkou (,)');
@define('PLUGIN_EVENT_FREETAG_LIST',		'Kl��ov� slova tohoto p��sp�vku: %s');
@define('PLUGIN_EVENT_FREETAG_USING',		'P��sp�vky ozna�en� %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG',		'Kl��ov� slova p��buzn� ke slovu %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED',		'��dn� p��buzn� kl��ov� slova');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS',		'V�echna definovan� kl��ov� slova');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS',		'Spr�va kl��ov�ch slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL',		'Spr�va v�ech kl��ov�ch slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF',		'Spr�va \'koncov�ch\' kl��ov�ch slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED',		'Vypsat p��sp�vky bez kl��ov�ch slov');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED',		'Vypsat p��sp�vky s \'koncov�mi\' kl��ov�mi slovy');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE',		'��dn� p��sp�vky bez kl��ov�ch slov!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG',		'Kl��ov� slovo');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT',		'V�ha');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS',		'Akce');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME',		'P�ejmenuvat');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT',		'Rozd�lit');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE',		'Smazat');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE',		'Opravdu chcete smazat kl��ov� slovo %s?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT',		'pou�ijte ��rku pro odd�len� slov:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD',		'Zobrazit mno�inu p��buzn�ch kl��ov�ch slov?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER',		'Pos�lat HTTP hlavi�ku X-FreeTag');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST',		'Zobrazit seznam v�ech tag� p�i �prav�ch p��sp�vk�');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT',		'Aktivovat \'Hled�n�-tag�-b�hem-psan�\'');

//
//  serendipity_plugin_freetag.php
//

@define('PLUGIN_FREETAG_NAME',		'Zobrazit p��sp�vky s kl��ov�mi slovy');
@define('PLUGIN_FREETAG_BLAHBLAH',		'Zobraz� seznam existuj�c�ch kl��ov�ch slov');
@define('PLUGIN_FREETAG_NEWLINE',		'Nov� ��dka za ka�d�m kl��ov�m slovem?');
@define('PLUGIN_FREETAG_XML',		'Zobrazovat XML ikony?');
@define('PLUGIN_FREETAG_SCALE',		'M�nit velikost fontu kl��ov�ho slova podle jeho obl�benosti (jako je to na Technorati nebo Flickru)?');
@define('PLUGIN_FREETAG_UPGRADE1_2',		'Aktualizace %d kl��ov�ch slov pro p��sp�vek �.%d');
@define('PLUGIN_FREETAG_MAX_TAGS',		'Kolik kl��ov�ch slov zobrazovat?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT',		'Kolikr�t se mus� kl��ov� slovo vyskytnout, aby bylo zobrazeno?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN',		'Nejmen�� velikost fontu p�sma v % p�i zobrazen� mno�iny kl��ov�ch slov');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX',		'Nejv�t�� velikost fontu p�sma v % p�i zobrazen� mno�iny kl��ov�ch slov');

@define('PLUGIN_EVENT_FREETAG_USE_FLASH',		'Pou��vat Flash k zborazen� mno�iny kl��ov�ch slov?');
@define('PLUGIN_EVENT_FREETAG_FLASH_TAG_COLOR',		'Flash - barva slov (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_TRANSPARENT',		'Flash - pr�hledn� pozad�?');
@define('PLUGIN_EVENT_FREETAG_FLASH_BG_COLOR',		'Flash - barva pozad� (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_WIDTH',		'Flash - ���ka');
@define('PLUGIN_EVENT_FREETAG_FLASH_SPEED',		'Flash - rychlost pohybu mno�iny kl��ov�ch slov');

@define('PLUGIN_FREETAG_META_KEYWORDS',		'Po�et kl��ov�ch slov, kter� maj� b�t vlo�ena do "meta keywords" tagu v hlavi�ce zdrojov�ho HTML k�du (0: zak�zat generov�n� meta tagu)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES',		'P��buzn� p��p�vky podle kl��ov�ch slov:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED',		'Zobrazovat p��buzn� p��sp�vky podle kl��ov�ch slov?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT',		'Kolik p��buzn�ch p��sp�vk� m� b�t zobrazeno?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER',		'Zobrazovat kl��ov� slova v pati�ce?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC',		'Pokud je povoleno, kl��ov� slova se budou zobrazovat v pati�ce str�nky. Pokud je zak�z�no, kl��ov� slova budou vlo�ena do p��sp�vku.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS',		'Slova mal�mi p�smeny');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS',		'P��buzn� kl��ov� slova');
@define('PLUGIN_EVENT_FREETAG_TAGLINK',		'Odkaz na kl��ov� slovo');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG',		'Vytvo�it kl��ov� slova p�o v�echny p�i�azen� kategorie?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC',		'Pokud je povoleno, n�zvy v�ech kategori�, do kter�ch je p��sp�vek za�azen, budou p�id�ny jako kl��ov� slova. M��ete nastavit p�i�azen� n�zv� kategori� jako kl��ov�ch slov pro v�echny ji� existuj�c� p��sp�vky pomoc� menu "Spr�va kl��ov�ch slov" v Administrativn� sekci.');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE',		'�ablona postrann�ho sloupce');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION',		'Pokud je nastaveno, je �ablona pou�ita k vykreslen� postrann�ho sloupce s kl��ov�mi slovy. V �ablon� je p��stupn� prom�nn� <tags>, ta obsahuje seznam tag� ve form�tu <tagName> => array(href => <tagLink>, count => <tagCount>)');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS',		'P�ev�st p�i�azen� kategorie v�ech p��sp�vk� na kl��ov� slova');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY',		'Byly p�evedeny kategorie p��sp�vku �.%d (%s): %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG',		'Ze jmen v�ech kategori� byla vytvo�ena kl��ov� slova.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS',		'Automatick� kl��ov� slova');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC',		'Zde m��ete p�i�adit ke ka�d�mu kl��ov�u slovu libovoln� mno�stv� obecn�ch slov (odd�lujte ��rkou ","). Kdykoliv se tato obecn� slova vyskytnou v p��sp�vku, jim odpov�daj�c� kl��ov� slovo bude automaticky p�i�azeno k p��sp�vku. M�jte na pam�ti, �e mnoho automatick�ch slov m��e v�znamn� zv��it �as ukl�d�n� p��sp�vku.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD',		'Nalezeno slovo <strong>%s</strong>, kl��ov� slovo <strong><em>%s</em></strong> bylo automaticky p�i�azeno.<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO',		'Zobrazen� p��sp�vk� %d a� %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL',		' (celkem %d p��sp�vk�)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT',		'Zobrazov�n� dal�� d�vky p��sp�vk�...');
@define('PLUGIN_EVENT_FREETAG_REBUILD',		'Znovup�i�azen� v�ech automatick�ch slov');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC',		'VAROV�N�: Tato funkce p�i�ad� a znovu ulo�� ka�d� z p��sp�vk�. Bude to dlouho trvat a dokonce to m��e poni�it n�kter� z p��sp�vk�. V�ele se doporu�uje nejd��ve z�lohovat datab�zi! Klikn�te na "Zru�it" pro p�eru�en� akce.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME',		'Kl��ov� slovo');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT',		'Po�et kl��ov�ch slov');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE',		'XML obr�zek - cesta relativn� k um�st�n� �ablon');

@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2',		'Pokud nastaveno na "Smarty", pak bude ve smarty vytvo�ena prom�nn� ($entry.freetag), kterou m��ete um�stit kamkoliv do �ablonov�ho souboru entries.tpl.');

// Next lines were translated on 2009/11/29

@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY',		'Roz���en� Smarty');
@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY_DESC',		'Generovat odd�len� prom�nn� Smarty pro pozd�j�� pou�it� v �ablon�ch. Toto nastaven� je nad�azen� jin�m nastaven�m. P��klad pou�it� naleznete v Readme.');

// Next lines were translated on 2010/04/12

@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG',		'Vytv��et tagy z automatick�ch kl��ov�ch slov?');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG_DESC',		'Pokud je povoleno, pak bude p��sp�vek prov��en na p��tomnost automatick�ch kl��ov�ch slov a budou mu n�sledn� p�id�ny odpov�daj�c� automatick� tagy. Tato slova m��ete zadat pod polo�kou menu "Spr�va kl��ov�ch slov" v administra�n� sekci.');

// Next lines were translated on 2011/01/11

@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP',		'Vy�istit namapov�n� tag� k p��sp�vk�m');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_INFO',		'N�sleduj�c� seznam obsahuje tagy, kter� jsou p�i�azeny k neexistuj�c�m p��sp�vk�m. Klikn�te na &quot;Vy�istit&quot; pro odstran�n� t�chto nadbyte�n�ch p�i�azen�.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_NOTHING',		'Nebyly nalezeny ��dn� tagy, kter� by byly p�i�azeny k neexistuj�c�m p��sp�vk�m. Nen� tedy co �istit.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_LOOKUP_ERROR',		'Tagy p�i�azeny k neexistuj�c�cm p��sp�vk�m nemohly b�t nalezeny, proto�e do�lo k chyb�.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_PERFORM',		'Vy�istit');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_ENTRIES',		'ID ��sla ovlivn�n�ch p��sp�vk�');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_SUCCESSFUL',		'V�echna p�ebyte�n� p�i�azen� byla �sp�n� odstran�na.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_FAILED',		'Odstra�ov�n� p�ebyte�n�ch p�i�azen� se nezda�ilo.');

// Next lines were translated on 2011/07/05

@define('PLUGIN_EVENT_FREETAG_COLLATION',		'Porovn�n� (MySQL) datab�ze pro sloupec entrytags.tag (automatick�-detekce)');

// Next lines were translated on 2012/05/13

@define('PLUGIN_EVENT_FREETAG_KILL',		'Pokud je za�krtnuto, budou smaz�ny v�echny tagy p�i�azen� k tomuto p��sp�vku.');