<?php # $Id$

@define('PLUGIN_EVENT_MIMETEX_NOTE','This plugin relies on an external executable to render gifs of TeX input.  It either requires MimeTex or a full laTeX installation.  MimeTex is a considerably easier install, but does not render fonts as cleanly as true LateX output. LaTeX rendering is done on a modifed version of the GPL <a href="http://www.mayer.dial.pipex.com/tex.htm">LatexRender</a>, which relies on a laTeX distribution and ImageMagick (which relies on Ghostscript).<br />  For more information, please see <a href="http://www.forkosh.com/mimetex.html">http://www.forkosh.com/mimetex.html</a><br />');
@define('PLUGIN_EVENT_MIMETEX_NAME', 'MimeTex/LaTeX TeX Interpreter');
@define('PLUGIN_EVENT_MIMETEX_NAME_BUTTON', 'TeX');
@define('PLUGIN_EVENT_MIMETEX_DESC', 'Create Gifs from TeX expressions using MimeTex or LaTeX');
@define('PLUGIN_EVENT_MIMETEX_PATH', 'Path to MimeTex');
if (substr(php_uname(), 0, 7) == "Windows"){
    @define('PLUGIN_EVENT_MIMETEX_PATH_DESC', 'The absolute path to your MimeTex executable.  Since you are running Windows you may need to include "START /B" in front of the executable.');
} else {
    @define('PLUGIN_EVENT_MIMETEX_PATH_DESC', 'The absolute path to your MimeTex executable.');
}
@define('PLUGIN_EVENT_MIMETEX_REPLACE', 'TeX Markup On');
@define('PLUGIN_EVENT_MIMETEX_REPLACE_DESC', 'If enabled TeX strings between [tex][/tex] tags (ex: [tex]\frac{2}{3}[/tex]) will be converted dynamically.  If disabled, TeX strings must be entered using the TeX button above the editor.');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX', 'Use mimeTeX or LaTex?');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX_BLAHBLAH', 'Would you like to use the mimeTeX or the LaTeX rendering engines?  Either one must be installed seperately from the plugin.');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX_LATEX','LaTeX');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX_MIMETEX','MimeTeX');
@define('PLUGIN_EVENT_MIMETEX_LATEXPATH','Path to latex');
@define('PLUGIN_EVENT_MIMETEX_LATEXPATH_DESC','The absolute path to your LaTeX executable.');
@define('PLUGIN_EVENT_MIMETEX_DVIPSPATH','Path to dvips');
@define('PLUGIN_EVENT_MIMETEX_DVIPSPATH_DESC','The absolute path to your dvips executable.');
@define('PLUGIN_EVENT_MIMETEX_CONVERTPATH','Path to convert');
@define('PLUGIN_EVENT_MIMETEX_CONVERTPATH_DESC','The absolute path to your convert executable.');
@define('PLUGIN_EVENT_MIMETEX_ADDTRANSPARENCY','Add transparency to images?');
@define('PLUGIN_EVENT_MIMETEX_ADDTRANSPARENCY_DESC','Toggles whether to use transparency when convert creates the final gif image. Useful for sites with dark backgrounds. Note that previously created images are uneffected.');
@define('PLUGIN_EVENT_MIMETEX_FILETYPE','Filetype of image');
@define('PLUGIN_EVENT_MIMETEX_FILETYPE_DESC','LatexRender can support either gif or png output.');
