<?php # lang_cz.inc.php 1.2 2011-08-21 14:20:03 VladaAjgl $

/**
 *  @version 1.2
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/22
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/09/28
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/08/21
 */

@define('PLUGIN_DOWNLOADMANAGER_TITLE', 'Downloadmanager');
@define('PLUGIN_DOWNLOADMANAGER_DESC', 'Zaji¹»uje Serendipity v¹echny funkce download managera. Pøi odinstalování jsou odstranìny v¹echny tabulky z databáze (ztráta v¹ech dat)!!!');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE', 'Titulek');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE_BLAHBLAH', 'tj. to, co se zobrazuje v informaèním pruhu okna prohlí¾eèe je¹tì nad menu');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE', 'Nadpis');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE_BLAHBLAH', 'tj. to, co je napsáno tuèným velkým písmem jako název stránky blogu');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL', 'Statická URL adresa');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL_BLAHBLAH', 'Definuje URL, pod kterou je download mana¾er pøístupný (index.php?serendipity[subpage]=zde_zadané_jméno)');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK', 'Permalink (stálý odkaz)');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK_BLAHBLAH', 'Definuje stálou zkratku, která mù¾e být krat¹í a srozumitelnìj¹í ne¾ statická URL adresa (nastavené vý¹e). Je tøeba zadat absolutní HTTP cestu, navíc musí konèit .htm nebo .html! (Výchozí nastavení: [http://vas_blog.cz/]downloads.html]');
@define('PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH', 'Cesta pro pøíchozí data');
@define('PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH_BLAHBLAH', 'Plná absolutní cesta k adresáøi, do kterého nahráváte soubory. Plugin pracuje tak, ¾e do tohoto adresáøe se nahrají soubory a teprve pak urèíte, které mají být nabízené ke sta¾ení. Ty si pak plugin pøemístí do adresáøe s downloady. (Adresáø musí být vytvoøen a webserver do nìj musí mít právo zápisu!)');
@define('PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH', 'Absolutní cesta adresáøe s downloady');
@define('PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH_BLAHBLAH', 'Plná absolutní cesta k adresáøi, do kterého si bude downloadmanager umís»ovat soubory, které pak budou pøístupné z blogu. (Adresáø musí být vytvoøen a webserver do nìj musí mít právo zápisu!)');
@define('PLUGIN_DOWNLOADMANAGER_HTTPPATH', 'HTTP cesta k pluginu');
@define('PLUGIN_DOWNLOADMANAGER_HTTPPATH_BLAHBLAH', 'aboslutní http cesta k pluginu (obvykle "/plugins/serendipity_event_downloadmanager").');
@define('PLUGIN_DOWNLOADMANAGER_DATEFORMAT', 'Formát data, podle pravidel PHP funkce date(). (výchozí: "Y/m/d, h:ia")');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE', 'Zobrazovat datum souboru');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE_BLAHBLAH', 'Má se v seznamu souborù zobrazovat datum souboru?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILENAME', 'Zobrazovat jméno souboru');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILENAME_BLAHBLAH', 'Má se v seznamu souborù zobrazovat jméno souboru?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE', 'Zobrazovat velikost');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE_BLAHBLAH', 'Má se v seznamu souborù zobrazovat velikost souboru?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS', 'Poèet sta¾ení souboru');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS_BLAHBLAH', 'Má se v seznamu souborù zobrazovat poèet sta¾ení souboru?');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD', 'Popis políèka se jménem souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD_BLAHBLAH', 'Zde mù¾ete zmìnit popis políèka se jménem souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD', 'Popis políèka s velikostí');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD_BLAHBLAH', 'Zde mù¾ete zmìnit popis políèka s velikostí souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD', 'Popis políèka s datem');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD_BLAHBLAH', 'Zde mù¾ete zmìnit popis políèka s datem vytvoøení souboru');
@define('PLUGIN_DOWNLOADMANAGER_DLS_FIELD', 'Popis políèka s poètem sta¾ení');
@define('PLUGIN_DOWNLOADMANAGER_DLS_FIELD_BLAHBLAH', 'Zde mù¾ete zmìnit popis políèka s poètem sta¾ení souboru');
@define('PLUGIN_DOWNLOADMANAGER_ICONWIDTH', '©íøka ikony');
@define('PLUGIN_DOWNLOADMANAGER_ICONWIDTHBLAH', '©íøka ikon typu souboru v seznamu souborù');
@define('PLUGIN_DOWNLOADMANAGER_ICONHEIGHT', 'Vý¹ka ikony');
@define('PLUGIN_DOWNLOADMANAGER_ICONHEIGHT_BLAHBLAH', '©íøka ikon typu souboru v seznamu souborù');
@define('PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED', 'Zobrazovat registrovaným u¾ivatelùm skryté kategorie?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED_BLAHBLAH', 'Mají se skryté kategorie zobrazovat registrovaným a pøihlá¹eným u¾ivatelùm?');

