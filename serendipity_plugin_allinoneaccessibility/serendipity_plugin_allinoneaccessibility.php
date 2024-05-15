<?php

// Wikipedia Finder Plugin for Serendipity
// 10/2004 by Thomas Nesges <thomas@tnt-computer.de>
// Mozilla-compatible Javascript by Garvin Hicking (http://www.supergarv.de)
// English translation and some Javascript-Debugging done by Paul Wistrand (http://paulwistrand.com)
// Spanish translation by Francisco Ortiz <frortiz@gmail.com>


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_allinoneaccessibility extends serendipity_plugin {

    function introspect(&$propbag) {
        $propbag->add('author',    PLUGIN_ALLINONEACCESSIBILITY_AUTHOR);
        $propbag->add('support_url',    PLUGIN_ALLINONEACCESSIBILITY_SUPPORT_URL);
        $propbag->add('support_email',    PLUGIN_ALLINONEACCESSIBILITY_SUPPORT_EMAIL);
        $propbag->add('version',     '1.5.2');
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('name',           PLUGIN_ALLINONEACCESSIBILITY_NAME);
        $propbag->add('description',    PLUGIN_ALLINONEACCESSIBILITY_DESC);
        $propbag->add('configuration',  array('allinoneaccessibility'));
        $propbag->add('requirements',  array(
            'serendipity' => '0.7',
        ));
        $propbag->add('version',     '1.5.2');
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
    }

    function introspect_config_item($name, &$propbag) {

        $current_domain_name = $_SERVER['HTTP_HOST'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ada.skynettechnologies.us/check-website',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('domain' => 'example4644.com') //'xoopsdemo.com', 'kirby.localhost.com', 'skynettechnologies.com'
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $settingURLObject = json_decode($response);
        echo '<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", (event) => {
            document.querySelector(".aioa-cst-wrapper").parentNode.querySelector(".configure_plugin").style.display = "none";
           document.querySelector("#content").append(document.querySelector(".aioa-cst-wrapper"))
//            document.querySelector("#content").append(document.querySelector(".aioa-heading-wrapper"))
        });</script>';
        try{
            if(isset($settingURLObject->status) && $settingURLObject->status == 3)
            { ?>
                <div class="aioa-cst-wrapper aioa-expire-plan-wrapper">
                    <h3 style="color: #aa1111">It appears that you have already registered! Please click on the "Manage Subscription" button to renew your subscription.<br> Once your plan is renewed, please refresh the page.</h3>
                    <div style="text-align: left; width:100%; padding-bottom: 10px;"><a target="_blank" class="aioa-cancel-button"  href="<?php echo $settingURLObject->settinglink;?>">Manage Subscription</a></div>
                </div>
            <?php }
            else if(isset($settingURLObject->status) && $settingURLObject->status > 0 && $settingURLObject->status < 3)
            {
                ?>
                <div class="aioa-cst-wrapper aioa-heading-wrapper">
                    <h2>Widget Preferences:</h2>
                    <div style="width:100%; padding-bottom: 10px;">
                        <a target="_blank" class="aioa-cancel-button" href="<?php echo $settingURLObject->manage_domain;?>">Manage Subscription</a>
                    </div>
                    <iframe id="aioamyIframe" width="100%" style=" height: calc(100vh - 150px); max-width: 1920px;" height="2900px"  src="<?php echo $settingURLObject->settinglink; ?>"></iframe>
                </div>

                <?php
            }
            else{
                ?>
                <div class="aioa-cst-wrapper aioa-new-user-wrapper">
                    <iframe src="https://ada.skynettechnologies.us/trial-subscription?isframe=true&website=<?php echo $current_domain_name;?>&developer_mode=true" height="600px;" width="100%" style="    height: calc(100vh - 100px); border: none;"></iframe>
                </div>
                <?php
            }
        } catch(Exception $e){}
    }

    function generate_content(&$title) {
        global $serendipity;
        echo '<script id="aioa-adawidget" src="https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode=420083&token=&t=0.31826311872414603&position="></script>';
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>
