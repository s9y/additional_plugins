<?php

/**
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
@define('PLUGIN_MF_AM_DESC', 'Pokud je nastaveno na "Interní", mù¾ete spustit POP3 stahovaè pouze z administraèní sekce. Pokud je nastaveno "Externí", mù¾ete spustit POP3 stahovaè pouze zvnìj¹ku (typicky jako úlohu cronu). Výchozí je "Interní".');
@define('PLUGIN_MF_HN', 'Jméno pro externí spou¹tìní');
@define('PLUGIN_MF_HN_DESC', 'Tento název je pou¾it pro spu¹tìní stahovaèe zvnìj¹ku. Nastavte na nìjaké obtí¾nì uhodnutelné jméno, aby Vám skript nemohla spustit neoprávnìná osoba. Podtr¾ítka nejsou povolena. Pokud je nastaven Typ na Interní, pak toto nastavení nemá ¾ádný úèinek. Výchozí: "popfetcher".');
@define('PLUGIN_MF_MS', 'Mailový server');
@define('PLUGIN_MF_MS_DESC', 'Doména, na které bì¾í POP3 mailový server, napø. "vasedomena.cz"');
@define('PLUGIN_MF_MD', 'Adresáø pro upload');
@define('PLUGIN_MF_MD_DESC', 'Sta¾ené pøílohy budou ulo¾eny do tohoto adresáøe. Výchozí nastavení je shodné s upload adresáøem Serendipity (zde prázdná hodnota). Pokud zadáte jiný adresáø, musí jeho jméno konèit lomítkem "/". Napø: "dovolena/".');
@define('PLUGIN_MF_PP', 'POP3 port');
@define('PLUGIN_MF_PP_DESC', 'Èíslo portu na serveru, na kterém bì¾í slu¾ba POP3. Pokud je nastaveno na 995, POP3 stahovaè se pokusí pøipojit zabezpeèeným pøipojením (POP3 over SSL). Výchozí: 110.');
@define('PLUGIN_MF_MU', 'U¾ivatelské jméno');
@define('PLUGIN_MF_MU_DESC', 'Pøihla¹ovací jméno k po¹tì');
@define('PLUGIN_MF_CAT', 'Kategorie');
@define('PLUGIN_MF_CAT_DESC', 'Kategorie blogu, ve které se budou publikovat maily. Výchozí je ¾ádná kategorie (prázdné políèko)');
@define('PLUGIN_MF_MP', 'Heslo');
@define('PLUGIN_MF_MP_DESC', 'Heslo k po¹tì');
@define('PLUGIN_MF_TO', 'Timeout');
@define('PLUGIN_MF_TO_DESC', 'Poèet vteøin, po kterých se ukonèí pokus o pøipojení k mailovému serveru. Výchozí: 30.');
@define('PLUGIN_MF_DF', 'Pøíznak "Smazat"');
@define('PLUGIN_MF_PF_DESC', 'Pokud je nastaveno na "Publikovat", pøíspìvky blogu s emaily jsou po sta¾ení okam¾itì publikovány. Pokud je nastaveno "Koncept", pak jsou ulo¾eny jako koncept a zveøejnìny teprve po pøepnutí administrátorem do stavu "publikovat". Výchozí: "Koncept". (Toto nastavení je ignorováno, pokud je pøíznak "Blog" nastaven na "Ne".)');
@define('PLUGIN_MF_PF', 'Pøíznak "Publikovat"');
@define('PLUGIN_MF_BF_DESC', 'Pokud nastaveno na "Ano", pøílohy jsou ulo¾eny do adresáøe pro stahování, pøipojeny k textu mailu a dohromady jsou vystaveny jako pøíspìvek blogu. Pokud je nastaveno na "Ne", pøílohy mailu jsou ulo¾eny do adresáøe pro stahování a zbytek mailu (tj. v¹echen text) je zahozen.');
@define('PLUGIN_MF_BF', 'Pøíznak "Blog"');
@define('PLUGIN_MF_DF_DESC', 'Pokud je nastaveno "Ano", pak je mail po sta¾ení smazán ze serveru. Obvyklé nastavení je "Ano", pokud plugin netestujete.');
@define('PLUGIN_MF_AF', 'Pøíznak "APOP"');
@define('PLUGIN_MF_AF_DESC', 'Pokud je nastaveno "Ano", stahovaè se pokusí pøihla¹ovat metodou APOP. Výchozí: "Ne".');
@define('ERROR_CHECK', 'CHYBA:');
@define('INTERNAL_MF', 'Interní');
@define('EXTERNAL_MF', 'Externí');
@define('PUBLISH_MF', 'Publikovat');
@define('DRAFT_MF', 'Koncept');
@define('MF_ERROR1', 'CHYBA: nelze se pøipojit k mailovému serveru');
@define('MF_ERROR2', 'CHYBA: nepodaøilo se pøihlásit k mailovému úètu (chybné jméno a/nebo heslo)');
@define('MF_ERROR3', 'CHYBA: z po¹tovního úètu nelze získat UIDL info. Pravdìpodobnì nepodporuje UIDL.');
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
@define('MF_MSG1', 'Ve Va¹í mailové schránce nejsou ¾ádné zprávy');
@define('MF_MSG2', 'Poèet mailù sta¾ených z Va¹í schránky');
@define('MF_MSG3', '[Hlavièka s datem nenalezena]');
@define('MF_MSG4', '[Hlavièka "Od" nenalezena - neznámý odesílatel]');
@define('MF_MSG5', 'Datum: ');
@define('MF_MSG6', 'Od: ');
@define('MF_MSG7', 'DATA MAILU');
@define('MF_MSG8', 'ÈÁST MAILU -- Nalezena pøíloha se jménem: ');
@define('MF_MSG9', 'ÈÁST MAILU -- Zpráva nalezena, ¾ádné pøílohy');
@define('MF_MSG10', 'V mailu nebyl nalezen ¾ádný text ani pøílohy');
@define('MF_MSG11', 'V¹echny zprávy byly smazány z mailového serveru');
@define('MF_MSG12', 'V¹echny zprávy jsou stále ulo¾eny na mailovém serveru');
@define('MF_MSG13', 'Pøíloha byla ulo¾ena jako soubor: ');
@define('MF_MSG14', 'Soubor pojmenovaný jako pøíloha ji¾ existuje. Pøíloha bude ulo¾ena jako soubor: ');
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
@define('MF_TEXTBODY_DESC', 'Pokud je aktivováno, v¹echny pøílohy, které obsahují pouze text budou pøidány do tìla pøíspìvku na blogu. Pokud není aktivováno, tyto pøílohy budou ulo¾eny jako samostatné soubory a do pøíspìvku bude vlo¾en pouze odkaz na nì.');
@define('MF_TEXTBODY_FIRST', 'První textová pøíloha je vlo¾ena jako tìlo pøíspìvku, ostatní jako roz¹íøená textová èást.');
@define('MF_TEXTBODY_FIRST_DESC', 'Nastavení je pou¾ito pouze pokud jsou plaintextové pøílohy vkládány do tìla pøíspìvku (viz. vý¹e). Pokud je aktivováno, bude pouze první textová pøíloha pou¾ita jako tìlo pøíspìvku (perex, teaser), ostatní budou ulo¾eny do "roz¹íøené textové èásti" pøíspìvku. Budou se tudí¾ zobrazovat pouze pøi zobrazení jednoho konkrétního pøíspìvku a ne na pøehledových stránkách, jako je napø. hlavní stránka.');
@define('MF_MYSELF', 'Autor');
@define('MF_AUTHOR_DESC', 'Nastavte autora, který se bude zobrazovat jako autor u pøíspìvkù obsahujících sta¾ené maily.');
@define('PLUGIN_MF_STRIPTAGS', 'Odstranit z mailu v¹echny HTML tagy');
@define('PLUGIN_MF_STRIPTAGS_DESC', 'Odstraní z mailu v¹echny HTML tagy, pøípadné formátování mailu tak bude ztraceno. Nehrozí ale rozházení stránky vlivem kukaèèího HTML kódu.');

@define('PLUGIN_MF_ADDFLAG', 'Oøezat reklamy?');
@define('PLUGIN_MF_ADDFLAG_DESC', 'Má POP3 stahovaè odstraòovat z mailu reklamní grafku a texty? Tento filter v souèasnosti funguje pouze pro T-Mobile a O2.');

@define('PLUGIN_MF_STRIPTEXT', 'Oøíznout text na speciálním znaku');
@define('PLUGIN_MF_STRIPTEXT_DESC', 'Pokud chcete oøezat z mailù reklamy nebo jiný ne¾ádoucí text, mù¾ete zde zadat "kouzelný øetìzec". V¹echen text, který se v mailu nachází za tímto øetìzcem, bude odstranìn a nebude se zobrazovat v pøíspìvku.');

@define('PLUGIN_MF_ONLYFROM', 'Omezení na konkrétní odesílatele');
@define('PLUGIN_MF_ONLYFROM_DESC', 'Pokud chcete povolit posílání mailù do blogu pouze z jedné mailové adresy, jednodu¹e ji sem zadejte. Pokud ponecháte políèko prázdné, na blogu budou zobrazovány v¹echny sta¾ené maily.');
@define('MF_ERROR_ONLYFROM', 'Emailová adresa %s se neshoduje s povolenou adresou %s. Mail byl ignorován.');
@define('MF_ERROR_NOAUTHOR', '®ádný z autorù nemá adresu %s. Mail byl pøeskoèen.');

@define('PLUGIN_MF_SPLITTEXT', 'Zadejte øetìzec, který oddìluje tìlo a roz¹íøenou textovou èást pøíspìvku');
@define('PLUGIN_MF_SPLITTEXT_DESC', 'Pomocí tohoto nastavení mù¾ete zajistit, ¾e se èást meilu bude ukládat do tìla pøíspìvku a zbytek do roz¹íøené textové èásti. Pokud POP3 stahovaè nalezne v mailu zde zadaný øetìzec, v¹echno pøed ním vlo¾í do tìla pøíspìvku a v¹echno za ním do roz¹íøené textové èásti. Zvolte jedineèný text, který se nemù¾e ocitnout v bì¾ném textu, jako napø. "xxx-SPLIT-xxx". Zadání této volby mù¾e pøekrýt jiné nastavení pro zpracování mailù!');

@define('PLUGIN_MF_USETEXT', 'Text hledaný v mailu');
@define('PLUGIN_MF_USETEXT_DESC', 'Pokud chcete z mailù vkládat do pøíspìvkù pouze urèitou èást, mù¾ete zde zadat "kouzelný øetìzec", podle které stahovaè pozná, kterou èást mailu má pou¾ít. Následnì pak musíte tento øetìzec napsat do ka¾dého mailu a oznaèit tak text urèený pro blog. Zadejte øetìzec, který se v mailech nemù¾e náhodnì objevit, dobré je napø. "xxx-BLOG-xxx".');
@define('PLUGIN_MF_CRONJOB', 'Tento plugin lze aktivovat pomocí Serendipity Cronjob pluginu. Instalujte jej, pokud chcete spou¹tìt stahovaè v pravidelných intervalech.');

@define('PLUGIN_MF_TEXTPREF', 'Upøednostòovat text');
@define('PLUGIN_MF_TEXTPREF_DESC', 'Nìkterá zaøízení posílají maily, které jsou psané ve formátu HTML, ale zároveò mají ten samý obsah pouze v neformátovaném textu. Tak¾e z mail dostanete dvakrát ten samý text. Pomocí této volby mù¾ete urèit, kterou èást chcete pou¾ívat.');
@define('PLUGIN_MF_TEXTPREF_BOTH', 'Obì èásti');
@define('PLUGIN_MF_TEXTPREF_HTML', 'HTML');
@define('PLUGIN_MF_TEXTPREF_PLAIN', 'Èistý text');

// Next lines were translated on 2009/10/23

@define('PLUGIN_MF_USEDATE', 'Upøednostnit èas odeslání pøíchozího mailu pøed èasem doruèení');
@define('PLUGIN_MF_REPLY', 'Komentáø/odpovìï místo pøíspìvku v blogu.');
@define('PLUGIN_MF_REPLY_ERROR1', 'Nebyl nalezen ¾ádný pøíspìvek, který by se shodoval s pøedmìtem mailu. Mail nebyl ulo¾en.');
@define('PLUGIN_MF_REPLY_ERROR2', 'Nelze ulo¾it komentáø.');

// Next lines were translated on 2009/11/21

@define('PLUGIN_MF_SUBFOLDER', 'Ukládat pøílohy v podadresáøích pojmenovaných jako 2010/02/ pro zachování chronologického poøadí?');
@define('PLUGIN_MF_DEBUG', 'Ukládat ladicí zprávy do souboru uploads/popfetcher-RRRR-MM.log?');

// Next lines were translated on 2011/06/19

@define('THUMBNAIL_VIEW', 'Zobrazovat náhledy v tìle pøíspìvku');
@define('THUMBNAIL_VIEW_DESC', 'Kdy¾ chcete zobrazit v tìle pøíspìvku náhledy pøipojených obrázkù. Pokud nastavíte "NE", budou se zobrazovat obrázky v plné velikosti.');