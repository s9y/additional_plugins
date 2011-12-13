#!/usr/bin/perl
#
# Configuration Menu
sub config_menu {

	debugmsg("sub config_menu",3);

	# Local variables
	my $inkey = "";
	my $waitkey = "";
	my $head_length = "";
	my $title_length = "";
	my $spacer_length = "";
	my $blank_cm3 = " " x length($CM_3);
	my $write_status = 0;
	my $indent = "\t";
	my $lang = '';
	my @langfiles = ();
	my @langs = ();
	my $langcnt = '';
	my $displaycnt = '';
	my $langfile = '';


	while ($inkey !~ /x|X/) {
		system('clear');

		# Find the length of the page header and underline with '='
		$head_length = length("$MENU_HEAD");
		if ($head_length > 80) {
			$head_length= 80;
		}
		$head_length = '=' x $head_length;
		# Find the length of the menu title and underline with '~'
		$title_length = length("$CM_TITLE");
		if ($title_length > 80) {
			$title_length= 80;
		}
		$title_length = '~' x $title_length;
		# Find the longest length for a menu option and create separator
		$spacer_length = length($CM_L.": ".$GLOBALVARS{'language'});
		if ($spacer_length < length($CM_1.": ".$GLOBALVARS{'webserveruser'})) {
			$spacer_length = length($CM_1.": ".$GLOBALVARS{'webserveruser'})
		}
		if ($spacer_length < length($CM_2.": ".$GLOBALVARS{'webservergroup'})) {
			$spacer_length = length($CM_2.": ".$GLOBALVARS{'webservergroup'});
		}
		if ($spacer_length < length($CM_3.": ".$GLOBALVARS{'libdir'})) {
			$spacer_length = length($CM_3.": ".$GLOBALVARS{'libdir'});
		}
		if ($spacer_length < length($CM_4.": ".$GLOBALVARS{'s9ydir'})) {
			$spacer_length = length($CM_4.": ".$GLOBALVARS{'s9ydir'});
		}
		if ($spacer_length < length($CM_5.": ".$GLOBALVARS{'tempfile'})) {
			$spacer_length = length($CM_5.": ".$GLOBALVARS{'tempfile'});
		}
		if ($spacer_length < length($CM_6.": ".$GLOBALVARS{'apacheconfigfile'})) {
			$spacer_length = length($CM_6.": ".$GLOBALVARS{'apacheconfigfile'});
		}
		if ($spacer_length < length($CM_7.": ".$GLOBALVARS{'s9yinstallscript'})) {
			$spacer_length = length($CM_7.": ".$GLOBALVARS{'s9yinstallscript'});
		}
		if ($spacer_length < length($CM_8.": ".$GLOBALVARS{'bypassroot'})) {
			$spacer_length = length($CM_8.": ".$GLOBALVARS{'bypassroot'});
		}
		if ($spacer_length < length($CM_9.": ".$GLOBALVARS{'sudo'})) {
			$spacer_length = length($CM_2.": ".$GLOBALVARS{'sudo'});
		}
		if ($spacer_length < length(" ".$CM_9A.": ".$GLOBALVARS{'commandprefix'})) {
			$spacer_length = length(" ".$CM_9A.": ".$GLOBALVARS{'commandprefix'});
		}
		if ($spacer_length < length($SM_S."    (D) ".$CM_D)) {
			$spacer_length = length($SM_S."    (D) ".$CM_D);
		}
		if ($spacer_length > 74) {
			$spacer_length = 74;
		}
		$spacer_length = '-' x ($spacer_length +6);
		# Screen output starts
		print "\n";
		print "\n".$indent.$MENU_HEAD;
		if ($DEBUG) { print $indent."Debug Level: $DEBUG" }
		print "\n".$indent.$head_length;
		print "\n";
		print "\n";
		print "\n";
		print "\n".$indent.$CM_TITLE;
		print "\n".$indent.$title_length;
		print "\n";
		print "\n";
		print "\n".$indent."(L) ".$CM_L.": ".$GLOBALVARS{'language'};
		print "\n";
		print "\n".$indent."(1) ".$CM_1.": ".$GLOBALVARS{'webserveruser'};
		print "\n".$indent."(2) ".$CM_2.": ".$GLOBALVARS{'webservergroup'};
		print "\n".$indent.$spacer_length;
		print "\n";
		print "\n".$indent."(3) ".$CM_3.": ".$GLOBALVARS{'libdir'};	
		print "\n".$indent."(4) ".$CM_4.": ".$GLOBALVARS{'s9ydir'};	
		print "\n".$indent."(5) ".$CM_5.": ".$GLOBALVARS{'tempfile'};	
		print "\n".$indent.$spacer_length;
		print "\n";
		print "\n".$indent."(6) ".$CM_6.": ".$GLOBALVARS{'apacheconfigfile'};	
		print "\n".$indent."(7) ".$CM_7.": ".$GLOBALVARS{'s9yinstallscript'};	
		print "\n".$indent.$spacer_length;

		if (($LOGIN_UID == 0) || ($LOGIN_GID == 0)) {
			print "\n";
			print "\n".$indent."(8) ".$CM_8.": ".$GLOBALVARS{'bypassroot'};
			print "\n".$indent."(9) ".$CM_9.": ".$GLOBALVARS{'sudo'};
			if ($GLOBALVARS{'sudo'} eq 'Y') {
				print "\n".$indent."    ".$CM_9A.": ".$GLOBALVARS{'commandprefix'};
			}else{
				print "\n";
			}
			print "\n".$indent.$spacer_length;
		}

		print "\n";
		print "\n".$indent."(S) ".$CM_S."    (D) ".$CM_D;
		print "\n".$indent.$spacer_length;
		print "\n".$indent.$CM_PROMPTA." (x ".$CM_PROMPTB.") :";


		# Get the keypress
        	$inkey = <STDIN>;
        	chomp($inkey);
		$inkey =~ tr/A-Z/a-z/;
		if ($inkey eq "l") { #Language
			$lang = "";
			#READ AVAILABLE LANGUAGES
			opendir(LANGDIR, "./lang") or die "Can't open language directory\n";
			@langfiles = grep {/lang_.*.pl$/} readdir LANGDIR;
			closedir LANGDIR;
			@langs = (); $langcnt = 0; $displaycnt = 0;
			print "Select Language:\n\n";
			foreach $langfile (@langfiles){
				chomp($langfile);
				$langcnt++;
				$langfile =~ s/lang_//;
				$langfile =~ s/\.pl//;
#				$langfile .= "               ";
#				$langfile = substr($langfile,0,10);
				$langs[$langcnt] = $langfile;
				print "\($langcnt\)$langfile\t";
				if ($displaycnt > 3) {print "\n"; $displaycnt = 0;}
				$displaycnt++;
			}
			print "\n\nType the number of your selection:";
			$inkey = <STDIN>;
			chomp($inkey);
			if ($inkey ne '') {
				$inkey += 0;
				$lang = $langs[$inkey];
				$lang =~ s/ //;
				$GLOBALVARS{'language'} = $lang;
			}
			$inkey="";
			# Try and Set the language
			# (only works when language changes to something as yet unused >:-\)
			require "lang_".$GLOBALVARS{'language'}.".pl";
		}elsif ($inkey eq "1") { #Webserver User
			print "\n\n".$indent.$CM_EDIT_1."[".$GLOBALVARS{'webserveruser'}."]:";
			# Get the keypress
	        	$inkey = <STDIN>;
	        	chomp($inkey);
			if ($inkey ne '') {
				$GLOBALVARS{'webserveruser'} = $inkey;
			}
			$inkey="";
		}elsif ($inkey eq "2") { #Webserver Group
			print "\n\n".$indent.$CM_EDIT_2."[".$GLOBALVARS{'webservergroup'}."]:";
			# Get the keypress
	        	$inkey = <STDIN>;
	        	chomp($inkey);
			if ($inkey ne '') {
				$GLOBALVARS{'webservergroup'} = $inkey;
			}
			$inkey="";
		}elsif ($inkey eq "3") { #Lib Directory
			print "\n\n".$indent.$CM_EDIT_3."[".$GLOBALVARS{'libdir'}."]:";
			# Get the keypress
	        	$inkey = <STDIN>;
	        	chomp($inkey);
			if ($inkey ne '') {
				if (opendir(DIRTEMP,$inkey)) {
					$GLOBALVARS{'libdir'} = $inkey;
				}else{
					print "\n$indent$inkey $CM_ERROR_2";
					print "\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
				}
				closedir(DIRTEMP);
			}
			$inkey="";
		}elsif ($inkey eq "4") { #S9Y Directory
			print "\n\n".$indent.$CM_EDIT_4."[".$GLOBALVARS{'s9ydir'}."]:";
			# Get the keypress
	        	$inkey = <STDIN>;
	        	chomp($inkey);
			if ($inkey ne '') {
				if (opendir(DIRTEMP,"$GLOBALVARS{'libdir'}/$inkey")) {
					$GLOBALVARS{'s9ydir'} = $inkey;
				}else{
					print "\n$indent$GLOBALVARS{'libdir'}/$inkey $CM_ERROR_2";
					print "\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
				}
				closedir(DIRTEMP);
			}
			$inkey="";
		}elsif ($inkey eq "5") { #Temporary File
			print "\n\n".$indent.$CM_EDIT_5."[".$GLOBALVARS{'tempfile'}."]:";
			# Get the keypress
	        	$inkey = <STDIN>;
	        	chomp($inkey);
			if ($inkey ne '') {
				if (($inkey ne $GLOBALVARS{'apacheconfigfile'}) && ("./".$inkey ne $GLOBALVARS{'apacheconfigfile'})) {
					if (($inkey ne $GLOBALVARS{'s9yinstallscript'}) && ("./".$inkey ne $GLOBALVARS{'s9yinstallscript'})) {
						if (open(FILETEMP, ">$inkey")) {
							$GLOBALVARS{'tempfile'} = $inkey;
						}else{
							print "\n".$indent.$CM_ERROR_3." ".$inkey." !";
							print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
						}
						close(FILETEMP);
						unlink($inkey);
					}else{
						print "\n".$indent.$CM_ERROR_4." !";
						print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
					}
				}else{
					print "\n".$indent.$CM_ERROR_5." !";
					print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
				}
			}
			$inkey="";
		}elsif ($inkey eq "6") { #Apache Configuration File
			print "\n\n".$indent.$CM_EDIT_6."[".$GLOBALVARS{'apacheconfigfile'}."]:";
			# Get the keypress
	        	$inkey = <STDIN>;
	        	chomp($inkey);
			if ($inkey ne '') {
				if (($inkey ne $GLOBALVARS{'tempfile'}) && ("./".$inkey ne $GLOBALVARS{'tempfile'})) {
					if (($inkey ne $GLOBALVARS{'s9yinstallscript'}) && ("./".$inkey ne $GLOBALVARS{'s9yinstallscript'})) {
						if (open(FILETEMP,">>$inkey")) {
							$GLOBALVARS{'apacheconfigfile'} = $inkey;
						}else{
							print "\n".$indent.$CM_ERROR_3." ".$inkey." !";
							print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
						}
						close(FILETEMP);
					}else{
						print "\n".$indent.$CM_ERROR_6." !";
						print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
					}
				}else{
					print "\n".$indent.$CM_ERROR_7." !";
					print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
				}
			}
			$inkey="";
		}elsif ($inkey eq "7") { #S9Y Install Script
			print "\n\n".$indent.$CM_EDIT_7."[".$GLOBALVARS{'s9yinstallscript'}."]:";
			# Get the keypress
	        	$inkey = <STDIN>;
	        	chomp($inkey);
			if ($inkey ne '') {
				if (($inkey ne $GLOBALVARS{'tempfile'}) && ("./".$inkey ne $GLOBALVARS{'tempfile'})) {
					if (($inkey ne $GLOBALVARS{'apacheconfigfile'}) && ("./".$inkey ne $GLOBALVARS{'apacheconfigfile'})) {
						if (open(FILETEMP,">>$inkey")) {
							$GLOBALVARS{'s9yinstallscript'} = $inkey;
						}else{
							print "\n".$indent.$CM_ERROR_3." ".$inkey." !";
							print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
						}
						close(FILETEMP);
					}else{
						print "\n".$indent.$CM_ERROR_8." !";
						print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
					}
				}else{
					print "\n".$indent.$CM_ERROR_9." !";
					print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
				}
			}
			$inkey="";
		}elsif ($inkey eq "8") { #Bypass Root Check
			print "\n\n".$indent.$CM_EDIT_8."[".$GLOBALVARS{'bypassroot'}."]:";
			# Get the keypress
	        	$inkey = <STDIN>;
	        	chomp($inkey);
			$inkey =~ tr/a-z/A-Z/;
			if ((substr($inkey,0,1) eq 'Y') || (substr($inkey,0,1) eq 'N')){
				$GLOBALVARS{'bypassroot'} = $inkey;
			}elsif ($inkey ne '') {
				print "\n$CM_ERROR_1";
				print "\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}
			$inkey="";
		}elsif ($inkey eq "9") { #Allow sudo
			print "\n\n".$indent.$CM_EDIT_9."[".$GLOBALVARS{'sudo'}."]:";
			# Get the input
			$inkey = <STDIN>;
			chomp($inkey);
			$inkey =~ tr/a-z/A-Z/;
			if ((substr($inkey,0,1) eq 'Y') || (substr($inkey,0,1) eq 'N')){
				$GLOBALVARS{'sudo'} = $inkey;
			}elsif ($inkey ne '') {
				print "\n$indent$CM_ERROR_1";
				print "\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}
			if ($GLOBALVARS{'sudo'} eq 'Y') {
				$inkey="";
				print "\n\n".$indent.$CM_EDIT_9A."[".$GLOBALVARS{'commandprefix'}."]:";
				# Get the input
		        	$inkey = <STDIN>;
		        	chomp($inkey);
				if ($inkey ne '') {
					$GLOBALVARS{'commandprefix'} = $inkey;
				}
			}
			$inkey="";
		}elsif ($inkey eq "s") { #Save changes
			&write_data;
			print "\n\n".$indent.$CM_SAVE;
			print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
		}elsif ($inkey eq "d") { #Discard changes
			&read_data;
		}
	}
return(0);
}

# This line is needed to satisfy require
1;
