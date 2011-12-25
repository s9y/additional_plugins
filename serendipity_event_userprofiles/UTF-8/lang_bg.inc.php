<?php # $Id$

/**
 *  @version $Revision$
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.8
 */

//
//  for serendipity_event_userprofiles.php
//
@define('PLUGIN_EVENT_USERPROFILES_DBVERSION', '0.1');
@define('PLUGIN_EVENT_USERPROFILES_ILINK','<input class="direction_ltr" id="serendipity_event_userprofiles%s" type="radio" %s name="serendipity[profile%s]" value="%s" title="%s" />');
@define('PLUGIN_EVENT_USERPROFILES_LABEL','<label for="serendipity_event_userprofiles%s">%s</label>');

@define('PLUGIN_EVENT_USERPROFILES_CITY',               'Град');
@define('PLUGIN_EVENT_USERPROFILES_COUNTRY',            'Държава');
@define('PLUGIN_EVENT_USERPROFILES_URL',                'Интернет страница');
@define('PLUGIN_EVENT_USERPROFILES_OCCUPATION',         'Работа');
@define('PLUGIN_EVENT_USERPROFILES_HOBBIES',            'Хобита');
@define('PLUGIN_EVENT_USERPROFILES_YAHOO',              'Yahoo');
@define('PLUGIN_EVENT_USERPROFILES_AIM',                'AIM');
@define('PLUGIN_EVENT_USERPROFILES_JABBER',             'Jabber');
@define('PLUGIN_EVENT_USERPROFILES_ICQ',                'ICQ');
@define('PLUGIN_EVENT_USERPROFILES_MSN',                'MSN');
@define('PLUGIN_EVENT_USERPROFILES_SKYPE',               'Skype');
@define('PLUGIN_EVENT_USERPROFILES_STREET',             'Улица');
@define('PLUGIN_EVENT_USERPROFILES_BIRTHDAY',           'Рожден ден');

@define('PLUGIN_EVENT_USERPROFILES_SHOWEMAIL',          'Показване на e-mail адрес');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCITY',           'Показване на \'Град\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCOUNTRY',        'Показване на \'Държава\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWURL',            'Показване на \'Интернет страница\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWOCCUPATION',     'Показване на \'работа\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWHOBBIES',        'Показване на \'Хобита\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWYAHOO',          'Показване на \'Yahoo\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWAIM',            'Показване на \'AIM\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWJABBER',         'Показване на \'Jabber\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWICQ',            'Показване на \'ICQ\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWMSN',            'Показване на \'MSN\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSKYPE',          'Показване на \'Skype\'');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSTREET',         'Показване на \'Улица\'');

@define('PLUGIN_EVENT_USERPROFILES_SHOW',               'Потребителски профил');
@define('PLUGIN_EVENT_USERPROFILES_TITLE',              'Потребителски профили');
@define('PLUGIN_EVENT_USERPROFILES_DESC',               'Показва профил на автора с възможност за вграждане на негова снимка.');
@define('PLUGIN_EVENT_USERPROFILES_SELECT',             'Изберете автор за редактиране');
@define('PLUGIN_EVENT_USERPROFILES_VCARD',              'Създаване на VCard');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_AT',    'VCard е създадена в %s');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_NOTE',  'Можете да намерите създадената VCard в медийната библиотека (\'uploads/...\').');
@define('PLUGIN_EVENT_USERPROFILES_VCARDNOTCREATED',    'Невъзможност за създаване на VCard.');

@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION', 'Тип на снимката');
@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION_BLAHBLAH', 'Тип на файла, съдържащ снимката на автора на статията (jpg, png ...) ?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED', 'Снимка на автора в статиите ?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED_DESC', 'При избор \'Да\' снимка на автора ще бъде показвана в статиите, за да се вижда кой ги е писал. Файлът със снимката трябва да бъде записан в поддиректория \'img\' на избраната от вас тема (\'templates/your_template/img\') и трябва да бъде с име името на автора. Всички специални символи (кавички, интервали, ...) трябва да бъдат заменени с  \'_\' в името на файла.');

//
//  for serendipity_plugin_userprofiles.php
//
@define('PLUGIN_USERPROFILES_NAME',          "Авторите на този блог");
@define('PLUGIN_USERPROFILES_NAME_DESC',     "Показва списък на авторите, писали статии за този блог.");
@define('PLUGIN_USERPROFILES_TITLE',         "Заглавие");
@define('PLUGIN_USERPROFILES_TITLE_DESC',    "Въведете заглавието на страничната приставка, съдържаща списъка на авторите.");
@define('PLUGIN_USERPROFILES_TITLE_DEFAULT', "Автори");

@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT', 'Показване на броя на коментарите ?');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_BLAHBLAH', 'Можете да показвате броя на коментарите, които е направил посетителят, автор на текущия коментар. Това може да бъде забранено или числото да бъде добавено преди/след тялото на коментара. Можете също така да го поставите, където желаете вътре в коментара като редактирате вашия шаблон comments.tpl и поставите в него {$comment.plugin_commentcount} на място, което искате. Накрая, освен това можете да промените начина на извеждане чрез редактиране на CSS клас .serendipity_commentcount.');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_APPEND', 'След тялото на коментара');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_PREPEND', 'Преди тялото на коментара');        
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_SMARTY', '{$comment.plugin_commentcount}');        

@define('PLUGIN_USERPROFILES_GRAVATAR', 'Използване на Gravatar вместо локално изображение (avatar) ?');
@define('PLUGIN_USERPROFILES_GRAVATAR_DESC', 'Използва Gravatar (глобален avatar), асоцииран с вашия e-mail адрес. Трябва предварително да се регистрирате в http://www.gravatar.com');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE', 'Размер на изображението');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE_DESC', 'Размер на изображението', 'Установява размера на изображението в пиксели. Размерите по X и Y са еднакви, като максималната стойност е 80.');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING', 'Максимален рейтинг на Gravatar');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING_DESC','Установява максималния позволен рейтинг за Gravatars. G, PG, R или X.');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT', 'Място на Gravatar по подразбиране');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT_DESC', 'Указва мястото на картинката, която да се показва, когато потребителят не е избрал Gravatar за себе си.');

@define('PLUGIN_USERPROFILES_BIRTHDAYSNAME', 'Рожденни дни на потребителите');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE', 'Рожденни дни');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DESCRIPTION', 'Показва кога потребителите има рожденни дни');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DEFAULT', 'рожденни дни');

@define('PLUGIN_USERPROFILES_BIRTHDAYIN', 'Рожден ден след %d дни');
@define('PLUGIN_USERPROFILES_BIRTHDAYTODAY', 'Рожден ден днес');
