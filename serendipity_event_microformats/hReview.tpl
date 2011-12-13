
<div class="hreview" style="clear:left; /*background-color:#FFF;*/ padding:1em;border:1px solid #EEE;">
    <div style="float:left;width:130px;padding:10px;background-color:#EEE; margin-right:10px;">
    {if $hreview_image}
    <p style="margin-bottom:1em;text-align:center;"><img src="{$hreview_image}" class="photo" alt="{$hreview_name}" /></p>
    {/if}
    <p style="margin-bottom:1em;"><a href="{$hreview_url}" class="item url">{$hreview_name}</a><br style="margin-bottom:1em;"/></p>
    <!--<p style="margin-bottom:1em;">Rating: {$hreview_rating} out of 5<br/>-->
    <p class="rating">{$hreview_rating_symbols} (<abbr class="value">{$hreview_ratingvalue}</abbr>/<abbr class="best">{$hreview_best}</abbr>)</p><!--</p>-->
    </div>
    <h5 class="summary" style="margin:0 0 1em 0;font-size:1.2em">{$hreview_summary}</h5>
	<span class="dtreviewed" title="{$hreview_date}{$hreview_timezone}">{$hreview_date_humanreadable}</span>
	<span class="reviewer fn" style="display:none">{$hreview_reviewer}</span>
	<span class="type" style="display:none">{$hreview_type}</span>
	<p class="description">
	{$hreview_desc}
	</p>
    <p style="clear:left;"></p>
</div>
{if $subnode == 1}
<script type="application/x-subnode; charset=utf-8">
    <!-- the following is structured blog data for machine readers. -->
    <subnode xmlns:data-view="http://www.w3.org/2003/g/data-view#" data-view:interpreter="http://structuredblogging.org/subnode-to-rdf-interpreter.xsl" xmlns="http://www.structuredblogging.org/xmlns#subnode">
        <xml-structured-blog-entry xmlns="http://www.structuredblogging.org/xmlns">
            <generator id="s9y-sb-1" type="x-s9y-sb-simple-review" version="1"/>
            <simple-review version="1" xmlns="http://www.structuredblogging.org/xmlns#simple-review">
                <review-title>{$hreview_summary}</review-title>
                <review-type>{$hreview_type}</review-type>
                <rating number="{$hreview_rating}" base="5" value="{$hreview_ratingvalue}">{$hreview_rating} out of 5</rating>
                <product-name>{$hreview_name}</product-name>
                <product-link>{$hreview_url}</product-link>
                <product-image-link>{$hreview_image}</product-image-link>
                <description type="text/html" escaped="true">{$hreview_desc_escaped}</description>
            </simple-review>
        </xml-structured-blog-entry>
    </subnode>
</script>
{/if}