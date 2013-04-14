<?php # lang_cs.inc.php 1.4 2013-04-14 13:14:20 VladaAjgl $

/**
 *  @version 1.4
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/18
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/10/23
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/11/21
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/06/19
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/14
 */

@define('PLUGIN_MF_NAME', 'POP3 stahovaè');
@define('PLUGIN_MF', 'POP3 stahovaè');
@define('PLUGIN_MF_DESC', 'Stahuje zprávy z emailu a zobrazí je vèetnì pøíloh v bloku v postranním sloupci (speciální podpora pro mobilní telefony)');
@define('PLUGIN_MF_AM', 'Typ pluginu');
@define('PLUGIN_MF_AM_DESC', 'Pokud je nastaveno na "Interní", mùžete spustit POP3 stahovaè pouze z administraèní sekce. Pokud je nastaveno "Externí", mùžete spustit POP3 stahovaè pouze zvnìjšku (typicky jako úlohu cronu). Výchozí je "Interní".');
@define('PLUGIN_MF_HN', 'Jméno pro externí spouštìní');
@define('PLUGIN_MF_HN_DESC', 'Tento název je použit pro spuštìní stahovaèe zvnìjšku. Nastavte na nìjaké obtížnì uhodnutelné jméno, aby Vám skript nemohla spustit neoprávnìná osoba. Podtržítka nejsou povolena. Pokud je nastaven Typ na Interní, pak toto nastavení nemá žádný úèinek. Výchozí: "popfetcher".');
@define('PLUGIN_MF_MS', 'Mailový server');
@define('PLUGIN_MF_MS_DESC', 'Doména, na které bìží POP3 mailový server, napø. "vasedomena.cz"');
@define('PLUGIN_MF_MD', 'Adresáø pro upload');
@define('PLUGIN_MF_MD_DESC', 'Stažené pøílohy budou uloženy do tohoto adresáøe. Výchozí nastavení je shodné s upload adresáøem Serendipity (zde prázdná hodnota). Pokud zadáte jiný adresáø, musí jeho jméno konèit lomítkem "/". Napø: "dovolena/".');
@define('PLUGIN_MF_PP', 'POP3 port');
@define('PLUGIN_MF_PP_DESC', 'Èíslo portu na serveru, na kterém bìží služba POP3. Pokud je nastaveno na 995, POP3 stahovaè se pokusí pøipojit zabezpeèeným pøipojením (POP3 over SSL). Výchozí: 110.');
@define('PLUGIN_MF_MU', 'Uživatelské jméno');
@define('PLUGIN_MF_MU_DESC', 'Pøihlašovací jméno k poštì');
@define('PLUGIN_MF_CAT', 'Kategorie');
@define('PLUGIN_MF_CAT_DESC', 'Kategorie blogu, ve které se budou publikovat maily. Výchozí je žádná kategorie (prázdné políèko)');
@define('PLUGIN_MF_MP', 'Heslo');
@define('PLUGIN_MF_MP_DESC', 'Heslo k poštì');
@define('PLUGIN_MF_TO', 'Timeout');
@define('PLUGIN_MF_TO_DESC', 'Poèet vteøin, po kterých se ukonèí pokus o pøipojení k mailovému serveru. Výchozí: 30.');
@define('PLUGIN_MF_DF', 'Pøíznak "Smazat"');
@define('PLUGIN_MF_PF_DESC', 'Pokud je nastaveno na "Publikovat", pøíspìvky blogu s emaily jsou po stažení okamžitì publikovány. Pokud je nastaveno "Koncept", pak jsou uloženy jako koncept a zveøejnìny teprve po pøepnutí administrátorem do stavu "publikovat". Výchozí: "Koncept". (Toto nastavení je ignorováno, pokud je pøíznak "Blog" nastaven na "Ne".)');
@define('PLUGIN_MF_PF', 'Pøíznak "Publikovat"');
@define('PLUGIN_MF_BF_DESC', 'Pokud nastaveno na "Ano", pøílohy jsou uloženy do adresáøe pro stahování, pøipojeny k textu mailu a dohromady jsou vystaveny jako pøíspìvek blogu. Pokud je nastaveno na "Ne", pøílohy mailu jsou uloženy do adresáøe pro stahování a zbytek mailu (tj. všechen text) je zahozen.');
@define('PLUGIN_MF_BF', 'Pøíznak "Blog"');
@define('PLUGIN_MF_DF_DESC', 'Pokud je nastaveno "Ano", pak je mail po stažení smazán ze serveru. Obvyklé nastavení je "Ano", pokud plugin netestujete.');
@define('PLUGIN_MF_AF', 'Pøíznak "APOP"');
@define('PLUGIN_MF_AF_DESC', 'Pokud je nastaveno "Ano", stahovaè se pokusí pøihlašovat metodou APOP. Výchozí: "Ne".');
@define('ERROR_CHECK', 'CHYBA:');
@define('INTERNAL_MF', 'Interní');
@define('EXTERNAL_MF', 'Externí');
@define('PUBLISH_MF', 'Publikovat');
@define('DRAFT_MF', 'Koncept');
@define('MF_ERROR1', 'CHYBA: nelze se pøipojit k mailovému serveru');
@define('MF_ERROR2', 'CHYBA: nepodaøilo se pøihlásit k mailovému úètu (chybné jméno a/nebo heslo)');
@define('MF_ERROR3', 'CHYBA: z poštovního úètu nelze získat UIDL info. Pravdìpodobnì nepodporuje UIDL.');
@define('MF_ERROR4', 'CHYBA: problém pøi stahování mailu');
@define('MF_ERROR5', 'CHYBA: nelze vytvoøit soubor: ');
@define('MF_ERROR6', 'CHYBA: adresáø pro stahování není zapisovatelný. Jdìte do nastavení pluginu a zmìòte adresáø nebo zmìòte pøístupová práva k aktuálnímu adresáøi.');
@define('MF_ERROR7', 'CHYBA: cesta k adresáøi pro stahování musí konèit lomítkem "/". Jdìte do nastavení pluginu a opravte nastavení.');
@define('MF_ERROR8', 'CHYBA: Vámi zadaná kategorie blogu pro zveøejòování mailù neexistuje.');
@define('MF_ERROR9', 'CHYBA: nezdaøilo se dekódování mailu, mail má chybný MIME formát. (Chyba je na stranì odesílatele mailu.)');
@define('MF_ERROR10', 'CHYBA: Nelze nalézt SprintPCS Picture/Video Share URL.');
@define('MF_ERROR11', 'CHYBA: Nepodaøilo se stáhnout SprintPCS Picture/Video URL.');
@define('MF_ERROR13', 'CHYBA: Nepodaøilo se otevøít soubor s obrázkem/videem');
@define('MF_ERROR14', 'CHYBA: Nelze otevøít nový soubor pro SprintPCS sound memo.');
@define('MF_MSG1', 'Ve Vaší mailové schránce nejsou žádné zprávy');
@define('MF_MSG2', 'Poèet mailù stažených z Vaší schránky');
@define('MF_MSG3', '[Hlavièka s datem nenalezena]');
@define('MF_MSG4', '[Hlavièka "Od" nenalezena - neznámý odesílatel]');
@define('MF_MSG5', 'Datum: ');
@define('MF_MSG6', 'Od: ');
@define('MF_MSG7', 'DATA MAILU');
@define('MF_MSG8', 'ÈÁST MAILU -- Nalezena pøíloha se jménem: ');
@define('MF_MSG9', 'ÈÁST MAILU -- Zpráva nalezena, žádné pøílohy');
@define('MF_MSG10', 'V mailu nebyl nalezen žádný text ani pøílohy');
@define('MF_MSG11', 'Všechny zprávy byly smazány z mailového serveru');
@define('MF_MSG12', 'Všechny zprávy jsou stále uloženy na mailovém serveru');
@define('MF_MSG13', 'Pøíloha byla uložena jako soubor: ');
@define('MF_MSG14', 'Soubor pojmenovaný jako pøíloha již existuje. Pøíloha bude uložena jako soubor: ');
@define('MF_MSG15', 'Publikuji nový pøíspìvek blogu s èíslem');
@define('MF_MSG16', 'Pøedmìt: ');
@define('MF_MSG17', '[Hlavièka s pøedmìtem nebyla nalezena]');
@define('MF_MSG18', 'Kliknìte pro plnou velikost obrázku');
@define('MF_MSG19', 'Zpráva pravdìpodobnì obsahuje vir. Mail byl pøeskoèen kvùli pøíloze s podezøelým jménem.');
@define('MF_MSG20', 'Pøeskoèena zpráva bez pøíloh');
@define('MF_MSG21', 'Sound Memo');
@define('MF_MSG22', 'Kliknìte pro video');
@define('MF_MSG23', 'Mobil @');
@define('MF_TEXTBODY', 'Zobrazit plaintextové pøílohy v tìle pøíspìvku?');
@define('MF_TEXTBODY_DESC', 'Pokud je aktivováno, všechny pøílohy, které obsahují pouze text budou pøidány do tìla pøíspìvku na blogu. Pokud není aktivováno, tyto pøílohy budou uloženy jako samostatné soubory a do pøíspìvku bude vložen pouze odkaz na nì.');
@define('MF_TEXTBODY_FIRST', 'První textová pøíloha je vložena jako tìlo pøíspìvku, ostatní jako rozšíøená textová èást.');
@define('MF_TEXTBODY_FIRST_DESC', 'Nastavení je použito pouze pokud jsou plaintextové pøílohy vkládány do tìla pøíspìvku (viz. výše). Pokud je aktivováno, bude pouze první textová pøíloha použita jako tìlo pøíspìvku (perex, teaser), ostatní budou uloženy do "rozšíøené textové èásti" pøíspìvku. Budou se tudíž zobrazovat pouze pøi zobrazení jednoho konkrétního pøíspìvku a ne na pøehledových stránkách, jako je napø. hlavní stránka.');
@define('MF_MYSELF', 'Autor');
@define('MF_AUTHOR_DESC', 'Nastavte autora, který se bude zobrazovat jako autor u pøíspìvkù obsahujících stažené maily.');
@define('PLUGIN_MF_STRIPTAGS', 'Odstranit z mailu všechny HTML tagy');
@define('PLUGIN_MF_STRIPTAGS_DESC', 'Odstraní z mailu všechny HTML tagy, pøípadné formátování mailu tak bude ztraceno. Nehrozí ale rozházení stránky vlivem kukaèèího HTML kódu.');

