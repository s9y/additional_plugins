/<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/05/06
 */

@define('PLUGIN_CONTACTFORM_TITLE',		'Kontaktní formuláø');
@define('PLUGIN_CONTACTFORM_TITLE_BLAHBLAH',		'Zobrazuje kontaktní formuláø k poslání e-mailu jako statickou stránku. Pøístup k fromuláøi buï pomocí stálého odkazu (permalinku) nebo na adrese index.php?serendipity[subpage]=contactform. Vzhled fromuláøe si mùžete upravit podle svého vložením souboru plugin_contactform.tpl do adresáøe s Vaší šablonou. Kryptogramy z pluginu SpamBlock budou použity, pokud je SpamBlock nainstalován.');
@define('PLUGIN_CONTACTFORM_PERMALINK',		'Stálý odkaz - Permalink');
@define('PLUGIN_CONTACTFORM_PAGETITLE',		'URL zkratka (kvùli zpìtné kompatibilitì, v novìjších verzích ignorujte)');
@define('PLUGIN_CONTACTFORM_PERMALINK_BLAHBLAH',		'Definuje permanetní URL adresu. Je tøeba zadat absolutní cestu a musí konèit na .html nebo .html!');
@define('PLUGIN_CONTACTFORM_EMAIL',		'Cílová e-mailová adresa');
@define('PLUGIN_CONTACTFORM_INTRO',		'Úvodní text (volitelné)');
@define('PLUGIN_CONTACTFORM_MESSAGE',		'Text zprávy');
@define('PLUGIN_CONTACTFORM_SENT',		'Text po odeslání zprávy');
@define('PLUGIN_CONTACTFORM_SENT_HTML',		'Zpráva byla úspìšnì odeslána!');
@define('PLUGIN_CONTACTFORM_ERROR_HTML',		'Pøi odesílání zprávy se vyskytla chyba!');
@define('PLUGIN_CONTACTFORM_ERROR_DATA',		'Jméno, e-mail ani text zprávy nesmí zùstat prázdné.');
@define('PLUGIN_CONTACTFORM_DYNAMIC_ERROR_DATA',		'Povinné pole je prázdné.');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT',		'Formátovat jako èlánek?');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT_BLAHBLAH',		'Pokud je vybráno, výsledná stránka je formátována jako obvyklý pøíspìvek (barvy, okraje, apod.) (Standardnì: ANO)');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL',		'Šablona');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_DESC',		'Tato volba Vám umožòuje nastavit vzhled kontaktního formuláøe podle Vašich pøání. Mùžete použít standardní vzhled, úsporný obchodní vzhled, vzhled s podrobnostmi nebo váš vlastní vzhled, který musíte ruènì zadat.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS',		'Pole formuláøe');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_STANDARD',		'Standardní');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_SMALLBIZ',		'Obchodní');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_DETAILED',		'Podrobný');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_FULLDYNAMIC',		'Vlastní');
@define('PLUGIN_CONTACTFORM_FNAME',		'Jméno');
@define('PLUGIN_CONTACTFORM_LNAME',		'Pøíjmení');
@define('PLUGIN_CONTACTFORM_ADDRESS',		'Adresa');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC',		'Tento øetìzec urèuje, které z polí se objeví v kontaktním formuláøi, zda jsou tato pole povinná a jejich pøednastavenou hodnotu.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC_NOTE',		'<p>"Pole formuláøe" je textový øetìzec, podle kterého se budou zobrazovat pole v kontaktním formuláøi. Øetìzec musí mít následující syntaxi &lt;pole&gt;:&lt;pole&gt;:&lt;pole&gt;.  Oddìlování polí je pomocí dvojteèky.</p>
   <p>Jednotlivá pole (kromì typu "radio", "checkbox" a "select", které bude samostatnì rozebráno) musí být zadány ve tvaru {require;}Jméno;typ{;default}.  Pamatujte na oddìlování jednotlivých polí pomocí dvojteèky. Ve tvaru syntaxe znamenají pøíkazy ve složených závorkách, že se jedná o nepovinné parametry. Pokud má být pole kontrolování, zda je vyplnìné, vložte na zaèátek definice pole slovo "require".
