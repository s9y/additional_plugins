#!/bin/bash

# Change to main CVS directory
cd ../../

# UPDATE REPOSITORIES
cd additional_themes
cvs update -d
cd ../additional_plugins
cvs update -d

# CREATE ZIP FILES
cd /home/groups/p/ph/php-blog/htdocs/cvs/additional_plugins/
rm ../additional_plugins.tgz
rm ../additional_themes.tgz
tar --exclude=emerge.sh --exclude=emerge_spartacus.dat -czf ../additional_plugins.tgz *

cd /home/groups/p/ph/php-blog/htdocs/cvs/additional_themes
tar -czf ../additional_themes.tgz *
find -maxdepth 1 -type d -exec zip -9r {}.zip {} \;

cd /home/groups/p/ph/php-blog/htdocs/cvs/additional_plugins/
find -maxdepth 1 -type d -exec zip -9r {}.zip {} \;

# UPDATE THE CONTENT FILES OF THE HOMEPAGE
ln -s index.php cvs/additional_plugins/homepage/index.php
ln -s -d css cvs/additional_plugins/homepage/css
ln -s header.png cvs/additional_plugins/homepage/header.png

cd /home/groups/p/ph/php-blog/htdocs
unzip -o spartacus_homepage.zip
unzip -o spartacus_homepage_template.zip
