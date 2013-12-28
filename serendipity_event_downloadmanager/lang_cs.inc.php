<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/09/28
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/08/21
 */

@define('PLUGIN_DOWNLOADMANAGER_TITLE', 'Downloadmanager');
@define('PLUGIN_DOWNLOADMANAGER_DESC', 'Zajišuje Serendipity všechny funkce download managera. Pøi odinstalování jsou odstranìny všechny tabulky z databáze (ztráta všech dat)!!!');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE', 'Titulek');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE_BLAHBLAH', 'tj. to, co se zobrazuje v informaèním pruhu okna prohlíeèe ještì nad menu');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE', 'Nadpis');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE_BLAHBLAH', 'tj. to, co je napsáno tuènım velkım písmem jako název stránky blogu');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL', 'Statická URL adresa');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL_BLAHBLAH', 'Definuje URL, pod kterou je download manaer pøístupnı (index.php?serendipity[subpage]=zde_zadané_jméno)');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK', 'Permalink (stálı odkaz)');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK_BLAHBLAH', 'Definuje stálou zkratku, která mùe bıt kratší a srozumitelnìjší ne statická URL adresa (nastavené vıše). Je tøeba zadat absolutní HTTP cestu, navíc musí konèit .htm nebo .html! (Vıchozí nastavení: [http://vas_blog.cz/]downloads.html]');
@define('PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH', 'Cesta pro pøíchozí data');
@define('PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH_BLAHBLAH', 'Plná absolutní cesta k adresáøi, do kterého nahráváte soubory. Plugin pracuje tak, e do tohoto adresáøe se nahrají soubory a teprve pak urèíte, které mají bıt nabízené ke staení. Ty si pak plugin pøemístí do adresáøe s downloady. (Adresáø musí bıt vytvoøen a webserver do nìj musí mít právo zápisu!)');
@define('PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH', 'Absolutní cesta adresáøe s downloady');
@define('PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH_BLAHBLAH', 'Plná absolutní cesta k adresáøi, do kterého si bude downloadmanager umísovat soubory, které pak budou pøístupné z blogu. (Adresáø musí bıt vytvoøen a webserver do nìj musí mít právo zápisu!)');
@define('PLUGIN_DOWNLOADMANAGER_HTTPPATH', 'HTTP cesta k pluginu');
@define('PLUGIN_DOWNLOADMANAGER_HTTPPATH_BLAHBLAH', 'aboslutní http cesta k pluginu (obvykle "/plugins/serendipity_event_downloadmanager").');
@define('PLUGIN_DOWNLOADMANAGER_DATEFORMAT', 'Formát data, podle pravidel PHP funkce date(). (vıchozí: "Y/m/d, h:ia")');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE', 'Zobrazovat datum souboru');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE_BLAHBLAH', 'Má se v seznamu souborù zobrazovat datum souboru?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILENAME', 'Zobrazovat jméno souboru');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILENAME_BLAHBLAH', 'Má se v seznamu souborù zobrazovat jméno souboru?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE', 'Zobrazovat velikost');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE_BLAHBLAH', 'Má se v seznamu souborù zobrazovat velikost souboru?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS', 'Poèet staení souboru');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS_BLAHBLAH', 'Má se v seznamu souborù zobrazovat poèet staení souboru?');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD', 'Popis políèka se jménem souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD_BLAHBLAH', 'Zde mùete zmìnit popis políèka se jménem souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD', 'Popis políèka s velikostí');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD_BLAHBLAH', 'Zde mùete zmìnit popis políèka s velikostí souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD', 'Popis políèka s datem');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD_BLAHBLAH', 'Zde mùete zmìnit popis políèka s datem vytvoøení souboru');
@define('PLUGIN_DOWNLOADMANAGER_DLS_FIELD', 'Popis políèka s poètem staení');
@define('PLUGIN_DOWNLOADMANAGER_DLS_FIELD_BLAHBLAH', 'Zde mùete zmìnit popis políèka s poètem staení souboru');
@define('PLUGIN_DOWNLOADMANAGER_ICONWIDTH', 'Šíøka ikony');
@define('PLUGIN_DOWNLOADMANAGER_ICONWIDTHBLAH', 'Šíøka ikon typu souboru v seznamu souborù');
@define('PLUGIN_DOWNLOADMANAGER_ICONHEIGHT', 'Vıška ikony');
@define('PLUGIN_DOWNLOADMANAGER_ICONHEIGHT_BLAHBLAH', 'Šíøka ikon typu souboru v seznamu souborù');
@define('PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED', 'Zobrazovat registrovanım uivatelùm skryté kategorie?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED_BLAHBLAH', 'Mají se skryté kategorie zobrazovat registrovanım a pøihlášenım uivatelùm?');

