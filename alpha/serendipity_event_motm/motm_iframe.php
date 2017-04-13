<?php
$contents = getSong();
$secsnow = $contents[1];
$secstotal = $contents[2];
?>
<html>
<head>
    <title></title>
    <script type="text/javascript"><!--
    var secsnow = '<?php echo $secsnow;?>';
    var secstotal = '<?php echo $secstotal;?>';
    function loadContent()
    {
        parent.content = document.getElementById('content').innerHTML;
        parent.secsnow = <?php echo $secsnow;?>;
        parent.secstotal = <?php echo $secstotal;?>;
        parent.do_refresh();
    }
    -->
    </script>
</head>
<body onLoad="loadContent();">
    <div name="content" id="content" style="margin-bottom:5px; align=center"><?php echo $contents[0];?></div>
</body>
</html><?php
// common links to streams
function stream($song)
{
    global $motm_server_temp;
    $streams = $motm_server_temp['streams'];
    if (!($streams && count($streams = unserialize($streams))))
        return $song;

    foreach ($streams as $stream)
    {
        if ($stream['motm_match'] && strstr($song,$stream['motm_match']))
        {
            if ($stream['motm_name'])
                $song = $stream['motm_name'];
            $song = "<a href='".$stream['motm_url']."'>$song</a>";
            if ($stream['motm_web_name'] && $stream['motm_web_url'])
                $song .= " <br><b>".PLUGIN_SIDEBAR_MOTM_IFRAME_FROM." <a href='".$stream['motm_web_url']."'>".$stream['motm_web_name']."</a></b>";
            break;
        }
    }
    return $song;
}
function getSong()
{
    global $motm_server_temp;
    
    $file_content = $motm_server_temp['song_info'];
    $output = unserialize($file_content);
    
    $song = $output['track'];
    $artist = $output['artist'];
    $album = $output['album'];
    $genre = $output['genre'];
    
    $filetime = $output['filetime'];
    $tracktime = $output['tracktime'];
    $seconds = $output['seconds'];
    
    $amazon_image = $output['amazon_image'];
    $image_size = $output['image_size'];
    $amazon_url = $output['amazon_url'];
    $artist_url = $output['artist_url'];
    $song_url = $output['song_url'];
    
    // Start buffering
    ob_start();
    
    ?>
    <div style='font-size:10px;'>
    <div class="clearfix">
    <?php
    $modified = time() - $filetime;
    if (!$seconds || $seconds == "" || $seconds == 0)
    {
        $seconds = 0;
        echo "<b>".PLUGIN_SIDEBAR_MOTM_IFRAME_STREAMING."</b><br/>";
        echo stream($song);
    }
    else
    {
        if ($amazon_image && $amazon_image != "") { ?>
            <a href='<?php echo $amazon_url;?>'><img src='<?php echo $amazon_image;?>' border='4' style='margin:2px;height:<?php echo $image_size;?>px;float:left' alt='<?php echo $album;?>'></a>
        <?php }
        if ($modified > $seconds)
            echo "<b>".PLUGIN_SIDEBAR_MOTM_IFRAME_RECENT."</b><br>";
        else
            echo "<b>".PLUGIN_SIDEBAR_MOTM_IFRAME_CURRENT."</b><br>";
        ?>
        <a href='<?php echo $artist_url;?>'><?php echo $artist;?></a>:
        <?php if ($amazon_url && $amazon_url != "") { ?><a href='<?php echo $amazon_url;?>'><?php echo $album;?></a> <?php } else { echo $album; } ?> - 
        <a href='<?php echo $song_url;?>'><?php echo $song;?></a></div>
        <?php if ($modified <= $seconds)
        {
        ?>
            <div style='text-align:right;margin-right:4px;' id='tracktime'><?php echo $tracktime;?></div>
            <div style='width:100%;' align='center'>
                <div id='serendipity_motm_track' style='width:200px;' align='left'>
                    <div id='serendipity_motm_slider' style='width:0px;text-align:center;'></div>
                </div>
            </div>
        <?php
        }
    }
    echo "</div>";
    // Grab the buffer
    $content[] = ob_get_contents();
    $content[] = $modified;
    $content[] = $seconds;

    // Stop buffering
    ob_end_clean();
    
    return $content;
}
?>
