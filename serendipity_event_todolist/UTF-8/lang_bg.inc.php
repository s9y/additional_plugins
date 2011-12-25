<?php # $Id$ #

/*
 * Bulgarian Translation version 1.0
 * @author Ivan Cenov jwalker@hotmail.bg
 * EN-Revision: 1.2
 */

	@define('PLUGIN_EVENT_TODOLIST_TITLE', 'Задачи/Проекти');
	@define('PLUGIN_EVENT_TODOLIST_DESC', 'Поддържа списък от проекти и степента на изпълнението им.');
	@define('PLUGIN_EVENT_TODOLIST_PROJECT', 'Проект');
	@define('PLUGIN_EVENT_TODOLIST_PROJECT_NAME', 'Име');
	@define('PLUGIN_EVENT_TODOLIST_HIDDEN', 'Скрит');
	@define('PLUGIN_EVENT_TODOLIST_PERCENTDONE', '% Готов');
	@define('PLUGIN_EVENT_TODOLIST_BLOGENTRY', 'Блог статия');
	@define('PLUGIN_EVENT_TODOLIST_ADMINPROJECT', 'Управление на проектите');
	@define('PLUGIN_EVENT_TODOLIST_ORDER', 'Подреждане на проектите по:');
	@define('PLUGIN_EVENT_TODOLIST_ORDER_DESC', 'Изберете как да подредите проектите при извеждането им на екрана.');
	@define('PLUGIN_EVENT_TODOLIST_ORDER_NUM_ORDER', 'Произволно');
	@define('PLUGIN_EVENT_TODOLIST_ORDER_DATE_ACS', 'Дата (От стар към нов)');
	@define('PLUGIN_EVENT_TODOLIST_ORDER_DATE_DESC', 'Дата (От нов към стар)');
	@define('PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_ASC', 'Прогрес (най-малко изпълнените отгоре)');
	@define('PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_DESC', 'Прогрес (най-много завършените отгоре)');
	@define('PLUGIN_EVENT_TODOLIST_ORDER_CATEGORY', 'По категория');
	@define('PLUGIN_EVENT_TODOLIST_ORDER_JSCATEGORY', 'По категория с Javascript');
	@define('PLUGIN_EVENT_TODOLIST_ORDER_ALPHA', 'Азбучно');
	@define('PLUGIN_EVENT_TODOLIST_PROJECTS', 'Управление на проектите');
	@define('PLUGIN_EVENT_TODOLIST_NOPROJECTS', 'Няма проекти в списъка');
	@define('PLUGIN_EVENT_TODOLIST_TITLEDESC','Заглавието на плъгин-а. Стойността се праща на страничния плъгин.');
	@define('PLUGIN_EVENT_TODOLIST_COLOR1', 'Вътрешен цвят');
	@define('PLUGIN_EVENT_TODOLIST_COLOR2', 'Външен цвят');
	@define('PLUGIN_EVENT_TODOLIST_COLORCONFIG', 'Цвят на прогрес-бара по подразбиране');
	@define('PLUGIN_EVENT_TODOLIST_COLORCONFIGDESC', 'Изберете цвят на прогрес-бара.  Можете да добавяте или модифицирате тези цветове от страница "Управление на цветовете". Това ще бъде активно, само ако имате инсталирани библиотеките PHP GD.');
	@define('PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLOR', 'Фонов цвят за прогрес-бара');
	@define('PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLORDESC', 'Въведете шест-цифрен шестнадесетичен код на цвета за фона на прогрес-бара.  Използвайте FFFFFF за бяло.  Това ще бъде активно, само ако имате инсталирани библиотеките PHP GD.');
	@define('PLUGIN_EVENT_TODOLIST_WHITETEXTBORDER', 'Граници на символите в бяло');
	@define('PLUGIN_EVENT_TODOLIST_WHITETEXTBORDERDESC', 'Може да решите текстът в прогрес-бара да бъде заобиколен с бяло, ако цветът на прогрес-бара е тъмен. Така ще направите текста по-лесно четим');
	@define('PLUGIN_EVENT_TODOLIST_OUTSIDETEXT', 'Поставяне на текста извън прогрес бара.');
	@define('PLUGIN_EVENT_TODOLIST_OUTSIDETEXTDESC', 'При отговор "Да" процентът на изпълнение ще бъде записан отстрани на прогрес-бара вместо в средата му.');
	@define('PLUGIN_EVENT_TODOLIST_BARLENGTH', 'Дължина на прогрес-бара');
	@define('PLUGIN_EVENT_TODOLIST_BARLENGTHDESC', 'Дължина на прогрес-бара в пиксели когато прогрес-баровете не са  сортирани по категория. Тази опция изисква GD библиотеки.');
	@define('PLUGIN_EVENT_TODOLIST_BARHEIGHT', 'Височина на прогрес-бара');
	@define('PLUGIN_EVENT_TODOLIST_BARHEIGHTDESC', 'Височина на прогрес-бара в пиксели.  Тази опция изисква GD библиотеки.');
	@define('PLUGIN_EVENT_TODOLIST_FONTSIZE', 'Големина на шрифта');
	@define('PLUGIN_EVENT_TODOLIST_FONTSIZEDESC', 'Големина на шрифта в пиксели. Тази опция изисква GD библиотеки.');
	@define('PLUGIN_EVENT_TODOLIST_FONT', 'Шрифт');
	@define('PLUGIN_EVENT_TODOLIST_FONTDESC', 'Изберете шрифт за прогрес-бара. Можете да добавите допълнителни шрифтове в папка '.dirname(__FILE__).'/fonts/.  Шрифтовете трябва да бъдат TrueType. Тази опция изисква GD библиотеки.');
	@define('PLUGIN_EVENT_TODOLIST_CATBARLENGTH', 'Дължина на прогрес-бара при сортиране по категории');
	@define('PLUGIN_EVENT_TODOLIST_CATBARLENGTHDESC', 'Дължина на прогрес-бара в пиксели когато прогрес-баровете са сортирани по категории. Може да поискате тази стойност да бъде по-малка понеже структурата на категориите отнема място на екрана. Тази опция изисква GD библиотеки.');
	@define('PLUGIN_EVENT_TODOLIST_CACHEIMAGE', 'Кеширане на генерираните графики');
	@define('PLUGIN_EVENT_TODOLIST_CACHEIMAGEDESC', 'Кеширане на копие от всички генерирани графики и доставянето им статично. Като резултат се постига по-бързо зареждане на страниците и по-малко натоварване на сървъра. Тази опция изисква GD библиотеки.');
	@define('PLUGIN_EVENT_TODOLIST_NUMENTRIES', 'Брой на блог статиите за показване');
	@define('PLUGIN_EVENT_TODOLIST_NUMENTRIESDESC', 'Указва колко статии да се показват в списъка при избор на статия, който да се свърже към проекта. Избират се последните (най-скорошни) статии.');
	@define('PLUGIN_EVENT_TODOLIST_CATEGORY', 'Използване на категории');
	@define('PLUGIN_EVENT_TODOLIST_CATEGORYDESC','Използване на категории за организиране на проектите.');
	@define('PLUGIN_EVENT_TODOLIST_ADDPROJECT','Добавяне на проект');
	@define('PLUGIN_EVENT_TODOLIST_EDITPROJECT','Редактиране на проект');
	@define('PLUGIN_EVENT_TODOLIST_PERCENTAGECOMPLETE','Процент на изпълнение на проекта');
	@define('PLUGIN_EVENT_TODOLIST_PROJECTDESC','Описание на проекта');
	@define('PLUGIN_EVENT_TODOLIST_DEFAULT_NOTE','Моля да отбележите, че този плъгин е event-плъгин, и трябва да използвате или Event Output Wrapper или модифициран страничен панел.');
	@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME','Система на категории:');
	@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DESC','Можете да използвате категории специално за проектите, които да създадете в този плъгин или системата от категории на блога.');
	@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_CUSTOM','Специални');
	@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DEFAULT','От блога');
	@define('PLUGIN_EVENT_TODOLIST_CATDB_WARNING','Вие избрахте специални категории, но в базата данни не съществува таблица с категории. Моля чукнете тук за да бъде създадена таблицата.');
	@define('PLUGIN_EVENT_TODOLIST_ADD_CAT','Управление на категориите');
	@define('PLUGIN_EVENT_TODOLIST_ADD_COLOR','Добавяне на цвят');
	@define('PLUGIN_EVENT_TODOLIST_MANAGE_COLORS','Управление на цветовете');
	@define('PLUGIN_EVENT_TODOLIST_CAT_NAME','Име на категорията');
	@define('PLUGIN_EVENT_TODOLIST_PARENT_CATEGORY','Родителската категория');
	@define('PLUGIN_EVENT_TODOLIST_ADMINCAT','Администриране на категориите');
	@define('PLUGIN_EVENT_TODOLIST_CACHE_NAME','Кеширане на страничния панел');
	@define('PLUGIN_EVENT_TODOLIST_CACHE_DESC','Кеширане на резултатите в страничния панел увеличава скоростта на показване на страницата.');
	@define('PLUGIN_EVENT_TODOLIST_NOGDLIB', 'Изглежда не PHP GD библиотеките не са инсталирани. Предвидени са статични изображения през 5%, така че нивото на изпълнение на проектите ще бъде закръглено надолу до най-близката 5% марка.');
	@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_NAME', 'Име на цвета (използва в списъка за избор на цвят)');
	@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR1', 'Цвят в средата на прогрес-бара (шестнадесетичено число подобно на ff3333).  Вероятно ще предпочетете по-светъл цвят за вътрешността на прогрес-бара.');
	@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR2', 'Цвят на периферията на прогрес-бара (шестнадесетичено число подобно на ff3333)');
	@define('PLUGIN_EVENT_TODOLIST_COLOR', 'Цвят');
	@define('PLUGIN_EVENT_TODOLIST_SAMPLE', 'Пример');
	@define('PLUGIN_EVENT_TODOLIST_COLORWHEEL', 'Цветно колело');
	@define('PLUGIN_EVENT_TODOLIST_COLORWHEEL_INSTRUCTIONS', 'Поставете мишката върху избрания цвят в колелото или квадрата. Чукнете да изберете цета. Копирайте и поставете кодовете в страницата за управление на цветовете.');
