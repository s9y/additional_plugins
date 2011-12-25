<?php # $Id$

@define('PLUGIN_EVENT_AUTOSAVE_TITLE', 'Sauvegarde automatique');
@define('PLUGIN_EVENT_AUTOSAVE_DESC', 'Effectue une copie de sauvegarde des posts lors de leur rédaction');
@define('PLUGIN_EVENT_AUTOSAVE_STARTING', 'Autosave démarre ...');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL', 'Intervale de temps');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL_DESC', 'Temps en secondes entre 2 sauvegardes (0 pour désactiver)');
@define('PLUGIN_EVENT_AUTOSAVE_INTERVAL_ERROR', 'L\'intervale de temps doit être un entier');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH', 'URL relative du plugin');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH_DESC', 'URL relative à la racine du blog jusqu\'au plugin, sans slash en début ou fin  (en général "plugins/serendipity_event_autosave")');
@define('PLUGIN_EVENT_AUTOSAVE_HTTPATH_ERROR', 'URL incorrecte');
@define('PLUGIN_EVENT_AUTOSAVE_AJAX_ERROR', 'L\'appel AJAX au serveur a échoué ');
@define('PLUGIN_EVENT_AUTOSAVE_SAVE_ERROR', '/!\ la sauvegarde automatique a échoué ;-(');
@define('PLUGIN_EVENT_AUTOSAVE_SAVED', 'le post a été sauvegardé avec succès :-)');
@define('PLUGIN_EVENT_AUTOSAVE_ACTIVATED', 'Autosave est actif (cliquez moi pour effectuer une sauvegarde manuelle ou attendez le temps défini)');
@define('PLUGIN_EVENT_AUTOSAVE_ACTIVATING', 'Autosave se charge ...');
@define('PLUGIN_EVENT_AUTOSAVE_INIT_FAILED', 'Autosave n\'est pas initialisé correctement et ne sera pas disponible');
@define('PLUGIN_EVENT_AUTOSAVE_RECOVER', 'Le post possède une copie de secours, vous pouvez la récupérer en cliquant ici');
@define('PLUGIN_EVENT_AUTOSAVE_RECOVER_FAILED', 'La récup de la copie de sauvegarde a échoué');
@define('PLUGIN_EVENT_AUTOSAVE_BAD_SHADOW', 'L\'identifiant donné ne correspond pas à celui de la copie de secours du post');
@define('PLUGIN_EVENT_AUTOSAVE_RESTORING', 'Autosave récupère la copie de sauvegarde ...');
@define('PLUGIN_EVENT_AUTOSAVE_RESTORED', 'Le post a été rechargé avec les données sauvegardées');
@define('PLUGIN_EVENT_AUTOSAVE_BAD_RESPONSE', 'Réponse AJAX inconnue');
@define('PLUGIN_EVENT_AUTOSAVE_UNSUPPORTED_EDITOR', 'Arggg! votre editeur wysiwyg n\'est pas encore supporté :-(');
@define('PLUGIN_EVENT_AUTOSAVE_CONFIRM', 'Vous êtes sur le point de recharger votre post depuis la copie de secours, êtes-vous sûr de vouloir continuer ?');
?>
