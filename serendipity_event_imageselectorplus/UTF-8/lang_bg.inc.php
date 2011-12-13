<?php # $Id: lang_bg.inc.php,v 1.1 2008/04/14 10:14:09 jwalker_bg Exp $

/**
 *  @version $Revision: 1.1 $
 *  @author Ivan Cenov <JWalker@hotmail.bg>
 *  EN-Revision: 1.7
  */

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_NAME',                      'Допълнителни опции за медийния менажер');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_DESC',                      'Дава допълнителни опции при вмъкване на изображения чрез медийния менажер [Serendipity >= 0.9]');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET',                    'Цел (URL) на тази връзка');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_JS',                 'Изскачаш прозорец (през JavaScript, с големина която се адаптира)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_ENTRY',              'Изолирана статия');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_BLANK',              'Изскачаш прозорец (via target=_blank)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG',                 'QuickBlog');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG_DESC',            'Ако въведете поне заглавие в следващите полета, изображението ще бъде записано веднага като нова статия в блога. Дизайнът може да бъде променен във файл quickblog.tpl.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXWIDTH',                  'Максимална ширина на миниатюрата (не взема предвид височината)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXHEIGHT',                 'Максимална височина на миниатюрата (не взема предвид ширината)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE',                'Динамично преоразмерява изображенията в зависимост от атрибутите за ширина и височина');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE_DESC',           'Автоматично изпраща преоразмерени версии на изображенията към клиента в зависимост от атрибутите за широчина и височина, указани в IMG tag. Това ви улеснява и намалява времето за изтегляне, но намалява ефективността на сървъра. (Забележка: Отношението между ширина и височина се поддържа).');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES',               'Разхивиране на ZIP архивите');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_BLABLAH',       'Разархивиране на качените ZIP архиви? - подразбираща се стойност за диалога в страницата за качване на изображения.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_DESC',          'Разархивиране на качените ZIP архиви?');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_OK',                  'ZIP архивът е разархивиран успешно');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FAILED',              'ZIP архивът не беше разрхивиран поради някаква грешка');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_IMAGE_FROM_ARCHIVE',  'Изображението от ZIP архива');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_ADD_TO_DB',           'добавено към базата данни');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD',                     'Използване на jhead за извличане на EXIF данни');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD_DESC',                'Отмяна на поведението по подразбиране и използване на външни повиквания на jhead за получаване на EXIF данни. Изберете тази опция само, ако jhead е иснталирано и може да бъде изпълнявано.'); 