@define('PLUGIN_MF_ADDFLAG', 'Oøezat reklamy?');
@define('PLUGIN_MF_ADDFLAG_DESC', 'Má POP3 stahovaè odstraòovat z mailu reklamní grafku a texty? Tento filter v souèasnosti funguje pouze pro T-Mobile a O2.');

@define('PLUGIN_MF_STRIPTEXT', 'Oøíznout text na speciálním znaku');
@define('PLUGIN_MF_STRIPTEXT_DESC', 'Pokud chcete oøezat z mailù reklamy nebo jiný nežádoucí text, mùžete zde zadat "kouzelný øetìzec". Všechen text, který se v mailu nachází za tímto øetìzcem, bude odstranìn a nebude se zobrazovat v pøíspìvku.');

@define('PLUGIN_MF_ONLYFROM', 'Omezení na konkrétní odesílatele');
@define('PLUGIN_MF_ONLYFROM_DESC', 'Pokud chcete povolit posílání mailù do blogu pouze z jedné mailové adresy, jednoduše ji sem zadejte. Pokud ponecháte políèko prázdné, na blogu budou zobrazovány všechny stažené maily.');
@define('MF_ERROR_ONLYFROM', 'Emailová adresa %s se neshoduje s povolenou adresou %s. Mail byl ignorován.');
@define('MF_ERROR_NOAUTHOR', 'Žádný z autorù nemá adresu %s. Mail byl pøeskoèen.');

