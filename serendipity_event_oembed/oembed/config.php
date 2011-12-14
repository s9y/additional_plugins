<?php
define("PROVIDER_XML",    dirname(__FILE__) . '/' . "providers.xml");
define("TEMPLATE_PATH",   dirname(__FILE__) . '/' . "templates/");

function __autoload($classname){
  if(file_exists($x=dirname(__FILE__) . '/' .$classname.".class.php")) {
    require_once($x);
  }
}
?>
