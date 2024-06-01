<?php

use http\Client\Request;

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_allinoneaccessibility extends serendipity_plugin

{
    var $dbold = '';

    function introspect(&$propbag) {
        $propbag->add('author',    PLUGIN_EVENT_ALLINONEACCESSIBILITY_AUTHOR);
        $propbag->add('name',           PLUGIN_EVENT_ALLINONEACCESSIBILITY_NAME);
        $propbag->add('description',    PLUGIN_EVENT_ALLINONEACCESSIBILITY_DESC);
        $propbag->add('configuration',  array('licence_key','colorcode','position','icon_type','icon_size'));
       $propbag->add('requirements',  array(
            'serendipity' => '0.7',
        ));
        $propbag->add('version',     '1.0.0');
        $propbag->add('event_hooks', array('frontend_configure' => true));
       $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
    }

    function introspect_config_item($name, &$propbag) {

        switch($name) {
            case 'licence_key':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_ALLINONEACCESSIBILITY_LICENCE_KEY);
                break;
            case 'colorcode':
                $propbag->add('type','string');
                $propbag->add('name', PLUGIN_EVENT_ALLINONEACCESSIBILITY_COLOR);
                $propbag->add('default', '420083');
                break;
            case 'position':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_EVENT_ALLINONEACCESSIBILITY_ICON_POSITION);
                $propbag->add('default', 'bottom_right');
                $propbag->add('radio', array(
                    'value' => array('top_left', 'top_center', 'top_right', 'bottom_left', 'bottom_right' , 'bottom_center', 'middel_left', 'middel_right'),
                    'desc'  => array(
                        PLUGIN_EVENT_ALLINONEACCESSIBILITY_ICON_POSITION_TOP_LEFT, PLUGIN_EVENT_ALLINONEACCESSIBILITY_ICON_POSITION_TOP_CENTER, PLUGIN_EVENT_ALLINONEACCESSIBILITY_ICON_POSITION_TOP_RIGHT, PLUGIN_EVENT_ALLINONEACCESSIBILITY_ICON_POSITION_BOTTOM_LEFT, PLUGIN_EVENT_ALLINONEACCESSIBILITY_ICON_POSITION_BOTTOM_RIGHT, PLUGIN_EVENT_ALLINONEACCESSIBILITY_ICON_POSITION_BOTTOM_CENTER, PLUGIN_EVENT_ALLINONEACCESSIBILITY_ICON_POSITION_MIDDLE_LEFT, PLUGIN_EVENT_ALLINONEACCESSIBILITY_ICON_POSITION_MIDDLE_RIGHT
                    )
                ));
                echo "
                        <script>
                            if(typeof(codecheck_flag) == 'undefined') {
                                var codecheck_flag = 1;
                                if(codecheck_flag) {
                                    jQuery(document).ready(function(){
                                        const inpElem = document.querySelector('.grouped');
                                        const wrapper = document.createElement('div');
                                        const msg = document.createElement('span');
                                        //const upgrade_msg = document.createElement('span');
                                        inpElem.style.maxWidth = 'none';
                                        inpElem.style.width = '96%';
                                        wrapper.style.display = 'flex';
                                        wrapper.style.flexDirection = 'column';
                                        msg.innerText = 'Where would you like to place the accessibility icon on your site?';
                                        msg.style.color = 'black';
                                        inpElem.parentElement.append(wrapper);
                                        wrapper.append(inpElem);
                                        wrapper.prepend(msg);
                                    });
                                }
                            }
                        </script>";
                break;
            case 'icon_type':
                    $propbag->add('type', 'select');
                    $propbag->add('name', PLUGIN_EVENT_ALLINONEACCESSIBILITY_ICON_TYPE);
                    $propbag->add('select_values', array('aioa-icon-type-1' => PLUGIN_EVENT_ALLINONEACCESSIBILITY_ACCESSIBILITY, 'aioa-icon-type-2' => PLUGIN_EVENT_ALLINONEACCESSIBILITY_WHEELCHAIR, 'aioa-icon-type-3' => PLUGIN_EVENT_ALLINONEACCESSIBILITY_LOWVISION));
                    $propbag->add('default', 'aioa-icon-type-1');
                break;
            case 'icon_size':
                    $propbag->add('type', 'select');
                    $propbag->add('name', PLUGIN_EVENT_ALLINONEACCESSIBILITY_ICON_SIZE);
                    $propbag->add('select_values', array('aioa-big-icon' => PLUGIN_EVENT_ALLINONEACCESSIBILITY_AIOA_BIG_ICON, 'aioa-medium-icon' => PLUGIN_EVENT_ALLINONEACCESSIBILITY_AIOA_MEDIUM_ICON, 'aioa-default-icon' => PLUGIN_EVENT_ALLINONEACCESSIBILITY_AIOA_ICON, 'aioa-small-icon' => PLUGIN_EVENT_ALLINONEACCESSIBILITY_AIOA_SMALL_ICON, 'aioa-extra-small-icon' => PLUGIN_EVENT_ALLINONEACCESSIBILITY_AIOA_EXTRA_SMALL_ICON));
                    $propbag->add('default', 'aioa-default-icon');

                break;
            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title) {
        global $serendipity;
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;
            $hooks = &$bag->get('event_hooks');
            echo '<script src="' . $serendipity['serendipityHTTPPath'] . '/plugins/serendipity_event_allinoneaccessibility/main.js' . '"></script>';
            $licence_key = $this->get_config('licence_key');
            $color_code = $this->get_config('colorcode');
            $position = $this->get_config('position');
            $icon_type = $this->get_config('icon_type');
            $icon_size = $this->get_config('icon_size');
            $url = "https://www.skynettechnologies.com/add-ons/license-api.php?";
            $domain_name = $_SERVER['HTTP_HOST'];
            $metadata['token'] = $this->get_config('licence_key');
            $metadata['domain'] = $domain_name;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $metadata);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $resp = curl_exec($curl);
            $resp = json_decode($resp);
            $currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if (strpos($currentURL, '/serendipity_admin.php') !== false) {
                return true;
            }else{
                if ($resp->valid == 1) {
                    $allinoneaccessibilityOutput = '
                    <script id="aioa-adawidget"
                    src= "https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode=' . $color_code . '&token=' . $licence_key . '&position=' . $position . '.' . $icon_type . '.' . $icon_size . '">
                    </script>';
                }elseif($licence_key !='' && $resp->valid == 0){
                }else{
                    $allinoneaccessibilityOutput = '
                    <script id="aioa-adawidget" src="https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode=420083&token=&t=0.31826311872414603&position="></script>';
                }
                echo $allinoneaccessibilityOutput;
            }
        }
    }
//?>
