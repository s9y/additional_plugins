<?php
chdir(dirname(__FILE__));

$out = explode("\n", `cvs -n -q update`);

foreach($out AS $file) {
	$file = trim($file);
	if (empty($file)) continue;
  
	if (preg_match('@^\? @', $file)) {
		$file = str_replace('? ', '', $file);
		echo "CVS ADD $file\n";
		`cvs add $file`;
	} elseif (preg_match('@^U @', $file)) {
		$file = str_replace('U ', '', $file);
		echo "CVS RM $file\n";
		`cvs rm $file`;
	}
}

`cvs -q commit -m "gitclone.sh autocommit"`;

