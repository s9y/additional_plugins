#!/usr/bin/perl
#
# English language file

debugmsg("lang_GB",3);


##################################
#                                #
#         !! WARNING !!          #
#                                #
#                                #
#   THE ORDER OF VARIABLES IN    #
#                                #
#    THIS FILE IS IMPORTANT      #
#                                #
#                                #
#   SOME MAY BE CONSTRUCTED BY   #
#                                #
# INCLUDING THE VALUES OF OTHERS #
#                                #
#                                #
#      !! EDIT WITH CARE !!      #
#                                #
##################################

#
# s9y_conf
#
$MUSTBEROOT = "You must be root to run this script";
$PROG_EXIT = "Goodbye...";
$PROGNAME_LONG = "S9Y Config Generator";
$PROGNAME_SHORT = "S9Y_CONF";

#
# write_data
#
$MAX_USERNUM_REACHED = "The maximum number of users al;ready exist";


#
# root_check
#
$ROOTPW_PROMPT = "Please enter the Superuser's Password";


#
# read_data
#
$READ_DATA_OPEN_ERROR = "Could not read from ".$S9Y_CONF_DATA."!";


#
# write_apachefile, write_s9y_install
#
$WRITE_DATA_OPEN_ERROR = "Could not open ".$S9Y_CONF_DATA." for writing!";
$WRITE_TEMP_OPEN_ERROR = "Can not wite to ">$GLOBALVARS{'tempfile'};

# write_apache_file
#
$APACHE_CONF_WRITE_SUCCESS = "Succesfully created ".$GLOBALVARS{'apacheconfigfile'};
$APACHE_CONF_WRITE_ERROR_1 = "WARNING: Unable to change permissions  on ".$GLOBALVARS{'apacheconfigfile'};
$APACHE_CONF_WRITE_ERROR_2 = "WARNING: Unable to create ".$GLOBALVARS{'apacheconfigfile'};
$APACHE_CONF_WRITE_ERROR_3 = "WARNING: sudo failed to create ".$GLOBALVARS{'apacheconfigfile'};
$APACHE_CONF_WRITE_ERROR_4 = "WARNING: sudo failed to chown root:root ".$GLOBALVARS{'apacheconfigfile'};
$APACHE_CONF_WRITE_ERROR_5 = "WARNING: sudo failed to chmod 0644 ".$GLOBALVARS{'apacheconfigfile'};

#
# write_s9y_install
#
$S9Y_SIS_TITLE = "Serendipity Shared Installation Script";
$S9Y_INSTALL_WRITE_SUCCESS = "Succesfully created ".$GLOBALVARS{'s9yinstallscript'};
$S9Y_INSTALL_WRITE_ERROR_1 = "WARNING: Unable to change permissions on ".$GLOBALVARS{'s9yinstallscript'};
$S9Y_INSTALL_WRITE_ERROR_2 = "WARNING: Unable to create ".$GLOBALVARS{'s9yinstallscript'};
$S9Y_INSTALL_WRITE_ERROR_3 = "WARNING: sudo failed to create ".$GLOBALVARS{'s9yinstallscript'};
$S9Y_INSTALL_WRITE_ERROR_4 = "WARNING: sudo failed to chown root:root ".$GLOBALVARS{'s9yinstallscript'};
$S9Y_INSTALL_WRITE_ERROR_5 = "WARNING: sudo failed to chmod 0744 ".$GLOBALVARS{'s9yinstallscript'};


#
# Menus
#
$MENU_HEAD = $PROGNAME_LONG." v".$GLOBALVARS{'version'}; # MUST be declared after $PROGNAME_LONG
$WAIT_MSG = "Push enter to continue";


# main_menu
$MM_TITLE = "Main Menu";
$MM_PROMPTA = "Option";
$MM_PROMPTB ="to exit";
$MM_1 = "Configuration";
$MM_2A = "Edit Users (";
$MM_2B = " on file)";
$MM_3 = "Create Apache Configuration File";
$MM_4 = "Create S9Y Install Script";

