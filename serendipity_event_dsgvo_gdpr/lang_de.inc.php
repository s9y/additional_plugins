<?php

@define('PLUGIN_EVENT_DSGVO_GDPR_NAME', 'DSGVO / GDPR: Datenschutz-Grundverordnung');
@define('PLUGIN_EVENT_DSGVO_GDPR_DESC', 'Dieses Plugin soll Blogbetreibern helfen, Konformität zur Datenschutz-Grundverordnung herzustellen.');
@define('PLUGIN_EVENT_DSGVO_GDPR_MENU', 'DSGVO-Erklärung');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT', 'Ihre Datenschutzerklärung / Impressum');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_DESC', 'Sie können die oebn stehende, automatisch erzeugte Inspektion als ersten groben Entwurf der benötigten Informationen, die Ihre Datenschutzerklärung enthalten sollte, verwenden. Versichern Sie sich jedoch, dass Ihre Datenschutzerklärung alle relevanten Informationen enthält. Falls Sie Hilfe benötigen, wenden Sie sich bitte an juristischen Beistand; wir können leider aus Haftungsgründen keine wasserdichte Vorlage einer solchen Erklärung bereit stellen.');
@define('PLUGIN_EVENT_DSGVO_GDPR_URL', 'Optional: URL zur Datenschutzerklärung');
@define('PLUGIN_EVENT_DSGVO_GDPR_URL_DESC', 'Standardmäßig wird ein interner Link erzeugt, der den hier eingegebenen Text als Ihre Datenschutzerklärung anzeigt. Haben Sie jedoch bereits eine spezifische URL (oder eine statische Seite), auf die Sie Ihre Besucher verweisen möchten, können Sie diese hier angeben. In dem Fall wird der Text für die Datenschutzerklärung aus dem Plugin nicht angezeigt und muss daher nicht eingegeben werden.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX', 'Müssen Kommentatoren die Datenschutzerklärung akzeptieren?');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX_DESC', 'Falls ausgewählt müssen Besucher eine zusätzliche Checkbox auswählen, um kommentieren zu können und zu bestätigen, dass sie Ihre Datenschutzerklärung akzeptieren.');

@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT', 'Zustimmungstext für Kommentare');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DESC', 'Geben Sie hier den Text ein, der Benutzern angezeigt wird, um die Bedingungen Ihres Angebotes zu akzeptieren. Verwenden Sie %gdpr_url% als Platzhalter für die URL.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DEFAULT', 'Ich stimme zu, dass meine Daten gespeichert werden dürfen. Weitere Einzelheiten und Informationen siehe <a href="%gdpr_url%" target="_blank">Datenschutzerklärung / Impressum</a>.');
@define('PLUGIN_EVENT_DSGVO_GDPR_INFO', 'Informationen zur Relevanz der DSGVO für Ihr Blog');
@define('PLUGIN_EVENT_DSGVO_GDPR_INFO_DESC', 'Serendipity kann aus den installierten Plugins ermitteln, wie sich diese auf die Nutzung und Handhabung sensibler Benutzerdaten in Ihrem Blog auswirken. An dieser Stelle werden diese Daten automatisch evaluiert und zu Ihrer Kenntnisname ausgegeben. Stellen Sie bitte sicher, dass sie immer die aktuellen Versionen von Plugins verwenden. Sie sind selbst gesetzlich dafür verantwortlich, dem Benutzer alle verwendeten Dienste mitzuteilen. Sollten Sie diesbezüglich relevante Funktionalität verwenden, die nicht Teile des Serendipity-Kerns oder der Serendipity-Plugins ist (z.B. eigene Plugins, Templates, Code-Schnipsel), denken Sie daran, diese in Ihrer Datenschutzerklärung zu nennen!');

@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER', 'Link zur Datenschutzerklärung im Footer anzeigen?');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_DESC', 'Falls aktiviert wird ein Link zu Ihrer Datenschutzerklärung im Footer Ihres Blogs angezeigt. Sie können den angezeigten Text anpassen. Verwenden Sie %gdpr_url% als Platzhalter für diesen Link.');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT', 'Linktext zur Datenschutzerklärung');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DESC', 'Falls der Link zur Datenschutzerklärung aktiviert ist, geben Sie hier den Text ein, der dort angezeigt werden soll.');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DEFAULT', '<a href="%gdpr_url%">Datenschutzerklärung / Impressum</a>');

