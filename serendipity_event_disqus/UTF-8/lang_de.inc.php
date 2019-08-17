<?php
@define('PLUGIN_DISQUS_TITLE', 'Disqus-Kommentare');
@define('PLUGIN_DISQUS_DESC', 'Disqus.com ist ein Webservice, mit dem Sie Kommentare zentral verwalten können. Der Dienst speichert und verwaltet Kommentare außerhalb Ihrer Serendipity-Installation und ist mit JavaScript eingebettet. Weitere Informationen finden Sie unter https://disqus.com/.');
@define('PLUGIN_DISQUS_DESC2', '
Das Plugin fügt die DISQUS-Ausgabe in die Smarty-Variablen {$entry.plugin_display_dat} und {$entry.disqus} ein, die Sie an einer beliebigen Stelle im {$entry}-Loop in Ihre entries.tpl-Vorlage einfügen können.

Wenn der angezeigte Eintrag bereits DISQUS-Unterstützung bietet, ist die Variable {$entry.has_disqus} wahr (true).
');
@define('PLUGIN_DISQUS_ENABLE_SINCE', 'Aktiviere disqus.com für Einträge seit ...');
@define('PLUGIN_DISQUS_ENABLE_SINCE_DESC', 'Geben Sie ein Datum (Y-m-d) ein, ab dem Disqus-Kommentare aktiviert werden sollen, damit auch ältere Kommentare noch ordnungsgemäß angezeigt werden.');
@define('PLUGIN_DISQUS_SHORTNAME', 'Kurzname Ihres Disqus-Blog-Kontos');
@define('PLUGIN_DISQUS_SHORTNAME_DESC', 'Geben Sie den Kurznamen (shortname) dieses Blogs ein, den Sie in Ihrem Disqus-Konto registriert haben.');
@define('PLUGIN_DISQUS_FOOTERCOMMENTLINK', 'DISQUS die Anzahl der Kommentare in der Fußzeile anzeigen lassen');
@define('PLUGIN_DISQUS_FOOTERCOMMENTLINK_DESC', 'Da die Anzahl der Kommentare nicht bekannt ist, fügt dieses Plugin nur "Kommentare" statt "N Kommentare" in die Fußzeile ein. Sie können DISQUS veranlassen, dies durch die richtige Anzahl zu ersetzen. In einigen Vorlagen wird dies jedoch möglicherweise nicht korrekt angezeigt, so dass Sie das dynamische Ersetzen von DISQUS hier deaktivieren können.');
@define('PLUGIN_DISQUS_HIDE_COMMENTCSS', 'Kommentar-CSS ausblenden');
@define('PLUGIN_DISQUS_HIDE_COMMENTCSS_DESC', 'Wenn disqus.com-Kommentare aktiviert sind, funktionieren alle Funktionen, die auf in Serendipity gespeicherten Kommentaren basieren, natürlich nicht mehr. Intern verwendet dieses Plugin CSS, um die Serendipity-Ausgabe für Kommentare und das Kommentarformular auszublenden. Dafür setzt es für diese CSS-Klassen "display: none". Bitte geben Sie die in Ihrem Theme verwendeten Klassen ein, mit denen Sie Ihren Kommentarbereich und Ihr Kommentarformular ausgezeichnet haben. Der Standard sollte für die meisten Themes funktionieren.');