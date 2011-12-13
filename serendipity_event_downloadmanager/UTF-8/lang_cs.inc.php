<?php # lang_cs.inc.php 1.2 2011-08-21 14:20:03 VladaAjgl $

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
@define('PLUGIN_DOWNLOADMANAGER_DESC', 'Zajišťuje Serendipity všechny funkce download managera. Při odinstalování jsou odstraněny všechny tabulky z databáze (ztráta všech dat)!!!');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE', 'Titulek');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE_BLAHBLAH', 'tj. to, co se zobrazuje v informačním pruhu okna prohlížeče ještě nad menu');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE', 'Nadpis');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE_BLAHBLAH', 'tj. to, co je napsáno tučným velkým písmem jako název stránky blogu');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL', 'Statická URL adresa');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL_BLAHBLAH', 'Definuje URL, pod kterou je download manažer přístupný (index.php?serendipity[subpage]=zde_zadané_jméno)');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK', 'Permalink (stálý odkaz)');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK_BLAHBLAH', 'Definuje stálou zkratku, která může být kratší a srozumitelnější než statická URL adresa (nastavené výše). Je třeba zadat absolutní HTTP cestu, navíc musí končit .htm nebo .html! (Výchozí nastavení: [http://vas_blog.cz/]downloads.html]');
@define('PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH', 'Cesta pro příchozí data');
@define('PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH_BLAHBLAH', 'Plná absolutní cesta k adresáři, do kterého nahráváte soubory. Plugin pracuje tak, že do tohoto adresáře se nahrají soubory a teprve pak určíte, které mají být nabízené ke stažení. Ty si pak plugin přemístí do adresáře s downloady. (Adresář musí být vytvořen a webserver do něj musí mít právo zápisu!)');
@define('PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH', 'Absolutní cesta adresáře s downloady');
@define('PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH_BLAHBLAH', 'Plná absolutní cesta k adresáři, do kterého si bude downloadmanager umísťovat soubory, které pak budou přístupné z blogu. (Adresář musí být vytvořen a webserver do něj musí mít právo zápisu!)');
@define('PLUGIN_DOWNLOADMANAGER_HTTPPATH', 'HTTP cesta k pluginu');
@define('PLUGIN_DOWNLOADMANAGER_HTTPPATH_BLAHBLAH', 'aboslutní http cesta k pluginu (obvykle "/plugins/serendipity_event_downloadmanager").');
@define('PLUGIN_DOWNLOADMANAGER_DATEFORMAT', 'Formát data, podle pravidel PHP funkce date(). (výchozí: "Y/m/d, h:ia")');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE', 'Zobrazovat datum souboru');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE_BLAHBLAH', 'Má se v seznamu souborů zobrazovat datum souboru?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILENAME', 'Zobrazovat jméno souboru');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILENAME_BLAHBLAH', 'Má se v seznamu souborů zobrazovat jméno souboru?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE', 'Zobrazovat velikost');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE_BLAHBLAH', 'Má se v seznamu souborů zobrazovat velikost souboru?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS', 'Počet stažení souboru');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS_BLAHBLAH', 'Má se v seznamu souborů zobrazovat počet stažení souboru?');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD', 'Popis políčka se jménem souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD_BLAHBLAH', 'Zde můžete změnit popis políčka se jménem souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD', 'Popis políčka s velikostí');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD_BLAHBLAH', 'Zde můžete změnit popis políčka s velikostí souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD', 'Popis políčka s datem');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD_BLAHBLAH', 'Zde můžete změnit popis políčka s datem vytvoření souboru');
@define('PLUGIN_DOWNLOADMANAGER_DLS_FIELD', 'Popis políčka s počtem stažení');
@define('PLUGIN_DOWNLOADMANAGER_DLS_FIELD_BLAHBLAH', 'Zde můžete změnit popis políčka s počtem stažení souboru');
@define('PLUGIN_DOWNLOADMANAGER_ICONWIDTH', 'Šířka ikony');
@define('PLUGIN_DOWNLOADMANAGER_ICONWIDTHBLAH', 'Šířka ikon typu souboru v seznamu souborů');
@define('PLUGIN_DOWNLOADMANAGER_ICONHEIGHT', 'Výška ikony');
@define('PLUGIN_DOWNLOADMANAGER_ICONHEIGHT_BLAHBLAH', 'Šířka ikon typu souboru v seznamu souborů');
@define('PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED', 'Zobrazovat registrovaným uživatelům skryté kategorie?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED_BLAHBLAH', 'Mají se skryté kategorie zobrazovat registrovaným a přihlášeným uživatelům?');

