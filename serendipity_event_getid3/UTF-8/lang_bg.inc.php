<?php # $Id: lang_bg.inc.php,v 1.3 2007/08/26 20:35:50 jwalker_bg Exp $

@define('PLUGIN_GETID3', 'getID3() поддръжка за извличане на свойствата на медийни файлове.');
@define('PLUGIN_GETID3_DESC', 'Използва библиотека getID3() за извличане на свойствата на филми/аудио. getID3() не се разпространява с тази приставка.');
@define('PLUGIN_GETID3_INSTALL', 'Библиотека getID3() не се разпространява с тази приставка и затова е необходимо да я свалите от http://getid3.org/. Разархивирайте файловете в директория serendipity_event_getid3.');

@define('PLUGIN_GETID3_INSTALL_DESC', 
'<h3>Инсталация</h3>' .
'<p>Библиотеката getID3() не се разпространява с тази приставка, така че трябва да свалите тези файлове от' .
'<a href="http://getid3.org/" target="_blank">getid3.org</a>. <b>Поддържа се само версия 1.0!</b></p>' .
'<p>В пакета ще намерите поддиректория getid3. Копирайте тази директория в директорията на Serendipity "bundled-libs".</p>');

@define('PLUGIN_GETID3_LIBNOTFOUND',    'GetID3 не беше намерена нито в "bundled-lib" нито в директорията на приставката!'); 
@define('PLUGIN_GETID3_LIBFOUNDBUNDLED','GetID3 е намерена в поддиректория "bundled-libs".'); 
@define('PLUGIN_GETID3_LIBFOUNDPLUGIN', 'GetID3 е намерена в директорията на приставката.');
