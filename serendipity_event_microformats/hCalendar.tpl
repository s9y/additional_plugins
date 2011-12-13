<div class="vevent" style="clear:left; /*background-color:#FFF;*/ padding:1em;border:1px solid #EEE;">
    <p class="summary" style="font-size:1.2em;font-weight:bold;margin-bottom:1em">{$hcalendar_summary}</p>
    <p style="margin-bottom:.5em"><span style="float:left;width:100px;font-weight:bold">Wann?</span>
    <abbr class="dtstart" title="{$hcalendar_startdate}{$hcalendar_timezone}" style="font-weight:bold">{$hcalendar_startdate_humanreadable}</abbr> bis <abbr class="dtend" title="{$hcalendar_enddate}{$hcalendar_timezone}" style="font-weight:bold">{$hcalendar_enddate_humanreadable}</abbr></p>
    <p style="margin-bottom:.5em"><span style="float:left;width:100px;font-weight:bold">Wo?</span>
    <a class="url" href="{$hcalendar_url}"><span class="location">{$hcalendar_location}</span></a></p>
    <p style="margin-bottom:.5em"><span style="float:left;width:100px;font-weight:bold">Was?</span>
    <span class="description">{$hcalendar_desc}</span></p>
</div>
{if $subnode == 1}
<script type="application/x-subnode; charset=utf-8">
    <!-- the following is structured blog data for machine readers. -->
    <subnode xmlns:data-view="http://www.w3.org/2003/g/data-view#" data-view:interpreter="http://structuredblogging.org/subnode-to-rdf-interpreter.xsl" "xmlns="http://www.structuredblogging.org/xmlns#subnode">
        <xml-structured-blog-entry xmlns="http://www.structuredblogging.org/xmlns">
            <generator id="s9y-sb-1" type="x-wpsb-simple-event" version="1"/>
            <simple-event version="1" xmlns="http://www.structuredblogging.org/xmlns#simple-event">
                <datetime>{$hcalendar_startdate_subnode}</datetime>
                <event-title>{$hcalendar_summary}</event-title>
                <location>{$hcalendar_location}</location>
                <more-information url="{$hcalendar_url}"/>
                <description type="text/html" escaped="true">{$hcalendar_desc_escaped}</description>
            </simple-event>
        </xml-structured-blog-entry>
    </subnode>
</script>
{/if}