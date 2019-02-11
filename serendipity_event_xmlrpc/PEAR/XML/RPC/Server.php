<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Server commands for our PHP implementation of the XML-RPC protocol
 *
 * This is a PEAR-ified version of Useful inc's XML-RPC for PHP.
 * It has support for HTTP transport, proxies and authentication.
 *
 * PHP versions 4 and 5
 *
 * @category   Web Services
 * @package    XML_RPC
 * @author     Edd Dumbill <edd@usefulinc.com>
 * @author     Stig Bakken <stig@php.net>
 * @author     Martin Jansen <mj@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1999-2001 Edd Dumbill, 2001-2010 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License
 * @version    SVN: 
 * @link       http://pear.php.net/package/XML_RPC
 */


/**
 * Pull in the XML_RPC class
 */
if (!class_exists('XML_RPC_Base')) {
    require_once dirname(__FILE__) . '/../RPC.php';
}

/**
 * signature for system.listMethods: return = array,
 * parameters = a string or nothing
 * @global array $GLOBALS['XML_RPC_Server_listMethods_sig']
 */
$GLOBALS['XML_RPC_Server_listMethods_sig'] = array(
    array($GLOBALS['XML_RPC_Array'],
          $GLOBALS['XML_RPC_String']
    ),
    array($GLOBALS['XML_RPC_Array'])
);

/**
 * docstring for system.listMethods
 * @global string $GLOBALS['XML_RPC_Server_listMethods_doc']
 */
$GLOBALS['XML_RPC_Server_listMethods_doc'] = 'This method lists all the'
        . ' methods that the XML-RPC server knows how to dispatch';

/**
 * signature for system.methodSignature: return = array,
 * parameters = string
 * @global array $GLOBALS['XML_RPC_Server_methodSignature_sig']
 */
$GLOBALS['XML_RPC_Server_methodSignature_sig'] = array(
    array($GLOBALS['XML_RPC_Array'],
          $GLOBALS['XML_RPC_String']
    )
);

/**
 * docstring for system.methodSignature
 * @global string $GLOBALS['XML_RPC_Server_methodSignature_doc']
 */
$GLOBALS['XML_RPC_Server_methodSignature_doc'] = 'Returns an array of known'
        . ' signatures (an array of arrays) for the method name passed. If'
        . ' no signatures are known, returns a none-array (test for type !='
        . ' array to detect missing signature)';

/**
 * signature for system.methodHelp: return = string,
 * parameters = string
 * @global array $GLOBALS['XML_RPC_Server_methodHelp_sig']
 */
$GLOBALS['XML_RPC_Server_methodHelp_sig'] = array(
    array($GLOBALS['XML_RPC_String'],
          $GLOBALS['XML_RPC_String']
    )
);

/**
 * docstring for methodHelp
 * @global string $GLOBALS['XML_RPC_Server_methodHelp_doc']
 */
$GLOBALS['XML_RPC_Server_methodHelp_doc'] = 'Returns help text if defined'
        . ' for the method passed, otherwise returns an empty string';

/**
 * dispatch map for the automatically declared XML-RPC methods.
 * @global array $GLOBALS['XML_RPC_Server_dmap']
 */
$GLOBALS['XML_RPC_Server_dmap'] = array(
    'system.listMethods' => array(
        'function'  => 'XML_RPC_Server_listMethods',
        'signature' => $GLOBALS['XML_RPC_Server_listMethods_sig'],
        'docstring' => $GLOBALS['XML_RPC_Server_listMethods_doc']
    ),
    'system.methodHelp' => array(
        'function'  => 'XML_RPC_Server_methodHelp',
        'signature' => $GLOBALS['XML_RPC_Server_methodHelp_sig'],
        'docstring' => $GLOBALS['XML_RPC_Server_methodHelp_doc']
    ),
    'system.methodSignature' => array(
        'function'  => 'XML_RPC_Server_methodSignature',
        'signature' => $GLOBALS['XML_RPC_Server_methodSignature_sig'],
        'docstring' => $GLOBALS['XML_RPC_Server_methodSignature_doc']
    ),
    'system.multiCall' => array (
        'function' => 'XML_RPC_Server_system_multiCall', 
        'signature' => array (array ($GLOBALS['XML_RPC_Array'], $GLOBALS['XML_RPC_Array'])), 
    	'docstring' => 'Executes multiple methods in sequence and returns the results '.
        '(implements http://www.xmlrpc.com/discuss/msgReader$1208).'
    ), 
    'system.multicall' => array (
        'function' => 'XML_RPC_Server_system_multiCall', 
//        'signature' => array (array ($XML_RPC_Array, $XML_RPC_Array)), 
        'docstring' => 'Executes multiple methods in sequence and returns the results '.
        '(implements http://www.xmlrpc.com/discuss/msgReader$1208).'
    ), 
    'system.time' => array (
        'function' => 'XML_RPC_Server_system_time', 
        'signature' => array (array ()), 
        'docstring' => 'Return the server time as unix time stamp')
);

