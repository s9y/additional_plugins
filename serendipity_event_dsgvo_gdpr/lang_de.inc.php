<?php

@define('PLUGIN_EVENT_DSGVO_GDPR_NAME', 'DSGVO / GDPR: Datenschutz-Grundverordnung');
@define('PLUGIN_EVENT_DSGVO_GDPR_DESC', 'Dieses Plugin soll Blogbetreibern helfen, Konformit�t zur Datenschutz-Grundverordnung herzustellen.');
@define('PLUGIN_EVENT_DSGVO_GDPR_MENU', 'DSGVO-Erkl�rung');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT', 'Ihre Datenschutzerkl�rung / Impressum');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_DESC', 'Sie k�nnen die oben stehende, automatisch erzeugte Inspektion als ersten groben Entwurf der ben�tigten Informationen, die Ihre Datenschutzerkl�rung enthalten sollte, verwenden. Versichern Sie sich jedoch, dass Ihre Datenschutzerkl�rung alle relevanten Informationen enth�lt. Falls Sie Hilfe ben�tigen, wenden Sie sich bitte an juristischen Beistand; wir k�nnen leider aus Haftungsgr�nden keine wasserdichte Vorlage einer solchen Erkl�rung bereit stellen.');
@define('PLUGIN_EVENT_DSGVO_GDPR_URL', 'Optional: URL zur Datenschutzerkl�rung');
@define('PLUGIN_EVENT_DSGVO_GDPR_URL_DESC', 'Standardm��ig wird ein interner Link erzeugt, der den hier eingegebenen Text als Ihre Datenschutzerkl�rung anzeigt. Haben Sie jedoch bereits eine spezifische URL (oder eine statische Seite), auf die Sie Ihre Besucher verweisen m�chten, k�nnen Sie diese hier angeben. In dem Fall wird der Text f�r die Datenschutzerkl�rung aus dem Plugin nicht angezeigt und muss daher nicht eingegeben werden.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX', 'M�ssen Kommentatoren die Datenschutzerkl�rung akzeptieren?');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX_DESC', 'Falls ausgew�hlt m�ssen Besucher eine zus�tzliche Checkbox ausw�hlen, um kommentieren zu k�nnen und zu best�tigen, dass sie Ihre Datenschutzerkl�rung akzeptieren.');

@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT', 'Zustimmungstext f�r Kommentare');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DESC', 'Geben Sie hier den Text ein, der Benutzern angezeigt wird, um die Bedingungen Ihres Angebotes zu akzeptieren. Verwenden Sie %gdpr_url% als Platzhalter f�r die URL.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DEFAULT', 'Ich stimme zu, dass meine Daten gespeichert werden d�rfen. Weitere Einzelheiten und Informationen siehe <a href="%gdpr_url%" target="_blank">Datenschutzerkl�rung / Impressum</a>.');
@define('PLUGIN_EVENT_DSGVO_GDPR_INFO', 'Informationen zur Relevanz der DSGVO f�r Ihr Blog');
@define('PLUGIN_EVENT_DSGVO_GDPR_INFO_DESC', 'Serendipity kann aus den installierten Plugins ermitteln, wie sich diese auf die Nutzung und Handhabung sensibler Benutzerdaten in Ihrem Blog auswirken. An dieser Stelle werden diese Daten automatisch evaluiert und zu Ihrer Kenntnisname ausgegeben. Stellen Sie bitte sicher, dass sie immer die aktuellen Versionen von Plugins verwenden. Sie sind selbst gesetzlich daf�r verantwortlich, dem Benutzer alle verwendeten Dienste mitzuteilen. Sollten Sie diesbez�glich relevante Funktionalit�t verwenden, die nicht Teile des Serendipity-Kerns oder der Serendipity-Plugins ist (z.B. eigene Plugins, Templates, Code-Schnipsel), denken Sie daran, diese in Ihrer Datenschutzerkl�rung zu nennen!');

