<?php
if (IN_serendipity !== true) {
    die ("Don't hack!");
}

# (c) 2007 by Jude 'judebert' Anthony, http://judebert.com/

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

#########################################################################################


class serendipity_event_advtypes extends serendipity_event {

    var $debug;

    function introspect(&$propbag) {
        global $serendipity;

        $propbag->add('name',          PLUGIN_ADVTYPES_TITLE);
        $propbag->add('description',   PLUGIN_ADVTYPES_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '1.1',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));

        $propbag->add('version',       '0.6');
        $propbag->add('author',       'Judebert (<a href="http://judebert.com/">http://judebert.com/</a>)');
        $propbag->add('stackable',     false);
        $propbag->add('event_hooks',   array(
            'backend_header'              => true,
            'backend_pluginconfig_media'  => true,
            'backend_pluginconfig_sequence' => true,
        ));
        //$propbag->add('configuration', array('unused'));
        $propbag->add('configuration', array('unused', 'sequence_tester', 'seqtest2'));
        $propbag->add('groups', array('BACKEND_TEMPLATES'));
        //$this->dependencies = array('serendipity_event_entryproperties' => 'keep');
    }

    function introspect_config_item($name, &$propbag) {
        global $serendipity;
        
        switch($name) {
            case 'unused' :
                $propbag->add('type', 'string');
                $propbag->add('name', 'unused');
                $propbag->add('description', 'unused');
                $propbag->add('default', 'unused');
                break;
            case 'sequence_tester' :
                $propbag->add('type', 'sequence');
                $propbag->add('name', 'Unused Sequence Widget');
                $propbag->add('description', 'A sequence widget to test the sequence widget code.');
                $propbag->add('values', array('1' => array('display' => 'This', 'img' => serendipity_getTemplateFile('img/emoticons/cool.png')),
                                             '2' => array('display' => 'That', 'img' => serendipity_getTemplateFile('img/emoticons/smile.png')),
                                             '3' => array('display' => 'The Other', 'img' => serendipity_getTEmplateFile('img/s9y_banner_small.png')),
                                             ));
                break;
            case 'seqtest2' :
                $propbag->add('type', 'sequence');
                $propbag->add('name', 'Multiple Unused Sequence Widgets');
                $propbag->add('description', 'A sequence widget to test the sequence widget code with multiple sequences.');
                $propbag->add('values', array('First Item',
                                             'Second Item' => array('display' => '2nd item'),
                                             'Third Item',
                                             ));
                $propbag->add('default', 'Third Item,Second Item,First Item');
                break;
            default:
                return false;
        }
        return true;
    }

    
    function generate_content(&$title) {
        $title = PLUGIN_ADVTYPES_TITLE;
    }

    function event_hook($event, &$bag, &$eventData, $addlData) {
        global $serendipity;
        
        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
            case 'backend_header':
                // Output the JavaScript, if we must
                $getModule = $serendipity['GET']['adminModule'];
                $postModule = $serendipity['POST']['adminModule'];
                if ($getModule == 'templates' || $postModule == 'templates' || $getModule == 'plugins' || $postModule == 'plugins') {
                    // Includes copied from include/admin/plugins.inc.php
                    echo '<script src="' . serendipity_getTemplateFile('dragdrop.js') . '" type="text/javascript"></script>';
                    //echo '<div class="warning js_warning"><em>' . PREFERENCE_USE_JS_WARNING . '</em></div>';
                    $media_js = serendipity_getTemplateFile('media_input.js');
                    print <<<EOS
<script type="text/javascript" language="JavaScript" src="serendipity_editor.js"></script>
<script type="text/javascript">
function change_preview(id)
{
    var text_box = document.getElementById("serendipity[template][" + id + "]");
    var image_box = document.getElementById(id + "_preview"); 
    var filename = text_box.value;
    image_box.style.backgroundImage = "url(" + filename + ")";
}
function choose_media(id)
{
    window.open('serendipity_admin_image_selector.php?serendipity[htmltarget]=' + id + '&serendipity[filename_only]=true', 'ImageSel', 'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1');
}
</script>

EOS;
                }
                break;

            case 'backend_pluginconfig_media':
                // Print the HTML to display the popup media selector
                $postKey = $eventData['postKey'];
                $var = $eventData['config_item'];
                $savedValue = $eventData['value'];
                $cbag = $eventData['cbag'];
                $cname = $cbag->get('name');
                $cdesc = $cbag->get('description');
                $preview_width = $cbag->get('preview_width');
                if (!$preview_width || $preview_width == "") {
                  $preview_width = '400px';
                }
                $preview_height = $cbag->get('preview_height');
                if (!$preview_height || $preview_height == "") {
                  $preview_height = '100px';
                }
                $media_link_text = MEDIA_LIBRARY;
                print <<<EOS
<tr><td colspan="2">
  <strong>$cname</strong>
  <br /><span style="color: #5E7A94; font-size: 8pt;">$cdesc</span>
</td> </tr>
<tr>
  <td style="border-bottom: 1px solid #000000">
    <!-- <img id="{$var}_preview" src="$savedValue"> -->
    <div id="{$var}_preview" style="background-image: url($savedValue); width:$preview_width; height: $preview_height;">&nbsp;</div>
  </td>
  <td style="border-bottom: 1px solid #000000">
    <input class="input_textbox" type="text" id="serendipity[$postKey][$var]" name="serendipity[$postKey][$var]" value="$savedValue"  onchange="change_preview('$var')"/>
    <br /><a href="#" onclick="choose_media('serendipity[$postKey][$var]')">$media_link_text</a>
  </td>
</tr>
EOS;
                return true;
                break;

            case 'backend_pluginconfig_sequence':
                //
                // Print the HTML to display the [drag-n-drop] orderable list
                //

                // For the drag-n-drop to work, the list must be included in
                // a container (probably an <ol>) that JavaScript can access
                // (easiest by ID), with <li> children that have unique IDs,
                // and handles with ids of 'g'.$li_id.
                // I can't get it to work unless there's a class of
                // pluginmanager_container on the ol, either.
                // The drag-n-drop returns the list of IDs in order.
                //
                // I want this generic sequence widget to hide the ID, but
                // display a name or description with an optional picture.
                // (This would allow users to identify choices by thumbnail.)
                // Therefore, I need an array with keys 'id', 'display', and
                // 'imgurl' (or similar) to generate each list item.

                // Data sent by include/functions_plugins_admin.inc.php
                // It also passes bag and plugin, but we don't need those
                $postKey = $eventData['postKey'];
                $var = $eventData['config_item'];
                $savedValue = $eventData['value'];
                $cbag = $eventData['cbag'];
                // Get the data we need to display the list
                if (!$savedValue) {
                    $savedValue = $eventData['default'];
                }
                $cname = $cbag->get('name');
                $cdesc = $cbag->get('description');
                /** Unordered array of values */
                $items = $cbag->get('values');
                if (!is_array($items)) { $items = null; }
                /** Array specifying order to use values in $items */
                $order = null;
                if ($savedValue) {
                    $order = explode(',', $savedValue);
                }
                $uparrow_img = serendipity_getTemplateFile('admin/img/uparrow.png');
                $downarrow_img = serendipity_getTemplateFile('admin/img/downarrow.png');

                // $items is the list of things to sequence.  It's not in
                // order, and reordering PHP arrays is problematic.  So
                // we keep it unordered, and access its values according
                // to another array (appropriately named $order).
                if (is_array($items)) {
                    // Allow simple value for any sequence item
                    foreach ($items as $key => $item) {
                        if (!is_array($item)) {
                            // Replace this item with an empty array
                            unset($items[$key]);
                            $items[$item] = array();
                        }
                    }

                    // Make sure all the items are in the order list; new items
                    // go on the end (new items could have been added in
                    // introspect_config_items, but not been configured).
                    // Also fill out thumbnails and display names
                    foreach ($items as $id => $junk) {
                        if ($order == null) {
                            $order = array($id);
                        } else if (!in_array($id, $order)) {
                            $order[] = $id;
                        }
                        // If there's no defined display name, default to the ID
                        if (!isset($items[$id]['display'])) {
                            $items[$id]['display'] = $id;
                        }
                        // If there's no image, we just won't display anything.
                    }

                    // Make sure all the items to be ordered exist!  Otherwise
                    // we could try to sequence nothing.
                    $filtered = array();
                    foreach ($order as $id) {
                        if (array_key_exists($id, $items)) {
                            $filtered[] = $id;
                        }
                    }
                    $order = $filtered;
                } else {
                    // If there's nothing to sequence, make the order to use
                    // them in valid, but empty
                    $order = array();
                }

                // Start the row, add one cell for the name and description
                print <<<EOS
<tr>
<td style="border-bottom: 1px solid #000000; vertical-align: top">
  <strong>$cname</strong>
  <br /><span style="color: #5E7A94; font-size: 8pt;">$cdesc</span>
</td>

EOS;
                // Now add one cell for the list
                print <<<EOS
<td style="border-bottom: 1px solid #000000; vertical-align: middle">

EOS;
                // Print the list
                print <<<EOS
  <input type="hidden" name="serendipity[$postKey][$var]" id="${var}_value" value="$savedValue" />
  <noscript>
    <!-- Replace standard submit button when using up/down submits -->
    <input type="hidden" name="SAVECONF" value="Save" />
  </noscript>
  <ol id="$var" class="sequence_container pluginmanager_container">

EOS;
                $sort_idx == 0;
                $last = count($order) - 1;
                foreach ($order as $id) {
                    // Create the variables required to print this item
                    if ($sort_idx > 0) {
                        $swapping = $order;
                        $temp = $swapping[(int)$sort_idx];
                        $swapping[(int)$sort_idx] = $swapping[(int)($sort_idx - 1)];
                        $swapping[(int)($sort_idx - 1)] = $temp;
                        $oneup = implode(',' , $swapping);
                    }
                    if ($sort_idx < $last) {
                        $swapping = $order;
                        $temp = $swapping[(int)$sort_idx];
                        $swapping[(int)$sort_idx] = $swapping[(int)($sort_idx + 1)];
                        $swapping[(int)($sort_idx + 1)] = $temp;
                        $onedown = implode(',' , $swapping);
                    }


                    // Print the HTML
                    //
                    // Set the item and its ID
                    print '    <li id="'.$id.'" class="sequence_item pluginmanager_item_even">' . "\n";
                    // Make a handle with ID 'g$id'
                    print '      <div id="g'.$id.'" class="pluginmanager_grablet sequence_grablet"><a href="#"></a></div>' . "\n";
                    // Add the item contents
                    print '      <span>'.$items[$id]['display'].'</span>' . "\n";
                    if (isset($items[$id]['img'])) {
                        print '      <img src="'.$items[$id]['img'].'" />' . "\n";
                    }
                    // Luddite submit buttons (please, think of the scriptless!)
                    print "<noscript><div>\n";
                    if ($sort_idx == 0) {
                        // Skip the move-up submit button
                        print "&nbsp;\n";
                    } else {
                        print <<<EOS
  <button type="submit" name="serendipity[$postKey][$var]" value="$oneup">
    <img src="$uparrow_img" alt="Move Up">
  </button>

EOS;
                    }
                    if ($sort_idx == $last) {
                        // Skip the move-down submit button
                        print "&nbsp;\n";
                    } else {
                        print <<<EOS
  <button type="submit" name="serendipity[$postKey][$var]" value="$onedown">
    <img src="$downarrow_img" alt="Move Down">
  </button>

EOS;
                    }
                    print "</div></noscript>\n";
                    // Close the item
                    print '    </li>'."\n";
                    // Next, please
                    $sort_idx++;
                }
                if (!is_array($items) or empty($order)) {
                    // Print the empty message
                    print(PLUGIN_ADVTYPES_NOTHING_TO_SEQUENCE);
                }
                // Print the Javascript to drag-n-drop the list
                print <<<EOS
<script type="text/javascript">
    function init_${var}_Sequence()
    {
        var lst = document.getElementById("${var}");
        DragDrop.makeListContainer(lst, '${var}_group');
        lst.onDragOut = function() { 
            //var seq = DragDrop.serData('${var}_group', null); 
            var seq = DragDrop.serData(null, '${var}'); 
            var start = seq.indexOf("(");
            var end = seq.indexOf(")");
            seq = seq.slice((start + 1), end);
            var order = document.getElementById("${var}_value");
            order.value = seq;
        };
    }
    addLoadEvent(init_${var}_Sequence);
</script>

EOS;
                // Finish the row
                print <<<EOS
</td>

EOS;
                return true;
                break;

            }
        }
        return true;
    }
}

/* vim: set sw=4 sts=4 ts=4 expandtab : */
