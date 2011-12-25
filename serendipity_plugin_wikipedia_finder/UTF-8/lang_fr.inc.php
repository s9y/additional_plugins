<?php # $Id$

/**
 *  @version $Revision$
 *  @author Ronny Staquet <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_WIKIPEDIAFINDER_TITLE',                     "Recherche Wikipedia");
@define('PLUGIN_WIKIPEDIAFINDER_DESC',                      "Surlignez une phrase et cliquez l'icône pour lancer une recherche sur Wikipedia.");
@define('PLUGIN_WIKIPEDIAFINDER_PROMPT',                    "Entrez la phrase �  chercher sur Wikipedia.");        
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TITLE',                "Titre");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TITLE_DESC',           "Titre de la zone �  afficher en barre latérale");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_SITE',                 "Site Wikipedia");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_SITE_DESC' ,           "Adresse URL du site Wikipedia �  utiliser");
@define('PLUGIN_WIKIPEDIAFINDER_SITE' ,                     "http://fr.wikipedia.org");        
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR',                "Couleur d'arrière-plan");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_DESC' ,          "La couleur d'arrière-plan du theme est-elle claire ou foncée ?  Ceci est nécessaire pour sélectionner correctement l'affichage de Wikipedia.");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_DARK' ,          "Arrière-plan foncé");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_LIGHT' ,         "Arrière-plan clair");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TARGET',               "Fenêtre cible");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW',             "Fenêtre cible avec javascript ouvert");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TARGET_DESC' ,         "Si Wikipedia doit être ouvert dans une nouvelle fenêtre, un nom de fenêtre peut être précisé ici (par ex. \"wikipedia\"). Cette option domine \"" . PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW . "\".");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_DESC',        "Une nouvelle fenêtre peut être ouverte en utilisant un script java qui contrôle ses dimensions (hauteur/largeur). Si \"Oui\" est sélectionné, cela domine \"" .PLUGIN_WIKIPEDIAFINDER_PROP_TARGET. "\".");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_HEIGHT',      "Fenêtre java : Hauteur");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_HEIGHT_DESC', "Hauteur de la fenêtre cible. Fonctionne seulement avec \"" . PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW . "\" activé.");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_WIDTH',       "Fenêtre java : Largeur");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_WIDTH_DESC',  "Largeur de la fenêtre cible. Fonctionne seulement avec \"" . PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW . "\" activé.");

?>
