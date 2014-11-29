<?php # $Id $

/* Contributed by Omid Mottaghi Rad (http://oxygenws.com/) */


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_quicklink extends serendipity_plugin
{
    var $title = PLUGIN_QUICKLINK_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_QUICKLINK_NAME);
        $propbag->add('description',   PLUGIN_QUICKLINK_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Omid Mottaghi Rad');
        $propbag->add('version',       '0.7.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('configuration', array('max_entries',
        									 'title',
        									 'delete',
        									 'submit',
        									 'timestamp',
        									 'show_tip',
        									 'is_public'));
        $propbag->add('groups', array('FRONTEND_FEATURES'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {

            case 'max_entries':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_QUICKLINK_MAXENTRIES);
                $propbag->add('description', PLUGIN_QUICKLINK_MAXENTRIES_BLAHBLAH);
                $propbag->add('default',     10);
                break;

            case 'title':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_QUICKLINK_TITLE);
                $propbag->add('description', PLUGIN_QUICKLINK_TITLE_BLAHBLAH);
                $propbag->add('default',     'Quick link');
                break;

            case 'delete':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_QUICKLINK_DELETE);
                $propbag->add('description', PLUGIN_QUICKLINK_DELETE_BLAHBLAH);
                $propbag->add('default',     DELETE);
                break;

            case 'submit':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_QUICKLINK_SUBMIT);
                $propbag->add('description', PLUGIN_QUICKLINK_SUBMIT_BLAHBLAH);
                $propbag->add('default',     'Send');
                break;

            case 'timestamp':
                $propbag->add('type', 'string');
                $propbag->add('name', GENERAL_PLUGIN_DATEFORMAT);
                $propbag->add('description', sprintf(GENERAL_PLUGIN_DATEFORMAT_BLAHBLAH, '%d-%m-%Y'));
                $propbag->add('default',     '%d-%m-%Y');
                break;

            case 'show_tip':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_QUICKLINK_SHOW_TIP);
                $propbag->add('description', PLUGIN_QUICKLINK_SHOW_TIP_BLAHBLAH);
                $propbag->add('default',     'true');
                break;

            case 'is_public':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_QUICKLINK_PUBLIC);
                $propbag->add('description', PLUGIN_QUICKLINK_PUBLIC_BLAHBLAH);
                $propbag->add('default',     'false');
                break;

            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title       = $this->get_config('title');
        $max_entries = $this->get_config('max_entries');
        $del_str     = $this->get_config('delete');
        $submit_str  = $this->get_config('submit');
        $timestamp   = $this->get_config('timestamp');
        $show_tip    = serendipity_db_bool($this->get_config('show_tip'));
        $is_public   = serendipity_db_bool($this->get_config('is_public'));

        // Create table, if not yet existant
        if ($this->get_config('version') != '0.3') {
            $q   = "CREATE TABLE {$serendipity['dbPrefix']}quicklink (
                        id {AUTOINCREMENT} {PRIMARY},
                        timestamp int(10) {UNSIGNED} NULL,
                        link varchar(255),
                        label varchar(255),
                        description text
                    )";
            @$sql = serendipity_db_schema_import($q);
            $this->set_config('version', '0.3');
        }

        //Put new link into the database if necessary
        if (($_SESSION['serendipityAuthedUser'] === true || $is_public === true) && !empty($_REQUEST['action']) && $_REQUEST['action'] == 'sendquicklink' && trim($_REQUEST['serendipity']['quicklink']) != '') {

            $sql =  sprintf(
                      "INSERT INTO %squicklink (
                            timestamp,
                            link,
                            label,
                            description
                       ) VALUES (
                            %s,
                            '%s',
                            '%s',
                            '%s'
                       )",

                    $serendipity['dbPrefix'],
                    time(),
                    serendipity_db_escape_string(trim($_REQUEST['serendipity']['quicklink'])),
                    serendipity_db_escape_string(trim($_REQUEST['serendipity']['quicklinklabel'])),
                    serendipity_db_escape_string(trim($_REQUEST['serendipity']['quicklinkdesc'])));

            serendipity_db_query($sql);
        }

        if (!$max_entries || !is_numeric($max_entries) || $max_entries < 1) {
            $max_entries = 15;
        }

        // if a delete link clicked!
        if (!empty($serendipity['GET']['action']) && $serendipity['GET']['action'] == 'quicklinkdelete'
          && $_SESSION['serendipityAuthedUser'] === true && $serendipity['serendipityUserlevel'] >= USERLEVEL_CHIEF) {
            $sql  = sprintf("DELETE from %squicklink
                              WHERE id = %d",
                                    $serendipity['dbPrefix'],
                                    (int)$serendipity['GET']['link_id']);
            serendipity_db_query($sql);
        }

        // if start is set
        if (!empty($serendipity['GET']['start'])) {
        	$start = (int) $serendipity['GET']['start'];
        } else {
        	$start = 0;
        }

        $next = $start+$max_entries;
        $prev = $start-$max_entries;

        // disable previous link if needed
        if($prev < 0){
        	$prev = false;
        }

        $q = 'SELECT    count(*) AS count
                FROM    '.$serendipity['dbPrefix'].'quicklink';

        $sql = serendipity_db_query($q);

        // disable next link if needed
        if($next >= $sql[0]['count']){
        	$next = false;
        }

        if ($_SESSION['serendipityAuthedUser'] === true || $is_public === true) {
       ?>

       <form action="<?php echo serendipity_currentURL(); ?>" method="post">
            <div>
                <input type="hidden" name="action" value="sendquicklink" />
                <input type="text" name="serendipity[quicklinklabel]" style="width: 90%" value="<?php echo PLUGIN_QUICKLINK_LABEL; ?>" onclick="if(this.value='<?php echo PLUGIN_QUICKLINK_LABEL; ?>') this.value=''" />
                <input type="text" name="serendipity[quicklink]" style="width: 90%" value="http://" dir="ltr" />
                <textarea name="serendipity[quicklinkdesc]" cols="15" rows="2" style="width: 90%"></textarea>
                <input name='submit' type='submit' value='<?php echo $submit_str; ?>' />
            </div>
        </form><br />
<?php
        }
