<?php # 

/**
 *  @version 
 *  @file serendipity_event_guestbook.php, langfile(se) v2.1 2006/10/17 crapmaster
 *  @author crapmaster
 *  EN-Revision: 
 */

@define('PLUGIN_GUESTBOOK_HEADLINE', 'Rubrik');
@define('PLUGIN_GUESTBOOK_HEADLINE_BLAHBLAH', 'Rubriken på sidan.');
@define('PLUGIN_GUESTBOOK_TITLE', 'Gästbok');
@define('PLUGIN_GUESTBOOK_TITLE_BLAHBLAH', 'Visa en gästbol i din blog med ditt vanlig blog-utseende.');
@define('PLUGIN_GUESTBOOK_PERMALINK', 'Permalänk');
@define('PLUGIN_GUESTBOOK_PERMALINK_BLAHBLAH', 'Definierar en permalänk för denna URL/address. Skall vara en absolut HTTP-path och skall avslutas med .htm eller .html!');
@define('PLUGIN_GUESTBOOK_PAGETITLE', 'Sidtitel');
@define('PLUGIN_GUESTBOOK_PAGETITLE_BLAHBLAH', 'Titel på sidan');
@define('PLUGIN_GUESTBOOK_PAGEURL', 'Statisk URL');
@define('PLUGIN_GUESTBOOK_PAGEURL_BLAHBLAH', 'Sätter URL/adress till gästboken (index.php?serendipity[subpage]=name)');

@define('PLUGIN_GUESTBOOK_SESSIONLOCK', 'Sessionslås');
@define('PLUGIN_GUESTBOOK_SESSIONLOCK_BLAHBLAH', 'Om aktivt, endast ett inlägg på session/användare.');
@define('PLUGIN_GUESTBOOK_TIMELOCK', 'Tidslås');
@define('PLUGIN_GUESTBOOK_TIMELOCK_BLAHBLAH', 'Efter hur många sekunder kan användaren göra ett nytt inlägg. Bra ifall du vill undvika dubbla inlägg pga dubbelklick, eller att förebygga för spam robots.');

@define('PLUGIN_GUESTBOOK_EMAILADMIN', 'Skicka e-post till admininstratören');
@define('PLUGIN_GUESTBOOK_EMAILADMIN_BLAHBLAH', 'Om sant, kommer admininstratören att få e-post för varje inlägg som postas.');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN', 'Administratörens E-post');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN_BLAHBLAH', 'Var vänlig ange en giltig e-post adress om du vill få notifiering på email.');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL', 'Fråga efter användarens e-post adress?');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL_BLAHBLAH', 'Vill du ha ett fält där användaren kan skriva in sin e-post adress?');
@define('PLUGIN_GUESTBOOK_SHOWURL', 'Fråga efter användarens hemsida?');
@define('PLUGIN_GUESTBOOK_SHOWURL_BLAHBLAH', 'Vill du ha ett fält där användaren kan skriva in sin hemsida?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA', 'Visa Captchas?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA_BLAHBLAH', 'Vill du använda CAPTCHAS (kräver att Spamblock plugin är aktiverad)');
@define('PLUGIN_GUESTBOOK_NUMBER', 'Inlägg per sida');
@define('PLUGIN_GUESTBOOK_NUMBER_BLAHBLAH', 'Hur många inlägg skall visas per sida?');
@define('PLUGIN_GUESTBOOK_WORDWRAP', 'Antal tecken per rad');
@define('PLUGIN_GUESTBOOK_WORDWRAP_BLAHBLAH', 'Efter hur många tecken skall radbrytning automatiskt ske?');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Ett fel uppstod vid processningen');
	
@define('PLUGIN_GUESTBOOK_EMAIL', 'E-post adress');
@define('PLUGIN_GUESTBOOK_INTRO', 'Introduktionstext (valfri)');
@define('PLUGIN_GUESTBOOK_MESSAGE', 'Meddelande');
@define('PLUGIN_GUESTBOOK_SENT', 'Text som visas efter att meddelandet har skickats.');
@define('PLUGIN_GUESTBOOK_SENT_HTML', 'Ditt medddelande har skickats!');
@define('PLUGIN_GUESTBOOK_ERROR_HTML', 'Ett fel uppstod när meddelande postades"!');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Namn, e-post och ditt meddelande får inte vara tomma.');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT', 'Formattera som artikel?');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT_BLAHBLAH', 'Om aktiverad, utdata blir automatiskt formatterad som en artikel (färger, ramar, etc.) (förvalt: ja)');
@define('PLUGIN_GUESTBOOK_CAPTCHAWARNING', '');
@define('PLUGIN_GUESTBOOK_PROTECTION', 'E-post kommer att bli konverterad på följande sätt: user at email dot com');
@define('PLUGIN_GUESTBOOK_DBDONE', 'Gästboksinlägg sparat!');
@define('PLUGIN_GUESTBOOK_USER_LOGGEDOFF', 'Användaren har loggat ut.');
@define('PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY', 'skrev');
@define('PLUGIN_GUESTBOOK_UNKNOWN_ERROR', 'Okänt fel! Var vänlig kontakta admininistratör av sidan.');
@define('PLUGIN_GUESTBOOK_TIMESTAMP_THE', 'den');
@define('PLUGIN_GUESTBOOK_ALTER_OLDTABLE_DONE', 'Databas-tabellen har framgångsrikt ändrats.');
@define('PLUGIN_GUESTBOOK_INSTALL_NEWTABLE_DONE', 'Databas-tabellen har framgångsrikt installerad.');

