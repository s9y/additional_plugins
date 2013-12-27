/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/07
 */
@define('PLUGIN_EVENT_MIMETEX_NOTE','Plugin vykresluje obrázky gif podle vstupu TeXu. Závisím na externím spustitelním programu. Vyžaduje buï MimeTex nebo plnou verzi laTeX. MimeTex je podstatnì jednodušší nainstalovat, ale nevykresluje fonty tak èistì jako opravdový LaTeX. LaTeX vykresluje pomocí pozmìnìné knihovny GPL <a href="http://www.mayer.dial.pipex.com/tex.htm">LatexRender</a>, která se liší podle distribuce LaTeXu a pomocí ImageMagicku (který závisí na Ghostcriptu).<br />  Pro více informací ètìte <a href="http://www.forkosh.com/mimetex.html">http://www.forkosh.com/mimetex.html</a><br />');
@define('PLUGIN_EVENT_MIMETEX_NAME', 'Interpret pøíkazù MimeTex/LaTeX');
@define('PLUGIN_EVENT_MIMETEX_NAME_BUTTON', 'TeX');
@define('PLUGIN_EVENT_MIMETEX_DESC', 'Vytvoøí obrázky gif z výrazu TeX použitím softwaru MimeTex nebo LaTeX');
@define('PLUGIN_EVENT_MIMETEX_PATH', 'Cesta k instalaci MimeTex');
@define('PLUGIN_EVENT_MIMETEX_REPLACE_DESC', 'Pokud je povoleno, øetìzce TeXu mezi tagy [tex][/tex] (napø.: [tex]\frac{2}{3}[/tex] pro vykreslení zlomku 2/3) budou dynamicky pøemìnìny. Pokud je vypnuto, øetìzce TeXu musí být do pøíspìvku vloženy pomocí tlaèítka TeX nad polem editoru.');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX', 'Použít MimeTeX nebo LaTeX?');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX_BLAHBLAH', 'Jako vykreslovací stroj se má použít MimeTeX nebo LaTeX? Jeden z nich musí být nainstalovaný navíc vedle pluginu, plugin sám o sobì neumí vykreslovat pøíkazy TeX bez jejich pøítomnosti.');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX_LATEX','LaTeX');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX_MIMETEX','MimeTeX');
@define('PLUGIN_EVENT_MIMETEX_LATEXPATH','Cesta k LaTeXu');
@define('PLUGIN_EVENT_MIMETEX_LATEXPATH_DESC','Absolutní cesta ke spustitelným souborùm LaTeXu.');
@define('PLUGIN_EVENT_MIMETEX_DVIPSPATH','Cesta k dvips');
@define('PLUGIN_EVENT_MIMETEX_DVIPSPATH_DESC','Absolutní cesta ke spustitelnému souboru dvips.');
@define('PLUGIN_EVENT_MIMETEX_CONVERTPATH','Cesta k convert');
@define('PLUGIN_EVENT_MIMETEX_CONVERTPATH_DESC','Absolutní cesta ke spustitelnému souboru convert.');
@define('PLUGIN_EVENT_MIMETEX_ADDTRANSPARENCY','Používat prùhledné pozadí v obrázcích?');
@define('PLUGIN_EVENT_MIMETEX_ADDTRANSPARENCY_DESC','Pøepíná, jestli má být u výsledného gif obrázku použita prùhledná barva. To je vhodné u blogù s tmavým nebo rùznorodým pozadím. Pamatujte, že døíve vytvoøené obrázky nebudou znovu tvoøeny a zùstanou v pùvodní verzi.');
@define('PLUGIN_EVENT_MIMETEX_FILETYPE','Typ obrázku');
@define('PLUGIN_EVENT_MIMETEX_FILETYPE_DESC','LatexRendere umí poskytnout obrázky buï ve formátu gif nebo png.');