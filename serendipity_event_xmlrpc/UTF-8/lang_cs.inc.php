<?php # lang_cs.inc.php 1.1 2012-01-16 20:34:34 VladaAjgl $

/**
 *  @version 1.1
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/14
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/16
 */

@define('PLUGIN_EVENT_XMLRPC_NAME', 'Posílání příspěvků pomocí XML-RPC');
@define('PLUGIN_EVENT_XMLRPC_DESC', 'Umožňuje posílat/editovat příspěvky pomocí XML-RPC API (MT, Blogger, WordPress Endpoints)');
@define('PLUGIN_EVENT_XMLRPC_GMT', 'Používat čas ve formátu GMT');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT', 'Výchozí kategorie');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT_DESC', 'Upřesněte výchozí kategorii, kam se mají umístit poslané příspěvky, pokud u nich není zadána kategorie.');

// Next lines were translated on 2012/01/16
@define('PLUGIN_EVENT_XMLRPC_DOC_RPCLINK', '<b>Pro informaci:</b><br/>Tento blog disponuje URL adresou, která zpracovává volání XMLRPC. Moderní klienti jsou schopni tutot RPC URL adresu zjistit automaticky ze základní URL adresy blogu, ale některým starším klientům je třeba zadat RPC URL explicitně.<br/>Vaše XML-RPC URL je: <b>%s</b><br/>');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG', 'Ladicí výpisy');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_DESC', 'Pokud Vás zajímá, jaké zprávy XML-RPC dostává a odpovídá, zapněte ladicí výpisy. Logovací soubor se jmenuje rpc.log a je umístěn v adresáři plugins.');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NONE', 'zakázáno');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NORMAL', 'povoleno');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_VERBOSE', 'ladění: Nepoužívejte pro klienty!');
@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION', 'Falešná WordPress verze');
@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION_DESC', 'Toto rozhraní XML-RPC umí odpovídat na volání typu WordPress. Normálně pokud je dotazováno na používaný software, odpovídá verzí Serendipity ' . $serendipity['version'] .'. Ale pokud zde zadáte číslo verze, bude odpovídat jako WordPress (a číslo zadané verze). Někteří klienti kontrolují, jestli má WordPress dostatečně vysokou verzi, takže hodnota 3.2 by měla stačit.');
@define('PLUGIN_EVENT_XMLRPC_HTMLCONVERT', 'Převádět příspěvky z plaintextu do HTML');
@define('PLUGIN_EVENT_XMLRPC_HTMLCONVERT_DESC', 'Plugin se snaží zjistit, jestli je tělo příspěvku posíláno jako čistý text (plaintext), a pokud je, pak znaky nového řádku převádí na HTML tagy. Pokud používáte značkovací pluginy jako textile nebo nl2br, měli byste tuto volbu vypnout.');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR', 'Autor komentáře z přihlašovacího jména');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DESC', 'Někteří klienti posílají komentáře s obecným jménem autora, jako např. \'komentář z WordPressu\'. Pokud je tato volba zapnutá, jméno autora bude převzato nikoliv z poslaného pole "autor", ale z přihlašovacího jména.');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DEFAULT', 'Neměnit autora');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_LOGIN', 'Použít přihlašovací jméno jako autora');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_REALNAME', 'Použít skutečné jméno jako autora');
@define('PLUGIN_EVENT_XMLRPC_UPLOADDIR', 'Adresář pro upload');
@define('PLUGIN_EVENT_XMLRPC_UPLOADDIR_DESC', 'Pokud klienti nahrávají média (např. obrázky a videa), do jakého adresáře v mediatéce se mají ukládat?');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM_HEADER', '<h3>Hlásit SPAM AntiSpamovým pluginům</h3>
Tento plugin je schopen hlásit HAM a SPAM AntiSpamovým pluginům, které umožňují přijímat tyto hlášky, aby na ně mohly reagovat (např. se z nich učit).<br/>
Porovnejte s tlačítky Spam/Ham v seznamu komentářů. 
Hlášení tohoto pluginu budou mít stejný účinek jako kliknutí na tato tlačítka v administrační sekci.<br/>
Pokud někteří klienti nemají samostatná tlačítka, ale pouze možnosti povolit a požádat o schválení (moderovat), můžete nastavit, které hlášky budou kdy poslány.<br/>
Pokud Váš klient neumí posílat hlášení o spamu, možná se vám bude hodit, když nastavíte, aby byl hlášen spam pokaždé, když zvolíte moderovat (moderate, požádat o schválení).');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM', 'Komentář označený jako SPAM');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM_DESC', 'Klient označil komentář jako SPAM');
@define('PLUGIN_EVENT_XMLRPC_EVENT_APPROVED', 'Komentář schválen');
@define('PLUGIN_EVENT_XMLRPC_EVENT_APPROVED_DESC', 'Klient označil komentář jako schválený');
@define('PLUGIN_EVENT_XMLRPC_EVENT_PENDING', 'Komentář byl moderován');
@define('PLUGIN_EVENT_XMLRPC_EVENT_PENDING_DESC', 'Klient označil komentář jako moderovaný (k dalšímu schválení)');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_NONE', 'Nedělat nic');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_SPAM', 'Hlásit jako SPAM');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_HAM', 'Hlásit jako HAM');