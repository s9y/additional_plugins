<?php

/**
 * This is a kind of example class how to do a oembed provider for a service, that doesn't support oembed.
 * This provider parses the podomatic URL and creates an iframe player for this.
 * 
 * Converting is done in the getEmbed function. This is the main code. 
 * Everything else is only type converting that should be nearly the same in any custom provider
 * 
 * All *.class.php files found in the customs directory will be included automatically
 * 
 * After implementing the provider you have to add it to the providers.xml like this:
 * <provider>
 *   <name>Podomatic Minicasts</name>
 *   <url>http://minicasts.podomatic.com/play/*</url>
 *   <class>PodomaticProvider</class>
 * </provider>
* 
 * @author Grischa Brockhaus
 *
 */
class PodomaticProvider extends EmbedProvider {

    /**
     * This is the main function calling the Posterous postly API and converting it into a OEmbed object
     * @param string $url post.ly url
     * @return OEmbed the embed object
     */
    public function getEmbed($url){
        // http://minicasts.podomatic.com/play/1620677/2976197
        if(preg_match("/minicasts\.podomatic\.com\/play\/(\d+)\/(\d+)/",$url,$matches)){
            $boo_id=$matches[2];
        }
        if (empty($boo_id)) return null;
        $width = 440;
        $height = 205;
        $player = "<iframe height='$height' width='$width' frameborder='0' marginheight='0' marginwidth='0' scrolling='no' src='http://minicasts.podomatic.com/embed/frame/posting/$boo_id?json_url=http%3A%2F%2Fminicasts.podomatic.com%2Fentry%2Fembed_params%2F$boo_id%3Fcolor%3Dadadad%26autoPlay%3Dfalse%26width%3D$width%26height%3D$height%26objembed%3D0' allowfullscreen></iframe>";
        $oembed = new RichEmbed();
        $oembed->type='rich';
        $oembed->html = $player;
        $oembed->width="$width";
        $oembed->height="$height";
        $oembed->url=$url;
        $oembed->version='1.0';
        $oembed->provider_name="Podomatic Minicast";
        $oembed->provider_url="http://www.podomatic.com";
        $oembed->title = 'Podomatic Minicast';
        
        return $oembed;
    }
    
    // === here comes the regular stuff for providers, what is very similar in any custom provider =========
    private function provideXML($url){
        $string="";
        $oembed = $this->getEmbed($url);
        if (isset($oembed)) {
            foreach($this->getEmbed($url) as $key=>$value){
                if(isset($value)&& $value!="") $string.="  <".$key.">".$value."</".$key.">\n";
            }
            $string="<oembed>\n".$string."</oembed>";
        }
        return $string;
    }
    private function provideObject($url){
        return $this->getEmbed($url);
    }
    private function provideJSON($url){
        $oembed = $this->getEmbed($url);
        if (isset($oembed)) return json_encode($this->getEmbed($url));
        else return null;
    }
    private function provideSerialized($url){
        $oembed = $this->getEmbed($url);
        if (isset($oembed)) return serialize($this->getEmbed($url));
        else return null;
    }
    public function provide($url,$format="json"){
        if($format=="xml"){
            return $this->provideXML($url);
        } else if ($format=="object"){
            return $this->provideObject($url);
        } else if ($format=="serialized"){
            return $this->provideSerialized($url);
        } else {
            return $this->provideJSON($url);;
        }
    }

    public function match($url) {
        return preg_match("/minicasts\.podomatic\.com\/play\/(\d+)\/(\d+)/",$url);
    }

    /**
     * Constructor
     * Enter description here ...
     * @param simplexml $config holds the entry in the providers.xml for this Provider. You can add more parameters parsed here
     */
    public function __construct($config){
        parent::__construct("http://minicasts.podomatic.com/play","");
    }
}