@define('PLUGIN_DOWNLOADMANAGER_NO_CATS_FOUND', '®ádné kategorie');
@define('PLUGIN_DOWNLOADMANAGER_CATEGORIES', 'Kategorie');
@define('PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES', 'Podkategorie');
@define('PLUGIN_DOWNLOADMANAGER_CATEGORY', 'Kategorie');
@define('PLUGIN_DOWNLOADMANAGER_NUMBER_OF_DOWNLOADS', 'poèet souborù');
@define('PLUGIN_DOWNLOADMANAGER_CATNAME', 'Jméno kategorie:');
@define('PLUGIN_DOWNLOADMANAGER_SUBCAT_OF', 'Podkategorie v:');
@define('PLUGIN_DOWNLOADMANAGER_ADD_CAT', 'Pøidat novou kategorii');
@define('PLUGIN_DOWNLOADMANAGER_DEL_FILE', 'Smazat soubor...');
@define('PLUGIN_DOWNLOADMANAGER_DEL_CAT', 'Smazat kategorii (a v¹echny soubory v ní obsa¾ené!)...');
@define('PLUGIN_DOWNLOADMANAGER_DEL_CAT_NOT_ALLOWD', 'Smazání není mo¾né - kategorie obsahuje podkategorie!');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_NOT_ALLOWED', 'Tato kategorie nemù¾e být smazána, proto¾e obsahuje alespoò jednu dal¹í podkategorii!');
@define('PLUGIN_DOWNLOADMANAGER_CAT_NOT_FOUND', 'Kategorie nenalezena!');
@define('PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT', 'Soubory v této kategorii');
@define('PLUGIN_DOWNLOADMANAGER_BACK', 'Zpìt...');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME', 'Jméno souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE', 'Velikost');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE', 'Datum');
@define('PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS', 'poèet sta¾ení');
@define('PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS_BLAH', 'Poèet sta¾ení');
@define('PLUGIN_DOWNLOADMANAGER_IMPORT_FILE', 'Importovat soubor z pøíchozího adresáøe do aktuální kategorie...');
@define('PLUGIN_DOWNLOADMANAGER_COPY_NOT_ALLOWED', 'Nelze zkopírovat soubor z pøíchozího adresáøe!<br />Dùvodem mù¾e být napø. aktivovaný safe_mode.<br />Pro pou¾ívání této funkce je tøeba deaktivovat safe_mode!');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_IN_INCOMING_NOT_ALLOWED', 'Webserver nemá dostatek oprávnìní pro smazání souboru z pøíchozího adresáøe! Sma¾te prosím soubor ruènì a potom pozmìòte pøístupová práva, aby to od pøí¹tì ¹lo.');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_IN_DOWNLOADDIR_NOT_ALLOWED', 'Webserver nemá dostatek oprávnìní pro smazání souboru z  adresáøe downloadù! Pozmìòte pøístupová práva, pak opakujte pokus o smazání.');
@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE', 'Pøíchozí adresáø:');
@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE_BLAHBLAH', 'Nahrajte soubor do tohoto adresáøe pomocí FTP, pokud Vám nejde nahrát pomocí funkce php-upload. To se mù¾e stát napø. pokud je soubor pøíli¹ velký. Php má toti¾ omezení na max. velikost uploadovaného souboru - nastavení v php.ini.<br />Aktuální adresáø: ');
@define('PLUGIN_DOWNLOADMANAGER_THIS_FILE', 'Vybraný soubor');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE', 'Editovat soubor');
@define('PLUGIN_DOWNLOADMANAGER_MOVE_TO_CAT', 'Pøesunout do');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC', 'Popis souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILE_EDITED', 'Soubor úspì¹nì zmìnìn a ulo¾en!');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_FILE', 'Stáhnout soubor');
@define('PLUGIN_DOWNLOADMANAGER_UPLOAD_FILE', 'Nahrát soubory...');
@define('PLUGIN_DOWNLOADMANAGER_FILE', 'Soubor');
@define('PLUGIN_DOWNLOADMANAGER_UPLOAD_NOT_ALLOWED', 'Nahrávání souborù není povoleno!<br />Povolte je v php.ini (file_uploads)!');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_OCCOURED', 'Bìhem nahrávání souboru se vyskytly chyby!');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_NOTCOPIED', 'Následující soubory nemohly být pøekopírovány:');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_TOOBIG', 'Následující soubory jsou pøíli¹ velké:');
@define('PLUGIN_DOWNLOADMANAGER_NO_FILES_UPLOADED', '®ádné uploadované soubory nebyly nalezeny!');
@define('PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY', 'Soubory z knihovny médií');
@define('PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY_BLAHBLAH', 'Do downloadmanagera mù¾ete pøidat soubory, které jsou ji¾ nahrané v knihovnì médií. Pozn.: Tyto soubory se nebudou pøemís»ovat, pouze se zkopírují a zùstanou i v pùvodním adresáøi!<br />Aktuální adresáø: ');
@define('PLUGIN_DOWNLOADMANAGER_HIDE_TREE', 'Skrýt celý podstrom této kategorie...');
@define('PLUGIN_DOWNLOADMANAGER_UNHIDE_TREE', 'Zobrazit celý podstrom této kategorie...');
@define('PLUGIN_DOWNLOADMANAGER_OPEN_CAT', 'Kliknutí otevøe kategorii pro upload a editaci souborù...');

