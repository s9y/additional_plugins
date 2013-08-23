<?php # 

/**
 *  @version 
 *  @file serendipity_event_guestbook.php, langfile(bg)
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.2
 */

//
//  serendipity_event_guestbook.php
//
@define('GUESTBOOK_HEADLINE', 'Заглавие');
@define('GUESTBOOK_HEADLINE_BLAHBLAH', 'Заглавие на страницата на книгата за гости');
@define('GUESTBOOK_TITLE', 'Книга за гости');
@define('GUESTBOOK_TITLE_BLAHBLAH', 'Показва книга за гости в блога.');
@define('GUESTBOOK_PAGETITLE', 'Заглавие на страницата');
@define('GUESTBOOK_PAGETITLE_BLAHBLAH', 'Заглавие на страницата на книгата за гости');
@define('GUESTBOOK_PAGEURL', 'Статичен URL');
@define('GUESTBOOK_PAGEURL_BLAHBLAH', 'Дефинира URL за страницата (например index.php?serendipity[subpage]=name)');
@define('GUESTBOOK_SESSIONLOCK', 'Заключване по сесия');
@define('GUESTBOOK_SESSIONLOCK_BLAHBLAH', 'Ако е активно, разрешава само едно съобщение за сесията. Понякога добре, понякога не, понеже може някой да е забравил да напише нещо и да иска да остави второ съобщение.');
@define('GUESTBOOK_TIMELOCK', 'Заключване по време');
@define('GUESTBOOK_TIMELOCK_BLAHBLAH', 'Задава време в секунди, след което посетителят може да въведе следващо съобщение. Полезно е, когато искате да се предпазите от дублиране на съобщенията чрез двойно кликване, или да изолирате спам роботите.');
@define('GUESTBOOK_EMAILADMIN', 'e-mail до администратора');
@define('GUESTBOOK_EMAILADMIN_BLAHBLAH', 'Ако е активно, при всяко съобщение се изпраща e-mail до администратора.');
@define('GUESTBOOK_TARGETMAILADMIN', 'e-mail адрес на администратора');
    
@define('GUESTBOOK_NUMBER', 'Съобщения на страница');
@define('GUESTBOOK_NUMBER_BLAHBLAH', 'Брой на съобщения, които да се показват на една страница');
@define('GUESTBOOK_WORDWRAP', 'Брой на символите на ред');
@define('GUESTBOOK_WORDWRAP_BLAHBLAH', 'След колко символа автоматично да се преминава на нов ред ?');
@define('GUESTBOOK_SHOWHOMEPAGE', 'Показване на URL на посетителя ?');
@define('GUESTBOOK_SHOWEMAIL', 'Показване на e-mail-а на посетителя ?');
@define('GUESTBOOK_DATEFORMAT', 'Формат на датата');

@define('SUBMIT', 'Изпращане');
@define('GUESTBOOK_NEXTPAGE', 'следваща страница');
@define('GUESTBOOK_PREVPAGE', 'предишна страница');
@define('TEXT_DELETE', 'изтриване');
@define('TEXT_SAY', 'каза');
@define('TEXT_EMAIL', 'e-mail');
@define('TEXT_NAME', 'Име');
@define('TEXT_HOMEPAGE', 'Страница');
@define('TEXT_COMMENT', 'Текст');
@define('TEXT_EMAILSUBJECT', ' БЛОГ: ново съобщение в книгата за гости');
@define('TEXT_EMAILTEXT', "%s току що написа във Вашата книга за гости:\n%s\n%s\n");
@define('ERROR_TIMELOCK', 'Между две съобщения трябва да има поне %s секунди.');
@define('ERROR_NAMEEMPTY', 'Липсва име на посетителя.');
@define('ERROR_TEXTEMPTY', 'Съобщението не съдържа никакъв текст.');
@define('ERROR_OCCURRED', 'Във вашето съобщение има проблеми. Отстранете ги и опитайте отново:');
@define('QUESTION_DELETE', 'Наистина ли искате да изтриете съобщението на %s ?');

//
//  serendipity_plugin_guestbook.php
//
@define('PLUGIN_GUESTSIDE_NAME', 'Книга за гости');
@define('PLUGIN_GUESTSIDE_BLAHBLAH', 'Показва последните съобщения в книгата за гости в странична приставка');
@define('PLUGIN_GUESTSIDE_TITLE', 'Заглавие на приставката');
@define('PLUGIN_GUESTSIDE_TITLE_BLAHBLAH', 'Заглавие на приставката на страничния панел');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL', 'Показване на e-mail');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL_BLAHBLAH', 'Да се показват ли e-mail адресите на авторите на съобщенията ?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE', 'Показване на URL');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE_BLAHBLAH', 'Да се показват ли URL на авторите на съобщенията ?');
@define('PLUGIN_GUESTSIDE_MAXCHARS', 'Брой символи');
@define('PLUGIN_GUESTSIDE_MAXCHARS_BLAHBLAH', 'Максимален брой символи от съобщението, които да се показват');
@define('PLUGIN_GUESTSIDE_MAXITEMS', 'Брой съобщения');
@define('PLUGIN_GUESTSIDE_MAXITEMS_BLAHBLAH', 'Максимален брой на съобщенията, които да се показват');
@define('PLUGIN_GUESTSIDE_NOENTRIES', 'Няма съобщения');

