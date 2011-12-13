#!/usr/bin/perl
#
# Initialise variables
sub check_globals {

	debugmsg("sub check_globals",3);

	# Local variables
	my $key = '';

	# Upgrades may require a number of suitable
	#  if -> elsif -> else blocks to ensure all
	#  variables exist, and to delete those no
	#  longer required.
	#
	# e.g. if ($GLOBALVARS{'version'} ne $VERSION) {
	#          unless (exists($GLOBALVARS{'variable name'})) {
	#              $GLOBALVARS{'variable name'} = 'setting';
	#          }
	#          if ($GLOBALVARS{'variable name'} eq '<value>') {
	#              Neccessary commands to overwrite/translate value...
	#          }
	#      }
	#      foreach $key (sort(keys(%USERDATA))) {
	#          if ($USERDATA{$key}[n] ne <expression>) {
	#              Neccessary commmands to create/translate data...
	#          }
	#      }
	#
	# i.e. Create any missing variables then check
	#      existing ones to determine if they are
	#      in the correct format.
	#
	
	# v0.7 (original PERL version)
	#        similar block will be required in ANY version
	#
	# Ensure ALL neccessary Global variables exist
	#
	unless(exists($GLOBALVARS{'version'})) {
		$GLOBALVARS{'version'} = $VERSION;
	}
	unless(exists($GLOBALVARS{'bypassroot'})) {
		$GLOBALVARS{'bypassroot'} = 'Y';
		$GLOBALVARS{'sudo'} = 'N';
	}
	unless(exists($GLOBALVARS{'sudo'})) {
		$GLOBALVARS{'sudo'} = 'N';
	}
	unless(exists($GLOBALVARS{'commandprefix'})) {
		$GLOBALVARS{'commandprefix'} = "sudo -H -p 'Enter SuperUser Password: '";
	}
	unless(exists($GLOBALVARS{'language'})) {
		$GLOBALVARS{'language'} = 'GB';
	}
	unless(exists($GLOBALVARS{'tempfile'})) {
		$GLOBALVARS{'tempfile'} = 's9y_conf.temp';
	}
	unless(exists($GLOBALVARS{'libdir'})) {
		$GLOBALVARS{'libdir'} = '/usr/local/lib/php';
	}
	unless(exists($GLOBALVARS{'s9ydir'})) {
		$GLOBALVARS{'s9ydir'} = 's9y';
	}
	unless(exists($GLOBALVARS{'apacheconfigfile'})) {
		$GLOBALVARS{'apacheconfigfile'} = './s9y_apache.conf';
	}
	unless(exists($GLOBALVARS{'s9yinstallscript'})) {
		$GLOBALVARS{'s9yinstallscript'} = './s9y_shared_install.sh';
	}
	unless(exists($GLOBALVARS{'webserveruser'})) {
		$GLOBALVARS{'webserveruser'} = 'wwwrun';
	}
	unless(exists($GLOBALVARS{'webservergroup'})) {
		$GLOBALVARS{'webservergroup'} = 'www';
	}

return(0);
}

# This line is needed to satisfy require
1;
