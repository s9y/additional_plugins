<?php

/**
 *  @version 
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
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TOOLBAR', 'Show toolbar');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TOOLBAR_DESC', 'Show the question mark button with the about dialog.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_AUTOLINS', 'Make URLs clickable');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_AUTOLINKS_DESC', 'Allows you to turn detection of links in the highlighted element on and off. If the option is turned off, URLs won’t be clickable.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_CLASSNAME', 'Add custom CSS classes');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_CLASSNAME_DESC', 'Allows you to add a custom class (or multiple classes) to every highlighter element that will be created on the page.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_COLLAPSE', 'Collapse the code snippets');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_COLLAPSE_DESC', 'Allows you to force highlighted elements on the page to be collapsed by default. If you collapse your code snippets, you have to show the toolbar, otherwise no code snippet is shown.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_GUTTER', 'Show line numbers');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_GUTTER_DESC', 'Allows you to turn gutter with line numbers on and off.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_SMARTTABS', 'Smart tabs');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_SMARTTABS_DESC', 'Allows you to turn smart tabs feature on and off.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TABSIZE', 'Tab size for smart tabs');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TABSIZE_DESC', 'Allows you to adjust tab size.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_STRIPBRS', 'Ignore <br> tags');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_STRIPBRS_DESC', 'If your software adds <br /> tags at the end of each line, this option allows you to ignore those..');