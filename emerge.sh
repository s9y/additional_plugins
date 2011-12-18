#!/bin/bash
cd /home/garvin/cvs/serendipity/additional_plugins/
rm additional_plugins.tgz
rm additional_themes.tgz
echo $(date) > last.txt
echo $(date) > homepage/last.txt
tar --exclude=homepage --exclude=spartacus_homepage.zip --exclude=spartacus_homepage_template.zip --exclude=emerge.sh --exclude=emerge_spartacus.dat -czf additional_plugins.tgz *
find -maxdepth 1 -type d -not -name . -not -name CVS -exec zip -9r {}.zip {} \; 1>/dev/null

cd /home/garvin/cvs/serendipity/additional_themes
tar -czf /home/garvin/cvs/serendipity/additional_plugins/additional_themes.tgz *
find -maxdepth 1 -type d -not -name . -not -name CVS -exec zip -9r {}.zip {} \; 1>/dev/null

cd /home/garvin/cvs/serendipity/additional_plugins/
php emerge_spartacus.php plugin en
php emerge_spartacus.php plugin de
php emerge_spartacus.php plugin ro
php emerge_spartacus.php plugin es
php emerge_spartacus.php plugin cs
php emerge_spartacus.php plugin cz
php emerge_spartacus.php plugin ko
php emerge_spartacus.php plugin nl
php emerge_spartacus.php plugin is
php emerge_spartacus.php plugin no
php emerge_spartacus.php plugin it
php emerge_spartacus.php plugin fr
php emerge_spartacus.php plugin zh
php emerge_spartacus.php plugin tn
php emerge_spartacus.php plugin pt
php emerge_spartacus.php plugin da
php emerge_spartacus.php plugin ru
php emerge_spartacus.php plugin fa
php emerge_spartacus.php plugin bg
php emerge_spartacus.php plugin ja
php emerge_spartacus.php plugin tw
php emerge_spartacus.php plugin fi
php emerge_spartacus.php plugin cn
php emerge_spartacus.php plugin pt_PT
php emerge_spartacus.php plugin se
php emerge_spartacus.php plugin hu
php emerge_spartacus.php plugin pl
php emerge_spartacus.php plugin sa
php emerge_spartacus.php plugin ta
php emerge_spartacus.php plugin tr

php emerge_spartacus.php plugin final
php emerge_spartacus.php template

rsync --partial -v -r ~/cvs/serendipity/additional_plugins/ \
  garvinhicking,php-blog@web.sourceforge.net:/home/groups/p/ph/php-blog/htdocs/cvs/additional_plugins/

rsync --partial -v -r ~/cvs/serendipity/additional_themes/ \
  garvinhicking,php-blog@web.sourceforge.net:/home/groups/p/ph/php-blog/htdocs/cvs/additional_themes/

rsync --partial -v -r ~/cvs/serendipity/additional_plugins/homepage/ \
  garvinhicking,php-blog@web.sourceforge.net:/home/groups/p/ph/php-blog/htdocs/homepage/

cp ~/cvs/serendipity/additional_plugins/*.xml ~/cvs/serendipity/git/additional_plugins/
cd ~/cvs/serendipity/git/additional_plugins
git pull
git rebase
git add *.xml
git commit -m "Automagic XML sync"
git push origin
