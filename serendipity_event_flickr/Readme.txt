
*** DESCRIPTION ***

This plugin can import photos from Flickr.com directly into serendipity's media library.
The only requirement is an API key (Get one at http://www.flickr.com/services/api/misc.api_keys.html)
to be able to access photos via web services.

For the moment, only Flickr.com is supported but other could be included if someone
needs it (Buzznet for exemple). Please mail me for a such feature.

Send any questions or comments to Jay.Bertrand@Free.Fr.

*** TODO ***

Add a second step to the import operation allowing the user to select the size
of the image to import and the directory where to upload.

Modify the phpFlickr library to prevent if from "die()-ing" too early when
an error occurs.

*** INSTALLATION ***

/!\ With some ISP's account, it is impossible to change the include path
with an ini_set() instruction (Free.fr for example). The plugin
will then fail to run since it can't instanciate some classes.

In that case, you probably have a special place in your account
to put common php files (ask your ISP). On Free.fr, just create a
directory called 'include' in the root directory of your account.
Then copy anything in the phpFlickr/PEAR subdir of the plugin to 
that directory.

My account on Free.fr:

+ blog
  + plugins
    + serendipity_event_flickr
      + phpFlickr
        + phpFlickr.php
        + xml.php

+ include
  + DB
  + HTTP
  + Net
  + DB.php
  + PEAR.php



Verion 0.1
---------------------------------------
Connect to Flickr.com and display photos for a given
username. Advanced search criterias include tags and
free text (keywords). A sort order is also possible.
Import is done at the root directory of the media library.