@define('PLUGIN_MF_SPLITTEXT', 'Zadejte øetìzec, který oddìluje tìlo a rozšíøenou textovou èást pøíspìvku');
@define('PLUGIN_MF_SPLITTEXT_DESC', 'Pomocí tohoto nastavení mùžete zajistit, že se èást meilu bude ukládat do tìla pøíspìvku a zbytek do rozšíøené textové èásti. Pokud POP3 stahovaè nalezne v mailu zde zadaný øetìzec, všechno pøed ním vloží do tìla pøíspìvku a všechno za ním do rozšíøené textové èásti. Zvolte jedineèný text, který se nemùže ocitnout v bìžném textu, jako napø. "xxx-SPLIT-xxx". Zadání této volby mùže pøekrýt jiné nastavení pro zpracování mailù!');

@define('PLUGIN_MF_USETEXT', 'Text hledaný v mailu');
@define('PLUGIN_MF_USETEXT_DESC', 'Pokud chcete z mailù vkládat do pøíspìvkù pouze urèitou èást, mùžete zde zadat "kouzelný øetìzec", podle které stahovaè pozná, kterou èást mailu má použít. Následnì pak musíte tento øetìzec napsat do každého mailu a oznaèit tak text urèený pro blog. Zadejte øetìzec, který se v mailech nemùže náhodnì objevit, dobré je napø. "xxx-BLOG-xxx".');
@define('PLUGIN_MF_CRONJOB', 'Tento plugin lze aktivovat pomocí Serendipity Cronjob pluginu. Instalujte jej, pokud chcete spouštìt stahovaè v pravidelných intervalech.');

