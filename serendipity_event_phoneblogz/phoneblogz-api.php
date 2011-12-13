<?php

require_once("xmlrpc.inc");

// Retrieve the users for the given account code and password
function getUsersForAccount($accesscode, $password) {

  $f = new xmlrpcmsg("pb.getUsersForAccount",
                array(new xmlrpcval($accesscode, "string"),
                      new xmlrpcval($password, "string")
                     )
                    );

  $c = new xmlrpc_client("/pbapi/xmlrpc.php", "www.phoneblogz.com", 80);

  $r=$c->send($f, 1);

  $arrResults = array();

  if ($r->faultCode() != 0) {
    $arrResults = array("error" => $r->faultString());
  } else {
    $v=$r->value();
    $u=$v->scalarval();

    // Go through the structs
    for ($i = 0; $i < count($u); ++$i) {
      $arr = $u[$i]->scalarval();
      array_push($arrResults, array("id" => $arr["id"]->scalarval(),
                                    "pin" => $arr["pin"]->scalarval(),
                                    "name" => $arr["name"]->scalarval()));
    }
  }

  return $arrResults;
}

function updateWordpressOptions($accesscode, $password, $notifyurl) {
  $f = new xmlrpcmsg("pb.updateWordpressOptions",
                array(new xmlrpcval($accesscode, "string"),
                      new xmlrpcval($password, "string"),
                      new xmlrpcval($notifyurl, "string")
                     )
                    );

  $c = new xmlrpc_client("/pbapi/xmlrpc.php", "www.phoneblogz.com", 80);
  $r=$c->send($f, 1);

  if ($r->faultCode() != 0) {
    $arrResults = array("error" => $r->faultString());
  } else {
    $v=$r->value();
    $u=$v->scalarval();
    $arrResults = $u;
  }

  return $arrResults;
}

function updateSerendipityOptions($accesscode, $password, $notifyurl) {
  $f = new xmlrpcmsg("pb.updateSerendipityOptions",
                array(new xmlrpcval($accesscode, "string"),
                      new xmlrpcval($password, "string"),
                      new xmlrpcval($notifyurl, "string")
                     )
                    );

  $c = new xmlrpc_client("/pbapi/xmlrpc.php", "www.phoneblogz.com", 80);
  $r=$c->send($f, 1);

  if ($r->faultCode() != 0) {
    $arrResults = array("error" => $r->faultString());
  } else {
    $v=$r->value();
    $u=$v->scalarval();
    $arrResults = $u;
  }

  return $arrResults;
}

function getPostsForAccount($accesscode, $password) {
  $f = new xmlrpcmsg("pb.getPostsForAccount",
                array(new xmlrpcval($accesscode, "string"),
                      new xmlrpcval($password, "string")
                     )
                    );

  $c = new xmlrpc_client("/pbapi/xmlrpc.php", "www.phoneblogz.com", 80);
  $r=$c->send($f, 1);

  $arrResults = array();

  if ($r->faultCode() != 0) {
    $arrResults = array("error" => $r->faultString());
  } else {
    $v=$r->value();
    $u=$v->scalarval();

    // Go through the structs
    for ($i = 0; $i < count($u); ++$i) {
      $arr = $u[$i]->scalarval();
      array_push($arrResults, array("messageid" => $arr["messageid"]->scalarval(),
                                    "userno" => $arr["userno"]->scalarval(),
                                    "username" => $arr["username"]->scalarval(),
                                    "timeleft" => $arr["timeleft"]->scalarval(),
                                    "callerid" => $arr["callerid"]->scalarval(),
                                    "processed" => $arr["processed"]->scalarval()));
    }
  }

  return $arrResults;
}

?>
