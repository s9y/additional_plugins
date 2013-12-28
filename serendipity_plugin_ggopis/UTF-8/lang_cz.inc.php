<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/03/07
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/13
 */

@define('PLUGIN_GGOPIS_NAME',		'Status z Gadu-Gadu');
@define('PLUGIN_GGOPIS_DESC',		'Zobrazuje popis stavu z Gadu-Gadu IM (Instant Messenger = protokol pro posílání zpráv, alternativa ICQ, Jabberu apod.)');
@define('PLUGIN_GGOPIS_GGGATEID',		'UID identifikátor Gadu-Gadu brány');
@define('PLUGIN_GGOPIS_GGGATEID_DESC',		' ');
@define('PLUGIN_GGOPIS_GGGATEPASSWD',		'Heslo ke Gadu-Gadu bráně');
@define('PLUGIN_GGOPIS_GGGATEPASSWD_DESC',		' ');
@define('PLUGIN_GGOPIS_GGID',		'Gadu-Gadu UID, jehož status se má sledovat');
@define('PLUGIN_GGOPIS_GGID_DESC',		' ');

@define('PLUGIN_GGOPIS_MSG_NOCONNTOAPPMSG',		'Spojení na appmsg.gadu-gadu.pl nebylo stanoveno, možná je zahlcen: ');
@define('PLUGIN_GGOPIS_MSG_CONNERROR',		'Chyba spojení');
@define('PLUGIN_GGOPIS_MSG_CONNUNEXPCLOSED',		'Spojení bylo neočekávaně přerušeno');
@define('PLUGIN_GGOPIS_MSG_UNKNOWNERROR',		'Neznámá chyba');
@define('PLUGIN_GGOPIS_MSG_INCORRPASSWD',		'Nesprávné heslo');
@define('PLUGIN_GGOPIS_MSG_SENDCONTACTSERROR',		'Chyba při posílání seznamu kontaktů');
@define('PLUGIN_GGOPIS_MSG_NOSTATUSDESC',		'Žádný popis statutu');