@define('PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST',       'Zobrazit popis souborù v seznamu souborù ke sta¾ení');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST_DESC',  'Pokud chcete generovat krátký seznam souborù, vypnìte tuto volbu. Pokud chcete poskytnout ke ka¾dému souboru podrobnìj¹í informace, volbu zapnìte.');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST',       'Pøímý download');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_DESC',  'Výchozí chování downloadmanagera je, ¾e pøed sta¾ením souboru zobrazí stránku s informacemi. Pomocí tohoto nastavení mù¾ete umo¾nit pøeskoèit tuto stránku rovnou na stahování souboru. Stahování zaène jak po kliknutí na jméno souboru, tak na ikonku.');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NO',    'Info-stránka');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_ICON',  'Pøímé stahování po kliknutí na ikonu');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NAME',  'Pøímé stahování po kliknutí na jméno souboru');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_BOTH',  'Pøímé stahování po kliknutí na obojí');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING',          'Nové verze existujících souborù...');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_DESC',     'Pokud uploadujete soubor, který u¾ existuje, má se vytvoøit nový soubor, nebo jen obnovit informace u ji¾ existujícího?');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_INSERT',   'vytvoøit nový soubor');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_UPDATE',   'aktualizovat starý');

// Next lines were translated on 2010/09/28

