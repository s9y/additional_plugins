<?php # 

/************
  TODO:

  - Add an option, if "No description" text is to be displayed - or just no text.

  - Add a message sending functionality.

 ***********/


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_ggopis extends serendipity_plugin {
    var $title = PLUGIN_GGOPIS_NAME;
  
    function introspect(&$propbag)
    {
        $this->title = $this->get_config('title', $this->title);

        $propbag->add('name',          PLUGIN_GGOPIS_NAME);
        $propbag->add('description',   PLUGIN_GGOPIS_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Piotr Borys');
        $propbag->add('version',       '1.5.1');
        $propbag->add('requirements',  array(
            'serendipity' => '0.9',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('configuration', array('gggateid', 'gggatepasswd', 'ggid'));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
    }

    // this function is taken from a www2gg library, written by Piotr Mach <pm@gg.wha.la>
	function calculate_hash ($haslo, $klucz)
    {
        $x0=0; $x1=0; $y0=0; $y1=0; $z=0; $tmp=0;
        $y0 = ($klucz << 16) >> 16; $y1 = $klucz >> 16 ;
        for ($i=0; $i<strlen($haslo); $i++)
        {
            $x0 = ($x0 & 0xFF00) | ord($haslo[$i]); $x1 &= 0xFFFF;
            $y0 ^= $x0; $y1 ^= $x1;
            $y0 += $x0; $y1 += $x1;
            $x1 <<= 8; $x1 |= ($x0 >> 8); $x0 <<= 8;
            $y0 ^= $x0; $y1 ^= $x1;
            $x1 <<= 8; $x1 |= ($x0 >> 8); $x0 <<= 8;
            $y0 -= $x0; $y1 -= $x1;
            $x1 <<= 8; $x1 |= ($x0 >> 8); $x0 <<= 8;
            $y0 ^= $x0; $y1 ^= $x1;
            $z = $y0 & 0x1F;
            $y0 &= 0xFFFF; $y1 &= 0xFFFF;
            if ($z <= 16)
            {
                $tmp= ($y1 << $z) | ($y0 >> (16-$z));
                $y0 = ($y1 >> (16-$z)) | ($y0 << $z);
                $y1 = $tmp;    
            }else{
                $tmp= $y0 << ($z-16);
                $y0 = ($y0 >> (32-$z)) | ( (($y1 << $z) >> $z) << ($z-16) );
                $y1 = ($y1 >> (32-$z)) | $tmp;
            }
            $y0 &= 0xFFFF; $y1 &= 0xFFFF;
        }
        $hash = hexdec(sprintf("%04x%04x", $y1, $y0));
        settype($hash, 'integer');
        return $hash;
    }

	function cp1250_to_utf8($tekst)
	{
	  $wynik = '';
	  for ($i=0; $i<strlen($tekst); $i++)
	  {
	    switch ($tekst[$i])
	    {
	      case '¹': $wynik .= 'Ä…'; break;
	      case 'æ': $wynik .= 'Ä‡'; break;
	      case 'ê': $wynik .= 'Ä™'; break;
	      case '³': $wynik .= 'Å‚'; break;
	      case 'ñ': $wynik .= 'Å„'; break;
	      case 'ó': $wynik .= 'Ã³'; break;
	      case 'œ': $wynik .= 'Å›'; break;
	      case 'Ÿ': $wynik .= 'Åº'; break;
	      case '¿': $wynik .= 'Å¼'; break;	
	      case '¥': $wynik .= 'Ä„'; break;
	      case 'Æ': $wynik .= 'Ä†'; break;
	      case 'Ê': $wynik .= 'Ä˜'; break;
	      case '£': $wynik .= 'Å'; break;
	      case 'Ñ': $wynik .= 'Åƒ'; break;
	      case 'Ó': $wynik .= 'Ã“'; break;
	      case 'Œ': $wynik .= 'Åš'; break;
	      case '': $wynik .= 'Å¹'; break;
	      case '¯': $wynik .= 'Å»'; break;
	      default: $wynik .= $tekst[$i];
	    }
	  }
	  return $wynik;
	}

    function get_gg_status($numer_gg, $haslo_gg, $szukany_numer, &$error, &$gg_status_widocznosc)
    {       
      define("GG_WELCOME",					0x0001);
      define("GG_LOGIN",					0x000c);
      define("GG_LOGIN60",					0x0015);
      define("GG_LOGIN_OK",					0x0003);
      define("GG_LOGIN_FAILED",				0x0009);
      define("GG_NEW_STATUS",				0x0002);
      define("GG_STATUS",					0x0002);
      define("GG_STATUS_NOT_AVAIL",			0x0001);
      define("GG_STATUS_NOT_AVAIL_DESCR",	0x0015);
      define("GG_STATUS_AVAIL",				0x0002);
      define("GG_STATUS_AVAIL_DESCR",		0x0004);
      define("GG_STATUS_BUSY",				0x0003);
      define("GG_STATUS_BUSY_DESCR",		0x0005);
      define("GG_STATUS_INVISIBLE",			0x0014);
      define("GG_NOTIFY",					0x0010);
      define("GG_NOTIFY_REPLY",				0x000c);
      define("GG_NOTIFY_REPLY60",			0x0011);
      define("GG_USER_NORMAL",				0x0003);
      define("GG_USER_BLOCKED",				0x0004);
      define("GG_SEND_MSG",					0x000b);
      define("GG_CLASS_MSG",				0x0004);
      define("GG_CLASS_CHAT",				0x0008);
      define("GG_CLASS_ACK",				0x0020);
      define("GG_SEND_MSG_ACK",				0x0005);
      define("GG_ACK_DELIVERED",			0x0002);
      define("GG_ACK_QUEUED",				0x0003);
      define("GG_RECV_MSG",					0x000a);
      define("GG_LOGIN_FAILED2",			0x000B);
      define("GG_ACK_MBOXFULL",				0x0004);
      define("DISCONNECTED",				0x0100);
      define("GG_PUBDIR50_REQUEST",			0x0014);
      define("GG_PUBDIR50_REPLY",			0x000e);
      define("GG_PUBDIR50_SEARCH",			0x0003);

	  
	  //
	  // Getting a logon server
	  //
      if (function_exists('serendipity_request_url')) {
        $buf = serendipity_request_url('http://appmsg.gadu-gadu.pl:80/appsvc/appmsg.asp?fmnumber=<'.$numer_gg.'>');
        if ($serendipity['last_http_request']['responseCode'] != '200') {
          $error = PLUGIN_GGOPIS_MSG_NOCONNTOAPPMSG . $errno . " - " . $errstr . "\n";
          return false;
        }
      } else {
        require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
        serendipity_request_start();
        $req = new HTTP_Request('http://appmsg.gadu-gadu.pl:80/appsvc/appmsg.asp?fmnumber=<'.$numer_gg.'>');
        if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
          $error = PLUGIN_GGOPIS_MSG_NOCONNTOAPPMSG . $errno . " - " . $errstr . "\n";
          serendipity_request_end();
          return false;
        } else {
          $buf = $req->getResponseBody();
          serendipity_request_end();
	      }
      }

      preg_match("/\s([\d\.]{8,16})\:([\d]{1,5})\s/", $buf, $adres);
      $host = $adres[1];
      $port = $adres[2];


	  //
	  // Connecting to a server
	  //
      require_once S9Y_PEAR_PATH . 'Net/Socket.php';
	  $conn = new Net_Socket();
	  if (!$conn->connect($host, $port, null, 10)) {
        $error = PLUGIN_GGOPIS_MSG_CONNERROR . ": $errno - $errstr\n\n";
        return false;
	  }

	  //
	  // Getting data from a server -
	  // receiving a key needed to calculate
	  // a hash from your password
	  //
	  if (!$data = $conn->read(12)) {
        $error = PLUGIN_GGOPIS_MSG_CONNUNEXPCLOSED . "\n\n";
		$conn->disconnect();
        return false;
	  }
      $tab = unpack("Vtyp/Vrozmiar/Vklucz", $data);

      // Calculating a password hash
      $hash = $this->calculate_hash($haslo_gg, $tab['klucz']);
      $data = pack("VVVVVVvVvVvCCa".strlen(""), GG_LOGIN60, 0x20 + strlen(""), $numer_gg, $hash, GG_STATUS_AVAIL, 0x20, 0, 0, 0, 0, 0, 0x14, 0xbe , "");

      // Sending a password hash - logging to a GG server
	  $conn->write($data);
      if (!$data1 = $conn->read(8)) {
        $error = PLUGIN_GGOPIS_MSG_UNKNOWNERROR . "\n";
		$conn->disconnect();
        return false;
      }
	  // Checking a login status
      $tab = unpack("Vlogin_status/Vrozmiar", $data1);
      if ($tab['login_status'] != GG_LOGIN_OK) {
        $error = PLUGIN_GGOPIS_MSG_INCORRPASSWD . "\n\n";
		$conn->disconnect();
        return false;
      }

      // Sending a contact list with one contact
      $data = pack ("VVVC",GG_NOTIFY, 5, $szukany_numer, GG_USER_NORMAL);
      if (!$conn->write($data)) {
        $error = PLUGIN_GGOPIS_MSG_SENDCONTACTSERROR . "\n\n";
		$conn->disconnect();
        return false;
      }
      // Receiving a packet with the next packet specification
      $gg_opis = '';
      $data = $conn->read(8);
      if (strlen($data) > 0) {      
        $tab = unpack("Vtyp/Vrozmiar", $data);
        // Pobranie pakietu opisu
        // DEBUG: echo $tab['rozmiar'];
		$data = $conn->read($tab['rozmiar']);
		if ($tab['rozmiar'] > 14) {
          $tablica = unpack("Iuin/Cstatus/Iremoteip/Sremoteport/Cversion/Cimagesize/Cunknown/Cdescription_size/a*description", $data);
          // Getting a status description, and converting it from CP1250 (that's how it's encoded) to UTF8
		  $gg_opis = $this->cp1250_to_utf8($tablica['description']);
          // Getting a status itself
		  $gg_status_flaga = $tablica['status'];
		} else {
          $tablica = unpack("Iuin/Cstatus", $data);
          // Getting a status
		  $gg_status_flaga = $tablica['status'];
		}
		  if (empty($gg_opis)) $gg_opis = PLUGIN_GGOPIS_MSG_NOSTATUSDESC;

          // Choosing a status icon to display
		  switch ($gg_status_flaga) {
            case GG_STATUS_NOT_AVAIL:
            case GG_STATUS_NOT_AVAIL_DESCR:
                $gg_status_widocznosc = 'gg11';
                break;
            case GG_STATUS_AVAIL:
            case GG_STATUS_AVAIL_DESCR:
                $gg_status_widocznosc = 'gg12';
                break;
            case GG_STATUS_BUSY:
            case GG_STATUS_BUSY_DESCR:
                $gg_status_widocznosc = 'gg13';
                break;
            default:
                $gg_status_widocznosc = 'gg11';
          }
        }
        else
        {
          $gg_opis = PLUGIN_GGOPIS_MSG_NOSTATUSDESC;
        }
        // Closing a connection to the server
        $conn->disconnect();
        return $gg_opis;
    }
    
    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE);
                $propbag->add('default',     '');
                break;
                
            case 'gggateid':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GGOPIS_GGGATEID);
                $propbag->add('description', PLUGIN_GGOPIS_GGGATEID_DESC);
                $propbag->add('default',     '1234');
                break;
                
            case 'gggatepasswd':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GGOPIS_GGGATEPASSWD);
                $propbag->add('description', PLUGIN_GGOPIS_GGGATEPASSWD_DESC);
                $propbag->add('default',     'haselko');
                break;
                
            case 'ggid':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_GGOPIS_GGID);
                $propbag->add('description', PLUGIN_GGOPIS_GGID_DESC);
                $propbag->add('default',     '5678');
                break;              
                
            default:
                    return false;
        }
        return true;
    }

    function send_message($adresat, $tresc)
    {
    }
    
    /*
	 * TODO: make a sending message function :)
  function wyslij_wiadomosc($adresat, $tresc, $potwierdzenie = TRUE)
  {
    $tresc = txt::iso2cp($tresc);
    $seq = mt_rand();
    
    $data = pack("VVVVVa".strlen($tresc)."C", GG_SEND_MSG, 0x0d + strlen($tresc), $adresat,
		 $seq,  ($potwierdzenie)?GG_CLASS_MSG:GG_CLASS_MSG | GG_CLASS_ACK, $tresc, 0);
    $this->Debug("WysÅ‚ano pakiet wiadomoÅ›ci : ".bin2hex($data), $data);
    
    $this->status_dostarczenia[$seq] = FALSE; //zmieni sie przy otrzymaniu potwierdzenia
    
    if (!fwrite($this->fp, $data)) 
      return FALSE;

  return $seq;
  }    
   */ 

    function generate_content(&$title) {
        global $serendipity;

        $title = $this->get_config('title', $this->title);

        $url = serendipity_currentURL(true);

        $error = '';
        $gggateid = $this->get_config('gggateid', '1234');
        $gggatepasswd = $this->get_config('gggatepasswd', 'haselko');
        $ggid = $this->get_config('ggid', '5678');
        $gg_status_widocznosc = 'gg11';
        $gg_status_opis = $this->get_gg_status($gggateid, $gggatepasswd, $ggid, $error, $gg_status_widocznosc);
        
        echo '<div align="center">';
        echo '<b>GG UIN: '.$ggid.'</b><br/>';
        echo "<img src=\"".$serendipity['baseURL']."plugins/serendipity_plugin_ggopis/img/".$gg_status_widocznosc.".png\"/><br/>";
        echo $gg_status_opis;
        echo '</div>';
    }
}

