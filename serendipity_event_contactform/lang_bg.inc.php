<?php

/**
 *  @version 
 *  @author Ivan Cenov jwalker@hotmail.bg
 *  EN-Revision: 1.6
 */

@define('PLUGIN_CONTACTFORM_TITLE', 'Форма за обратна връзка');
@define('PLUGIN_CONTACTFORM_TITLE_BLAHBLAH', 'Показва форма за изпращане на e-mail в блога като статична страница. Тя може да бъде достигната или чрез постоянна връзка, указана тук при конфигурирането на приставката или чрез \'index.php?serendipity[subpage]=contactform\'. Можете да промените външния вид на формата като поставите файл \'plugin_contactform.tpl\' в директорията на вашата тема и я модифицирате там. Captchas от приставка Spamblock (ако са позволени) ще бъдат приложени.');
@define('PLUGIN_CONTACTFORM_PERMALINK', 'Постоянна връзка');
@define('PLUGIN_CONTACTFORM_PAGETITLE', 'Късо URL име (за обратна съвместимост)');
@define('PLUGIN_CONTACTFORM_PERMALINK_BLAHBLAH', 'Дефинира постоянна връзка за URL. Трябва да бъде абсолютен HTTP път и да завършва с \'.htm\' или \'.html\'.');
@define('PLUGIN_CONTACTFORM_EMAIL', 'e-mail адрес');
@define('PLUGIN_CONTACTFORM_INTRO', 'Въвеждащ текст, който се появява над полето за въвеждане на съобщението (може да бъде оставено празно)');
@define('PLUGIN_CONTACTFORM_MESSAGE', 'Съобщение');
@define('PLUGIN_CONTACTFORM_SENT', 'Текст след като съобщението е било изпратено успешно');
@define('PLUGIN_CONTACTFORM_SENT_HTML', 'Съобщението беше успешно изпратено.');
@define('PLUGIN_CONTACTFORM_ERROR_HTML', 'Съобщението не беше изпратено поради възникнала грешка.');
@define('PLUGIN_CONTACTFORM_ERROR_DATA', 'Въведете вашето име, e-mail и съобщението.');
@define('PLUGIN_CONTACTFORM_DYNAMIC_ERROR_DATA', 'Не е попълнено задължително поле.');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT', 'Форматиране като статия ?');
@define('PLUGIN_CONTACTFORM_ARTICLEFORMAT_BLAHBLAH', 'При избор \'Да\' съобщението се форматира автоматично като статия (цветове, шрифтове и т.н.).');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL','Use the dynamic tpl?');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_DESC','This setting allows you to choose the form type you wish to use.  You can use the standard form, a small business form, a more detailed form or an entirely custom form created from a manually entered string.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS','Form field string');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_STANDARD','Standard');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_SMALLBIZ','Small Business');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_DETAILED','Detailed Form');
@define('PLUGIN_CONTACTFORM_DYNAMICTPL_FULLDYNAMIC','Custom');
@define('PLUGIN_CONTACTFORM_FNAME','First Name');
@define('PLUGIN_CONTACTFORM_LNAME','Last Name');
@define('PLUGIN_CONTACTFORM_ADDRESS','Address');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC','This is the string that is parsed to determine which fields will appear on the form, whether they are required, and the default settings.');
@define('PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC_NOTE','<p>The "Form field string" is a text string that is used to determine which fields are displayed on the dynamic form.  The string must be in the order of &lt;field&gt;:&lt;field&gt;:&lt;field&gt;.  Note the separation by colons.</p>
   <p>The individual fields (except for type "radio", as defined later) must be of the form {require;}Name;type{;default}.  Note the separation by semicolons.  Also, note that the curly brackets indicate an optional field.  If a field must be filled in to complete the form then the word "require" must appear at the start of the field definition (without the curly backets).</p>
   <p>Fields of different types are available.  Currently these types are supported:
        <ul> 
         <li>text - standard text box; Example: "Name;text"</li>
         <li>checkbox - A checkbox; Example: "Check Box;checkbox;Name displayed after checkbox,checked"</li>
         <li>radio - A group of radio buttons; Example: "Radio Button;radio;Yes,yes|No,no,checked"</li>
         <li>hidden - A hidden field; Example: "hiddendata;hidden"</li>
         <li>password - A password field. Note, this does not check the password against anything and it is included in the email in plaintext; Example: "require;Preferred Password;password"</li>
         <li>textarea - A large, multiline text area; Example: "Label;textarea"</li>
         <li>select - A dropdown box; Example: "Drop Down;select;Yes,yes|No,no,selected"</li>
        </ul>
   </p>
   <p>To indicate a default value for a field, you simply add an additional definition with that default.  The only valid default for type "checkbox" is "checked".</p><p>The type "radio" uses a field definition such as this: {require;}Name;radio;Name1,Value1|Name2,Value2{,checked}.  Note the additional definition of options, where the options themselves are separated by a pipe character (|), and each option has a name, a value, and an option default of checked.</p>
   <p>Examples (the quotation marks are for clarity and are not required):
       <ul>
         <li>Replicating the default form:- "require;Name;text:require;Email;text:require;Homepage;text:require;Message;textarea"</li>
         <li>A text field labeled for phone numbers:- "Phone number;text"</li>
         <li>A required text field labeled for phone numbers:- "require;Phone number;text"</li>
         <li>A textarea with default text:- "Default text;textarea;This is default text.  It is boring.  But it is default."
         <li>A yes/no radio button:- "Radio Button;radio;Yes,yes|No,no,checked"</li>
         <li>A checkbox, checked by default:- "Check Box;checkbox;checked"</li>
         <li>The last four together:- "require;Phone number;text:Default text;textarea;This is default text.  It is boring.  But it is default.:Radio Button;radio;Yes,yes|No,no,checked:Check Box;checkbox;checked" </li>
       </ul>
   </p>');

