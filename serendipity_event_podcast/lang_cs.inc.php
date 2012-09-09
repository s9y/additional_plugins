<?php # lang_cs.inc.php 1.2 2012-05-13 14:20:13 VladaAjgl $

/**
 *  @version 1.2
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/28
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/06/19
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/05/13
 */

@define('PLUGIN_PODCAST_NAME',             'Podcasting plugin');
@define('PLUGIN_PODCAST_DESC',             'Pøidává "podcastovací" možnosti (RSS zapouzdøení, pøehrávaè videa a/nebo hudby)');
@define('PLUGIN_PODCAST_EASY',             '<br/><h3>Jednoduché nastavení:</h3>');
@define('PLUGIN_PODCAST_USEPLAYER',        'Zobrazit pøehrávaè');
@define('PLUGIN_PODCAST_USEPLAYER_DESC',   'Má se generovat HTML kód pro pøehrávání podcastù místo jednoduchého odkazu na soubor multimédia?');
@define('PLUGIN_PODCAST_AUTOSIZE',         'Pøizpùsobit velikost pøehrávaèe');
@define('PLUGIN_PODCAST_AUTOSIZE_DESC',    'Snaží se urèit rozmìry videa a pøizpùsobit jim rozmìry pøehrávaèe. Nastavení šíøky a výšky budou ingorována.');
@define('PLUGIN_PODCAST_WIDTH',            'Šíøka');
@define('PLUGIN_PODCAST_WIDTH_DESC',       'Šíøka pøehrávaèe');
@define('PLUGIN_PODCAST_HEIGHT',           'Výška');
@define('PLUGIN_PODCAST_HEIGHT_DESC',      'Výška pøehrávaèe');
@define('PLUGIN_PODCAST_ALIGN',            'Zarovnání');
@define('PLUGIN_PODCAST_ALIGN_DESC',       'Zarovnání pøehrávaèe k okolnímu textu');
@define('PLUGIN_PODCAST_ALIGN_LEFT',       'doleva');
@define('PLUGIN_PODCAST_ALIGN_RIGHT',      'doprava');
@define('PLUGIN_PODCAST_ALIGN_CENTER',     'na støed');
@define('PLUGIN_PODCAST_ALIGN_NONE',       'žádné');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY',   'Vložit první multimediální soubor pouze jako RSS zapouzdøení');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY_DESC',   'Specifikace standardu RSS umožòuje vložit pouze jedno zapouzdøení u každého pøíspìvku. Pokud je tato volba "Ano", pak bude respektován výše zmínìný standard RDD a pouze první nalezený multimediální soubor bude vložen do RSS kanálu.');

@define('PLUGIN_PODCAST_EXTATTRSETTINGS',  '<br/><h3>Podcastování pomocí rozšíøených parametrù pøíspìvku:</h3>');
@define('PLUGIN_PODCAST_EXTATTR',          'Rozšíøující parametry pøíspìvku');
@define('PLUGIN_PODCAST_EXTATTR_DESC',     'Zde mùžete urèit, které rozšiøující parametry mají být zpracovávány jako multimediální pøílohy èlánku a které tedy budou vkládány do RSS. Pište seznam èárkou oddìlených jmen parametrù. Pro tuto funkci je tøeba mít nainstalovaný plugin "Rozšíøené parametry pøíspìvku".');

@define('PLUGIN_PODCAST_EXTPOS',           'Poloha multimédiálních souborù nalezených v rozšíøených parametrech pøíspìvku.');
@define('PLUGIN_PODCAST_EXTPOS_DESC',      'Urèete, jakým zpùsobem mají být vøazeny multimediální soubory do pøíspìvku.');
@define('PLUGIN_PODCAST_EXTPOS_NONE',      'Nevkládat do pøíspìvku');
@define('PLUGIN_PODCAST_EXTPOS_BT',        'Zaèátek pøíspìvku');
@define('PLUGIN_PODCAST_EXTPOS_BB',        'Konec pøíspìvku');
@define('PLUGIN_PODCAST_EXTPOS_ET',        'Zaèátek rozšíøené textové èásti');
@define('PLUGIN_PODCAST_EXTPOS_EB',        'Konec rozšíøené textové èásti');

