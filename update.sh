#!/bin/bash
echo "WHOAMI: `whoami`";
cd /home/garvin/cvs/serendipity/additional_themes
echo "CVS update additional_themes:";
cvs -v update -d 1>/var/log/s9y-cvs.log 2>&1
find -name DEADJOE -exec rm {} \;
cd /home/garvin/cvs/serendipity/additional_plugins
echo "CVS update additional_plugins:";
cvs -v update -d 1>>/var/log/s9y-cvs.log 2>&1
find -name DEADJOE -exec rm {} \;

echo "Gitclone.sh:";
/home/garvin/cvs/serendipity/git/additional_plugins/gitclone.sh
echo "Gitclone.php additional_plugins:";
php /home/garvin/cvs/serendipity/additional_plugins/gitclone.php
echo "Gitclone.php additional_themes:";
php /home/garvin/cvs/serendipity/additional_themes/gitclone.php