@define('PLUGIN_DOWNLOADMANAGER_NO_CATS_FOUND', 'Žádné kategorie');
@define('PLUGIN_DOWNLOADMANAGER_CATEGORIES', 'Kategorie');
@define('PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES', 'Podkategorie');
@define('PLUGIN_DOWNLOADMANAGER_CATEGORY', 'Kategorie');
@define('PLUGIN_DOWNLOADMANAGER_NUMBER_OF_DOWNLOADS', 'počet souborů');
@define('PLUGIN_DOWNLOADMANAGER_CATNAME', 'Jméno kategorie:');
@define('PLUGIN_DOWNLOADMANAGER_SUBCAT_OF', 'Podkategorie v:');
@define('PLUGIN_DOWNLOADMANAGER_ADD_CAT', 'Přidat novou kategorii');
@define('PLUGIN_DOWNLOADMANAGER_DEL_FILE', 'Smazat soubor...');
@define('PLUGIN_DOWNLOADMANAGER_DEL_CAT', 'Smazat kategorii (a všechny soubory v ní obsažené!)...');
@define('PLUGIN_DOWNLOADMANAGER_DEL_CAT_NOT_ALLOWD', 'Smazání není možné - kategorie obsahuje podkategorie!');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_NOT_ALLOWED', 'Tato kategorie nemůže být smazána, protože obsahuje alespoň jednu další podkategorii!');
@define('PLUGIN_DOWNLOADMANAGER_CAT_NOT_FOUND', 'Kategorie nenalezena!');
@define('PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT', 'Soubory v této kategorii');
@define('PLUGIN_DOWNLOADMANAGER_BACK', 'Zpět...');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME', 'Jméno souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE', 'Velikost');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE', 'Datum');
@define('PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS', 'počet stažení');
@define('PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS_BLAH', 'Počet stažení');
@define('PLUGIN_DOWNLOADMANAGER_IMPORT_FILE', 'Importovat soubor z příchozího adresáře do aktuální kategorie...');
@define('PLUGIN_DOWNLOADMANAGER_COPY_NOT_ALLOWED', 'Nelze zkopírovat soubor z příchozího adresáře!<br />Důvodem může být např. aktivovaný safe_mode.<br />Pro používání této funkce je třeba deaktivovat safe_mode!');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_IN_INCOMING_NOT_ALLOWED', 'Webserver nemá dostatek oprávnění pro smazání souboru z příchozího adresáře! Smažte prosím soubor ručně a potom pozměňte přístupová práva, aby to od příště šlo.');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_IN_DOWNLOADDIR_NOT_ALLOWED', 'Webserver nemá dostatek oprávnění pro smazání souboru z  adresáře downloadů! Pozměňte přístupová práva, pak opakujte pokus o smazání.');
@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE', 'Příchozí adresář:');
@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE_BLAHBLAH', 'Nahrajte soubor do tohoto adresáře pomocí FTP, pokud Vám nejde nahrát pomocí funkce php-upload. To se může stát např. pokud je soubor příliš velký. Php má totiž omezení na max. velikost uploadovaného souboru - nastavení v php.ini.<br />Aktuální adresář: ');
@define('PLUGIN_DOWNLOADMANAGER_THIS_FILE', 'Vybraný soubor');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE', 'Editovat soubor');
@define('PLUGIN_DOWNLOADMANAGER_MOVE_TO_CAT', 'Přesunout do');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC', 'Popis souboru');
@define('PLUGIN_DOWNLOADMANAGER_FILE_EDITED', 'Soubor úspěšně změněn a uložen!');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_FILE', 'Stáhnout soubor');
@define('PLUGIN_DOWNLOADMANAGER_UPLOAD_FILE', 'Nahrát soubory...');
@define('PLUGIN_DOWNLOADMANAGER_FILE', 'Soubor');
@define('PLUGIN_DOWNLOADMANAGER_UPLOAD_NOT_ALLOWED', 'Nahrávání souborů není povoleno!<br />Povolte je v php.ini (file_uploads)!');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_OCCOURED', 'Během nahrávání souboru se vyskytly chyby!');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_NOTCOPIED', 'Následující soubory nemohly být překopírovány:');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_TOOBIG', 'Následující soubory jsou příliš velké:');
@define('PLUGIN_DOWNLOADMANAGER_NO_FILES_UPLOADED', 'Žádné uploadované soubory nebyly nalezeny!');
@define('PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY', 'Soubory z knihovny médií');
@define('PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY_BLAHBLAH', 'Do downloadmanagera můžete přidat soubory, které jsou již nahrané v knihovně médií. Pozn.: Tyto soubory se nebudou přemísťovat, pouze se zkopírují a zůstanou i v původním adresáři!<br />Aktuální adresář: ');
@define('PLUGIN_DOWNLOADMANAGER_HIDE_TREE', 'Skrýt celý podstrom této kategorie...');
@define('PLUGIN_DOWNLOADMANAGER_UNHIDE_TREE', 'Zobrazit celý podstrom této kategorie...');
@define('PLUGIN_DOWNLOADMANAGER_OPEN_CAT', 'Kliknutí otevře kategorii pro upload a editaci souborů...');

