<?php # lang_cs.inc.php 1.1 2012-01-16 20:34:34 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/14
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/16
 */

@define('PLUGIN_EVENT_XMLRPC_NAME', 'Posílání pøíspìvkù pomocí XML-RPC');
@define('PLUGIN_EVENT_XMLRPC_DESC', 'Umožòuje posílat/editovat pøíspìvky pomocí XML-RPC API (MT, Blogger, WordPress Endpoints)');
@define('PLUGIN_EVENT_XMLRPC_GMT', 'Používat èas ve formátu GMT');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT', 'Výchozí kategorie');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT_DESC', 'Upøesnìte výchozí kategorii, kam se mají umístit poslané pøíspìvky, pokud u nich není zadána kategorie.');

// Next lines were translated on 2012/01/16
@define('PLUGIN_EVENT_XMLRPC_DOC_RPCLINK', '<b>Pro informaci:</b><br/>Tento blog disponuje URL adresou, která zpracovává volání XMLRPC. Moderní klienti jsou schopni tutot RPC URL adresu zjistit automaticky ze základní URL adresy blogu, ale nìkterým starším klientùm je tøeba zadat RPC URL explicitnì.<br/>Vaše XML-RPC URL je: <b>%s</b><br/>');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG', 'Ladicí výpisy');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_DESC', 'Pokud Vás zajímá, jaké zprávy XML-RPC dostává a odpovídá, zapnìte ladicí výpisy. Logovací soubor se jmenuje rpc.log a je umístìn v adresáøi plugins.');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NONE', 'zakázáno');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NORMAL', 'povoleno');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_VERBOSE', 'ladìní: Nepoužívejte pro klienty!');
@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION', 'Falešná WordPress verze');
@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION_DESC', 'Toto rozhraní XML-RPC umí odpovídat na volání typu WordPress. Normálnì pokud je dotazováno na používaný software, odpovídá verzí Serendipity ' . $serendipity['version'] .'. Ale pokud zde zadáte èíslo verze, bude odpovídat jako WordPress (a èíslo zadané verze). Nìkteøí klienti kontrolují, jestli má WordPress dostateènì vysokou verzi, takže hodnota 3.2 by mìla staèit.');
@define('PLUGIN_EVENT_XMLRPC_HTMLCONVERT', 'Pøevádìt pøíspìvky z plaintextu do HTML');
@define('PLUGIN_EVENT_XMLRPC_HTMLCONVERT_DESC', 'Plugin se snaží zjistit, jestli je tìlo pøíspìvku posíláno jako èistý text (plaintext), a pokud je, pak znaky nového øádku pøevádí na HTML tagy. Pokud používáte znaèkovací pluginy jako textile nebo nl2br, mìli byste tuto volbu vypnout.');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR', 'Autor komentáøe z pøihlašovacího jména');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DESC', 'Nìkteøí klienti posílají komentáøe s obecným jménem autora, jako napø. \'komentáø z WordPressu\'. Pokud je tato volba zapnutá, jméno autora bude pøevzato nikoliv z poslaného pole "autor", ale z pøihlašovacího jména.');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DEFAULT', 'Nemìnit autora');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_LOGIN', 'Použít pøihlašovací jméno jako autora');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_REALNAME', 'Použít skuteèné jméno jako autora');
@define('PLUGIN_EVENT_XMLRPC_UPLOADDIR', 'Adresáø pro upload');
@define('PLUGIN_EVENT_XMLRPC_UPLOADDIR_DESC', 'Pokud klienti nahrávají média (napø. obrázky a videa), do jakého adresáøe v mediatéce se mají ukládat?');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM_HEADER', '<h3>Hlásit SPAM AntiSpamovým pluginùm</h3>
Tento plugin je schopen hlásit HAM a SPAM AntiSpamovým pluginùm, které umožòují pøijímat tyto hlášky, aby na nì mohly reagovat (napø. se z nich uèit).<br/>
Porovnejte s tlaèítky Spam/Ham v seznamu komentáøù. 
Hlášení tohoto pluginu budou mít stejný úèinek jako kliknutí na tato tlaèítka v administraèní sekci.<br/>
Pokud nìkteøí klienti nemají samostatná tlaèítka, ale pouze možnosti povolit a požádat o schválení (moderovat), mùžete nastavit, které hlášky budou kdy poslány.<br/>
Pokud Váš klient neumí posílat hlášení o spamu, možná se vám bude hodit, když nastavíte, aby byl hlášen spam pokaždé, když zvolíte moderovat (moderate, požádat o schválení).');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM', 'Komentáø oznaèený jako SPAM');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM_DESC', 'Klient oznaèil komentáø jako SPAM');
@define('PLUGIN_EVENT_XMLRPC_EVENT_APPROVED', 'Komentáø schválen');
@define('PLUGIN_EVENT_XMLRPC_EVENT_APPROVED_DESC', 'Klient oznaèil komentáø jako schválený');
@define('PLUGIN_EVENT_XMLRPC_EVENT_PENDING', 'Komentáø byl moderován');
@define('PLUGIN_EVENT_XMLRPC_EVENT_PENDING_DESC', 'Klient oznaèil komentáø jako moderovaný (k dalšímu schválení)');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_NONE', 'Nedìlat nic');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_SPAM', 'Hlásit jako SPAM');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_HAM', 'Hlásit jako HAM');