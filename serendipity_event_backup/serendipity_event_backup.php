<?php  #

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

# (c) 2005 by Alexander 'dma147' Mieland, http://blog.linux-stats.org, <dma147@linux-stats.org>
# Contact me on IRC in #linux-stats, #archlinux, #archlinux.de, #s9y on irc.freenode.net

// Probe for a language include with constants. Still include defines later on,
// if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

#########################################################################################

class serendipity_event_backup extends serendipity_event {

    var $debug;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_BACKUP_TITLE);
        $propbag->add('description',   PLUGIN_BACKUP_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('version',       '0.14');
        $propbag->add('author',       'Alexander \'dma147\' Mieland, http://blog.linux-stats.org, dma147@linux-stats.org');
        $propbag->add('stackable',     false);
        $propbag->add('event_hooks',   array(
        									'frontend_footer'		  => true,
                                            'external_plugin'         => true,
                                            'backend_sidebar_entries' => true,
                                            'backend_sidebar_admin'   => true,
                                            'backend_sidebar_entries_event_display_backup' => true,
                                            'css_backend'             => true
                                        )
        );
        $propbag->add('configuration', array(
        									'abspath_backupdir'
										)
		);
        $propbag->add('groups', array('FRONTEND_FULL_MODS', 'BACKEND_FEATURES'));
        $this->dependencies = array('serendipity_event_entryproperties' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
    	global $serendipity;


    	$below_docroot = preg_replace("`(.*)\/[^\/]*`i", "\\1", $_SERVER['DOCUMENT_ROOT']);

        switch($name) {

            case 'abspath_backupdir' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_BACKUP_ABSPATH_BACKUPDIR);
                $propbag->add('description', PLUGIN_BACKUP_ABSPATH_BACKUPDIR_BLAHBLAH);
                $propbag->add('default', $below_docroot.'/backups');

                break;


            default:
                    return false;
        }
        return true;
    }


    function selected() {
        global $serendipity;

        if ($serendipity['GET']['subpage'] == $this->get_config('pageurl') ||
            preg_match('@^' . preg_quote($this->get_config('permalink')) . '@i', $serendipity['GET']['subpage'])) {
            return true;
        }

        return false;
    }


    function setupDB() {
        global $serendipity;

		$q = "CREATE TABLE {$serendipity['dbPrefix']}dma_sqlbackup (
					auto_backup 	int(2)		NOT NULL 	default '0',
					time_backup 	int(10)		NOT NULL 	default '0',
					last_backup 	int(10) 	NOT NULL 	default '0',
					data_backup 	text 		NOT NULL,
					auto_backdel 	int(2) 		NOT NULL 	default '0',
					time_backdel 	int(10) 	NOT NULL 	default '0',
					last_backdel 	int(10) 	NOT NULL 	default '0'
			)";
		$sql = serendipity_db_schema_import($q);

		$q = "CREATE TABLE {$serendipity['dbPrefix']}dma_htmlbackup (
					auto_backup 	int(2)		NOT NULL 	default '0',
					time_backup 	int(10)		NOT NULL 	default '0',
					last_backup 	int(10) 	NOT NULL 	default '0',
					data_backup 	text 		NOT NULL,
					auto_backdel 	int(2) 		NOT NULL 	default '0',
					time_backdel 	int(10) 	NOT NULL 	default '0',
					last_backdel 	int(10) 	NOT NULL 	default '0'
			)";
		$sql = serendipity_db_schema_import($q);

		$q = "TRUNCATE TABLE {$serendipity['dbPrefix']}dma_sqlbackup";
		$sql = serendipity_db_schema_import($q);

		$q = "TRUNCATE TABLE {$serendipity['dbPrefix']}dma_htmlbackup";
		$sql = serendipity_db_schema_import($q);

		$q = "INSERT INTO {$serendipity['dbPrefix']}dma_sqlbackup (
					auto_backup,
					time_backup,
					last_backup,
					data_backup,
					auto_backdel,
					time_backdel,
					last_backdel
		) VALUES (
					'0',
					'0',
					'0',
					'',
					'0',
					'0',
					'0'
		)";
		$sql = serendipity_db_schema_import($q);
		$q = "INSERT INTO {$serendipity['dbPrefix']}dma_htmlbackup (
					auto_backup,
					time_backup,
					last_backup,
					data_backup,
					auto_backdel,
					time_backdel,
					last_backdel
		) VALUES (
					'0',
					'0',
					'0',
					'',
					'0',
					'0',
					'0'
		)";
		$sql = serendipity_db_schema_import($q);
    }

    function uninstall(&$propbag) {
        global $serendipity;

        serendipity_db_query("DROP TABLE {$serendipity['dbPrefix']}dma_sqlbackup");
        serendipity_db_query("DROP TABLE {$serendipity['dbPrefix']}dma_htmlbackup");
	}


	function getRelPath() {
		global $serendipity;
		$c_path = dirname(__FILE__);
		$b_path = $serendipity['serendipityPath'];
		if ($b_path[(strlen($b_path)-1)] == "/")
			$b_path = substr($b_path, 0, strlen($b_path)-1);
		$r_path = ".".str_replace($b_path, "", $c_path);
		return $r_path;
	}


	function calcFilesize($filesize) {
	   $array = array(
		   'YB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
		   'ZB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
		   'EB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
		   'PB' => 1024 * 1024 * 1024 * 1024 * 1024,
		   'TB' => 1024 * 1024 * 1024 * 1024,
		   'GB' => 1024 * 1024 * 1024,
		   'MB' => 1024 * 1024,
		   'KB' => 1024,
	   );
	   if($filesize <= 1024) {
		   $filesize = $filesize . ' Bytes';
	   }
	   foreach($array AS $name => $size) {
		   if($filesize > $size || $filesize == $size) {
			   $filesize = round((round($filesize / $size * 100) / 100), 2) . ' ' . $name;
		   }
	   }
	   return $filesize;
	}


	function MakeHTMLBackup($dir_to_backup="", $exclude=NULL) {
		global $serendipity;
		$BACKUPDIR = $this->get_config('abspath_backupdir');
		$backupscript = dirname(__FILE__) . '/backup.sh';
		@chmod($backupscript, 0777);

		$excludes = "";
		if (is_array($exclude) && count($exclude) >= 1) {
			for($a=0, $b=count($exclude); $a<$b; $a++) {
				if ($excludes != "") { $excludes .= " "; }
				$excludes .= "\"".$exclude[$a]."\"";
			}
		}

		passthru($backupscript." \"".$dir_to_backup."\" \"".$BACKUPDIR."\" ".$excludes);
	}


	function MakeSQLBackup($complete=1, $tables="", $what="data", $drop=1) {
		global $serendipity;
		$BACKUPDIR = $this->get_config('abspath_backupdir');
		$filetime = date("Y-m-d-H-i",time());
		$success = 0;
		@ignore_user_abort(1);
		@set_time_limit(0);
		if ($complete == 1) {
			unset($tables);
			$QUERY = serendipity_db_query("SHOW TABLES");
			foreach ($QUERY AS $THISTABLE) {
				$tables[] = $THISTABLE[0];
			}
		}
		for ($q=0;$q<count($tables);$q++) {
			$table = $tables[$q];
			serendipity_db_query("OPTIMIZE TABLE `".$table."`");

			if (!file_exists($BACKUPDIR)) {
				@mkdir($BACKUPDIR, 0777);
				@chmod($BACKUPDIR, 0777);
			}
			if (!file_exists($BACKUPDIR."/tmp")) {
				@mkdir($BACKUPDIR."/tmp", 0777);
				@chmod($BACKUPDIR."/tmp", 0777);
			}
			if (!file_exists($BACKUPDIR."/tmp/last_backup")) {
				@mkdir($BACKUPDIR."/tmp/last_backup", 0777);
				@chmod($BACKUPDIR."/tmp/last_backup", 0777);
			}

			$dateidir = $BACKUPDIR."/tmp/last_backup/";
			$dateiname = $table.".sql";
			$sqltext = "#########################################################\n";
			$sqltext .= "## Created by serendipity_event_backup, a s9y plugin\n";
			$sqltext .= "## Copyright © 2004- by Alexander Mieland\n";
			$sqltext .= "## http://blog.linux-stats.org\n";
			$sqltext .= "## Contact: dma147@linux-stats.org\n";
			$sqltext .= "#########################################################\n";
			$sqltext .= "##\n";
			$sqltext .= "##\n";
			$create_text = "";
			$insert_text = "";
			if ($what == "structure" OR $what == "data") {
				if ($drop == 1) {
					$create_text .= "##\n";
					$create_text .= "##		DROP-data von Tabelle ".$table."\n";
					$create_text .= "##\n";
					$create_text .= "DROP TABLE IF EXISTS ".$table.";\n\n";
				}
				$create_text .= "##\n";
				$create_text .= "##		CREATE-data von Tabelle ".$table."\n";
				$create_text .= "##\n";
				$sql = "SHOW CREATE TABLE ".$table."";
				unset($result);
				$result = serendipity_db_query($sql);
				if (!isset($result)) {
					$sql = "DESCRIBE ".$table."";
					unset($result);
					$result = serendipity_db_query($sql);
					if (isset($result)) {
						$fieldnum=0;
						foreach ($result AS $field) {
							$fieldnum++;
						}
						unset($result);
						$result = serendipity_db_query($sql);
						$create_text .= "CREATE TABLE ".$table."";
						$tz=0;
						$sqlende = "";
						foreach ($result AS $field) {
							$name  = $field[0];
							$type  = " ".$field[1];
							if ($row[2] == "") {$null = " NOT NULL";} else {$null = " NULL";}
							if ($row[4] == "") {$default = "";} else {$default = " DEFAULT '".$row[4]."'";}
							if ($row[5] == "") {$extra = "";} else {$extra = " ".$row[5];}
							$create_text .= "\t".$name."".$type.$null.$default.$extra;
							$tz++;
							if ($tz<$fieldnum) $create_text .= ", \n";
						}
						unset($pri_key);
						unset($mul_key);
						unset($mul_index_key);
						unset($uni_key);
						unset($uni_index_key);
						unset($full_key);
						unset($full_index_key);
						$sql = "SHOW KEYS FROM ".$table."";
						$key_result = serendipity_db_query($sql);
						foreach ($key_result AS $row) {
							$non_unique = $row[1];
							$key_name = $row[2];
							$column_name = $row[4];
							$fulltext = $row[9];
							if (ereg("PRIMARY", $key_name)) {
								$pri_key[] = $column_name;
								$pri_index_key[] = $key_name;
							} elseif ($non_unique) {
								if ($fulltext=="FULLTEXT") {
									$full_key[] = $column_name;
									$full_index_key[] = $key_name;
								} else {
									$mul_key[] =  $column_name;
									$mul_index_key[] = $key_name;
								}
							} elseif ((!$non_unique) and (!ereg("PRIMARY", $key_name))) {
								$uni_key[] =  $column_name;
								$uni_index_key[] = $key_name;
							}
						}
						if (count($pri_key)>0) {
							$pri_text = " PRIMARY KEY (";
							for ($tr=0; $tr<count($pri_key); $tr++) {
								$pri_text .= $pri_key[$tr];
								if (($tr+1)<count($pri_key)) $pri_text .= ", ";
							}
							$pri_text .= ")";
							$create_text .= ", \n\t".trim($pri_text);
						}
						if (count($mul_key)>0) {
							$mul_text = " KEY (";
							for ($tr=0; $tr<count($mul_key); $tr++) {
								$mul_text .= $mul_key[$tr];
								if (($tr+1)<count($mul_key)) $mul_text .= ", ";
							}
							$mul_text .= ")";
							$create_text .= ", \n\t".trim($mul_text);
						}
						if (count($full_key)>0) {
							$full_text = " FULLTEXT KEY (";
							for ($tr=0; $tr<count($full_key); $tr++) {
								$full_text .= $full_key[$tr];
								if (($tr+1)<count($full_key)) $full_text .= ", ";
							}
							$full_text .= ")";
							$create_text .= ", \n\t".trim($full_text);
						}
						if (count($uni_key)>0) {
							$uni_text = " UNIQUE KEY (";
							for ($tr=0; $tr<count($uni_key); $tr++) {
								$uni_text .= $uni_key[$tr];
								if (($tr+1)<count($uni_key)) $uni_text .= ", ";
							}
							$uni_text .= ")";
							$create_text .= ", \n\t".trim($uni_text);
						}
						$create_text .= "\n);\n\n";
					}
				} else {
					$create_text .= $result[0][1].";\n\n";
				}
			}
			if ($what == "dataonly" OR $what == "data") {
				$insert_text .= "##\n";
				$insert_text .= "##		INSERT-data von Tabelle ".$table."\n";
				$insert_text .= "##\n";
				$R2 = serendipity_db_query("SELECT * FROM ".$table."");
				unset($THIS);
				if (is_array($R2) && count($R2) >= 1) {
					foreach ($R2 AS $THIS) {
						$insert_text .= "INSERT INTO ".$table." (";
						@reset ($THIS);
						unset($key);
						unset($val);
						$insert_text1 = '';
						$insert_text2 = '';
						foreach ($THIS as $key => $val) {
							if (!intval($key) AND $key != "0") {
								$insert_text1 .= "".$key.",";
								$insert_text2 .= "'".addslashes($val)."',";
							}
						}
						$insert_text1 = substr($insert_text1, 0, (strlen($insert_text1)-1));
						$insert_text2 = substr($insert_text2, 0, (strlen($insert_text2)-1));
						$insert_text .= $insert_text1.") VALUES (".$insert_text2.");\n";
					}
				}
			}
			if ($create_text != "") {
				$create_text = $sqltext.$create_text;
				if ($TXT=fopen($dateidir.$filetime."_CREATE_".$dateiname, "w")) {
					fputs($TXT,$create_text);
					fclose($TXT);
					chmod($dateidir.$filetime."_CREATE_".$dateiname, 0666);
				}
			}
			if ($insert_text != "") {
				$insert_text = $sqltext.$insert_text;
				if ($TXT=fopen($dateidir.$filetime."_INSERT_".$dateiname, "w")) {
					fputs($TXT,$insert_text);
					fclose($TXT);
					chmod($dateidir.$filetime."_INSERT_".$dateiname, 0666);
				}
			}
		}
	}


	function CheckAutoHTMLBackup() {
		global $serendipity;
		$BACKUPDIR = $this->get_config('abspath_backupdir');
		if (!file_exists($BACKUPDIR)) {
			@mkdir($BACKUPDIR, 0777);
			@chmod($BACKUPDIR, 0777);
		}
		$retconf = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}dma_htmlbackup");
		foreach ($retconf[0] as $key => $val) {
			$backupconfig[$key] = stripslashes(trim($val));
		}
		$backupdata_array = explode("|^|", $backupconfig['data_backup']);
		$dir_to_backup = trim($backupdata_array[0]);
		if (substr($dir_to_backup,  strlen($dir_to_backup)-1, strlen($dir_to_backup)) == "/") {
			$dir_to_backup = substr($dir_to_backup,  0, strlen($dir_to_backup)-1);
		}
		$exclude = unserialize(trim($backupdata_array[1]));

		if ($backupconfig['auto_backup'] == 1) {
			$now = time();
			@ignore_user_abort(1);
			@set_time_limit(0);
			if (($backupconfig['last_backup']+$backupconfig['time_backup']) <= $now) {
				$UPDATECONF = "UPDATE {$serendipity['dbPrefix']}dma_htmlbackup SET ";
				$UPDATECONF .= "		last_backup='".$now."' ";
				$backupconfig['last_backup'] = $now;
				serendipity_db_query($UPDATECONF);

				$this->MakeHTMLBackup($dir_to_backup, $exclude);
			}
		}
		return true;
	}


    function getTar() {
		if (@include_once(dirname(__FILE__)."/bundled-libs/Tar.php")) {
	        return true;
		}

		if (@include_once("Tar.php")) {
	        return true;
		}

		if (@include_once("/bundled-libs/Tar.php")) {
	        return true;
		}

		if (@include_once(S9Y_INCLUDE_PATH . "/bundled-libs/Tar.php")) {
	        return true;
		}
    }


	function CheckAutoSQLBackup() {
		global $serendipity;
		$BACKUPDIR = $this->get_config('abspath_backupdir');
		$TEMPDIR = $BACKUPDIR."/tmp";
		$ARCHIVDIR = $BACKUPDIR;
		if (!file_exists($BACKUPDIR)) {
			@mkdir($BACKUPDIR, 0777);
			@chmod($BACKUPDIR, 0777);
		}
		if (!file_exists($BACKUPDIR."/tmp")) {
			@mkdir($BACKUPDIR."/tmp", 0777);
			@chmod($BACKUPDIR."/tmp", 0777);
		}
		if (!file_exists($BACKUPDIR."/tmp/last_backup")) {
			@mkdir($BACKUPDIR."/tmp/last_backup", 0777);
			@chmod($BACKUPDIR."/tmp/last_backup", 0777);
		}
		$retconf = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}dma_sqlbackup");
		foreach ($retconf[0] as $key => $val) {
			$backupconfig[$key] = stripslashes(trim($val));
		}
		$backupdata_array = explode("|^|", $backupconfig['data_backup']);
		$complete = intval($backupdata_array[0]);
		$tables = unserialize($backupdata_array[1]);
		$data = $backupdata_array[2];
		$drop = intval($backupdata_array[3]);
		$pack = intval($backupdata_array[4]);
		if ($backupconfig['auto_backup'] == 1) {
			$now = time();
			@ignore_user_abort(1);
			@set_time_limit(0);
			if (($backupconfig['last_backup']+$backupconfig['time_backup']) <= $now) {
				if ($backupconfig['data_backup'] != "") {
					$UPDATECONF = "UPDATE {$serendipity['dbPrefix']}dma_sqlbackup SET ";
					$UPDATECONF .= "		last_backup='".$now."' ";
					$backupconfig['last_backup'] = $now;
					serendipity_db_query($UPDATECONF);
					$DATA_BACKUP = explode("|^|", $backupconfig['data_backup']);
					$complete = $DATA_BACKUP[0];
					$tables = unserialize(stripslashes($DATA_BACKUP[1]));
					$data = $DATA_BACKUP[2];
					$drop = $DATA_BACKUP[3];
					$pack = $DATA_BACKUP[4];
					if (isset($complete) && $complete == 1) {
						$this->MakeSQLBackup(1,NULL, $data, $drop);
					} else {
						$this->MakeSQLBackup(0, $tables, $data, $drop);
					}
					if ($pack == 1) {
						$archiv = "../".date("Y-m-d-H-i",time())."_sqlbackup.tar.gz";
						chdir($TEMPDIR);
						if (file_exists($archiv)) {
							unlink($archiv);
						}

						$this->getTar();
						$tar_object = new Archive_Tar($archiv, "gz");
						$tar_object->setErrorHandling(PEAR_ERROR_RETURN);
						$filelist[0]="./last_backup";
						$tar_object->create($filelist);
						chmod($archiv, 0666);
						chdir($serendipity['serendipityPath']);
					} else {
						$archiv = "../".date("Y-m-d-H-i",time())."__sqlbackup.tar";
						chdir($TEMPDIR);
						if (file_exists($archiv)) {
							unlink($archiv);
						}
						$this->getTar();
						$tar_object = new Archive_Tar($archiv, FALSE);
						$tar_object->setErrorHandling(PEAR_ERROR_RETURN);
						$filelist[0]="./last_backup";
						$tar_object->create($filelist);
						chmod($archiv, 0666);
						chdir($serendipity['serendipityPath']);
					}
					$fe = opendir($TEMPDIR."/last_backup");
					while ($file = readdir($fe)) {
						if ($file != "." && $file != ".." && $file != "index.php" && $file != "cvs" && $file != "CVS") {
							unlink($TEMPDIR."/last_backup/".$file);
						}
					}
					closedir($fe);
				} else {
					return false;
				}
			}
		}
		return true;
	}


	function CheckAutoDelHTMLBackup() {
		global $serendipity;
		$BACKUPDIR = $this->get_config('abspath_backupdir');
		$backupdir = $BACKUPDIR;
		if (!file_exists($BACKUPDIR)) {
			@mkdir($BACKUPDIR, 0777);
			@chmod($BACKUPDIR, 0777);
		}
		$retconf = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}dma_htmlbackup");
		foreach ($retconf[0] as $key => $val) {
			$backupconfig[$key] = stripslashes(trim($val));
		}
		$backupdata_array = explode("|^|", $backupconfig['data_backup']);
		$dir_to_backup = trim($backupdata_array[0]);
		if (substr($dir_to_backup,  strlen($dir_to_backup)-1, strlen($dir_to_backup)) == "/") {
			$dir_to_backup = substr($dir_to_backup,  0, strlen($dir_to_backup)-1);
		}
		$exclude = unserialize(trim($backupdata_array[1]));

		if ($backupconfig['auto_backdel'] == 1) {
			@ignore_user_abort(1);
			@set_time_limit(0);
			$now = time();
			$fe = opendir($backupdir);
			while ($file = readdir($fe)) {
				if (preg_match("@htmlbackup@", $file)) {
					if (filemtime($backupdir."/".$file) <= ($now - $backupconfig['time_backdel'])) {
						unlink($backupdir."/".$file);
					}
				}
			}
			closedir($fe);
		}
		return true;
	}


	function CheckAutoDelSQLBackup() {
		global $serendipity;
		$BACKUPDIR = $this->get_config('abspath_backupdir');
		$backupdir = $BACKUPDIR;
		if (!file_exists($BACKUPDIR)) {
			@mkdir($BACKUPDIR, 0777);
			@chmod($BACKUPDIR, 0777);
		}
		if (!file_exists($BACKUPDIR."/tmp")) {
			@mkdir($BACKUPDIR."/tmp", 0777);
			@chmod($BACKUPDIR."/tmp", 0777);
		}
		if (!file_exists($BACKUPDIR."/tmp/last_backup")) {
			@mkdir($BACKUPDIR."/tmp/last_backup", 0777);
			@chmod($BACKUPDIR."/tmp/last_backup", 0777);
		}
		$retconf = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}dma_sqlbackup");
		foreach ($retconf[0] as $key => $val) {
			$backupconfig[$key] = stripslashes(trim($val));
		}
		$backupdata_array = explode("|^|", $backupconfig['data_backup']);
		$complete = intval($backupdata_array[0]);
		$tables = unserialize($backupdata_array[1]);
		$data = $backupdata_array[2];
		$drop = intval($backupdata_array[3]);
		$pack = intval($backupdata_array[4]);
		if ($backupconfig['auto_backdel'] == 1) {
			@ignore_user_abort(1);
			@set_time_limit(0);
			$now = time();
			$fe = opendir($backupdir);
			while ($file = readdir($fe)) {
				if (preg_match("@sqlbackup@", $file)) {
					if (filemtime($backupdir."/".$file) <= ($now - $backupconfig['time_backdel'])) {
						unlink($backupdir."/".$file);
					}
				}
			}
			closedir($fe);
		}
		return true;
	}


	function RecoverSQLBackup($backupfile)
		{
		global $serendipity;
		$BACKUPDIR = $this->get_config('abspath_backupdir');
		$backupdir = $BACKUPDIR;
		$pbackupfile = $BACKUPDIR."/".basename($backupfile);
		$recoverdir = $BACKUPDIR."/tmp/last_backup";
		if (!file_exists($BACKUPDIR)) {
			@mkdir($BACKUPDIR, 0777);
			@chmod($BACKUPDIR, 0777);
		}
		if (!file_exists($BACKUPDIR."/tmp")) {
			@mkdir($BACKUPDIR."/tmp", 0777);
			@chmod($BACKUPDIR."/tmp", 0777);
		}
		if (!file_exists($BACKUPDIR."/tmp/last_backup")) {
			@mkdir($BACKUPDIR."/tmp/last_backup", 0777);
			@chmod($BACKUPDIR."/tmp/last_backup", 0777);
		}
		$retconf = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}dma_sqlbackup");
		foreach ($retconf[0] as $key => $val) {
			$backupconfig[$key] = stripslashes(trim($val));
		}
		$backupdata_array = explode("|^|", $backupconfig['data_backup']);
		$complete = intval($backupdata_array[0]);
		$tables = unserialize($backupdata_array[1]);
		$data = $backupdata_array[2];
		$drop = intval($backupdata_array[3]);
		$pack = intval($backupdata_array[4]);
		if (!file_exists($pbackupfile)) {
			return PLUGIN_BACKUP_NOT_FOUND;
		}
		$this->getTar();
		if (preg_match("@.gz$@", $backupfile)) { $zipped = TRUE; } else { $zipped = FALSE; }
		$tar_object = new Archive_Tar($pbackupfile, $zipped);
		$tar_object->setErrorHandling(PEAR_ERROR_RETURN);
		$tar_object->extract($backupdir."/tmp");
		$fe = opendir($recoverdir);
		chdir($recoverdir);
		while ($file = readdir($fe))
			{
			if (ereg("_CREATE_", $file))
				{
				unset($rec);
				$drop = "";
				$create = "";
				$rec = file($file);
				for ($a=0;$a<count($rec);$a++)
					{
					if (!ereg("^##", $rec[$a]))
						{
						if (ereg("DROP TABLE", $rec[$a]))
							{
							$drop .= $rec[$a];
							}
						else
							{
							$create .= $rec[$a];
							}
						}
					}
				if (trim($drop) != "")
					{
					serendipity_db_query(preg_replace("|(`;([\ \\r\\n]{0,})$)|","`",$drop));
					#print("<pre>".preg_replace("|(`;([\ \\r\\n]{0,})$)|","`",$drop)."</pre>");
					}
				serendipity_db_query(preg_replace("|(\)([\ (TYPE=MyISAM)]{0,});([\ \\r\\n]{0,})$)|",")",$create));
				#print("<pre>".preg_replace("|(\)([\ (TYPE=MyISAM)]{0,});([\ \\r\\n]{0,})$)|",")",$create)."</pre>");
				}
			}
		chdir("../../../");
		closedir($fe);
		$fe = opendir($recoverdir);
		chdir($recoverdir);
		while ($file = readdir($fe))
			{
			if (ereg("_INSERT_", $file))
				{
				unset($rec);
				$insert = "";
				$fop = fopen($file, "r");
				$rec = fread($fop, filesize($file));
				fclose($fop);
				$insert = explode("\nINSERT INTO", $rec);
				for ($blu=0;$blu<count($insert);$blu++)
					{
					if ($blu >= 1)
						{
						serendipity_db_query("INSERT INTO".preg_replace("|(\);([\ \\r\\n]{0,})$)|",")",$insert[$blu]));
						#print("<pre>INSERT INTO".preg_replace("|(\);([\ \\r\\n]{0,})$)|",")",$insert[$blu])."</pre>");
						}
					}
				}
			}
		chdir("../../../");
		closedir($fe);
		$fe = opendir($recoverdir);
		while ($file = readdir($fe))
			{
			if ($file != "." && $file != ".." && $file != "index.".$_SESSION['SUFFIX'] && $file != "cvs" && $file != "CVS")
				{
				unlink($recoverdir."/".$file);
				}
			}
		closedir($fe);
		return PLUGIN_BACKUP_SQL_RECOVERED;
		}


	function backup_interface() {
		global $serendipity;
		$BACKUPDIR = $this->get_config('abspath_backupdir');
		$TEMPDIR = $BACKUPDIR."/tmp";
		$ARCHIVDIR = $BACKUPDIR;


        $TITLE  = "";
        $TITLE .= "<h2>" . PLUGIN_BACKUP_TITLE . "</h2>\n";
        $TITLE .= "<span class='msg_notice'><span class='icon-info-circled'></span>" . PLUGIN_BACKUP_DESC . "</span>\n";

		if (!file_exists($BACKUPDIR)) {
			@mkdir($BACKUPDIR, 0777);
			@chmod($BACKUPDIR, 0777);
		}
		if (!file_exists($BACKUPDIR."/tmp")) {
			@mkdir($BACKUPDIR."/tmp", 0777);
			@chmod($BACKUPDIR."/tmp", 0777);
		}
		if (!file_exists($BACKUPDIR."/tmp/last_backup")) {
			@mkdir($BACKUPDIR."/tmp/last_backup", 0777);
			@chmod($BACKUPDIR."/tmp/last_backup", 0777);
		}

		if (isset($serendipity['POST']['action']) && $serendipity['POST']['action'] == "makesqlbackup") {
			$STATUSMSG = '';
			unset($UPDATECONF);
			if (!isset($serendipity['POST']['complete']) || $serendipity['POST']['complete'] != 1){$serendipity['POST']['complete'] = 0;}
			if (!isset($serendipity['POST']['drop']) || $serendipity['POST']['drop'] != 1){$serendipity['POST']['drop'] = 0;}
			if (!isset($serendipity['POST']['pack']) || $serendipity['POST']['pack'] != 1){$serendipity['POST']['pack'] = 0;}
			$DATA_BACKUP = $serendipity['POST']['complete'];
			$DATA_BACKUP .= "|^|";
			$DATA_BACKUP .= (isset($serendipity['POST']['complete'])&&$serendipity['POST']['complete']==1?serialize(array()):serialize($serendipity['POST']['tables']));
			$DATA_BACKUP .= "|^|";
			$DATA_BACKUP .= $serendipity['POST']['data'];
			$DATA_BACKUP .= "|^|";
			$DATA_BACKUP .= $serendipity['POST']['drop'];
			$DATA_BACKUP .= "|^|";
			$DATA_BACKUP .= $serendipity['POST']['pack'];
			if (!isset($serendipity['POST']['delete']) && isset($serendipity['POST']['bakautomatik']) && $serendipity['POST']['bakautomatik'] == 1) {
				$UPDATECONF = "UPDATE {$serendipity['dbPrefix']}dma_sqlbackup SET ";
				$UPDATECONF .= "		auto_backup='1', ";
				$UPDATECONF .= "		time_backup='".$serendipity['POST']['interval']."', ";
				$UPDATECONF .= "		last_backup='".time()."', ";
				$UPDATECONF .= "		data_backup='".addslashes($DATA_BACKUP)."' ";
				$STATUSMSG .= "<span class='msg_notice'><span class='icon-info-circled'></span>" . PLUGIN_BACKUP_AUTO_SQL_BACKUP_STARTED . '</span>';
			} elseif (!isset($serendipity['POST']['delete']) && (count($serendipity['POST']) >= 1 && !isset($serendipity['POST']['bakautomatik']))) {
				$UPDATECONF = "UPDATE {$serendipity['dbPrefix']}dma_sqlbackup SET ";
				$UPDATECONF .= "		auto_backup='0', ";
				$UPDATECONF .= "		time_backup='0', ";
				$UPDATECONF .= "		last_backup='0', ";
				$UPDATECONF .= "		data_backup='".addslashes($DATA_BACKUP)."' ";
				$STATUSMSG .= "<span class='msg_notice'><span class='icon-info-circled'></span>" . PLUGIN_BACKUP_AUTO_SQL_BACKUP_STOPPED . '</span>';
			}
			if (isset($UPDATECONF)) {
				serendipity_db_query($UPDATECONF);
			}
			unset($UPDATECONF);
			if (!isset($serendipity['POST']['delete']) && isset($serendipity['POST']['delautomatik']) && $serendipity['POST']['delautomatik'] == 1) {
				$UPDATECONF = "UPDATE {$serendipity['dbPrefix']}dma_sqlbackup SET ";
				$UPDATECONF .= "		auto_backdel='1', ";
				$UPDATECONF .= "		time_backdel='".$serendipity['POST']['delage']."', ";
				$UPDATECONF .= "		last_backdel='".time()."' ";
				$STATUSMSG .= "<span class='msg_notice'><span class='icon-info-circled'></span>" . PLUGIN_BACKUP_AUTO_SQL_DELETE_STARTED . '</span>';
			} elseif (!isset($serendipity['POST']['delete']) && (count($serendipity['POST']) >= 1 && !isset($serendipity['POST']['delautomatik']))) {
				$UPDATECONF = "UPDATE {$serendipity['dbPrefix']}dma_sqlbackup SET ";
				$UPDATECONF .= "		auto_backdel='0', ";
				$UPDATECONF .= "		time_backdel='0', ";
				$UPDATECONF .= "		last_backdel='0' ";
				$STATUSMSG .= "<span class='msg_notice'><span class='icon-info-circled'></span>" . PLUGIN_BACKUP_AUTO_SQL_DELETE_STOPPED . '</span>';
			}
			if (isset($UPDATECONF)) {
				serendipity_db_query($UPDATECONF);
			}
			if (isset($serendipity['POST']['backup']) && $serendipity['POST']['backup'] == 1) {
				if (isset($serendipity['POST']['complete']) && $serendipity['POST']['complete'] == 1) {
					$this->MakeSQLBackup(1,NULL, $serendipity['POST']['data'], $serendipity['POST']['drop']);
				} else {
					$this->MakeSQLBackup(0, $serendipity['POST']['tables'], $serendipity['POST']['data'], $serendipity['POST']['drop']);
				}
				if ($serendipity['POST']['pack'] == 1) {
					$archiv = "../".date("Y-m-d-H-i",time())."_sqlbackup.tar.gz";
					chdir($TEMPDIR);
					if (file_exists($archiv)) {
						unlink($archiv);
					}
					$this->getTar();
					$tar_object = new Archive_Tar($archiv, "gz");
					$tar_object->setErrorHandling(PEAR_ERROR_RETURN);
					$filelist[0]="./last_backup";
					$tar_object->create($filelist);
					chmod($archiv, 0666);
					chdir($serendipity['serendipityPath']);
				} else {
					$archiv = "../".date("Y-m-d-H-i",time())."_sqlbackup.tar";
					chdir($TEMPDIR);
					if (file_exists($archiv)) {
						unlink($archiv);
					}
					$this->getTar();
					$tar_object = new Archive_Tar($archiv, FALSE);
					$tar_object->setErrorHandling(PEAR_ERROR_RETURN);
					$filelist[0]="./last_backup";
					$tar_object->create($filelist);
					chmod($archiv, 0666);
					chdir($serendipity['serendipityPath']);
				}
				$fe = opendir($TEMPDIR."/last_backup");
				while ($file = readdir($fe)) {
					if ($file != "." && $file != ".." && $file != "index.php" && $file != "cvs" && $file != "CVS") {
						unlink($TEMPDIR."/last_backup/".$file);
					}
				}
				closedir($fe);
				$STATUSMSG .= "<span class='msg_success'><span class='icon-ok-circled'></span>" . PLUGIN_BACKUP_SQL_SAVED . '</span>';
			}
		}

		if (isset($serendipity['POST']['action']) && $serendipity['POST']['action'] == "makehtmlbackup") {
			$STATUSMSG = '';
			unset($UPDATECONF);
			if (!isset($serendipity['POST']['complete']) || $serendipity['POST']['complete'] != 1){$serendipity['POST']['complete'] = 0;}
			$DATA_BACKUP = $serendipity['serendipityPath'];
			$DATA_BACKUP .= "|^|";

			$s9ypath = trim($serendipity['serendipityPath']);
			$s9ydir = preg_replace("`^.*\/([^\/]*)\/$`", "\\1", $s9ypath);
			if (substr($s9ypath,  strlen($s9ypath)-1, strlen($s9ypath)) == "/") {
				$s9ypath = substr($s9ypath,  0, strlen($s9ypath)-1);
			}

			$dirs_to_exclude = array();
			$fd = opendir($s9ypath);
			while ($dir = readdir($fd)) {
				if (is_dir($dir) && $dir != "." && $dir != "..") {
					if (is_array($serendipity['POST']['dirs']) && !in_array($dir, $serendipity['POST']['dirs'])) {
						$dirs_to_exclude[] = $dir;
					}
				}
			}
			closedir($fd);
			$DATA_BACKUP .= (isset($serendipity['POST']['complete'])&&$serendipity['POST']['complete']==1?serialize(array()):serialize($dirs_to_exclude));

			if (!isset($serendipity['POST']['delete']) && isset($serendipity['POST']['bakautomatik']) && $serendipity['POST']['bakautomatik'] == 1) {
				$UPDATECONF = "UPDATE {$serendipity['dbPrefix']}dma_htmlbackup SET ";
				$UPDATECONF .= "		auto_backup='1', ";
				$UPDATECONF .= "		time_backup='".$serendipity['POST']['interval']."', ";
				$UPDATECONF .= "		last_backup='".time()."', ";
				$UPDATECONF .= "		data_backup='".addslashes($DATA_BACKUP)."' ";
				$STATUSMSG .= "<span class='msg_notice'><span class='icon-info-circled'></span>" . PLUGIN_BACKUP_AUTO_HTML_BACKUP_STARTED . '</span>';
			} elseif (!isset($serendipity['POST']['delete']) && (count($serendipity['POST']) >= 1 && !isset($serendipity['POST']['bakautomatik']))) {
				$UPDATECONF = "UPDATE {$serendipity['dbPrefix']}dma_htmlbackup SET ";
				$UPDATECONF .= "		auto_backup='0', ";
				$UPDATECONF .= "		time_backup='0', ";
				$UPDATECONF .= "		last_backup='0', ";
				$UPDATECONF .= "		data_backup='".addslashes($DATA_BACKUP)."' ";
				$STATUSMSG .= "<span class='msg_notice'><span class='icon-info-circled'></span>" . PLUGIN_BACKUP_AUTO_HTML_BACKUP_STOPPED . '</span>';
			}
			if (isset($UPDATECONF)) {
				serendipity_db_query($UPDATECONF);
			}
			unset($UPDATECONF);
			if (!isset($serendipity['POST']['delete']) && isset($serendipity['POST']['delautomatik']) && $serendipity['POST']['delautomatik'] == 1) {
				$UPDATECONF = "UPDATE {$serendipity['dbPrefix']}dma_htmlbackup SET ";
				$UPDATECONF .= "		auto_backdel='1', ";
				$UPDATECONF .= "		time_backdel='".$serendipity['POST']['delage']."', ";
				$UPDATECONF .= "		last_backdel='".time()."' ";
				$STATUSMSG .= "<span class='msg_notice'><span class='icon-info-circled'></span>" . PLUGIN_BACKUP_AUTO_HTML_DELETE_STARTED . '</span>';
			} elseif (!isset($serendipity['POST']['delete']) && (count($serendipity['POST']) >= 1 && !isset($serendipity['POST']['delautomatik']))) {
				$UPDATECONF = "UPDATE {$serendipity['dbPrefix']}dma_htmlbackup SET ";
				$UPDATECONF .= "		auto_backdel='0', ";
				$UPDATECONF .= "		time_backdel='0', ";
				$UPDATECONF .= "		last_backdel='0' ";
				$STATUSMSG .= "<span class='msg_notice'><span class='icon-info-circled'></span>" . PLUGIN_BACKUP_AUTO_HTML_DELETE_STOPPED . '</span>';
			}
			if (isset($UPDATECONF)) {
				serendipity_db_query($UPDATECONF);
			}
			if (isset($serendipity['POST']['backup']) && $serendipity['POST']['backup'] == 1) {
				if (isset($serendipity['POST']['complete']) && $serendipity['POST']['complete'] == 1) {
					$this->MakeHTMLBackup($s9ypath);
				} else {
					$this->MakeHTMLBackup($s9ypath, $dirs_to_exclude);
				}
				$STATUSMSG .= "<span class='msg_success'><span class='icon-ok-circled'></span>" . PLUGIN_BACKUP_HTML_SAVED . '</span>';
			}
		}

		if (isset($serendipity['POST']['del']) and count($serendipity['POST']['del']) >= 1) {
			for ($a=0;$a<count($serendipity['POST']['del']);$a++) {
				unlink($ARCHIVDIR."/".basename($serendipity['POST']['del'][$a]));
			}
		}

		if (isset($_GET['recover']) && isset($_GET['backup']) && $_GET['recover'] == 1 && trim($_GET['backup']) != "") {
			$STATUSMSG .= $this->RecoverSQLBackup($_GET['backup']);
		} elseif (isset($_GET['download']) && isset($_GET['backup']) && $_GET['download'] == 1 && trim($_GET['backup']) != "") {
			$file = $BACKUPDIR."/".basename($_GET['backup']);
			$fp = fopen($file,"r");
			if (preg_match("@.gz$@", $_GET['backup'])) {
				header("Content-Type: application/x-gzip-compressed");
			} elseif (preg_match("@.tar$@", $_GET['backup'])) {
				header("Content-Type: application/x-tar-compressed");
			}
			header("Content-Transfer-Encoding: Binary");
			header("Content-length: ".filesize($BACKUPDIR."/".$_GET['backup']));
			header("Content-disposition: attachment; filename=".basename($_GET['backup']));
			while (!feof($fp)) {
				$buff = fread($fp,4096);
				print $buff;
			}
		}

		$retconfs = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}dma_sqlbackup");
		foreach ($retconfs[0] as $key => $val) {
			$backupconfig[$key] = stripslashes(trim($val));
		}
		$backupdatas_array = explode("|^|", $backupconfig['data_backup']);
		$complete = intval($backupdatas_array[0]);
		$tables = unserialize($backupdatas_array[1]);
		$data = $backupdatas_array[2];
		$drop = intval($backupdatas_array[3]);
		$pack = intval($backupdatas_array[4]);

		$BACKUPFORM  = "<h3>".PLUGIN_BACKUP_SQL_BACKUP."</h3>\n";
		$BACKUPFORM .= '<div class="serendipity_backup_form">';
		$BACKUPFORM .= '<form name="NewBackupForm" action="?" method="POST">';
		$BACKUPFORM .= '<input type="hidden" name="serendipity[c]" value="backup">
						<input type="hidden" name="serendipity[action]" value="makesqlbackup">
						<input type="hidden" name="serendipity[backup]" value="1">';
		$BACKUPFORM .= "<input type=\"hidden\" name=\"serendipity[adminModule]\" value=\"event_display\">\n";
		$BACKUPFORM .= "<input type=\"hidden\" name=\"serendipity[adminAction]\" value=\"backup\">\n";
		$BACKUPFORM .= '<div class="form_multiselect"><label for="serendipity_tables">' . PLUGIN_BACKUP_LABEL_TABLES . '</label><select id="serendipity_tables" name="serendipity[tables][]" size="10" multiple>';
		$QUERY = serendipity_db_query("SHOW TABLES");
		$co = 0;
		foreach ($QUERY AS $THISTABLE) {
			if (count($tables) >= 1) {
				if (@in_array($THISTABLE[0], $tables)) {
					$BACKUPFORM .= '<option value="'.$THISTABLE[0].'" selected>'.$THISTABLE[0].'</option>';
				} else {
					$BACKUPFORM .= '<option value="'.$THISTABLE[0].'">'.$THISTABLE[0].'</option>';
				}
			} else {
				$BACKUPFORM .= '<option value="'.$THISTABLE[0].'"';
				if ($co==0) { $BACKUPFORM .= ' selected'; }
				$BACKUPFORM .= '>'.$THISTABLE[0].'</option>';
			}
			$co++;
		}
		$BACKUPFORM .= '</select></div>';
		$BACKUPFORM .= '<div class="form_select">
                            <label for="serendipity_data">' . PLUGIN_BACKUP_LABEL_DATA . '</label>
							<select id="serendipity_data" name="serendipity[data]">
								<option value="0"> --- '.PLUGIN_BACKUP_PLEASE_CHOOSE.' --- </option>';
		if (isset($data) && $data == "data") {
			$BACKUPFORM .= '		<option value="data" selected>'.PLUGIN_BACKUP_STRUCT_AND_DATA.'</option>';
			$BACKUPFORM .= '		<option value="structure">'.PLUGIN_BACKUP_ONLY_STRUCT.'</option>';
			$BACKUPFORM .= '		<option value="dataonly">'.PLUGIN_BACKUP_ONLY_DATA.'</option>';
		} elseif (isset($data) && $data == "structure") {
			$BACKUPFORM .= '		<option value="data">'.PLUGIN_BACKUP_STRUCT_AND_DATA.'</option>';
			$BACKUPFORM .= '		<option value="structure" selected>'.PLUGIN_BACKUP_ONLY_STRUCT.'</option>';
			$BACKUPFORM .= '		<option value="dataonly">'.PLUGIN_BACKUP_ONLY_DATA.'</option>';
		} elseif (isset($data) && $data == "dataonly") {
			$BACKUPFORM .= '		<option value="data">'.PLUGIN_BACKUP_STRUCT_AND_DATA.'</option>';
			$BACKUPFORM .= '		<option value="structure">'.PLUGIN_BACKUP_ONLY_STRUCT.'</option>';
			$BACKUPFORM .= '		<option value="dataonly" selected>'.PLUGIN_BACKUP_ONLY_DATA.'</option>';
		} else {
			$BACKUPFORM .= '		<option value="data" selected>'.PLUGIN_BACKUP_STRUCT_AND_DATA.'</option>';
			$BACKUPFORM .= '		<option value="structure">'.PLUGIN_BACKUP_ONLY_STRUCT.'</option>';
			$BACKUPFORM .= '		<option value="dataonly">'.PLUGIN_BACKUP_ONLY_DATA.'</option>';
		}
		$BACKUPFORM .= '	</select></div>';
		if (isset($drop) && $drop == 1) {
            $BACKUPFORM .= '<div class="form_check"><input id="serendipity_drop_table" type="checkbox" name="serendipity[drop]" value="1" checked><label for="serendipity_drop_table">' . PLUGIN_BACKUP_WITH_DROP_TABLE . '</label></div>';
        } elseif (isset($drop) && $drop == "0") {
            $BACKUPFORM .= '<div class="form_check"><input id="serendipity_drop_table" type="checkbox" name="serendipity[drop]" value="1"><label for="serendipity_drop_table">' . PLUGIN_BACKUP_WITH_DROP_TABLE . '</label></div>';
        } elseif (!isset($drop)) {
            $BACKUPFORM .= '<div class="form_check"><input id="serendipity_drop_table" type="checkbox" name="serendipity[drop]" value="1" checked><label for="serendipity_drop_table">' . PLUGIN_BACKUP_WITH_DROP_TABLE . '</label></div>';
        }
		if (isset($pack) && $pack == 1) {
            $BACKUPFORM .= '<div class="form_check"><input id="serendipity_pack_backup" type="checkbox" name="serendipity[pack]" value="1" checked><label for="serendipity_pack_backup">' . PLUGIN_BACKUP_ZIPPED . '</label></div>';
        } elseif (isset($pack) && $pack == "0") {
            $BACKUPFORM .= '<div class="form_check"><input id="serendipity_pack_backup" type="checkbox" name="serendipity[pack]" value="1"><label for="serendipity_pack_backup">' . PLUGIN_BACKUP_ZIPPED . '</label></div>';
        } elseif (!isset($pack)) {
            $BACKUPFORM .= '<div class="form_check"><input id="serendipity_pack_backup" type="checkbox" name="serendipity[pack]" value="1" checked><label for="serendipity_pack_backup">' . PLUGIN_BACKUP_ZIPPED . '</label></div>';
        }
		if (isset($complete) && $complete == 1) {
            $BACKUPFORM .= '<div class="form_check"><input id="serendipity_complete_db" type="checkbox" name="serendipity[complete]" value="1" checked><label for="serendipity_complete_db">' . PLUGIN_BACKUP_WHOLE_DATABASE . '</label></div>';
        } elseif (isset($complete) && $complete == "0") {
            $BACKUPFORM .= '<div class="form_check"><input id="serendipity_complete_db" type="checkbox" name="serendipity[complete]" value="1"><label for="serendipity_complete_db">' . PLUGIN_BACKUP_WHOLE_DATABASE . '</label></div>';
        } elseif (!isset($complete)) {
            $BACKUPFORM .= '<div class="form_check"><input id="serendipity_complete_db" type="checkbox" name="serendipity[complete]" value="1"><label for="serendipity_complete_db">' . PLUGIN_BACKUP_WHOLE_DATABASE . '</label></div>';
        }
		if ($backupconfig['auto_backup'] == 1) {
            $C_automatik = ' checked';
        } else {
            $C_automatik = '';
        }
		if ($backupconfig['auto_backdel'] == 1) {
            $C_delmatik = ' checked';
        } else {
            $C_delmatik = '';
        }
		$BAKAUTO['TIME'] = array(600,3600,7200,21600,43200,86400,172800,345600,604800,1209600,2419200);
		$BAKAUTO['TEXT'] = array('10 '.PLUGIN_BACKUP_MINUTES, PLUGIN_BACKUP_EVERY.' '.PLUGIN_BACKUP_HOUR,PLUGIN_BACKUP_EVERY.' 2 '.PLUGIN_BACKUP_HOURS,PLUGIN_BACKUP_EVERY.' 6 '.PLUGIN_BACKUP_HOURS,PLUGIN_BACKUP_EVERY.' 12 '.PLUGIN_BACKUP_HOURS,PLUGIN_BACKUP_EVERY.' 24 '.PLUGIN_BACKUP_HOURS,PLUGIN_BACKUP_EVERY.' 2 '.PLUGIN_BACKUP_DAYS,PLUGIN_BACKUP_EVERY.' 4 '.PLUGIN_BACKUP_DAYS,PLUGIN_BACKUP_EVERY.' 7 '.PLUGIN_BACKUP_DAYS,PLUGIN_BACKUP_EVERY.' 2 '.PLUGIN_BACKUP_WEEKS,PLUGIN_BACKUP_EVERY.' 4 '.PLUGIN_BACKUP_WEEKS);
		$DELAUTO['TIME'] = array(43200,86400,172800,345600,604800,1209600,2419200,4838400,14515200);
		$DELAUTO['TEXT'] = array('12 '.PLUGIN_BACKUP_HOURS,' 24 '.PLUGIN_BACKUP_HOURS,'2 '.PLUGIN_BACKUP_DAYS,'4 '.PLUGIN_BACKUP_DAYS,'7 '.PLUGIN_BACKUP_DAYS,'2 '.PLUGIN_BACKUP_WEEKS,'4 '.PLUGIN_BACKUP_WEEKS,'2 '.PLUGIN_BACKUP_MONTHS,'6 '.PLUGIN_BACKUP_MONTHS);
		$BACKUPFORM .= '<fieldset>
							<span class="wrap_legend"><legend>' . PLUGIN_BACKUP_AUTO_BACKUP . '</legend></span>
                            <div class="form_check">
								<input id="serendipity_bakautomatik" type="checkbox" name="serendipity[bakautomatik]" value="1"' . $C_automatik . '><label for="serendipity_bakautomatik">' . PLUGIN_BACKUP_ACTIVATE_AUTO_BACKUP . '</label>
							</div>
							<div class="form_select">
								<label for="serendipity_interval">' . PLUGIN_BACKUP_TIME_BET_BACKUPS . '</label>
								<select id="serendipity_interval" name="serendipity[interval]">';
		for ($BA=0;$BA<count($BAKAUTO['TIME']);$BA++) {
			if ($backupconfig['time_backup'] >= 1) {
				if ($BAKAUTO['TIME'][$BA] == $backupconfig['time_backup']) {
					$BACKUPFORM .= 				'<option value="'.$BAKAUTO['TIME'][$BA].'" selected>'.$BAKAUTO['TEXT'][$BA].'</option>';
				} else {
					$BACKUPFORM .= 				'<option value="'.$BAKAUTO['TIME'][$BA].'">'.$BAKAUTO['TEXT'][$BA].'</option>';
				}
			} else {
				if ($BA==3) {
					$BACKUPFORM .= 				'<option value="'.$BAKAUTO['TIME'][$BA].'" selected>'.$BAKAUTO['TEXT'][$BA].'</option>';
				} else {
					$BACKUPFORM .= 				'<option value="'.$BAKAUTO['TIME'][$BA].'">'.$BAKAUTO['TEXT'][$BA].'</option>';
				}
			}
		}
		$BACKUPFORM .= '</select></div></fieldset>';
        $BACKUPFORM .= '<fieldset>
							<span class="wrap_legend"><legend>' . PLUGIN_BACKUP_DEL_OLD_BACKUPS . '</legend><span>
                            <div class="form_check">
								<input id="serendipity_delautomatik" type="checkbox" name="serendipity[delautomatik]" value="1"' . $C_delmatik . '><label for="serendipity_delautomatik">' . PLUGIN_BACKUP_ACTIVATE_AUTO_DELETE . '</label>
							</div>
							<div class="form_select">
								<label for="serendipity_delage">' . PLUGIN_BACKUP_OLDER_THAN . '...' . PLUGIN_BACKUP_WILL_BE_DELETED . '</label>
								<select id="serendipity_delage" name="serendipity[delage]">';
		for ($BA=0;$BA<count($DELAUTO['TIME']);$BA++) {
			if ($backupconfig['time_backdel'] >= 1) {
				if ($DELAUTO['TIME'][$BA] == $backupconfig['time_backdel']) {
					$BACKUPFORM .= 				'<option value="'.$DELAUTO['TIME'][$BA].'" selected>'.$DELAUTO['TEXT'][$BA].'</option>';
				} else {
					$BACKUPFORM .= 				'<option value="'.$DELAUTO['TIME'][$BA].'">'.$DELAUTO['TEXT'][$BA].'</option>';
				}
			} else {
				if ($BA==6) {
					$BACKUPFORM .= 				'<option value="'.$DELAUTO['TIME'][$BA].'" selected>'.$DELAUTO['TEXT'][$BA].'</option>';
				} else {
					$BACKUPFORM .= 				'<option value="'.$DELAUTO['TIME'][$BA].'">'.$DELAUTO['TEXT'][$BA].'</option>';
				}
			}
		}
		$BACKUPFORM .= '</select></div></fieldset>';
        $BACKUPFORM .= '<div class="form_buttons"><input type="submit" name="serendipity[submit]" value="' . PLUGIN_BACKUP_START_BACKUP . '"></div>';
		$BACKUPFORM .= '</form>';
		$BACKUPFORM .= '</div>';
		unset($BACKUPS);

		$retconfh = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}dma_htmlbackup");
		foreach ($retconfh[0] as $key => $val) {
			$htmlbackupconfig[$key] = stripslashes(trim($val));
		}
		$backupdatah_array = explode("|^|", $htmlbackupconfig['data_backup']);
		$dir_to_backup = trim($backupdata_array[0]);
		if (substr($dir_to_backup,  strlen($dir_to_backup)-1, strlen($dir_to_backup)) == "/") {
			$dir_to_backup = substr($dir_to_backup,  0, strlen($dir_to_backup)-1);
		}
		$exclude = unserialize(trim($backupdatah_array[1]));

		$BACKUPFORM .= "<h3>" . PLUGIN_BACKUP_HTML_BACKUP . "</h3>\n";
		$BACKUPFORM .= '<div class="serendipity_backup_form">';
		$BACKUPFORM .= '<form name="NewHBackupForm" action="?" method="POST">';
		$BACKUPFORM .= '<input type="hidden" name="serendipity[c]" value="backup">
						<input type="hidden" name="serendipity[action]" value="makehtmlbackup">
						<input type="hidden" name="serendipity[backup]" value="1">';
		$BACKUPFORM .= "<input type=\"hidden\" name=\"serendipity[adminModule]\" value=\"event_display\">\n";
		$BACKUPFORM .= "<input type=\"hidden\" name=\"serendipity[adminAction]\" value=\"backup\">\n";
		$BACKUPFORM .= '<div class="form_multiselect">
                            <label for="serendipity_dirs">' . PLUGIN_BACKUP_LABEL_DIRS . '</label>
							<select id="serendipity_dirs" name="serendipity[dirs][]" size="10" multiple>';

		$s9ypath = trim($serendipity['serendipityPath']);
		$s9ydir = preg_replace("`^.*\/([^\/]*)\/$`", "\\1", $s9ypath);

		$dirs = array();
		$fd = opendir($s9ypath);
		while ($dir = readdir($fd)) {
			if (is_dir($dir) && $dir != "." && $dir != "..") {
				$dirs[] = $dir;
			}
		}
		closedir($fd);
		unset($dir);

		@reset($dirs);
		asort($dirs);
		@reset($dirs);

		foreach($dirs AS $dir) {
			if (is_array($exclude) && count($exclude) >= 1) {
				if (!in_array($dir, $exclude)) {
					$BACKUPFORM .= '<option value="'.$dir.'" selected>'.$s9ydir."/".$dir.'</option>';
				} else {
					$BACKUPFORM .= '<option value="'.$dir.'">'.$s9ydir."/".$dir.'</option>';
				}
			} else {
				$BACKUPFORM .= '<option value="'.$dir.'"';
				if ($co==0) { $BACKUPFORM .= ' selected'; }
				$BACKUPFORM .= '>'.$s9ydir."/".$dir.'</option>';
			}
			$co++;
		}
		$BACKUPFORM .= '</select></div>';
		$BACKUPFORM .= '<div class="form_check">';
		if (!is_array($exclude) || count($exclude) <= 0) {
            $BACKUPFORM .= '	<input id="serendipity_complete_html" type="checkbox" name="serendipity[complete]" value="1" checked><label for="serendipity_complete_html">' . PLUGIN_BACKUP_WHOLE_BLOG . '</label>';
        } else {
            $BACKUPFORM .= ' <input id="serendipity_complete_html" type="checkbox" name="serendipity[complete]" value="1"><label for="serendipity_complete_html">' . PLUGIN_BACKUP_WHOLE_BLOG . '</label>';
        }
		$BACKUPFORM .= '</div>';
        if ($htmlbackupconfig['auto_backup'] == 1) {
            $C_automatik = ' checked';
        } else {
            $C_automatik = '';
        }
		if ($htmlbackupconfig['auto_backdel'] == 1) {
            $C_delmatik = ' checked';
        } else {
            $C_delmatik = '';
        }
		$BACKUPFORM .= '<fieldset>
							<span class="wrap_legend"><legend>' . PLUGIN_BACKUP_AUTO_BACKUP . '</legend></span>
                            <div class="form_check">
			                     <input id="serendipity_bakautomatik_html" type="checkbox" name="serendipity[bakautomatik]" value="1"' . $C_automatik . '><label for="serendipity_bakautomatik_html">' . PLUGIN_BACKUP_ACTIVATE_AUTO_BACKUP . '</label>
							</div>
							<div class="form_select">
								<label for="serendipity_interval_html">' . PLUGIN_BACKUP_TIME_BET_BACKUPS . '</label>
								<select id="serendipity_interval_html" name="serendipity[interval]">';
		for ($BA=0;$BA<count($BAKAUTO['TIME']);$BA++) {
			if ($htmlbackupconfig['time_backup'] >= 1) {
				if ($BAKAUTO['TIME'][$BA] == $htmlbackupconfig['time_backup']) {
					$BACKUPFORM .= 				'<option value="'.$BAKAUTO['TIME'][$BA].'" selected>'.$BAKAUTO['TEXT'][$BA].'</option>';
				} else {
					$BACKUPFORM .= 				'<option value="'.$BAKAUTO['TIME'][$BA].'">'.$BAKAUTO['TEXT'][$BA].'</option>';
				}
			} else {
				if ($BA==3) {
					$BACKUPFORM .= 				'<option value="'.$BAKAUTO['TIME'][$BA].'" selected>'.$BAKAUTO['TEXT'][$BA].'</option>';
				} else {
					$BACKUPFORM .= 				'<option value="'.$BAKAUTO['TIME'][$BA].'">'.$BAKAUTO['TEXT'][$BA].'</option>';
				}
			}
		}
		$BACKUPFORM .= '		</select></div></fieldset>';
        $BACKUPFORM .= '<fieldset>
							<span class="wrap_legend"><legend>' . PLUGIN_BACKUP_DEL_OLD_BACKUPS . '</legend></span>
                            <div class="form_check">
								<input id="serendipity_delautomatik_html" type="checkbox" name="serendipity[delautomatik]" value="1"' . $C_delmatik . '><label for="serendipity_delautomatik_html">' . PLUGIN_BACKUP_ACTIVATE_AUTO_DELETE . '</label>
							</div>
							<div class="form_select">
								<label for="serendipity_delage_html">' . PLUGIN_BACKUP_OLDER_THAN . '...' . PLUGIN_BACKUP_WILL_BE_DELETED . '</label>
								<select id="serendipity_delage_html" name="serendipity[delage]">';
		for ($BA=0;$BA<count($DELAUTO['TIME']);$BA++) {
			if ($htmlbackupconfig['time_backdel'] >= 1) {
				if ($DELAUTO['TIME'][$BA] == $htmlbackupconfig['time_backdel']) {
					$BACKUPFORM .= 				'<option value="'.$DELAUTO['TIME'][$BA].'" selected>'.$DELAUTO['TEXT'][$BA].'</option>';
				} else {
					$BACKUPFORM .= 				'<option value="'.$DELAUTO['TIME'][$BA].'">'.$DELAUTO['TEXT'][$BA].'</option>';
				}
			} else {
				if ($BA==6) {
					$BACKUPFORM .= 				'<option value="'.$DELAUTO['TIME'][$BA].'" selected>'.$DELAUTO['TEXT'][$BA].'</option>';
				} else {
					$BACKUPFORM .= 				'<option value="'.$DELAUTO['TIME'][$BA].'">'.$DELAUTO['TEXT'][$BA].'</option>';
				}
			}
		}
		$BACKUPFORM .= '</select></div></fieldset>';
		$BACKUPFORM .= '<div class="form_buttons"><input type="submit" name="serendipity[submit]" value="' . PLUGIN_BACKUP_START_BACKUP . '"></div>';
		$BACKUPFORM .= '</form>';
		$BACKUPFORM .= '</div>';
		unset($BACKUPS);

		$bc = 0;
		$fd = opendir($BACKUPDIR);
		while ($backup = readdir($fd)) {
			if (preg_match("@backup@", $backup)) {
				$BACKUPS['NAME'][$bc] = $backup;
				$BACKUPS['FILE'][$bc] = $BACKUPDIR."/".$backup;
				$BACKUPS['TIME'][$bc] = filemtime($BACKUPDIR."/".$backup);
				$BACKUPS['SIZE'][$bc] = filesize($BACKUPDIR."/".$backup);
				$bc++;
			}
		}
		closedir($fd);
		@reset($BACKUPS);
		@array_multisort($BACKUPS['TIME'], SORT_DESC, SORT_NUMERIC, $BACKUPS['NAME'], $BACKUPS['FILE'], $BACKUPS['SIZE']);

		if (count($BACKUPS['NAME']) >= 1) {
            $BACKUPFORM .= '<h3>' . PLUGIN_BACKUP_LABEL_BACKUPS . '</h3>' . "\n";
			$BACKUPFORM .= '<form name="UPForm" action="?" method="POST">'."\n";
			$BACKUPFORM .= '<input type="hidden" name="serendipity[c]" value="backup">
							<input type="hidden" name="serendipity[action]" value="deletesqlbackup">'."\n";
			$BACKUPFORM .= "<input type=\"hidden\" name=\"serendipity[adminModule]\" value=\"event_display\">\n";
			$BACKUPFORM .= "<input type=\"hidden\" name=\"serendipity[adminAction]\" value=\"backup\">\n";
            $BACKUPFORM .= '<div class="serendipity_backups_wrap">'."\n";
            $BACKUPFORM .= '<table class="serendipity_backups">'."\n";
            $BACKUPFORM .= '<thead>'."\n";
			$BACKUPFORM .= '<tr>'."\n";
			$BACKUPFORM .= '<th>' . PLUGIN_BACKUP_FILENAME . '</th>'."\n";
			$BACKUPFORM .= '<th>' . PLUGIN_BACKUP_FILESIZE . '</th>'."\n";
			$BACKUPFORM .= '<th>' . PLUGIN_BACKUP_DATE . '</th>'."\n";
			$BACKUPFORM .= '<th>' . PLUGIN_BACKUP_OPTION . '</th>'."\n";
			$BACKUPFORM .= '</tr>'."\n";
            $BACKUPFORM .= '</thead>'."\n";
            $BACKUPFORM .= '<tbody>'."\n";
			for ($bco=0;$bco<count($BACKUPS['NAME']);$bco++) {
				$BACKUPFORM .= '<tr>'."\n";
				$BACKUPFORM .= '<td><input id="serendipity_del_' . $bco . '" type="checkbox" name="serendipity[del][]" value="' . $BACKUPS['NAME'][$bco] . '"><label for="serendipity_del_' . $bco . '" class="visuallyhidden">' . PLUGIN_BACKUP_DELETE_MARK . '</label> <a href="'.$serendipity['baseURL'] . ($serendipity['rewrite'] == "none" ? $serendipity['indexFile'] . "?/" : "") . 'plugin/dlbackup_' . $BACKUPS['NAME'][$bco] . '">' . $BACKUPS['NAME'][$bco] . '</a></td>'."\n";
				$BACKUPFORM .= '<td>' . $this->calcFilesize($BACKUPS['SIZE'][$bco]) . '</td>'."\n";
				$BACKUPFORM .= '<td>' . date("d.m.Y, H:i",$BACKUPS['TIME'][$bco]) . '</td>'."\n";
				$BACKUPFORM .= '<td>' . "\n";
				if (preg_match("@htmlbackup@", $BACKUPS['NAME'][$bco])) {
                    $BACKUPFORM .= "&nbsp;";
				} else {
					$BACKUPFORM .= "<a title=\"".PLUGIN_BACKUP_RECOVER_THIS."\" href=\"./serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=backup&amp;backup=" . $BACKUPS['NAME'][$bco] . "&amp;recover=1\">" . PLUGIN_BACKUP_RECOVER . "</a>";
				}
				$BACKUPFORM .= '</td>'."\n";
				$BACKUPFORM .= '</tr>'."\n";
			}
			$BACKUPFORM .= '</tbody>' . "\n";
            $BACKUPFORM .= '</table>' . "\n";
            $BACKUPFORM .= '</div>' . "\n";
            $BACKUPFORM .= '<div class="form_buttons"><input type="submit" name="serendipity[delete]" value="' . PLUGIN_BACKUP_DELETE . '"></div>' . "\n";
			$BACKUPFORM .= '</form>' . "\n";
		} else {
			$BACKUPFORM .= "<span class='msg_notice'><span class='icon-info-circled'></span>" . PLUGIN_BACKUP_NO_BACKUPS . "</span>\n";
		}

		echo $TITLE;
		if (isset($STATUSMSG) && trim($STATUSMSG) != "") {
			echo $STATUSMSG;
		}
		echo $BACKUPFORM;
	}


    function generate_content(&$title) {
        $title = PLUGIN_BACKUP_TITLE.' ('.$this->get_config('pageurl').')';
    }


    function install() {
        $this->setupDB();
    }


    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {

                case 'backend_sidebar_entries':
                    if ($serendipity['version'][0] == '1') {
                        if ($serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN && ($serendipity['dbType'] == 'mysql' || $serendipity['dbType'] == 'mysqli')) {
?>
                            <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=backup"><?php echo PLUGIN_BACKUP_TITLE; ?></a></li>
<?php
                        }
                    }
                    break;

                case 'backend_sidebar_admin':
?>
                    <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=backup"><?php echo PLUGIN_BACKUP_TITLE; ?></a></li>
<?php
                    break;

                case 'backend_sidebar_entries_event_display_backup':
                    $this->backup_interface();
                    break;


				case 'frontend_footer':
					echo "<img src=\"".$serendipity['baseURL'] . ($serendipity['rewrite'] == "none" ? $serendipity['indexFile'] . "?/" : "") . "plugin/checkautobackup\" width=\"1\" height=\"1\" style=\"border: 0px\" alt=\"\" />";
					break;


                case 'css_backend':
                    echo file_get_contents(dirname(__FILE__) . '/backup_backend.css');

                    break;


                case 'external_plugin':
                	$uri_parts = explode('?', str_replace('&amp;', '&', $eventData));
                    // Try to get request parameters from eventData name
                    if (!empty($uri_parts[1])) {
                        $reqs = explode('&', $uri_parts[1]);
                        foreach($reqs AS $id => $req) {
                            $val = explode('=', $req);
                            if (empty($_REQUEST[$val[0]])) {
                                $_REQUEST[$val[0]] = $val[1];
                            }
                        }
                    }
                    $parts     = explode('_', $uri_parts[0]);

                    switch($parts[0]) {
                        case 'checkautobackup':

                        	$this->CheckAutoSQLBackup();
                        	$this->CheckAutoDelSQLBackup();
                        	$this->CheckAutoHTMLBackup();
                        	$this->CheckAutoDelHTMLBackup();
                            break;



                        case 'dlbackup':

							$BACKUPDIR = $this->get_config('abspath_backupdir');

                        	$file = str_replace(array("\\", "/", "dlbackup_"), array("", "", ""), $uri_parts[0]);
                        	$file = basename($file);

							$dlfile = $BACKUPDIR."/".$file;

							$fnar = explode(".", $file);
							$ext = $fnar[(count($fnar)-1)];
							if ($ext == "tar") {
								$contenttype = "application/x-tar";
							} else {
								$contenttype = "application/x-zip-compressed";
							}


							$filename = $file;
							$path = $BACKUPDIR;
							$sysname = $file;
							$filesize = filesize($dlfile);

							if (function_exists("getallheaders")) {
								$headers = getallheaders();
							}

							if (substr($headers["Range"], 0, 6) == "bytes=") {
								header("HTTP/1.1 206 Partial Content");
								header("Content-Type: $contenttype");
								header("Content-Disposition: attachment; filename=".$filename);
								header("Accept-Ranges: bytes");
								header("Connection: close");
								$bytes = explode("=",$headers["Range"]);
								$bytes = $bytes[1];
								if (preg_match("@^-([0-9]+)@", $bytes, $bytes_len)) {
									$bytes_len = $bytes_len[1];
									$bytes_start = $filesize - $bytes_len;
									$bytes_end = $filesize - 1;
									header("Content-Length: ".$bytes_len);
								} elseif (preg_match("@([0-9]+)-$@", $bytes, $bytes_start)) {
									$bytes_start = $bytes_start[1];
									$bytes_end = $filesize - 1;
									$bytes_len = $filesize - $bytes_start;
									header("Content-Length: $bytes_len");
								} elseif (preg_match("@^([0-9]+)-([0-9]+)$@", $bytes, $bytes_pos))
									{
									$bytes_start = $bytes_pos[0];
									$bytes_end = $bytes_pos[1];
									if ($bytes_start < 0 || $bytes_start > ($filesize - 1)) {
										$bytes_start = 0;
                                    }
									if ($bytes_end < $bytes_start || $bytes_end > ($filesize - 1)) {
										$bytes_end = $filesize - 1;
                                    }
									$bytes_len = $bytes_end - $bytes_start + 1;
									header("Content-Length: $bytes_len");
								} else {
									$bytes_start = 0;
									$bytes_end = $filesize - 1;
									$bytes_len = $bytes_end - $bytes_start + 1;
									header("Content-Length: $bytes_len");
								}
								header("Content-Range: bytes $bytes_start-$bytes_end/".$filesize);
								$fp = fopen($path."/".$sysname,"rb");
								fseek($fp, $bytes_start);
								$contents = fread ($fp, $bytes_len );
								fclose($fp);
								echo $contents;
							} else {
								$fp = fopen($path."/".$sysname,"rb");
								$contents = fread ($fp, $filesize);
								fclose($fp);
								header("Content-Type: $contenttype");
								header("Content-Disposition: attachment; filename=".$filename);
								header("Accept-Ranges: bytes");
								header("Content-Length: " . strlen($contents));
								header("Connection: close");
								echo $contents;
							}

                            break;


                    }
                    return true;
                    break;


            }
        }

        return true;
    }
}
/* vim: set sts=4 ts=4 expandtab : */