/**
 * @global string $GLOBALS['XML_RPC_Server_debuginfo']
 */
$GLOBALS['XML_RPC_Server_debuginfo'] = '';


/**
 * Lists all the methods that the XML-RPC server knows how to dispatch
 *
 * @return object  a new XML_RPC_Response object
 */
function XML_RPC_Server_listMethods($server, $m)
{
    global $XML_RPC_err, $XML_RPC_str, $XML_RPC_Server_dmap;

    $v = new XML_RPC_Value();
    $outAr = array();
    foreach ($server->dmap as $key => $val) {
        $outAr[] = new XML_RPC_Value($key, 'string');
    }
    foreach ($XML_RPC_Server_dmap as $key => $val) {
        $outAr[] = new XML_RPC_Value($key, 'string');
    }
    $v->addArray($outAr);
    return new XML_RPC_Response($v);
}

/**
 * Returns an array of known signatures (an array of arrays)
 * for the given method
 *
 * If no signatures are known, returns a none-array
 * (test for type != array to detect missing signature)
 *
 * @return object  a new XML_RPC_Response object
 */
function XML_RPC_Server_methodSignature($server, $m)
{
    global $XML_RPC_err, $XML_RPC_str, $XML_RPC_Server_dmap;

    $methName = $m->getParam(0);
    $methName = $methName->scalarval();
    if (strpos($methName, 'system.') === 0) {
        $dmap = $XML_RPC_Server_dmap;
        $sysCall = 1;
    } else {
        $dmap = $server->dmap;
        $sysCall = 0;
    }
    //  print "<!-- ${methName} -->\n";
    if (isset($dmap[$methName])) {
        if ($dmap[$methName]['signature']) {
            $sigs = array();
            $thesigs = $dmap[$methName]['signature'];
            for ($i = 0; $i < sizeof($thesigs); $i++) {
                $cursig = array();
                $inSig = $thesigs[$i];
                for ($j = 0; $j < sizeof($inSig); $j++) {
                    $cursig[] = new XML_RPC_Value($inSig[$j], 'string');
                }
                $sigs[] = new XML_RPC_Value($cursig, 'array');
            }
            $r = new XML_RPC_Response(new XML_RPC_Value($sigs, 'array'));
        } else {
            $r = new XML_RPC_Response(new XML_RPC_Value('undef', 'string'));
        }
    } else {
        $r = new XML_RPC_Response(0, $XML_RPC_err['introspect_unknown'],
                                  $XML_RPC_str['introspect_unknown']);
    }
    return $r;
}

/**
 * Returns help text if defined for the method passed, otherwise returns
 * an empty string
 *
 * @return object  a new XML_RPC_Response object
 */
function XML_RPC_Server_methodHelp($server, $m)
{
    global $XML_RPC_err, $XML_RPC_str, $XML_RPC_Server_dmap;

    $methName = $m->getParam(0);
    $methName = $methName->scalarval();
    if (strpos($methName, 'system.') === 0) {
        $dmap = $XML_RPC_Server_dmap;
        $sysCall = 1;
    } else {
        $dmap = $server->dmap;
        $sysCall = 0;
    }

    if (isset($dmap[$methName])) {
        if ($dmap[$methName]['docstring']) {
            $r = new XML_RPC_Response(new XML_RPC_Value($dmap[$methName]['docstring']),
                                                        'string');
        } else {
            $r = new XML_RPC_Response(new XML_RPC_Value('', 'string'));
        }
    } else {
        $r = new XML_RPC_Response(0, $XML_RPC_err['introspect_unknown'],
                                     $XML_RPC_str['introspect_unknown']);
    }
    return $r;
}
    
