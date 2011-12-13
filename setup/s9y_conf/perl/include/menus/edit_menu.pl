#!/usr/bin/perl
#
# Configuration Menu
sub edit_menu {

	debugmsg("sub edit_menu",3);

	# Local variables
	my $inkey = "";
	my $waitkey = "";
	my $head_length = "";
	my $title_length = "";
	my $spacer_length = "";
	my $write_status = 0;
	my $indent = "\t";
	my $page = 0;
	my $pages = 0;
	my @users_page = ();
	my $numusers_page = 3;
	my $index = 0;
	my $next_userid = 0;
	my @thisuser = ();
	my $user_edited = 0;
	my $users_changed = 0;

	# Find the length of the page header and underline with '='
	$head_length = length("$MENU_HEAD");
	if ($head_length > 80) {
		$head_length= 80;
	}
	$head_length = '=' x $head_length;

	# Find the length of the menu title and underline with '~'
	$title_length = length("$EM_TITLE");
	if ($title_length > 80) {
		$title_length= 80;
	}
	$title_length = '~' x $title_length;

	$spacer_length = '-' x 80;

	while ($inkey !~ /x|X/) {
		@USER_ID = sort(keys(%USERDATA));
		$NUM_USERS = @USER_ID;
		$next_userid = $NUM_USERS;
		if ($next_userid < 10) {
			$next_userid = "00".$next_userid;
		}elsif ($next_userid < 100) {
			$next_userid = "0".$next_userid;
		}	
		@users_page = ();
		$pages = int($NUM_USERS / $numusers_page);
		if ($NUM_USERS % $numusers_page) {
			$pages += 1;
		}
		if ($page > $pages -1) {
			$page = $pages -1;
		}
		if ($page < 0) {
			$page = 0;
		}
		for ($index = 0; $index < $numusers_page; $index += 1) {
			if (exists($USER_ID[$index + $page  * $numusers_page])) {
				push(@users_page,$USER_ID[$index + $page * $numusers_page]);
			}
		}
		system('clear');
		print "\n";
		print "\n".$indent.$MENU_HEAD;
		if ($DEBUG) { print $indent."Debug Level: $DEBUG" }
		print "\n".$indent.$head_length;
		print "\n";
		print "\n";
		print "\n";
		print "\n".$indent.$EM_TITLE;
		print "\n".$indent.$title_length;
		print "\n";
		print "\n";
		$page += 1;
		print "\n".$indent.$EM_PAGE_1." ".$page." ".$EM_PAGE_2." ".$pages." (".$NUM_USERS." ".$EM_PAGE_3.")";
		print "\n".$indent;
		if ($pages > 1) {
			if ($page >= 3) {
				print "(F) ".$EM_F;
			}
		}
		if ($page >= 2) {
			print "(P) ".$EM_P."  ";
		}
		if ($page <= $pages - 1) {
			print "(N) ".$EM_N."  ";
		}
		if ($pages > 1) {
			if ($page <= $pages -2) {
				print "(L) ".$EM_L."  ";
			}
		}
		$page -= 1;
		print "\n";
		print "\n".$indent."(A) ".$EM_A;
		if ($NUM_USERS > 0){
			print "  (E) ".$EM_E."  (D) ".$EM_D;
		}
		print "\n".$indent."(S) ".$EM_S."  (R) ".$EM_R;
		foreach $index (@users_page) {
			print "\n".$indent.$spacer_length;
			print "\n".$indent.$EM_1.": ".$index;
			print "\n".$indent.$EM_2.": ".$USERDATA{$index}[0];
			print "\n".$indent.$EM_3.": ".$USERDATA{$index}[1];
			print "\n".$indent.$EM_4.": ".$USERDATA{$index}[2];
			print "\n".$indent.$EM_5.": ".$USERDATA{$index}[3];
		}
		print "\n".$indent.$spacer_length;
		print "\n".$indent.$EM_PROMPTA." (x ".$EM_PROMPTB.") :";


		# Get the keypress
        	$inkey = <STDIN>;
        	chomp($inkey);
		$inkey =~ tr/a-z/A-Z/;
		if ($inkey eq "X") { #Exit
			@USER_ID = sort(keys(%USERDATA));
			$NUM_USERS = @USER_ID;
			if ($users_changed == 1) {
				$inkey='loop';
				while ($inkey eq 'loop') {
					print "\n".$indent.$EM_EXIT_SAVE." (Y/N) ?:";
					# Get the input
					$inkey = <STDIN>;
					chomp($inkey);
					$inkey =~ tr/a-z/A-Z/;
					if ($inkey eq 'Y') {
						&write_data;
						$inkey="";
					}elsif ($inkey eq 'N') {
						&read_data;
						$inkey="";
					}else{
						$inkey='loop';
					}
				}	
			}
			return(0);
		}elsif ($inkey eq "F") { #First Page
			if ($page > 0) {
				$page = 0;
			}
			$inkey="";
		}elsif ($inkey eq "P") { #Previous Page
			if ($page > 0) {
				$page -= 1;
			}
			$inkey="";
		}elsif ($inkey eq "N") { #Next Page
			if ($page < $pages -1 ) {
				$page += 1;
			}
			$inkey="";
		}elsif ($inkey eq "L") { #Last Page
			if ($page < $pages - 1) {
				$page = $pages;
			}
			$inkey="";
		}elsif ($inkey eq "A") { #Add User
			if ($NUM_USERS < 1000) {
				debugmsg("Next UserID: ".$next_userid,5);
				$thisuser[0] = $next_userid;
				print "\n\n".$indent.$EM_1.": ".$next_userid;
				$inkey="";
				print "\n".$indent.$EM_2.": ";
				# Get the input
		        	$inkey = <STDIN>;
		        	chomp($inkey);
				if ($inkey ne '') {
					$thisuser[1] = $inkey;
					$inkey="";
					print $indent.$EM_3.": ";
					# Get the input
					$inkey = <STDIN>;
					chomp($inkey);
					if ($inkey ne '') {
						$thisuser[2] = $inkey;
						$inkey="";
						print $indent.$EM_4.": ";
						# Get the input
						$inkey = <STDIN>;
						chomp($inkey);
						if ($inkey ne '') {
							$thisuser[3] = $inkey;
						}
						$inkey="";
						print $indent.$EM_5.": ";
						# Get the input
						$inkey = <STDIN>;
						chomp($inkey);
						if ($inkey ne '') {
							$thisuser[4] = $inkey;
							@USERDATA{$thisuser[0]} = ([$thisuser[1],$thisuser[2],$thisuser[3],$thisuser[4]]);
							$users_changed = 1;
							print "\n".$indent.$EM_SUCCESS_ADD;
							print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
						}else{
							print "\n".$indent.$EM_ERROR_4." ".$EM_FAILURE_ADD." !";
							print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
						}
					}else{
						print "\n".$indent.$EM_ERROR_3." ".$EM_FAILURE_ADD." !";
						print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
					}
				}else{
					print "\n".$indent.$EM_ERROR_2." ".$EM_FAILURE_ADD." !";
					print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
				}
			}else{
				print "\n\n".$indent.$EM_ERROR_1;
			}
			$inkey="";
		}elsif ($inkey eq "E") { #Edit User
			$user_edited = 0;
			$inkey="";
			print "\n\n".$indent.$EM_EDIT_1E.": ";
			# Get the input
			$inkey = <STDIN>;
			chomp($inkey);
			debugmsg("Input UID: ".$inkey,5);
			if (($inkey ne '') && ($USERDATA{$inkey} ne '')){
				$thisuser[0] = $inkey;
				$thisuser[1] = $USERDATA{$inkey}[0];
				$thisuser[2] = $USERDATA{$inkey}[1];
				$thisuser[3] = $USERDATA{$inkey}[2];
				$thisuser[4] = $USERDATA{$inkey}[3];
				print "\n".$indent.$EM_EDIT_2."[".$thisuser[1]."]: ";
				# Get the input
		        	$inkey = <STDIN>;
		        	chomp($inkey);
				if ($inkey ne '') {
					debugmsg("Name entered: ".$inkey,5);
					$user_edited = 1;
					$thisuser[1] = $inkey;
				}
				$inkey="";
				print "\n".$indent.$EM_EDIT_3."[".$thisuser[2]."]: ";
				# Get the input
				$inkey = <STDIN>;
				chomp($inkey);
				if ($inkey ne '') {
					debugmsg("Webroot entered: ".$inkey,5);
					$user_edited = 1;
					$thisuser[2] = $inkey;
				}
				$inkey="";
				print "\n".$indent.$EM_EDIT_4A."[".$thisuser[3]."]: ";
				# Get the input
				$inkey = <STDIN>;
				chomp($inkey);
				debugmsg(" Blog Directory entered: '".$inkey."'",5);
				if ($inkey ne '') {
					$user_edited = 1;
					$thisuser[3] = $inkey;
				}elsif($thisuser[3] ne '') {
					$inkey='loop';
					while ($inkey eq 'loop') {
						print "\n".$indent.$EM_EDIT_4B." (Y/N) ?:";
						# Get the input
						$inkey = <STDIN>;
						chomp($inkey);
						$inkey =~ tr/a-z/A-Z/;
						if ($inkey eq 'Y') {
							$user_edited = 1;
							$thisuser[3] = '';
							$inkey="";
						}elsif ($inkey eq 'N') {
							$inkey="";
						}else{
							$inkey='loop';
						}
					}	
				}
				$inkey="";
				print "\n".$indent.$EM_EDIT_5."[".$thisuser[4]."]: ";
				# Get the input
				$inkey = <STDIN>;
				chomp($inkey);
				if ($inkey ne '') {
					debugmsg("User Account entered: ".$inkey,5);
					$user_edited = 1;
					$thisuser[4] = $inkey;
				}
				debugmsg("User edit: ".$user_edited,5);
				if ($user_edited == 1) {
					@USERDATA{$thisuser[0]} = ([$thisuser[1],$thisuser[2],$thisuser[3],$thisuser[4]]);
					$users_changed = 1;
					print "\n".$indent.$EM_SUCCESS_EDIT;
					print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;

				}else{
					print "\n".$indent.$EM_FAILURE_EDIT;
					print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
				}
			}else{
					print "\n".$indent.$EM_ERROR_5;
					print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
			}
			$inkey="";
		}elsif ($inkey eq "D") { #Delete User
			$inkey="";
			print "\n\n".$indent.$EM_EDIT_1D.": ";
			# Get the input
	        	$inkey = <STDIN>;
	        	chomp($inkey);
			if ($inkey ne '') {
				if (delete($USERDATA{$inkey})) {
					$users_changed = 1;
					print "\n".$indent.$EM_SUCCESS_DELETE;
					print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
				}else{
					print "\n".$indent.$EM_ERROR_5." ".$EM_FAILURE_DELETE." !";
					print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
				}
			}
			$inkey="";
		}elsif ($inkey eq "S") { #Save Changes
			&write_data;
			print "\n\n".$indent.$EM_SAVE;
			print "\n".$indent.$WAIT_MSG; $waitkey = <STDIN>;
		}elsif ($inkey eq "R") { #Reset Changes
			&read_data;
		}
	}
return(0);
}

# This line is needed to satisfy require
1;
