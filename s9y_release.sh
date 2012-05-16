#!/bin/bash
# Script used to upload release tarball.

# 1. Make sure serendipity_config.inc.php points to proper version
# 2. Make sure a release tag for git exists
# 3. In this script: Change version numbers, git checkout path
# 4. Make sure docs/NEWS is updated
# 4.1 Update docs/NEWS of all other branches (master, 2.0, etc.)
# 5. Write blog entry, change version number in sidebar
# 6. Execute this script (make sure proper version numbers exists)
# 7. Change s9y.org downloads page


cd git/s9y_16
git archive --output release.tar --prefix serendipity/ 1.6.2
mv release.tar ../../
cd ../../
rm -rf serendipity
tar -xvf release.tar

export SVN_SSH="ssh -l garvinhicking"
rm serendipity-1.6.2.tar.gz
rm serendipity-1.6.2.zip
cd serendipity/bundled-libs
./create_release.sh serendipity-1.6.2.tar.gz serendipity nobody nogroup
cd ../../
zip -9 -r serendipity-1.6.2.zip serendipity
tar --owner=nobody --group=nogroup -cjf "serendipity-1.6.2.tar.bz2" serendipity
cd serendipity
mkdir templates_stripped
mv templates/default templates_stripped/
mv templates/carl_contest templates_stripped/
mv templates/bulletproof templates_stripped/
rm -rf templates
mv templates_stripped templates
rm -rf deployment
rm checksums.inc.php
cd ..
zip -r serendipity-1.6.2-lite.zip serendipity
tar --owner=nobody --group=nogroup -czf "serendipity-1.6.2-lite.tar.gz" "serendipity"
tar --owner=nobody --group=nogroup -cjf "serendipity-1.6.2-lite.tar.bz2" "serendipity"

scp serendipity/docs/NEWS garvinhicking@frs.sourceforge.net:/home/frs/project/p/ph/php-blog/serendipity/1.6.2/README
scp serendipity/docs/NEWS garvinhicking@frs.sourceforge.net:/home/frs/project/p/ph/php-blog/serendipity/README
scp serendipity-1.6.2.* garvinhicking@frs.sourceforge.net:/home/frs/project/p/ph/php-blog/serendipity/1.6.2/
php s9ymd5.php 1.6.2
