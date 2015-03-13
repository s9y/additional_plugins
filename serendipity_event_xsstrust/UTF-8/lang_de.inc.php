<?php
        @define('PLUGIN_EVENT_XSSTRUST_NAME',     'Einstellungen für vertrauenswürdige Mehrbenutzer-Blogs / HTMLPurifier');
        @define('PLUGIN_EVENT_XSSTRUST_DESC',     'Dieses Plugin gibt an, welchen Autoren eines Mehrbenutzer-Blogs Sie genug trauen und von denen Sie keine Hackangriffe erwarten. Alle anderen Autoren dürfen kein HTML mehr verwenden!');
        @define('PLUGIN_EVENT_XSSTRUST_AUTHORS',  'Vertrauenswürdige Autoren');
@define('PLUGIN_XSSTRUST_HTMLPURIFIER', 'HTMLPurifier aktivieren?');
@define('PLUGIN_XSSTRUST_HTMLPURIFIER_DESC', 'Verwendet HTMLPurifier (www.htmlpurifier.org) um JavaScript bösartiges HTML von den Redakteurseingaben zu filtern. Falls aktiviert ist HTML von Redakteuren also teilweise erlaubt. Falls deaktiviert wird JEDES HTML von der Ausgabe gelöscht.');
