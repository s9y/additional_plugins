 <script language="Javascript" type="text/javascript">
<!--
function popImage(file_name,file_title,file_width,file_height) {ldelim}
	if (parseInt(navigator.appVersion.charAt(0))>=4){ldelim}
		var optBrowser='scrollbars=yes,width='+file_width+',height='+file_height+',toolbar=no,menubar=no,location=no,resize=1,resizable=0';
		var imgWin=window.open('about:blank','',optBrowser);
		with (imgWin.document){ldelim}
			writeln('<html><head><title>Loading...</title>');
			writeln('<style>body{ldelim}margin:0;padding:0;text-align:center;{rdelim} img{ldelim}border:0px;{rdelim}</style>');
			writeln('</head>');
			writeln('<sc'+'ript>');
			writeln('function doTitle(){ldelim}document.title="'+file_title+'";{rdelim}');
			writeln('</sc'+'ript>');
			writeln('<body onload="self.focus();doTitle()">');
			writeln('<a href="javascript:window.close()"><img src="'+file_name+'" width="'+file_width+'" height="'+file_height+'" alt=""/></a>');
			writeln('</body></html>');
			close();
		{rdelim}
	{rdelim}
{rdelim}
//-->
</script>
<div class="serendipity_Entry_Date serendipity_event_usergallery">
    <div class="serendipity_entry">
    	<h3 class="serendipity_date">{$plugin_usergallery_title}</h3>

        <div class="serendipity_entry_body">
          	<div class="serendipity_gallery_navigation">
            	<a href="{$plugin_usergallery_httppath}">{$plugin_usergallery_title}</a>{foreach name="gallery" from=$plugin_usergallery_gallery_breadcrumb item="gallery"} &raquo; <a href="{$plugin_usergallery_httppath_extend}gallery={$gallery.path}">{$gallery.name}</a>{/foreach}{if $plugin_usergallery_limit_directory!=""} &raquo; <a href="{$plugin_usergallery_httppath_extend}gallery={$plugin_usergallery_currentgal}">{$plugin_usergallery_limit_directory}</a>{/if}
            </div>
        {if $plugin_usergallery_preface}
			<div class="serendipity_preface">{$plugin_usergallery_preface}</div>
		{/if}
		<!-- album list -->
		{if $plugin_usergallery_dir_list eq 'yes'}
			<ul class="plainList serendipity_gallery_directory">
			{if $plugin_usergallery_display_dir_tree eq "yes"}
        	<!-- basefolder in treeview -->
            	<!-- considering singular/plural form of "image" depending on the filecount -->
            	<li><a href="{$plugin_usergallery_httppath}">{$plugin_usergallery_title} ({$plugin_usergallery_maindir_filecount} {if $plugin_usergallery_maindir_filecount == 1}{$CONST.IMAGE}{else}{$CONST.PLUGIN_EVENT_USERGALLERY_IMAGES}{/if})</a></li>
			{else}
	   			{if $plugin_usergallery_toplevel eq 'no'}
				<!-- 'up-one-level' link in galleries-->
				<li><a href="{$plugin_usergallery_httppath_extend}gallery={$plugin_usergallery_uppath}">{$const.uponelevel} ({$plugin_usergallery_maindir_filecount} {if $plugin_usergallery_maindir_filecount == 1}{$CONST.IMAGE}{else}{$CONST.PLUGIN_EVENT_USERGALLERY_IMAGES}{/if})</a></li>
	   			{else}
				<!-- basefolder in listview -->
				<li><a href="{$plugin_usergallery_httppath}">{$plugin_usergallery_title} ({$plugin_usergallery_maindir_filecount} {if $plugin_usergallery_maindir_filecount == 1}{$CONST.IMAGE}{else}{$CONST.PLUGIN_EVENT_USERGALLERY_IMAGES}{/if})</a></li>
	   			{/if}
			{/if}
			<!-- folders -->
   			{foreach name="dir_list" from=$plugin_usergallery_subdirectories item="dir"}
            	<li style="padding-left: {$dir.pxdepth}px;"><a href="{$plugin_usergallery_httppath_extend}gallery={$dir.relpath}">{$dir.name} ({$dir.filecount} {if $dir.filecount == 1}{$CONST.IMAGE}{else}{$CONST.PLUGIN_EVENT_USERGALLERY_IMAGES}{/if})</a></li>
   			{/foreach}
   			</ul>
		{/if}
		<!-- end album list -->
		{if $plugin_usergallery_pagination}
		<!-- pagination -->
		<div class="serendipity_gallery_pagination_top" style="text-align: center">
			{if $plugin_usergallery_current_page != 1}
			<a class="prev" href="{$plugin_usergallery_httppath_extend}gallery={$plugin_usergallery_currentgal}&amp;page={$plugin_usergallery_previous_page}">&laquo; {$CONST.PREVIOUS_PAGE}</a>
			{/if}
            <span>({$CONST.PLUGIN_EVENT_USERGALLERY_PAGINATION|@sprintf:$plugin_usergallery_current_page:$plugin_usergallery_total_pages:$plugin_usergallery_total_count})</span>
			{if $plugin_usergallery_current_page != $plugin_usergallery_total_pages}
			<a class="next" href="{$plugin_usergallery_httppath_extend}gallery={$plugin_usergallery_currentgal}&amp;page={$plugin_usergallery_next_page}">{$CONST.NEXT_PAGE} &raquo;</a>
			{/if}
		</div>
		<!-- end pagination -->
		{/if}
		<!-- images -->
   		{foreach name="column" from=$plugin_usergallery_images item="image"}
   		{if $smarty.foreach.column.first}
   		<div class="serendipity_gallery_row">
 		{/if}
    		<div class="serendipity_gallery_thumbs" style="width: {$plugin_usergallery_colwidth}%;">
    		{if $image.isimage}
           		{if $plugin_usergallery_image_display eq 'popup'}
				<!-- popup -->
             	<a href="javascript:popImage('{$image.fullimage}','{$image.name}','{$image.dimensions_width}','{$image.dimensions_height}')"><img class="gallery_thumb" {if $plugin_usergallery_fixed_width !=0}height={$plugin_usergallery_fixed_width}px width={$plugin_usergallery_fixed_width}px{/if} src="{$image.link}" alt="" /></a>
          		{else}
				<!-- show thumb -->
	      		<a href="{$plugin_usergallery_httppath_extend}serendipity[image]={$image.id}"><img class="gallery_thumb" {if $plugin_usergallery_fixed_width !=0}height={$plugin_usergallery_fixed_width}px width={$plugin_usergallery_fixed_width}px{/if} style="width: 100%;" src="{$image.link}" alt="" /></a>
           		{/if}
    		{else}
				<!-- download link -->
            	<a href="{$image.fullimage}" target=blank><img class="gallery_thumb" src="{$image.link}" alt="" /></a><br><a href="{$image.fullimage}" target=blank>Download {$image.name}.{$image.extension}</a>
    		{/if}
		    </div>
		{if $smarty.foreach.column.last}
		<!-- last column -->
			<div style='clear: both;'></div>
	   	</div>
		{else}
	       	{if $smarty.foreach.column.iteration is div by $plugin_usergallery_cols}
	 		<!-- new column -->
	       	<div style='clear: both;'></div>
		</div>
		<div class="serendipity_gallery_row">
	    	{/if}
    	{/if}
	    {/foreach}
		<!-- end images -->
		{if $plugin_usergallery_pagination}
		<!-- pagination -->
		<div class="serendipity_gallery_pagination_bottom" style="text-align: center">
			{if $plugin_usergallery_current_page != 1}
			<a class="prev" href="{$plugin_usergallery_httppath_extend}gallery={$plugin_usergallery_currentgal}&amp;page={$plugin_usergallery_previous_page}">&laquo; {$CONST.PREVIOUS_PAGE}</a>
			{/if}
            <span>({$CONST.PLUGIN_EVENT_USERGALLERY_PAGINATION|@sprintf:$plugin_usergallery_current_page:$plugin_usergallery_total_pages:$plugin_usergallery_total_count})</span>
			{if $plugin_usergallery_current_page != $plugin_usergallery_total_pages}
			<a class="next" href="{$plugin_usergallery_httppath_extend}gallery={$plugin_usergallery_currentgal}&amp;page={$plugin_usergallery_next_page}">{$CONST.NEXT_PAGE} &raquo;</a>
			{/if}
		</div>
		<!-- end pagination -->
		{/if}
	</div>
    </div>
</div>
