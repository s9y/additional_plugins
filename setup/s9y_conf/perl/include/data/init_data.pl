#!/usr/bin/perl
#
# Initialise data arrays with default values
sub init_data {

	debugmsg("sub init_data",3);

	#Global variables array
	%GLOBALVARS = (
		'version'		=> "$VERSION"
		,'bypassroot'		=> 'Y'
		,'sudo'			=> 'N'
		,'commandprefix'	=> "sudo -H -p 'Enter SuperUser Password: '"
		,'language'		=> 'GB'
		,'tempfile'		=> 's9y_conf.temp'
		,'libdir'		=> '/usr/local/lib/php'
		,'s9ydir'		=> 's9y'
		,'apacheconfigfile'	=> './s9y_apache.conf'
		,'s9yinstallscript'	=> './s9y_install_shared.sh'
		,'webserveruser'		=> 'wwwrun'
		,'webservergroup'	=> 'www'
	);

	#Userdata array
	%USERDATA = (
		'001'	=> ['Local User','/home/local/public_html','blog','local']
		,'002'	=> ['Vhost user.foo.bar','/srv/www/vhosts/bar/foo/user','','user']
		,'027'	=> ['Local User2','/home/local2/public_html','blog','local2']
		,'004'	=> ['Local User3','/home/local3/public_html','blog','local3']
		,'015'	=> ['Vhost user37.foo.bar','/srv/www/vhosts/bar/foo/user37','','user37foobar']
		,'006'	=> ['Vhost www.bar.foo','/srv/www/vhosts/foo/bar/www','','wwwbarfoo']
		,'019'	=> ['Vhost user19.foo.bar','/srv/www/vhosts/bar/foo/user19','','foobaruser19']
	#	,'ID'	=> ['Name','WebRoot','BlogDir','user']
	);

	# Write data to file
	&write_data;

return(0);
}

# This line is needed to satisfy require
1;
