#!/usr/bin/perl
#
# Write data to file
sub write_data {

	debugmsg("sub write_data",3);

	# Local variables
	my $key = 0;
	my $usernum = 0;
	my $userid = 0;

	debugmsg("Data File: $S9Y_CONF_DATA",4);
	# Open the data file
	open(DATAOUT, ">$S9Y_CONF_DATA") or die "$WRITE_DATA_OPEN_ERROR\n";

	# Global variables
	foreach $key (sort(keys(%GLOBALVARS))){
		debugmsg("GLOBAL $key: $GLOBALVARS{$key}\n",4);
		print DATAOUT "GLOBAL\t".
				"$key\t".
				"$GLOBALVARS{$key}".
				"\n";
	}

	# User Data
	foreach $key (sort(keys(%USERDATA))){
		if ($usernum < 10) {
			$userid = "00".$usernum;
		}elsif ($usernum < 100) {
			$userid = "0".$usernum;
		}elsif ($usernum > 1000) {
			die $MAX_USERNUM_REACHED."\n";
		}	
		$usernum += 1;
		debugmsg("USERDATA $key: $USERDATA{$key}[0],$USERDATA{$key}[1],".
			"$USERDATA{$key}[2]\t,$USERDATA{$key}[3]\n",4);
		print DATAOUT "USERDATA\t".
				"$userid\t".
				"$USERDATA{$key}[0]\t".
				"$USERDATA{$key}[1]\t".
				"$USERDATA{$key}[2]\t".
				"$USERDATA{$key}[3]".
				"\n";
	}

	# Close data file
	close(DATAOUT);

	# Make data file Read/Write for ALL
	#  (required to allow root/user access)
	#
	# Chmod file to rw-,rw-,rw- (0666)
	chmod(0666,$S9Y_CONF_DATA);

return(0);
}

# This line is needed to satisfy require
1;
