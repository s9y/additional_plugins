<?php # 

function communityrating_serendipity_show_image($file, $alt = '*') {
	return '<img alt="' . $alt . '" src="' . $file . '" />';
}

function communityrating_serendipity_show($params, &$smarty) {
    static $images = array();
    global $serendipity;

    if (empty($params['type'])) {
    	$params['type'] = 'IMDB';
    }

    $params['id'] = '';
    if (!empty($params['data'])) {
        $params['points'] = $params['data']['cr_' . $params['type'] . '_rating'];
        $params['id']     = $params['data']['cr_' . $params['type'] . '_id'];
    }

    if (empty($params['stars'])) {
        $params['stars'] = 0;
    }

    if (!empty($params['url'])) {
        $url = $params['url'] . '_' . $params['type'] . '_' . $params['id'];
        $cache = $serendipity['smarty']->compile_dir . '/cr_' . md5($url);

        if (!file_exists($cache) || filemtime($cache) < (time()-604800)) {
            $fp = @fopen($cache, 'a');
            if ($fp) {
                fwrite($fp, date('d.m.Y H:i'));
                fclose($fp);
            }

            if (function_exists('serendipity_request_url')) {
                $data = serendipity_request_url($url);
            } else {
                require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
                $req = new HTTP_Request($url);

                if (!PEAR::isError($req->sendRequest()) || $req->getResponseCode() == '200') {
                    $data = $req->getResponseBody();
                } else {
                    $data = '';
                }
            }

            $id = '';
            if (preg_match('@<rating>(.+)</rating>@imsU', $data, $match)) {
                $id = $match[1];
            }

            $url = '';
            if (preg_match('@<url>(.+)</url>@imsU', $data, $match)) {
                $url = $match[1];
            }

            $fp = fopen($cache . '.id', 'w');
            if ($fp) {
                fwrite($fp, $id);
                fclose($fp);
            }

            $fp = fopen($cache . '.url', 'w');
            if ($fp) {
                fwrite($fp, $url);
                fclose($fp);
            }
        }

        $params['points']      = (int)@file_get_contents($cache . '.id');
        $params['foreign_url'] = @file_get_contents($cache . '.url');
    }

    if (!empty($params['points'])) {
        $params['stars']  = $params['points'] / 2;
    } else {
        $params['points'] = $params['stars'];
    }

    if ($params['points'] < 1) {
        return '';
    }

    if (empty($params['path'])) {
    	$params['path'] = 'serendipityHTTPPath';
    }

    if (!empty($params['who'])) {
        $params['tpl_who'] = '_' . $params['who'];
    }

    if (!isset($images[$params['path']][$params['type']])) {
        $images[$params['path']][$params['type']] = array(
            'full' => communityrating_serendipity_show_image(serendipity_getTemplateFile('img/star_' . $params['type'] . '_full.png', $params['path']), '*'),
            'half' => communityrating_serendipity_show_image(serendipity_getTemplateFile('img/star_' . $params['type'] . '_half.png', $params['path']), '.'),
            'zero' => communityrating_serendipity_show_image(serendipity_getTemplateFile('img/star_' . $params['type'] . '_zero.png', $params['path']), 'o'),
        );
    }

	$out = '';
	for ($i = $params['stars']; $i >= 1; $i--) {
		 $out .= $images[$params['path']][$params['type']]['full'];
	}

	if ($i > 0) {
		 $out .= $images[$params['path']][$params['type']]['half'];
		 $params['stars'] = $params['stars'] + 1;
	}

	for ($i = 5 - $params['stars']; $i > 0; $i--) {
		 $out .= $images[$params['path']][$params['type']]['zero'];
	}

    $filename = 'communityrating_' . $params['type'] . $params['tpl_who'] . '.tpl';
    $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
    if (!$tfile || $tfile == $filename) {
        $tfile = dirname(__FILE__) . '/' . $filename;
    }
    $inclusion = $serendipity['smarty']->security_settings[INCLUDE_ANY];
    $serendipity['smarty']->security_settings[INCLUDE_ANY] = true;
    $serendipity['smarty']->assign(
        array(
            'communityrating_images'        => $out,
            'communityrating_rating'        => $params['points'],
            'communityrating_type'          => $params['type'],
            'communityrating_id'            => $params['id'],
            'communityrating_foreign_url'   => $params['foreign_url']
        )
    );
    $content = $serendipity['smarty']->fetch('file:'. $tfile);
    $serendipity['smarty']->security_settings[INCLUDE_ANY] = $inclusion;

	if (!empty($params['escaped'])) {
        echo serendipity_utf8_encode((function_exists('serendipity_specialchars') ? serendipity_specialchars($content) : htmlspecialchars($content, ENT_COMPAT, LANG_CHARSET)));
	} else {
        echo $content;
	}
}