@define('PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST',       'Zobrazit popis souborů v seznamu souborů ke stažení');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST_DESC',  'Pokud chcete generovat krátký seznam souborů, vypněte tuto volbu. Pokud chcete poskytnout ke každému souboru podrobnější informace, volbu zapněte.');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST',       'Přímý download');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_DESC',  'Výchozí chování downloadmanagera je, že před stažením souboru zobrazí stránku s informacemi. Pomocí tohoto nastavení můžete umožnit přeskočit tuto stránku rovnou na stahování souboru. Stahování začne jak po kliknutí na jméno souboru, tak na ikonku.');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NO',    'Info-stránka');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_ICON',  'Přímé stahování po kliknutí na ikonu');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NAME',  'Přímé stahování po kliknutí na jméno souboru');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_BOTH',  'Přímé stahování po kliknutí na obojí');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING',          'Nové verze existujících souborů...');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_DESC',     'Pokud uploadujete soubor, který už existuje, má se vytvořit nový soubor, nebo jen obnovit informace u již existujícího?');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_INSERT',   'vytvořit nový soubor');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_UPDATE',   'aktualizovat starý');

// Next lines were translated on 2010/09/28

@define('PLUGIN_DOWNLOADMANAGER_BACKEND_TITLE', 'Downloadmanager verze %s - Administrační menu');
@define('PLUGIN_DOWNLOADMANAGER_INTRO', 'Úvodní text (nepovinné)');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY', 'Obecné: zobrazovat data pouze registrovaným uživatelům');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_BLAHBLAH', 'Chcete, aby přehled kategorií a souborů ke stažení byl zobrazován pouze registrovaným a přihlášeným uživatelům?');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_ERROR', 'Soubory ke stažení jsou přístupné pouze registrovaným uživatelům!');
@define('PLUGIN_DOWNLOADMANAGER_ROOTLEVEL_TITLE', 'soubory v kořenovém adresáři (v přehledu schované, neviditelné!)');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_UPGRADE_NOTCOPIED', 'Omlouváme se, vyskytla se chyba. Soubory z <br /><em>%s</em><br />nemohly být přesunuty do<br /><em>%s</em>.<br /><br />Přesuňte je proím ručně a klikněte na <a class="backend_error_link" href="%s">tento odkaz</a>, abyste o přesunu informovali plugin!<br />Kromě toho odstraňte ručně také staré adresáře.<br />');
@define('PLUGIN_DOWNLOADMANAGER_ALLFILES_COPIED_NEWDIR', 'Protože jste aktualizovali plugin downloadmanager na verzi 0.24, byly všechny soubory ke stažený zkopírovány do nových podadresářů \'/.dlm/files\' a \'/.dlm/ftpin\' v adresáři \'/archives\', aby se zamezilo konfliktu s cestami ke starým složkám.<br /><br />Nastavení bylo změněno, aby ukazovalo na nové adresáře a dále nelze měnit.<br />Odstraňte prosím ručně staré adresáře.<br />');
@define('PLUGIN_DOWNLOADMANAGER_ALLFILES_COPY_NEWDIR_REMEMBER', 'Úspěšně jste změnili plugin, aby nově pracoval pouze s novými adresáři.<br /><br />Nezapomeňte prosím ručně přesunout soubory do nových adresářů \'archives/.dlm/files\' a \'archives/.dlm/ftpin\'!<br />Také ručně odstraňte staré adresáře.<br />');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MARK', 'označit/odznačit vše');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MARK_TITLE', 'smazat všechny označené');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MOVE_TITLE', 'přesunout všechny označené do kategorie');
@define('PLUGIN_DOWNLOADMANAGER_CLEAR_TRASH', 'Vymazat bin v adresáři ftp/koš');
@define('PLUGIN_DOWNLOADMANAGER_NO_TRASH', 'Žádné soubory k vymazání v adresáři ftp/koš');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_CF_CHANGE', 'Změnit název kategorie přímo v políčku / <em>Enter</em>');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', 'Pro zobrazení a manipulaci s adresářem ftp/koš vyberte podkategorii v kořenové složce.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_MULTI', 'Všechny soubory f adresáři ftp/koš budou teď smazány!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_SINGLE', 'Po stisku červeného tlačítka bude provedeno mazání!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_ERASE', 'Všechny soubory označené k mazání budou <b>přesunuty</b> do adresáře ftp/koš,<br />&nbsp;&nbsp;&nbsp;aby omylem nedošlo k nevratnému zničení souborů!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_KEEP', 'Ponechat soubory, ale nezobrazovat je na přehledové stránce? Přesuňte je do kořenového adresáře,<br />&nbsp;&nbsp;&nbsp;nebo vytvořte skrytý podadresář! Pamatujte, že máte 2 volby v nastavení<br />&nbsp;&nbsp;&nbsp;týkající se registrovaným a přihlášených uživatelů a toho, co se jim bude zobrazovat.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_TRASH', 'Použijte tlačátko s modrým košem k vyčištění adresáře ftp/koš po skončení práce!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_MOVE', 'Použijte adresář ftp/koš k jednoduchému přesunu více souborů mezi adresáři!<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. pošlete soubory do ftp/koš pomocí <b>označit</b> <em>a</em> <b>smazat</b>;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. v kategoriích vyberte jiný podadresář;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. otevřete ftp/koš a přesuňte soubory pomocí <b>označit</b> <em>a</em> <b>přesunout</b>.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_DESC', 'Při odinstalování pluginu budou všechny databázové tabulky související s pluginem smazány!');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE_RENAME', 'Přejmenovat tento soubor');
@define('PLUGIN_DOWNLOADMANAGER_BACK_ROOT', 'Kořenová kategorie');
@define('PLUGIN_DOWNLOADMANAGER_BACK_CURRENT', 'Aktuální kategorie');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_CHANGE', 'Změnit jméno souboru pod soubor-odkaz editovat-podstránka.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_LFTP', 'Nahrát soubory pomocí ftp do adresáře /serendipity/archives/.dlm/ftpin folder.');