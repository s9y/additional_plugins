<?php # lang_cz.inc.php 1.1 2011-10-16 11:24:15 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/05
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/10/16
 */

@define('PLUGIN_GETID3', 'getID3() podpora pro získání vlastností média');
@define('PLUGIN_GETID3_DESC', 'Pou¾ívá knihovnu getID3() k získání doplòujících informací o audio/video souborech. getID3() samotná není distribuována s tímto pluginem.');
@define('PLUGIN_GETID3_INSTALL', 'Knihovna getID3() není z licenèních dùvodù distribuována s tímto pluginem, musíte si ji ruènì stáhnout z http://getid3.org/. Rozbalte soubory do adresáøe serendpity_event_getid3 nebo (a to je lep¹í volba) do adresáøe bundled-libs.');

@define('PLUGIN_GETID3_INSTALL_DESC', 
'<h3>Instalace</h3>' .
'<p>Knihovna getID3() sama o sobì není distribuována s tímto pluginem. Musíte ji ruènì stáhnout z ' .
'<a href="http://getid3.org/" target="_blank">getid3.org</a>. <b>Podporována je pouze verze knihovny 1.x!</b></p>' .
'<p>Ve sta¾eném archivu najdete podadresáø getid3. Zkopírujte prosím obsah tohoto adresáøe do adresáøe Serendipity "bundled-libs".</p>');

@define('PLUGIN_GETID3_LIBNOTFOUND',    'Knihovna getID3 nebyla nalezena ani v adresáøi bundled-libs, ani v adresáøi pluginu!'); 
@define('PLUGIN_GETID3_LIBFOUNDBUNDLED','Knihovna getID3 byla nalezena v adresáøi bundled-libs.'); 
@define('PLUGIN_GETID3_LIBFOUNDPLUGIN', 'Knihovna getID3 nalezena v adresáøi pluginu.');