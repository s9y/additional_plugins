<?php # $Id: lang_bg.inc.php,v 1.3 2006/08/18 08:06:51 jwalker_bg Exp $

/**
 *  @version $Revision: 1.3 $
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.2
 */

    @define('PLUGIN_EVENT_FORGOTPASSWORD_NAME', 'Забравена парола');
    @define('PLUGIN_EVENT_FORGOTPASSWORD_DESC', 'Сменя паролата на избран потребител');
    @define('PLUGIN_EVENT_FORGOTPASSWORD_LOST_PASSWORD', 'Забравена парола ?');
    @define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_USERNAME', 'Въведете потребителското име, на което сте забравили паролата');
    @define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_PASSWORD', 'Въведете новата парола');
    @define('PLUGIN_EVENT_FORGOTPASSWORD_SEND_EMAIL', 'Изпращане на e-mail');
    @define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SUBJECT', 'Забравена парола');
    @define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_BODY', "Някой (може би вие) иска да промени вашата парола,\nако вие искате да промените паролата си, изберете следващата връзка:\n");
    @define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR', 'Няма връзка с базата данни.');
    @define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_CANNOT_SEND', "Невъзможност за смяна на паролата, може би поради неправилна конфигурация на SMTP в php.ini<br />\nили поради това, че сте дали невалиден e-mail адрес във вашия профил.");
    @define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SENT', 'Току що беше изпратен e-mail на адреса във вашия профил. Проверете вашата пощенска кутия.');
    @define('PLUGIN_EVENT_FORGOTPASSWORD_CHANGE_PASSWORD', 'Смяна на парола');
    @define('PLUGIN_EVENT_FORGOTPASSWORD_PASSWORD_CHANGED', 'Паролата е сменена успешно.');
    @define('PLUGIN_EVENT_FORGOTPASSWORD_USER_NOT_EXIST', 'Потребителското име не съществува в базата данни. Върнете на предишната страница и опитайте отново.');
