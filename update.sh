#!/bin/bash
cd /home/garvin/cvs/serendipity/additional_themes
cvs -q update -d 1>/var/log/s9y-cvs.log 2>&1
find -name DEADJOE -exec rm {} \;
cd /home/garvin/cvs/serendipity/additional_plugins
cvs -q update -d 1>>/var/log/s9y-cvs.log 2>&1
find -name DEADJOE -exec rm {} \;

/home/garvin/cvs/serendipity/git/additional_plugins/gitclone.sh
php /home/garvin/cvs/serendipity/additional_plugins/gitclone.php
php /home/garvin/cvs/serendipity/additional_themes/gitclone.php
