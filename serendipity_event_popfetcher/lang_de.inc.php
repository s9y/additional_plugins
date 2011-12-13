<?php
// German Language definitions
// Author: Jason Levitt
// Email: fredb86@users.sourceforge.net
// Translation: Jan Wildeboer (jw@domainfactory.de)

@define('PLUGIN_MF_NAME', 'POPfetcher');
@define('PLUGIN_MF', 'POPfetcher');
@define('PLUGIN_MF_DESC', 'Holt Email inkl. Anhänge ab und veröffentlicht sie von einem POP3 Email Account (mit spezieller Handy Unterstützung)');
@define('PLUGIN_MF_AM', 'Plugin Methode');
@define('PLUGIN_MF_AM_DESC', 'Wenn auf "Intern" gesetzt, müssen Sie den POPfetcher über das Admin-Menü aufrufen. Wenn "Extern" eingestellt ist, kann POPfetcher nur über einen Crinjob aufgerufen werden. (Vorgabe ist "Intern".');
@define('PLUGIN_MF_HN', 'Name für externen Aufruf');
@define('PLUGIN_MF_HN_DESC', 'Bitte geben Sie eine Zeichenkette ein, über die das Plugin später gezielt aufgerufen werden kann. Diese Zeichenkette sollten nur sie kennen, so dass der Aufruf des Popfetcher vor fremden Besuchern geschützt ist. Wenn der Name z.B. auf "xyz123" gesetzt wird, kann der Aufruf mittels http://yourblog/index.php?/plugin/xyz1234" durchgeführt werden (auch automatisiert via wget/lynx). Falls der Aufruf des Plugins nicht auf "Extern" steht, hat diese Option keine Auswirkung.');
@define('PLUGIN_MF_MS', 'Mail Server');
@define('PLUGIN_MF_MS_DESC', 'Der Servername des POP3 Server, z.B. yourdomain.com');
@define('PLUGIN_MF_MD', 'Upload Verzeichniss');
@define('PLUGIN_MF_MD_DESC', 'Anhänge einer Mail werden hier gespeichert. Vorgabe ist das oberste Upload-Verzeichniss (einfach das Feld leer lassen). Wenn ein Verzeichniss angegeben wird, bitte den Slash "/" am Ende nicht vergessen. Beispiel: MyVacation/ ');
@define('PLUGIN_MF_PP', 'POP3 port');
@define('PLUGIN_MF_PP_DESC', 'POP3 Service Port.  Falls auf 995 eingestellt, dann wird POP3 über SSL probiert.  Voreinstellung ist 110.');
@define('PLUGIN_MF_MU', 'POP3 User');
@define('PLUGIN_MF_MU_DESC', 'Der POP3 Benutzername');
@define('PLUGIN_MF_CAT', 'Kategorie');
@define('PLUGIN_MF_CAT_DESC', 'Blog Kategorie unter der die Einträge eingeordnet werden sollen. Vorgabe ist "keine Kategorie" (einfach das Feld leer lassen)');
@define('PLUGIN_MF_MP', 'Passwort');
@define('PLUGIN_MF_MP_DESC', 'Das POP3 Passwort');
@define('PLUGIN_MF_TO', 'Timeout');
@define('PLUGIN_MF_TO_DESC', 'Maximalzeit in Sekunden für die Kontaktaufnahme mit dem POP3-Server. Vorgabe ist 30 Sekunden.');
@define('PLUGIN_MF_DF', 'Mail Löschen');
@define('PLUGIN_MF_DF_DESC', 'Wenn auf "Ja", werden Mails nach dem Aholen auf dem Server gelöscht. Sollte nur auf "Nein" stehen zu Testzwecken.');
@define('PLUGIN_MF_PF', 'Publizieren');
@define('PLUGIN_MF_PF_DESC', 'Wenn auf "Publizieren" werden die Einträge sofort veröffentlicht. Wenn auf "Entwurf" werden die Einträge als Entwurf markiert. Default is draft. (Wird ignoriert wenn Blog auf "Nein" steht).');
@define('PLUGIN_MF_BF', 'Blog');
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

@define('MF_TEXTBODY', 'Use plaintext attachments as entry body?');
@define('MF_TEXTBODY_DESC', 'If activated, all plaintext attachments of a mail will be used as the body of your entry. If not activated, all text attachments will be saved as text attachments and only linked in your entry');
@define('MF_TEXTBODY_FIRST', 'First text attachment is entry body, the rest extended');
@define('MF_TEXTBODY_FIRST_DESC', 'Only used if plaintext attachments are treated as entry body (see above). If activated, only the first plaintext attachment will be used as the entry body, all other contained text attachments will be put into the extended part of your entry');
@define('MF_MYSELF', 'Aktueller Autor');
@define('MF_AUTHOR_DESC', 'Wählen Sie den Autoren, dem die popfetcher Einträge zugeschrieben werden sollen');
@define('PLUGIN_MF_STRIPTAGS', 'Entferne alle HTML-Tags aus den Mails');
@define('PLUGIN_MF_STRIPTAGS_DESC', 'Entferne alle HTML-Tags aus den Mails');
@define('PLUGIN_MF_ADDFLAG', 'Werbung entfernen?');
@define('PLUGIN_MF_ADDFLAG_DESC', 'Soll popfetcher probieren, die Werbetexte und -Bilder von E-Mails zu entfernen? Derzeit ist dies nur für O2 und T-Mobile implementiert.');
@define('PLUGIN_MF_STRIPTEXT', 'Text nach speziellen Buchstaben abschneiden');
@define('PLUGIN_MF_STRIPTEXT_DESC', 'Wenn Sie Werbung oder andere Textpassagen abschneiden wollen, können Sie hier einen "magischen Text" angeben. Sobald dieser im Inhalt ihrer Mail vorkommt, wird aller Text danach aus dem Eintrag gelöscht.');
@define('PLUGIN_MF_ONLYFROM', 'E-Mail Absender');
@define('PLUGIN_MF_ONLYFROM_DESC', 'Wenn nur ein spezieller Absender anerkannt werden soll, tragen Sie hier diese E-Mail Addresse ein. Bei einem leeren Feld werden alle E-Mails im Blog angenommen');
@define('MF_ERROR_ONLYFROM', 'E-Mail Absender %s entspricht nicht dem zugelassenen Absender %s. Ignoriere E-Mail.');

@define('PLUGIN_MF_SPLITTEXT', 'Spezieller Text, der Text und erweiterten Eintrag einer E-Mail aufteilt');
@define('PLUGIN_MF_SPLITTEXT_DESC', 'Falls Sie die Aufteilung der E-Mail in normalen Eintrag und erweiterten Eintrag manuell bestimmen wollen, können Sie diesen Trennungstext hier eingeben. Alles vor dem Auftreten dieses Texts wird dann in den normalen Eintrag gestellt, alles nach dem Text in den erweiterten Eintrag. Stellen Sie sicher, dass der spezielle Text einmalig vorkommt, also so etwas wie "xxx-TRENNER-xxx". Wenn Sie dieses Feld leerlassen, wird die E-Mail wie gewöhnlich aufgeteilt - sollten Sie hier einen Text eintragen, werden einige der anderen Konfigurationsoptionen ausgehebelt!');

?>
