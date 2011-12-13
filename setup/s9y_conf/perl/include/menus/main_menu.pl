#!/usr/bin/perl
#
# Main Menu
sub main_menu {

	debugmsg("sub main_menu",3);

	# Local variables
	my $inkey = "";
	my $waitkey = "";
	my $head_length = "";
	my $title_length = "";
	my $spacer_length = "";
	my $write_status = 0;
	my $indent = "\t";

	# Find the length of the page header and underline with '='
	$head_length = length("$MENU_HEAD");
	if ($head_length > 80) {
		$head_length= 80;
	}
	$head_length = '=' x $head_length;

	# Find the length of the menu title and underline with '~'
	$title_length = length("$MM_TITLE");
	if ($title_length > 80) {
		$title_length= 80;
	}
	$title_length = '~' x $title_length;

	# Find the longest length for a menu option and create separator
	$spacer_length = length("(1) $MM_1");
	if ($spacer_length < length("(2) $MM_2A".$NUM_USERS."$MM_2B")) {
		$spacer_length = length("(2) $MM_2");
	}
	if ($spacer_length < length("(3) $MM_3")) {
		$spacer_length = length("(3) $MM_3");
	}
	if ($spacer_length < length("(4) $MM_4")) {
		$spacer_length = length("(4) $MM_4");
	}
	if ($spacer_length > 80) {
		$spacer_length = 80;
	}
	$spacer_length = '-' x ($spacer_length +2);

	while ($inkey !~ /x|X/) {
		system('clear');
		print "\n";
		print "\n$indent$MENU_HEAD";
		if ($DEBUG) { print $indent."Debug Level: ".$DEBUG; }
		print "\n$indent$head_length";
		print "\n";
		print "\n";
		print "\n";
		print "\n$indent$MM_TITLE";
		print "\n$indent$title_length";
		print "\n";
		print "\n";
		print "\n$indent(1) $MM_1";
		print "\n$indent$spacer_length";
		print "\n";
		print "\n$indent(2) $MM_2A".$NUM_USERS."$MM_2B";
		print "\n$indent$spacer_length";
		print "\n";
		print "\n$indent(3) $MM_3";
		print "\n";
		print "\n$indent(4) $MM_4";	
		print "\n$indent$spacer_length";
		print "\n$indent$MM_PROMPTA (x $MM_PROMPTB):";


		# Get the keypress
        	$inkey = <STDIN>;
        	chomp($inkey);
		$inkey =~ tr/A-Z/a-z/;
		if ($inkey eq "1") {
			&config_menu;
		}elsif ($inkey eq "2") {
#			print "\n\n$indentOption 2 selected";
#			print "\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			&edit_menu;
		}elsif ($inkey eq "3") {
			$write_status = &write_apache_file;
			debugmsg("Write Status: $write_status",4);
			if ($write_status == 0) {
				print "\n\n$indent$APACHE_CONF_WRITE_SUCCESS";
				print "\n\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}elsif ($write_status == 1) {
				print "\n\n$indent$APACHE_CONF_WRITE_ERROR_1";
				print "\n\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}elsif ($write_status == 2) {
				print "\n\n$indent$APACHE_CONF_WRITE_ERROR_2";
				print "\n\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}elsif ($write_status == 3) {
				print "\n\n$indent$APACHE_CONF_WRITE_ERROR_3";
				print "\n\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}elsif ($write_status == 4) {
				print "\n\n$indent$APACHE_CONF_WRITE_ERROR_4";
				print "\n\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}elsif ($write_status == 5) {
				print "\n\n$indent$APACHE_CONF_WRITE_ERROR_5";
				print "\n\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}
		}elsif ($inkey eq "4") {
			$write_status = &write_s9y_install;
			debugmsg("Write Status: $write_status",4);
			if ($write_status == 0) {
				print "\n\n$indent$S9Y_INSTALL_WRITE_SUCCESS";
				print "\n\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}elsif ($write_status == 1) {
				print "\n\n$indent$S9Y_INSTALL_WRITE_ERROR_1";
				print "\n\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}elsif ($write_status == 2) {
				print "\n\n$indent$S9Y_INSTALL_WRITE_ERROR_2";
				print "\n\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}elsif ($write_status == 3) {
				print "\n\n$indent$S9Y_INSTALL_WRITE_ERROR_3";
				print "\n\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}elsif ($write_status == 4) {
				print "\n\n$indent$S9Y_INSTALL_WRITE_ERROR_4";
				print "\n\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}elsif ($write_status == 5) {
				print "\n\n$indent$S9Y_INSTALL_WRITE_ERROR_5";
				print "\n\n$indent$WAIT_MSG"; $waitkey = <STDIN>;
			}
		}
	}
return(0);
}

# This line is needed to satisfy require
1;
