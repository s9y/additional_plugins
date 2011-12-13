<?php # $Id: lang_fr.inc.php,v 1.1 2006/12/30 11:02:21 garvinhicking Exp $

/**
 *  @version $Revision: 1.1 $
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
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'Send X-FreeTag-HTTP-Headers');
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

@define('PLUGIN_FREETAG_META_KEYWORDS', 'Nombre de mots-clef à insérer dans lfile:///home/ptitlu/www/blog/plugins/serendipity_event_freetag/lang_fr.inc.phpe code HTML (0: désactivé)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Billets ayant les mêmes tags :');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','Afficher les billets ayant les même tags  ?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','Combien de billets doivent être affichés ?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Montrer les tags dans le pied de page ?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Si activé, les tags seront affichés dans le pied de page du billet. Si non, ils seront affichés dans le corps du billet.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Mettre les tags en minuscules.');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Tags en rapport');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'Lien Tag');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'Créer des tags pour toutes les catégories associées ?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'Si activé, les catégories dont un billet fait partie seront ajoutées en tant que tag à ce billet.');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', 'Convertir toutes les catégories assignées à des billets en tags.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', 'Catégories converties du billet #%d (%s): %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'Toutes les catogries sont converties.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Mots-clef automatisés');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'Vous pouvez assigner des mots-clef (séparatés par ",") à chaque tag. Dès que vous utilisez ces mots-clef dans le texte de vos billets, le tag correspondant est à votre billet. Notez que ceci allonge le temps de sauvegarde de votre billet.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'Mot-clef trouvé <strong>%s</strong>, tag <strong><em>%s</em></strong> assigné automatiquement.<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', 'Recherche des billets %d à %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (totalisant %d billets)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'Recherche du prochain groupe de billets...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Analyse des mots-clef automatiques');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Attention : Cette fonction va rechercher et re-sauvegarder chacun de vos billets. Cela va prendre du temps, et risque d\'endommager certains de vos billets. Il est conseillé de faire auparavant une sauvegarde de votre base de données ! Cliquez sur "ANNULER" pour arrêter.');
