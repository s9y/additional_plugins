<?php
// German Language definitions
// Author: Jason Levitt
// Email: fredb86@users.sourceforge.net
// Translation: Jan Wildeboer (jw@domainfactory.de)

@define('PLUGIN_MF_NAME', 'POPfetcher');
@define('PLUGIN_MF', 'POPfetcher');
@define('PLUGIN_MF_DESC', 'Holt E-Mail inkl. Anhängen ab und veröffentlicht sie von einem POP3 E-Mail-Account (mit spezieller Handy-Unterstützung)');
@define('PLUGIN_MF_AM', 'Plugin-Methode');
@define('PLUGIN_MF_AM_DESC', 'Wenn auf "Intern" gesetzt, müssen Sie den POPfetcher über das Admin-Menü aufrufen. Wenn "Extern" eingestellt ist, kann POPfetcher nur über einen Crinjob aufgerufen werden. (Vorgabe ist "Intern".');
@define('PLUGIN_MF_HN', 'Name für externen Aufruf');
@define('PLUGIN_MF_HN_DESC', 'Bitte geben Sie eine Zeichenkette ein, über die das Plugin später gezielt aufgerufen werden kann. Diese Zeichenkette sollten nur sie kennen, so dass der Aufruf des Popfetcher vor fremden Besuchern geschützt ist. Wenn der Name z.B. auf "xyz123" gesetzt wird, kann der Aufruf mittels http://yourblog/index.php?/plugin/xyz1234" durchgeführt werden (auch automatisiert via wget/lynx). Falls der Aufruf des Plugins nicht auf "Extern" steht, hat diese Option keine Auswirkung.');
@define('PLUGIN_MF_MS', 'Mail-Server');
@define('PLUGIN_MF_MS_DESC', 'Der Servername des POP3-Servers, z.B. yourdomain.com');
@define('PLUGIN_MF_MD', 'Upload-Verzeichnis');
@define('PLUGIN_MF_MD_DESC', 'Anhänge einer Mail werden hier gespeichert. Vorgabe ist das oberste Upload-Verzeichniss (einfach das Feld leer lassen). Wenn ein Verzeichniss angegeben wird, bitte den Slash "/" am Ende nicht vergessen. Beispiel: MyVacation/ ');
@define('PLUGIN_MF_PP', 'POP3 port');
@define('PLUGIN_MF_PP_DESC', 'POP3 Service Port. Falls auf 995 eingestellt, dann wird POP3 über SSL aufgebaut. Voreinstellung ist 110.');
@define('PLUGIN_MF_MU', 'POP3 User');
@define('PLUGIN_MF_MU_DESC', 'Der POP3 Benutzername');
@define('PLUGIN_MF_CAT', 'Kategorie');
@define('PLUGIN_MF_CAT_DESC', 'Blog-Kategorie, unter der die Einträge eingeordnet werden sollen. Vorgabe ist "keine Kategorie" (einfach das Feld leer lassen)');
@define('PLUGIN_MF_MP', 'Passwort');
@define('PLUGIN_MF_MP_DESC', 'Das POP3 Passwort');
@define('PLUGIN_MF_TO', 'Timeout');
@define('PLUGIN_MF_TO_DESC', 'Maximalzeit in Sekunden für die Kontaktaufnahme mit dem POP3-Server. Vorgabe ist 30 Sekunden.');
@define('PLUGIN_MF_DF', 'Mail nach Abruf löschen?');
@define('PLUGIN_MF_DF_DESC', 'Wenn auf "Ja", werden Mails nach dem Aholen auf dem Server gelöscht. Sollte nur auf "Nein" stehen zu Testzwecken.');
@define('PLUGIN_MF_PF', 'Publizieren');
@define('PLUGIN_MF_PF_DESC', 'Wenn auf "Publizieren" werden die Einträge sofort veröffentlicht. Wenn auf "Entwurf" werden die Einträge als Entwurf markiert. Default is draft. (Wird ignoriert wenn Blog auf "Nein" steht).');
@define('PLUGIN_MF_BF', 'Als Blog-Artikel veröffentlichen?');
@define('PLUGIN_MF_BF_DESC', 'Wenn auf "Ja", werden Anhänge dekodiert, in den Medienmanger verschoben, zum Eintrag angefügt und der Eintrag wird eingepflegt. Wenn auf "Nein" werden nur die Anhänge in den Medienmanager abgelegt und die Mail wird ansonsten ignoriert.');
@define('PLUGIN_MF_AF', 'APOP');
@define('PLUGIN_MF_AF_DESC', 'Wenn "Ja" wird APOP für den Login-Vorgang verwendet. Vorgabe ist "Nein".');
@define('ERROR_CHECK', 'FEHLER:');
@define('INTERNAL_MF', 'Intern');
@define('EXTERNAL_MF', 'Extern');
@define('PUBLISH_MF', 'Publizieren');
@define('DRAFT_MF', 'Entwurf');
@define('MF_ERROR1', 'FEHLER: Konnte nicht zum Mailserver verbinden.');
@define('MF_ERROR2', 'FEHLER: Login war nicht möglich (falsches Passowrt?).');
@define('MF_ERROR3', 'FEHLER: Konnte keine UIDL Informationen von der Mailbox erhalten. UIDL wird wahrscheinlich nicht unterstützt.');
@define('MF_ERROR4', 'FEHLER: Während des Abholvorgangs sind Fehler aufgetreten.');
@define('MF_ERROR5', 'FEHLER: Konnte folgende Datei nicht anlegen: ');
@define('MF_ERROR6', 'FEHLER: Das Upload Verzeichniss hat keine Schreibrechte. Bitte die Schreibrechte anpassen.');
@define('MF_ERROR7', 'FEHLER: Das Upload Verzeichniss hat keinen "/" als Abschluss. Bitte korrigieren.');
@define('MF_ERROR8', 'FEHLER: Die Blog Kategorie ist nicht angelegt.');
@define('MF_ERROR9', 'FEHLER: Fehler bei mimeDecode: Die Mail ist keine korrekte MIME-Mail.');
@define('MF_ERROR10', 'FEHLER: Konnte keine SprintPCS Picture/Video Share URL finden.');
@define('MF_ERROR11', 'FEHLER: Konnte nicht zur SprintPCS Picture/Video URL verbinden.');
@define('MF_ERROR13', 'FEHLER: Fopen konnte Bild-/Video-Date nicht öffnen.');
@define('MF_ERROR14', 'FEHLER: Konnte SprintPCS sound memo nicht öffnen.');
@define('MF_MSG1', 'Keine Nachrichten vorhanden.');
@define('MF_MSG2', 'Nachrichten, die aus der Mailbox geholt wurden');
@define('MF_MSG3', '[Kein date header gefunden]');
@define('MF_MSG4', '[Kein from header gefunden]');
@define('MF_MSG5', 'Datum: ');
@define('MF_MSG6', 'Von: ');
@define('MF_MSG7', 'MESSAGE DATA');
@define('MF_MSG8', 'MESSAGE PART -- Anhang gefunden: ');
@define('MF_MSG9', 'MESSAGE PART -- Nachricht gefunden ohne Body');
@define('MF_MSG10', 'Weder Anhänge noch Inhalt in dieser Mail vorhanden');
@define('MF_MSG11', 'Alle Nachrichten wurden aus der Mailbox entfernt');
@define('MF_MSG12', 'Alle Nachrichten weiterhin in der Mailbox vorhanden');
@define('MF_MSG13', 'Anhang wurde gespeichert als: ');
@define('MF_MSG14', 'Anhang mit gleichem Dateinamen bereits vorhanden, Name wird erweitert für: ');
@define('MF_MSG15', 'Neuer Blog Eintrag angelegt mit der ID:');
@define('MF_MSG16', 'Betreff: ');
@define('MF_MSG17', '[Kein subject header gefunden]');
@define('MF_MSG18', 'Hier klicken für Vollbild-Anzeige');
@define('MF_MSG19', 'Möglicher Virus gefunden. Nachricht wird ignoriert, da verdächtiger Anhang gefunden wurde.');
@define('MF_MSG20', 'Ignoriere Nachricht ohne Anhänge');
@define('MF_MSG21', 'Sound Memo');
@define('MF_MSG22', 'Klicken um Video anzuzeigen');
@define('MF_MSG23', 'Mobiltelefon @ ');

