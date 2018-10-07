
<section id="maintenance_vgwort" class="equal_heights quick_list">
    <h3>Zählmarken</h3>
    <h4>Reserve: {$unused}</h4> 
    
    <form enctype="multipart/form-data" method="POST" action="{$serendipityBaseURL}index.php?/plugin/vgwortImport">
        <label>Import a new CSV with Zählmarken from <a href="https://tom.vgwort.de/portal/metis/secure/editOrderPersonalizedPixel">T.O.M</a></label>
        <input type="file" name="csv"/>
        <button>{$CONST.GO}</button>
    </form>
</section>