@define('PLUGIN_PODCAST_EXPERT',           '<br/><h3>Pokroèilá nastavení:</h3>');
@define('PLUGIN_PODCAST_QTEXT',            'Quicktime pøípony');
@define('PLUGIN_PODCAST_QTEXT_DESC',       'Typy souborù, které je schopný pøehrát Quick Time Player.');
@define('PLUGIN_PODCAST_WMEXT',            'Windows Media Player pøípony');
@define('PLUGIN_PODCAST_WMEXT_DESC',       'Typy souborù, které je schopný pøehrát Windows Media Player.');
@define('PLUGIN_PODCAST_MFEXT',            'Flash pøípony');
@define('PLUGIN_PODCAST_MFEXT_DESC',       'Typy souborù, které je schopný pøehrát Flash Player.');
@define('PLUGIN_PODCAST_XSPFEXT',          'XSPF flashplayer audio pøípony');
@define('PLUGIN_PODCAST_XSPFEXT_DESC',     'Typy zvukových souborù, které je schopen pøehrát XSFB flashplayer. Obvykle pouze MP3 a XSPF.');
@define('PLUGIN_PODCAST_AUEXT',            'Quicktime miniplayer audio pøípony');
@define('PLUGIN_PODCAST_AUEXT_DESC',       'Typy zvukových souborù, které je schopný pøehrát Quick Time Miniplayer.');
@define('PLUGIN_PODCAST_FLVEXT',           'FLV player pøípony');
@define('PLUGIN_PODCAST_FLVEXT_DESC',      'Typy souborù, které je shopný pøehrát FLV player. FLV je formát videa podporovaný Flashovými pøehrávaèi. Výhoda formátu je nezávislost na platformì. Do tohoto formátu umí pøevádìt soubory spousta volnì dostupných nástrojù (pro PC http://www.rivavx.com/index.php?id=483&L=0 a pro Mac http://www.versiontracker.com/dyn/moreinfo/macosx/15473).');
@define('PLUGIN_PODCAST_USECACHE',         'Cachování');
@define('PLUGIN_PODCAST_USECACHE_DESC',    'Má se použít cashování pro zapamatování informací nalezených podcastù? Pøi použití cachování je nutní analyzovat obsah souborù pouze jednou. (Doporuèená volba!)');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION',  'Optimalizace JavaScriptu');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION_DESC','Pokud je zapnutá, JavaScripty jsou do stránky pøidávány pouze v pøípadì potøeby. Pokud používáte cachování pøíspìvkù, MUSÍTE tuto volbu VYPNOUT!');

@define('PLUGIN_PODCAST_ASURE_FEEDENC',  	'Ujistit se o zapouzdøení multimédia do RSS kanálu');
@define('PLUGIN_PODCAST_ASURE_FEEDEENC_DESC',  'Zajistí vložení média do RSS kanálu jako "zapouzdøení" i v pøípadì, že není zobrazeno v pøíspìvku');

@define('PLUGIN_PODCAST_HTTPREL',          'Relativní HTTP adresa pluginu');
@define('PLUGIN_PODCAST_HTTPREL_DESC',     'Napište relativní cestu k pluginu vzhledem k základnímu adresáøi blogu. Pokud jste nezmìnili strukturu stálých odkazù (permalinkù) a pokud Váš blog nebìží na serveru v podadresáøi, pak by vše mìlo fungovat s výchozím nastavením.');

@define('PLUGIN_PODCAST_USAGE', 
'Skenuje pøíspìvky na pøítomnost odkazù na multimediální soubory (video, audio) a nahrazuje je HTML kódem, který zobrazí soubor v pøehrávaèi multimédií. Toto ulehèuje vytváøení objektù pøehrávaèe, jednoduše tím, že staèí napsat odkaz na soubor (napø. video) nebo ho vybrat z mediatéky. Navíc plugin vkládá multimediální soubory do RSS kanálu zpùsobem, který umožòuje RSS èteèkám zobrazit je jako podcasty. /Klíèové slovo: Zapouzdøovací tagy / Enclosure Tags).');

@define('PLUGIN_PODCAST_INSTALL_DESC', 
'<h3>Instalace</h3>' .
'<p>Plugin používá knihovnu getID3(), která nemùže být z licenèních dùvodù distribuována s tímto pluginem. Musíte si ji sami stáhnout z ' .
'<a href="http://getid3.org/" target="_blank">getid3.org</a>. <b>Podporovaná je pouze verze 1.x!</b></p>' .
'<p>Ve staženém archivu naleznete podadresáø getid3. Tento podadresáø je tøeba zkopírovat do adresáøe "bundled-libs" v Serenddipity.</p>');
@define('PLUGIN_PODCAST_INSTALL_FLV_DESC', 
'<h3>FLV Player</h3>' .
'<p>Plugin použává JW-FLV Player pro zobrazení videí ve formátu FLV. Z licenèních dùvodù tento pøehrávaè není distribuován spolu s tímto pluginem, musíte si ho <a href="http://www.jeroenwijering.com/?item=Flash_Video_Player" target="_blank">stáhnout zde</a>.<br />' .
'Ve staženém archivu najdete soubory flvplayer.swf a swfobject.js. Zkopírujte je do adresáøe tohoto pluginu. Pokud adresáø obsahuje pouze soubory "mediaplayer.*", pøejmenujte je na "flvplayer.*"</p>');

