<?php

@define('PLUGIN_EVENT_AUTOUPDATE_NAME',     'Serendipity Autoupdate');
@define('PLUGIN_EVENT_AUTOUPDATE_DESC',     'Sobald das Dashboard Plugin (einmal am Tag) ein Serendipity Update entdeckt, setzt dieses Plugin eine Ein-Klick Option in das Dashboard des Backends, um ein manuelles Download oder ein automatisches und gesichertes Upgrade der Blogsoftware zu starten.');
@define('PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON',     'Automatisches Upgrade starten');
@define('PLUGIN_EVENT_AUTOUPDATE_DISABLE_INTEGRITY_CHECKS', 'Deaktiviere Integritätsprüfung (ACHTUNG!)');
@define(
    'PLUGIN_EVENT_AUTOUPDATE_DISABLE_INTEGRITY_CHECKS_DESC',
    'Diese Einstellung deaktiviert die Integritätsprüfung für Dateien für einen Durchlauf des automatischen Updates. Sie wird danach automatisch wieder auf `Nein` gesetzt.'
);
@define(
    'PLUGIN_EVENT_AUTOUPDATE_RETRY_NO_INTEGRITY_CHECKS_BUTTON',
    'Automatisches Upgrade ohne Integritätsprüfung wiederholen'
);
