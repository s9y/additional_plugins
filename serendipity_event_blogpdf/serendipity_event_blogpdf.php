<?php # $Id$

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


/* TODO:
- Use Links inside entries
- Put images
- Build a nice TOC
- Insert nice formatting, maybe user-defined? (Color, Font face)
- Parse attributes like STRONG, BOLD, ...
*/

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

if (!function_exists('html_entity_decode')) {
    function html_entity_decode($given_html, $quote_style = ENT_QUOTES) {
        $trans_table = get_html_translation_table(HTML_SPECIALCHARS, $quote_style);
        if ($trans_table["'"] != '&#039;') { # some versions of PHP match single quotes to &#39;
          $trans_table["'"] = '&#039;';
        }

        return (strtr($given_html, array_flip($trans_table)));
    }
}

class serendipity_event_blogpdf extends serendipity_event
{
    var $title = PLUGIN_EVENT_BLOGPDF_NAME;
    var $pdf;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_BLOGPDF_NAME);
        $propbag->add('description',   PLUGIN_EVENT_BLOGPDF_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Olivier PLATHEY, Steven Wittens');
        $propbag->add('license',       'GPL (Uses LGPL FPDF, HTML2PDF, UFPDF');
        $propbag->add('version',       '1.8');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('event_hooks',    array(
            'external_plugin'  => true,
            'entries_footer'   => true,
            'frontend_display' => true
        ));
        $propbag->add('groups', array('FRONTEND_FULL_MODS'));
        $propbag->add('configuration', array('html2pdf', 'updf', 'fallback'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'html2pdf':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        'HTML2PDF support');
                $propbag->add('description', '');
                $propbag->add('default',     false);
                return true;
                break;
            case 'updf':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        'UPDF / Unicode support');
                $propbag->add('description', '');
                $propbag->add('default',     false);
                return true;
                break;
			case 'fallback':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        'Fallback to iso8559');
                $propbag->add('description', 'Should be used when your Blog is in UTF-8 and you use a latin charset, but the UFPDF library doesn\'t work');
                $propbag->add('default',     false);
                return true;
                break;
        }
        return false;
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        $links = array();
        $article_show = false;

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display':
                    if (isset($serendipity['GET']['id']) && is_numeric($serendipity['GET']['id'])) {
                        $article_show = true;
                        $year         = date('Y', serendipity_serverOffsetHour($eventData['timestamp']));
                        $month        = date('m', serendipity_serverOffsetHour($eventData['timestamp']));
                    } else {
                        break;
                    }

                case 'entries_footer':
                    if (isset($serendipity['GET']['id']) && is_numeric($serendipity['GET']['id'])) {
                        $links[] = '<a href="' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/articlepdf_' . $serendipity['GET']['id'] . '">' . PLUGIN_EVENT_BLOGPDF_VIEW_ENTRY . '</a>';
                    }

                    if (isset($serendipity['GET']['category'])) {
                        $cid = explode('_', $serendipity['GET']['category']);
                        if (is_numeric($cid[0])) {
                            $cat = serendipity_fetchCategoryInfo($cid[0]);
                            $links[] = '<a href="' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/categorypdf_' . $cid[0] . '">' . sprintf(PLUGIN_EVENT_BLOGPDF_VIEW_CATEGORY, $cat['category_name']) . '</a>';
                        }
                    }

                    if (empty($year) && empty($month) && isset($serendipity['GET']['range']) && is_numeric($serendipity['GET']['range'])) {
                        $year  = substr($serendipity['GET']['range'], 0, 4);
                        $month = substr($serendipity['GET']['range'], 4, 2);
                    }

                    if (empty($year)) {
                        $year = date('Y', serendipity_serverOffsetHour());
                    }

                    if (empty($month)) {
                        $month = date('m', serendipity_serverOffsetHour());
                    }

                    $links[] = '<a href="' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/monthpdf_' . $year . $month . '">' . PLUGIN_EVENT_BLOGPDF_VIEW_MONTH . '</a>';
                    $links[] = '<a href="' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/blogpdf">' . PLUGIN_EVENT_BLOGPDF_VIEW_FULL . '</a>';

                    if ($article_show) {
                        $eventData['add_footer'] .= '<br />' . PLUGIN_EVENT_BLOGPDF_VIEW . implode(' | ', $links);
                    } else {
                        echo '<br />' . PLUGIN_EVENT_BLOGPDF_VIEW . implode(' | ' , $links);
                    }


                    return true;
                    break;

                case 'external_plugin':
                    if (serendipity_db_bool($this->get_config('html2pdf'))) {
                        include_once dirname(__FILE__) . '/html2fpdf.php';
                    } elseif (serendipity_db_bool($this->get_config('updf'))) {
                        include_once dirname(__FILE__) . '/serendipity_blogupdf.inc.php';
                    } else {
                        include_once dirname(__FILE__) . '/serendipity_blogpdf.inc.php';
                    }

                    $cachetime = 60*60*24; // one day

                    $parts     = explode('_', $eventData);
                    if (!empty($parts[1])) {
                        $param     = (int) $parts[1];
                    } else {
                        $param     = null;
                    }

                    $methods = array('blogpdf', 'articlepdf', 'monthpdf', 'categorypdf');

                    if (!in_array($parts[0], $methods)) {
                        return;
                    }

                    if (serendipity_db_bool($this->get_config('html2pdf'))) {
                        $this->pdf = new HTML2FPDF();
                    } else {
                        $this->pdf = new PDF();
                    }

                    $this->pdf->AliasNbPages();

                    switch($parts[0]) {
                        case 'blogpdf':
                            $feedcache = $serendipity['serendipityPath'] . 'archives/blog.pdf';
                            $entries = serendipity_fetchEntries();
                            $this->process(
                              $feedcache,
                              $entries
                            );
                            break;

                        case 'articlepdf':
                            $feedcache = $serendipity['serendipityPath'] . 'archives/article' . $param . '.pdf';
                            $this->single = true;
                            $entry = serendipity_fetchEntry('id', $param);
                            $this->process(
                              $feedcache,
                              $entry
                            );
                            break;

                        case 'monthpdf':
                            $feedcache = $serendipity['serendipityPath'] . 'archives/month' . $param . '.pdf';
                            $entries = serendipity_fetchEntries($param);
                            $this->process(
                              $feedcache,
                              $entries
                            );
                            break;

                        case 'categorypdf':
                            $feedcache = $serendipity['serendipityPath'] . 'archives/category' . $param . '.pdf';
                            $serendipity['GET']['category'] = $param . '_category';
                            $entries = serendipity_fetchEntries();
                            $this->process(
                              $feedcache,
                              $entries
                            );
                            break;
                    }

                    $this->pdf->Output();

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

    function process($feedcache, &$entries) {
        if (!file_exists($feedcache) || filesize($feedcache) == 0 || filemtime($feedcache) < (time() - $cachetime)) {
            if ($this->single) {
                $this->print_entry(0, $entries, $this->prep_out(serendipity_formatTime(DATE_FORMAT_ENTRY, $entries['timestamp'])));
            } else {
                $this->print_entries($entries);
            }
            $this->pdf->Close();
            $fp = fopen($feedcache, 'wb');
            fwrite($fp, $this->pdf->buffer);
            fclose($fp);
        } else {
            $this->pdf->buffer = file_get_contents($feedcache);
            $this->pdf->state = 3; // fake closed document to insert cached PDF
        }

        return true;
    }

    function print_entry($x, &$entry, $header = false) {
        if ($header) {
            $this->pdf->AddPage();
            $this->pdf->SetFont('Courier','',12);
            $this->pdf->TOC_Add($header);
            $this->pdf->Cell(0, 10, $header, 1);
            $this->pdf->Ln();
            $this->pdf->Ln();
        }

        $entryLink = serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp']));
        serendipity_plugin_api::hook_event('frontend_display', $entry, array('no_scramble' => true));

        $posted_by = ' ' . POSTED_BY . ' ' . htmlspecialchars($entry['author']);
        if (is_array($entry['categories']) && sizeof($entry['categories']) > 0) {
            $posted_by .= ' ' . IN . ' ';
            $cats = array();
            foreach ($entry['categories'] as $cat) {
                $cats[] = $cat['category_name'];
            }
            $posted_by .= implode(', ', $cats);
        }

        $posted_by .= ' ' . AT . ' ' . serendipity_strftime('%H:%M', $entry['timestamp']);

        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Write(4, $this->prep_out($entry['title']) . "\n");
        $this->pdf->Ln();

        $this->pdf->SetFont('Arial', '', 10);
        $html = $this->prep_out($entry['body'] . $entry['extended']) . "\n";
        if (serendipity_db_bool($this->get_config('html2pdf'))) {
            $this->pdf->WriteHTML($html);
        } else {
            $this->pdf->Write(4, $html);
        }
        $this->pdf->Ln();

        $this->pdf->SetFont('Courier', '', 9);
        $this->pdf->Write(4, $this->prep_out($posted_by) . "\n");
        $this->pdf->Ln();

        if ($this->single) {
            $this->printComments(serendipity_fetchComments($entry['id']));
        }

    }

    function printComments($comments) {
        if (!is_array($comments) || count($comments) < 1) {
            return;
        }

        foreach ($comments as $i => $comment) {
            $comment['comment'] = htmlspecialchars(strip_tags($comment['body']));
            if (!empty($comment['url']) && substr($comment['url'], 0, 7) != 'http://' && substr($comment['url'], 0, 8) != 'https://') {
                $comment['url'] = 'http://' . $comment['url'];
            }

            serendipity_plugin_api::hook_event('frontend_display', $comment);

            $name = empty($comment['username']) ? ANONYMOUS : $comment['username'];
            $body = $comment['comment'];

            $this->pdf->SetFont('Arial', '', 9);
            $html = $this->prep_out(
              $body . "\n" .
              '    ' . $name .
              ' ' . ON . ' ' . serendipity_mb('ucfirst', $this->prep_out(serendipity_strftime('%b %e %Y, %H:%M', $comment['timestamp'])))
            ) . "\n";

            if (serendipity_db_bool($this->get_config('html2pdf'))) {
                $this->pdf->WriteHTML($html);
            } else {
                $this->pdf->Write(3, $html);
            }
            $this->pdf->Ln();
            $this->pdf->Ln();
        }
    }

    function prep_out($string) {
        if (serendipity_db_bool($this->get_config('html2pdf'))) {
            return $string;
        } elseif (serendipity_db_bool($this->get_config('fallback'))) {
			return strip_tags(html_entity_decode(utf8_decode($string)));
		} else {
			return strip_tags(html_entity_decode($string));
		}

    }

    function print_entries(&$entries) {
        $extended = true;
        $preview  = false;

        $addData = array('extended' => $extended, 'preview' => $preview, 'no_scramble' => true);
        serendipity_plugin_api::hook_event('entry_display', $entries, $addData);

        /* pre-walk the array to collect them keyed by date */
        $bydate = array();
        if (!is_array($entries) || $entries[0] == false) {
            return;
        }

        $lastDate = '';
        for ($x = 0, $num_entries = count($entries); $x < $num_entries; $x++) {
            $d = $this->prep_out(serendipity_formatTime(DATE_FORMAT_ENTRY, $entries[$x]['timestamp']));
            $bydate[$d][] = $entries[$x];
        }

        foreach ($bydate as $date => $ents) {
            $header = $date;
            foreach ($ents as $x => $entry) {
                $this->print_entry($x, $entry, $header);
                $header = false;
            } // end for-loop (entries)
        } // end for-loop (dates)
    } // end function serendipity_printEntries

}

/* vim: set sts=4 ts=4 expandtab : */
