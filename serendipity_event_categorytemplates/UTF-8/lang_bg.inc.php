<?php # 

/**
 *  @version $Revision$
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.4
 */

@define('PLUGIN_CATEGORYTEMPLATES_NAME', 'Свойства/шаблони за категории');
@define('PLUGIN_CATEGORYTEMPLATES_DESC', 'Тази приставка Ви позволява да сменяте шаблона и някои други свойства в зависимост от избраната катергория');
@define('PLUGIN_CATEGORYTEMPLATES_SELECT', 'Моля въведете име на папката на шаблона, който искате да използвате за тази категория. Относителните имена на папките започват под templates/ . Така например можете да използвате "blue" или "kubrick". Можете да въведете и име на под-папка, ако сте записали под-папката в template папката. В такъв случай можете да запишете например "blue/category1" или "blue/category2".');
@define('PLUGIN_CATEGORYTEMPLATES_FETCHLIMIT', 'Брой постинги за показване на една страница');
@define('PLUGIN_CATEGORYTEMPLATES_PASS', 'Защита с парола:');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_DESC', 'Да бъде позволена защита с пароли на категориите ? Защитата с пароли има някои недостатъци. Ще бъде извършван допълнителен достъп да базата данни и освен това статиите в защитените категории няма да бъдат показвани на предната страница за посетителите, докато те не влязат в защитената категория.');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_USER', 'Serendipity защита с парола на категориите');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY', 'Глобално установяване на категорията на избраната статия');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY_DESC', 'Ако е позволено, категорията на избраната статия ще бъде установена като текуща за целия блог.');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE', 'Приоритет на шаблоните на категориите');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE_DESC', 'Когато дадена статия е асоциирана с повече от една категории, този списък определя категорията, чийто шаблон ще се използва при визуализация на статията. Най-горната категория се взема предвид първа.');
@define('PLUGIN_CATEGORYTEMPLATES_NO_CUSTOMIZED_CATEGORIES', 'Все още няма категории със собствени шаблони.');
@define('PLUGIN_CATEGORYTEMPLATES_HIDERSS', 'Трябва ли статиите от тази категория да бъдат скрити от RSS емисиите?');
