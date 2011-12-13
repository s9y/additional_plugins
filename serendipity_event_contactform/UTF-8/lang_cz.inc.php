<?php # lang_cz.inc.php 1.3 2009-05-06 20:20:31 VladaAjgl $

/**
 *  @version 1.3
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/05/06
 */

@define('PLUGIN_CONTACTFORM_TITLE',		'Kontaktní formulář');
@define('PLUGIN_CONTACTFORM_TITLE_BLAHBLAH',		'Zobrazuje kontaktní formulář k poslání e-mailu jako statickou stránku. Přístup k fromuláři buď pomocí stálého odkazu (permalinku) nebo na adrese index.php?serendipity[subpage]=contactform. Vzhled fromuláře si můžete upravit podle svého vložením souboru plugin_contactform.tpl do adresáře s Vaší šablonou. Kryptogramy z pluginu SpamBlock budou použity, pokud je SpamBlock nainstalován.');
@define('PLUGIN_CONTACTFORM_PERMALINK',		'Stálý odkaz - Permalink');
@define('PLUGIN_CONTACTFORM_PAGETITLE',		'URL zkratka (kvůli zpětné kompatibilitě, v novějších verzích ignorujte)');
@define('PLUGIN_CONTACTFORM_PERMALINK_BLAHBLAH',		'Definuje permanetní URL adresu. Je třeba zadat absolutní cestu a musí končit na .html nebo .html!');
@define('PLUGIN_CONTACTFORM_EMAIL',		'Cílová e-mailová adresa');
@define('PLUGIN_CONTACTFORM_INTRO',		'Úvodní text (volitelné)');
@define('PLUGIN_CONTACTFORM_MESSAGE',		'Text zprávy');
@define('PLUGIN_CONTACTFORM_SENT',		'Text po odeslání zprávy');
@define('PLUGIN_CONTACTFORM_SENT_HTML',		'Zpráva byla úspěšně odeslána!');
@define('PLUGIN_CONTACTFORM_ERROR_HTML',		'Při odesílání zprávy se vyskytla chyba!');
@define('PLUGIN_CONTACTFORM_ERROR_DATA',		'Jméno, e-mail ani text zprávy nesmí zůstat prázdné.');
@define('PLUGIN_CONTACTFORM_DYNAMIC_ERROR_DATA',		'Povinné pole je prázdné.');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT',		'Formátovat jako článek?');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT_BLAHBLAH',		'Pokud je vybráno, výsledná stránka je formátována jako obvyklý příspěvek (barvy, okraje, apod.) (Standardně: ANO)');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL',		'Šablona');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_DESC',		'Tato volba Vám umožňuje nastavit vzhled kontaktního formuláře podle Vašich přání. Můžete použít standardní vzhled, úsporný obchodní vzhled, vzhled s podrobnostmi nebo váš vlastní vzhled, který musíte ručně zadat.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS',		'Pole formuláře');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_STANDARD',		'Standardní');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_SMALLBIZ',		'Obchodní');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_DETAILED',		'Podrobný');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_FULLDYNAMIC',		'Vlastní');
@define('PLUGIN_CONTACTFORM_FNAME',		'Jméno');
@define('PLUGIN_CONTACTFORM_LNAME',		'Příjmení');
@define('PLUGIN_CONTACTFORM_ADDRESS',		'Adresa');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC',		'Tento řetězec určuje, které z polí se objeví v kontaktním formuláři, zda jsou tato pole povinná a jejich přednastavenou hodnotu.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC_NOTE',		'<p>"Pole formuláře" je textový řetězec, podle kterého se budou zobrazovat pole v kontaktním formuláři. Řetězec musí mít následující syntaxi &lt;pole&gt;:&lt;pole&gt;:&lt;pole&gt;.  Oddělování polí je pomocí dvojtečky.</p>
   <p>Jednotlivá pole (kromě typu "radio", "checkbox" a "select", které bude samostatně rozebráno) musí být zadány ve tvaru {require;}Jméno;typ{;default}.  Pamatujte na oddělování jednotlivých polí pomocí dvojtečky. Ve tvaru syntaxe znamenají příkazy ve složených závorkách, že se jedná o nepovinné parametry. Pokud má být pole kontrolování, zda je vyplněné, vložte na začátek definice pole slovo "require".
