#!/usr/bin/perl
#
# s9y_conf.pl
#
# Serendipity Config Generator
$VERSION = "0.7";

#Debug Level
$DEBUG = 0;
if ($DEBUG) { print "Debug Level: $DEBUG\n"; }

# Local variable
my $rootcheck = 0;

# Initial;isation

# Directories holding files to be included
push(@INC	,'./lang'
		,'./include'
		,'./include/data'
		,'./include/menus'
		,'./include/output'
);

#Include subroutines
require 'debugmsg.pl';
require 'init_vars.pl';
require 'init_data.pl';
require 'check_globals.pl';
require 'write_data.pl';
require 'read_data.pl';
require 'root_check.pl';
require 'main_menu.pl';
require 'config_menu.pl';
require 'edit_menu.pl';
require 'write_apache_file.pl';
require 'write_s9y_install.pl';

# Initialise main variables
&init_vars;

# Set language
require "lang_".$GLOBALVARS{'language'}.".pl";

# Root check
unless (&root_check) {
	print "\n\n$MUSTBEROOT\n";
	exit (1);
}

# Go to main program menu
&main_menu;

# Make certian we delete our tempfile
unlink($GLOBALVARS{'tempfile'});

print "\n\t$PROG_EXIT\n\n";
exit(0);
