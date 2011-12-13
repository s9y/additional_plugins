#!/bin/bash
#
# s9y_conf.sh
#
# S9Y config generator
#
# Exit code returned:-
#	 0 --- Execution completed succesfully
#	 1 --- User running script NOT root
#	 2 --- User aborted
#	 3 --- Unable to create $APACHECONFIGFILE
#	 4 --- Unable to create $APACHECONFIGFILE AND unable to remove temporary file $TEMPFILE1
#	 5 --- Unable to create $APACHECONFIGFILE AND unable to remove temporary file $TEMPFILE2
#	 6 --- Unable to create $APACHECONFIGFILE AND unable to remove temporary file $TEMPFILE1 AND $TEMPFILE2
#	 7 --- Unable to create $S9YINSTALLSCRIPT
#	 8 --- Unable to create $S9YINSTALLSCRIPT and unable to remove $TEMPFILE2
#	 9 --- Unable to create $TEMPFILE1
#	10 --- Unable to chmod $TEMPFILE1
#	11 --- Unable to create $TEMPFILE2
#	12 --- Unable to chmod $TEMPFILE2
#	99 --- ABNORMAL EXIT !! (should never happen [touches wood hurriedly])
#
#=========================================
# 0.6.1 - 23 Mar 2006
#-----------------------------------------
#
# Chris Lander <clander@labbs.com>
#
# Addition of GPL licence
#  addition of example files
#  webserver user/group moved to server_config
# 
#=========================================
# 0.6 - 11 Mar 2006
#-----------------------------------------
#
# Chris Lander <clander@labbs.com>
#
# Addition of exit codes/messages
#  more error trapping
#  cleanup of temporary files
# 
#=========================================
# 0.5 - 10 Mar 2006
#-----------------------------------------
#
# Chris Lander <clander@labbs.com>
#
# Addition of variables for webserver user/group
# 
#=========================================
# 0.4 - 9 Mar 2006
#-----------------------------------------
#
# Chris Lander <clander@labbs.com>
#
# Minor Bugfixes and code tidying
# 
#=========================================
# 0.3 - 9 Mar 2006
#-----------------------------------------
#
# Chris Lander <clander@labbs.com>
#
# Addition of Root Check BYPASS and
#  sudo control
# 
#=========================================
# 0.2 - 9 Mar 2006
#-----------------------------------------
#
# Chris Lander <clander@labbs.com>
#
# Addition of root user checks
#
#=========================================
# 0.1 - 8 Mar 2006
#-----------------------------------------
#
# Chris Lander <clander@labbs.com>
#
# Initial creation of script
#


# user_data
#
# Data sets for the individual S9Y installations
function user_data {

	#
	# !! ADD YOUR USERS HERE !!
	#
	# add_user "Friendly name for user" "Users Webroot" "Blog Subdirectory (if any) of Users Webroot" "local user that owns Blog directory"
	#
	# e.g.
	# Local User that has their blog in a subdirectory of their user webroot
	# add_user "Local User" "/home/localuser/public_html" "blog" "localuser" 
	#
	# Virtual hosting (i.e. user.foo.bar) that has the blog in their webroot
	# add_user "Virtual Host user.foo.bar" "/srv/www/vhosts/bar/foo/user" "" "root" 

	# Local User that has their blog in a subdirectory of their user webroot
	 add_user "Local User" "/home/localuser/public_html" "blog" "localuser" 
	
	# Virtual hosting (i.e. user.foo.bar) that has the blog in their webroot
	 add_user "Virtual Host user.foo.bar" "/srv/www/vhosts/bar/foo/user" "" "root" 
}

# server_config
#
# Server config parameteers such as base directory of Shared install
#  Config files the script creates, user/group the webserver runs as,
#  Whether strict checking is performed to allow only root to execute
#  the script, or if sudo should be used to execute commands as root.
function server_config {
	#
	# S9Y Installation variables
	#
	
	# S9Y Shared Installation Base Directories
	LIBDIR="/usr/local/lib/php"			# Base library directory
	S9YDIR="s9y"					# Subdirectory of library directory for S9Y

	# Configuration files
	APACHECONFIGFILE="./s9y_apache.conf"		# Apache style config file
	S9YINSTALLSCRIPT="./s9y_install_shared.sh"	# S9Y shared installation script

	# Webserver user/group
	WEBSERVERUSER="wwwrun"				# User the webserver runs as
	WEBSERVERGROUP="www"				# Group the webserver runs under
}

# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
# !! NON USER CONFIGURABLE DATA BELOW !!
# !!                                  !!
# !!   SYSTEMS ADMINISTRATORS ONLY    !!
# !!                                  !!
# !!        * EDIT WITH CARE *        !!
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

#
# Main program
#
function main {

	global_vars					# Set global variables
	server_config					# Set user configurations
	user_data					# Set S9Y installation data
	echo ""
	echo "S9Y config generator v$VERSION"
	echo "Author: Chris Lander <webmaster@labbs.com> 9 Mar 2006"
	echo ""

	# Since this script copies files and directories, and makes use of chmod and chown
	#  it is possibly only suited for root usage!
	#
	#
	# check if we are started as root
	# only one of UID and USER must be set correctly
	if test "$UID" != "0" -a "$USER" != root -a -z "$ROOT" ; then
		if test "$BYPASSROOT" = 0 ; then
			echo "This script is intended for SysAdmin usage !!"
			echo ""
			echo "You must be root to start $0."
			goodbye 1
		else
			echo "This script will create $APACHECONFIGFILE and $S9YINSTALLSCRIPT !!"
			echo ""
			KEY=""
			while [ "X$KEY" = "X" ]; do
				KEY=""
				KEYS=$YESNO
				PROMPT="Are you sure you want to continue? (Y/N)"
				get_input
			done
			if [ "$KEY" = "N" ] || [ "$KEY" = "n" ]; then
				echo ""
				goodbye 2
			fi
			if [ "$SUDO" = "1" ]; then
				echo ""
				echo ""
				echo "The root password WILL be required !!"
				echo ""
				KEY=""
				while [ "X$KEY" = "X" ]; do
					KEY=""
					KEYS=$YESNO
					PROMPT="Are you sure you want to continue? (Y/N)"
					get_input
				done
				if [ "$KEY" = "N" ] || [ "$KEY" = "n" ]; then
					echo ""
					goodbye 2
				fi
			fi
		fi
	fi

	echo ""
	echo ""
	KEY=""
	while [ "X$KEY" = "X" ]; do
		KEY=""
		KEYS=$YESNO
		PROMPT="Create new configuration files? (Y/N)"
		get_input
	done
	if [ "$KEY" = "N" ] || [ "$KEY" = "n" ]; then
		echo ""
		goodbye 2
	fi
	echo ""
	echo ""

	initialise_files
	make_config
	finalise_files
	
	goodbye 0
}

# get_input
#
# Routine to trap user input
function get_input {

		local GOTKEY="0"
		local I="0"
		while [ "$GOTKEY" = "0" ]
		do
			read -n1 -p "$PROMPT" KEY
			for I in $KEYS 
			do
				if [ "$I" = "$KEY" ]; then
					return
				fi
			done
		done

}

# add_user
#
# add user info to array as:-
# 	$1 - Friendly name for this setup
# 	$2 - This site's Webroot
# 	$3 - Subdirectory to Blog from site's Webroot
# 	$4 - local system user who owns this Blog directory
function add_user {
    local OFFSET=`expr $USER_ID \* 4`
    USER_ARRAY[$OFFSET]="$1"
    USER_ARRAY[`expr $OFFSET + 1`]="$2"
    USER_ARRAY[`expr $OFFSET + 2`]="$3"
    USER_ARRAY[`expr $OFFSET + 3`]="$4"
    USER_ID=`expr $USER_ID + 1`
}

# initialise_files
#
# Initialise config files with headers
#
function initialise_files {

touch $TEMPFILE1 &>/dev/null
if [ $? != 0 ]; then
	goodbye 9
fi

chmod u+rw $TEMPFILE1 &>/dev/null
if [ $? != 0 ]; then
	goodbye 10
fi

touch $TEMPFILE2 &>/dev/null
if [ $? != 0 ]; then
	goodbye 11
fi

chmod u+rwx $TEMPFILE2 &>/dev/null
if [ $? != 0 ]; then
	goodbye 12
fi

#
# Header for Apache Config File
#
echo "# $APACHECONFIGFILE
#
#
# Suggested S9Y Apache configuration
#
# S9Y config generator v$VERSION
#
# "`date`"
" > $TEMPFILE1

#
# Header for S9Y Install Script
#
echo "#!/bin/bash
#
# $S9YINSTALLSCRIPT
#
# Serendipity Shared Installation script
#
# S9Y config generator v$VERSION
#
# "`date`"
" > $TEMPFILE2

}

