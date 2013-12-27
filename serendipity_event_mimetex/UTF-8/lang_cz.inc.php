/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/07
 */
@define('PLUGIN_EVENT_MIMETEX_NOTE','Plugin vykresluje obrázky gif podle vstupu TeXu. Závisím na externím spustitelním programu. Vyžaduje buď MimeTex nebo plnou verzi laTeX. MimeTex je podstatně jednodušší nainstalovat, ale nevykresluje fonty tak čistě jako opravdový LaTeX. LaTeX vykresluje pomocí pozměněné knihovny GPL <a href="http://www.mayer.dial.pipex.com/tex.htm">LatexRender</a>, která se liší podle distribuce LaTeXu a pomocí ImageMagicku (který závisí na Ghostcriptu).<br />  Pro více informací čtěte <a href="http://www.forkosh.com/mimetex.html">http://www.forkosh.com/mimetex.html</a><br />');
@define('PLUGIN_EVENT_MIMETEX_NAME', 'Interpret příkazů MimeTex/LaTeX');
@define('PLUGIN_EVENT_MIMETEX_NAME_BUTTON', 'TeX');
@define('PLUGIN_EVENT_MIMETEX_DESC', 'Vytvoří obrázky gif z výrazu TeX použitím softwaru MimeTex nebo LaTeX');
@define('PLUGIN_EVENT_MIMETEX_PATH', 'Cesta k instalaci MimeTex');
@define('PLUGIN_EVENT_MIMETEX_REPLACE_DESC', 'Pokud je povoleno, řetězce TeXu mezi tagy [tex][/tex] (např.: [tex]\frac{2}{3}[/tex] pro vykreslení zlomku 2/3) budou dynamicky přeměněny. Pokud je vypnuto, řetězce TeXu musí být do příspěvku vloženy pomocí tlačítka TeX nad polem editoru.');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX', 'Použít MimeTeX nebo LaTeX?');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX_BLAHBLAH', 'Jako vykreslovací stroj se má použít MimeTeX nebo LaTeX? Jeden z nich musí být nainstalovaný navíc vedle pluginu, plugin sám o sobě neumí vykreslovat příkazy TeX bez jejich přítomnosti.');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX_LATEX','LaTeX');
@define('PLUGIN_EVENT_MIMETEX_OR_LATEX_MIMETEX','MimeTeX');
@define('PLUGIN_EVENT_MIMETEX_LATEXPATH','Cesta k LaTeXu');
@define('PLUGIN_EVENT_MIMETEX_LATEXPATH_DESC','Absolutní cesta ke spustitelným souborům LaTeXu.');
@define('PLUGIN_EVENT_MIMETEX_DVIPSPATH','Cesta k dvips');
@define('PLUGIN_EVENT_MIMETEX_DVIPSPATH_DESC','Absolutní cesta ke spustitelnému souboru dvips.');
@define('PLUGIN_EVENT_MIMETEX_CONVERTPATH','Cesta k convert');
@define('PLUGIN_EVENT_MIMETEX_CONVERTPATH_DESC','Absolutní cesta ke spustitelnému souboru convert.');
@define('PLUGIN_EVENT_MIMETEX_ADDTRANSPARENCY','Používat průhledné pozadí v obrázcích?');
@define('PLUGIN_EVENT_MIMETEX_ADDTRANSPARENCY_DESC','Přepíná, jestli má být u výsledného gif obrázku použita průhledná barva. To je vhodné u blogů s tmavým nebo různorodým pozadím. Pamatujte, že dříve vytvořené obrázky nebudou znovu tvořeny a zůstanou v původní verzi.');
@define('PLUGIN_EVENT_MIMETEX_FILETYPE','Typ obrázku');
@define('PLUGIN_EVENT_MIMETEX_FILETYPE_DESC','LatexRendere umí poskytnout obrázky buď ve formátu gif nebo png.');