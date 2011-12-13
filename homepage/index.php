<?php
if (isset($_GET['language'])) {
    setcookie('language', $_GET['language']);
}
if (empty($_REQUEST['language'])) {
    $_REQUEST['language'] = 'en';
}
define('LANG', preg_replace('@[^a-z_]@i', '', $_REQUEST['language']));
if (is_dir('homepage')) {
    define('BASEDIR', 'homepage/');
} else {
    define('BASEDIR', '');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Serendipity :: Spartacus - Serendipity Plugin And Repository Tool Access Customization/Unification System</title>
    <style type="text/css" media="all">@import "css/style.css";</style>
    <style type="text/css" media="all">@import "css/style_new.css";</style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="css/favicon.png"></link>
</head>
<body>

<div id="wrap">
    <div id="header"><a id="topofpage"></a>
    	<div id="menu"><a href="http://www.s9y.org" title="Serendipity Homepage">Homepage</a> | <a href="http://blog.s9y.org" title="Latest News from the official Serendipity Blog">Blog</a> | <a href="http://www.s9y.org/12.html" title="Try Serendipity">Download</a> | <a href="http://www.s9y.org/forums" title="Serendipity user and developer forum">User Forums</a> | <a href="http://spartacus.s9y.org" title="Spartacus online repository for plugins and templates">Plugins / Templates</a></div>
        <div id="identity">
            <h1><a class="homelink1" href="http://spartacus.s9y.org/">SPARTACUS</a></h1>
            <h2><a class="homelink2"><strong>S</strong>erendipity <strong>P</strong>lugin <strong>A</strong>nd <strong>R</strong>epository <strong>T</strong>ool <strong>A</strong>ccess <strong>C</strong>ustomization/<strong>U</strong>nification <strong>S</strong>ystem</a></h2>
        </div>
    </div>

    <div id="mainpane">
        <div id="rightcolumn">
            <div id="contenttop">&nbsp;</div>
            <div id="content">
                <div class="serendipity_entry">
                    <a class="mainpage" href="index.php">&laquo; Back to main</a>
            
                    <?php if (empty($_REQUEST['mode'])) { ?>
                    <p>You can browse these categories:</p>
                    <ul>
                        <li><a href="index.php?mode=bygroups_event_<?php echo LANG; ?>">All Event Plugins</a></li>
                        <li><a href="index.php?mode=bygroups_sidebar_<?php echo LANG; ?>">All Sidebar Plugins</a></li>
                        <li><a href="index.php?mode=template_all">All Templates</a></li>
                    </ul>
                    <p>You can also quickjump to specific plugin categories on the left side.</p>
                    <?php } else {
                            $file = BASEDIR . preg_replace('@[^a-z_0-9-]@i', '', $_REQUEST['mode']) . '.htm';
                            if (file_exists($file)) {
                                include $file;
                            } else { ?>
                    <p>Invalid URL</p>
                    <?php   }
                         } ?>
                </div>
            </div>
        </div>
        
        <div id="serendipityLeftSideBar">
            <div id="sidebartop">&nbsp;</div>
            <div id="sidebarmiddle">
                <div class="serendipitySideBarContent">
                    <h3 class="serendipitySideBarTitle">What is Spartacus?</h3>
                    <p>Spartacus is an Event Plugin for the Weblog Engine <a href="http://www.s9y.org">Serendipity</a>.</p>
                    <p>Once installed through the usual plugin configuration manager within your Serendipity Installation, you can fetch and manage plugins via Serendipity. No need to use FTP or manual downloading - just click &amp; fetch!</p>
                </div>
            
                <div class="serendipitySideBarContent">
                    <h3 class="serendipitySideBarTitle">What is this site?</h3>
                    <p>This page is for not-yet Serendipity users to view our available plugins, or for users who cannot use the Spartacus plugin because of technical restrictions of their webserver.</p>
                </div>
            
                <div class="serendipitySideBarContent">
                    <h3 class="serendipitySideBarTitle">Plugins</h3>
                    <h4>Event</h4>
                    <ol>
                        <li><a href="index.php?mode=bygroups_event_<?php echo LANG; ?>">All Groups</a></li>
                        <?php echo str_replace('[LANG]', LANG, file_get_contents(BASEDIR . 'box_groups_event.htm')); ?>
                    </ol>
                    <h4>Sidebar</h4>
                    <ol>
                        <li><a href="index.php?mode=bygroups_sidebar_<?php echo LANG; ?>">All Groups</a></li>
                        <?php echo str_replace('[LANG]', LANG, file_get_contents(BASEDIR . 'box_groups_sidebar.htm')); ?>
                    </ol>
                </div>
            
                <div class="serendipitySideBarContent">
                    <h3 class="serendipitySideBarTitle">Templates</h3>
                    <ol>
                        <li><a href="index.php?mode=template_all">All Templates</a></li>
                        <?php echo file_get_contents(BASEDIR . 'box_groups_template.htm'); ?>
                    </ol>
                </div>
            
                <div class="serendipitySideBarContent">
                    <h3 class="serendipitySideBarTitle">Change Language</h3>
                    <form action="index.php" method="get">
                        <p>
                            <input class="smallsubmit" type="submit" value="&gt;" />
                            <select class="language" name="language">
            <?php
            $lang = array('en' => 'English',
                          'de' => 'German',
                          'da' => 'Danish',
                          'es' => 'Spanish',
                          'fr' => 'French',
                          'fi' => 'Finnish',
                          'cs' => 'Czech',
                          'nl' => 'Dutch',
                          'is' => 'Icelandic',
                          'se' => 'Swedish',
                          'pt' => 'Portuguese Brazilian',
                          'pt_PT' => 'Portuguese European',
                          'bg' => 'Bulgarian',
                          'hu' => 'Hungarian',
                          'no' => 'Norwegian',
                          'ro' => 'Romanian',
                          'it' => 'Italian',
                          'ru' => 'Russian',
                          'fa' => 'Persian',
                          'tn' => 'Traditional Chinese',
                          'cn' => 'Simplified Chinese',
                          'ja' => 'Japanese',
                          'ko' => 'Korean',
                          'ta' => 'Tamil');
            foreach($lang as $l => $d) {
            ?>
                                    <option value="<?php echo $l; ?>"><?php echo htmlspecialchars($d); ?></option>
            <?php
            }
            ?>
                            </select>
                        </p>
                    </form>
                    <ol>
                        <li><a href="http://www.netmirror.org/mirror/serendipity/package_RSSevent.xml">RSS Feed Event-Plugins</a></li>
                        <li><a href="http://www.netmirror.org/mirror/serendipity/package_RSSsidebar.xml">RSS Feed Sidebar-Plugins</a></li>
                        <li><a href="http://cia.navi.cx/stats/project/Serendipity/.rss">RSS Feed Commits</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div>
        <br style="clear: both" />
    </div>
    
    <div id="footer">
        <p>This site is hosted by the kind people at <a href="http://www.sourceforge.net/">SourceForge.net</a> and created by <a href="http://garv.in/">Garvin Hicking</a>.</p>
    </div>
</div>

<script type="text/javascript"> 
 
   var _gaq = _gaq || [];
   _gaq.push(['_setAccount', 'UA-77038-1']);
   _gaq.push(['_trackPageview']);
        
   (function() {
       var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
       ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
 
</body>
</html>