/**
 * Executes multiple methods in sequence and returns the results 
 * (implements http://www.xmlrpc.com/discuss/msgReader$1208)
 *
 * @return object  a new XML_RPC_Response object
 */
function XML_RPC_Server_system_multiCall($server, $msg) {
    $dmap = $server->dmap;
    
    $array = $msg;
    for ($i = 0; $i < $array->getNumParams(); $i ++) {
        $details = $array->getParam($i);
        
        if ($details->kindOf() != 'struct') 
        {
            $resp = new XML_RPC_Response(0, $GLOBALS['XML_RPC_err']['incorrect_params'], 
              "system_multiCall() expects _only_ struct datatypes wrapped in one array.");  
        }
        elseif ($details->arraysize() >= 1) {

            // check if method name a string pointing to valid function
            if ( !is_a($method_obj = $details->structmem('methodName'), 'XML_RPC_value') 
                  || ($method_obj->kindOf() != 'scalar')
                  || !($method = $method_obj->scalarVal()) 
                  || !strlen($function = $dmap[$method]['function']) ) 
            {
              
              $resp = new XML_RPC_Response(0, $GLOBALS['XML_RPC_err']['incorrect_params'], 
                    "system_multiCall() method call '$method' type '".gettype($method).
                    "' resolves to an invalid function. Parameter or dmap configuration problem?");         
            }
            // check params object valid
            elseif ( ($params = $details->structmem('params')) && (!is_a($params, 'XML_RPC_Value') 
                      || $params->kindOf() != 'array') ) 
            {
              
              $resp = new XML_RPC_Response(0, $GLOBALS['XML_RPC_err']['incorrect_params'], 
                    "system_multiCall() method call '$function' parameters container " .
                    "is not a XML_RPC_Value type '$GLOBALS[XML_RPC_Array]'.");
            }
            // don't call multiCall recursive
            elseif ( preg_match("/\bsystem_multiCall$/i", $function) ) 
            {
              
              $resp = new XML_RPC_Response(0, $GLOBALS['XML_RPC_err']['incorrect_params'], 
                            "system_multiCall() must not be called recursively.");
            }
            // process params, build a message, execute procedure call
            else 
            {
                // build array containing xml_rpc_value of each param
                $params_list = array ();
                for ($j = 0; isset ($params) && $j < $params->arraysize(); $j ++) {
                    $params_list[] = $param = $params->arraymem($j);
                }
              
                $msg = new XML_RPC_Message($method, $params_list);
                $msg->setSendEncoding($server->encoding);
                $resp = $server->execute($function, $msg);
            }

        } 
        else 
        {
            $resp = new XML_RPC_Response(0, $GLOBALS['XML_RPC_err']['incorrect_params'], 
                                            "system_multiCall() must be called with at" . 
                                            "least the functions name as parameter 1");
        }

        // convert error to struct (multiCall Spec)
        if (!$resp->faultCode()) {
            $xml_response = array();
            $xml_response[] = $resp->value();
            $values[] = new XML_RPC_Value($xml_response, 'array');
            //$values[] = $resp->value();
        } 
        else {
            $value = new XML_RPC_Value;
            $value->addStruct( array( 'faultCode' => new XML_RPC_Value($resp->faultCode(), 
                                                                       $GLOBALS['XML_RPC_Int']), 
                                      'faultString' => new XML_RPC_Value($resp->faultString(), 
                                                                         $GLOBALS['XML_RPC_String'])));
            $values[] = $value;
        }
    }

    $v = new XML_RPC_Value();
    $v->addArray($values);

    return new XML_RPC_Response($v);
}

/**
 * Simply returns system time
 *
 * @return object  a new XML_RPC_Response object
 */
function XML_RPC_Server_system_time() 
{
    $val = new XML_RPC_Value(time(), 'int');
    $resp = new XML_RPC_Response($val);
    return $resp;
}

/**
 * @return void
 */
