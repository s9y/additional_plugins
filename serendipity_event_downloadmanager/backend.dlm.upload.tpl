{* backend.dlm.upload.tpl last modified 2016-07-11 *}
<div id="dlm_backend_uploadform">
{if !empty( $dlmulf.file_uploads ) && ( $dlmulf.file_uploads == 1 || $dlmulf.file_uploads == true || $dlmulf.file_uploads == 'On' )}
    <form action="?" name="uploadfileform" method="POST" enctype="multipart/form-data">
    <div>
        <input type="hidden" name="serendipity[adminModule]" value="event_display" />
        <input type="hidden" name="serendipity[adminAction]" value="downloadmanager" />
        <input type="hidden" name="serendipity[catid]" value="{$dlmgbl.thiscat}" />
        <input type="hidden" name="serendipity[uploaded]" value="1" />
        <input type="hidden" name="MAX_FILE_SIZE" value="{$dlmulf.MAX_FILE_SIZE}" />
    </div>
    <div id="uploads">
        <h4>{$CONST.PLUGIN_DOWNLOADMANAGER_UPLOAD_FILE}</h4>
        {section name=formloop start=1 loop=6 step=1}
        <div class="upload {cycle name="cycle1" values="odd,even"}">
            <div class="form_field upload_file">
                <label for="upload_file_{$smarty.section.formloop.index}">{$smarty.section.formloop.index}. {$CONST.PLUGIN_DOWNLOADMANAGER_FILE} (max. {$dlmulf.MAX_SIZE_PER_FILE})</label>
                <input id="upload_file_{$smarty.section.formloop.index}" class="check_input input_button" multiple="" type="file" name="file[]" />
            </div>
            <div class="upload_description">
                <label for="upload_desc_{$smarty.section.formloop.index}">{$CONST.PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC}</label>
                <textarea id="upload_desc_{$smarty.section.formloop.index}" onblur="if(this.value=='')this.value='<!--// {$CONST.PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC} /\/\-->';" onfocus="if(this.value=='<!--// {$CONST.PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC} /\/\-->')this.value='';" cols="30" rows="3" name="serendipity[desc][]"></textarea>
            </div>
        </div>
        {/section}
        <input id="upload_submit" class="serendipityPrettyButton input_button dlm_input_button" type="submit" name="serendipity[dlmanAction]" value="{$CONST.GO}" />
    </div>
    </form>
{else}
    <p class="serendipityAdminMsgError">{$CONST.PLUGIN_DOWNLOADMANAGER_UPLOAD_NOT_ALLOWED}</p>
{/if}
</div><!-- div upload form end -->