?>
<div id="quick_link_tip" style="position:absolute; visibility: hidden"></div>
<script language="JavaScript"><!--

var toolTipSTYLE="";
function initToolTips()
{
  toolTipSTYLE = document.getElementById("quick_link_tip").style;
  toolTipSTYLE.visibility = "visible";
  toolTipSTYLE.display = "none";
  document.onmousemove = moveToMouseLoc;
}
function toolTip(msg, bg)
{
  if(toolTip.arguments.length < 1) //hide
  {
	toolTipSTYLE.display = "none";
  }
  else // show
  {
    if(!bg) bg = "#FFFFFF";
    var content =
    '<table border="1" cellspacing="0" cellpadding="0" bgcolor="' + bg +
    '"><td><font size="-1">&nbsp\;' + msg +
    '&nbsp\;</font></td></table>';
    document.getElementById("quick_link_tip").innerHTML = content;
    toolTipSTYLE.display='block'
  }
}
function moveToMouseLoc(e)
{
  if (e && e.pageX) {
    x = e.pageX;
    y = e.pageY;
    toolTipSTYLE.left = x + 0 + 'px';
    toolTipSTYLE.top = y + 20 + 'px';
  }
  return true;
}
initToolTips();
//--></script>
<div style="margin: 0px; padding: 0px; text-align: left;">
<?php
		$q = 'SELECT    s.description       AS description,
						s.link              AS link,
						s.label             AS label,
                        s.timestamp         AS stamp,
                        s.id                AS link_id
              FROM    '.$serendipity['dbPrefix'].'quicklink AS s
              ORDER BY    s.timestamp DESC
              ' . serendipity_db_limit_sql(serendipity_db_limit($start, $max_entries));

        $sql = serendipity_db_query($q);

        if ($sql && is_array($sql)) {
            foreach($sql AS $key => $row) {

                if (!preg_match('@^https?://@', trim($row['link']))) {
                    $row['link'] = 'http://' . $row['link'];
                }
                $row['link'] = str_replace('javascript:', '', $row['link']);
                
            	// create tool tip string
            	$tip = '';
            	if($show_tip == 'true'){
            		$tip = (function_exists('serendipity_specialchars') ? serendipity_specialchars(serendipity_strftime($timestamp, $row['stamp'])) : htmlspecialchars(serendipity_strftime($timestamp, $row['stamp']), ENT_COMPAT, LANG_CHARSET));
            		if( trim($row['description']) != ''){
            			$tip .= '<br />' . nl2br((function_exists('serendipity_specialchars') ? serendipity_specialchars($row['description']) : htmlspecialchars($row['description'], ENT_COMPAT, LANG_CHARSET)));
            		}
            		$tip = ' onMouseOver="toolTip(\'' . $tip . '\')" onMouseOut="toolTip()"';
            	}

            	// create label of link
            	if(trim($row['label']) == '' || $row['label'] == PLUGIN_QUICKLINK_LABEL){
            		$label = $row['link'];
            	}else{
            		$label = $row['label'];
            	}

            	// create link string
                $link = '<a href="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($row['link']) : htmlspecialchars($row['link'], ENT_COMPAT, LANG_CHARSET)) . '"' . $tip . ' target="_blank">' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($label) : htmlspecialchars($label, ENT_COMPAT, LANG_CHARSET)) . '</a>';

                // create telete link string
                $deleteLink = '';
                if ($_SESSION['serendipityAuthedUser'] === true && $serendipity['serendipityUserlevel'] >= USERLEVEL_CHIEF) {
                    $deleteLink =  ' | <a href="' . $serendipity['baseURL'] . $serendipity['indexFile']
                                  . '?serendipity[action]=quicklinkdelete&amp;serendipity[link_id]='
                                  . $row['link_id'] . '" onclick="return confirm(\'' . PLUGIN_QUICKLINK_ALERT . '\');">' . $del_str . '</a>';
                }
                $entry = array('link' => $link);
                serendipity_plugin_api::hook_event('frontend_display', $entry);

                echo $entry['link']
                     . $deleteLink
                     . '<br />' . "\n\n";
            }
        }

        if($prev !== false || $next !== false){
        	if($prev !== false){
	        	echo '<br /><div align="center"><a href="' . $serendipity['baseURL'] . $serendipity['indexFile'] . '?serendipity[start]='
	                                  . $prev . '">' . PREVIOUS . '</a> | ';
	        }else{
	        	echo '<br /><div align="center">' . PREVIOUS . ' | ';
	        }

	        if($next !== false){
	        	echo '<a href="' . $serendipity['baseURL'] . $serendipity['indexFile'] . '?serendipity[start]='
	                                  . $next . '">' . NEXT . '</a></div><br />' . "\n";
	        }else{
	        	echo NEXT . '</div><br />' . "\n";
	        }
        }
?>
</div>
<?php
    }
}

/* vim: set sts=4 ts=4 expandtab : */
