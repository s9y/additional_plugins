<?php # $Id$


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_smiletag extends serendipity_plugin
{
    var $title = PLUGIN_SMILETAG;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_SMILETAG);
        $propbag->add('description',   PLUGIN_SMILETAG_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '1.03');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('configuration', array('urlpath'));
        $propbag->add('groups', array('FRONTEND_FEATURES'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'urlpath':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_SMILETAG_URLPATH);
                $propbag->add('description', '');
                $propbag->add('default', $serendipity['baseURL'] . 'plugins/serendipity_plugin_smiletag/');
                break;

            default:
                    return false;
        }
        return true;
    }

    function example() {
        echo '<p>' . PLUGIN_SMILETAG_INSTALL . '</p>';
    }

    function generate_content(&$title)
    {
        global $serendipity;
?>
<script type="text/javascript" language="JavaScript">
<!--
	var smiletagURL = "<?php echo $this->get_config('urlpath'); ?>";
//-->
</script>
<script type="text/javascript" language="JavaScript" src="<?php echo $this->get_config('urlpath'); ?>/smiletag-script.js"></script>
<table border="0" cellpadding="0" cellspacing="0">
     <tr>
          <td valign="top" >
      	  <iframe name="iframetag" marginwidth="0" marginheight="0" src="<?php echo $this->get_config('urlpath'); ?>/view.php" width="98%" height="300">
			Your Browser must support IFRAME to view this page correctly
		  </iframe>
		  </td>
     </tr>
     <tr>
          <td>
  			<form name="smiletagform" method="post" action="<?php echo $this->get_config('urlpath'); ?>/post.php" target="iframetag"><br />
              <?php echo NAME; ?><br /><input type="text" name="name"/><br />
              <?php echo HOMEPAGE . '/' . EMAIL; ?><br /><input type="text" name="mail_or_url" value="http://" /><br />
              <?php echo COMMENT; ?><br /><textarea name="message_box" rows="3" cols="20"></textarea><br />
              <input type="hidden" name="message" value="" />
              <input type="submit" name="submit" value="<?php echo GO; ?>" onclick="clearMessage()" />
            </form>
	       </td>
        </tr>
</table>
<?php
    }
}

/* vim: set sts=4 ts=4 expandtab : */
