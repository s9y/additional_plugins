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
<div class="serendipity_Entry_Date serendipity_event_usergallery_image_display">

   	<h3 class="serendipity_date">{$plugin_usergallery_title}</h3>
   	<h4 class="serendipity_title">{$plugin_usergallery_limit_directory}</h4>
   	
  	<div class="serendipity_entry">
      	<div class="serendipity_gallery_navigation">
	   		<!-- navigation -->
			<a href="{$plugin_usergallery_httppath}">{$plugin_usergallery_title}</a> 
			{foreach name="gallery" from=$plugin_usergallery_gallery_breadcrumb item="gallery"}
			&raquo; <a href="{$plugin_usergallery_httppath_extend}gallery={$gallery.path}">{$gallery.name}</a>
			{/foreach}
			<div style="float: left;">
				{if $plugin_usergallery_previousid != -1}
				<a href="{$plugin_usergallery_httppath_extend}serendipity[image]={$plugin_usergallery_previousid}">&laquo; {$CONST.PREVIOUS}</a>
				{/if}
      		</div>
			<div style="float: right;">
      			{if $plugin_usergallery_nextid != -1}
      			<a href="{$plugin_usergallery_httppath_extend}serendipity[image]={$plugin_usergallery_nextid}">{$CONST.NEXT} &raquo;</a>
				{/if}
      		</div> 
	   		<!-- end navigation -->
		</div>

		<br />

        <div class="serendipity_gallery_entry">
           	<div class="serendipity_gallery_title">
			   	{$plugin_usergallery_file.title}
            </div>
            {if $plugin_usergallery_file.is_image}
			<!-- Popup -->
            <a href="javascript:popImage('{$plugin_usergallery_file.link}','{$plugin_usergallery_file.name}','{$plugin_usergallery_file.dimensions_width}','{$plugin_usergallery_file.dimensions_height}')">
            <img class="gallery_thumb" width="{$plugin_usergallery_file.alt_width}px" height="{$plugin_usergallery_file.alt_height}px" src="{$plugin_usergallery_file.link}" border="0" alt="" /></a>
            {else}
            <!-- download link -->
            <a href="{$plugin_usergallery_file.link}" alt="{$plugin_usergallery_file.name}" />{$CONST.USERGALLERY_DOWNLOAD_HERE}</a>
            {/if}
            <!-- file information -->
			<div class="serendipity_gallery_info">
				{$CONST.USERGALLERY_SEE_FULLSIZED}.<br />
				{if count($plugin_usergallery_file.entries) > 0}
				    {$CONST.USERGALLERY_LINKED_ENTRIES}
				    <ol>
    				{foreach from=$plugin_usergallery_file.entries item="link"}
    				    <li><a href="{$link.href}">{$link.title}</a></li>
    				{/foreach}
    				</ol>
    		            {/if}
				{if count($plugin_usergallery_file.staticpage_results) > 0}
				    {$CONST.USERGALLERY_LINKED_STATICPAGES}
                            <ol>
                            {foreach from=$plugin_usergallery_file.staticpage_results item="result"}
                                <li><a href="{$result.href}">{$result.title}</a></li>
                            {/foreach}
                            </ol>
                        {/if}

       			{$plugin_usergallery_file.name}.{$plugin_usergallery_file.extension}<br />
       			{$const.filesize}: {$plugin_usergallery_file.size_txt} kb<br />
			      {foreach name="info" from=$plugin_usergallery_extended_info item="entry"}
                        {$entry.name}: {$entry.value}<br />
                        {/foreach}
				{if $plugin_usergallery_file.is_image}
       			{$plugin_usergallery_xtra_info}<br />
				{/if}
                  </div>
        </div>
   	</div>
</div>
