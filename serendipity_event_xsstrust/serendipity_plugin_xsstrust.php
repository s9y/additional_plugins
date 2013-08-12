<?php # 

/* Author: Nicola Zanoni, (nicola.zanoni@gmail.com) */



if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_xsstrust extends serendipity_plugin
{
    var $title = PLUGIN_ETHICS_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_ETHICS_NAME);
        $propbag->add('description',   PLUGIN_ETHICS_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Loris Zena');
        $propbag->add('version',       '1.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('configuration', array(
                                             'base_val'
                                             ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'base_val':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_ETHICS_BASEVAL);
                $propbag->add('description', PLUGIN_ETHICS_BASEVAL_BLAHBLAH);
                $propbag->add('default',     1);
                break;

            default:
                    return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title    = $this->title;
        $base_val = $this->get_config('base_val');

        // Create table, if not yet existant
        if ($this->get_config('version') != '1.0') {
            $q   = "CREATE TABLE if not exists {$serendipity['dbPrefix']}ethics (
                        id int(10) {PRIMARY},
                        ethics int(1) default 1,
                        pwd varchar(32),
                        last_banned int(10) {UNSIGNED} default null
                    )";
            $sql = serendipity_db_schema_import($q);
            $this->set_config('version', '1.0');

            $q = 'SELECT   authorid              AS villan_id,
                           realname              AS villan
                  FROM     '.$serendipity['dbPrefix'].'authors
                  WHERE    userlevel < '.USERLEVEL_ADMIN;

            $sql = serendipity_db_query($q);
            if ($sql && is_array($sql)) {
                $e_val = (int)$base_val;
                if (!$e_val || !is_numeric($e_val) || $e_val < 1 || $e_val > 3) {
                    $e_val = 1;
                }

                foreach($sql AS $key => $row) {
                    $villan_id = $row['villan_id'];

                    $q1 = "INSERT INTO {$serendipity['dbPrefix']}ethics (id, ethics, pwd, last_banned)
                           VALUES(" . (int)$villan_id . ", " . (int)$e_val . ", '', 0);";
                    $sql = serendipity_db_query($q1);
                }
            }
        }

        $q = 'SELECT   a.authorid              AS villan_id,
                       a.realname              AS villan
              FROM     '.$serendipity['dbPrefix'].'authors AS a
   LEFT OUTER JOIN     '.$serendipity['dbPrefix'].'ethics AS e
                ON     e.id = a.authorid
             WHERE     userlevel < '.USERLEVEL_ADMIN . '
               AND     e.id IS NULL';
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            foreach($sql AS $key => $row) {
                $villan_id = $row['villan_id'];
                $e_val     = $base_val;

                if (!$e_val || !is_numeric($e_val) || $e_val < 1 || $e_val > 3) {
                    $e_val = 1;
                }

                $q1   = "INSERT INTO {$serendipity['dbPrefix']}ethics (id, ethics, pwd, last_banned)
                       VALUES(".(int)$villan_id.", ".(int)$e_val.", '', 0);";
                $sqli = serendipity_db_query($q1);
            }
        }

        // Modify ethic value, only if administrator
        if ($serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN) {
            $act  = $_REQUEST['ethic_act'];
            $vill = (int)$_REQUEST['ethic_vill'];
            $ethic_received = (int)$_REQUEST['ethic_ethic'];
            $q = "SELECT ethics FROM {$serendipity['dbPrefix']}ethics
                  WHERE  id = $vill";
            $sql = serendipity_db_query($q);
            if ($sql && is_array($sql)) {
                 foreach($sql AS $key => $row) {
                      $eti = $row['ethics'];
                 }
            }

            if ($act != "" && $vill != "" && $ethic_received == $eti) {
                 if ($act == "m") {
                     if ($eti > 1) {
                         $q = "UPDATE {$serendipity['dbPrefix']}ethics SET ethics = ethics - 1
                               WHERE id = $vill";
                         $sql = serendipity_db_query($q);
                     }
                     if ($eti == 3) {
                         $q1 = "SELECT pwd FROM {$serendipity['dbPrefix']}ethics
                                WHERE  id = $vill";
                         $sql = serendipity_db_query($q1);
                         if ($sql && is_array($sql)) {
                             foreach($sql AS $key => $row) {
                                 $password = $row['pwd'];
                             }
                         }
                         $q2 = "UPDATE {$serendipity['dbPrefix']}authors SET password = '$password'
                                WHERE authorid = $vill";
                         $sql = serendipity_db_query($q2);
                     }
                 } else if ($act == "p") {
                     if ($eti < 3) {
                         $q = "UPDATE {$serendipity['dbPrefix']}ethics SET ethics = ethics + 1
                               WHERE id = $vill";
                         $sql = serendipity_db_query($q);
                     }
                     if ($eti == 2) {
                         $q1 = "SELECT password FROM {$serendipity['dbPrefix']}authors
                                 WHERE authorid = $vill";
                         $sql = serendipity_db_query($q1);
                         if ($sql && is_array($sql)) {
                             foreach($sql AS $key => $row) {
                                 $password = $row['password'];
                             }
                         }
                         $today = getdate();
                         $q2 = "UPDATE {$serendipity['dbPrefix']}ethics
                                SET pwd = '$password', last_banned = '" . time() . "'
                                WHERE id = $vill";
                         $sql = serendipity_db_query($q2);
                         $new_password = "banned_for_a_while";
                         $q3 = "UPDATE {$serendipity['dbPrefix']}authors SET password = '$new_password'
                                WHERE authorid = $vill";
                         $sql = serendipity_db_query($q3);
                     }
                 }
            }
        } // end of admin part

        $q = 'SELECT    a.authorid              AS villan_id,
                        a.realname              AS villan,
                        a.password              AS pwd,
                        e.id                    AS ethic_id,
                        e.ethics                AS ethics
                FROM    '.$serendipity['dbPrefix'].'authors AS a,
                        '.$serendipity['dbPrefix'].'ethics AS e
                WHERE   a.authorid = e.id
            ORDER BY    a.realname ASC';
        ?>
        <div style="margin: 0px; padding: 0px; text-align: justify;">
        <p>
        <?
        echo PLUGIN_ETHICS_INTRO;
        ?>
        <br>
        <img src="<?php echo $serendipity['serendipityHTTPPath']; ?>plugins/serendipity_plugin_ethics/img/green.gif">
        <?
        echo PLUGIN_ETHICS_GREENLIGHT."  ";
        ?>
        <img src="<?php echo $serendipity['serendipityHTTPPath']; ?>plugins/serendipity_plugin_ethics/img/yellow.gif">
        <?
        echo PLUGIN_ETHICS_YELLOWLIGHT."  ";
        ?>
        <img src="<?php echo $serendipity['serendipityHTTPPath']; ?>plugins/serendipity_plugin_ethics/img/red.gif">
        <?
        echo PLUGIN_ETHICS_REDLIGHT;
        ?>
        </p>
        <table align="center" width="100%">
        <?
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            foreach($sql AS $key => $row) {
                echo "<tr><td>";
                echo htmlspecialchars($row['villan'])."</td><td>";
                if ($row['ethics'] == 3) {
                    ?>
                    <img src="<?php echo $serendipity['serendipityHTTPPath']; ?>plugins/serendipity_plugin_ethics/img/red_light.gif">
                    <?
                } else if ($row['ethics'] == 2) {
                    ?>
                    <img src="<?php echo $serendipity['serendipityHTTPPath']; ?>plugins/serendipity_plugin_ethics/img/yellow_light.gif">
                    <?
                } else {
                    ?>
                    <img src="<?php echo $serendipity['serendipityHTTPPath']; ?>plugins/serendipity_plugin_ethics/img/green_light.gif">
                    <?
                }
                echo "</td>";
                if ($serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN) {
                    echo "<td>";
                    if ($row['ethics'] < 3)
                        echo "<a href=\"".$serendipity['serendipityHTTPPath'] . $serendipity['indexFile']."?ethic_vill=".$row['villan_id']."&amp;ethic_act=p&amp;ethic_ethic=".$row['ethics']."\">";
                    echo "?";
                    if ($row['ethics'] < 3)
                        echo "</a>";
                    echo "  ";
                    if ($row['ethics'] > 1)
                        echo "<a href=\"".$serendipity['serendipityHTTPPath'] . $serendipity['indexFile']."?ethic_vill=".$row['villan_id']."&amp;ethic_act=m&amp;ethic_ethic=".$row['ethics']."\">";
                    echo "?";
                    if ($row['ethics'] > 1)
                        echo "</a>";
                    echo "</td>";
                }
                echo "</tr>";
            }
        }
?>
</table>
</div>
<?php
    }
}
