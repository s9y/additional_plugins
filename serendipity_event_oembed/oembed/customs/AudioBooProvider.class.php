<?php

/**
 * This is a kind of example class how to do a oembed provider for a service, that doesn't support oembed.
 * This provider reads the AudioBoo API to resolve Boos and produce embedded players.
 * It is configurable, what type of player should be used. 
 * 
 * Converting is done in the getEmbed function. This is the main code. 
 * Everything else is only type converting that should be nearly the same in any custom provider
 * 
 * All *.class.php files found in the customs directory will be included automatically
 * 
 * After implementing the provider you have to add it to the providers.xml like this:
 * <provider>
 *   <name>AudioBoo (3 different players)</name>
 *   <url>http://(audio)?boo.fm/boos/*</url>
 *   <class>AudioBooProvider</class>
 * </provider>
* 
 * @author Grischa Brockhaus
 *
 */
class AudioBooProvider extends EmbedProvider {

    /**
     * This is the main function calling the Posterous postly API and converting it into a OEmbed object
     * @param string $url post.ly url
     * @return OEmbed the embed object
     */
    public function getEmbed($url){
        // http://audioboo.fm/boos/649785-ein-erster-testboo
        if(preg_match("/audioboo\.fm\/boos\/(\d+)-/",$url,$matches) || preg_match("/boo\.fm\/boos\/(\d+)-/",$url,$matches)){
            $boo_id=$matches[1];
        }
        if (empty($boo_id)) return null;

        $api_fetch = "http://api.audioboo.fm/audio_clips/" . $boo_id . ".xml";
        $xml = simplexml_load_string(file_get_contents($api_fetch));
        if (!isset($xml) && !isset($xml->body)) return null;
        $audioboo = $xml->body;
        if (isset($audioboo->error)) return null;
        if (!isset($audioboo->audio_clip)) return null;
        $audio = $audioboo->audio_clip;
        $detail_url = (string)$audio->urls->detail;
        $detail_enc = urlencode($detail_url);
        $title = (string)$audio->title;
        $title_enc = urlencode($title);
        $time = (string)$audio->recorded_at;
        $time = str_ireplace("T", " ", $time);
        $time = str_ireplace("Z", "", $time);
        $time_enc = urlencode($time);
        $username = (string)$audio->user->username;
        $tpl_wordpress = '<object data="http://abfiles.s3.amazonaws.com/swf/fullsize_player.swf" height="129" id="boo_embed_' . $boo_id .'" type="application/x-shockwave-flash" width="400"><param name="movie" value="http://abfiles.s3.amazonaws.com/swf/fullsize_player.swf" /><param name="scale" value="noscale" /><param name="salign" value="lt" /><param name="bgColor" value="#FFFFFF" /><param name="allowScriptAccess" value="always" /><param name="wmode" value="window" /><param name="FlashVars" value="mp3=' . $detail_enc .'.mp3%3Fkeyed%3Dtrue%26source%3Dembed&amp;mp3Title=' . $title_enc . '&amp;mp3Time=' . $time_enc . '&amp;mp3LinkURL=' .$detail_enc . '&amp;mp3Author=gbrockhaus&amp;rootID=boo_embed_' . $boo_id . ' " /><a href="' . $detail_url . '.mp3?keyed=true&amp;source=embed">' . $title .' (mp3)</a></object>';
        $tpl_fullfeatured = '<div class="ab-player" data-boourl="' . $detail_url . '/embed"><a href="' . $detail_url . '">listen to &lsquo;' . $title. '&rsquo; on Audioboo</a></div>
<script type="text/javascript">(function() { var po = document.createElement("script"); po.type = "text/javascript"; po.async = true; po.src = "http://d15mj6e6qmt1na.cloudfront.net/assets/embed.js"; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s); })();</script>';
        $tpl_standard = '<iframe style="margin: 0px; padding: 0px; border: none; display: block; max-width:100%; width: 1000px; height: 145px;" allowtransparency="allowtransparency" cellspacing="0" frameborder="0" hspace="0" marginheight="0" marginwidth="0" scrolling="no" vspace="0" src="' . $detail_url . '/embed" title="Audioboo player"></iframe>';
        
        if (is_array($this->config)) {
            $tpls = array(
            'standard' => $tpl_standard,
            'wordpress' => $tpl_wordpress,
            'fullfeatured' => $tpl_fullfeatured
            );
            $tpl = $tpls[$this->config['audioboo_tpl']];
        }
        if (empty($tpl)) $tpl = $tpl_wordpress;
        
        $oembed = new RichEmbed();
        $oembed->type='rich';
        $oembed->html = $tpl;
        $oembed->width='400';
        $oembed->height='129';
        $oembed->url=$detail_url;
        $oembed->version='1.0';
        $oembed->provider_name="AudioBoo";
        $oembed->provider_url="http://audioboo.fm";
        $oembed->resource_url=$detail_url .'.mp3';
        $oembed->title = $title;
        //$oembed->html = $post->body;
        $oembed->author_name = $username;
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
        return preg_match('/audioboo\.fm\/boos\/(\d+)/',$url) || preg_match('/boo\.fm\/boos\/(\d+)/',$url);
    }

    /**
     * Constructor
     * Enter description here ...
     * @param simplexml $config holds the entry in the providers.xml for this Provider. You can add more parameters parsed here
     */
    public function __construct($config){
        parent::__construct("http://boo.fm/boo","");
    }
}