</p>
   <p>Pole mohou být následujících typù:
        <ul> 
         <li>text - standardní textové pole; Pøíklad: "Jméno;text"</li>
         <li>checkbox - zaškrtávací políèko; Pøíklad: "Žádám odpovìï;checkbox;název, který se má zobrazit po zaškrtnutí políèka"</li>
         <li>radio - skupina vybíracích koleèek; Pøíklad: "Z aut mám nejradši;radio;Citroeny|Peugeoty|Renaulty"</li>
         <li>hidden - skryté pole; Pøíklad: "skryte_pole;hidden"</li>
         <li>password - heslo. Pozor, toto políèko není nijak testováno, je jen vloženo do mailu, kde se objeví jeho textová hodnota.; Pøíklad: "require;Heslo;password"</li>
         <li>textarea - velká oblast pro text o nìkolika øádcích; Pøíklad: "Zde napište svùj dopis;textarea"</li>
         <li>select - Rozbalovací políèko s výbìrem nìkolika voleb; Pøíklad: "Neoblíbenìjší kategorie na blogu;select;auta|letadla|kytièky|drogy"</li>
        </ul>
   </p>
   <p>K pøednastavení hodnoty pro políèko jednoduše pøidáte další definici k poli. Pro políèko checkbox je jediná správná hodnota "checked"</p>
   <p>Typ "radio" používá následující syntaxi {require;}Název;radio;Volba1,Hodnota1|Volba1,Hodnota1{,checked}.</p>
   <p>Pøíklady:
       <ul>
         <li>Standardní formuláø lze zapsat takto: "require;Jméno;text:require;E-mail;text:require;Domácí stránka;text:require;Text zprávy;textarea;"</li>
         <li>Textové pole pro telefoní èíslo: "Telefon;text"</li>
         <li>Textové pole pro telefoní èíslo, které má být povinnì vyplnìné:- "require;Telefon;text"</li>
         <li>Textová oblast s pøednastaveným textem: "Pøednastavený text;textarea;Tohle je pøednastavený text...  Pìkná nuda...  Ale je to pøednastavené."
         <li>Výbìr mezi ano/ne: "Výbìr;radio;Ano,ano|Ne,ne a ještì jednou ne"</li>
         <li>Zaškrtávací políèko standardnì zaškrtnuté: "Povolání Student;checkbox;checked"</li>
         <li>Poslední ètyøi pøíklady dohromady: "require;Telefon;text:Pøednastavený text;textarea;Tohle je pøednastavený text...  Pìkná nuda...  Ale je to pøednastavené.:Výbìr;radio;Ano,ano|Ne,ne a ještì jednou ne:Povolání Student;checkbox;checked" </li>
       </ul>
   </p>');

@define('PLUGIN_CONTACTFORM_TEMPLATE',		'Jméno souboru se šablonou');
@define('PLUGIN_CONTACTFORM_TEMPLATE_DESC',		'Zadejte pouze jméno souboru jakékoliv šablony, která má být použita k vykreslení kontaktního formuláøe. Mùžete nahrát vlastní soubory buï do adresáøe tohoto pluginu, nebo do adresáøe se šablonou, kterou používáte.');
@define('PLUGIN_CONTACTFORM_SUBJECT',		'Pøedmìt emailu');
@define('PLUGIN_CONTACTFORM_SUBJECT_DESC',		'Zadejte pøedmìt emailu, který bude poslán na Vaši adresu. Mùžete do nìj umístit promìnnou %s, která bude obsahovat nadpis kontaktního formuláøe.');

// Next lines were translated on 2009/05/06
@define('PLUGIN_CONTACTFORM_ISSUECOUNTER',		'Používat poèítadlo kontaktních formuláøù?');
@define('PLUGIN_CONTACTFORM_ISSUECOUNTER_DESC',		'Pokud je použito, každý odeslaný kontaktní formuláø dostane jedineèné ID identifikaèní èíslo.');
@define('PLUGIN_CONTACTFORM_MAIL_ISSUECOUNTER',		'Èíslo lístku: %s');