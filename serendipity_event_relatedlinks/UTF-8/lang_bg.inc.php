<?php # 

/**
 *  @version 
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.3
 */

        @define('PLUGIN_EVENT_RELATEDLINKS_TITLE', 'Подобни статии/връзки');
        @define('PLUGIN_EVENT_RELATEDLINKS_DESC', 'Вмъква връзки към подобни (свързани с тази статия) други статии или WEB страници. За постигане на гъвкавост можете да редактирате файл "plugin_relatedlinks.tpl" (Smarty-Template), за да настроите как да изглежда статията. Забележка: Тази приставка извежда връзките само в детайлен / пълен вид на статията.');
        @define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC', 'Въведете връзките, които искате да се показват - по една връзка на ред, без HTML код (това означава връзките да са разделени с нов ред). Ако искате да въведете описание на връзката, използвайте следния формат: http://example.com/link.html=Примерна връзка. Всичко след "=" ще се използва като описание. Ако описание не бъде въведено, ще бъде показана самата връзка (URL адресът)');
        @define('PLUGIN_EVENT_RELATEDLINKS_LIST', 'Подобни статии/връзки :');

        @define('PLUGIN_EVENT_RELATEDLINKS_POSITION', 'Позиция на връзките');
        @define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC', 'Ако активирате Smarty templating, е необходимо са вмъкнете този ред във вашия entries.tpl шаблон вътре в цикъла foreach, където се установява променливата $entry. Това е например мястото, където коментарите и обратните проследявания се показват: {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}');
        @define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER', 'Постави под статията');
        @define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY', 'Постави в тялото на статията');
        @define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY', 'Активирай Smarty');

        @define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR', 'Символ разделител');
        @define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR_DESC', 'Въведете символ, който да раздели адреса на връзката и описанието й. Символът не трябва да присъства нито в адреса, нито в описанието. Подходящ символ е \'|\'.');
