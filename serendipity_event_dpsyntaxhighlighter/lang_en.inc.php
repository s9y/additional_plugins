<?php

/**
 *  @version $Revision$
 *  @author Brendon Kozlowski
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_NAME', 'Markup: Syntax Highlighter');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_DESC', 'This plugin is a JavaScript code highlighter based on the code of the same name by Alex Gorbatchev.   '
       .'This plugin takes less server-side resources than GeSHi and displays less markup in the actual HTML code.  It\'s a lighter, cleaner alternative. '
       .'This plugin requires the supporting theme to provide the following hooks: frontend_header, frontend_footer (and optionally backend_preview on the '
       .'administrative theme only).');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH', 'Path to the scripts');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH_DESC', 'Enter the full HTTP path (everything after your domain name) that leads to this plugin\'s directory.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME', 'Select a theme');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME_DESC', 'Choose a theme/style for the syntax highlighter that corresponds best to your blog.');