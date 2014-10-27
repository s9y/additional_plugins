<?php

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

#@define('PLUGIN_EVENT_LIGHTBOX_NAME', 'Lightbox/Thickbox JS/Greybox');
#@define('PLUGIN_EVENT_LIGHTBOX_DESC', 'Lightbox je jednoduchý nenápadný skript pou¾ívaný k zobrazení obrázù pøes aktuální stranu. Bìhem okam¾iku ho nastavíte. Funguje ve v¹ech moderních prohlí¾eèích. Lightbox zobrazuje obrázky, zatímco Thickbox umí zobrazit také vyskakovací HTML bloky. Oba skripty fungují následovnì: Vyhledávají v pøíspìvcích a nahrazují ka¾dý výskyt odkazu \'a href="XXX"\' odkazem na zobrazení nad aktuální stránkou. Tak¾e pokud chcete zobrazovat zvìt¹ené obrázky, staèí do èlánku vlo¾it odkazy na tyto velké obrázky. Pøi pou¾ití Thickboxu vlo¾te atribut \'class="thickbox"\' do odkazu \'a href\', tento odkaz se pak zobrazí ve vyskakovacím oknì.');
@define('PLUGIN_EVENT_LIGHTBOX_TYPE', 'Vyberte skript, který má formátovat Va¹e obrázky/odkazy');
@define('PLUGIN_EVENT_LIGHTBOX_PATH', 'Cesta ke skriptùm');
@define('PLUGIN_EVENT_LIGHTBOX_PATH_DESC', 'Zadejte plnou HTTP cestu (v¹echno, co následuje po názvu Va¹í domény) do adresáøe s pluginem Lightbox.');

@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION', 'Optimalizace nahrávání JavaScriptu');
@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION_DESC', 'Zapnutí této volby nahraje skript a CSS Lightboxu pouze pokud jsou v zobrazeném èlánku obrázky, které tuto funkci vy¾adují. To podstatnì zkrátí dobu nahrávání stránky. Na nìkterých blogách tato funkce vedla k tomu, ¾e se skript nenahrál nikdy. Pokud je to i Vá¹ pøípad, vypnìte tuto volbu.');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY', 'Vytvoøit galerii');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_NONE', '®ádná galerie');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_ENTRY', 'Galerie s fotkami z pøíspìvku');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_PAGE', 'Galerie s fotkami na této stránce');

// Next lines were translated on 2012/05/13
@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS', 'Objekt s inicializaèním nastavením JavaScriptu');
@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS_DESC', 'Nìkteré typy Lightboxu (napø. prettyPhoto) umo¾òují zadání libovolného objektu s nastavním, tak¾e mù¾ete zadat napø. "(social_tools: false)". Currently works with prettyPhoto only.');