@define('MF_TEXTBODY', 'Plain-Text-Attachments als Blog-Eintrag benutzen?');
@define('MF_TEXTBODY_DESC', 'Falls gesetzt werden alle Plain-Text-Attachments als Inhalt des Blog-Artikels verwendet. Falls deaktiviert, werden alle Text-Attachments auch als solche gespeichert und verlinkt. Nur wenn diese Option aktiviert ist können Bilder/Datei-Attachments auch im Blog-Eintrag verlinkt werden.');
@define('MF_TEXTBODY_FIRST', 'Erstes Text-Attachment ist Blog-Eintrag, der Rest Erweiterter Inhalt');
@define('MF_TEXTBODY_FIRST_DESC', 'Wird nur benutzt, wenn Plain-Text-Attachments als Blog-Eintrag benutzt werden. Falls aktiviert wird nur das erste Plain-Text-Attachment als Blog-Eintragstext verwendet und alle weiteren als Text in den erweiterten Text eingefügt.');
@define('MF_MYSELF', 'Aktueller Autor');
@define('MF_AUTHOR_DESC', 'Wählen Sie den Autoren, dem die POPfetcher-Einträge zugeordnet werden sollen');
@define('PLUGIN_MF_STRIPTAGS', 'Entferne alle HTML-Tags aus den Mails');
@define('PLUGIN_MF_STRIPTAGS_DESC', 'Entfernt alle HTML-Tags (Formatierung, Links, etc.) aus dem Mailinhalt');
@define('PLUGIN_MF_ADDFLAG', 'Werbung entfernen?');
@define('PLUGIN_MF_ADDFLAG_DESC', 'Soll POPfetcher probieren, die Werbetexte und -Bilder von E-Mails zu entfernen? Derzeit ist dies nur für O2 und T-Mobile implementiert.');
@define('PLUGIN_MF_STRIPTEXT', 'Text nach speziellen Buchstaben abschneiden');
@define('PLUGIN_MF_STRIPTEXT_DESC', 'Wenn Sie Werbung oder andere Textpassagen abschneiden wollen, können Sie hier einen "magischen Text" angeben. Sobald dieser im Inhalt ihrer Mail vorkommt, wird aller Text danach aus dem Eintrag gelöscht.');
@define('PLUGIN_MF_ONLYFROM', 'E-Mail Absender');
@define('PLUGIN_MF_ONLYFROM_DESC', 'Wenn nur ein spezieller Absender anerkannt werden soll, tragen Sie hier diese E-Mail Addresse ein. Bei einem leeren Feld werden alle E-Mails im Blog angenommen');
@define('MF_ERROR_ONLYFROM', 'E-Mail Absender %s entspricht nicht dem zugelassenen Absender %s. Ignoriere E-Mail.');

