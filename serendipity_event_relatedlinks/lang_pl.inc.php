<?php # 

/**
 *  @version $Revision$
 *  @author Kostas CoSTa Brzezinski <costa@kofeina.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_RELATEDLINKS_TITLE', 'Powi±zane wpisy/linki');
@define('PLUGIN_EVENT_RELATEDLINKS_DESC', 'Wstaw powi±zane z danym wpisem linki do innych wpisów lub stron. Mo¿esz swobodnie zmieniaæ sposób prezentowania linków przez edycjê szablonu smarty "plugin_relatedlinks.tpl". Proszê zwróciæ uwagê, ¿e ten plugin pokazuje dane tylko w pe³nym widoku wpisu (wymaga wy¶wietlenia pe³nej jego tre¶ci).');
@define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC', 'Wstaw powi±zane z tym wpisem linki, które chcesz pokazaæ. Jeden URL (nie kod HTML!) na liniê (to znaczy linie separowane znakiem nowej linii - po prostu wci¶nij enter aby przej¶c do nowej linii). Je¶li chcesz dodaæ opis, wprowad¼ go wed³ug nastêpuj±cego schematu: http://przyklad.com/link.html=Przyk³ad owa strona. Wszystko co znajdzie siê w linii po znaku "=" bêdzie traktowane jako opis linku. Je¶li nie wprowadzisz opisu, zostanie wy¶wietlony sam link.');
@define('PLUGIN_EVENT_RELATEDLINKS_LIST', 'Powi±zane linki:');

@define('PLUGIN_EVENT_RELATEDLINKS_POSITION', 'Umieszczenie wtyczki');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC', 'Umie¶ciæ wynik dzia³ania wtyczki w stopce wpisu czy u¿yæ w tym celu szablonu Smarty? Je¶li uaktywnisz szablon Smarty, musisz dodaæ tê liniê do szablonu entries.tpl swojego schematu: {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}. Liniê umie¶æ w pêtli foreach, w której definiowane jest wy¶wietlanie zmiennej $entry (np. w miejscu wy¶wietlania komentarzy, ¶ladów czy rozszerzonej tre¶ci wpisu).');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER', 'Umie¶æ w stopce wpisu');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY', 'Umie¶æ w tre¶ci wpisu');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY', 'U¿yj wywo³ania Smarty');

?>
