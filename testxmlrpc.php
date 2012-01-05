<?php
// needs php5-curl and php5-xmlrpc on Ubuntu

@define("XMLRPC_USER", "grischa");
@define("XMLRPC_PWD", "int0rg98");
@define("XMLRPC_HOST", "grischa.scorpius.uberspace.de");
@define("XMLRPC_ENDPOINT", "http://" . XMLRPC_HOST . "/blog/serendipity_xmlrpc.php");

function test($request) {
    print "$request\n";
    
    $req = curl_init(XMLRPC_ENDPOINT);
    
    // Using the cURL extension to send it off,  first creating a custom header block
    $headers = array();
    array_push($headers,"Content-Type: text/xml");
    array_push($headers,"Content-Length: ".strlen($request));
    array_push($headers,"\r\n");
    
    //URL to post to
    curl_setopt($req, CURLOPT_URL, XMLRPC_ENDPOINT);
    
    //Setting options for a secure SSL based xmlrpc server
    curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($req, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt( $req, CURLOPT_CUSTOMREQUEST, 'POST' );
    curl_setopt($req, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($req, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $req, CURLOPT_POSTFIELDS, $request );
    
    //Finally run
    $response = curl_exec($req);
    echo "resonse: $response\n";
    
    //Close the cURL connection
    curl_close($req);
    
    //Decoding the response to be displayed
    echo xmlrpc_decode($response);    
}

//test(xmlrpc_encode_request('wp.getTags', array(1, XMLRPC_USER, XMLRPC_PWD)));
//test(xmlrpc_encode_request('wp.getOptions', array(1, XMLRPC_USER, XMLRPC_PWD)));

$req_mt_setPostCategories ='<?xml version="1.0" encoding="utf-8"?>
<methodCall>
	<methodName>mt.setPostCategories</methodName>
	<params>
		<param>
			<value><string>92</string></value>
			</param>
		<param>
			<value><string>' . XMLRPC_USER . '</string></value>
			</param>
		<param>
			<value><string>' . XMLRPC_PWD  . '</string></value>
			</param>
		<param>
			<value>
			<array>
			<data>
			<value>
			<struct>
			<member>
			<name>categoryId</name>
			<value><string>3</string></value>
			</member>
			<member>
			<name>categoryName</name>
			<value><string>wpandroid</string></value>
			</member>
			<member>
			<name>isPrimary</name>
			<value><boolean>1</boolean></value>
			</member>
			</struct>
			</value>
			</data>
			</array>
			</value>
			</param>
		</params>
	</methodCall>';

//test($req_mt_setPostCategories);

$req_metaWeblog_getPost = '<?xml version="1.0" encoding="utf-8"?>
<methodCall>
	<methodName>metaWeblog.getPost</methodName>
	<params>
		<param>
			<value><string>92</string></value>
			</param>
		<param>
			<value><string>' . XMLRPC_USER . '</string></value>
			</param>
		<param>
			<value><string>' . XMLRPC_PWD  . '</string></value>
			</param>
		</params>
	</methodCall>';

//test($req_metaWeblog_getPost);

//test(xmlrpc_encode_request('wp.getCategories', array(1, XMLRPC_USER, XMLRPC_PWD)));
//test(xmlrpc_encode_request('mt.supportedMethods', array(1, XMLRPC_USER, XMLRPC_PWD)));
//test(xmlrpc_encode_request('wp.getPostFormats', array(1, XMLRPC_USER, XMLRPC_PWD)));

$req = "<methodCall><methodName>metaWeblog.editPost</methodName><params><param><value><string>97</string></value></param><param><value><string>grischa</string></value></param><param><value><string>int0rg98</string></value></param><param><value><struct><member><name>custom_fields</name><value><array><data><value><struct><member><name>value</name><value><double>52.47235714285714</double></value></member><member><name>key</name><value><string>geo_latitude</string></value></member></struct></value><value><struct><member><name>value</name><value><double>13.443786685714285</double></value></member><member><name>key</name><value><string>geo_longitude</string></value></member></struct></value><value><struct><member><name>value</name><value><i4>1</i4></value></member><member><name>key</name><value><string>geo_public</string></value></member></struct></value></data></array></value></member><member><name>title</name><value><string>Was sollen diese Spam Kommentare eigentlich genau bewirken?</string></value></member><member><name>date_created_gmt</name><value><dateTime.iso8601>20120104T23:26:07</dateTime.iso8601></value></member><member><name>wp_password</name><value><string></string></value></member><member><name>post_status</name><value><string>publish</string></value></member><member><name>description</name><value><string>Bei mir kommen seit gestern in regelm&#228;ssigen Abst&#228;nden Spam Kommentare wie die unten an.

Was soll das? Sie sind alle unterschiedlich aber immer nach dem selben Muster aufgebaut: Englisch mit zumeist einem Schreibfehler und immer ein Loblied auf den Artikel, der nat&#252;rlich nicht gelesen wurde. Oder was soll \"&lt;em&gt;Danke Gott, dass ich diese Info nun endlich gefundem habe!&lt;/em&gt;\" unter einem Youtube Video mit einem lustig furzenden Comic Dino? :D

Merkw&#252;rdiger Weise haben die Kommentare alle keinen Link, der beworben werden k&#246;nnte, was ist also das Ziel?!

Schr&#228;g..

&lt;a href=\"http://grischa.scorpius.uberspace.de/blog/uploads/screenshot-1325727080060.png\"&gt;&lt;img class=\"alignnone\" title=\"screenshot-1325727080060.png\" alt=\"image\" src=\"http://grischa.scorpius.uberspace.de/blog/uploads/screenshot-1325727080060.png\" /&gt;&lt;/a&gt;

</string></value></member><member><name>mt_keywords</name><value><string>spam</string></value></member><member><name>dateCreated</name><value><dateTime.iso8601>20120104T22:26:07</dateTime.iso8601></value></member><member><name>post_type</name><value><string>post</string></value></member><member><name>categories</name><value><array><data><value><string>wpandroid</string></value></data></array></value></member></struct></value></param><param><value><boolean>0</boolean></value></param></params></methodCall>";
test($req);