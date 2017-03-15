# D64 LSR-Stopper-Plugin für Serendipity

Mit diesem Plugin verhinderst du Verlinkungen zu Medien, deren Verlage das Leistungsschutzrecht unterstützen bzw. in Anspruch nehmen.

Dieses Plugin basiert auf dem [Original-Plugin für Wordpress](http://wordpress.org/extend/plugins/d64-lsr-stopper/). Danke!

## Beschreibung

Mit diesem Plugin werden Links zu Internetseiten und Medien, deren Verlage/Firmen das Leistungsschutzrecht unterstützen bzw. in Anspruch nehmen, auf eine <a href="http://leistungsschutzrecht-stoppen.d-64.org/blacklisted/">spezielle Seite</a> umgeleitet, die über das Leistungsschutzrecht aufklärt. Auf der Blacklist sind die Mitglieder des BDZV (Bundesvereinigung deutscher Zeitungsverleger), des VDZ (Verband deutscher Zeitschriftenverleger) sowie der Deutschen Content-Allianz. Medien, die sich explizit vom Leistungsschutzrecht distanziert haben werden wieder entfernt.

Die Blacklist wird von D64 angeboten und dort heruntergeladen. Alternativ geschieht die Einstufung über einen DNS-Service (s.u.).

<ul>
	<li><a href="http://leistungsschutzrecht-stoppen.d-64.org/">Weitere Informationen gibt es bei D64 &rarr;</a></li>
	<li><a href="https://github.com/gglnx/d64-lsr-stopper">Plugin für Wordpress auf GitHub &rarr;</a></li>
	<li><a href="http://dentaku.wazong.de/2013/03/01/lsrdnsbl/">Dentakus Blogpost zu seinem DNS-Service</a></li>
</ul>

<em>Hinweis: Keine Sorge, das Plugin lässt sich problemlos und rückstandslos entfernen (d.h. es werden keine Änderungen an der Datenbank vorgenommen), nach Deinstallation funktionieren alle Links wie vorher.</em>

## Installation

1. [ZIP-Archiv](https://github.com/mattsches/serendipity_event_lsrstopper/archive/master.zip) herunterladen.
2. ZIP-Archiv entpacken.
3. Dateien nach `/plugins/` hochladen.
4. Das Plugin im Admin-Bereich von Serendipity aktivieren.
5. Falls ihr das Plugin `serendipity_event_trackexits` verwendet, stellt sicher, dass es erst *nach* `serendipity_event_lsrstopper` ausgeführt wird!
