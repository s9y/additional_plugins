#!/usr/bin/perl
#
# Print Debug messages to screen
sub debugmsg{

	#Local variables
	my $text = shift(@_);
	my $level = shift(@_);

	if ($DEBUG >= $level) {
		print "DEBUG: ";
		print "$text\n";
	}

return(0);
}

# This line is needed to satisfy require
1;