# write_apache_config
#
# $1 Users Name
# $2 Users Web Directory
# $3 Subdirectory for  Blog
#
# Writes Apache2 config file
#
function write_apache_config {

local WEBDIR="$2"
local BLOGDIR=""

if [ "$3" = "" ]; then
    BLOGDIR="$2"
else
    BLOGDIR="$2/$3"
fi

echo "#
# $1
#
<Directory \"$BLOGDIR\">
 AllowOverride All
 php_value include_path \".:$LIBDIR:$LIBDIR/$S9YDIR/:$LIBDIR/$S9YDIR/bundled-libs/:$BLOGDIR/\"
 php_admin_value open_basedir \"$LIBDIR:$LIBDIR/$S9YDIR/:$BLOGDIR/:/usr/bin/\"
 php_admin_value post_max_size \"10M\"
 php_admin_value upload_max_filesize \"10M\"
</Directory>
">> $TEMPFILE1

}

# write_s9y_install
#
# $1 Users Name
# $2 Users Web Directory
# $3 Subdirectory for  Blog
#
# Writes S9Y Install Script
#
function write_s9y_install {

local WEBDIR="$2"

if [ "$3" = "" ]; then
    local BLOGDIR="$2"
else
    local BLOGDIR="$2/$3"
fi

echo "#
# $1
#
cp -r $LIBDIR/$S9YDIR/deployment/* $BLOGDIR
cp -r $LIBDIR/$S9YDIR/templates $BLOGDIR/
cp -r $LIBDIR/$S9YDIR/htmlarea $BLOGDIR/
chown -R $4:$WEBSERVERGROUP $BLOGDIR
chown -R $4:$WEBSERVERGROUP $BLOGDIR/*
chmod u+rwx,g+rwx $BLOGDIR
chmod u+rwx,g+rwx $BLOGDIR/{templates_c,uploads,archives}
chown $WEBSERVERUSER:$WEBSERVERGROUP $BLOGDIR/serendipity_config_local.inc.php
chmod u+rwx,g-rwx,o-rwx $BLOGDIR/serendipity_config_local.inc.php
" >> $TEMPFILE2

}

function finalise_files {

	$COMMANDPREFIX mv $TEMPFILE1 $APACHECONFIGFILE &>/dev/null
	if [ $? != 0 ]; then
		rm $TEMPFILE1 &>/dev/null
		if [ $? != 0 ]; then
			rm $TEMPFILE2 &>/dev/null
			if [ $? != 0 ]; then
				goodbye 6
			fi
			goodbye 4
		fi
		rm $TEMPFILE2 &>/dev/null
		if [ $? != 0 ]; then
			goodbye 5
		fi
		goodbye 3
	fi
	
	$COMMANDPREFIX mv $TEMPFILE2 $S9YINSTALLSCRIPT &>/dev/null
	if [ $? != 0 ]; then
		rm $TEMPFILE2 &>/dev/null
		if [ $? != 0 ]; then
			goodbye 8
		fi
		goodbye 7
	fi

	$COMMANDPREFIX chmod u+rw,g-rwx,o-rwx $APACHECONFIGFILE &>/dev/null
	if [ $? != 0 ]; then
		echo "Unable to chmod $APACHECONFIGFILE"
	fi

	$COMMANDPREFIX chown $MYUSER:$MYGROUP $APACHECONFIGFILE &>/dev/null
	if [ $? != 0 ]; then
		echo "Unable to chown $APACHECONFIGFILE"
	fi

	$COMMANDPREFIX chmod u+rw,g-rwx,o-rwx $S9YINSTALLSCRIPT &>/dev/null
	if [ $? != 0 ]; then
		echo "Unable to chmod $S9YINSTALLSCRIPT"
	fi

	$COMMANDPREFIX chown $MYUSER:$MYGROUP $S9YINSTALLSCRIPT &>/dev/null
	if [ $? != 0 ]; then
		echo "Unable to chown $S9YINSTALLSCRIPT"
	fi

}


# make_config
#
# Writes S9Y Install Script
#
function make_config {
	local I=0
	local OFFSET=0
	local NAME=""
	local WEBROOT=""
	local SUBDIR=""
	local USER=""
	while [ "$I" -lt "$USER_ID" ]
	do
		OFFSET=`expr $I \* 4`
		NAME=${USER_ARRAY[$OFFSET]}
		WEBROOT=${USER_ARRAY[`expr $OFFSET + 1`]}
		SUBDIR=${USER_ARRAY[`expr $OFFSET + 2`]}
		USER=${USER_ARRAY[`expr $OFFSET + 3`]}
		I=`expr $I + 1`
		echo "Creating configuration for $NAME"
		echo "            Webroot: $WEBROOT"
		echo "  Blog Subdirectory: $SUBDIR"
		echo " Local user account: $USER"
		echo ""
		write_apache_config "$NAME" "$WEBROOT" "$SUBDIR" "$USER"
		write_s9y_install "$NAME" "$WEBROOT" "$SUBDIR" "$USER"
	done
}

# goodbye
#
# Exits the program with suitable success/failure messages
function goodbye {
	echo ""
	echo ""

	case "$1" in

		"0" )
			echo ""
			echo ""
			echo "Configuration files created:-"
			echo ""
			echo "        APACHE: $APACHECONFIGFILE"
			echo "       INSTALL: $S9YINSTALLSCRIPT"
			echo ""
			echo ""
		;;
	
		"1" )
			echo "Please run this script as root, no configuration files created"
		;;
	
		"2" )
			echo "User aborted, no configuration files created"
		;;

		"3" )
			echo "Execution Interrupted !!"
			echo ""
			echo "Unable to create $APACHECONFIGFILE"
		;;
	
		"4" )
			echo "Execution Interrupted !!"
			echo ""
			echo "Unable to create $APACHECONFIGFILE and unable to remove $TEMPFILE1"
		;;

		"5" )
			echo "Execution Interrupted !!"
			echo ""
			echo "Unable to create $APACHECONFIGFILE and unable to remove $TEMPFILE2"
		;;

		"6" )
			echo "Execution Interrupted !!"
			echo ""
			echo "Unable to create $APACHECONFIGFILE and unable to remove $TEMPFILE1 and $TEMPFILE2"
		;;

		"7" )
			echo "Execution Interrupted !!"
			echo ""
			echo "Unable to create $S9YINSTALLSCRIPT"
		;;

		"8" )
			echo "Execution Interrupted !!"
			echo ""
			echo "Unable to create $S9YINSTALLSCRIPT and unable to remove $TEMPFILE2"
		;;

		"9" )
			echo "Execution Interrupted !!"
			echo ""
			echo "Unable to create $TEMPFILE1"
		;;
	
		"10" )
			echo "Execution Interrupted !!"
			echo ""
			echo "Unable to chmod $TEMPFILE1"
		;;
	
		"11" )
			echo "Execution Interrupted !!"
			echo ""
			echo "Unable to create $TEMPFILE2"
		;;
	
		"12" )
			echo "Execution Interrupted !!"
			echo ""
			echo "Unable to chmod $TEMPFILE2"
		;;

	esac	
	echo ""
	sudo -K				# Ensure sudo password not cached !
	exit $1
}

# global_vars
#
# Set global variables
function global_vars {

	VERSION="0.6.1"					# Program version number
	USER_ID=0					# User counter
	YESNO="Y y N n"					# Array used for Y/N input
	TEMPFILE1="s9y_temp1.txt"				# Temorary work file
	TEMPFILE2="s9y_temp2.txt"				# Temorary work file
	MYUSER=$UID					# UID of user invoking script
	MYGROUP=$GROUPS					# GID of user invoking script


	# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	# !!   SYSTEMS ADMINISTRATORS ONLY    !!
	# !!                                  !!
	# !!        * EDIT WITH CARE *        !!
	# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

	# !! ?? BYPASS CHECK FOR ROOT ACCESS IN THIS SCRIPT ?? !!
	BYPASSROOT=0					# Bypass root check ?

	# !! ?? SHOULD sudo (to root) BE ALLOWED FOR THIS SCRIPT ?? !!
	#
	# N.B. The SUDO setting will have no effect of BYPASSROOT is set false
	SUDO=0						# Allow sudo ?
	if [ "$SUDO" = "1" ]; then
		sudo -K					# Ensure sudo password not cached !
		COMMANDPREFIX="sudo -H"
		MYUSER=0				# We are using sudo so files created
		MYGROUP=0				# need to be owned by root
	else
		COMMANDPREFIX=""
	fi

}

main

goodbye 0						# IF WE GET HERE THEN A MAJOR OVERSIGHT HAS OCCURED
sudo -K							# Ensure sudo password NOT cached
exit 99							# Make certain we exit. ;-)
#
# [EOF] - s9y_conf.sh - S9Y config generator
#
