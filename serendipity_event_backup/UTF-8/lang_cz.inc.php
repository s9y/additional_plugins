<?php # lang_cz.inc.php 1.0 2009-05-25 22:12:09 VladaAjgl $

/**
 *  @version 1.0
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/25
 */

@define('PLUGIN_BACKUP_TITLE', 'Zálohování');
@define('PLUGIN_BACKUP_DESC', 'Zpřístupňuje možnost automatického zálohování Serendepity - databázových tabulek i souborů. V současnosti je podporována pouze databáze MySQL(i). VAROVÁNÍ: Plugin nefunguje optimálně s velkou databází nebo velkým množstvím souborů.');
@define('PLUGIN_BACKUP_ABSPATH_BACKUPDIR', 'Absolutní cesta k adresáři pro zálohy');
@define('PLUGIN_BACKUP_ABSPATH_BACKUPDIR_BLAHBLAH', 'Tento adresář by měl být mimo adresář s webovými stránkami. Webserver musí mít práva zápisu do tohoto adresáře!');

@define('PLUGIN_BACKUP_NOT_FOUND', 'Záloha nenalezena');
@define('PLUGIN_BACKUP_SQL_RECOVERED', 'Záloha SQL obnovena');
@define('PLUGIN_BACKUP_AUTO_SQL_BACKUP_STARTED', 'Automatické zálohování SQL databáze spuštěno');
@define('PLUGIN_BACKUP_AUTO_SQL_BACKUP_STOPPED', 'Automatické zálohování SQL databáze zastaveno');
@define('PLUGIN_BACKUP_AUTO_SQL_DELETE_STARTED', 'Automatické mazání SQL databáze spuštěno');
@define('PLUGIN_BACKUP_AUTO_SQL_DELETE_STOPPED', 'Automatické mazání SQL databáze zastaveno');
@define('PLUGIN_BACKUP_SQL_SAVED', 'Záloha SQL databáze uložena');
@define('PLUGIN_BACKUP_HTML_RECOVERED', 'Záloha HTML obnovena');
@define('PLUGIN_BACKUP_AUTO_HTML_BACKUP_STARTED', 'Automatické zálohování HTML stránek spuštěno');
@define('PLUGIN_BACKUP_AUTO_HTML_BACKUP_STOPPED', 'Automatické zálohování HTML stránek zastaveno');
@define('PLUGIN_BACKUP_AUTO_HTML_DELETE_STARTED', 'Automatické mazání HTML stránek spuštěno');
@define('PLUGIN_BACKUP_AUTO_HTML_DELETE_STOPPED', 'Automatické mazání HTML stránek zastaveno');
@define('PLUGIN_BACKUP_HTML_SAVED', 'Záloha HTML souborů uložena');
@define('PLUGIN_BACKUP_PLEASE_CHOOSE', 'vyberte prosím');
@define('PLUGIN_BACKUP_STRUCT_AND_DATA', 'Struktura a data');
@define('PLUGIN_BACKUP_ONLY_STRUCT', 'Pouze struktura');
@define('PLUGIN_BACKUP_ONLY_DATA', 'Pouze data');
@define('PLUGIN_BACKUP_WITH_DROP_TABLE', 'Včetně smazání tabulek (DROP TABLE)');
@define('PLUGIN_BACKUP_ZIPPED', 'sbaleno - gzip');
@define('PLUGIN_BACKUP_WHOLE_DATABASE', 'Celá databáze');
@define('PLUGIN_BACKUP_START_BACKUP', 'Spustit zálohování...');
@define('PLUGIN_BACKUP_MINUTES', 'minuty');
@define('PLUGIN_BACKUP_HOUR', 'hodina');
@define('PLUGIN_BACKUP_HOURS', 'hodiny');
@define('PLUGIN_BACKUP_DAYS', 'dny');
@define('PLUGIN_BACKUP_WEEKS', 'týdny');
@define('PLUGIN_BACKUP_EVERY', 'každý');
@define('PLUGIN_BACKUP_MONTHS', 'měsíce');
@define('PLUGIN_BACKUP_AUTO_BACKUP', 'Automatické zálohování');
@define('PLUGIN_BACKUP_ACTIVATE_AUTO_BACKUP', 'Aktivovat automatické zálohování');
@define('PLUGIN_BACKUP_TIME_BET_BACKUPS', 'Perioda zálohování');
@define('PLUGIN_BACKUP_DEL_OLD_BACKUPS', 'Mazat staré zálohy');
@define('PLUGIN_BACKUP_ACTIVATE_AUTO_DELETE', 'Aktivovat automatické mazání starých záloh');
@define('PLUGIN_BACKUP_OLDER_THAN', 'Zálohy starší než');
@define('PLUGIN_BACKUP_WILL_BE_DELETED', 'budou smazány');
@define('PLUGIN_BACKUP_FILENAME', 'Jméno souboru');
@define('PLUGIN_BACKUP_FILESIZE', 'Velikost');
@define('PLUGIN_BACKUP_DATE', 'Datum');
@define('PLUGIN_BACKUP_OPTION', 'Volba');
@define('PLUGIN_BACKUP_RECOVER_THIS', 'Obnovit databázi pomocí této zálohy...');
@define('PLUGIN_BACKUP_DELETE', 'Smazat');
@define('PLUGIN_BACKUP_NO_BACKUPS', 'žádné zálohy');
@define('PLUGIN_BACKUP_WHOLE_BLOG', 'Celá Serendipity');
@define('PLUGIN_BACKUP_SQL_BACKUP', 'Záloha SQL databáze');
@define('PLUGIN_BACKUP_HTML_BACKUP', 'Záloha HTML souborů');

?>
