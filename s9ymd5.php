<?php
$ver = $argv[1];

function msum($string) {
 $p = explode(' ', $string);
 echo $p[0];
}

?>
Use this for copy&paste to s9y.org download pages

 * ((http://prdownloads.sourceforge.net/php-blog/serendipity-<?= $ver; ?>.tar.gz?download)(Serendipity <?= $ver; ?> tar.gz))<br>(MD5: <?= msum(`md5sum serendipity-$ver.tar.gz`) ?>)
 * ((http://prdownloads.sourceforge.net/php-blog/serendipity-<?= $ver; ?>.tar.bz2?download)(Serendipity <?= $ver; ?> tar.bz2)) <br>(MD5: <?= msum(`md5sum serendipity-$ver.tar.bz2`) ?>)
 * ((http://prdownloads.sourceforge.net/php-blog/serendipity-<?= $ver; ?>.zip?download)(Serendipity <?= $ver; ?> ZIP)) <br>(MD5: <?= msum(`md5sum serendipity-$ver.zip`) ?>)


 * ((http://prdownloads.sourceforge.net/php-blog/serendipity-<?= $ver; ?>-lite.tar.gz?download)(Serendipity <?= $ver; ?> LITE tar.gz))<br>(MD5: <?= msum(`md5sum serendipity-$ver-lite.tar.gz`) ?>)
 * ((http://prdownloads.sourceforge.net/php-blog/serendipity-<?= $ver; ?>-lite.zip?download)(Serendipity <?= $ver; ?> LITE ZIP)) <br>(MD5: <?= msum(`md5sum serendipity-$ver-lite.tar.gz`) ?>)
  
