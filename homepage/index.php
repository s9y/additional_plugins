<?php
if (isset($_GET['language'])) {
    #setcookie('language', $_GET['language']);
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
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spartacus | Serendipity Blog System</title>
    <meta name="description" content="Serendipity is a PHP-powered weblog engine giving users an easy way to maintain a blog and developers a framework with the power for professional applications.">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="stylesheet" href="homepage/css/master.css">
    <script src="homepage/scripts/modernizr/modernizr.js"></script>
</head>
<body id="top">
    <nav id="nav-global" role="navigation">
        <div class="layout-container">
            <a id="open-nav" class="nav-toggle" href="#site-nav">Menu</a>

            <ul id="site-nav" class="nav-collapse">
                <li><a href="http://s9y.org">Start</a></li>
                <li><a href="http://docs.s9y.org/docs/">Docs</a></li>
                <li><a href="http://blog.s9y.org">Blog</a></li>
                <li><a href="http://board.s9y.org">Forums</a></li>
            <?php if (substr(($_REQUEST['mode']), 0, 8) === 'template') { ?>
                <li><a href="index.php">Plugins</a></li>
                <li id="current-page"><a href="index.php?mode=template_all">Themes</a></li>
            <?php } else { ?>
                <li id="current-page"><a href="index.php">Plugins</a></li>
                <li><a href="index.php?mode=template_all">Themes</a></li>
            <?php } ?>
                <li><a href="https://github.com/s9y">GitHub</a></li>
            </ul>
        </div>
    </nav>

    <header id="masthead" role="banner">
        <div class="layout-container">
            <h1>Spartacus</h1>

            <div class="spartacus-slogan">
                <span>Serendipity Plugin And Repository Tool Access Customization/Unification System</span>
            </div>
        </div>
    </header>

    <div id="claim">
        <div class="layout-container">
            <span id="slogan">Not mainstream since 2002</span>
        </div>
    </div>

    <main role="main">
        <div class="layout-container">
            <article id="content">
            <?php if (empty($_REQUEST['mode'])) { ?>
                <h2>What is Spartacus?</h2>

                <p>Spartacus is an Event Plugin for the Weblog Engine <a href="http://www.s9y.org">Serendipity</a>. Once installed through the usual plugin configuration manager within your Serendipity Installation, you can fetch and manage plugins via Serendipity. No need to use FTP or manual downloading - just click &amp; fetch!</p>

                <h3>What is this site?</h3>

                <p>This page is for not-yet Serendipity users to view our available plugins, or for users who cannot use the Spartacus plugin because of technical restrictions of their webserver.</p>

                <p>You can browse these categories:</p>

                <ul>
                    <li><a href="index.php?mode=bygroups_event_<?php echo LANG; ?>">Event plugins</a></li>
                    <li><a href="index.php?mode=bygroups_sidebar_<?php echo LANG; ?>">Sidebar plugins</a></li>
                    <li><a href="index.php?mode=template_all">Themes</a></li>
                </ul>

                <p>You can also quickjump to specific <a href="#spartacus-plugins">plugin categories</a>.</p>
            <?php } else {
                echo "<a class='spartacus-back' href='index.php'>Back to main</a>\n";

                $file = BASEDIR . preg_replace('@[^a-z_0-9-]@i', '', $_REQUEST['mode']) . '.htm';
                if (file_exists($file)) {
                    include $file;
                } else { ?>
                    <p>Invalid URL</p>
            <?php   }
                } ?>
            </article>

            <aside id="sidebar">
                <h2>More info</h2>

                <section id="spartacus-plugins" class="widget">
                    <h3>Plugins</h3>

                    <h4>Event</h4>

                    <ul class="spartacus-list">
                        <li><a href="index.php?mode=bygroups_event_<?php echo LANG; ?>">All Groups</a></li>
                        <?php echo str_replace('[LANG]', LANG, file_get_contents(BASEDIR . 'box_groups_event.htm')); ?>
                    </ul>

                    <h4>Sidebar</h4>

                    <ul class="spartacus-list">
                        <li><a href="index.php?mode=bygroups_sidebar_<?php echo LANG; ?>">All Groups</a></li>
                        <?php echo str_replace('[LANG]', LANG, file_get_contents(BASEDIR . 'box_groups_sidebar.htm')); ?>
                    </ul>
                </section>

                <section id="spartacus-themes" class="widget">
                    <h3>Themes</h3>

                    <ul class="spartacus-list">
                        <li><a href="index.php?mode=template_all">All Templates</a></li>
                        <?php echo file_get_contents(BASEDIR . 'box_groups_template.htm'); ?>
                    </ul>
                </section>

                <section id="spartacus-language" class="widget">
                    <h3>Change language</h3>

                    <form action="index.php" method="get">
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
                            <option value="<?php echo $l; ?>"><?php echo htmlspecialchars($d, ENT_COMPAT, 'UTF-8'); ?></option>
                    <?php
                        }
                    ?>
                        </select>
                        <input type="submit" value="Go">
                    </form>
                </section>

                <section id="spartacus-feeds" class="widget">
                    <h3>Feeds</h3>

                    <ul>
                        <li><a href="https://raw.githubusercontent.com/s9y/additional_plugins/master/package_RSSevent.xml">Event plugins</a></li>
                        <li><a href="https://raw.githubusercontent.com/s9y/additional_plugins/master/package_RSSsidebar.xml">Sidebar plugins</a></li>
                        <li><a href="https://github.com/s9y/additional_plugins/commits/master.atom">Plugin commits</a></li>
                        <li><a href="https://github.com/s9y/additional_themes/commits/master.atom">Theme commits</a></li>
                    </ul>
                </section>
            </aside>
        </div>
    </main>

    <footer id="service" role="contentinfo">
        <div class="layout-container">
            <ul id="service-links">
                <li><a id="to-top" href="#top">Back to top</a></li>
                <li><a href="https://blog.s9y.org/index.php?serendipity[subpage]=dsgvo_gdpr_privacy">Privacy policy</a></li>
            </ul>

            <p id="supporters">This site is hosted by the kind people at <a href="http://www.sourceforge.net">SourceForge.net</a> and created by <a href="http://garv.in">Garvin Hicking</a>.</p>
        </div>
    </footer>

    <script src="homepage/scripts/jquery/dist/jquery.min.js"></script>
    <script src="homepage/scripts/master.js"></script>
    <!-- Google Analytics
    <script>
    window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
    ga('create','UA-77038-1','auto');ga('send','pageview')
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async defer></script>
    -->
</body>
</html>