@define('PLUGIN_DOWNLOADMANAGER_NO_CATS_FOUND', 'ádné kategorie');
@define('PLUGIN_DOWNLOADMANAGER_CATEGORIES', 'Kategorie');
@define('PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES', 'Podkategorie');
@define('PLUGIN_DOWNLOADMANAGER_CATEGORY', 'Kategorie');
@define('PLUGIN_DOWNLOADMANAGER_NUMBER_OF_DOWNLOADS', 'poèet souborù');
@define('PLUGIN_DOWNLOADMANAGER_CATNAME', 'Jméno kategorie:');
@define('PLUGIN_DOWNLOADMANAGER_SUBCAT_OF', 'Podkategorie v:');
@define('PLUGIN_DOWNLOADMANAGER_ADD_CAT', 'Pøidat novou kategorii');
@define('PLUGIN_DOWNLOADMANAGER_DEL_FILE', 'Smazat soubor...');
@define('PLUGIN_DOWNLOADMANAGER_DEL_CAT', 'Smazat kategorii (a všechny soubory v ní obsaené!)...');
@define('PLUGIN_DOWNLOADMANAGER_DEL_CAT_NOT_ALLOWD', 'Smazání není moné - kategorie obsahuje podkategorie!');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_NOT_ALLOWED', 'Tato kategorie nemùe bıt smazána, protoe obsahuje alespoò jednu další podkategorii!');
@define('PLUGIN_DOWNLOADMANAGER_CAT_NOT_FOUND', 'Kategorie nenalezena!');
@define('PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT', 'Soubory v této kategorii');
@define('PLUGIN_DOWNLOADMANAGER_BACK', 'Zpìt...');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME', 'Jméno souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE', 'Velikost');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE', 'Datum');
@define('PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS', 'poèet staení');
@define('PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS_BLAH', 'Poèet staení');
@define('PLUGIN_DOWNLOADMANAGER_IMPORT_FILE', 'Importovat soubor z pøíchozího adresáøe do aktuální kategorie...');
@define('PLUGIN_DOWNLOADMANAGER_COPY_NOT_ALLOWED', 'Nelze zkopírovat soubor z pøíchozího adresáøe!<br />Dùvodem mùe bıt napø. aktivovanı safe_mode.<br />Pro pouívání této funkce je tøeba deaktivovat safe_mode!');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_IN_INCOMING_NOT_ALLOWED', 'Webserver nemá dostatek oprávnìní pro smazání souboru z pøíchozího adresáøe! Smate prosím soubor ruènì a potom pozmìòte pøístupová práva, aby to od pøíštì šlo.');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_IN_DOWNLOADDIR_NOT_ALLOWED', 'Webserver nemá dostatek oprávnìní pro smazání souboru z  adresáøe downloadù! Pozmìòte pøístupová práva, pak opakujte pokus o smazání.');
@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE', 'Pøíchozí adresáø:');
@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE_BLAHBLAH', 'Nahrajte soubor do tohoto adresáøe pomocí FTP, pokud Vám nejde nahrát pomocí funkce php-upload. To se mùe stát napø. pokud je soubor pøíliš velkı. Php má toti omezení na max. velikost uploadovaného souboru - nastavení v php.ini.<br />Aktuální adresáø: ');
@define('PLUGIN_DOWNLOADMANAGER_THIS_FILE', 'Vybranı soubor');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE', 'Editovat soubor');
@define('PLUGIN_DOWNLOADMANAGER_MOVE_TO_CAT', 'Pøesunout do');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC', 'Popis souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILE_EDITED', 'Soubor úspìšnì zmìnìn a uloen!');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_FILE', 'Stáhnout soubor');
@define('PLUGIN_DOWNLOADMANAGER_UPLOAD_FILE', 'Nahrát soubory...');
@define('PLUGIN_DOWNLOADMANAGER_FILE', 'Soubor');
@define('PLUGIN_DOWNLOADMANAGER_UPLOAD_NOT_ALLOWED', 'Nahrávání souborù není povoleno!<br />Povolte je v php.ini (file_uploads)!');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_OCCOURED', 'Bìhem nahrávání souboru se vyskytly chyby!');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_NOTCOPIED', 'Následující soubory nemohly bıt pøekopírovány:');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_TOOBIG', 'Následující soubory jsou pøíliš velké:');
@define('PLUGIN_DOWNLOADMANAGER_NO_FILES_UPLOADED', 'ádné uploadované soubory nebyly nalezeny!');
@define('PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY', 'Soubory z knihovny médií');
@define('PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY_BLAHBLAH', 'Do downloadmanagera mùete pøidat soubory, které jsou ji nahrané v knihovnì médií. Pozn.: Tyto soubory se nebudou pøemísovat, pouze se zkopírují a zùstanou i v pùvodním adresáøi!<br />Aktuální adresáø: ');
@define('PLUGIN_DOWNLOADMANAGER_HIDE_TREE', 'Skrıt celı podstrom této kategorie...');
@define('PLUGIN_DOWNLOADMANAGER_UNHIDE_TREE', 'Zobrazit celı podstrom této kategorie...');
@define('PLUGIN_DOWNLOADMANAGER_OPEN_CAT', 'Kliknutí otevøe kategorii pro upload a editaci souborù...');