function XML_RPC_Server_debugmsg($m)
{
    global $XML_RPC_Server_debuginfo;
    $XML_RPC_Server_debuginfo = $XML_RPC_Server_debuginfo . $m . "\n";
}


/**
 * A server for receiving and replying to XML RPC requests
 *
 * <code>
 * $server = new XML_RPC_Server(
 *     array(
 *         'isan8' =>
 *             array(
 *                 'function' => 'is_8',
 *                 'signature' =>
 *                      array(
 *                          array('boolean', 'int'),
 *                          array('boolean', 'int', 'boolean'),
 *                          array('boolean', 'string'),
 *                          array('boolean', 'string', 'boolean'),
 *                      ),
 *                 'docstring' => 'Is the value an 8?'
 *             ),
 *     ),
 *     1,
 *     0
 * ); 
 * </code>
 *
 * @category   Web Services
 * @package    XML_RPC
 * @author     Edd Dumbill <edd@usefulinc.com>
 * @author     Stig Bakken <stig@php.net>
 * @author     Martin Jansen <mj@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1999-2001 Edd Dumbill, 2001-2010 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/XML_RPC
 */
class XML_RPC_Server
{
    /**
     * Should the payload's content be passed through mb_convert_encoding()?
     *
     * @see XML_RPC_Server::setConvertPayloadEncoding()
     * @since Property available since Release 1.5.1
     * @var boolean
     */
    var $convert_payload_encoding = false;

    /**
     * The dispatch map, listing the methods this server provides.
     * @var array
     */
    var $dmap = array();

    /**
     * The present response's encoding
     * @var string
     * @see XML_RPC_Message::getEncoding()
     */
    var $encoding = '';

    /**
     * Debug mode (0 = off, 1 = on)
     * @var integer
     */
    var $debug = 0;

    /**
     * The response's HTTP headers
     * @var string
     */
    var $server_headers = '';

    /**
     * The response's XML payload
     * @var string
     */
    var $server_payload = '';


    /**
     * Constructor for the XML_RPC_Server class
     *
     * @param array $dispMap   the dispatch map. An associative array
     *                          explaining each function. The keys of the main
     *                          array are the procedure names used by the
     *                          clients. The value is another associative array
     *                          that contains up to three elements:
     *                            + The 'function' element's value is the name
     *                              of the function or method that gets called.
     *                              To define a class' method: 'class::method'.
     *                            + The 'signature' element (optional) is an
     *                              array describing the return values and
     *                              parameters
     *                            + The 'docstring' element (optional) is a
     *                              string describing what the method does
     * @param int $serviceNow  should the HTTP response be sent now?
     *                          (1 = yes, 0 = no)
     * @param int $debug       should debug output be displayed?
     *                          (1 = yes, 0 = no)
     *
     * @return void
     */
    function __construct($dispMap, $serviceNow = 1, $debug = 0)
    {
        global $HTTP_RAW_POST_DATA;

        if ($debug) {
            $this->debug = 1;
        } else {
            $this->debug = 0;
        }

        $this->dmap = $dispMap;

        if ($serviceNow) {
            $this->service();
        } else {
            $this->createServerPayload();
            $this->createServerHeaders();
        }
    }

    /**
     * @return string  the debug information if debug debug mode is on
     */
    function serializeDebug()
    {
        global $XML_RPC_Server_debuginfo, $HTTP_RAW_POST_DATA;

        if ($this->debug) {
            XML_RPC_Server_debugmsg('vvv POST DATA RECEIVED BY SERVER vvv' . "\n"
                                    . $HTTP_RAW_POST_DATA
                                    . "\n" . '^^^ END POST DATA ^^^');
        }

        if ($XML_RPC_Server_debuginfo != '') {
            return "<!-- PEAR XML_RPC SERVER DEBUG INFO:\n\n"
                   . str_replace('--', '- - ', $XML_RPC_Server_debuginfo)
                   . "-->\n";
        } else {
            return '';
        }
    }

