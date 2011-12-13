<div class="feedlist_items">

    {foreach from=$feedlist_entries item="feedlist_entry"}
    <div class="feedlist_item">    
        {if $feedlist_entry.feedicon != ''}
    <div class="feedlist_image">
        <img src="{$feedlist_entry.feedicon|@escape}" />
    </div>
        {/if}
        
        <h3><a href="{$feedlist_entry.htmlurl}">{$feedlist_entry.feedname}</a></h3>
        
        <h4><a href="{$feedlist_entry.entryurl}">{$feedlist_entry.entrytitle}</a></h4>

        <div class="feedlist_body">
            {$feedlist_entry.entrybody|@truncate:255:'...'}
        </div>
        
        <div class="feedlist_date">
            {$feedlist_entry.entrydate|@date_format:'%d.%m.%Y %H:%M'}
        </div>

    {/foreach}
    </div>

</div>
