<?php # 

/**
 *  @version $Revision$
 *  @author P'tit Lu <ptitlu@ptitlu.org>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Marquage des entrées');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Autorise le marquage libre des billets');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Entrez tous les tags s\'appliquant. Séparer les tags multiples par des virgules (,)');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Tags pour ce billet: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Billets marqués comme %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Tags se rapportant au tag %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED','Pas de tags en rapport.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'Tous les tags définis');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Gérer les tags');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Gérer tous les tags');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', 'Gérer les tags \'orphelins\'');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Lister les billets non marqués');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Lister les billets marqués \'orphelins\'');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Aucune entrée non marquée');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Poids');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Action');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Renommer');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Séparer');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Effacer');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'voulez-vous vraiment effacer le tag %s ?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'Utilisez la virgule pour séparer les tags :');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Afficher le nuage de tags pour les tags en rapport ?');
@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Billets ayant les mêmes tags :');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','Afficher les billets ayant les même tags  ?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','Combien de billets doivent être affichés ?');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Nuage de tags');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Montre une liste des tags existant pour les billets');
@define('PLUGIN_FREETAG_NEWLINE', 'Retour à la ligne après chaque tag ?');
@define('PLUGIN_FREETAG_XML', 'Afficher les icones XML ?');
@define('PLUGIN_FREETAG_SCALE','Ajuster la taille du tag par rapport à sa fréquence (comme sur Technorati, flickr) ?');
@define('PLUGIN_FREETAG_UPGRADE1_2','Mise à jour des tags %d pour le billet numéro: %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Combien de tags doivent être affichés ?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Combien de fois un tag doit-il être présent pour apparaître ?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Taille de police minimale (%) d\'un tag dans le nuage');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Taille de police maximale (%) d\'un tag dans le nuage');
?>
