
<section id="maintenance_vgwort" class="equal_heights quick_list">
    <h3>{$CONST.PLUGIN_EVENT_VGWORT_TPL_TITLE}</h3>
    <h4>Reserve: {$unused}</h4> 
    
    <form enctype="multipart/form-data" method="POST" action="{$serendipityBaseURL}index.php?/plugin/vgwortImport">
        <label>{$CONST.PLUGIN_EVENT_VGWORT_TPL_IMPORT} <a href="https://tom.vgwort.de/portal/metis/secure/editOrderPersonalizedPixel">T.O.M</a></label>
        <input type="file" name="csv"/>
        <button>{$CONST.GO}</button>
    </form>
</section>