    /**
     * Sets whether the payload's content gets passed through
     * mb_convert_encoding()
     *
     * Returns PEAR_ERROR object if mb_convert_encoding() isn't available.
     *
     * @param int $in  where 1 = on, 0 = off
     *
     * @return void
     *
     * @see XML_RPC_Message::getEncoding()
     * @since Method available since Release 1.5.1
     */
    function setConvertPayloadEncoding($in)
    {
        if ($in && !function_exists('mb_convert_encoding')) {
            return $this->raiseError('mb_convert_encoding() is not available',
                              XML_RPC_ERROR_PROGRAMMING);
        }
        $this->convert_payload_encoding = $in;
    }

    /**
     * Sends the response
     *
     * The encoding and content-type are determined by
     * XML_RPC_Message::getEncoding()
     *
     * @return void
     *
     * @uses XML_RPC_Server::createServerPayload(),
     *       XML_RPC_Server::createServerHeaders()
     */
    function service()
    {
        if (!$this->server_payload) {
            $this->createServerPayload();
        }
        if (!$this->server_headers) {
            $this->createServerHeaders();
        }

        /*
         * $server_headers needs to remain a string for compatibility with
         * old scripts using this package, but PHP 4.4.2 no longer allows
         * line breaks in header() calls.  So, we split each header into
         * an individual call.  The initial replace handles the off chance
         * that someone composed a single header with multiple lines, which
         * the RFCs allow.
         */
        $this->server_headers = preg_replace("@[\r\n]+[ \t]+@",
                                ' ', trim($this->server_headers));
        $headers = preg_split("@[\r\n]+@", $this->server_headers);
        foreach ($headers as $header)
        {
            header($header);
        }

        print $this->server_payload;
    }

    /**
     * Generates the payload and puts it in the $server_payload property
     *
     * If XML_RPC_Server::setConvertPayloadEncoding() was set to true,
     * the payload gets passed through mb_convert_encoding()
     * to ensure the payload matches the encoding set in the
     * XML declaration.  The encoding type can be manually set via
     * XML_RPC_Message::setSendEncoding().
     *
     * @return void
     *
     * @uses XML_RPC_Server::parseRequest(), XML_RPC_Server::$encoding,
     *       XML_RPC_Response::serialize(), XML_RPC_Server::serializeDebug()
     * @see  XML_RPC_Server::setConvertPayloadEncoding()
     */
    function createServerPayload()
    {
        $r = $this->parseRequest();
        $this->server_payload = '<?xml version="1.0" encoding="'
                              . $this->encoding . '"?>' . "\n"
                              . $this->serializeDebug()
                              . $r->serialize();
        if ($this->convert_payload_encoding) {
            $this->server_payload = mb_convert_encoding($this->server_payload,
                                                        $this->encoding);
        }
    }

    /**
     * Determines the HTTP headers and puts them in the $server_headers
     * property
     *
     * @return boolean  TRUE if okay, FALSE if $server_payload isn't set.
     *
     * @uses XML_RPC_Server::createServerPayload(),
     *       XML_RPC_Server::$server_headers
     */
    function createServerHeaders()
    {
        if (!$this->server_payload) {
            return false;
        }
        $this->server_headers = 'Content-Length: '
                              . strlen($this->server_payload) . "\r\n"
                              . 'Content-Type: text/xml;'
                              . ' charset=' . $this->encoding;
        return true;
    }

    /**
     * @return array
     */
    function verifySignature($in, $sig)
    {
        for ($i = 0; $i < sizeof($sig); $i++) {
            // check each possible signature in turn
            $cursig = $sig[$i];
            if (sizeof($cursig) == $in->getNumParams() + 1) {
                $itsOK = 1;
                for ($n = 0; $n < $in->getNumParams(); $n++) {
                    $p = $in->getParam($n);
                    // print "<!-- $p -->\n";
                    if ($p->kindOf() == 'scalar') {
                        $pt = $p->scalartyp();
                    } else {
                        $pt = $p->kindOf();
                    }
                    // $n+1 as first type of sig is return type
                    if ($pt != $cursig[$n+1]) {
                        $itsOK = 0;
                        $pno = $n+1;
                        $wanted = $cursig[$n+1];
                        $got = $pt;
                        break;
                    }
                }
                if ($itsOK) {
                    return array(1);
                }
            }
        }
        if (isset($wanted)) {
            return array(0, "Wanted ${wanted}, got ${got} at param ${pno}");
        } else {
            $allowed = array();
            foreach ($sig as $val) {
                end($val);
                $allowed[] = key($val);
            }
            $allowed = array_unique($allowed);
            $last = count($allowed) - 1;
            if ($last > 0) {
                $allowed[$last] = 'or ' . $allowed[$last];
            }
            return array(0,
                         'Signature permits ' . implode(', ', $allowed)
                                . ' parameters but the request had '
                                . $in->getNumParams());
        }
    }

