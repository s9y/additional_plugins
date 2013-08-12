<?php # 

/**
 *  @version 
 *  @author Alberto Mucignat <alberto.mucignat@gmail.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Freetag');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Consente il libero tagging dei post');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Inserisci i tag. I tag diversi vanno separati con la virgola (,)');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Tags: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Post con tag %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Tag simili a %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED','Non ci sono tag associati.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'Tutti i tag');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Gestione tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Gestione di tutti i tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', 'Gestione dei tag \'foglie\'');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Lista dei post senza tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Lista dei post con tag \'foglie\'');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Non ci sono post senza !');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Peso');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Azione');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Rinomina');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Splitta');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Cancella');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Vuoi veramente cancellare il tag %s?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'Usa la virgola per separare i tag:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Visualizza la nuvola dei tag correlati ai post?');
@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Post simili:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','Visualizzare post simili?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','Quanti post simili devono essere visualizzati?');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Tags');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Mostra i tag associati ai post');
@define('PLUGIN_FREETAG_NEWLINE', 'Fineriga dopo ogni tag?');
@define('PLUGIN_FREETAG_XML', 'Visualizza le icone XML?');
@define('PLUGIN_FREETAG_SCALE','Scala la dimensione dei font in base alla popolaritˆ (come Technorati, Flickr)?');
@define('PLUGIN_FREETAG_UPGRADE1_2','Salvando i tag %d per il post %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Quanti tag devono essere visualizzati?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Quante occorrenze deve avere un tag per essere visibile?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Misura minima del font % di un tag nella nuvola');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Misura massima del font  % di un tag nella nuvola');
?>
