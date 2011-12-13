<?php # $Id: lang_bg.inc.php,v 1.4 2006/08/18 09:30:23 jwalker_bg Exp $

/**
 *  @version $Revision: 1.4 $
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.1
 */

    @define('PLUGIN_SIDEBAR_WEATHER_NAME', 'Времето');
    @define('PLUGIN_SIDEBAR_WEATHER_DESC', 'Показва състоянието на времето като странична приставка.');
    @define('PLUGIN_SIDEBAR_WEATHER_TITLE', 'Име');
    @define('PLUGIN_SIDEBAR_WEATHER_TITLE_BLAHBLAH', 'Име в страничната приставка');
    @define('PLUGIN_SIDEBAR_WEATHER_METAR', 'METAR код на място' );
    @define('PLUGIN_SIDEBAR_WEATHER_METAR_BLAHBLAH', 'Някои кодове на български места са София: LBSF, Варна: LBWN, Бургас: LBBG, Пловдив: LBPD, Горна Оряховица: LBGO. Други METAR кодове на местата можете да намерите в http://weather.noaa.gov/');
    @define('PLUGIN_SIDEBAR_WEATHER_TIMEZONE', 'Вашата времева зона');
    @define('PLUGIN_SIDEBAR_WEATHER_TIMEZONE_BLAHBLAH', 'Времевата зона трябва да е относително GMT (за България +2 зимно и +3 лятно време)');
    @define('PLUGIN_SIDEBAR_WEATHER_UNITS','Мерни единици');
    @define('PLUGIN_SIDEBAR_WEATHER_UNITS_BLAHBLAH','Изберете системата на мерните единици за показване на величините');
    @define('PLUGIN_SIDEBAR_WEATHER_UNITS_NAME_METRIC', 'Метрична');
    @define('PLUGIN_SIDEBAR_WEATHER_UNITS_NAME_IMPERIAL', 'Английска/US стандартна');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_UPDATE', 'Последно обновяване:');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_WINDDIRECTION', 'Посока на вятъра:');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_VISIBILITY', 'Видимост:');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_CLOUDS_AMOUNT', 'Количество облаци:');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_CLOUDS_HEIGHT', 'Височина на облаците:');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_TEMPERATURE', 'Температура:');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_FELT_TEMPERATURE', 'Усещане за температура:');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_HUMIDITY', 'Влажност:');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_PRESSURE', 'Налягане:');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_RAIN', 'Дъжд:');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_S', 'Юг');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_SE', 'Югоизток');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_SW', 'Югозапад');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_SSW', 'Юг/Югозапад');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_SSE', 'Юг/Югоизток');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_E', 'Изток');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_ESE', 'Изток/Югоизток');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_ENE', 'Изток/Североизток');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_N', 'Север');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_NW', 'Северозапад');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_NE', 'Североизток');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_NNW', 'Север/Северозапад');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_NNE', 'Север/Североизток');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_W', 'Запад');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_WNW', 'Запад/Северозапад');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_WSW', 'Запад/Югозапад');
    @define('PLUGIN_SIDEBAR_WEATHER_DATA_V', 'Променлив');
    @define('PLUGIN_SIDEBAR_WEATHER_CACHE_ENTRIES', 'Кеширане на информацията ?');
    @define('PLUGIN_SIDEBAR_WEATHER_CACHE_ENTRIES_DESC', 'Трябва да бъде инсталиран пакет PEAR:Cache.');
    @define('PLUGIN_SIDEBAR_WEATHER_CACHE_DIRECTORY', 'Директория за кешираната информация:');
    @define('PLUGIN_SIDEBAR_WEATHER_CACHE_DIRECTORY_DESC', 'WEB сървърът трябва да има възможност за четене и запис от/в тази директория.');
    @define('PLUGIN_SIDEBAR_WEATHER_PIXEL_DIRECTORY', 'HTTP път до вашите изображения за времето');