@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER', 'Link zur Datenschutzerkl�rung im Footer anzeigen?');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_DESC', 'Falls aktiviert wird ein Link zu Ihrer Datenschutzerkl�rung im Footer Ihres Blogs angezeigt. Sie k�nnen den angezeigten Text anpassen. Verwenden Sie %gdpr_url% als Platzhalter f�r diesen Link.');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT', 'Linktext zur Datenschutzerkl�rung');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DESC', 'Falls der Link zur Datenschutzerkl�rung aktiviert ist, geben Sie hier den Text ein, der dort angezeigt werden soll.');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DEFAULT', '<a href="%gdpr_url%">Datenschutzerkl�rung / Impressum</a>');

@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_MENU', 'CookieConsent');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT', 'CookieConsent von Insites verwenden?');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_DESC', 'Falls aktiviert wird in Ihrem Blog ein Cookie-Hinweis angezeigt. Dazu wird das Javascript-Plugin CookieConsent verwendet. Es unterst�tzt nur eine einfache Zustimmung / Information zu Cookies. Sie k�nnen den Generator auf <a href="https://cookieconsent.insites.com/download/">https://cookieconsent.insites.com/download/</a> verwenden, um den Code anzupassen; achten Sie jedoch darauf, hier NUR den Hauptteil des JavaScripts anzugeben, aber KEINE Links zu CSS oder JavaScript, damit dieser Code nur von Ihrem eigenen Server geladen wird und nicht von fremden Servern.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT', 'CookieConsent-Code');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT_DESC', 'Dieses JavaScript ist leicht verst�ndlich, Sie k�nnen hier alle Farben und Texte anpassen. Verwenden Sie %gdpr_url% als Platzhalter f�r den Link zu Ihrer Datenschutzerkl�rung.');
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
    "link": "Lesen Sie mehr in der Datenschutzerkl�rung",
    "href": "%gdpr_url%"
  }
})});
</script>
');

@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH', 'Verzeichnis des CookieConsent-JavaScripts');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH_DESC', 'Dieses Plugin enth�lt das JS und CSS von der CookieConsent-Website. Sie k�nnen hier auf andere Verzeichnisse verweisen. Stellen Sie sicher, dass die Dateien cookieconsent.min.css und cookieconsent.min.js hei�en.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_ERROR', 'Sie m�ssen die Bedingungen akzeptieren, um zu kommentieren.');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_ERROR', 'Dieses Blog hat noch keine Datenschutzerkl�rung erzeugt; diese muss in der Plugin-Konfiguration eingestellt werden.');

