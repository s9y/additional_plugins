<?php # 

/**
 *  @version $Revision$
 *  @author Kostas CoSTa Brzezinski <costa@kofeina.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_RELATEDLINKS_TITLE', 'Powiązane wpisy/linki');
@define('PLUGIN_EVENT_RELATEDLINKS_DESC', 'Wstaw powiązane z danym wpisem linki do innych wpisów lub stron. Możesz swobodnie zmieniać sposób prezentowania linków przez edycję szablonu smarty "plugin_relatedlinks.tpl". Proszę zwrócić uwagę, że ten plugin pokazuje dane tylko w pełnym widoku wpisu (wymaga wyświetlenia pełnej jego treści).');
@define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC', 'Wstaw powiązane z tym wpisem linki, które chcesz pokazać. Jeden URL (nie kod HTML!) na linię (to znaczy linie separowane znakiem nowej linii - po prostu wciśnij enter aby przejśc do nowej linii). Jeśli chcesz dodać opis, wprowadź go według następującego schematu: http://przyklad.com/link.html=Przykład owa strona. Wszystko co znajdzie się w linii po znaku "=" będzie traktowane jako opis linku. Jeśli nie wprowadzisz opisu, zostanie wyświetlony sam link.');
@define('PLUGIN_EVENT_RELATEDLINKS_LIST', 'Powiązane linki:');

@define('PLUGIN_EVENT_RELATEDLINKS_POSITION', 'Umieszczenie wtyczki');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC', 'Umieścić wynik działania wtyczki w stopce wpisu czy użyć w tym celu szablonu Smarty? Jeśli uaktywnisz szablon Smarty, musisz dodać tę linię do szablonu entries.tpl swojego schematu: {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}. Linię umieść w pętli foreach, w której definiowane jest wyświetlanie zmiennej $entry (np. w miejscu wyświetlania komentarzy, śladów czy rozszerzonej treści wpisu).');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER', 'Umieść w stopce wpisu');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY', 'Umieść w treści wpisu');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY', 'Użyj wywołania Smarty');

?>
