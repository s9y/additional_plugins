<?php # $Id$

/**
 *  @version $Revision$
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_PICASA_NAME',                                 'Picasa');
@define('PLUGIN_EVENT_PICASA_DESC',                                 'Shows Picasa albums exported as XML');
@define('PLUGIN_EVENT_PICASA_PROP_PATH',                            'Path');
@define('PLUGIN_EVENT_PICASA_PROP_PATH_DESC',                       'Path to the directory where Picasa albums are stored on the Webserver.  This should be a relative path from the root of your serendipity installation.');
@define('PLUGIN_EVENT_PICASA_PROP_JSWINDOW',                        'Open the target window using JavaScript');
@define('PLUGIN_EVENT_PICASA_PROP_JSWINDOW_DESC',                   'Each image can be seen in a larger version in a new window. Using JavaScript the size of the new window can automatically be adjusted to the size of the image.');
@define('PLUGIN_EVENT_PICASA_PROP_SHOWTITLE',                       'Show title of the albums');
@define('PLUGIN_EVENT_PICASA_PROP_SHOWTITLE_DESC',                  'Shall the title of the album be shown in the entry? Will only be used when not using Smarty-Templating.');
@define('PLUGIN_EVENT_PICASA_PROP_SMARTY',                          'Smarty-Template');
@define('PLUGIN_EVENT_PICASA_PROP_SMARTY_DESC',                     'Which Smarty template shall be used to render the output?');
@define('PLUGIN_EVENT_PICASA_PROP_SMARTY_NONE',                     'Do not use Smarty');
@define('PLUGIN_EVENT_PICASA_PROP_UPLOAD_SIZE',                     'Size of uploaded images');
@define('PLUGIN_EVENT_PICASA_PROP_UPLOAD_SIZE_DESC',                'If images are uploaded directly from picasa, the size they should be');
@define('PLUGIN_EVENT_PICASA_PROP_CREATE_ENTRY_AFTER_UPLOAD',       'Create new entry for uploaded album');
@define('PLUGIN_EVENT_PICASA_PROP_CREATE_ENTRY_AFTER_UPLOAD_DESC',  'After an album is uploaded, should a new draft entry that includes the new album be created?');

@define('PLUGIN_EVENT_PICASA_ERR_INDEXNOTFOUND',                    '<i>Picasa Plugin: Index file of the album could not be found</i>');
@define('PLUGIN_EVENT_PICASA_ERR_MISSING_RSS',                      'Sorry, but no pictures were received.  This URL only works when loaded from a Picasa button.');
@define('PLUGIN_EVENT_PICASA_ERR_UPLOAD_DIR_ALREADY_EXISTS',        'Upload directory already exists');
@define('PLUGIN_EVENT_PICASA_ERR_DIR_CREATION_FAILED',              'Failed to create directory for upload');

@define('PLUGIN_EVENT_PICASA_UPLOAD_HEADER',                        'Upload images from Google Picasa to the Serendipity blog at ');
@define('PLUGIN_EVENT_PICASA_UPLOAD_USERNAME',                      'Username');
@define('PLUGIN_EVENT_PICASA_UPLOAD_PASSWORD',                      'Password');
@define('PLUGIN_EVENT_PICASA_UPLOAD_REMEMBER_LOGIN',                'Remember login?');
@define('PLUGIN_EVENT_PICASA_UPLOAD_LOGIN',                         'Login');
@define('PLUGIN_EVENT_PICASA_UPLOAD_DISCARD',                       'Discard');
@define('PLUGIN_EVENT_PICASA_UPLOAD_ALBUMNAME',                     'Album Name');
@define('PLUGIN_EVENT_PICASA_UPLOAD_DESCRIPTION',                   'Description');
@define('PLUGIN_EVENT_PICASA_UPLOAD_PARENTDIR',                     'Parent directory');
@define('PLUGIN_EVENT_PICASA_UPLOAD_PARENTDIR_BASEDIR',             'Base Directory');
@define('PLUGIN_EVENT_PICASA_UPLOAD_UPLOAD',                        'Upload');
@define('PLUGIN_EVENT_PICASA_UPLOAD_SUCCESS',                       'Upload successful!');

@define('PLUGIN_EVENT_PICASA_EXAMPLE_HEADER',                       'Instructions for adding an upload button to Google Picasa');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP1',                        'Download the following file: ');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP2',                        'Rename the file to have a .zip extension.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP3',                        'Extract the .pbf file from the zip file.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP4',                        'Open it in a text editor. It is an xml file. Replace every instance of "mysite.com" with the name of the site that hosts your blog. Replace "mysite.com/serendipity/index.php" with the actual path to your index.php in your s9y blog.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP5',                        'Put the pbf file back into the .zip.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP6',                        'Rename the .zip file back to .pbz.');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP7',                        'Put the .pbz file in the buttons directory of your picasa installation, which is typically "C:\Program Files\Google\Picasa\buttons".');
@define('PLUGIN_EVENT_PICASA_EXAMPLE_STEP8',                        'Launch picasa, and the button should be present. If it is not, you should be able to find it in Tools >> Configure Buttons...');

?>
