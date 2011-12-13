<?php

$dh = @opendir('.');
if (!$dh) {
    die('Failure');
}

// Only non-UTF languages!
$ext = array(
    'tw'    => 'big5',
    'se'    => 'ISO-8859-1',
    'pt_PT' => 'ISO-8859-1',
    'pt'    => 'ISO-8859-1',
    'no'    => 'ISO-8859-1',
    'nl'    => 'ISO-8859-1',
    'it'    => 'ISO-8859-1',
    'is'    => 'ISO-8859-1',
    'hu'    => 'ISO-8859-2',
    'fr'    => 'ISO-8859-1',
    'es'    => 'ISO-8859-15',
    'en'    => 'ISO-8859-1',
    'de'    => 'ISO-8859-1',
    'da'    => 'ISO-8859-1',
    'cz'    => 'ISO-8859-2',
    'cs'    => 'windows-1250',
    'bg'    => 'windows-1251',
    'zh'    => 'gb2312'
);

while (($file = readdir($dh)) !== false) {
    if (!is_dir($file . '/UTF-8/')) {
        continue;
    }
    
    $langdh = opendir($file);
    while (($langfile = readdir($langdh)) !== false) {
        if (!preg_match('@lang_(.+)\.inc\.php$@i', $langfile, $extmatch)) {
            continue;
        }
        
        $target = $file . '/UTF-8/' . $langfile;
        $source = $file . '/' . $langfile;
        copy($source, $target);

        if (!isset($ext[$extmatch[1]])) {
            echo "'$langfile' already is in UTF-8. Leaving untouched.\n";
        } else {
            $set = $ext[$extmatch[1]];
            $cmd = 'iconv -f ' . $set . ' -t UTF-8 -o ' . $target . ' ' . $source . "\n";
            echo $cmd;
            $return = `$cmd`;
            chmod($target, 0644);
        }
    }
    closedir($langdh);
}

closedir($dh);