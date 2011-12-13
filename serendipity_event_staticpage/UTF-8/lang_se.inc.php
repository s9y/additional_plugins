<?php # $Id: lang_se.inc.php,v 1.1 2005/11/09 13:29:21 garvinhicking Exp $

@define('PLUGIN_STATICPAGELIST_NAME',             'lista med statiska sidorna');
@define('PLUGIN_STATICPAGELIST_NAME_DESC',        'Den här plugin visar en konfigurerbar lista den statiska sidorna. StaticPage-Plugin behöver version 1.22 eller högre.');
@define('PLUGIN_STATICPAGELIST_TITLE',            'Titel');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',       'Rubrik för den sidonavigator:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',    'statiska sidor');
@define('PLUGIN_STATICPAGELIST_LIMIT',            "Antal sidor: Seitenanzahl");
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',       "Max antal sidor som ska visas. Maximale Anzahl der anzuzeigenden Seiten");
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',   "Visa startsidorlink Startseitenlink anzeigen");
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',   "Skapar länk på Startsidor Einen Link zur Startseite erstellen");
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME',"Startsidor");

@define('STATICPAGE_HEADLINE', 'Sidhuvudet');
@define('STATICPAGE_HEADLINE_BLAHBLAH', 'visar ett sidhuvud som titel på den statiska sidan'); 
@define('STATICPAGE_TITLE', 'statiska sidor');
@define('STATICPAGE_TITLE_BLAHBLAH', 'Förvaltar olika statiska sidor inom ditt blog med blog-design och alla formateringen. Lägg3r till en ny menypunkt i administrationsgränssnittet!');
@define('STATICPAGE_PAGETITLE', 'Sidans URL-Titel');
@define('STATICPAGE_PERMALINK', 'Permalänk');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'Anger den statiska sidans permalänkar. Denna måste ha en absolut sökväg från HTTP.roten och ha filändelsen .htm eller .html!');
@define('CONTENT_BLAHBLAH', 'innehållet','der Inhalt');
@define('STATICPAGE_ARTICLEFORMAT', 'Formatera som artikel?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', 'bestämmer om utgåvan automatiskt ska formateras som en artikel (färger, kanter mm.) (Standard: ja)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', 'Sidans titel som "Formaters som artikel"-vy');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'När optionen "Formatera som artikel" är vald, kan man genom den här titeln avgöra vad som ska visas på det stället där vanligtvis blog-datumet finns.');
@define('STATICPAGE_SELECT',           'Välj statiska sidor för bearbetning.');
@define('STATICPAGE_PASSWORD_NOTICE',   'Denna sida är lösenordsskyddad. Var god ange ditt lösenord: ');
@define('STATICPAGE_PARENTPAGES_NAME',  'Parent sida');
@define('STATICPAGE_PARENTPAGE_DESC',   'Välj den överordnade sidan');
@define('STATICPAGE_PARENTPAGE_PARENT', ' Är parent sida');
@define('STATICPAGE_AUTHORS_NAME',      'Författarens namn');
@define('STATICPAGE_AUTHORS_DESC',      'Författare har skapat sidan');
@define('STATICPAGE_FILENAME_NAME',     'Template (Smarty)');
@define('STATICPAGE_FILENAME_DESC',     'Ange det templates filnamn, som ska användas för denna sida. Smarty-filen återfinns antingen bland dina plugin eller i din template-mapp.');

@define('STATICPAGE_SHOWCHILDPAGES_NAME', 'visa child-sidor');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', 'visa samtliga child-sidor som linklista.');
@define('STATICPAGE_PRECONTENT_NAME', 'Inledning');
@define('STATICPAGE_PRECONTENT_DESC', 'Denna inledning visas före child-sidorna.');
@define('STATICPAGE_CANNOTDELETE_MSG', 'Denna sida kan inte raderas eftersom det finns fortfarande child-sidor i databasen. Dessa behöver raderas innan.');
@define('STATICPAGE_IS_STARTPAGE', 'Definiera denna sida som startsida');
@define('STATICPAGE_IS_STARTPAGE_DESC', 'Istället för serendipities ska denna statiska sida vara startsida. Du får enbart definiera en sida som standardsida. Om du vill vill skapa en länk till den ursprungliga sidan, får du länka till "index.php?frontpage"');
@define('STATICPAGE_TOP', 'Hög');
@define('STATICPAGE_LINKNAME', 'Bearbeta');

@define('STATICPAGE_ARTICLETYPE', 'Typ av artikel');
@define('STATICPAGE_ARTICLETYPE_DESC', 'Välj en typ av artikel för denna sida.');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'Sidornas ordning');
@define('STATICPAGE_CATEGORY_PAGES', 'Editera sidor');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'Editera sidtyp');

@define('PAGETYPES_SELECT', 'Välj en sidtyp för bearbetning.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', 'Beskrivning');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'Beskrivning av sidan.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'Templatenamn');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', 'Templatenamn. Ett template kan återfinnas i staticpages-plugin mappen eller i standardmappen för template.');
@define('STATICPAGE_ARTICLETYPE_IMAGE', 'sökväg bild');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', 'URL för en kategoribild.');

?>