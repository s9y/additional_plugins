<?php # 

/**
 *  @version 
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.11
 */

//
//  serendipity_event_staticpage.php
//
@define('STATICPAGE_HEADLINE', 'Заглавие');
@define('STATICPAGE_HEADLINE_BLAHBLAH', 'Заглавие, което се показва над съдържанието и е форматирано като всяко друго заглавие в блога.');
@define('STATICPAGE_TITLE', 'Статични страници');
@define('STATICPAGE_TITLE_BLAHBLAH', 'Показва статични страници във вашия блог използвайки общия дизайн на блога. Добавя нова команда към административното меню.');
@define('CONTENT_BLAHBLAH', '');
@define('STATICPAGE_PERMALINK', 'Permalink (константна връзка)');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'Дефинира permalink за URL. Трябва да бъде абсолютен HTTP път и да завършва с \'.htm\' or \'.html\' !');
@define('STATICPAGE_PAGETITLE', 'Късо име на URL (съвместимост назад)');
@define('STATICPAGE_ARTICLEFORMAT', 'Форматиране като статия ?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', 'При избор \'Да\' страницата автоматично ще бъде форматирана като статия (цветове, граници, шрифтове и т.н.), по подразбиране: \'Да\'.');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', 'Заглавие на страницата, когато е форматирана като статия');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'При използване на формат като статия, можете да изберете какъв текст да се показва, където се показва датата над статиите за един ден.');
@define('STATICPAGE_SELECT', 'Изберете страница за редактиране или \'Нова\' за създаване на нова страница.');
@define('STATICPAGE_PASSWORD_NOTICE', 'Разглеждането на тази страница изисква въвеждането на парола. Въведете я тук. ');
@define('STATICPAGE_PARENTPAGES_NAME', 'Родителска страница');
@define('STATICPAGE_PARENTPAGE_DESC', 'Изберете родителска страница за тази страница');
@define('STATICPAGE_PARENTPAGE_PARENT', 'Това е родителска страница');
@define('STATICPAGE_AUTHORS_NAME', 'Име на автора');
@define('STATICPAGE_AUTHORS_DESC', 'Този автор е собственик на страницата');
@define('STATICPAGE_FILENAME_NAME', 'Smarty шаблон за страницата');
@define('STATICPAGE_FILENAME_DESC', 'Име на файла - Smarty шаблон, който ще се използва за тази страница. Този файл може да бъде поставен в директорията на тази приставка или в директорията на избраната от вас тема (templates/your_theme).');
@define('STATICPAGE_SHOWCHILDPAGES_NAME', 'Показване на страници деца');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', 'Показване на страниците-деца в списък от връзки.');
@define('STATICPAGE_PRECONTENT_NAME', 'Предварително съдържание');
@define('STATICPAGE_PRECONTENT_DESC', 'Това съдържание се показва преди списъка на страниците деца.');
@define('STATICPAGE_CANNOTDELETE_MSG', 'Тази страница не може да бъде изтрита, защото тя има страници деца. Първо трябва да изтриете тях.');
@define('STATICPAGE_IS_STARTPAGE', 'Тази страница да бъде главна страница на блога (на сайта)');
@define('STATICPAGE_IS_STARTPAGE_DESC', 'Вместо да се показва подразбиращата се лицева страница (със статиите) да се показва тази страница. Ако желаете връзка към обичайната лицева страница, използвайте \'index.php?frontpage\'.');
@define('STATICPAGE_TOP', 'Горе');
@define('STATICPAGE_NEXT', 'Следваща');
@define('STATICPAGE_PREV', 'Предишна');
@define('STATICPAGE_LINKNAME', 'Редактиране');

@define('STATICPAGE_ARTICLETYPE', 'Тип на страницата');
@define('STATICPAGE_ARTICLETYPE_DESC', 'Изберете вида на страницата.');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'Подреждане');
@define('STATICPAGE_CATEGORY_PAGES', 'Редактиране');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'Типове страници');
@define('STATICPAGE_CATEGORY_PAGEADD', 'Други приставки');

@define('PAGETYPES_SELECT', 'Изберете тип на страницата.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', 'Описание');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'Кратко описание на този тип страници - какво съдържат, предназначение. Можете да регистрирате няколко типа страници според необходимостта.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'Smarty шаблон за страницата');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', 'Име на файла - Smarty шаблон, който ще се използва за тази страница. Този файл може да бъде поставен в директорията на тази приставка или в директорията на избраната от вас тема (\'templates/your_theme\').');
@define('STATICPAGE_ARTICLETYPE_IMAGE', 'Път до картинката на типа');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', ' Можете да укажете графично изображение, което да бъде свързано с този тип. Това изображение ще се показва на всички страници от този тип. Така посетителят ще може по-лесно да се ориентира в съдържанието на Вашия сайт. Тук е необходим пълен път до файла.');

@define('STATICPAGE_SHOWNAVI', 'Показване на навигация');
@define('STATICPAGE_SHOWNAVI_DESC', 'Показване на навигационни връзки в страницата.');
@define('STATICPAGE_SHOWONNAVI', 'Показване в страничната приставка');
@define('STATICPAGE_SHOWONNAVI_DESC', 'Показване на връзка към страницата в навигацията в страничната приставка.');

@define('STATICPAGE_SHOWNAVI_DEFAULT', 'Показване на навигация в странична приставка');
@define('STATICPAGE_DEFAULT_DESC', 'Подразбираща се стойност за нови страници.');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', 'Показване на страницата при навигация в странична приставка');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', 'Показване на маркап');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', 'Форматиране като статия');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', 'Показване на страници деца (не само родителските)');