    /**
     * @return object  a new XML_RPC_Response object
     *
     * @uses XML_RPC_Message::getEncoding(), XML_RPC_Server::$encoding
     */
    function parseRequest($data = '')
    {
        global $XML_RPC_xh, $HTTP_RAW_POST_DATA,
                $XML_RPC_err, $XML_RPC_str, $XML_RPC_errxml,
                $XML_RPC_defencoding, $XML_RPC_Server_dmap;

        if ($data == '') {
            $data = $HTTP_RAW_POST_DATA;
        }

        $this->encoding = XML_RPC_Message::getEncoding($data);
        $parser_resource = xml_parser_create($this->encoding);
        $parser = (int) $parser_resource;

        $XML_RPC_xh[$parser] = array();
        $XML_RPC_xh[$parser]['cm']     = 0;
        $XML_RPC_xh[$parser]['isf']    = 0;
        $XML_RPC_xh[$parser]['params'] = array();
        $XML_RPC_xh[$parser]['method'] = '';
        $XML_RPC_xh[$parser]['stack'] = array();	
        $XML_RPC_xh[$parser]['valuestack'] = array();	

        $plist = '';

        // decompose incoming XML into request structure

        xml_parser_set_option($parser_resource, XML_OPTION_CASE_FOLDING, true);
        xml_set_element_handler($parser_resource, 'XML_RPC_se', 'XML_RPC_ee');
        xml_set_character_data_handler($parser_resource, 'XML_RPC_cd');
        if (!xml_parse($parser_resource, $data, 1)) {
            // return XML error as a faultCode
            $r = new XML_RPC_Response(0,
                                      $XML_RPC_errxml+xml_get_error_code($parser_resource),
                                      sprintf('XML error: %s at line %d',
                                              xml_error_string(xml_get_error_code($parser_resource)),
                                              xml_get_current_line_number($parser_resource)));
            xml_parser_free($parser_resource);
        } elseif ($XML_RPC_xh[$parser]['isf']>1) {
            $r = new XML_RPC_Response(0,
                                      $XML_RPC_err['invalid_request'],
                                      $XML_RPC_str['invalid_request']
                                      . ': '
                                      . $XML_RPC_xh[$parser]['isf_reason']);
            xml_parser_free($parser_resource);
        } else {
            xml_parser_free($parser_resource);
            $m = new XML_RPC_Message($XML_RPC_xh[$parser]['method']);
            // now add parameters in
            for ($i = 0; $i < sizeof($XML_RPC_xh[$parser]['params']); $i++) {
                // print '<!-- ' . $XML_RPC_xh[$parser]['params'][$i]. "-->\n";
                $plist .= "$i - " . var_export($XML_RPC_xh[$parser]['params'][$i], true) . " \n";
                $m->addParam($XML_RPC_xh[$parser]['params'][$i]);
            }

            if ($this->debug) {
                XML_RPC_Server_debugmsg($plist);
            }

            // now to deal with the method
            $methName = $XML_RPC_xh[$parser]['method'];
            if (strpos($methName, 'system.') === 0) {
                $dmap = $XML_RPC_Server_dmap;
                $sysCall = 1;
            } else {
                $dmap = $this->dmap;
                $sysCall = 0;
            }

            if (isset($dmap[$methName]['function'])
                && is_string($dmap[$methName]['function'])
                && strpos($dmap[$methName]['function'], '::') !== false)
            {
                $dmap[$methName]['function'] =
                        explode('::', $dmap[$methName]['function']);
            }

            if (isset($dmap[$methName]['function'])
                && is_callable($dmap[$methName]['function']))
            {
                // dispatch if exists
                if (isset($dmap[$methName]['signature'])) {
                    $sr = $this->verifySignature($m,
                                                 $dmap[$methName]['signature'] );
                }
                if (!isset($dmap[$methName]['signature']) || $sr[0]) {
                    // if no signature or correct signature
                    if ($sysCall) {
                        $r = call_user_func($dmap[$methName]['function'], $this, $m);
                    } else {
                        $r = call_user_func($dmap[$methName]['function'], $m);
                    }
                    if (!is_object($r) || !is_a($r, 'XML_RPC_Response')) {
                        $r = new XML_RPC_Response(0, $XML_RPC_err['not_response_object'],
                                                  $XML_RPC_str['not_response_object']);
                    }
                } else {
                    $r = new XML_RPC_Response(0, $XML_RPC_err['incorrect_params'],
                                              $XML_RPC_str['incorrect_params']
                                              . ': ' . $sr[1]);
                }
            } else {
                // else prepare error response
                $r = new XML_RPC_Response(0, $XML_RPC_err['unknown_method'],
                                          $XML_RPC_str['unknown_method'] . ": " . $methName);
            }
        }
        return $r;
    }

