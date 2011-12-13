<?php # $Id: lang_fr.inc.php,v 1.1 2006/02/09 14:04:08 garvinhicking Exp $

/**
 *  @version $Revision: 1.1 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_FLICKR_NAME', 'Importer depuis Flickr.com');
@define('PLUGIN_EVENT_FLICKR_DESC', 'Importe des images dans la médiathèque depuis flickr.com');
@define('PLUGIN_EVENT_FLICKR_APIKEY', 'Clé de l\'API');
@define('PLUGIN_EVENT_FLICKR_APIKEY_INVALID', 'La clé doit faire 32 caractères et ne doit contenir que des chiffres ou des lettres de a à f');
@define('PLUGIN_EVENT_FLICKR_APIKEY_DESC', 'Clé de l\'API, voir http://www.flickr.com/services/api/');
@define('PLUGIN_EVENT_FLICKR_IMPORT', 'Importer une image de Flickr.com');
@define('PLUGIN_EVENT_FLICKR_IMPORT2', 'Importer une image de Flickr.com (étape 2)');
@define('PLUGIN_EVENT_FLICKR_TAGS', 'Tags');
@define('PLUGIN_EVENT_FLICKR_KEYWORDS', 'Mots clé');

@define('PLUGIN_EVENT_FLICKR_IMPORT_BLAHBLAH', 'L\'importation peut se faire sur toutes les images "publiques" disponibles sur Flickr.com. /!\ Attention cependant à n\'utiliser que des images libres de droit!');
@define('PLUGIN_EVENT_FLICKR_INSTALL', '<strong>/!\</strong> Chez certains hébergeurs, il est impossible de changer le chemin d\'inclusion de PHP avec une instruction ini_set() (Sur Free.fr par exemple). Le plugin va alors s\'arrêter puisqu\'il ne pourra inclure les fichiers requis.<br /><br />Dans ce cas, votre hébergeur propose sûrement un répertoire spécial où placer vos fichiers communs. Sur Free.fr, il suffit de créer un répertoire \'include\' à la racine de votre espace web et y copier le contenu du répertoire \'phpFlickr/PEAR\'.');