@define('STATICPAGE_PAGEORDER_DESC', 'Подреждане на статичните страници');
@define('STATICPAGE_PAGEADD_DESC', 'Избор на приставки, които да бъдат включени като връзки в навигацията на статичните страници');
@define('STATICPAGE_PAGEADD_PLUGINS', 'Следващите приставки могат да бъдат включени в страничната приставка на статичните страници:');

@define('STATICPAGE_PUBLISHSTATUS', 'Състояние');
@define('STATICPAGE_PUBLISHSTATUS_DESC', 'Степен на готовност на страницата.');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', 'Показване на заглавията или \'предишна\'/\'следваща\' при навигацията');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', 'Предишна/Следваща');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', 'Заглавие');

@define('STATICPAGE_LANGUAGE', 'Език');
@define('STATICPAGE_LANGUAGE_DESC', 'Определете езика на тази страница.');

@define('STATICPAGE_PLUGINS_INSTALLED', 'Приставката е инсталирана');
@define('STATICPAGE_PLUGIN_AVAILABLE', 'Приставката е налична, но не е инсталирана');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE', 'Приставката не е налична');

@define('STATICPAGE_SEARCHRESULTS', 'Намерени са %d статични страници:');

@define('LANG_ALL', 'Всички езици');
@define('LANG_EN', 'English');
@define('LANG_DE', 'German');
@define('LANG_DA', 'Danish');
@define('LANG_ES', 'Spanish');
@define('LANG_FR', 'French');
@define('LANG_FI', 'Finnish');
@define('LANG_CS', 'Czech (Win-1250)');
@define('LANG_CZ', 'Czech (ISO-8859-2)');
@define('LANG_NL', 'Dutch');
@define('LANG_IS', 'Icelandic');
@define('LANG_PT', 'Portuguese Brazilian');
@define('LANG_BG', 'Bulgarian');
@define('LANG_NO', 'Norwegian');
@define('LANG_RO', 'Romanian');
@define('LANG_IT', 'Italian');
@define('LANG_RU', 'Russian');
@define('LANG_FA', 'Persian');
@define('LANG_TW', 'Traditional Chinese (Big5)');
@define('LANG_TN', 'Traditional Chinese (UTF-8)');
@define('LANG_ZH', 'Simplified Chinese (GB2312)');
@define('LANG_CN', 'Simplified Chinese (UTF-8)');
@define('LANG_JA', 'Japanese');
@define('LANG_KO', 'Korean');

@define('STATICPAGE_STATUS', 'Състояние');

//
//  serendipity_plugin_staticpage.php
//

@define('PLUGIN_STATICPAGELIST_NAME',                   'Статични страници - списък');
@define('PLUGIN_STATICPAGELIST_NAME_DESC',              'Тази приставка показва конфигурируем списък от статични страници.');
@define('PLUGIN_STATICPAGELIST_TITLE',                  'Заглавие');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',             'Заглавие на страничната приставка');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',          'Статични страници');
@define('PLUGIN_STATICPAGELIST_LIMIT',                  'Брой страници');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',             'Колко връзки към статични страници да се показват. 0 означава без ограничение.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',         'Връзка към лицевата страница');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',         'Да има ли връзка към лицевата страница (със статиите) ?');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME',     'Заглавна страница');
@define('PLUGIN_LINKS_IMGDIR',                          'Директория с картинки за формиране на дървото');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',                 'Пълен URL до картинките, формиращи дървовидната структура. Директория \'img\' трябва да се намира в тази директория (тя е част от тази приставка).');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME',         'Графика или само текст');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC',         'Връзките да се показват в дървовидна структура или само като текст.');
@define('PLUGIN_STATICPAGELIST_ICON',                   'Дърво');
@define('PLUGIN_STATICPAGELIST_TEXT',                   'Текст');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY',            'Само родителски страници ?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC',       'При избор \'Да\' само родителските страници се показват. При избор \'Не\' се виждат всички страници.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME',               'Използване на графика в дървовидната структура');

@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRIES',      'URL на преместената директория е сменен в %s статични страници.'); 

@define('STATICPAGE_QUICKSEARCH_DESC', 'Ако е разрешено, бързото търсене ще работи и в статичните страници.');

@define('STATICPAGE_CATEGORYPAGE','свързана статична страница');
@define('STATICPAGE_RELATED_CATEGORY', 'свързана категория');
@define('STATICPAGE_RELATED_CATEGORY_DESCRIPTION', 'Извеждане на статиите от тази категория или поставяне на връзка към категорията на статичната страница. Използвайте "plugin_staticpage_related_category.tpl" за тази възможност.');

@define('STATICPAGE_ARTICLE_OVERVIEW','Преглед на страницата');
@define('STATICPAGE_NEW_HEADLINES','Най-нови статии:');

@define('STATICPAGE_TEMPLATE','Шаблон за редактиране');
@define('STATICPAGE_TEMPLATE_INTERNAL','Всички полета');
@define('STATICPAGE_TEMPLATE_EXTERNAL', 'Кратък шаблон');

@define('STATICPAGE_SECTION_META', 'Мета-данни');
@define('STATICPAGE_SECTION_BASIC', 'Основно съдържание');
@define('STATICPAGE_SECTION_OPT', 'Опции');
@define('STATICPAGE_SECTION_STRUCT', 'Структурирано');
