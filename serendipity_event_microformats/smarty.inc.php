<?php # 

function microformats_serendipity_show_image($file, $alt = '*')
{
    return '<img alt="' . $alt . '" src="' . $file . '" />';
}

function microformats_serendipity_show($params, &$smarty)
{
    static $images = array();
    global $serendipity;
/*echo '<pre>';
    print_r($serendipity);
echo '</pre>';*/
    $params['mf_type'] = $params['type'];
    /*echo '<pre>';
    print_r($serendipity['smarty']);
    echo '</pre>';*/
    switch ($params['mf_type']) {
        case 'hReview':
            $params['id'] = '';
            if (!empty($params['data'])) {
                $params['name']	= $params['data']['mf_'.$params['mf_type'].'_name'];
                $params['type']	= $params['data']['mf_'.$params['mf_type'].'_type'];
                $params['url']	= $params['data']['mf_'.$params['mf_type'].'_url'];
                $params['image']	= $params['data']['mf_'.$params['mf_type'].'_image'];
                $params['rating']	= floatval($params['data']['mf_'.$params['mf_type'].'_rating']);
                $params['summary']	= $params['data']['mf_'.$params['mf_type'].'_summary'];
                $params['desc']	= $params['data']['mf_'.$params['mf_type'].'_desc'];
                $params['date']	= $params['data']['mf_'.$params['mf_type'].'_date'];
                //$params['timezone']	= $params['data']['mf_'.$params['mf_type'].'_timezone'];
                $params['reviewer']	= $params['data']['mf_'.$params['mf_type'].'_reviewer'];
            }
            /*echo '<pre>';
            print_r($params);
            echo '</pre>';*/

            if (empty($params['name'])) {
                return '';
            }

            if (empty($params['stars'])) {
                $params['stars'] = 0;
            }

            if (!empty($params['points'])) {
                $params['stars']  = $params['points'] / 2;
            } else {
                $params['points'] = $params['stars'];
            }

            if (empty($params['path'])) {
                $params['path'] = 'serendipityHTTPPath';
            }

            if (!empty($params['who'])) {
                $params['tpl_who'] = '_' . $params['who'];
            }

            if (!isset($images[$params['path']][$params['mf_type']])) {
                $images[$params['path']][$params['mf_type']] = array(
                    'full' => microformats_serendipity_show_image(serendipity_getTemplateFile('img/star_' . $params['mf_type'] . '_full.png', $params['path']), '*'),
                    'half' => microformats_serendipity_show_image(serendipity_getTemplateFile('img/star_' . $params['mf_type'] . '_half.png', $params['path']), '.'),
                    'zero' => microformats_serendipity_show_image(serendipity_getTemplateFile('img/star_' . $params['mf_type'] . '_zero.png', $params['path']), 'o'),
                );
            }

        $out = '';
        for ($i = $params['stars']; $i >= 1; $i--) {
            $out .= $images[$params['path']][$params['mf_type']]['full'];
        }

        if ($i > 0) {
            $out .= $images[$params['path']][$params['mf_type']]['half'];
            $params['stars'] = $params['stars'] + 1;
        }

        for ($i = 5 - $params['stars']; $i > 0; $i--) {
            $out .= $images[$params['path']][$params['mf_type']]['zero'];
        }
        break;
    case 'hCalendar':
            $params['id'] = '';
            if (!empty($params['data'])) {
                $params['summary']      = $params['data']['mf_'.$params['mf_type'].'_summary'];
                $params['location']     = $params['data']['mf_'.$params['mf_type'].'_location'];
                $params['url']          = $params['data']['mf_'.$params['mf_type'].'_url'];
                $params['startdate']    = $params['data']['mf_'.$params['mf_type'].'_startdate'];
                $params['enddate']      = $params['data']['mf_'.$params['mf_type'].'_enddate'];
                $params['desc']         = $params['data']['mf_'.$params['mf_type'].'_desc'];
                //$params['timezone'] = $params['data']['mf_'.$params['mf_type'].'_timezone'];
            }
            //echo '<pre>';
            //print_r($params);
            //echo '</pre>';

            if (empty($params['summary'])) {
                return '';
            }
        break;
    }


    //$filename = 'microformats_' . $params['type'] . $params['tpl_who'] . '.tpl';
    $filename = $params['mf_type'].'.tpl';
    $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
    if (!$tfile || $tfile == $filename) {
        $tfile = dirname(__FILE__).'/'.$filename;
    }
    $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
    $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
    switch ($params['mf_type']) {
        case 'hReview':
            $serendipity['smarty']->assign(
                array(
                    /*'hreview_version'			=> '0.3',*/
                    'hreview_summary'           => $params['summary'],
                    'hreview_date'              => microformats_calculate_date($params['date'], $serendipity['smarty']->_tpl_vars['timezone']),
                    'hreview_date_humanreadable'=> date('d.m.Y H:i T', $params['date']),
                    'hreview_reviewer'          => $params['reviewer'],
                    'hreview_type'              => $params['type'],
                    'hreview_image'             => $params['image'],
                    'hreview_url'               => $params['url'],
                    'hreview_name'              => $params['name'],
                    'hreview_desc'              => $params['desc'],
                    'hreview_desc_escaped'      => htmlentities($params['desc']),
                    'hreview_rating'            => floor($params['rating']),
                    'hreview_ratingvalue'       => $params['rating'],
                    'hreview_best'              => (int)$serendipity['smarty']->_tpl_vars['best']/*,
                    'hreview_rating_symbols'    => '&hearts;'*/
                )
            );
            echo 'Creating range from 1.0 to ' . $params['rating'] . '(' . floatval($params['rating']) . ') by ' . $serendipity['smarty']->_tpl_vars['step'] . '(' . floatval($serendipity['smarty']->get_template_vars('step')) . ')';
            echo '<br />Best: '.$serendipity['smarty']->_tpl_vars['best'].'('.$serendipity['smarty']->get_template_vars('best').')';
            echo '<br />Name: '.$serendipity['smarty']->_tpl_vars['hreview_name'].'('.$serendipity['smarty']->get_template_vars('hreview_name').')';
            $loop = range(1.0, floatval($params['rating']), floatval($serendipity['smarty']->get_template_vars('step')));
            foreach ($loop as $v) {
                $hreview_rating_symbols .= '&hearts;';
            }
            $serendipity['smarty']->assign(array('hreview_rating_symbols' => $hreview_rating_symbols));
//print_r($serendipity['smarty']);
            break;
        case 'hCalendar':
            $serendipity['smarty']->assign(
                array(
                    'hcalendar_summary'                 => $params['summary'],
                    'hcalendar_location'                => $params['location'],
                    'hcalendar_url'                     => $params['url'],
                    'hcalendar_startdate'               => microformats_calculate_date($params['startdate'], $serendipity['smarty']->_tpl_vars['timezone']),
                    'hcalendar_enddate'                 => microformats_calculate_date($params['enddate'], $serendipity['smarty']->_tpl_vars['timezone']),
                    'hcalendar_startdate_subnode'       => date('Y-m-d', strtotime($params['startdate'])),
                    'hcalendar_startdate_humanreadable' => date('d.m.Y H:i T', $params['startdate']),
                    'hcalendar_enddate_humanreadable'   => date('d.m.Y H:i T', $params['enddate']),
                    'hcalendar_desc'                    => $params['desc'],
                    'hcalendar_desc_escaped'            => htmlentities($params['desc'])
                )
            );
            break;
    }
    $content = $serendipity['smarty']->fetch('file:'.$tfile);
    $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;

    if (!empty($params['escaped'])) {
        echo serendipity_utf8_encode(htmlspecialchars($content));
    } else {
        echo $content;
    }
}

function microformats_calculate_date($date_humanreadable, $timezone)
{
    $return = date('Ymd\THi', $date_humanreadable).$timezone;
    return $return;
}
