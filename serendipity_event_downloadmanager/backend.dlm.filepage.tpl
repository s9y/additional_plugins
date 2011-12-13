{* backend.dlm.filepage.tpl last modified 2010-09-08 *}
<div id="dlm_backend_fileedit">
    <form action="?" name="editfileform" method="POST">
    <div>
        <input type="hidden" name="serendipity[adminModule]" value="event_display" />
        <input type="hidden" name="serendipity[adminAction]" value="downloadmanager" />
        <input type="hidden" name="serendipity[edited]" value="1" />
        <input type="hidden" name="serendipity[fileid]" value="{$dlmefe.fileid}" />
        <input type="hidden" name="serendipity[catid]" value="{$dlmefe.catid}" />
    </div>
    
    <div id="dlm_edit_file">
        <h4>{$CONST.PLUGIN_DOWNLOADMANAGER_EDIT_FILE}</h4>
        
        <div class="edit_field">
            <label for="dlm_file_moveto">{$CONST.PLUGIN_DOWNLOADMANAGER_MOVE_TO_CAT}</label>
            <select id="dlm_file_moveto" name="serendipity[moveto]">
            {foreach from=$dlmefe.selcatlist item="thiscat"}
                <option value="{$thiscat.cat.node_id}"{if $thiscat.cat.node_id == $dlmefe.catid} selected{/if}>{if $thiscat.cat.node_id != 1}&nbsp;&nbsp;{/if}{if is_array( $thiscat.imgname )}{foreach from=$thiscat.imgname item="tab"}{if $tab == 'e'}&nbsp;&nbsp;&nbsp;&nbsp;{/if}{if $tab == 'l'}&nbsp;&nbsp;&nbsp;|{/if}{if $tab == 'b' || $tab == 'nb'}&nbsp;&nbsp;&nbsp;{/if}{/foreach}{/if}{$thiscat.cat.payload}</option>
            {/foreach}
            </select>
        </div>
        <div class="edit_field">
            <label for="dlm_file_rename">{$CONST.PLUGIN_DOWNLOADMANAGER_EDIT_FILE_RENAME}</label>
            <input id="dlm_file_rename" type="text" name="serendipity[realfilename]" value="{$dlmefe.realfilename}" />
        </div>
        <div class="edit_field">
            <label for="">{$CONST.PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC}</label>
            <textarea onblur="if(this.value=='')this.value='<!--// {$CONST.PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC} /\/\-->';" onfocus="if(this.value=='<!--// {$CONST.PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC} /\/\-->')this.value='';" name="serendipity[description]">{$dlmefe.description}</textarea>
        </div>
        <input id="editfile_submit" class="serendipityPrettyButton input_button" type="submit" name="serendipity[dlmanAction]" value="{$CONST.GO}" />
    </div>
    </form>
</div><!-- div edit file end -->
