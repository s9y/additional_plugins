<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_spamblock_surbl extends serendipity_event
{
  var $filter_defaults;

  function introspect(&$propbag)
  {
    global $serendipity;

    $this->title = PLUGIN_EVENT_SPAMBLOCKSURBL_TITLE;

    $propbag->add('name',          PLUGIN_EVENT_SPAMBLOCKSURBL_TITLE);
    $propbag->add('description',   PLUGIN_EVENT_SPAMBLOCKSURBL_DESC);
    $propbag->add('stackable',     false);
    $propbag->add('author',        'Sebastian Nohn');
    $propbag->add('requirements',  array(
					 'serendipity' => '0.8',
					 'php'         => '4.1.0'
					 ));
    $propbag->add('version',       '1.2.1');
    $propbag->add('event_hooks',    array(
					  'frontend_saveComment' => true
					  ));
    $propbag->add('groups', array('ANTISPAM'));

      $propbag->add('legal',    array(
          'services' => array(
              'surbl' => array(
                  'url'  => '#',
                  'desc' => 'Checks submitted comment URLs through the SURBL BL'
              ),
          ),
          'frontend' => array(
              'Comment URLs are checked by the SURBL BL, entered URLs are passed through that service',
          ),
          'backend' => array(
          ),
          'cookies' => array(
          ),
          'stores_user_input'     => false,
          'stores_ip'             => false,
          'uses_ip'               => false,
          'transmits_user_input'  => true
      ));

  }

  function generate_content(&$title) {
    $title = $this->title;
  }

  function event_hook($event, &$bag, &$eventData, $addData = null) {
    global $serendipity;

    $hooks = &$bag->get('event_hooks');

    if (isset($hooks[$event])) {
      switch($event) {


      case 'frontend_saveComment':
	if (!is_array($eventData) || serendipity_db_bool($eventData['allow_comments'])) {
	  // Check for IP listed in SURBL
	  if (serendipity_db_bool($this->get_config('surbl_enabled', false))) {
	    require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : 'bundled-libs/') . 'Net/DNSBL/SURBL.php';
	    $surbl = new Net_DNSBL_SURBL();
	    if ($surbl->isListed($addData['url'])) {
	      $this->log($logfile, $eventData['id'], 'REJECTED', PLUGIN_EVENT_SPAMBLOCK_REASON_SURBL, $addData);
	      $eventData = array('allow_comments' => false);
	      $serendipity['messagestack']['comments'][] = PLUGIN_EVENT_SPAMBLOCK_ERROR_SURBL;
	      return false;
	    }
	    // BEGIN Code copied from http://www.phpfreaks.com/quickcode/Extract_All_URLs_on_a_Page/15.php
	    $urls = '(http|file|ftp)';
	    $ltrs = '\w';
	    $gunk = '/#~:.?+=&%@!\-';
	    $punc = '.:?\-';
	    $any = "$ltrs$gunk$punc";
	    preg_match_all("{
                              \b
                              $urls   :
                              [$any] +?


                              (?=
                                 [$punc] *
                                 [^$any]
                                |
                                 $
                               )
                             }x", $addData['comment'], $matches);
	    // END Code copied from http://www.phpfreaks.com/quickcode/Extract_All_URLs_on_a_Page/15.php
	    foreach ($matches[0] as $surbl_check_url) {
	      if ($surbl->isListed($surbl_check_url)) {
		$eventData = array('allow_comments' => false);
		$serendipity['messagestack']['comments'][] = PLUGIN_EVENT_SPAMBLOCK_ERROR_SURBL;
		return false;
	      }
	    }
	  }
	}
	return true;
	break;


      default:
	return false;
	break;
      }
    } else {
      return false;
    }
  }
}


/* vim: set sts=4 ts=4 expandtab : */
?>
