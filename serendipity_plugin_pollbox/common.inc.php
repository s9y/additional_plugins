<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_common_pollbox {
    var $poll = array();

    static function poll($pollid = null) {
        $poll  = new serendipity_common_pollbox;
        $poll->setPoll($poll->fetchPoll($pollid));
        $poll->showPoll($pollid);
    }

    function setCookie($name, $value) {
        echo '<script type="text/javascript">
        function SetPollCookie(name, value) {
            var today  = new Date();
            var expire = new Date();
            expire.setTime(today.getTime() + (60*60*24*30));
            document.cookie = \'serendipity[\' + name + \']=\'+escape(value) + \';expires=\' + expire.toGMTString();
        }

        SetPollCookie("' . $name . '", "' . $value . '");
        </script>' . "\n";
    }

    function showPoll($pollid = null) {
        global $serendipity;

        echo '<strong class="polltitle">' . $this->poll['title'] . '</strong>';
        echo '<form action="' . serendipity_currentURL() . '" method="post" id="serendipity_poll_showform">';

        if ($pollid || $_SESSION["pollHasVoted{$this->poll['id']}"] || $serendipity['COOKIE']["pollHasVoted{$this->poll['id']}"]) {
            $this->showResults();
        } elseif (isset($serendipity['POST']['goVote']) && !empty($serendipity['POST']['vote'])) {
            $_SESSION["pollHasVoted{$this->poll['id']}"] = true;
            $this->setCookie("pollHasVoted{$this->poll['id']}", 'true');
            $this->addVote($this->poll['id'], $serendipity['POST']['vote']);
            $this->showResults();
        } else {
            $this->showOptions();
        }
        echo '</form>';
    }

    function addVote($pollid, $optid) {
        global $serendipity;

        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}polls_options SET votes=votes+1 WHERE pollid = " . (int)$pollid . " AND id = " . (int)$optid);
        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}polls         SET votes=votes+1 WHERE id     = " . (int)$pollid);
    }

    function showOptions() {
        if (is_array($this->poll['options'])) {
            foreach($this->poll['options'] AS $optid => $option) {
                if (empty($option['title'])) {
                    continue;
                }
                echo '<input class="pollitem" type="radio" style="width: 15px; margin: 0px;" name="serendipity[vote]" value="' . $optid . '" /> ' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($option['title']) : htmlspecialchars($option['title'], ENT_COMPAT, LANG_CHARSET)) . '<br />';
            }
        }
        echo '<input class="pollsubmit" type="submit" name="serendipity[goVote]" value="' . GO . '" />';
    }

    function showResults() {
        $sorted = array();
        foreach((array)$this->poll['options'] AS $option) {
            $sorted[$option['title']] = $option['votes'];
        }
        asort($sorted);

        foreach($sorted AS $title => $votes) {
            echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($title) : htmlspecialchars($title, ENT_COMPAT, LANG_CHARSET)) . '<br />';
            if ($this->poll['votes'] > 0) {
                $total = ceil(($votes / $this->poll['votes']) * 100);
            } else {
                $total = 0;
            }
            echo '<div class="pollvote" style="text-align: right">' . $total . '%, ' . $votes . ' ' . PLUGIN_POLL_VOTES . '</div>';
        }

        printf('<div class="polltotal">' . PLUGIN_POLLBOX_TOTALVOTES . '</div>', $this->poll['votes']);
    }

    function setPoll($poll) {
        $this->poll = $poll;
    }

    static function fetchPoll($cid = null) {
        global $serendipity;

        $result = array();

        $polls = serendipity_db_query("SELECT p.id, p.title, p.content, p.timestamp, p.votes AS allvotes,
                                              po.title as optiontitle, po.votes, po.id AS optionid
                                        FROM {$serendipity['dbPrefix']}polls AS p
                             LEFT OUTER JOIN {$serendipity['dbPrefix']}polls_options AS po
                                          ON p.id = po.pollid
                                       WHERE " . (!empty($cid) ? 'p.id = ' . (int)$cid : 'p.active = 1'));
        if (is_array($polls)) {
            $first = false;
            foreach($polls AS $poll) {
                $id = $poll['id'];

                $cpoll = array(
                    'title'     => $poll['title'],
                    'id'        => $poll['id'],
                    'content'   => $poll['content'],
                    'timestamp' => $poll['timestamp'],
                    'votes'     => $poll['allvotes'],
                    'options'   => array()
                );

                if (!$first) {
                    $result = $cpoll;
                }

                $opt = array(
                    'title' => $poll['optiontitle'],
                    'votes' => $poll['votes']
                );

                $result['options'][$poll['optionid']]      = $opt;
                $first = true;
            }
        }

        return $result;
    }

}