# config_menu
$CM_TITLE = "Configuration";
$CM_PROMPTA = "Option";
$CM_PROMPTB ="to exit";
$CM_L = "       Language";
$CM_1 = " Webserver User";
$CM_2 = "Webserver Group";
$CM_3 = "        Lib Directory";
$CM_4 = " Subdirectory for S9Y";
$CM_5 = "       Temporary File";
$CM_6 = "Apache Config File";
$CM_7 = "S9Y Install Script";
$CM_8 = "Bypass Root Check";
$CM_9 = "       Allow sudo";
$CM_9A = "          Command";
$CM_S = "Save changes";
$CM_D = "Discard changes";

$CM_EDIT_1 = "Webserver User";
$CM_EDIT_2 = "Webserver Group";
$CM_EDIT_3 = "Lib Directory";
$CM_EDIT_4 = "Subdirectory for S9Y";
$CM_EDIT_5 = "Temporary File";
$CM_EDIT_6 = "Apache Config File";
$CM_EDIT_7 = "S9Y Install Script";
$CM_EDIT_8 = "Bypass Root Check";
$CM_EDIT_9 = "Allow sudo";
$CM_EDIT_9A = "Command";

$CM_NOCHANGE = "unchanged.";
$CM_SAVE = "Configuration saved";
$CM_DISCARD = "Changes discarded";
$CM_ERROR_1 = "Please Enter Y or N";
$CM_ERROR_2 = "does NOT exist!";
$CM_ERROR_3 = "Can NOT write to";
$CM_ERROR_4 = "Temporary File and S9Y Install Script MUST be different";
$CM_ERROR_5 = "Temporary File and Apache Config File MUST be different";
$CM_ERROR_6 = "Apache Config File and S9Y Install Script MUST be different";
$CM_ERROR_7 = "Apache Config File and Temporary File MUST be different";
$CM_ERROR_8 = "S9Y Install Script and Apache Config File MUST be different";
$CM_ERROR_9 = "S9Y Install Script and Temporary File MUST be different";

# edit_menu
$EM_TITLE = "Edit Users";
$EM_PROMPTA = "Option";
$EM_PROMPTB ="to exit";

$EM_PAGE_1 = "Page";
$EM_PAGE_2 = "of";
$EM_PAGE_3 = "users in the system";

$EM_F = "First";
$EM_P = "Previous";
$EM_N = "Next";
$EM_L = "Last";
$EM_A = "Add User";
$EM_E = "Edit User";
$EM_D = "Delete User";
$EM_S = "Save Changes";
$EM_R = "Reset Changes";
$EM_1 = "UID";
$EM_2 = "          Name";
$EM_3 = "       Webroot";
$EM_4 = "Blog Directory";
$EM_5 = "  User Account";

$EM_EXIT_SAVE = "User data has changed do you want to save";
$EM_EDIT_1E = "Enter UID to edit";
$EM_EDIT_1D = "Enter UID to delete";
$EM_EDIT_2 = "Name";
$EM_EDIT_3 = "Webroot";
$EM_EDIT_4A = "Blog Directory";
$EM_EDIT_4B = "Delete Blog Directory";
$EM_EDIT_5 = "User Account";

$EM_SAVE = "Users saved";
$EM_NOTSAVED = "NO changes made";
$EM_DONTFORGET = "SAVE CHANGES TO COMMIT USERS TO FILE";

$EM_SUCCESS_ADD = "User add succesful (".$EM_DONTFORGET.")";
$EM_SUCCESS_EDIT = "User edit succesful (".$EM_DONTFORGET.")";
$EM_SUCCESS_DELETE = "User delete succesful (".$EM_DONTFORGET.")";

$EM_FAILURE_ADD = "User data NOT added";
$EM_FAILURE_EDIT = "User data NOT changed";
$EM_FAILURE_DELETE = "User data NOT Deleted";

$EM_ERROR_1 = "Maximum number of users already on file";
$EM_ERROR_2 = "No Name Entered";
$EM_ERROR_3 = "No Webroot Entered";
$EM_ERROR_4 = "No User Account Entered";
$EM_ERROR_5 = "User does NOT exist";
# This line is needed to satisfy require
1;
