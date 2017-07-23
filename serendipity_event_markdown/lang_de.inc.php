<?php # 

/**
 *  @version 1.25
 *  @author Thomas Hochstein <thh@inter.net>
 *  EN-Revision: 1.25
 */

@define('PLUGIN_EVENT_MARKDOWN_NAME', 'Textformatierung: Markdown');
@define('PLUGIN_EVENT_MARKDOWN_DESC', 'Markdown-Textformatierung durchführen');
@define('PLUGIN_EVENT_MARKDOWN_EXTRA_NAME', '"Markdown Extra" verwenden');
@define('PLUGIN_EVENT_MARKDOWN_EXTRA_DESC', 'Markdown Extra iste eine erweiterte Markdown-Variante, vgl. http://michelf.ca/projects/php-markdown/extra/');
@define('PLUGIN_EVENT_MARKDOWN_TRANSFORM', '<a href="http://daringfireball.net/projects/markdown/syntax">Markdown</a>-Formatierung erlaubt');

@define('PLUGIN_EVENT_MARKDOWN_VERSION', 'Markdown-Version');
@define('PLUGIN_EVENT_MARKDOWN_VERSION_BLABLAH', 'Welche Markdown-Version verwenden? (Siehe http://michelf.ca/projects/php-markdown/ und http://michelf.ca/blog/2013/php-markdown-lib/)');

@define('PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_NAME', 'SmartyPants (und Typographer) verwenden');
@define('PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_DESC', 'SmartyPants (oder SmartyPants Typographer) "verschönern" Text durch Ersetzung bestimmter Zeichen mit passenden HTML-Entities, vgl. http://michelf.ca/projects/php-smartypants/ - Nur mit der "lib"-Version von Markdwon möglich!');
@define('PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_EXTENDED', '+Typographer');
@define('PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_NEVER', 'deaktiviert');
