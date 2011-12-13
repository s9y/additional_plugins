
<!-- plugin_staticpage_sidebar.tpl -->

<div class="staticpage_sbList" style="margin: 0;padding: 0;{* take styles into your templates css file *}">
{if !empty($staticpage_jsStr)}
    <div class="staticpage_sbJsList" style="overflow: hidden;white-space: nowrap;padding-bottom: 10px;{* take styles into your templates css file *}">
    {$staticpage_jsStr}
    </div>
{/if}
{if !$staticpage_jsStr or empty($staticpage_jsStr)}
  <dl>
{if $frontpage_path}
    <dt><a href="{$frontpage_path}">{$CONST.PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME}</a></dt>
{/if}
{if is_array($staticpage_listContent) and !empty($staticpage_listContent)}
{foreach name="pageList" from=$staticpage_listContent item="pageList"}
  {if !empty($pageList.permalink)}
    <dt><a href="{$pageList.permalink}" title="{$pageList.pagetitle}" style="padding-left: {$pageList.depth}px;">{$pageList.headline|truncate:20:"..."}</a></dt>
  {else}
    <dt><span style="padding-left: {$pageList.depth}px;">{$pageList.headline|truncate:20:"..."}</span></dt>
  {/if}
{/foreach}
{/if}
  </dl>
{/if}
</div>
