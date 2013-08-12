<?php # 

/**
 *  @version $Revision$
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.1
 */

        @define('PLUGIN_EVENT_GESHI_NAME',     'Форматиране на текст: GeSHi');
        @define('PLUGIN_EVENT_GESHI_DESC',     'Синтактично оцветяване на програмни текстове. Приложение: [geshi lang=lang_name [,ln={y|n}]] програмен текст (без HTML) [/geshi]. Поддържани езици: actionscript, ada, apache, asm, asp, bash, c, c_mac, caddcl, cadlisp, cpp, csharp (C#), css, delphi, html4strict, java, javascript, lisp, lua, mpasm, nsis, objc, oobas, oracle8, pascal, perl, php, python, qbasic, smarty, vb, vbnet, visualfoxpro, xml');
        @define('PLUGIN_EVENT_GESHI_TRANSFORM', 'Можете да използвате таг <b>[geshi lang=lang_name [,ln={y|n}]][/geshi]</b>, за да въведете оцветен програмен текст');
        @define('PLUGIN_EVENT_GESHI_VERSION', '03');
        @define('PLUGIN_EVENT_GESHI_PATHTOGESHI','Път до GeSHi');
        @define('PLUGIN_EVENT_GESHI_PATHTOGESHI_DESC','Път до директорията, където е инсталиран GeSHi');
        @define('PLUGIN_EVENT_GESHI_SHOWLINENUMBERS','Номера на редове ?');
        @define('PLUGIN_EVENT_GESHI_SHOWLINENUMBERS_DESC','Показване на номера на редове по подразбиране ?');