@define('PLUGIN_DOWNLOADMANAGER_BACKEND_TITLE', 'Downloadmanager verze %s - Administraèní menu');
@define('PLUGIN_DOWNLOADMANAGER_INTRO', 'Úvodní text (nepovinné)');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY', 'Obecné: zobrazovat data pouze registrovaným u¾ivatelùm');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_BLAHBLAH', 'Chcete, aby pøehled kategorií a souborù ke sta¾ení byl zobrazován pouze registrovaným a pøihlá¹eným u¾ivatelùm?');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_ERROR', 'Soubory ke sta¾ení jsou pøístupné pouze registrovaným u¾ivatelùm!');
@define('PLUGIN_DOWNLOADMANAGER_ROOTLEVEL_TITLE', 'soubory v koøenovém adresáøi (v pøehledu schované, neviditelné!)');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_UPGRADE_NOTCOPIED', 'Omlouváme se, vyskytla se chyba. Soubory z <br /><em>%s</em><br />nemohly být pøesunuty do<br /><em>%s</em>.<br /><br />Pøesuòte je proím ruènì a kliknìte na <a class="backend_error_link" href="%s">tento odkaz</a>, abyste o pøesunu informovali plugin!<br />Kromì toho odstraòte ruènì také staré adresáøe.<br />');
@define('PLUGIN_DOWNLOADMANAGER_ALLFILES_COPIED_NEWDIR', 'Proto¾e jste aktualizovali plugin downloadmanager na verzi 0.24, byly v¹echny soubory ke sta¾ený zkopírovány do nových podadresáøù \'/.dlm/files\' a \'/.dlm/ftpin\' v adresáøi \'/archives\', aby se zamezilo konfliktu s cestami ke starým slo¾kám.<br /><br />Nastavení bylo zmìnìno, aby ukazovalo na nové adresáøe a dále nelze mìnit.<br />Odstraòte prosím ruènì staré adresáøe.<br />');
@define('PLUGIN_DOWNLOADMANAGER_ALLFILES_COPY_NEWDIR_REMEMBER', 'Úspì¹nì jste zmìnili plugin, aby novì pracoval pouze s novými adresáøi.<br /><br />Nezapomeòte prosím ruènì pøesunout soubory do nových adresáøù \'archives/.dlm/files\' a \'archives/.dlm/ftpin\'!<br />Také ruènì odstraòte staré adresáøe.<br />');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MARK', 'oznaèit/odznaèit v¹e');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MARK_TITLE', 'smazat v¹echny oznaèené');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MOVE_TITLE', 'pøesunout v¹echny oznaèené do kategorie');
@define('PLUGIN_DOWNLOADMANAGER_CLEAR_TRASH', 'Vymazat bin v adresáøi ftp/ko¹');
@define('PLUGIN_DOWNLOADMANAGER_NO_TRASH', '®ádné soubory k vymazání v adresáøi ftp/ko¹');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_CF_CHANGE', 'Zmìnit název kategorie pøímo v políèku / <em>Enter</em>');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', 'Pro zobrazení a manipulaci s adresáøem ftp/ko¹ vyberte podkategorii v koøenové slo¾ce.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_MULTI', 'V¹echny soubory f adresáøi ftp/ko¹ budou teï smazány!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_SINGLE', 'Po stisku èerveného tlaèítka bude provedeno mazání!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_ERASE', 'V¹echny soubory oznaèené k mazání budou <b>pøesunuty</b> do adresáøe ftp/ko¹,<br />&nbsp;&nbsp;&nbsp;aby omylem nedo¹lo k nevratnému znièení souborù!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_KEEP', 'Ponechat soubory, ale nezobrazovat je na pøehledové stránce? Pøesuòte je do koøenového adresáøe,<br />&nbsp;&nbsp;&nbsp;nebo vytvoøte skrytý podadresáø! Pamatujte, ¾e máte 2 volby v nastavení<br />&nbsp;&nbsp;&nbsp;týkající se registrovaným a pøihlá¹ených u¾ivatelù a toho, co se jim bude zobrazovat.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_TRASH', 'Pou¾ijte tlaèátko s modrým ko¹em k vyèi¹tìní adresáøe ftp/ko¹ po skonèení práce!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_MOVE', 'Pou¾ijte adresáø ftp/ko¹ k jednoduchému pøesunu více souborù mezi adresáøi!<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. po¹lete soubory do ftp/ko¹ pomocí <b>oznaèit</b> <em>a</em> <b>smazat</b>;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. v kategoriích vyberte jiný podadresáø;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. otevøete ftp/ko¹ a pøesuòte soubory pomocí <b>oznaèit</b> <em>a</em> <b>pøesunout</b>.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_DESC', 'Pøi odinstalování pluginu budou v¹echny databázové tabulky související s pluginem smazány!');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE_RENAME', 'Pøejmenovat tento soubor');
@define('PLUGIN_DOWNLOADMANAGER_BACK_ROOT', 'Koøenová kategorie');
@define('PLUGIN_DOWNLOADMANAGER_BACK_CURRENT', 'Aktuální kategorie');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_CHANGE', 'Zmìnit jméno souboru pod soubor-odkaz editovat-podstránka.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_LFTP', 'Nahrát soubory pomocí ftp do adresáøe /serendipity/archives/.dlm/ftpin folder.');