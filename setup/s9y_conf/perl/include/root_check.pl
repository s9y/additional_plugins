#!/usr/bin/perl
#
# Initialise variables
sub root_check {

	debugmsg("sub root_check",3);

	debugmsg("Bypass Root Check: $GLOBALVARS{'bypassroot'}",5);
	debugmsg("             UID: $LOGIN_UID",5);
	debugmsg("             GID: $LOGIN_GID",5);

	if ($GLOBALVARS{'bypassroot'} eq 'Y') {		# Bypass Root Check ?
		debugmsg("Bypassing root check",4);
		return(1);
	}elsif (($LOGIN_UID == 0) || ($LOGIN_GID == 0)) {	# Are We Superuser ?
		debugmsg("Superuser is running script",4);
		return(1);
	}else{							# Not Superuser
		debugmsg("Superuser is NOT running script",4);
		return(0);
	}
return(0);
}

# This line is needed to satisfy require
1;
