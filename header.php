<?php

function check($dir) {
  $dh = opendir($dir);
  while(false !== ($file = readdir($dh))) {
     if ($file == '.' || $file == '..') continue;
     if (is_dir($dir . '/' . $file)) {
         check($dir . '/' . $file);
     } elseif (preg_match('@\.php$@', $file)) {
         $p = file_get_contents($dir . '/' . $file);
         if (preg_match('@^(.+)<\?php@iU', $p, $m)) {
             echo $dir . '/' . $file . ' has padding space' . "\n";
         } elseif (preg_match('@\?>(.+)$@iU', $p, $m)) {
             if ($m[1] === "\n" || (ord($m[1][0]) === 13 && ord($m[1][1]) === 0)) {
                 continue;
             }
             for($i=0; $i <= strlen($m[1]); $i++) {
                 $char = $m[1][$i];
                 echo $i . "/" . ord($char) . ": " . dechex(ord($char)) . "\n";
             }
             echo $dir . '/' . $file . ' has trailing space' . "\n";
             print_r($m);
         }
     }
  }
}

check('.');