    /**
     * Echos back the input packet as a string value
     *
     * @return void
     *
     * Useful for debugging.
     */
    function echoInput()
    {
        global $HTTP_RAW_POST_DATA;

        $r = new XML_RPC_Response(0);
        $r->xv = new XML_RPC_Value("'Aha said I: '" . $HTTP_RAW_POST_DATA, 'string');
        print $r->serialize();
    }

    /**
     * Executes the function defined in dmap and return result in response form 
     * or return 'method not found' response error. 
     * Note: 
     *   It is expected that the called function/method returns a valid response
     *   object.
     * 
     * Supported are:
     * <ul>
     *  <li>
     *   Static class functions in form of 'Class::function'
     *  </i>
     *  <li>
     *   Server objects methods in form of 'Classname.Methodname', whilst classname 
     *   must be the classname of the XML_RPC_Server object serverside
     *  </li>
     *  <li>
     *   Static functions in global namespace in form of 'function'
     *  </li>
     * </ul>
     *
     * @return object  a new XML_RPC_Response object
     */
    function execute($function, $msg) {
        global $XML_RPC_err, $XML_RPC_str;
        
        /*
        // if signature does not match
        $result = $this->verifySignature($msg, $sig);
        if (is_array($result) && $result[0]==1)
        //if (PEAR :: isError($err = $this->verifySignature($msg, $sig)))
        {
            return new XML_RPC_Response(0, $XML_RPC_err['incorrect_params'], $XML_RPC_str['incorrect_params'].': '.$err->getMessage());
        }
        */
        
        if (!preg_match("/:|\./", $function) && is_callable($function, false)) 
        {
            //echo "<p>Function '$function'</p>";
            $r = call_user_func($function, $msg);
        }
        elseif (preg_match("/^([^\.]+)\.([^\.]+)$/i", $function, $matches) 
                && is_callable(array ($object = $matches[1], $method = $matches[2]), false) 
                && preg_match("/^".preg_quote($object)."$/i", get_class($this))) 
        {
    
            //echo "<p>ServerObject '$function' '".get_class($this)."'</p>";
            $r = call_user_func(array ($this, $method), $msg);
        }
        elseif (preg_match("/^([\w]+)(?:::)([\w]+)$/i", $function, $matches) 
                && class_exists($class = $matches[1]) 
                && in_array(strtolower($classfunction = $matches[2]), get_class_methods($class)) ) 
        {
    
            //echo "<p>StaticObject '$function'</p>";
            $r = call_user_func(array($class,$classfunction),$msg);
        } 
        else 
        {
    
            //echo "<p>Unknown '$function'</p>";      
            $r = new XML_RPC_Response(0, $XML_RPC_err['unknown_method'], 'Serverside method '. ($this->debug() ? "'$function' " : "'enable serverside debug for the name' ").'unknown.'.' Server dmap configuration problem?');
        }
    
        if (!is_a($r, 'XML_RPC_Response')) 
        {
            return new XML_RPC_Response(0, $XML_RPC_err['not_response_object'], $XML_RPC_str['not_response_object']);
        } 
        else 
        {
            return $r;
        }
    }

}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */

?>
