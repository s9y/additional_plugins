#!/usr/bin/perl
#
# Initialise variables
sub init_vars {

	debugmsg("sub init_vars",3);

	# Local variables
	my $readok = 0;

	# Initialse arrays to null
	%GLOBALVARS = ();
	%USERDATA = ();

	# Datafile
	$S9Y_CONF_DATA = './s9y_conf.dat';

	# Read variables from datafile
	$readok = &read_data;
	debugmsg("Read OK: $readok",4);

	# Check we read the data file properly and
	#
	#  In the case we did:
	#    Perform tests to ensure all data required
	#    exists in the proper format and that any
	#    version upgrade is performed where it is
	#    needed (i.e. deletion/addition of variables).
	#
	#  In the case the file didn't exist, or couldn't
	#  be read for some reason:
	#     Initialise variables to sane defaults.
	#
	if ($readok) {
		&check_globals;
	}else{
		&init_data;
	}

	# Count No. Users
	@USER_ID = sort(keys(%USERDATA));
	$NUM_USERS = @USER_ID;

	# Login and Superuser Info
	$LOGIN_UID = $>;
	$LOGIN_GID = $);
	@SUPERUSER = getpwuid(0);

	# Ensure sudo password not cached by shell
	system('sudo -K');

return(0);
}

# This line is needed to satisfy require
1;
