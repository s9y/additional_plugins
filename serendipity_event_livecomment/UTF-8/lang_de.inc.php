<?php # 

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  DE-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_EVENT_LIVECOMMENT_NAME', 'Erweiterter Kommentarbereich');
@define('PLUGIN_EVENT_LIVECOMMENT_DESC', 'Eine Livevorschau und Formatierungsbuttons erweitern den Kommentarbereich mittels JavaScript.');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT', 'Welche Darstellungsmethode?');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_DESC', 'Die jQuery-Mathode nutzt nur JavaScript um die Kommentare darzustellen, direkt über dem Kommentareingabefeld. Sie ist schnell und macht ihre Aufgabe in den meisten Fällen gut, aber unterstützt nur ein begrenztes Set von Textformatierungen (BBCode, Textile, s9y, nl2br, markdown). 
Die alte legacy-Methode nutzt echtes AJAX um die Kommentare exakt so zu formatieren, wie sie später angezeigt werden (also auch Wiki, Emoticons, etc) und platziert die Vorschau auch am späteren Bestimmungsort, aber ruckelt mehr.
BEACHTE: Das Template muss die üblichen CSS IDs und Klassen unterstützen, damit das Plugin richtig funktionieren kann.(#serendipity_replyform_*, #serendipity_commentForm etc. von commentform.tpl).');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_JQUERY', 'jQuery (feste Position, schneller und angenehmer)');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_LEGACY', 'Alte legacy-Methode (angepasste Position, volle Formatierungsunterstützung)');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_NONE', 'Keine (deaktiviert die Vorschau)');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_TITLE', 'Live-Vorschau');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON', 'Textformatierungsbuttons');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_DESC', 'Zeige über der Kommentareingabe Buttons zum einfachen Formatieren des Textes an.');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION', 'Vorschau-Animation');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_DESC', 'Mit welcher Animationsart soll der Vorschaubereich eingeblendet werden? "show" bedeutet, dass er einfach so eingeblendet werden soll.');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_SPEED', 'Animationsgeschwindigkeit des Vorschaubereichs');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_SPEED_DESC', 'Möglich sind die Schlüsselwörter "fast", "def" oder "slow" sowie die numerische Angabe (in ms).');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION', 'Animation der Textformattierungsbuttons');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_DESC', 'Mit welcher Animationsart sollen die Textformattierungsbuttons eingeblendet werden? "show" bedeutet, dass einfach so eingeblendet werden soll.');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_SPEED', 'Animationsgeschwindigkeit der Textformatierungsbuttons');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_SPEED_DESC', 'Möglich sind die Schlüsselwörter "fast", "def" oder "slow" sowie die numerische Angabe (in ms).');
@define('PLUGIN_EVENT_LIVECOMMENT_TIMEOUT', 'Ajax Wartezeit');
@define('PLUGIN_EVENT_LIVECOMMENT_TIMEOUT_DESC', 'Nach dieser Wartezeit muss der Ajax-Aufruf beendet sein, damit die Buttons eingeblendet werden können. Wenn es keine Probleme gibt kann dies leer bleiben.');
@define('PLUGIN_EVENT_LIVECOMMENT_ELASTIC', 'Elastische Kommentareingabe');
@define('PLUGIN_EVENT_LIVECOMMENT_ELASTIC_DESC', 'Vergrößert das kommentareingabefeld falls nötig.');
@define('PLUGIN_EVENT_LIVECOMMENT_BOLD', 'fett');
@define('PLUGIN_EVENT_LIVECOMMENT_ITALIC', 'kursiv');
@define('PLUGIN_EVENT_LIVECOMMENT_UNDERLINE', 'unterstrichen');
@define('PLUGIN_EVENT_LIVECOMMENT_URL', 'Link');
@define('PLUGIN_EVENT_LIVECOMMENT_INLINE', 'Eingebettete Parameter');
@define('PLUGIN_EVENT_LIVECOMMENT_INLINE_DESC', 'Fügt die JavaScript-Parameter direkt in den HTML-Code hinzu und deaktiviert den Ajax-Aufruf. Diese Option sollte den Server entlasten.');
@define('PLUGIN_EVENT_LIVECOMMENT_PATH', 'Plugin-Pfad');
@define('PLUGIN_EVENT_LIVECOMMENT_PATH_DESC', 'Wird hier der Pluginpfad angegeben wird dieser nicht mehr dynamisch ermittelt, was einen deutlichen Leistungsgewinn einbringt. Beispiel: http://www.example.com/plugins/serendipity_event_livecomment/ (das / am Ende ist wichtig).');
