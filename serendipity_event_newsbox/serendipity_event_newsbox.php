<?php # 

// Built from serendipity_event_entryproperties, with help from serendipity_event_includeentries

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_newsbox extends serendipity_event
{
    var $services;
    var $html = '<div class="newsbox"><i>No news today.</i></div>';
    var $isFrontPage = false;
    var $got_content = array();

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_NEWSBOX_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_NEWSBOX_DESC);
        $propbag->add('copyright',     'GPL');
        $propbag->add('groups',        array('FRONTEND_VIEWS', 'FRONTEND_FEATURES'));
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Jude Anthony');
        $propbag->add('version',       '0.6');
        $propbag->add('requirements',  array(
            'serendipity' => '1.0-alpha1',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        // Rejected event hooks
        //    'frontend_fetchentry'                               => true,
        //    'backend_publish'                                   => true,
        //    'backend_save'                                      => true,
        //    'backend_display'                                   => true,
        //    'backend_import_entry'                              => true,
        //    'entry_display'                                     => true,
        //    'frontend_entryproperties'                          => true,
        //    'backend_sidebar_entries_event_display_buildcache'  => true,
        //    'backend_sidebar_entries'                           => true,
        //    'backend_cache_entries'                             => true,
        //    'backend_cache_purge'                               => true,
        //    'backend_plugins_new_instance'                      => true,
        //    'frontend_entryproperties_query'                    => true,
        //    'frontend_entries_rss'                              => true
        $propbag->add('event_hooks',    array(
            'genpage'                => true,
            'frontend_fetchentries'  => true,
            'css'                    => true,
            'frontend_header'        => true,
            'entries_header'         => true,
            'entries_footer'         => true,
            'frontend_footer'        => true,
            'newsbox:get_containers' => true,
            'newsbox:get_content'    => true,
        ));
        $propbag->add('configuration', array('title', 'content_type', 'news_cats', 'max_entries', 'placement'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'title':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_NEWSBOX_TITLEFIELD);
                $propbag->add('description', PLUGIN_EVENT_NEWSBOX_TITLEFIELD_DESC);
                $propbag->add('default', 'News');
                break;
            case 'news_cats':
                $propbag->add('type',    'content');
                $propbag->add('default', $this->makeCategorySelector());
                // Name and description aren't used for type 'content'.
                break;
            case 'max_entries':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_NEWSBOX_NUMENTRIES);
                $propbag->add('description', PLUGIN_EVENT_NEWSBOX_NUMENTRIES_DESC);
                $propbag->add('default', '5');
                break;
            case 'placement':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_EVENT_NEWSBOX_PLACEMENT);
                $propbag->add('description', PLUGIN_EVENT_NEWSBOX_PLACEMENT_DESC);
                $select = array(
                    'page header'  => PLUGIN_EVENT_NEWSBOX_PLACEMENT_PAGE_TOP,
                    'entry top'    => PLUGIN_EVENT_NEWSBOX_PLACEMENT_ENTRY_TOP,
                    'entry bottom' => PLUGIN_EVENT_NEWSBOX_PLACEMENT_ENTRY_BOTTOM,
                    'page footer'  => PLUGIN_EVENT_NEWSBOX_PLACEMENT_PAGE_BOTTOM
                    );
                // Get all the newsbox containers (except me)
                $containers = array();
                serendipity_plugin_api::hook_event('newsbox:get_containers', $containers, array('id' => $this->instance));
                foreach( $containers as $container )
                {
                    $cid = $container['id'];
                    $cname = $container['name'];
                    $select[$cid] = $cname;
                }
                $select['hidden'] = PLUGIN_EVENT_NEWSBOX_PLACEMENT_HIDDEN;
                $propbag->add('select_values', $select);
                $propbag->add('default', 'entry top');
                break;
            case 'content_type':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_EVENT_NEWSBOX_CONTENTTYPE);
                $propbag->add('description', PLUGIN_EVENT_NEWSBOX_CONTENTTYPE_DESC);
                $radio = array();
                $radio['desc'] = array('Newsboxes', 'Categories');
                $radio['value'] = array('newsboxes', 'categories');
                $propbag->add('radio', $radio);
                $propbag->add('radio_per_row', 1);
                $propbag->add('default', 'categories');
                break;
        }
        return true;
    }

    // Ah, a neat trick.  See, when someone hits the "save" button for
    // configuration, it returns us to the configuration screen.  In that case,
    // s9y is going to call introspection again.  This gives us a chance to
    // check variables and change settings, even though the "configuration
    // saved" message has already been printed.  A bit deceptive, but
    // effective.
    //
    // Strangely, while serendipity_event_includeentries can use the same
    // string for the POST variable and the configuration variable name, I
    // get an error about htmlspecialchars() at admin/plugins.inc.php line
    // 356: an array is passed to parameter 1.  It's easily fixed by making
    // the two strings slightly different.
    function &makeCategorySelector()
    {
        global $serendipity;

        $selector = ''; // We start in our own, column-spanning row
        $selector .= '</td></tr>';
        $selector .= '<tr><td style="border-bottom: 1px solid #000; vertical-align: top">';
        $selector .= '<strong>'. PLUGIN_EVENT_NEWSBOX_NEWSCATS .'</strong><br />';
        $selector .= '<span style="color: rgb(94, 122, 148); font-size: 8pt;">';
        $selector .= PLUGIN_EVENT_NEWSBOX_NEWSCATS_DESC . '</span><br />';
        $selector .= '</td><td style="border-bottom: 1px solid #000">';
        $selector .= '<strong>' . CATEGORIES . '</strong><br />';

        // $selected_cats is used to set up the selections;
        // 'news_cats' holds the value when it's set.
        if (is_array($serendipity['POST']['plugin']['newscats']))
        {
            // Someone has already selected categories
            $selected_cats = array();
            foreach ($serendipity['POST']['plugin']['newscats'] AS $idx => $id)
            {
                $selected_cats[$id] = true;
            }
            $catlist = implode(',', array_keys($selected_cats));
            $this->set_config('news_cats', $catlist);
        } else {
            // Form is just being displayed; get previously selected categories
            // Must use default value! 'false' is very fast.
            $catlist = $this->get_config('news_cats', false);
            if (!$catlist)
            {
                $selected_cats = array();
            }
            else
            {
                $cat_ids = explode(',', $catlist);
                foreach ($cat_ids AS $id)
                {
                    $selected_cats[$id] = true;
                }
            }
        }

        $selector .= '<select name="serendipity[plugin][newscats][]" multiple="true" size="5">';
        if (is_array($cats = serendipity_fetchCategories())) {
            $cats = serendipity_walkRecursive($cats, 'categoryid', 'parentid', VIEWMODE_THREADED);
            foreach ( $cats as $cat ) {
                $catid = $cat['categoryid'];
                $selector .= '<option value="'. $catid .'"'
                    . (isset($selected_cats[$catid]) ? ' selected="selected"' : '')
                    . '>' . str_repeat('&nbsp;', $cat['depth'])
                    . $cat['category_name']
                    .'</option>' . "\n";
            }
        }

        $selector .= '</select>';
        $selector .= '</td></tr>';

        return $selector;
    }

    function generate_content(&$title) {
        $title = 'Newsbox: ' . $this->get_config('title');
    }

    function event_hook($event, &$bag, &$eventData, $addlData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        // I'm not really certain why this is here (since we only get called
        // for the events we hooked), but Garvin uses it, so it must be
        // important.
        if (isset($hooks[$event])) {
            $content_type = $this->get_config('content_type', 'categories');
            $placement = $this->get_config('placement', 'entry top');
            $news_cats = $this->get_config('news_cats');

            switch($event) {
                case 'genpage':
                    // Is this the frontpage? (Garvin's algorythm; works
                    // for all cases except index.html, on my server)
                    if ($addlData['startpage'])
                    {
                      $this->isFrontPage = true;
                    }
                    else
                    {
                      $this->isFrontPage = false;
                      return true;
                    }

                    // Get this newsbox's entries
                    //

                    // Hidden newsboxes don't need to waste time doing this.
                    if ($placement == 'hidden')
                    {
                      return true;
                    }

                    // If I don't contain categories, I don't generate HTML from categories.
                    if ($content_type != 'categories')
                    {
                      return true;
                    }

                    // If this newsbox is empty, we'd get an SQL error.
                    if (empty($news_cats))
                    {
                      $this->html = '<div class="newsbox"><i>No ' .
                          $this->get_config('title', PLUGIN_EVENT_NEWSBOX_DEFAULT_TITLE) .
                          ' today.</i></div>';
                      return true;
                    }

                    // Smarty isn't initialized yet.
                    serendipity_smarty_init();

                    // Create the SQL to fetch my entries
                    $sql = "\n" . ' e.id IN ' . "\n"
                        . '(SELECT entryid FROM '
                        . $serendipity['dbPrefix'] . 'entrycat'
                        . "\n" . ' WHERE categoryid IN ('
                        . $news_cats . ')' . "\n" . ')';

                    // We don't want our exclusion logic to execute on *this*
                    // fetchEntries call!
                    $serendipity['newsbox'] = 'no_exclude';
                    //--JAM: yeah, it looks like a bug to me.  I wonder what else gets accidentally overwritten?
                    $oldLimit = $serendipity['fetchLimit'];
                    // We want the number of entries configurable
                    $max_entries = $this->get_config('max_entries', 5);
                    if (!is_numeric($max_entries))
                    {
                        $max_entries = 5;
                    }
                    $entries = serendipity_fetchEntries(null, true,
                        $max_entries, false, false, 'timestamp DESC', $sql);
                    $serendipity['fetchLimit'] = $oldLimit;
                    unset($serendipity['newsbox']);

                    // Process our input data with new printEntries:
                    // $entries, no extended, no preview, block NEWSBOX, no smarty fetch, no hooks, footer
                    serendipity_printEntries($entries, 0, false, 'NEWSBOX', false, false, false);
                    $newsbox_data = array();
                    $newsbox_data['title'] = $this->get_config('title', PLUGIN_EVENT_NEWSBOX_DEFAULT_TITLE);
                    $newsbox_data['cats'] = explode(',', $news_cats);
                    $newsbox_data['content_type'] = $content_type;
                    $newsbox_data['isContainer'] = ($content_type != 'categories');
                    $newsbox_data['multicat_action'] = $serendipity['baseURL'] . $serendipity['indexFile'];
                    $serendipity['smarty']->assign('newsbox_data', $newsbox_data);
                    $nb = serendipity_getTemplateFile('newsbox.tpl');
                    if ($nb && $nb != 'newsbox.tpl')
                    {
                      // Template is obviously newsbox-aware
                      $this->html = serendipity_smarty_fetch('NEWSBOX', 'newsbox.tpl', false);
                    }
                    else
                    {
                      // Set the newsbox variable for the template, in case it's newsbox-aware
                      $serendipity['smarty']->assign('isNewsbox', true);

                      // Modify the footer link
                      $more = '<form style="display:inline;" action="' . $serendipity['baseURL'] . $serendipity['indexFile'] . '" method="post">';
                      foreach (explode(',', $news_cats) as $cat)
                      {
                        $more .= '<input type="hidden" name="serendipity[multiCat][]" value="' . $cat . '">';
                      }
                      $more .= '<input class="serendipityPrettyButton input_button" type="submit" name="serendipity[isMultiCat]" value="More ' . $this->get_config('title', PLUGIN_EVENT_NEWSBOX_DEFAULT_TITLE) . '"></form>';
                      $serendipity['smarty']->assign('footer_info', $more);

                      // Get the HTML
                      $serendipity['skip_smarty_hooks'] = true;  // Don't call entries_header from the template!
                      $this->html = serendipity_smarty_fetch('NEWSBOX', 'entries.tpl', false);
                      unset($serendipity['skip_smarty_hooks']);

                      // Don't leave the newsbox variable set for the regular fetch
                      $serendipity['smarty']->clear_assign('isNewsbox');

                      // Check if the template supports newsboxes
                      // Matches class = "whatever_newsbox_whatever", taking care to allow
                      // whitespace where legal and match quote types (I don't think you
                      // can use a quote in a class name, but hey...)
                      if (preg_match('/class\\s*=\\s*(["\'])[^\\1]*newsbox/', $this->html) == 0)
                      {
                        // Add the div; give it the default class "newsbox" and a title
                        $title = $this->get_config('title');
                        $this->html = "\n<div class=\"newsbox\"><h3 class=\"newsbox_title\">$title</h3>\n" . $this->html . "\n</div><!--newsbox-->\n";
                      }
                    }

                    // Done processing the newsbox
                    break;

                case 'frontend_fetchentries':
                    // Only on the frontpage
                    if (!$this->isFrontPage)
                    {
                        return true;
                    }

                    // Don't even call this hook if we're already in this hook
                    if (isset($serendipity['newsbox']) && $serendipity['newsbox'] == 'no_exclude')
                    {
                      return true;
                    }

                    // If we don't contain categories, we don't want to
                    // exclude categories accidentally
                    if ($content_type != 'categories')
                    {
                      return true;
                    }

                    // Don't restrict the calendar, etc; only the main listing
                    $source = $addlData['source'];
                    if ($source != 'entries')
                    {
                      return true;
                    }

                    // No joins required!
                    // $joins = array();
                    $conds = array();

                    if (isset($news_cats) && !empty($news_cats))
                    {
                      // Exclude entries in the newbox
                      $conds[] =
                        ' (e.id NOT IN (SELECT entryid from '
                        . $serendipity['dbPrefix'] . 'entrycat'
                        . ' WHERE categoryid IN (' . $news_cats . ')))';
                    }

                    if (count($conds) > 0) {
                        $cond = implode(' AND ', $conds);
                        if (empty($eventData['and'])) {
                            $eventData['and'] = " WHERE $cond ";
                        } else {
                            $eventData['and'] .= " AND $cond ";
                        }
                    }

                    return true;
                    break;

                case 'css':
                    // Can't tell if this is the fronpage or not.  Better
                    // generate the CSS, just in case.

                    if (strpos($eventData, 'newsbox') !== false)
                    {
                      // This CSS is already newsbox-aware.
                      return true;
                    }
                    $eventData = $eventData . '
.newsbox
{
  border: 1px solid black;
  padding: 2px;
  margin-bottom: 4px;
}
.newsbox_title
{
  font-style: italic;
}
.newsbox_container
{
  border: 1px solid black;
  padding: 2px;
  margin-bottom: 4px;
  text-align: center;
  margin: 2px auto;
}
.newsbox_container .newsbox
{
  border: none;
  width: 48%;
  float: left;
  text-align: left;
  margin: 2px;
  display: inline;
}
                    ';
                    return true;
                    break;

                // Placement cases: if configured placement equals the hook,
                // print my HTML.  Hidden takes care of itself: there is no
                // matching hook, so it never gets printed.  Contained
                // newsboxes will also never match a hook; their HTML is
                // requested by the containing newsbox.
                case 'frontend_header':
                    if ($this->isFrontPage && $placement == 'page header')
                    {
                        echo $this->getHTML();
                    }
                    return true;
                    break;
                case 'entries_header':
                    if ($this->isFrontPage && $placement == 'entry top')
                    {
                        echo $this->getHTML();
                    }
                    return true;
                    break;
                case 'entries_footer':
                    if ($this->isFrontPage && $placement == 'entry bottom')
                    {
                        // Entry footer markup is ugly.  Close the div.
                        echo '</div>';
                        echo $this->getHTML();
                        // Reopen the div we closed to avoid bad markup.
                        echo '<div>';
                    }
                    return true;
                    break;
                case 'frontend_footer':
                    if ($this->isFrontPage && $placement == 'page footer')
                    {
                        echo $this->getHTML();
                    }
                    return true;
                    break;

                case 'newsbox:get_content':
                    // Custom hook to retrieve data for contained newsboxes.
                    // If the container asking for content is my container,
                    // add my content to the data array.
                    if ($addlData['id'] == $placement)
                    {
                        // 1. Avoid recursion.
                        // 2. Go to step 1.
                        if (!$this->got_content[$addlData['id']])
                        {
                                $this->got_content[$addlData['id']] = true;
                                $eventData[] = $this->getHTML();
                        }
                        return true;
                    }
                    break;
                case 'newsbox:get_containers':
                    // Custom hook to find newsbox containers.  If I'm a newsbox
                    // container, return my instance ID.
                    if (($addlData['id'] != $this->instance)
                        && ($this->get_config('content_type', 'categories') == 'newsboxes'))
                    {
                        $eventData[] = array(
                            'id' => $this->instance,
                            'name' => 'Newsbox: ' . $this->get_config('title', PLUGIN_EVENT_NEWSBOX_DEFAULT_TITLE));
                        return true;
                    }
                    break;


                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
        return true;
    }

    // Convenience function to avoid duplicating code in every possible
    // placement of output.
    function getHTML()
    {
        global $serendipity;
        $content_type = $this->get_config('content_type', 'categories');
        if ($content_type == 'newsboxes')
        {
            // Wrap content from my contained newsboxes.
            $contents = array();
            serendipity_plugin_api::hook_event('newsbox:get_content',
                $contents, array('id' => $this->instance));
            $nb = serendipity_getTemplateFile('newsbox.tpl');
            if ($nb && $nb != 'newsbox.tpl')
            {
              // The template should be able to handle this
              $serendipity['smarty']->assign('NEWSBOX', $contents);
              $newsbox_data = array();
              $newsbox_data['title'] = $this->get_config('title', PLUGIN_EVENT_NEWSBOX_DEFAULT_TITLE);
              $newsbox_data['cats'] = '';
              $newsbox_data['content_type'] = $content_type;
              $newsbox_data['isContainer'] = true;
              $newsbox_data['multicat_action'] = '';
              $serendipity['smarty']->assign('newsbox_data', $newsbox_data);
              $this->html = serendipity_smarty_fetch('NEWSBOX', 'newsbox.tpl', false);
            }
            else
            {
            $this->html = "\n<div class=\"newsbox_container\"><h3 class=\"newsbox_title\">" . $this->get_config('title') . "</h3>\n";
            foreach ($contents as $box)
            {
                $this->html .= $box . "\n";
            }
            $this->html .= '<div style="clear:both;"><br /></div>' . "\n";
            $this->html .= "\n</div><!--newsbox_container-->\n";
        }
        }
        return $this->html;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>
