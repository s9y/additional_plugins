have a look at staticpage-entries-listing.tpl and plugin_staticpage_related_category.tpl!

for the backlinks from a category to the related static-page use this in your entries.tpl:
(you can use {$CONST.PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME} instead of {$blogTitle})

{if ($view == 'archives') || ($view == 'frontpage')}
    <table border="0" cellpadding="2" cellspacing="2" class="staticpage_navigation">
        <tr>
              <td class="staticpage_navigation_left">&raquo;

              <a href="{$serendipityBaseURL}">{$blogTitle}</a>
              &raquo; {$CONST.ARTICLE_OVERVIEW}</td>
        </tr>
    </table>
{/if}


{if ($view == 'categories')}
    <table border="0" cellpadding="2" cellspacing="2" class="staticpage_navigation">
        <tr>
              <td class="staticpage_navigation_left">&raquo;

              {if $staticpage_categorypage}
              <a href="{$staticpage_categorypage.permalink}">{$staticpage_categorypage.pagetitle}</a>
              {else}
              <a href="{$serendipityBaseURL}">{$blogTitle}</a>
              {/if}
              &raquo; {$CONST.ARTICLE_OVERVIEW}</td>
        </tr>
    </table>
{/if}
