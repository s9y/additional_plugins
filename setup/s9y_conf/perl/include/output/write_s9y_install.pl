#!/usr/bin/perl
#
# Write the S9Y Shared Installation script
sub write_s9y_install{

	debugmsg("sub write_s9y_install",3);

	#Local variables
	my $now = localtime();
	my $uid = "";
	my $username = "";
	my $webdir = "";
	my $blogdir = "";
	my $localuser = "";

	# Open TEMP file for writing
	open(OUTFILE,">$GLOBALVARS{'tempfile'}") or die "$WRITE_TEMP_OPEN_ERROR\n";

	print OUTFILE <<"ENDHEAD";
#!/bin/bash
#
# $GLOBALVARS{'s9yinstallscript'}
#
# $S9Y_SIS_TITLE
#
# $PROGNAME_LONG v$GLOBALVARS{'version'}
#
# $now 
ENDHEAD

	foreach $uid(sort(keys(%USERDATA))) {
		$username	= $USERDATA{$uid}[0];
		$webdir		= $USERDATA{$uid}[1];
		$blogdir	= $USERDATA{$uid}[2];
		$localuser	= $USERDATA{$uid}[3];

		if ($blogdir eq "") {
		    $blogdir="$webdir"
		}else{
		    $blogdir="$webdir/$blogdir"
		}

		print OUTFILE <<"ENDBLOCK";


#
# $username
#
cp -r $GLOBALVARS{'libdir'}/$GLOBALVARS{'s9ydir'}/deployment/* $blogdir
cp -r $GLOBALVARS{'libdir'}/$GLOBALVARS{'s9ydir'}/templates $blogdir/
cp -r $GLOBALVARS{'libdir'}/$GLOBALVARS{'s9ydir'}/htmlarea $blogdir/
chown -R $localuser:$GLOBALVARS{'webservergroup'} $blogdir
chown -R $localuser:$GLOBALVARS{'webservergroup'} $blogdir/*
chmod u+rwx,g+rwx $blogdir
chmod u+rwx,g+rwx $blogdir/{templates_c,uploads,archives}
chown $GLOBALVARS{'webserveruser'}:$GLOBALVARS{'webservergroup'} $blogdir/serendipity_config_local.inc.php
chmod u+rwx,g-rwx,o-rwx $blogdir/serendipity_config_local.inc.php
ENDBLOCK

	}

	# Close file
	close(OUTFILE);

	# Move Temporary File to Output File
	if (($GLOBALVARS{'sudo'} eq 'Y') && ($LOGIN_UID != 0) && ($LOGIN_GID != 0)) {
		print "\n";
		$writeok = system($GLOBALVARS{'commandprefix'}." mv ".$GLOBALVARS{'tempfile'}." ".$GLOBALVARS{'s9yinstallscript'});
		debugmsg("Write OK (mv): ".$writeok,4);
		unless ($writeok == 0) {
			return(3);
		}
		$writeok = system($GLOBALVARS{'commandprefix'}." chown root:root ".$GLOBALVARS{'s9yinstallscript'});
		debugmsg("sudo chown: ".$writeok,4);
		unless ($writeok == 0) {
			return(4);
		}
		$writeok = system($GLOBALVARS{'commandprefix'}." chmod 0744 ".$GLOBALVARS{'s9yinstallscript'});
		debugmsg("sudo chmod: ".$writeok,4);
		unless ($writeok == 0) {
			return(5);
		}
		return(0);
	}elsif (rename($GLOBALVARS{'tempfile'},$GLOBALVARS{'s9yinstallscript'})) {
		# Chmod file to rw-,r--,r-- (0644)
		if (chmod(0744,$GLOBALVARS{'s9yinstallscript'})) {
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
