/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/05
 */@define('PLUGIN_ADMINNOTES_TITLE', 'Rychlé poznámky');
@define('PLUGIN_ADMINNOTES_DESC', 'Zobrazuje v administraèní sekci oznámení pøihlášeným uživatelùm');

@define('PLUGIN_ADMINNOTES_FEEDBACK', 'Povolit uživatelùm posílání poznámek?');
@define('PLUGIN_ADMINNOTES_FEEDBACK_DESC', 'Pokud není povoleno, pak mùže poznámky psát pouze administrátor. Pokud je povoleno, pak uživatelé mohou posílat zprávy všem skupinám uživatelù, jichž jsou èleny.');
@define('PLUGIN_ADMINNOTES_FEEDBACK_INFO', 'Zadejte zprávu, která se objeví v administraèní sekci a vyberte cílovou skupinu adresátù, kteøí tuto zprávu uvidí.');

@define('PLUGIN_ADMINNOTES_HTML', 'Povolit HTML formátování?');
@define('PLUGIN_ADMINNOTES_HTML_DESC', 'Pokud je povoleno, pak je možné v pøíspìvcích používat HTML tagy. Pozor, nìkteøí "záškodníci" by se mohli pokusit vložit do stránek kód v JavaScriptu. Tuto volbu povolte pouze pokud stoprocentnì vìøíte všem svým uživatelùm!');

@define('PLUGIN_ADMINNOTES_CUTOFF', 'Zkrátit poznámky po X znacích?');
@define('PLUGIN_ADMINNOTES_CUTOFF_DESC', 'Poznámky delši než zde nastaveno budou ve výpisu oøíznuty a jejich plné znìní se zobrazí až po rozkliknutí.');