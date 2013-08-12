<?php

/**
 *  @version 
 *  @author Matthias Mees <matthiasmees@googlemail.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_METADESC_NAME', 'HTML Meta-Tags');
@define('PLUGIN_METADESC_DESC', 'Setzt Tags für HTML Meta-Schlüsselwörter/-Beschreibungen und das title-Element für Seiten mit nur einem einzelnen Eintrag bzw. allgemeine Meta-Schlüsselwörter/-Beschreibungen für Seite mit mehr als einem Eintrag.');
@define('PLUGIN_METADESC_FORM', 'Bleibt dieses Feld leer, so werden die ersten 120 Zeichen des Eintrages
als Meta-Beschreibung verwendet. Kann auf Basis der Liste von HTML-Tags für die Schlüsselwörter keine Schlüsselwortphrase generiert werden, so
werden die standardmäßigen Meta-Schlüsselwörter für Seiten mit nicht nur einem Eintrag verwendet.<br /><br />Vorschlag für die Meta-Beschreibung<sup>*</sup>: 20-30 Wörter, maximal 120-180 Zeichen inklusive Leerzeichen.<br />Vorschlag für die Meta-Schlüsselwörter<sup>*</sup>: 15-20 Wörter, vor allem Schlüsselbegriffe und -phrasen aus dem Inhalt des Eintrags.');
@define('PLUGIN_METADESC_DESCRIPTION', 'Meta-Beschreibung:');
@define('PLUGIN_METADESC_KEYWORDS', 'Meta-Schlüsselwörter:');
@define('PLUGIN_METADESC_HEADTITLE_DESC', 'Das title-Element einer HTML-Seite kann über das unten stehende Feld eingestellt werden. Bleibt dieses Feld leer, wird das title-Element über das Template bestimmt, üblicherweise ist es dann "Titel des Eintrags - Blog-Titel".  <br /><br />Vorschlag<sup>*</sup>: 3-9 Wörter, maximal 64 Zeichen inklusive Leerzeichen, die wichtigsten Wörter zuerst..');
@define('PLUGIN_METADESC_HEADTITLE', 'title-Element der HTML-Seite');
@define('PLUGIN_METADESC_LENGTH', 'Länge');
@define('PLUGIN_METADESC_WORDS', 'Wörter');
@define('PLUGIN_METADESC_CHARACTERS', 'Zeichen');
@define('PLUGIN_METADESC_STRINGLENGTH_DISCLAIMER', 'Die Vorschläge für Wörter- und Zeichenzahl sind geschätzte Richtlinien, nicht tatsächliche Einschränkungen.');
@define('PLUGIN_METADESC_TAGNAMES', 'HTML-Tags für Schlüsselwörter');
@define('PLUGIN_METADESC_TAGNAMES_DESC', 'Hier eine durch Kommata getrennte Liste von HTML-Tags eingeben, die durchsucht werden sollen. Üblicherweise enthalten diese die Schlüsselwörter.');
@define('PLUGIN_METADESC_DEFAULT_DESCRIPTION', 'Standard-HTML-Meta-Beschreibung');
@define('PLUGIN_METADESC_DEFAULT_DESCRIPTION_DESC', 'Hier die standardmäßig auf Seiten mit nicht nur einem Eintrag verwendete META-Beschreibung eingeben.');
@define('PLUGIN_METADESC_DEFAULT_KEYWORDS', 'Standard-HTML-Meta-Schlüsselwörter');
@define('PLUGIN_METADESC_DEFAULT_KEYWORDS_DESC', 'Hier eine durch Kommata getrennte Liste der Schlüsselwörter eingeben, die auf Seitem mit nicht nur einem Eintrag verwendet werden sollen.');
@define('PLUGIN_METADESC_ESCAPE', 'HTML-Sonderzeichen escapen');
@define('PLUGIN_METADESC_ESCAPE_DESC', 'In Meta-Beschreibung oder -Schlüsselwörtern enthaltene HTML-Sonderzeichen mittels htmlspecialchars() durch deren entsprechende HTML-Entities ersetzen.');
