<?php # 

/**
 *  @version $Revision$
 *  @author Ivan Cenov JWalker@hotmail.bg
 *  EN-Revision: 1.23
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Маркиране на статии');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Позволява свободно маркиране на статиите');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Въведете маркери, подходящи за тази статия. Разделете маркерите със запетайка (,)');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Маркери, дефинирани към тази статия: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Статии, маркирани с \'%s\'');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Маркери, свързани с маркер \'%s\'');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED','Няма свързани маркери.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'Всички дефинирани маркери');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Управление на маркерите');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Управление на всички маркери');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', 'Управление на единични маркери');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Списък на немаркираните статии');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Списък на статии, маркирани с единични маркери');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Няма немарикирани статии!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Маркер');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Тегло');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Действие');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Преименоване');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Разделяне');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Изтриване');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Действително ли желаете да изтриете маркер \'%s\'?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'използвайте запетая за разделяне на маркерите:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Показване на облак с маркерите?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'Изпращане на X-FreeTag-HTTP-Headers');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST', 'Показване на списък с всички маркери при писане на статия');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT', 'Активиране на функцията "Намиране на маркери по време на писане"');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Маркери');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Показва списък на маркери към статиите');
@define('PLUGIN_FREETAG_NEWLINE', 'Всеки маркер на нов ред?');
@define('PLUGIN_FREETAG_XML', 'Показване на XML икони?');
@define('PLUGIN_FREETAG_SCALE','Мащабиране на големината на шрифта в зависимост от популярността на маркера (подобно на Technorati, flickr)?');
@define('PLUGIN_FREETAG_UPGRADE1_2','Обновяване на %d маркера за статия номер %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Колко маркера да бъдат показвани?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Минимален брой на използване на маркер, за да бъде показван?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Най-малък шрифт % за маркерите в облака');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Най-голям шрифт % за маркерите в облака');

@define('PLUGIN_EVENT_FREETAG_USE_FLASH', 'Използване на Flash за показване на облака от маркери?');
@define('PLUGIN_EVENT_FREETAG_FLASH_TAG_COLOR', 'Цвят на маркерите (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_TRANSPARENT', 'Прозрачен фон на облака?');
@define('PLUGIN_EVENT_FREETAG_FLASH_BG_COLOR', 'Цвят на фона на облака (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_WIDTH', 'Ширина на облака');
@define('PLUGIN_EVENT_FREETAG_FLASH_SPEED', 'Скорост на движение на облака');


@define('PLUGIN_FREETAG_META_KEYWORDS', 'Брой на мета-ключовите думи, които да се вграждат в HTML (0: забранено)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Статии с еднакви маркери:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','Показване на статиите с еднакви маркери?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','Колко статии с даден маркер да бъдат показвани?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Показване на маркерите след статиите?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Ако е позволено, маркерите ще се показват след статиите. Ако е забранено, маркерите ще бъдат поставяни в тялото на статиите (в началната или допълнителната част).');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Маркерите с малки букви');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Свързани маркери');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'Връзка');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'Създаване на маркери за всички асоциирани категории?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'Ако е позволено, всички категории, към които дадена статия е асоциирана ще бъдат добавени като маркери към статията. Можете да установите всички асоциации на категории за всички съществуващи статии през панел "Управление на маркерите" в административната страница.');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE', 'Шаблон за страничния панел');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION', 'Ако е установен, шаблонът се използва за изобразяване на маркерите в страничния панел. В шаблона има променлива <tags> която съдържа списъка на маркерите във формат <tagName> => array(href => <tagLink>, count => <tagCount>)');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', 'Преобразуване на всички асоциирани категории за съществуващи статии в маркери');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', 'Преобразувани категории за статия #%d (%s): %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'Всички категории са преобразувани в маркери.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Автоматични ключови думи');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'Можете да асоциирате ключови думи, разделени със \',\' за всеки маркер. Когато ключовите думи се използват в текста на статиите, съответните маркери се асоциират със статиите. Все пак да се има предвид, че твърде много ключови думи могат да увеличат времето за запис на статията.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'Намерена ключова дума <strong>%s</strong>, маркер <strong><em>%s</em></strong> е асоцииран автоматично.<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', 'Преглед на статии от %d до %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (общо %d статии)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'Преглед на следващия пакет статии...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Преизчисляване на всички ключови думи');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Внимание: Тази функция ще презапише всяка статия във вашия блог. Това ще отнеме известно време и е потенциално опасно за статиите. Моля първо направете резервно копие на базата данни. Натиснете \'CANCEL\', ако желаете да прекратите операцията.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', 'Име на маркер');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', 'Брой появи');

@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK',      'Technorati връзки');
@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK_DESC', 'Добавя Technorati връзки след маркерите в основата на статията. Натискането на тези маркери ще покаже подобни статии в други блогове, намерени в Technorati.');

@define('PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK_IMG',      'Изображение за Technorati връзка');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE',    'XML изображение (относително спрямо пътя до избраната тема на блога)');

@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2', 'При избор на \'Smarty\', ще бъде създадена \'Smarty\' променлива {$entry.freetag}, която можете да сложите навсякъде в файл entries.tpl.');
