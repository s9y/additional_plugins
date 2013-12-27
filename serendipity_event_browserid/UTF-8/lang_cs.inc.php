/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2012/05/13
 */
@define('PLUGIN_BROWSERID_NAME',     'BrowserID přihlašování');
@define('PLUGIN_BROWSERID_DESC',     'Umožňuje autorům přihlašovat se do blogu pomocí služby BrowserID');

@define('PLUGIN_BROWSERID_DESCRIPTION', 
'<h3>Puužití BrwoserID k přihlašování do blogu</h3>' .
'<p>BrowserID nevyžaduje žádná nastavení. Přihlásíte se pomocí emailové adresy spřažené s <a href="serendipity_admin.php?serendipity[adminModule]=personal">vaším uživatelským účtem</a>.<br/> 
Pokud jste si emailovou adresu ještě nezaregistrovali na BrowserID, můžete tak učinit během přihlašování, nebo ji můžete zaregistrovat přímo na <a href="https://browserid.org/" target="_blank">webu BrowserID</a>.<br/>
BrowserID si nejdříve potřebuje ověřit, že jste vlastníkem zadaného emailu. Po této proceduře budete připraveni používat BrowserID k přihlašování do blogu.</p>');