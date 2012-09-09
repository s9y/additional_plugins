<?php # lang_cs.inc.php 1.5 2012-05-13 14:17:20 VladaAjgl $

/**
 *  @version 1.5
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
@define('PLUGIN_EVENT_LIGHTBOX_DESC',		'Lightbox je jednoduchý nenápadný skript používaný k zobrazení obrázù pøes aktuální stranu. Bìhem okamžiku ho nastavíte. Funguje ve všech moderních prohlížeèích. Lightbox zobrazuje obrázky, zatímco Thickbox umí zobrazit také vyskakovací HTML bloky. Oba skripty fungují následovnì: Vyhledávají v pøíspìvcích a nahrazují každý výskyt odkazu \'a href="XXX"\' odkazem na zobrazení nad aktuální stránkou. Takže pokud chcete zobrazovat zvìtšené obrázky, staèí do èlánku vložit odkazy na tyto velké obrázky. Pøi použití Thickboxu vložte atribut \'class="thickbox"\' do odkazu \'a href\', tento odkaz se pak zobrazí ve vyskakovacím oknì.');
@define('PLUGIN_EVENT_LIGHTBOX_TYPE',		'Vyberte skript, který má formátovat Vaše obrázky/odkazy');
@define('PLUGIN_EVENT_LIGHTBOX_PATH',		'Cesta ke skriptùm');
@define('PLUGIN_EVENT_LIGHTBOX_PATH_DESC',		'Zadejte plnou HTTP cestu (všechno, co následuje po názvu Vaší domény) do adresáøe s pluginem Lightbox.');

@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION',		'Optimalizace nahrávání JavaScriptu');
@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION_DESC',		'Zapnutí této volby nahraje skript a CSS Lightboxu pouze pokud jsou v zobrazeném èlánku obrázky, které tuto funkci vyžadují. To podstatnì zkrátí dobu nahrávání stránky. Na nìkterých blogách tato funkce vedla k tomu, že se skript nenahrál nikdy. Pokud je to i Váš pøípad, vypnìte tuto volbu.');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY',		'Vytvoøit galerii');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_NONE',		'Žádná galerie');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_ENTRY',		'Galerie s fotkami z pøíspìvku');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_PAGE',		'Galerie s fotkami na této stránce');

// Next lines were translated on 2012/05/13
@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS',		'Objekt s inicializaèním nastavením JavaScriptu');
@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS_DESC',		'Nìkteré typy Lightboxu (napø. prettyPhoto) umožòují zadání libovolného objektu s nastavním, takže mùžete zadat napø. "(social_tools: false)".');