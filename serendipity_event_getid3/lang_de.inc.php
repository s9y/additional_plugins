<?php # lang_de.inc.php 1.0 2009-08-20 10:10:25 VladaAjgl $

/**
 *  @version 1.0
 *  DE-Revision: Revision of lang_de.inc.php
 *  @author Konrad Bauckmeier <kontakt@dd4kids.de>
 *  @translated 2009/08/20
 */

@define('PLUGIN_GETID3',                'getID3() Unterstützung zum Erkennen von Medien Eigenschaften');
@define('PLUGIN_GETID3_DESC',           'Benutzt die getID3() Bibliothek um erweiterte Medien Eigenschaften für Filme und Audios zu erkennen. getID3() selbst wird nicht mit dem Plugin ausgeliefert.');

@define('PLUGIN_GETID3_INSTALL_DESC', 
'<h3>Installationsanweisung</h3>' .
'<p>Die Bibliothek getID3() wird nicht zusamen mit dem Plugin ausgeliefert. Sie müssen die getid3 Dateien selbst von ' .
'<a href="http://getid3.org/" target="_blank">getid3.org</a> herunter laden. <b>Es wird nur die 1.x Version unterstützt!</b></p>' .
'<p>In dem Archiv finden Sie ein Unterverzeichnis mit Namen getid3, dieses müssen Sie in das Serenddipity Verzeichnis "bundled-libs" entpacken.</p>');

@define('PLUGIN_GETID3_LIBNOTFOUND',    'GetID3 wurde weder im bundled-lib noch im Plugin Verzeichnis gefunden!'); 
@define('PLUGIN_GETID3_LIBFOUNDBUNDLED','GetID3 wurde unter den bundled-libs gefunden'); 
@define('PLUGIN_GETID3_LIBFOUNDPLUGIN', 'GetID3 wurde innerhalb des Pluginverzeichnisses gefunden.');

// Next lines were translated on 2009/08/20
@define('PLUGIN_GETID3_INSTALL',         'getID3() wird nicht mit diesem Plugin mitgeliefert. Bitte laden Sie es manuell von http://getid3.org/ und entpacken sie die Dateien in das serendipity_event_getid3 Verzeichnis oder in das bundled-libs Verzeichnis (bevorzugt).');