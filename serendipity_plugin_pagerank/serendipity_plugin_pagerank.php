<?php
/************************************************************
 *  Goélette Web Agency  http://www.goelette.net/
 *
 *  Copyright (c)2005 Goélette
 *  Version 0.30
 *  Released under the GNU General Public License
 *
 ************************************************************/


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

class serendipity_plugin_pagerank extends serendipity_plugin
{
    var $title = PLUGIN_PAGERANK_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_PAGERANK_NAME);
        $propbag->add('description',   PLUGIN_PAGERANK_DETAIL);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Christian Lescuyer');
        $propbag->add('version',       '0.32');
        $propbag->add('requirements',  array(
            'serendipity' => '0.8',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));

        $properties  = array('page_count', 'this_page');
        // Warning: loop starts at 1
        for ($i = 1, $n = @$this->get_config('page_count'); $i <= $n; ++$i) {
          $properties[] = 'page' . $i;
          $properties[] = 'capt' . $i;
        }
        $propbag->add('configuration', $properties);

        return true;
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        if ($name == 'page_count') {
            $propbag->add('type', 'string');
            $propbag->add('name', PLUGIN_PAGERANK_PAGE_COUNT);
            $propbag->add('description', PLUGIN_PAGERANK_PAGE_COUNT_DESC);
            $propbag->add('default', '1');
        } else if ($name == 'this_page') {
            $propbag->add('type', 'radio');
            $propbag->add('name', PLUGIN_PAGERANK_THIS_PAGE);
            $propbag->add('description', PLUGIN_PAGERANK_THIS_PAGE_DESC);
            $propbag->add('radio',  array(
                'value' => array('yes', 'no'),
                'desc'  => array(PLUGIN_PAGERANK_THIS_PAGE_YES, PLUGIN_PAGERANK_THIS_PAGE_NO)));
            $propbag->add('default', 'yes');
        } else if (substr($name, 0, 4) == 'page') {
            $index = substr($name, 4);
            $propbag->add('type', 'string');
            $propbag->add('name', sprintf(PLUGIN_PAGERANK_PAGE_URL, $index));
            $propbag->add('description', sprintf(PLUGIN_PAGERANK_PAGE_URL_DESC, $index));
            $propbag->add('default', 'http://' . $_SERVER['SERVER_NAME'] . '/');
        } else if (substr($name, 0, 4) == 'capt') {
            $index = substr($name, 4);
            $propbag->add('type', 'string');
            $propbag->add('name', sprintf(PLUGIN_PAGERANK_PAGE_CAPTION, $index));
            $propbag->add('default', 'Page d\'accueil');
        } else {
            return false;
        }

        return true;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title = $this->title;

        print '<ul>';

        // PR for the current page
        if ($this->get_config('this_page') == 'yes') {
            $page = $_SERVER['SERVER_NAME'] .  $_SERVER['REQUEST_URI'];
            print '<li>' . PLUGIN_PAGERANK_THIS_PAGE_CAPTION . ': ';
            print '<span class="PageRank">' . $this->getrank($page) . '</span></li>';
        }

        // Warning: loop starts at 1
        for ($i = 1, $n = $this->get_config('page_count'); $i <= $n; ++$i) {
            $caption = $this->get_config('capt' . $i);
            $page = $this->get_config('page' . $i);
            print '<li>' . $caption . ': ';
            print '<span class="PageRank">' . $this->getrank($page) . '</span></li>';
        }
        print '</ul>';
    }

/*
 * Algorithm lifted from "Google Checksum Algorithm 2.0.114 (PHP Source)"
 * written and contributed by Alex Stapleton, Andy Doctorow, Tarakan,
 *                            Bill Zeller, Vijay "Cyberax" Bhatter, traB
 * Straightened up by Christian Lescuyer
 *
 */

    //unsigned shift right
    function zeroFill($a, $b)
    {
      $z = hexdec(80000000);
      if ($z & $a) {
        $a = ($a>>1);
        $a &= (~$z);
        $a |= 0x40000000;
        $a = ($a>>($b-1));
      } else {
        $a = ($a>>$b);
      }
      return $a;
    }

    function mix($a, $b, $c)
    {
      $a -= $b; $a -= $c; $a ^= ($this->zeroFill($c,13));
      $b -= $c; $b -= $a; $b ^= ($a<<8);
      $c -= $a; $c -= $b; $c ^= ($this->zeroFill($b,13));
      $a -= $b; $a -= $c; $a ^= ($this->zeroFill($c,12));
      $b -= $c; $b -= $a; $b ^= ($a<<16);
      $c -= $a; $c -= $b; $c ^= ($this->zeroFill($b,5));
      $a -= $b; $a -= $c; $a ^= ($this->zeroFill($c,3));
      $b -= $c; $b -= $a; $b ^= ($a<<10);
      $c -= $a; $c -= $b; $c ^= ($this->zeroFill($b,15));

      return array($a, $b, $c);
    }

    function GoogleCH($url, $length = 0, $init = 0xE6359A60)
    {
        if ($length == 0) {
          $length = sizeof($url);
        }
        $a = $b = 0x9E3779B9;
        $c = $init;
        $k = 0;
        $len = $length;
        while($len >= 12) {
            $a += ($url[$k+0] +($url[$k+1]<<8) +($url[$k+2]<<16) +($url[$k+3]<<24));
            $b += ($url[$k+4] +($url[$k+5]<<8) +($url[$k+6]<<16) +($url[$k+7]<<24));
            $c += ($url[$k+8] +($url[$k+9]<<8) +($url[$k+10]<<16)+($url[$k+11]<<24));
            $mix = $this->mix($a,$b,$c);
            $a = $mix[0]; $b = $mix[1]; $c = $mix[2];
            $k += 12;
            $len -= 12;
        }

        $c += $length;
        switch($len)              /* all the case statements fall through */
        {
            case 11: $c+=($url[$k+10]<<24);
            case 10: $c+=($url[$k+9]<<16);
            case 9 : $c+=($url[$k+8]<<8);
              /* the first byte of c is reserved for the length */
            case 8 : $b+=($url[$k+7]<<24);
            case 7 : $b+=($url[$k+6]<<16);
            case 6 : $b+=($url[$k+5]<<8);
            case 5 : $b+=($url[$k+4]);
            case 4 : $a+=($url[$k+3]<<24);
            case 3 : $a+=($url[$k+2]<<16);
            case 2 : $a+=($url[$k+1]<<8);
            case 1 : $a+=($url[$k+0]);
             /* case 0: nothing left to add */
        }
        $mix = $this->mix($a,$b,$c);

        return $mix[2];
    }

    //converts a string into an array of integers containing the numeric value of the char
    function strord($string)
    {
      for($i=0;$i<strlen($string);$i++) {
        $result[$i] = ord($string{$i});
      }

      return $result;
    }

   /*
    * Query returns "Rank_1:1:4" (for example) as a string
    */
    function getrank($url)
    {
      $url = 'info:'.$url;
      $ch = $this->GoogleCH($this->strord($url));
      $url = "http://www.google.com/search?client=navclient-auto&ch=6$ch&features=Rank&q=" . urlencode($url);

      if (ini_get('allow_url_fopen')) {
          $data = file_get_contents($url, 128);
      } else {
          require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
          $req = new HTTP_Request($url);
          if (!PEAR::isError($req->sendRequest())) {
              $data = $req->getResponseBody();
           }
      }

      $rankarray = explode (':', $data);

      return $rankarray[2];
    }

}

/* vim: set sts=4 ts=4 expandtab : */
