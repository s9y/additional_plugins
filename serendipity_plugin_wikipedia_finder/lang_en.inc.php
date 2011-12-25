<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_WIKIPEDIAFINDER_TITLE',                     "Wikipedia Finder");
@define('PLUGIN_WIKIPEDIAFINDER_DESC',                      "Highlight a phrase and click the icon to search on using Wikipedia.");
@define('PLUGIN_WIKIPEDIAFINDER_PROMPT',                    "Enter the phrase to search on using Wikipedia.");        
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TITLE',                "Title");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TITLE_DESC',           "Title of the Sidebarblocks");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_SITE',                 "Wikipedia Site");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_SITE_DESC' ,           "The Url of the Wikipedia site to be used.");
@define('PLUGIN_WIKIPEDIAFINDER_SITE' ,                     "http://en.wikipedia.org");        
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR',                "Template background color");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_DESC' ,          "Is the template background light or dark? Necessary for the Wikipedia graphic selection.");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_DARK' ,          "Dark background");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_LIGHT' ,         "Light background");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TARGET',               "Target window");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW',             "Target windows with Javascript open");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TARGET_DESC' ,         "If Wikipedia is to be opened in a new window, a window name can be entered here (e.g. \"wikipedia\"). This setting overrides \"" . PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW . "\".");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_DESC',        "A new window can be opened using Javascript that controls the height and width of the window. If \"Yes\" is selected this overrides the \"" .PLUGIN_WIKIPEDIAFINDER_PROP_TARGET. "\" setting.");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_HEIGHT',      "Javascript window: Height");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_HEIGHT_DESC', "Height of the target window. Only effective when \"" . PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW . "\" selected.");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_WIDTH',       "Javascript window: Width");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_WIDTH_DESC',  "Width of the target window. Only effective when \"" . PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW . "\" selected.");

?>
