=================================================================================
s9y_conf
~~~~~~~~
A PERL script to aid in the setup of Serendipity Blog (S9Y) especially in a
shared environment.

This script is released to the public domain under the GPL licence, it is free
to use without warranty.

Chris Lander - clander@labbs.com
=================================================================================

Install
~~~~~~~

1. Copy all the files and subdirectories onto your machine.
    (Directory structure IS important)

2. Make sure s9y_conf.pl is executable (i.e. chmod 0744 s9y_conf.pl)



Usage
~~~~~

When you execute the script for the first time a sane set of defaults is setup,
which you can then edit to suit your requirements.  By default the Apache style
config file and shared install script are created in the script's directory, all
users are allowed to run the script and output files are not created via sudo.

From the main menu you can navigate to the configuration and user editing
menus.  You will also be able to create the output files from the main menu.

During script execution, and when exiting, a data file is written to retain
data for future runs.

If you start this script as the superuser you will be able to change flags at
the configuration menu to prevent anyone but the superuser being able to use the
script, and whether or not sudo should be used during creation of the output
files.

Sudo support is there to enable SysAdmins working at a site with an AUP
requiring the use of sudo to be able to run the script directly from their user
shell without breaching that AUP.  You can of course run the script via sudo to
gain superuser access to its functions.



History
~~~~~~~
=========================================
 0.7 - 27 Mar 2006
-----------------------------------------

 Chris Lander <clander@labbs.com>

 Initial creation of script