@define('PLUGIN_MF_TEXTPREF', 'Upøednostòovat text');
@define('PLUGIN_MF_TEXTPREF_DESC', 'Nìkterá zaøízení posílají maily, které jsou psané ve formátu HTML, ale zároveò mají ten samý obsah pouze v neformátovaném textu. Takže z mail dostanete dvakrát ten samý text. Pomocí této volby mùžete urèit, kterou èást chcete používat.');
@define('PLUGIN_MF_TEXTPREF_BOTH', 'Obì èásti');
@define('PLUGIN_MF_TEXTPREF_HTML', 'HTML');
@define('PLUGIN_MF_TEXTPREF_PLAIN', 'Èistý text');

// Next lines were translated on 2009/10/23

@define('PLUGIN_MF_USEDATE', 'Upøednostnit èas odeslání pøíchozího mailu pøed èasem doruèení');
@define('PLUGIN_MF_REPLY', 'Komentáø/odpovìï místo pøíspìvku v blogu.');
@define('PLUGIN_MF_REPLY_ERROR1', 'Nebyl nalezen žádný pøíspìvek, který by se shodoval s pøedmìtem mailu. Mail nebyl uložen.');
@define('PLUGIN_MF_REPLY_ERROR2', 'Nelze uložit komentáø.');

// Next lines were translated on 2009/11/21

@define('PLUGIN_MF_SUBFOLDER', 'Ukládat pøílohy v podadresáøích pojmenovaných jako 2010/02/ pro zachování chronologického poøadí?');
@define('PLUGIN_MF_DEBUG', 'Ukládat ladicí zprávy do souboru uploads/popfetcher-RRRR-MM.log?');

// Next lines were translated on 2011/06/19

@define('THUMBNAIL_VIEW', 'Zobrazovat náhledy v tìle pøíspìvku');
@define('THUMBNAIL_VIEW_DESC', 'Když chcete zobrazit v tìle pøíspìvku náhledy pøipojených obrázkù. Pokud nastavíte "NE", budou se zobrazovat obrázky v plné velikosti.');