@define('PLUGIN_EVENT_DSGVO_GDPR_SERENDIPITY_CORE', '

<h4>Serendipity-Kern</h4>

<p>Serendipity verwendet ein sogenanntes "Session cookie" f�r sowohl das Frontend als auch das Backend. Ein Besucher bekommt ein Cookie mit einer eindeutigen ID, welches auf dem Server verwendet wird, um tempor�re Benutzerdaten f�r die Session zu speichern (z.B. G�ltigkeit des Login, Benutzereinstellungen).
Dieses Cookie ist notwendig, um sich ins Backend einzuloggen, aber optional im Frontend.
Bestimmte Plugins k�nnen das Session-Cookie verwenden, um zus�tzlich tempor�re Daten zu speichern.</p>

<p>Die folgenden Daten k�nnen von der Anwendung Serendipity auf dem Server gespeichert werden (vor�bergehend, werden nach einer auf dem Server voreingestellten Zeit ung�ltig, �blicherweise binnen Stunden):</p>

<ul>
<li>HTTP-Browser-Referrer, �ber den man auf das Blog kam</li>
<li>einzigartiger ID-Token des Autors</li>
<li>Benutzerdaten von angemeldeten Autoren, wie sie f�r schnelleren Zugriff in der Datenbank gespeichert werden:
    <ul>
        <li>Passwort</li>
        <li>ID des Benutzers</li>
        <li>eingestellte Sprache des Benutzers</li>
        <li>Benutzername</li>
        <li>E-Mail</li>
        <li>Hashtyp des Logins</li>
        <li>Berechtigungen zur Ver�ffentlichung von Eintr�gen</li>
    </ul>
</li>
<li>Inhalt des letzten Blogeintrags beim Speichern</li>
<li>Indikator, ob Smarty-Templates verwendet werden</li>
<li>m�glicher Inhalt eines erzeugten CAPTCHA-Bildes</li>
<li>das eingestellte Frontend-Theme</li>
</ul>

<p>Die folgenden Daten werden in Cookies gespeichert:</p>

<ul>
<li>PHP Session-ID</li>
<li>Zustand der Auswahlschalter f�r Eintragseditor, Sortierung, Sortierungsrichtung und Filter sowie zuletzt verwendetes Verzeichnis der Mediendatenbank (nur, falls eingeloggt)</li>
<li>Login-Token des Autors (nur, falls eingeloggt)</li>
<li>Anzeigesprache</li>
<li>nach dem Kommentieren: Nachname, E-Mail, URL, Status von "Daten merken?" (falls aktiviert)</li>
</ul>

<p>Die IP-Adressen von Benutzern werden wie folgt verwendet:</p>

<ul>
<li>in der Datenbank gespeichert, falls Referrer-Tracking aktiviert ist (Statistiken)</li>
<li>gespeichert f�r Kommentare eines Benutzers und angezeigt in der E-Mail, die an Moderatoren gesendet wird</li>
<li>gespeichert in Logdateien (falls aktiviert) der Antispam-Plugins</li>
<li>�mermittelt an den Akismet-Antispam-Filter (falls aktiviert)</li>
<li>tempor�rer Nur-lesen-Zugriff, um Referrer, Logins und IP-Flooding zu pr�fen</li>
</ul>

<p>Benutzereingeaben von Benutzern (nicht Autoren):</p>

<ul>
<li>Kommentare (alle Metadaten eines Kommentars, gespeichert in der Datenbank-Tabelle serendipity_comments)</li>
<li>Referrer-URL, �ber die man auf das Blog kam (falls Referrer-Tracking aktiviert ist, gespeichert in der Datenbank-Tabelle serendipity_referers)</li>
</ul>

<p>Zudem sind derzeit die folgenden Plugins aktiviert und erzeugen automatisch die folgende Liste an Ausgaben:</p>

');

@define('PLUGIN_EVENT_DSGVO_GDPR_ANONYMIZE', 'Anonymisiere IPs?');
@define('PLUGIN_EVENT_DSGVO_GDPR_ANONYMIZE_DESC', 'Falls aktiviert werden die letzten Teile der IP-Adressen (ipv4 und ipv6) mit "0" �berschrieben. Das bedeutet, dass an allen Stellen, an denen Serendipity die IP-Adresse des Benutzers speichert oder verwendet (auch f�r Anti-Spam-Techniken), die aufgezeichnete IP nicht die tats�chliche IP des Bsuchers sein wird. So werden Sie z.B. im Fall eines Missbrauchs nicht wissen, von welcher IP-Adresse ein Kommentar tats�chlich abgegeben wurde.');

@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND', 'Benutzerdaten verwalten');
@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND_INFO', 'Hier k�nnen Sie einen exakt �bereinstimmenden Benutzernamen oder eine E-Mail-Adresse eingeben, um diesen Benutzer zu entfernen oder seine Daten zu exportieren. Sie k�nnen mehrere Namen auf jeweils einer neuen Zeile eingeben.');
@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND_DELFAIL', 'Um exportieren oder l�schen zu k�nnen muss mindestens ein Benutzername oder eine E-Mail-Adresse eingegeben werden.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COPY_CLIPBOARD', 'In Zwischenablage kopieren');
