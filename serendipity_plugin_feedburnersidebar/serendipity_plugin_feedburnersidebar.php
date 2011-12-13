<?php 
# Copyright by Aaron Axelsen
# Modevia Web Services - http://www.modevia.com
# axelseaa [at] modevia [dot] com

if (IN_serendipity !== true) {
	die("Don't Hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

@define('PLUGIN_FEEDBURNERSIDEBAR_TITLE',   'Feedburner Sidebar');
@define('PLUGIN_FEEDBURNERSIDEBAR_TITLE_DESC',   '');
@define('PLUGIN_FEEDBURNERSIDEBAR_NAME',   'Feedburner Sidebar');
@define('PLUGIN_FEEDBURNERSIDEBAR_DESC',   'Adds assorted functionality of the feedburner service into the sidebar.');

class serendipity_plugin_feedburnersidebar extends serendipity_plugin {
    var $title = PLUGIN_FEEDBURNERSIDEBAR_NAME;

    function introspect(&$propbag) {
        $this->title = $this->get_config('title', $this->title);

        $propbag->add('name',          PLUGIN_FEEDBURNERSIDEBAR_NAME);
        $propbag->add('description',   PLUGIN_FEEDBURNERSIDEBAR_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Aaron Axelsen');
        $propbag->add('version',       '1.0');
        $propbag->add('requirements',  array(
            'serendipity' => '1.2.1',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
	$propbag->add('configuration', array('title', 'feedid', 'feedaddress', 'email_subscribe', 'email_title', 'feedflare'));
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;

        switch($name) {
		case 'title':
			$propbag->add('type',        'string');
			$propbag->add('name',        FEEDBURNERSIDEBAR_TITLE);
			$propbag->add('description', FEEDBURNERSIDEBAR_TITLE_DESC);
			$propbag->add('default',     'Feedburner');
			break;
		case 'feedid':
			$propbag->add('type',        'string');
			$propbag->add('name',        FEEDBURNERSIDEBAR_FEEDID);
			$propbag->add('description', FEEDBURNERSIDEBAR_FEEDID_DESC);
			$propbag->add('default',     '');
			break;
		case 'feedaddress':
			$propbag->add('type',        'string');
			$propbag->add('name',        FEEDBURNERSIDEBAR_FEEDADDRESS);
			$propbag->add('description', FEEDBURNERSIDEBAR_FEEDADDRESS_DESC);
			$propbag->add('default',     'YOURFEEDNAMEHERE');
			break;
		case 'email_subscribe':
			$propbag->add('type',	     'radio');
			$propbag->add('name',	     FEEDBURNERSIDEBAR_EMAIL_SUBSCRIBE);
			$propbag->add('description', FEEDBURNERSIDEBAR_EMAIL_SUBSCRIBE_DESC);
			$propbag->add('default','none');
			$propbag->add('radio', array(
				'value' => array('link','form','none'),
				'desc' => array(FEEDBURNERSIDEBAR_EMAIL_SUBSCRIBE_LINK,
					FEEDBURNERSIDEBAR_EMAIL_SUBSCRIBE_FORM,
					FEEDBURNERSIDEBAR_EMAIL_SUBSCRIBE_NONE)
			));
			$propbag->add('radio_per_row','1');
			break;
		case 'email_title':
			$propbag->add('type',        'string');
			$propbag->add('name',        FEEDBURNERSIDEBAR_EMAIL_TITLE);
			$propbag->add('description', FEEDBURNERSIDEBAR_EMAIL_TITLE_DESC);
			$propbag->add('default',     'Subscribe to blog updates by email!');
			break;
		default:
			return false;
		}		
		return true;
	}

	function generate_content(&$title) {
		global $serendipity;
		$title = $this->get_config('title');
		$feedid = $this->get_config('feedid');
	if (empty($feedid) || !is_numeric($feedid)) {
		echo "<p style='color:red;font-weight: bold;'>Numeric Feedburner ID Required!</p>";
  	} else {
		$emailTitle = $this->get_config('email_title');
		$rv = array();

		$emailSubscribe = $this->get_config('email_subscribe');
		switch($emailSubscribe) {
			case 'none':
				break;
			case 'link':
				$rv[] = '<a href="http://www.feedburner.com/fb/a/emailverifySubmit?feedId='.$feedid.'&amp;loc=en_US" target="_blank">'.$emailTitle.'</a>';
				break;
			case 'form':
				$rv[] = '<form action="http://www.feedburner.com/fb/a/emailverify" 
					method="post" target="popupwindow" onsubmit="window.open(\'http://www.feedburner.com/fb/a/emailverifySubmit?feedId='.$feedid.'\',
					 \'popupwindow\', \'scrollbars=yes,width=550,height=520\');return true">';
				$rv[] = '<p><label for="email">Enter your email address:</label></p>';
				$rv[] = '<p><input type="text" style="width:140px" name="email" id="email" /></p>';
				$rv[] = '<input type="hidden" value="http://feeds.feedburner.com/~e?ffid='.$feedid.'" name="url"/>';
				$rv[] = '<input type="hidden" name="loc" value="en_US"/>';
				$rv[] = '<input type="submit" value="Subscribe" />';
				$rv[] = '</form>';
				break;
		}
		echo implode("\n",$rv);
	}
    }

}
/* vim: set sts=4 ts=4 expandtab : */
?>
