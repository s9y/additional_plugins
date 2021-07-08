<?php # 

if (IN_serendipity !== true) {
    die ("Don't hack!");
}
    
@serendipity_plugin_api::load_language(dirname(__FILE__));

?>