@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_MENU', 'CookieConsent');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT', 'CookieConsent von Insites verwenden?');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_DESC', 'Falls aktiviert wird in Ihrem Blog ein Cookie-Hinweis angezeigt. Dazu wird das Javascript-Plugin CookieConsent verwendet. Es unterstützt nur eine einfache Zustimmung / Information zu Cookies. Sie können den Generator auf<a href="https://cookieconsent.insites.com/download/">https://cookieconsent.insites.com/download/</a> verwenden, um den Code anzupassen; achten Sie jedoch darauf, hier NUR den Hauptteil des JavaScripts anzugeben, aber KEINE links zu CSS oder JavaScript, damit dieser Code nur von Ihrem eigenen Server geladen wird und nicht von fremden Servern.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT', 'CookieConsent-Code');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT_DESC', 'Dieses JavaScript ist leicht verständlich, Sie können hier alle Farben und Texte anpassen. Verwenden Sie %gdpr_url% als Platzhalter für den Link zu Ihrer Datenschutzerklärung.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT_DEFAULT', '
<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#FFFFFF",
      "text": "#000000"
    },
    "button": {
      "background": "#FFFFFF",
      "text": "#0c5e0a",
      "border": "#000000"
    }
  },
  "content": {
    "message": "Diese Website verwendet Cookies.",
    "dismiss": "Akzeptieren",
    "link": "Lesen Sie mehr in der Datenschutzerklärung",
    "href": "%gdpr_url%"
  }
})});
</script>
');

@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH', 'Verzeichnis des CookieConsent-JavaScripts');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH_DESC', 'Dieses Plugin enthält das JS und CSS von der CookieConsent-Website. Sie können hier auf andere Verzeichnisse verweisen. Stellen Sie sicher, dass die Dateien cookieconsent.min.css und cookieconsent.min.js heißen.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_ERROR', 'Sie müssen die Bedingungen akzeptieren, um zu kommentieren.');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_ERROR', 'Dieses Blog hat noch keine Datenschutzerklärung erzeugt; diese muss in der Plugin-Konfiguration eingestellt werden.');

@define('PLUGIN_EVENT_DSGVO_GDPR_SERENDIPITY_CORE', '

<h4>Serendipity-Kern</h4>

<p>Serendipity verwendet ein sogenanntes "Session cookie" für sowohl das Frontend als auch das Backend. Ein Besucher bekommt ein Cookie mit einer eindeutigen ID, welches auf dem Server verwendet wird, um temporäre Benutzerdaten für die Session zu speichern (z.B. Gültigkeit des Login, Benutzereinstellungen).
Dieses Cookie ist notwendig, um sich ins Backend einzuloggen, aber optional im Frontend.
Bestimmte Plugins können das Session-Cookie verwenden, um zustätzlich temporäre Daten zu speichern.</p>

<p>Die folgenden Daten können von der Anwendung Serendipity auf dem Server gespeichert werden (vorübergehend, werden nach einer auf dem Server voreingestellten Zeit ungültig, üblicherweise binnen Stunden):</p>

<ul>
<li>HTTP-Browser-Referrer, über den man auf das Blog kam</li>
<li>einzigartiger ID-Token des Autors</li>
<li>Benutzerdaten von angemeldeten Autoren, wie sie für schnelleren Zugriff in der Datenbank gespeichert werden:
    <ul>
        <li>Passwort</li>
        <li>ID des Benutzers</li>
        <li>eingestellter Sprache des Benutzers</li>
        <li>Benutzername</li>
        <li>E-Mail</li>
        <li>Hashtyp des Logins</li>
        <li>Berechtigungen zur Veröffentlichung von Einträgen</li>
    </ul>
</li>
<li>Inhalt des letzten Blogeintrags beim Speichern</li>
<li>Indikator, ob Smarty-Templates verwendet werden</li>
<li>möglicher Inhalt eines erzeugten CAPTCHA-Bilders</li>
<li>das eingestellte Frontend-Theme</li>
</ul>

<p>Die folgenden Daten werden in Cookies gespeichert:</p>

<ul>
<li>PHP Session-ID</li>
<li>Zustand der Auswahlschalter für Eintragseditor, Sortierung, Sortierungsrichtung und Filter sowie zuletzt verwendetes Verzeichnis der Mediendatenbank (nur, falls eingeloggt)</li>
<li>Login-Token des Autors (nur, falls eingeloggt)</li>
<li>Anzeigesprache</li>
<li>nach dem Kommentieren: Nachname, E-Mail, URL, Status von "Daten merken?" (falls aktiviert)</li>
</ul>

<p>Die IP-Adressen von Benutzern werden wie folgt verwendet:</p>

<ul>
<li>in der Datenbank gespeichert, falls Referrer-Tracking aktiviert ist (Statistiken)</li>
<li>gespeichert für Kommentare eines Benutzers und angezeigt in der E-Mail, die an Moderatoren gesendet wird</li>
<li>gespeichert in Logdateien (falls aktiviert) der Antispam-Plugins</li>
<li>ümermittelt an den Akismet-Antispam-Filter (falls aktiviert)</li>
<li>temporärer Nur-lesen-Zugriff, um Referrer, Logins und IP-Flooding zu prüfen</li>
</ul>

<p>Benutzereingeaben von Benutzern (nicht Autoren):</p>

<ul>
<li>Kommentare (alle Metadaten eines Kommentars, gespeichert in der Datenbank-Tabelle serendipity_comments)</li>
<li>Referrer-URL, über die man auf das Blog kam (falls Referrer-Tracking aktiviert ist, gespeichert in der Datenbank-Tabelle serendipity_referers)</li>
</ul>

<p>Zudem sind derzeit die folgenden Plugins aktiviert und erzeugen automatisch die folgende Liste an Ausgaben:</p>

');