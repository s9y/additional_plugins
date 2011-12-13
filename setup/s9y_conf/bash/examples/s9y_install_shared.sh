#!/bin/bash
#
# ./s9y_install_shared.sh
#
# Serendipity Shared Installation script
#
# S9Y config generator v0.6
#
# Wed Mar 22 09:41:51 GMT 2006

#
# Local User
#
cp -r /usr/local/lib/php/s9y/deployment/* /home/localuser/public_html/blog
cp -r /usr/local/lib/php/s9y/templates /home/localuser/public_html/blog/
cp -r /usr/local/lib/php/s9y/htmlarea /home/localuser/public_html/blog/
chown -R localuser:www /home/localuser/public_html/blog
chown -R localuser:www /home/localuser/public_html/blog/*
chmod u+rwx,g+rwx /home/localuser/public_html/blog
chmod u+rwx,g+rwx /home/localuser/public_html/blog/{templates_c,uploads,archives}
chown wwwrun:www /home/localuser/public_html/blog/serendipity_config_local.inc.php
chmod u+rwx,g-rwx,o-rwx /home/localuser/public_html/blog/serendipity_config_local.inc.php

#
# Virtual Host user.foo.bar
#
cp -r /usr/local/lib/php/s9y/deployment/* /srv/www/vhosts/bar/foo/user
cp -r /usr/local/lib/php/s9y/templates /srv/www/vhosts/bar/foo/user/
cp -r /usr/local/lib/php/s9y/htmlarea /srv/www/vhosts/bar/foo/user/
chown -R root:www /srv/www/vhosts/bar/foo/user
chown -R root:www /srv/www/vhosts/bar/foo/user/*
chmod u+rwx,g+rwx /srv/www/vhosts/bar/foo/user
chmod u+rwx,g+rwx /srv/www/vhosts/bar/foo/user/{templates_c,uploads,archives}
chown wwwrun:www /srv/www/vhosts/bar/foo/user/serendipity_config_local.inc.php
chmod u+rwx,g-rwx,o-rwx /srv/www/vhosts/bar/foo/user/serendipity_config_local.inc.php