@define('PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST',       'Zobrazit popis souborù v seznamu souborù ke staení');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST_DESC',  'Pokud chcete generovat krátkı seznam souborù, vypnìte tuto volbu. Pokud chcete poskytnout ke kadému souboru podrobnìjší informace, volbu zapnìte.');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST',       'Pøímı download');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_DESC',  'Vıchozí chování downloadmanagera je, e pøed staením souboru zobrazí stránku s informacemi. Pomocí tohoto nastavení mùete umonit pøeskoèit tuto stránku rovnou na stahování souboru. Stahování zaène jak po kliknutí na jméno souboru, tak na ikonku.');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NO',    'Info-stránka');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_ICON',  'Pøímé stahování po kliknutí na ikonu');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NAME',  'Pøímé stahování po kliknutí na jméno souboru');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_BOTH',  'Pøímé stahování po kliknutí na obojí');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING',          'Nové verze existujících souborù...');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_DESC',     'Pokud uploadujete soubor, kterı u existuje, má se vytvoøit novı soubor, nebo jen obnovit informace u ji existujícího?');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_INSERT',   'vytvoøit novı soubor');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_UPDATE',   'aktualizovat starı');

// Next lines were translated on 2010/09/28

@define('PLUGIN_DOWNLOADMANAGER_BACKEND_TITLE', 'Downloadmanager verze %s - Administraèní menu');
@define('PLUGIN_DOWNLOADMANAGER_INTRO', 'Úvodní text (nepovinné)');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY', 'Obecné: zobrazovat data pouze registrovanım uivatelùm');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_BLAHBLAH', 'Chcete, aby pøehled kategorií a souborù ke staení byl zobrazován pouze registrovanım a pøihlášenım uivatelùm?');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_ERROR', 'Soubory ke staení jsou pøístupné pouze registrovanım uivatelùm!');
@define('PLUGIN_DOWNLOADMANAGER_ROOTLEVEL_TITLE', 'soubory v koøenovém adresáøi (v pøehledu schované, neviditelné!)');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_UPGRADE_NOTCOPIED', 'Omlouváme se, vyskytla se chyba. Soubory z <br /><em>%s</em><br />nemohly bıt pøesunuty do<br /><em>%s</em>.<br /><br />Pøesuòte je proím ruènì a kliknìte na <a class="backend_error_link" href="%s">tento odkaz</a>, abyste o pøesunu informovali plugin!<br />Kromì toho odstraòte ruènì také staré adresáøe.<br />');
@define('PLUGIN_DOWNLOADMANAGER_ALLFILES_COPIED_NEWDIR', 'Protoe jste aktualizovali plugin downloadmanager na verzi 0.24, byly všechny soubory ke staenı zkopírovány do novıch podadresáøù \'/.dlm/files\' a \'/.dlm/ftpin\' v adresáøi \'/archives\', aby se zamezilo konfliktu s cestami ke starım slokám.<br /><br />Nastavení bylo zmìnìno, aby ukazovalo na nové adresáøe a dále nelze mìnit.<br />Odstraòte prosím ruènì staré adresáøe.<br />');
@define('PLUGIN_DOWNLOADMANAGER_ALLFILES_COPY_NEWDIR_REMEMBER', 'Úspìšnì jste zmìnili plugin, aby novì pracoval pouze s novımi adresáøi.<br /><br />Nezapomeòte prosím ruènì pøesunout soubory do novıch adresáøù \'archives/.dlm/files\' a \'archives/.dlm/ftpin\'!<br />Také ruènì odstraòte staré adresáøe.<br />');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MARK', 'oznaèit/odznaèit vše');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MARK_TITLE', 'smazat všechny oznaèené');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MOVE_TITLE', 'pøesunout všechny oznaèené do kategorie');
@define('PLUGIN_DOWNLOADMANAGER_CLEAR_TRASH', 'Vymazat bin v adresáøi ftp/koš');
@define('PLUGIN_DOWNLOADMANAGER_NO_TRASH', 'ádné soubory k vymazání v adresáøi ftp/koš');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_CF_CHANGE', 'Zmìnit název kategorie pøímo v políèku / <em>Enter</em>');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', 'Pro zobrazení a manipulaci s adresáøem ftp/koš vyberte podkategorii v koøenové sloce.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_MULTI', 'Všechny soubory f adresáøi ftp/koš budou teï smazány!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_SINGLE', 'Po stisku èerveného tlaèítka bude provedeno mazání!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_ERASE', 'Všechny soubory oznaèené k mazání budou <b>pøesunuty</b> do adresáøe ftp/koš,<br />&nbsp;&nbsp;&nbsp;aby omylem nedošlo k nevratnému znièení souborù!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_KEEP', 'Ponechat soubory, ale nezobrazovat je na pøehledové stránce? Pøesuòte je do koøenového adresáøe,<br />&nbsp;&nbsp;&nbsp;nebo vytvoøte skrytı podadresáø! Pamatujte, e máte 2 volby v nastavení<br />&nbsp;&nbsp;&nbsp;tıkající se registrovanım a pøihlášenıch uivatelù a toho, co se jim bude zobrazovat.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_TRASH', 'Pouijte tlaèátko s modrım košem k vyèištìní adresáøe ftp/koš po skonèení práce!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_MOVE', 'Pouijte adresáø ftp/koš k jednoduchému pøesunu více souborù mezi adresáøi!<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. pošlete soubory do ftp/koš pomocí <b>oznaèit</b> <em>a</em> <b>smazat</b>;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. v kategoriích vyberte jinı podadresáø;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. otevøete ftp/koš a pøesuòte soubory pomocí <b>oznaèit</b> <em>a</em> <b>pøesunout</b>.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_DESC', 'Pøi odinstalování pluginu budou všechny databázové tabulky související s pluginem smazány!');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE_RENAME', 'Pøejmenovat tento soubor');
@define('PLUGIN_DOWNLOADMANAGER_BACK_ROOT', 'Koøenová kategorie');
@define('PLUGIN_DOWNLOADMANAGER_BACK_CURRENT', 'Aktuální kategorie');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_CHANGE', 'Zmìnit jméno souboru pod soubor-odkaz editovat-podstránka.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_LFTP', 'Nahrát soubory pomocí ftp do adresáøe /serendipity/archives/.dlm/ftpin folder.');