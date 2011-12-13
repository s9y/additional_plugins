<?php # $Id: lang_en.inc.php,v 1.6 2008/02/15 11:27:45 garvinhicking Exp $

/**
 *  @version $Revision: 1.6 $
 *  @author Translator Noel <kriana_raktara@comcast.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_AUDIOSCROBBLER_TITLE', 'Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_TITLE_BLAHBLAH', 'Shows last played songs in your blog');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER', 'Number of Songs');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER_BLAHBLAH', 'How many songs should be displayed? (Standard: one, must be at least 1)');
@define('PLUGIN_AUDIOSCROBBLER_USERNAME', 'Audioscrobbler Username');
@define('PLUGIN_AUDIOSCROBBLER_USERNAME_BLAHBLAH', 'Enter your username so that the plugin can access the appropriate feed.');
@define('PLUGIN_AUDIOSCROBBLER_NEWWINDOW', 'New Window');
@define('PLUGIN_AUDIOSCROBBLER_NEWWINDOW_BLAHBLAH', 'Sollen die Links in einem neuen Fenster ge??ffnet werden (needs Javascript)');
@define('PLUGIN_AUDIOSCROBBLER_CACHETIME', 'How often should the list be updated?');
@define('PLUGIN_AUDIOSCROBBLER_CACHETIME_BLAHBLAH', 'The contents of the Audioscrobbler feed are cached. When this number of minutes expires, it is updated. (Standard: 30 minutes, minimum 5 Minuten)');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING', 'Entry Formatting');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLAHBLAH', 'Use %ARTIST% for the Artist, %SONG% for the Song, %ALBUM% for the Album and %DATE% for the Date.');
@define('PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE', 'Stunden Unterschied zur UTC Zeit');
@define('PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE_BLAHBLAH', 'Time offset from GMT (example: EST (Boston, New York (USA)) = -5)');   
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK', 'Formatting for the whole block');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK_BLAHBLAH', 'Use %ENTRIES% for the songlist, %PROFILE% for a link to your Audioscrobbler Profile, and %LASTUPDATE% for the date and time the feed was last cached.');
@define('PLUGIN_AUDIOSCROBBLER_PROFILETITLE', 'Title for the Profile Link');
@define('PLUGIN_AUDIOSCROBBLER_PROFILETITLE_BLAHBLAH', 'Text to display for the optional linke to your Audioscrobbler profile. (To use your username type %USER%');
@define('PLUGIN_AUDIOSCROBBLER_SONGLINK', 'Link Songs');
@define('PLUGIN_AUDIOSCROBBLER_SONGLINK_BLAHBLAH', 'Should songs be linked to their Audioscrobbler page?');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK', 'Link Artists');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_BLAHBLAH', 'Should artists be linked? (choose a service)');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_NONE', 'no');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_SCROBBLER', 'Artist page in Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_NONE', 'with Musicbrainz, if available');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_SCROBBLER', 'with Musicbrainz, if Musicbrainz is not available, with Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_SPACER', 'Separator');
@define('PLUGIN_AUDIOSCROBBLER_SPACER_BLAHBLAH', 'What should be used to separate entries in the songlist?');
@define('PLUGIN_AUDIOSCROBBLER_COULD_NOT_WRITE', 'Cache could not be written');
@define('PLUGIN_AUDIOSCROBBLER_COULD_NOT_READ', 'Cache could not be evaluated');
@define('PLUGIN_AUDIOSCROBBLER_FEED_OFFLINE', 'Audioscrobbler Songlist offline');
@define('PLUGIN_AUDIOSCROBBLER_STACK', 'Use stacking?');
@define('PLUGIN_AUDIOSCROBBLER_STACK_BLAHBLAH', 'If the number of songs in your songlist is smaller than the number of songs you want to have displayed, you can enable this setting so that the last song item will be repeated X times to fill the list.');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER_BLAHBLAH', 'How many songs should be displayed? (Standard: one, must be at least 1)');
@define('PLUGIN_AUDIOSCROBBLER_FORCE_ENCODING', 'Force encoding:');
@define('PLUGIN_AUDIOSCROBBLER_FORCE_ENCODING_BLAHBLAH', 'By default, Serendipity uses UTF-8 to parse the Audioscrobbler data.  If this is breaking special characters because your blog is not UTF-8, enter the appropriate encoding here.');

