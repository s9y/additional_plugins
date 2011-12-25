<?php # $Id$


@define('PLUGIN_EVENT_INCLUDEENTRY_NAME',     'Markup: Включване на статия/шаблон/блок в статия');
@define('PLUGIN_EVENT_INCLUDEENTRY_DESC',     'Тази приставка дава възможност за включване на елементи от статия в друга статия. Използвайте този код: [s9y-include-entry:XXX:YYY]. Заменете XXX идентификатора на статията (цяло число), а YYY с идентификатор на частта за включване (например "body", "title", "extended", ...). Освен това в административния панел е включено нова команда в менюто за поддръжка на шаблони (заготовки на статии) и блокове, които можете да включвате във Вашите статии.');
@define('PLUGIN_EVENT_INCLUDEENTRY_BLOCKS',   'Шаблони/Блокове');
@define('PLUGIN_EVENT_INCLUDEENTRY_DBVERSION', '1.0');
@define('PLUGIN_EVENT_INCLUDEENTRY_FILENAME_NAME', 'Шаблон (Smarty)');
@define('PLUGIN_EVENT_INCLUDEENTRY_FILENAME_DESC', 'Въведете името на файла, съдържащ Smarty шаблона, който трябва да бъде използван за тази страница. Файлът може да бъде поставен в директорията на тази приставка или в директорията за външния вид на блога (templates/your_selected_template).');
@define('STATICBLOCK_SELECT_TEMPLATES', 'Шаблони (заготовки) на статии');
@define('STATICBLOCK_SELECT_BLOCKS', 'Блокове');
@define('STATICBLOCK_EDIT_TEMPLATES', 'Редактиране на шаблон (заготовка) за статия');
@define('STATICBLOCK_EDIT_BLOCKS', 'Редактиране на блок');
@define('STATICBLOCK_USE', 'Нова статия от избрания шаблон');
@define('STATICBLOCK_ATTACH', 'Прикачане на статичен блок:');

@define('STATICBLOCK_RANDOMIZE', 'Показване на случайни блокове');
@define('STATICBLOCK_RANDOMIZE_DESC', 'Ако е позволено, ще бъдат включвани блокове между статиите по случаен признак.');
@define('STATICBLOCK_FIRST_SHOW', 'Първа статия');
@define('STATICBLOCK_FIRST_SHOW_DESC', 'Въведете броя на статиите, след които започва включването на случайно избрани блокове. "1" означава включване след първата статия, "2" след втората и така нататък.');
@define('STATICBLOCK_SHOW_SKIP', 'Стъпка (прескачане на статии');
@define('STATICBLOCK_SHOW_SKIP_DESC', 'Въведете броя на статии, които се прескачат преди да се включи следващият случаен блок. "1" ще включва блок след всяка статия, "2" след всяка втора и така нататък.');

@define('STATICBLOCK_SHOW_MULTI', 'Позволяване на повече блокове');
@define('STATICBLOCK_SHOW_MULTI_DESC', 'Ако сте прикачили статичен блок към дадена статия, да бъде ли позволено поставянето и на втори (случаен) блок след тази статия ? Ако установите "Не", статиите ще имат не повече от един блок.');
