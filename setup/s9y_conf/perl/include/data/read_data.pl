#!/usr/bin/perl
#
# Read data from file
sub read_data {

	debugmsg("sub read_data",3);

	# Local variables
	my($line,@newitem);

	# Ensure arrays initialised to null
	%GLOBALVARS = ();
	%USERDATA = ();

	# Check if file exists and whether we can read it
	if (not(-e "$S9Y_CONF_DATA")) {
		return(0);
	}elsif (not(-r "$S9Y_CONF_DATA")) {
			return(0);
	}else{
		# Open data file
		open(DATAIN, "<$S9Y_CONF_DATA") or die "$READ_DATA_OPEN_ERROR\n";
	
		# Read data file line by line
		while (<DATAIN>) {
			$line = $_;
			chomp($line);
			debugmsg("Line: $line",6);
			@newitem = split(/\t/,$line);
			# Determine variable type and put values in the correct array
			debugmsg("Newitem 0: '$newitem[0]'",7);
			debugmsg("Newitem 1: '$newitem[1]'",7);
			debugmsg("Newitem 2: '$newitem[2]'",7);
		
			if($newitem[0] eq "GLOBAL"){
				debugmsg("GLOBAL $newitem[1]: $newitem[2]",5);
				$GLOBALVARS{$newitem[1]} = $newitem[2];
			}elsif($newitem[0] eq "USERDATA"){
				debugmsg("USERDATA $newitem[1]: ".
					"$newitem[2],$newitem[3],".
					"$newitem[4],$newitem[5],",5);
				$USERDATA{$newitem[1]} = [$newitem[2],$newitem[3],$newitem[4],$newitem[5]]
			}
		}
		# Close data file
		close(DATAIN);
	}

return(1);
}

# This line is needed to satisfy require
1;
