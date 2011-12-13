<?php # $Id: lang_en.inc.php,v 1.10 2007/07/20 12:56:29 garvinhicking Exp $

/**
 *  @version $Revision: 1.10 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  for serendipity_event_userprofiles.php
//
@define('PLUGIN_EVENT_USERPROFILES_DBVERSION', '0.1');
@define('PLUGIN_EVENT_USERPROFILES_ILINK','<input class="direction_ltr" id="serendipity_event_userprofiles%s" type="radio" %s name="serendipity[profile%s]" value="%s" title="%s" />');
@define('PLUGIN_EVENT_USERPROFILES_LABEL','<label for="serendipity_event_userprofiles%s">%s</label>');

@define('PLUGIN_EVENT_USERPROFILES_CITY',               'City');
@define('PLUGIN_EVENT_USERPROFILES_COUNTRY',            'Country');
@define('PLUGIN_EVENT_USERPROFILES_URL',                'Homepage');
@define('PLUGIN_EVENT_USERPROFILES_OCCUPATION',         'Occupation');
@define('PLUGIN_EVENT_USERPROFILES_HOBBIES',            'Hobbies');
@define('PLUGIN_EVENT_USERPROFILES_YAHOO',              'Yahoo');
@define('PLUGIN_EVENT_USERPROFILES_AIM',                'AIM');
@define('PLUGIN_EVENT_USERPROFILES_JABBER',             'Jabber');
@define('PLUGIN_EVENT_USERPROFILES_ICQ',                'ICQ');
@define('PLUGIN_EVENT_USERPROFILES_MSN',                'MSN');
@define('PLUGIN_EVENT_USERPROFILES_SKYPE',              'Skype');
@define('PLUGIN_EVENT_USERPROFILES_STREET',             'Street');
@define('PLUGIN_EVENT_USERPROFILES_BIRTHDAY',           'Birthday');

@define('PLUGIN_EVENT_USERPROFILES_SHOWEMAIL',          'Show E-Mail-Address');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCITY',           'Show City');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCOUNTRY',        'Show Country');
@define('PLUGIN_EVENT_USERPROFILES_SHOWURL',            'Show Homepage');
@define('PLUGIN_EVENT_USERPROFILES_SHOWOCCUPATION',     'Show Occupation');
@define('PLUGIN_EVENT_USERPROFILES_SHOWHOBBIES',        'Show Hobbies');
@define('PLUGIN_EVENT_USERPROFILES_SHOWYAHOO',          'Show Yahoo');
@define('PLUGIN_EVENT_USERPROFILES_SHOWAIM',            'Show AIM');
@define('PLUGIN_EVENT_USERPROFILES_SHOWJABBER',         'Show Jabber');
@define('PLUGIN_EVENT_USERPROFILES_SHOWICQ',            'Show ICQ');
@define('PLUGIN_EVENT_USERPROFILES_SHOWMSN',            'Show MSN');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSKYPE',          'Show Skype');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSTREET',         'Show Street');

@define('PLUGIN_EVENT_USERPROFILES_SHOW',               'Showing user profile of selected author:');
@define('PLUGIN_EVENT_USERPROFILES_TITLE',              'User Profiles');
@define('PLUGIN_EVENT_USERPROFILES_DESC',               'Shows simple user profiles and allows to embed author pictures.');
@define('PLUGIN_EVENT_USERPROFILES_SELECT',             'Select a profile to edit.');
@define('PLUGIN_EVENT_USERPROFILES_VCARD',              'Create VCard');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_AT',    'VCard created at %s');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_NOTE',  'You can find this vcard in the media library.');
@define('PLUGIN_EVENT_USERPROFILES_VCARDNOTCREATED',    'Can\'t create vcard');

@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION', 'File extension');
@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION_BLAHBLAH', 'Which file extension do the images of the authors have?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED', 'Show user picture within entry?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED_DESC', 'If enabled, a picture for the user will be shown within each entry to visually indicate who has written the entry. The image file must be placed in the "img" Subfolder of your selected template and be called like the authorname. All special characters (quotes, spaces, ...) must be replaced by an "_" inside the filename.');

//
//  for serendipity_plugin_userprofiles.php
//
@define('PLUGIN_USERPROFILES_NAME',          "Serendipity Authors");
@define('PLUGIN_USERPROFILES_NAME_DESC',     "Shows a list for all Authors");
@define('PLUGIN_USERPROFILES_TITLE',         "Title");
@define('PLUGIN_USERPROFILES_TITLE_DESC',    "Enter the Sidebar Title to display:");
@define('PLUGIN_USERPROFILES_TITLE_DEFAULT', "Authors");

@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT', 'Show comment count?');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_BLAHBLAH', 'Do you want to show the number of comments a visitor made? It can either be disabled, or you can append/prepend the comment count to the comment body, or you can place the commentcount anyplace you like by editing your comments.tpl template and placing {$comment.plugin_commentcount} at the place you want. You can customize the look of the container via the .serendipity_commentcount CSS class.');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_APPEND', 'Append to comment body');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_PREPEND', 'Prepend to comment body');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_SMARTY', 'Manual Smarty templating');

@define('PLUGIN_USERPROFILES_GRAVATAR', 'Use Gravatar rather than local image?');
@define('PLUGIN_USERPROFILES_GRAVATAR_DESC', 'Uses Gravatar image associated with your email address.  Register at www.gravatar.com');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE', 'Gravatar picture size');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE_DESC', 'Sets the display size for your Gravatar userpic, in square pixels. Max is 80.');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING', 'Maximum Gravatar rating');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING_DESC','Sets the highest rating allowed for Gravatars.  G, PG, R or X.');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT', 'Location of default Gravatar image');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT_DESC', 'Specifies the location of a graphic to display if a user doesn\'t have a Gravatar.');

@define('PLUGIN_USERPROFILES_BIRTHDAYSNAME', 'Birthdays of users');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE', 'Birthdays');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DESCRIPTION', 'Show when the users have the next birthday.');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DEFAULT', 'birthdays');

@define('PLUGIN_USERPROFILES_BIRTHDAYIN', 'Birthday in %d days');
@define('PLUGIN_USERPROFILES_BIRTHDAYTODAY', 'Birthday today');

@define('PLUGIN_USERPROFILES_BIRTHDAYNUMBERS', 'Limit display of people having birthday to this number');
@define('PLUGIN_USERPROFILES_SHOWAUTHORS', 'Show userlist?');
@define('PLUGIN_USERPROFILES_SHOWGROUPS', 'Show link to detailed groups?');
