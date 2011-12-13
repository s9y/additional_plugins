#!/usr/bin/perl
#
# Write the Apache style configuration file
sub write_apache_file{

	debugmsg("sub write_apache_file",3);

	#Local variables
	my $now = localtime();
	my $uid = "";
	my $username = "";
	my $webdir = "";
	my $blogdir = "";
	my $writeok = 0;

	# Open TEMP file for writing
	open(OUTFILE,">$GLOBALVARS{'tempfile'}") or die "$WRITE_TEMP_OPEN_ERROR\n";

	print OUTFILE <<"ENDHEAD";
# $GLOBALVARS{'apacheconfigfile'}
#
#
# Suggested S9Y Apache configuration
#
# $PROGNAME_LONG v$GLOBALVARS{'version'}
#
# $now
ENDHEAD

	foreach $uid(sort(keys(%USERDATA))) {
		$username	= $USERDATA{$uid}[0];
		$webdir		= $USERDATA{$uid}[1];
		$blogdir	= $USERDATA{$uid}[2];

		if ($blogdir eq "") {
		    $blogdir="$webdir"
		}else{
		    $blogdir="$webdir/$blogdir"
		}

		print OUTFILE <<"ENDBLOCK";


#
# $username
#
<Directory \"$blogdir\">
 AllowOverride All
 php_value include_path \".:$GLOBALVARS{'libdir'}:$GLOBALVARS{'libdir'}/$GLOBALVARS{'s9ydir'}:$GLOBALVARS{'libdir'}/\$GLOBALVARS{'s9ydir'}/bundled-libs/:$blogdir/\"
 php_admin_value open_basedir \"$GLOBALVARS{'libdir'}:$GLOBALVARS{'libdir'}/$GLOBALVARS{'s9ydir'}:$blogdir/:/usr/bin/\"
 php_admin_value post_max_size \"10M\"
 php_admin_value upload_max_filesize \"10M\"
</Directory>
ENDBLOCK

	}

	# Close file
	close(OUTFILE);

	# Move Temporary File to Output File

	if (($GLOBALVARS{'sudo'} eq 'Y') && ($LOGIN_UID != 0) && ($LOGIN_GID != 0)) {
		print "\n";
		$writeok = system($GLOBALVARS{'commandprefix'}." mv ".$GLOBALVARS{'tempfile'}." ".$GLOBALVARS{'apacheconfigfile'});
		debugmsg("sudo mv: ".$writeok,4);
		unless ($writeok == 0) {
			return(3);
		}
		$writeok = system($GLOBALVARS{'commandprefix'}." chown root:root ".$GLOBALVARS{'apacheconfigfile'});
		debugmsg("sudo chown: ".$writeok,4);
		unless ($writeok == 0) {
			return(4);
		}
		$writeok = system($GLOBALVARS{'commandprefix'}." chmod 0644 ".$GLOBALVARS{'apacheconfigfile'});
		debugmsg("sudo chmod: ".$writeok,4);
		unless ($writeok == 0) {
			return(5);
		}
		return(0);
	}elsif (rename($GLOBALVARS{'tempfile'},$GLOBALVARS{'apacheconfigfile'})) {
		# Chmod file to rw-,r--,r-- (0644)
		if (chmod(0644,$GLOBALVARS{'apacheconfigfile'})) {
			return(0);
		}else{
			return (1);
		}
	}else{
		return(2);

	}

return(0);
}

# This line is needed to satisfy require
1;
