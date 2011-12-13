<?php # $Id: lang_it.inc.php,v 1.3 2007/08/13 09:53:12 garvinhicking Exp $

# (c) 2005 by Alexander 'dma147' Mieland, http://blog.linux-stats.org, <dma147@linux-stats.org>
# Contact me on IRC in #linux-stats, #archlinux, #archlinux.de, #s9y on irc.freenode.net

# italian language file



@define("PLUGIN_DOWNLOADMANAGER_TITLE", "Downloadmanager");
@define("PLUGIN_DOWNLOADMANAGER_DESC", "Aggiunge le funzionalita' di downloadmanager a s9y. Quando viene disinstallato, tutte le tabelle vengono eliminate!");
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE', 'Titolo della pagina');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE_BLAHBLAH', 'Titolo della pagina');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE', 'Descrizione');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE_BLAHBLAH', 'Descrizione della pagina.');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL', 'URL Statico');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL_BLAHBLAH', "Definisce l'URL della pagina (index.php?serendipity[subpage]=name)");
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK', 'Permalink');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK_BLAHBLAH', "Definisce un permalink per l'URL che puo' essere piu' corto dell'URL statico. Deve essere un path HTTP assoluto e finire con .htm o .html! (defaults [http://blog/]downloads.html)");
@define("PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH", "Path di upload");
@define("PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH_BLAHBLAH", "Indirizzo completo e assoluto della directory di upload. (L'indirizzo deve esistere ed essere scrivibile dal server!)");
@define("PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH", "Path di download");
@define("PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH_BLAHBLAH", "Indirizzo completo e assoluto della directory di download. (L'indirizzo deve esistere ed essere scrivibile dal server!)");
@define("PLUGIN_DOWNLOADMANAGER_HTTPPATH", "http path to plugin");
@define("PLUGIN_DOWNLOADMANAGER_HTTPPATH_BLAHBLAH", "absolute http path to plugin (usually \"/plugins/serendipity_event_downloadmanager\").");
@define("PLUGIN_DOWNLOADMANAGER_DATEFORMAT", "Formato della data, utilizza la sintassi di PHP date(). (Italiana: \"d/m/Y, h:ia\")");
@define("PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE", "Visualizza la data del file");
@define("PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE_BLAHBLAH", "Visualizzare la data del file nell'elenco?");
@define("PLUGIN_DOWNLOADMANAGER_SHOWFILENAME", "Visualizza il nome del file");
@define("PLUGIN_DOWNLOADMANAGER_SHOWFILENAME_BLAHBLAH", "Visualizzare il nome del file nell'elenco?");
@define("PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE", "Visualizza la dimensione del file");
@define("PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE_BLAHBLAH", "Visualizzare la dimensione del file nell'elenco?");
@define("PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS", "Visualizza numero di download");
@define("PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS_BLAHBLAH", "Visualizzare il numero di download nelle elenco?");
@define("PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD", "Etichetta del campo nome file");
@define("PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD_BLAHBLAH", "Ccambia l'etichetta del campo nome file qui'");
@define("PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD", "Etichetta del campo dimensione file");
@define("PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD_BLAHBLAH", "Cambia l'etichetta del campo dimensione file qui'");
@define("PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD", "Etichetta del campo data del file");
@define("PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD_BLAHBLAH", "Cambia l'etichetta del campo data del file qui'");
@define("PLUGIN_DOWNLOADMANAGER_DLS_FIELD", "Etichetta del campo numero di download");
@define("PLUGIN_DOWNLOADMANAGER_DLS_FIELD_BLAHBLAH", "Cambia l'etichetta del campo numero di download qui'");
@define("PLUGIN_DOWNLOADMANAGER_ICONWIDTH", "Larghezza icona");
@define("PLUGIN_DOWNLOADMANAGER_ICONWIDTHBLAH", "Larghezza dell'icona del file nell'elenco");
@define("PLUGIN_DOWNLOADMANAGER_ICONHEIGHT", "Altezza icona");
@define("PLUGIN_DOWNLOADMANAGER_ICONHEIGHT_BLAHBLAH", "Altezza dell'icona del file nell'elenco");
@define("PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED", "Visualizza categorie nascoste agli utenti registrati?");
@define("PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED_BLAHBLAH", "Visualizzare le categorie nascoste agli utenti registrati?");