@define('PLUGIN_MF_SPLITTEXT', 'Spezieller Text, der Text und erweiterten Eintrag einer E-Mail aufteilt');
@define('PLUGIN_MF_SPLITTEXT_DESC', 'Falls Sie die Aufteilung der E-Mail in normalen Eintrag und erweiterten Eintrag manuell bestimmen wollen, können Sie diesen Trennungstext hier eingeben. Alles vor dem Auftreten dieses Texts wird dann in den normalen Eintrag gestellt, alles nach dem Text in den erweiterten Eintrag. Stellen Sie sicher, dass der spezielle Text einmalig vorkommt, also so etwas wie "xxx-TRENNER-xxx". Wenn Sie dieses Feld leerlassen, wird die E-Mail wie gewöhnlich aufgeteilt - sollten Sie hier einen Text eintragen, werden einige der anderen Konfigurationsoptionen ausgehebelt!');

@define('PLUGIN_MF_USETEXT', 'Spezieller Text, der den Bloginhalt definiert');
@define('PLUGIN_MF_USETEXT_DESC', 'Falls nur ein Ausschnitt der E-Mail als Blogeintrag genutzt werden soll, kann dieser Marker hier spezifiziert werden. Sobald der Begriff in der E-Mail auftaucht wird alles zwischen diesem Marker als Bloginhalt verwendet. Es ist sicherzustellen, dass der "magische" Textmarker innerhalb der E-Mail eindeutig ist, also z.B. "xxx-BLOG-xxx".');
@define('PLUGIN_MF_CRONJOB', 'Dieses Plugin wird vom Serendipity Cronjob plugin unterstützt. Mit diesem Plugin kann einfach eine periodische Ausführung konfiguriert werden.');

@define('PLUGIN_MF_TEXTPREF', 'Bevorzugter Textbereich');
@define('PLUGIN_MF_TEXTPREF_DESC', 'Einige Mailprogramme senden E-Mails, die den Text sowohl als HTML als auch als Plain-Text enthalten, was zu dupliziertem Inhalt führen kann. Mit dieser Option wird eingestellt, welcher Textteil Priorität erhält.');
@define('PLUGIN_MF_TEXTPREF_BOTH', 'Beide');
@define('PLUGIN_MF_TEXTPREF_HTML', 'HTML');
@define('PLUGIN_MF_TEXTPREF_PLAIN', 'Plain Text');

@define('PLUGIN_MF_USEDATE', 'Datum der eingehenden E-Mail anstelle Ankunftsdatum bevorzugen');
@define('PLUGIN_MF_REPLY', 'Kommentar/Antwort wurde entdeckt, dies ist kein Blog-Eintrag.');
@define('PLUGIN_MF_REPLY_ERROR1', 'Eintrag konnte anhand des Betreffs nicht zugeordnet werden, E-Mail wurde nicht gespeichert.');
@define('PLUGIN_MF_REPLY_ERROR2', 'Konnte Kommentar nicht speichern.');

@define('PLUGIN_MF_SUBFOLDER', 'Datei-Anhänge in Unterverzeichnissen wie 2019/02/ speichern?');
@define('PLUGIN_MF_DEBUG', 'Fehler- und Debuggingmeldungen in uploads/popfetcher-YYYY-MM.log speichern?');

@define('THUMBNAIL_VIEW', 'Vorschaubilder in Blog-Eintrag anzeigen');
@define('THUMBNAIL_VIEW_DESC', 'Falls ein Thumbnail von angehängten Bildern im Blog-Eintrag dargestellt werden soll kann dies auf "Ja" gestellt werden. Wenn es auf "Nein" steht wird das vollständige Bild angezeigt.');

@define('PLUGIN_MF_DEBUGFILE', 'Für Entwickler: Hier kann ein Dateinamen angegeben werden zu einer EML-Datei mit einer E-Mail, um diese zu debuggen.');