@define('BODY', 'Inlägg');
@define('SUBMIT', 'Skicka inlägg');
@define('GUESTBOOK_NEXTPAGE', 'nästa sida');
@define('GUESTBOOK_PREVPAGE', 'föregående sida');

@define('TEXT_DELETE', 'ta bort');
@define('TEXT_SAY', 'sa');
@define('TEXT_EMAIL', 'E-post');
@define('TEXT_NAME', 'Namn');
@define('TEXT_HOMEPAGE', 'Hemsida');
@define('TEXT_EMAILSUBJECT', 'Blog: nytt inlägg i gästboken');
@define('TEXT_EMAILTEXT', "%s skrev precis nåt i din gästbok:\n%s\n%s\n");

@define('TEXT_CONVERTBOLDUNDERLINE', 'Omslutande asterisker markerar text som fetstil (*ord*), underscore görs med hjälp av _ord_.');
@define('TEXT_CONVERTSMILIES', 'Standard emoticons som :-) och ;-) konverteras till bilder.');
@define('TEXT_IMG_DELETEENTRY', 'Ta bort inlägg');
@define('TEXT_IMG_LASTMODIFIED', 'senast modifierad');
@define('TEXT_USERS_HOMEPAGE', 'Gästens hemsida');

@define('ERROR_TIMELOCK', 'Du måste vänta minst %s sekunder mellan varje postat inlägg!');
@define('ERROR_NAMEEMPTY', 'Var vänlig fyll i ditt namn.');
@define('ERROR_TEXTEMPTY', 'Var vänlig fyll i text.');
@define('ERROR_OCCURRED', 'Nåt gick fel:');
	
@define('ERROR_EMAILEMPTY', 'Var vänlig ange en giltig e-post adress.');
@define('ERROR_DATATOSHORT', 'Ditt inlägg skall ha minst 3, i kommentarer 10 tecken.');
@define('ERROR_NOVALIDEMAIL', 'Din e-post adress verkar vara ogiltig: ');
@define('ERROR_COLOR_START', '<span style="color: #ff0000"> ');
@define('ERROR_COLOR_END', ' </span>');
@define('ERROR_NOINPUT', 'Var vänlig mata in ditt namn, e-post adress och en kommentar');
@define('ERROR_ISFALSECAPTCHA', 'CAPTCHAS för ditt inlägg stämmer inte!');
@define('ERROR_NOCAPTCHASET', 'Den generella CAPTCHA-konfigurationen kanske inte är korrekt!');
@define('ERROR_UNKNOWN', 'Ett okänt fel inträffade. Var vänlig försök igen eller informera webmastern för hemsidan. Tack!');
@define('ERROR_IS_MARKED_SPAM', 'Ditt inlägg blev markerat som spam. Var vänlig rätta till ditt inlägg eller kontakta webmastern för hemsidan!');

@define('THANKS_FOR_ENTRY', 'Ditt gästboksinlägg:');
@define('QUESTION_DELETE', 'Vill du verkligen ta bort inlägget %s ?');
@define('MARK_SPAM', 'Skall detta inlägg markeras som SPAM?');

@define('PAGINATOR_TO', 'Till');
@define('PAGINATOR_FIRST', 'Först');
@define('PAGINATOR_PREVIOUS', 'Föregående');
@define('PAGINATOR_NEXT', 'Nästa');
@define('PAGINATOR_LAST', 'Sista');
@define('PAGINATOR_PAGE', 'Sifa.');
@define('PAGINATOR_RANGE', ' till ');
@define('PAGINATOR_OFFSET', ', totalt ');
@define('PAGINATOR_ENTRIES', ' inlägg. ');

//
//  serendipity_plugin_guestbook.php
//
@define('PLUGIN_GUESTSIDE_NAME', 'Gästbokens sidmeny');
@define('PLUGIN_GUESTSIDE_BLAHBLAH', 'Visa de senaste gästboksinläggen i sidmenyn');
@define('PLUGIN_GUESTSIDE_TITLE', 'Inläggets titel');
@define('PLUGIN_GUESTSIDE_TITLE_BLAHBLAH', 'Sätt titeln för sidmenyn');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL', 'Visa användarens e-post?');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL_BLAHBLAH', 'Skall skribentens e-post adress visas?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE', 'Visa användarens hemsida?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE_BLAHBLAH', 'Skall skribentens hemsida visas?');
@define('PLUGIN_GUESTSIDE_MAXCHARS', 'Max antal tecken');
@define('PLUGIN_GUESTSIDE_MAXCHARS_BLAHBLAH', 'Inläggets innehåll i antal tecken');
@define('PLUGIN_GUESTSIDE_MAXITEMS', 'Max. antal inlägg');
@define('PLUGIN_GUESTSIDE_MAXITEMS_BLAHBLAH', 'Sätt antalet inlägg som skall visas');