// Next lines were translated on 2011/06/19

@define('PLUGIN_PODCAST_EXPERT_HINT',      'TIP: Pomocí HTML znaèek si mùžete pøizpùsobit LIBOVOLNÝ pøehrávaè, takže mùžete zadat seznam rùzných variant pøehrávaèe pro rùzné typy souborù! Pamatujte, že jak jednou uložíte nastavení pluginu, bude vždy použito statické znaèkování <strong>namísto</strong> toho, které plugin poskytuje pomocí souboru <strong>podcast_player.php</strong>. Pokud chcete resetovat nastavení na výchozí hodnoty, jednoduše vymažte veškerý obsah pole pro znaèkování pluginu a uložte nastavení.');
@define('PLUGIN_PODCAST_QTEXT_HTML',       'Znaèkování pøehrávaèe Quicktime');
@define('PLUGIN_PODCAST_WMEXT_HTML',       'Znaèkování Windows Media Player');
@define('PLUGIN_PODCAST_MFEXT_HTML',       'Znaèkování Flash player');
@define('PLUGIN_PODCAST_XSPFEXT_HTML',     'Znaèkování XSPF');
@define('PLUGIN_PODCAST_AUEXT_HTML',       'Znaèkování Quicktime.');
@define('PLUGIN_PODCAST_FLOWEXT',          'Rozšíøení Flowplayer');
@define('PLUGIN_PODCAST_FLOWEXT_DESC',     'Rozšíøení Flowplayer je schopné pøehrávat formát FLV podporovaný Flashovými pøehrávaèi. Více na www.flowplayer.org.');
@define('PLUGIN_PODCAST_FLOWEXT_HTML',     'Znaèkování Flowplayer');
@define('PLUGIN_PODCAST_HTML5_AUDIO',      'HTML5 audio rozšíøení');
@define('PLUGIN_PODCAST_HTML5_AUDIO_DESC', 'Moderní prohlížeèe nativnì podporují HTML5 widgety.');
@define('PLUGIN_PODCAST_HTML5_AUDIO_HTML', 'Znaèkování HTML5 audio');
@define('PLUGIN_PODCAST_HTML5_VIDEO',      'HTML5 vedio rozšíøení');
@define('PLUGIN_PODCAST_HTML5_VIDEO_DESC', 'Moderní prohlížeèe nativnì podporují HTML5 widgety.');
@define('PLUGIN_PODCAST_HTML5_VIDEO_HTML', 'Znaèkování HTML5 video');
@define('PLUGIN_PODCAST_USAGE_RSS',        'Pro omezení RSS kanálù na pouze specifikované typy mùžete pøistupovat ke kanálu pomocí URL jako http://' . $serendipity['baseURL'] . '/rss.php?version=2.0&podcast_format=ogg.
Toto nastavení napøíklad vloží do kanálu pouze soubory formátu "ogg". Mùžete urèit více formátù oddìlených èárkou ",".');
@define('PLUGIN_PODCAST_ITUNES',           'Znaèkování iTunes XML');
@define('PLUGIN_PODCAST_ITUNES_DESC',      'Zadejte XML, které má být vložení do RSS-kanálu, aby se zobrazovalo v iTunes.');
@define('PLUGIN_PODCAST_MERGEMULTI',       'Slouèit více elementù HTML5 pøehrávaèe');
@define('PLUGIN_PODCAST_DOWNLOADLINK',     'Vždy pøipojit odkaz na stažení');
@define('PLUGIN_PODCAST_DOWNLOADLINK_DESC','Pokud je vypnuto, mùžete pøidat vlastní prizpùsobený odkaz na stažení do znaèek pøehrávaèe.');

// Next lines were translated on 2012/05/13
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS','Ignorovat CSS tøídy');
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS_DESC','Pokud mají odkazy na média zadanou tuto CSS tøídu, pak budou ignorovány (tyto odkazy nebudou nahrazovány pøehrávaèem a nebudou se zobrazovat v RSS kanálu).');