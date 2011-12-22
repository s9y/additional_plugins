<?php
class ProviderList {
    function ul_providernames($with_url=false) {
        $provider_names = array();
        $xml = simplexml_load_file(PLUGIN_OEMBED_PROVIDER_XML_FILE);// PROVIDER_XML comes from config.php
        foreach($xml->provider as $provider){
            if (isset($provider->name)) {
                $pentry = $provider->name;
                if ($with_url && isset($provider->url)) {
                    //$pentry = "<b>$pentry</b><br/>(" . $provider->url . ")";
                    $pentry = "$pentry";
                }
                $provider_names[] = $pentry;
            }
        }
        natsort($provider_names);
        return "<ol><li>" . implode("</li><li>", $provider_names) . "</li></ol>";
    }
}