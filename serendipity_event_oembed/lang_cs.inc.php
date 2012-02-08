<?php # lang_cs.inc.php 1.1 2012-02-04 09:54:28 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2012/01/11
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/02/04
 */

@define('PLUGIN_EVENT_OEMBED_NAME',      'oEmbed');
@define('PLUGIN_EVENT_OEMBED_DESC',      'oEmbed je form�t, kter� umo��uje vkl�dat do blogu jin� str�nky z internetu. Umo��uje zobrazovat v p��sp�vc�ch vlo�en� obsah (jako tweety, fotky nebo videa), kdy� autor p��sp�vku nap�e odkaz na zdroj obsahu, ani� by bylo pot�eba p��mo parsovat c�lovou str�nku.');

@define('PLUGIN_EVENT_OEMBED_MAXWIDTH',      'Maxim�ln� ���ka vlo�en�ho objektu');
@define('PLUGIN_EVENT_OEMBED_MAXWIDTH_DESC', 'Toto je maxim�ln� ���ka vlo�en�ho obsahu. Ne v�echny slu�by pro vkl�d�n� obsahu toto nastaven� podporuj�, ale v�t�ina ano.');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT',     'Maxim�ln� v��ka vlo�en�ho objektu');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT_DESC','Toto je maxim�ln� v��ka vlo�en�ho obsahu. Ne v�echny slu�by pro vkl�d�n� obsahu toto nastaven� podporuj�, ale v�t�ina ano.');

@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE',   'Obecn� poskytovatel oEmbed');
@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE_DESC','Pokud plugin nen� schopen rozlu�tit URL, proto�e ji je�t� nezn�, m��e ji zpracovat "obecn�m poskytovatelem". Tyto slu�by implementuj� oEmbed pro velk� po�et slu�eb, kter� nemaj� oEmbed. Na v�b�r jsou dv� mo�nosti: oohembed.com (d��ve bezplatn� slu�ba koupen� firmou Embedly a s velmi omezen�m API) nebo embed.ly (dob�e spravovan� a udr�ovan� slu�ba pro mnoho oEmbed slu�eb, viz http://embed.ly/providers, ale k pou�it� je t�eba z�skat API kl��.');
@define('PLUGIN_EVENT_OEMBED_SERVICE_NONE',      '��dn� obecn� poskytovatel');
@define('PLUGIN_EVENT_OEMBED_SERVICE_OOHEMBED',  'oohembed (zdarma, ale omezen�)');
@define('PLUGIN_EVENT_OEMBED_SERVICE_EMBEDLY',   'embed.ly (pot�eba API kl��)');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY',     'embed.ly API kl��');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY_DESC','abyste mohli pou��vat embed.ly, pot�ebujete API kl��. ��et zdarma umo��uje 10000 pou�it� za m�s�c, co� by m�lo sta�it i pro siln� vyt�en� blogy, proto�e v�sledky jsou lok�ln� cachov�ny a vkl�d�ny pouze jedenkr�t na URL. ��et zdarma m��ete zaregistrovat na http://app.embed.ly/pricing/free');

@define('PLUGIN_EVENT_OEMBED_INFO',      '<h3>Plugin oEmbed</h3>' .
'<p>'.
'Tento plugin zobarzuje m�sto zadan� URL adresy jej� reprezentaci pro zn�m� webov� slu�by. Nap��klad kdy� zad�te odkaz na youtube, nezobraz� odkaz na youtube, n�br� rovnou odkazovan� video. M�sto odkazu na flickr zobrazuje rovnou obr�zek.<br/>' .
'Syntaxe pro pou�it� tohoto pluginu je <b>[embed <i>odkaz</i>]</b> (nebo <b>[e <i>odkaz</i>]</b> pokud m�te rad�i zkratky).<br/>'.
'Pokud slu�ba (adresa) nen� pluginem v sou�asnosti podporov�na, bude zobrazen pouze klikateln� odkaz.<br/>'.
'</p><p>'.
'Za�a�te pros�m tento plugin na za��tek seznamu plugin�, aby zadan� odkaz nemohl b�t zm�n�n jin�m pluginem (nap�. p�id�n�m href)'.
'</p>');

@define('PLUGIN_EVENT_OEMBED_SUPPORTED',      '<p>'.
'Plugin podporuje n�sleduj�c� reprezentace odkaz�, ani� by bylo pot�eba nastavovat obecn� fallback:%s'.
'</p>');

// Next lines were translated on 2012/02/04
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO', 'P�ehr�va� Audioboo');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_DESC', 'Audioboo podporuje 3 r�zn� p�ehr�va�e (viz http://audioboo.fm/boos/649785-ein-erster-testboo.embed?labs=1). Vyberte si, kter� se v�m nejv�ce l�b�.');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_STANDARD', 'standardn�');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_FULLFEATURED', 'pln� v�bava (vy�aduje JavaScript)');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_WORDPRESS', 'p�ehr�va� wordpress.com (vy�aduje Flash)');