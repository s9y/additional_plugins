/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/05
 */@define('PLUGIN_ADMINNOTES_TITLE', 'Rychlé poznámky');
@define('PLUGIN_ADMINNOTES_DESC', 'Zobrazuje v administrační sekci oznámení přihlášeným uživatelům');

@define('PLUGIN_ADMINNOTES_FEEDBACK', 'Povolit uživatelům posílání poznámek?');
@define('PLUGIN_ADMINNOTES_FEEDBACK_DESC', 'Pokud není povoleno, pak může poznámky psát pouze administrátor. Pokud je povoleno, pak uživatelé mohou posílat zprávy všem skupinám uživatelů, jichž jsou členy.');
@define('PLUGIN_ADMINNOTES_FEEDBACK_INFO', 'Zadejte zprávu, která se objeví v administrační sekci a vyberte cílovou skupinu adresátů, kteří tuto zprávu uvidí.');

@define('PLUGIN_ADMINNOTES_HTML', 'Povolit HTML formátování?');
@define('PLUGIN_ADMINNOTES_HTML_DESC', 'Pokud je povoleno, pak je možné v příspěvcích používat HTML tagy. Pozor, někteří "záškodníci" by se mohli pokusit vložit do stránek kód v JavaScriptu. Tuto volbu povolte pouze pokud stoprocentně věříte všem svým uživatelům!');

@define('PLUGIN_ADMINNOTES_CUTOFF', 'Zkrátit poznámky po X znacích?');
@define('PLUGIN_ADMINNOTES_CUTOFF_DESC', 'Poznámky delši než zde nastaveno budou ve výpisu oříznuty a jejich plné znění se zobrazí až po rozkliknutí.');