</p>
   <p>Pole mohou být následujících typů:
        <ul> 
         <li>text - standardní textové pole; Příklad: "Jméno;text"</li>
         <li>checkbox - zaškrtávací políčko; Příklad: "Žádám odpověď;checkbox;název, který se má zobrazit po zaškrtnutí políčka"</li>
         <li>radio - skupina vybíracích koleček; Příklad: "Z aut mám nejradši;radio;Citroeny|Peugeoty|Renaulty"</li>
         <li>hidden - skryté pole; Příklad: "skryte_pole;hidden"</li>
         <li>password - heslo. Pozor, toto políčko není nijak testováno, je jen vloženo do mailu, kde se objeví jeho textová hodnota.; Příklad: "require;Heslo;password"</li>
         <li>textarea - velká oblast pro text o několika řádcích; Příklad: "Zde napište svůj dopis;textarea"</li>
         <li>select - Rozbalovací políčko s výběrem několika voleb; Příklad: "Neoblíbenější kategorie na blogu;select;auta|letadla|kytičky|drogy"</li>
        </ul>
   </p>
   <p>K přednastavení hodnoty pro políčko jednoduše přidáte další definici k poli. Pro políčko checkbox je jediná správná hodnota "checked"</p>
   <p>Typ "radio" používá následující syntaxi {require;}Název;radio;Volba1,Hodnota1|Volba1,Hodnota1{,checked}.</p>
   <p>Příklady:
       <ul>
         <li>Standardní formulář lze zapsat takto: "require;Jméno;text:require;E-mail;text:require;Domácí stránka;text:require;Text zprávy;textarea;"</li>
         <li>Textové pole pro telefoní číslo: "Telefon;text"</li>
         <li>Textové pole pro telefoní číslo, které má být povinně vyplněné:- "require;Telefon;text"</li>
         <li>Textová oblast s přednastaveným textem: "Přednastavený text;textarea;Tohle je přednastavený text...  Pěkná nuda...  Ale je to přednastavené."
         <li>Výběr mezi ano/ne: "Výběr;radio;Ano,ano|Ne,ne a ještě jednou ne"</li>
         <li>Zaškrtávací políčko standardně zaškrtnuté: "Povolání Student;checkbox;checked"</li>
         <li>Poslední čtyři příklady dohromady: "require;Telefon;text:Přednastavený text;textarea;Tohle je přednastavený text...  Pěkná nuda...  Ale je to přednastavené.:Výběr;radio;Ano,ano|Ne,ne a ještě jednou ne:Povolání Student;checkbox;checked" </li>
       </ul>
   </p>');

@define('PLUGIN_CONTACTFORM_TEMPLATE',		'Jméno souboru se šablonou');
@define('PLUGIN_CONTACTFORM_TEMPLATE_DESC',		'Zadejte pouze jméno souboru jakékoliv šablony, která má být použita k vykreslení kontaktního formuláře. Můžete nahrát vlastní soubory buď do adresáře tohoto pluginu, nebo do adresáře se šablonou, kterou používáte.');
@define('PLUGIN_CONTACTFORM_SUBJECT',		'Předmět emailu');
@define('PLUGIN_CONTACTFORM_SUBJECT_DESC',		'Zadejte předmět emailu, který bude poslán na Vaši adresu. Můžete do něj umístit proměnnou %s, která bude obsahovat nadpis kontaktního formuláře.');

// Next lines were translated on 2009/05/06
@define('PLUGIN_CONTACTFORM_ISSUECOUNTER',		'Používat počítadlo kontaktních formulářů?');
@define('PLUGIN_CONTACTFORM_ISSUECOUNTER_DESC',		'Pokud je použito, každý odeslaný kontaktní formulář dostane jedinečné ID identifikační číslo.');
@define('PLUGIN_CONTACTFORM_MAIL_ISSUECOUNTER',		'Číslo lístku: %s');