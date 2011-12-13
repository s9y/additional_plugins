=================================================================================
s9y_conf
~~~~~~~
A BASH script to aid in the setup of Serendipity Blog (S9Y) in a shared
environment.

This script is released to the public domain under the GPL licence, it is free
to use without warranty.

Chris Lander - clander@labbs.com
=================================================================================

The default configuration allows ONLY the root user to succesfully run the script,
but system administrators may relax this requirement. In this case it is possible
to force final file creation via sudo, to retain some sanity over runaway users!


User data is entered into the body of the script, and when it is run two output
files are generated.  The first is an Apache style config file suitable for
inclusion in the Apache setup.  The second is a bash script that can be used to
copy files from the S9Y shared setup into the user directories, setting
permissions as neccessary.


Server setup is covered in server_config, where you can set the output file
names, the location of the S9Y installation, and the user/group that Apache runs
as.


Final output of the script can be configured by changing the statements in the
functions initialise_files, write_apache_config, write_s9y_install, and
finalise_files.


Sysadmins can relax superuser requirements by changing the flags in global_vars,
enabling the script to be run by all users.  Care should be taken when doing so
to ensure that output files are set with sane paths to avoid breaking system
functionality.  Sysadmins can set the script to use sudo for superuser powers,
which may be useful if your company AUP requires its use.
=================================================================================


History
~~~~~~~
=========================================
 0.6.1 - 23 Mar 2006
-----------------------------------------

 Chris Lander <clander@labbs.com>

 Addition of GPL licence
  addition of example files
 
=========================================
 0.6 - 11 Mar 2006
-----------------------------------------

 Chris Lander <clander@labbs.com>

 Addition of exit codes/messages
  more error trapping
  cleanup of temporary files
 
=========================================
 0.5 - 10 Mar 2006
-----------------------------------------

 Chris Lander <clander@labbs.com>

 Addition of variables for webserver user/group
 
=========================================
 0.4 - 9 Mar 2006
-----------------------------------------

 Chris Lander <clander@labbs.com>

 Minor Bugfixes and code tidying
 
=========================================
 0.3 - 9 Mar 2006
-----------------------------------------

 Chris Lander <clander@labbs.com>

 Addition of Root Check BYPASS and
  sudo control
 
=========================================
 0.2 - 9 Mar 2006
-----------------------------------------

 Chris Lander <clander@labbs.com>

 Addition of root user checks

=========================================
 0.1 - 8 Mar 2006
-----------------------------------------

 Chris Lander <clander@labbs.com>

 Initial creation of script
