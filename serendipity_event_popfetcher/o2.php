<?php

// German O2 library
// Author: Garvin Hicking

class popfetcher_provider_o2 {
    function getBody($msg) {
        // O2 embeds hav got weird stuff in them

        preg_match('@^.*<p>(.+)<p> Wenn Sie mehr.*$@imsU', $msg, $matches);
        $out = $matches[1];
        $out = preg_replace('@<img src="cid:.*">@imsU', '', $out);
        $out = str_replace(array('<p>', '</p>'), array('<br />', ''), $out);
        
        $regex_nasty_duplicates = '@(<br />[\r\n]?){2,}@imsU';
        while (preg_match($regex_nasty_duplicates, $out)) {
            $out = preg_replace($regex_nasty_duplicates, '<br />', $out);
        }

        return $out;
    }
}

?>