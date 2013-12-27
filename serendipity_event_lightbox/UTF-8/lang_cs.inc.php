/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Translated on 2007/12/01
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/10/31
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/05/13
 */

@define('PLUGIN_EVENT_LIGHTBOX_NAME',		'Lightbox/Thickbox JS/Greybox');
@define('PLUGIN_EVENT_LIGHTBOX_DESC',		'Lightbox je jednoduchý nenápadný skript používaný k zobrazení obrázů přes aktuální stranu. Během okamžiku ho nastavíte. Funguje ve všech moderních prohlížečích. Lightbox zobrazuje obrázky, zatímco Thickbox umí zobrazit také vyskakovací HTML bloky. Oba skripty fungují následovně: Vyhledávají v příspěvcích a nahrazují každý výskyt odkazu \'a href="XXX"\' odkazem na zobrazení nad aktuální stránkou. Takže pokud chcete zobrazovat zvětšené obrázky, stačí do článku vložit odkazy na tyto velké obrázky. Při použití Thickboxu vložte atribut \'class="thickbox"\' do odkazu \'a href\', tento odkaz se pak zobrazí ve vyskakovacím okně.');
@define('PLUGIN_EVENT_LIGHTBOX_TYPE',		'Vyberte skript, který má formátovat Vaše obrázky/odkazy');
@define('PLUGIN_EVENT_LIGHTBOX_PATH',		'Cesta ke skriptům');
@define('PLUGIN_EVENT_LIGHTBOX_PATH_DESC',		'Zadejte plnou HTTP cestu (všechno, co následuje po názvu Vaší domény) do adresáře s pluginem Lightbox.');

@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION',		'Optimalizace nahrávání JavaScriptu');
@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION_DESC',		'Zapnutí této volby nahraje skript a CSS Lightboxu pouze pokud jsou v zobrazeném článku obrázky, které tuto funkci vyžadují. To podstatně zkrátí dobu nahrávání stránky. Na některých blogách tato funkce vedla k tomu, že se skript nenahrál nikdy. Pokud je to i Váš případ, vypněte tuto volbu.');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY',		'Vytvořit galerii');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_NONE',		'Žádná galerie');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_ENTRY',		'Galerie s fotkami z příspěvku');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_PAGE',		'Galerie s fotkami na této stránce');

// Next lines were translated on 2012/05/13
@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS',		'Objekt s inicializačním nastavením JavaScriptu');
@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS_DESC',		'Některé typy Lightboxu (např. prettyPhoto) umožňují zadání libovolného objektu s nastavním, takže můžete zadat např. "(social_tools: false)".');