@define("PLUGIN_DOWNLOADMANAGER_NO_CATS_FOUND", "Nessuna categoria presente!");
@define("PLUGIN_DOWNLOADMANAGER_CATEGORIES", "Categorie");
@define("PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES", "Sotto-categorie");
@define("PLUGIN_DOWNLOADMANAGER_CATEGORY", "Categoria");
@define("PLUGIN_DOWNLOADMANAGER_NUMBER_OF_DOWNLOADS", "# file");
@define("PLUGIN_DOWNLOADMANAGER_CATNAME", "Nome Categoria:");
@define("PLUGIN_DOWNLOADMANAGER_SUBCAT_OF", "Sotto-categoria di:");
@define("PLUGIN_DOWNLOADMANAGER_ADD_CAT", "Aggiungi nuova categoria");
@define("PLUGIN_DOWNLOADMANAGER_DEL_FILE", "Elimina questo file...");
@define("PLUGIN_DOWNLOADMANAGER_DEL_CAT", "Elimina questa categoria (e tutti i file contenuti!)...");
@define("PLUGIN_DOWNLOADMANAGER_DEL_CAT_NOT_ALLOWD", "Eliminazione non permessa! ... sono presenti sotto-categorie!");
@define("PLUGIN_DOWNLOADMANAGER_DELETE_NOT_ALLOWED", "Questa categoria non pu essere eliminata, perche' contiene almeno una sotto-categoria!");
@define("PLUGIN_DOWNLOADMANAGER_CAT_NOT_FOUND", "Categoria non trovata!");
@define("PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT", "Download in questa categoria");
@define("PLUGIN_DOWNLOADMANAGER_BACK", "Indietro...");
@define("PLUGIN_DOWNLOADMANAGER_FILENAME", "Nome file");
@define("PLUGIN_DOWNLOADMANAGER_FILESIZE", "Dimensione file");
@define("PLUGIN_DOWNLOADMANAGER_FILEDATE", "Data");
@define("PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS", "dls");
@define("PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS_BLAH", "Numero di download");
@define("PLUGIN_DOWNLOADMANAGER_IMPORT_FILE", "Importa questo file dalla directory di upload in questa categoria...");
@define("PLUGIN_DOWNLOADMANAGER_COPY_NOT_ALLOWED", "Impossibile copiare il file dalla directory di upload alla directory di download!<br />Pu essere causato dall'impostazione safe_mode attivata nel tuo php.ini.<br />Disattivareafe_mode to use this feature!");
@define("PLUGIN_DOWNLOADMANAGER_DELETE_IN_INCOMING_NOT_ALLOWED", "Impossibile eliminare il file dalla directory di upload! Elimina il file manualmente e configura i permessi per permettere l'eliminazione dei file.");
@define("PLUGIN_DOWNLOADMANAGER_DELETE_IN_DOWNLOADDIR_NOT_ALLOWED", "Impossibile eliminare il file dalla directory di download! Configura i permessi per permettere l'eliminazione dea file.");
@define("PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE", "Directory di upload:");
@define("PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE_BLAHBLAH", "Utilizza questa directory per caricare i file via FTP se non hai i diritti di caricare i file via php-upload. Il file potrebbe essere piu' grande del massimo valore settato in php.ini o se file_uploads sono disattivati nel php.ini.<br />Current directory: ");
@define("PLUGIN_DOWNLOADMANAGER_THIS_FILE", "File selezionato");
@define("PLUGIN_DOWNLOADMANAGER_EDIT_FILE", "Modifica questo file");
@define("PLUGIN_DOWNLOADMANAGER_MOVE_TO_CAT", "Muovi in");
@define("PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC", "Descrizione file");
@define("PLUGIN_DOWNLOADMANAGER_FILE_EDITED", "File modifica e salvato!");
@define("PLUGIN_DOWNLOADMANAGER_DOWNLOAD_FILE", "Scarica questo file!");
@define("PLUGIN_DOWNLOADMANAGER_UPLOAD_FILE", "Carica file...");
@define("PLUGIN_DOWNLOADMANAGER_FILE", "File");
@define("PLUGIN_DOWNLOADMANAGER_UPLOAD_NOT_ALLOWED", "Impossibile caricare file!<br />Attiva file_uploads in php.ini (file_uploads)!");
@define("PLUGIN_DOWNLOADMANAGER_ERRORS_OCCOURED", "Riscontrati errori nel caricamento del file!");
@define("PLUGIN_DOWNLOADMANAGER_ERRORS_NOTCOPIED", "Questi file non possono essere copiati:");
@define("PLUGIN_DOWNLOADMANAGER_ERRORS_TOOBIG", "Questi file sono troppo grandi:");
@define("PLUGIN_DOWNLOADMANAGER_NO_FILES_UPLOADED", "Nessun file caricato trovato!");
@define("PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY", "File nella libreria dei media");
@define("PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY_BLAHBLAH", "Puoi importare i file caricati dalla libreria dei media in downloadmanager. Nota: I file non vengono mossi, vengono solo copiati!<br />Directory corrente: ");
@define("PLUGIN_DOWNLOADMANAGER_HIDE_TREE", "Nascondi questa categoria e tutte le sotto-categorie contenute...");
@define("PLUGIN_DOWNLOADMANAGER_UNHIDE_TREE", "Visualizza questa categoria e tutte le sotto-categorie contenute...");
@define("PLUGIN_DOWNLOADMANAGER_OPEN_CAT", "Clicca per aprire questa categoria per caricare e modificare i file...");


?>
