<?php # 

/**
 *  @version 
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.5
 */

@define('PLUGIN_EVENT_ENTRYCHECK_TITLE', 'Правила за публикуване на статии');
@define('PLUGIN_EVENT_ENTRYCHECK_DESC', 'Прилага няколко проверки на статията преди тя да бъде публикувана');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES', 'Статия без категория ?');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_DESC', 'Ако е установено на true, статията трябва да има поне една асоциирана категория към себе си');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_WARNING', 'Публикуването на статия без асоциирана категория към нея не е позволено. Моля установете подходяща асоциация и запишете статията отново.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE', 'Статия без заглавие ?');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_DESC', 'Ако е установено на true, статията трябва да има заглавие');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_WARNING', 'Публикуването на статията без заглавие не е позволено. Моля въведете заглавие и запишете статията отново.');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT', 'Категория по подразбиране');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT_DESC', 'В случай, че авторът не е избрал категория, по подразбиране статията се асоциира с тази категория.');

@define('PLUGIN_EVENT_ENTRYCHECK_LOCKED', 'Тази статия е заключена за редактиране от %s на %s');
@define('PLUGIN_EVENT_ENTRYCHECK_UNLOCK', 'Отключване на статията');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCK_WARNING', 'Тази статия е заключена и може да бъде записвана само от собственика на ключа, ако не я отключите.');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCKING', 'Разрешаване на заключването на статии ?');
