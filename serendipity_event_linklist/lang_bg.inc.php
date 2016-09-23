<?php

/**
 *  @version 
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.8
 */

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKLIST_TITLE', 'Списък от връзки');
@define('PLUGIN_LINKLIST_DESC', 'Менажер на връзките - показва връзки към други сайтове в странична приставка.');
@define('PLUGIN_LINKLIST_LINK', 'Връзка');
@define('PLUGIN_LINKLIST_LINK_NAME', 'Име');
@define('PLUGIN_LINKLIST_ADMINLINK', 'Управление на връзките');
@define('PLUGIN_LINKLIST_ORDER', 'Подреждане на връзките');
@define('PLUGIN_LINKLIST_ORDER_DESC', 'Изберете как да се подредят връзките при извеждане в страничната приставка.');
@define('PLUGIN_LINKLIST_ORDER_NUM_ORDER', 'По избор');
@define('PLUGIN_LINKLIST_ORDER_DATE_ACS', 'Дата (от стари към нови)');
@define('PLUGIN_LINKLIST_ORDER_DATE_DESC', 'Дата (от нови към стари)');
@define('PLUGIN_LINKLIST_ORDER_CATEGORY', 'По категории');
@define('PLUGIN_LINKLIST_ORDER_ALPHA', 'Азбучно');
@define('PLUGIN_LINKLIST_LINKS', 'Manage Links');
@define('PLUGIN_LINKLIST_NOLINKS', 'No Links in List');
@define('PLUGIN_LINKLIST_CATEGORY', 'Use categories');
@define('PLUGIN_LINKLIST_CATEGORYDESC', 'Use categories to organize links.');
@define('PLUGIN_LINKLIST_ADDLINK', 'Добавяне на връзка');
@define('PLUGIN_LINKLIST_LINK_EXAMPLE', 'Пример: http://www.s9y.org или http://www.s9y.org/forums/');
@define('PLUGIN_LINKLIST_EDITLINK', 'Редактиране на връзка');
@define('PLUGIN_LINKLIST_LINKDESC', 'Описание на връзката');
@define('PLUGIN_LINKLIST_CATEGORY_NAME', 'Система от категории:');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DESC', 'Можете да изберете специфична за приставката система от категории или категориите на блога.');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM', 'Специфична');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT', 'От блога');
@define('PLUGIN_LINKLIST_ADD_CAT', 'Управление на категориите');
@define('PLUGIN_LINKLIST_CAT_NAME', 'Име на категорията');
@define('PLUGIN_LINKLIST_PARENT_CATEGORY', 'Родителска категория');
@define('PLUGIN_LINKLIST_ADMINCAT', 'Администриране на категориите');
@define('PLUGIN_LINKLIST_CACHE_NAME', 'Кеширане на страничната приставка');
@define('PLUGIN_LINKLIST_CACHE_DESC', 'Кеширането на страничната приставка увеличава скоростта на Вашата страница. Кеширането се обновява, когато се добавят връзки през административния интерфейс.');
@define('PLUGIN_LINKLIST_ENABLED_NAME', 'Enabled');
@define('PLUGIN_LINKLIST_ENABLED_DESC', 'Enable the plugin.');
@define('PLUGIN_LINKLIST_DELETE_WARN', 'Когато избраните категории се изтрият, връзките които те са съдържали отиват в коренната директория (на първо ниво).');

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKS_NAME', 'Списък от връзки');
@define('PLUGIN_LINKS_BLAHBLAH', 'Менажер на връзките - показва връзки към други сайтове в странична приставка чрез дървовидно меню.');
@define('PLUGIN_LINKS_TITLE', 'Име');
@define('PLUGIN_LINKS_TITLE_BLAHBLAH', 'Име на страничната приставка, съдържаща дървото на връзките.');
@define('PLUGIN_LINKS_TOP_LEVEL', 'Текст за най-горното ниво');
@define('PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH', 'Въведете текст, който да се появява на най-горното ниво (може да бъде оставено празно).');
@define('PLUGIN_LINKS_DIRECTXML', 'Директно въвеждане на XML');
@define('PLUGIN_LINKS_DIRECTXML_BLAHBLAH', 'Връзките се въвеждат в XML формат. Можете да направите това тук директно или да използвате административния интерфейс.');
@define('PLUGIN_LINKS_LINKS', 'Връзки');
@define('PLUGIN_LINKS_LINKS_BLAHBLAH', 'Описание на дървото на връзките. Използвайте XML: за директории - "<dir name="dirname"> ... </dir>; за връзки - "<link name="linkname" link="http://link.com/" />');
@define('PLUGIN_LINKS_OPENALL', 'Текст за отваряне на всички');
@define('PLUGIN_LINKS_OPENALL_BLAHBLAH', 'Въведете текст за връзката, с която се отварят всички връзки в дървото.');
@define('PLUGIN_LINKS_OPENALL_DEFAULT', 'Отвори всички');
@define('PLUGIN_LINKS_CLOSEALL', 'Текст за затваряне на всички');
@define('PLUGIN_LINKS_CLOSEALL_BLAHBLAH', 'Въведете текст за връзката, с която се затварят всички връзки в дървото.');
@define('PLUGIN_LINKS_CLOSEALL_DEFAULT', 'Затвори всички');
@define('PLUGIN_LINKS_SHOW', 'Показване на Отвори и Затвори всички');
@define('PLUGIN_LINKS_SHOW_BLAHBLAH', 'Да се показват ли връзките за отваряне и затваряне на цялото дърво ?');
@define('PLUGIN_LINKS_LOCATION', 'Позиция на Отвори и Затвори всички');
@define('PLUGIN_LINKS_LOCATION_BLAHBLAH', 'Позиция на връзките \'Отвори всички\' и \'Затвори всички\'.');
@define('PLUGIN_LINKS_LOCATION_TOP', 'Горе');
@define('PLUGIN_LINKS_LOCATION_BOTTOM', 'Долу');
@define('PLUGIN_LINKS_SELECTION', 'Избор на директориите');
@define('PLUGIN_LINKS_SELECTION_BLAHBLAH', 'Избор \'Да\' означава, че имената на директориите могат да бъдат избирани (ще бъдат връзки, които отварят директориите).');
@define('PLUGIN_LINKS_COOKIE', 'Използване на куки');
@define('PLUGIN_LINKS_COOKIE_BLAHBLAH', 'Избор \'Да\' означава, че дървото на връзките използва куки, за да запомни състоянието си.');
@define('PLUGIN_LINKS_LINE', 'Използване на линии');
@define('PLUGIN_LINKS_LINE_BLAHBLAH', 'Избор \'Да\' означава, че за изобразяването на дървото се използват линии.');
@define('PLUGIN_LINKS_ICON', 'Използване на икони');
@define('PLUGIN_LINKS_ICON_BLAHBLAH', 'Избор \'Да\' означава, че за изобразяването на дървото се използват икони.');
@define('PLUGIN_LINKS_STATUS', 'Текст на статус реда');
@define('PLUGIN_LINKS_STATUS_BLAHBLAH', 'Избор \'Да\' означава, че на статус реда на браузъра се изписват имената на връзките вместо URL, към който сочат.');
@define('PLUGIN_LINKS_CLOSELEVEL', 'Затваряне на същото ниво');
@define('PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH', 'Избор \'Да\' означава, че само една поддиректория в избраната директория може да бъде отворена. В този случай връзките \'Отвори всички\' и \'Затвори всички\' не работят.');
@define('PLUGIN_LINKS_TARGET', 'Прозорец на връзката');
@define('PLUGIN_LINKS_TARGET_BLAHBLAH', 'Прозорец, в който да се отварят връзките - може да бъде "_blank", "_self", "_top", "_parent" или име на рамка (frame).');
@define('PLUGIN_LINKS_IMGDIR', 'Директория за картинките на дървото');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'Избор \'Да\' означава, че приставката ще използва картинките от собствената си директория \'img\'. При избор \'Не\' приставката ще търси картинките в \'/templates/default/img/\'. Също така, избор \'Не\' е необходим при използване на много блогове (shared install), но тогава картинките трябва да бъдат преместени в \'/templates/default/img/\' ръчно.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME', 'Състояние на дървото с категориите на връзките');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_DESC', 'Когато използвате подреждане по \'категории\', можете да изберете дали то да бъде отворено или затворено първоначално.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_CLOSED', 'Затворено');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_OPEN', 'Отворено');
@define('PLUGIN_LINKLIST_OUTSTYLE_DTREE', 'dtree');
@define('PLUGIN_LINKLIST_OUTSTYLE_CSS', 'CSS списък');
@define('PLUGIN_LINKLIST_ORDER_OUTSTYLE_SIMP_CSS', 'Ограничен CSS стил');
@define('PLUGIN_LINKS_OUTSTYLE', 'Изберете стила на списъка');
@define('PLUGIN_LINKS_OUTSTYLE_BLAHBLAH', 'Изберете стил за списъка с връзки.  Dtree използва JavaScript, за да възпроизведе дървовиден изглед на списъка. Вариант CSS използва CSS divs и ограничен JavaScript, за да наподоби dtree, но не поддържа всички негови функции. Ограниченият CSS ще произведе прост CSS контролиран списък, което позволява силен контрол над представянето на списъка. Dtree обикновено не е откриваемо от търсещите машини.');
@define('PLUGIN_LINKS_CALLMARKUP', 'Прилагане на форматиране ?');
@define('PLUGIN_LINKS_CALLMARKUP_BLAHBLAH', 'Изберете дали да приложите форматиране на изхода от приставката.');
@define('PLUGIN_LINKS_USEDESC', 'Използване на даденото описание');
@define('PLUGIN_LINKS_USEDESC_BLAHBLAH', 'Използване на описанието на заглавието на връзката, ако има такова.');
@define('PLUGIN_LINKS_PREPEND', 'Въведете текст, който да бъде показван преди списъка на връзките.');
@define('PLUGIN_LINKS_APPEND', 'Въведете текст, който да бъде показван след списъка на връзките.');

