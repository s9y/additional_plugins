/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/27
 */@define('DEJURE_TITLE', 'Automatické odkazy Dejure.org');
@define('DEJURE_DESCRIPTION', 'Automaticky vytváří odkazy na citace a judikaturu (odkazy a zdroje informací) pomocí služby dejure.org.');
@define('DEJURE_MAIL', 'Emailová adresa vlastníka blogu');
@define('DEJURE_MAIL_DESC', 'Tato informace je odeslána na dejure.org a slouží pouze pro komunikaci při technických obtížích. Adresa nebude použita pro zasílání komerčních oznámení ani k jiným podobným účelům!');
@define('DEJURE_NEWSLETTER', 'Newsletter');
@define('DEJURE_NEWSLETTER_DESC', 'Chci se zapsat k odebírání aktualizací na službě dejure.org.');
@define('DEJURE_TARGET', 'Otevírat odkazy v...');
@define('DEJURE_TARGET_DESC', 'Prázdná hodnota způsobí otevírání odkazů ve stejném okně, hodnota "_blank" v novém okně.');
@define('DEJURE_CSS', 'CSS třída pro odkazy dejure.org');
@define('DEJURE_CSS_DESC', '');
@define('DEJURE_LINKSTYLE', 'Styl odkazů dejure.org');
@define('DEJURE_LINKSTYLE_DESC', '');
@define('DEJURE_LINKSTYLE_SHORT', 'Odkazovat pouze následující čísla judikatur (např. §_242_BGB; §_278_254_BGB)');
@define('DEJURE_LINKSTYLE_WIDE', 'Použít detailní odkazy (např. _§ 242 BGB_; _§ 278_, _254 BGB_)');