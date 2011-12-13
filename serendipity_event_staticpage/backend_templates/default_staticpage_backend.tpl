<br />
<div class="default_staticpage">

    <div style="width: 69%; float: left">
        <!-- LEFT -->

        <fieldset class="sect_basic">
            <legend>{$CONST.STATICPAGE_SECTION_BASIC}</legend>
            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="headline" what="desc"|escape:js}">{staticpage_input item="headline" what="name"|escape:js}</label><br />
                    {staticpage_input item="headline"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="articleformattitle" what="desc"|escape:js}">{staticpage_input item="articleformattitle" what="name"|escape:js}</label><br />
                    {staticpage_input item="articleformattitle"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="content" what="desc"|escape:js}">{staticpage_input item="content" what="name"|escape:js}</label><br />
                    {staticpage_input item="content"}
            </div>
        </fieldset>

        <fieldset class="sect_struct">
            <legend>{$CONST.STATICPAGE_SECTION_STRUCT}</legend>
            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="authorid" what="desc"|escape:js}">{staticpage_input item="authorid" what="name"|escape:js}</label><br />
                    {staticpage_input item="authorid"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="articletype" what="desc"|escape:js}">{staticpage_input item="articletype" what="name"|escape:js}</label><br />
                    {staticpage_input item="articletype"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="language" what="desc"|escape:js}">{staticpage_input item="language" what="name"|escape:js}</label><br />
                    {staticpage_input item="language"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="related_category_id" what="desc"|escape:js}">{staticpage_input item="related_category_id" what="name"|escape:js}</label><br />
                    {staticpage_input item="related_category_id"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="parent_id" what="desc"|escape:js}">{staticpage_input item="parent_id" what="name"|escape:js}</label><br />
                    {staticpage_input item="parent_id"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="show_childpages" what="desc"|escape:js}">{staticpage_input item="show_childpages" what="name"|escape:js}</label><br />
                    {staticpage_input item="show_childpages"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="shownavi" what="desc"|escape:js}">{staticpage_input item="shownavi" what="name"|escape:js}</label><br />
                    {staticpage_input item="shownavi"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="pre_content" what="desc"|escape:js}">{staticpage_input item="pre_content" what="name"|escape:js}</label><br />
                    {staticpage_input item="pre_content"}
            </div>

        </fieldset>
    </div>

    <div style="width: 29%; float: right">
        <!-- RIGHT -->
        <fieldset class="sect_meta">
            <legend>{$CONST.STATICPAGE_SECTION_META}</legend>
            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="pagetitle" what="desc"|escape:js}">{staticpage_input item="pagetitle" what="name"|escape:js}</label><br />
                    {staticpage_input item="pagetitle"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="permalink" what="desc"|escape:js}">{staticpage_input item="permalink" what="name"|escape:js}</label><br />
                    {staticpage_input item="permalink"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="pass" what="desc"|escape:js}">{staticpage_input item="pass" what="name"|escape:js}</label><br />
                    {staticpage_input item="pass"}
            </div>

        </fieldset>
        
        <fieldset class="sect_opt">
            <legend>{$CONST.STATICPAGE_SECTION_OPT}</legend>
            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="publishstatus" what="desc"|escape:js}">{staticpage_input item="publishstatus" what="name"|escape:js}</label><br />
                    {staticpage_input item="publishstatus"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="is_startpage" what="desc"|escape:js}">{staticpage_input item="is_startpage" what="name"|escape:js}</label><br />
                    {staticpage_input item="is_startpage"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="is_404_page" what="desc"|escape:js}">{staticpage_input item="is_404_page" what="name"|escape:js}</label><br />
                    {staticpage_input item="is_404_page"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="showonnavi" what="desc"|escape:js}">{staticpage_input item="showonnavi" what="name"|escape:js}</label><br />
                    {staticpage_input item="showonnavi"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="markup" what="desc"|escape:js}">{staticpage_input item="markup" what="name"|escape:js}</label><br />
                    {staticpage_input item="markup"}
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="articleformat" what="desc"|escape:js}">{staticpage_input item="articleformat" what="name"|escape:js}</label><br />
                    {staticpage_input item="articleformat"}
            </div>

        </fieldset>

        {* EXAMPLE FOR CUSTOM STATICPAGE PROPERTIES
        
        <fieldset class="sect_custom">
            <legend>Custom</legend>

            <div class="sp_sect">
                <label class="sp_label" title="Choose the main sidebar that should be shown when this staticpage is evaluated">Sidebars</label><br />
                <select name="serendipity[plugin][custom][sidebars][]" multiple="multiple">
                    <option {if (@in_array('left', $form_values.custom.sidebars))}selected="selected"{/if} value="left">Left</option>
                    <option {if (@in_array('right', $form_values.custom.sidebars))}selected="selected"{/if} value="right">Right</option>
                    <option {if (@in_array('hidden', $form_values.custom.sidebars))}selected="selected"{/if} value="hidden">Hidden</option>
                </select>
            </div>

            <div class="sp_sect">
                <label class="sp_label" title="CSS class of the main page body that should be associated">Main CSS class</label><br />
                    <input type="text" name="serendipity[plugin][custom][css_class]" value="{$form_values.custom.css_class|@default:'None'}" />
            </div>
        </fieldset>
         END OF EXAMPLE FOR CUSTOM STATICPAGE PROPERTIES *}

        <div style="margin: 0px auto; text-align: center">
            <input type="submit" name="serendipity[SAVECONF]" value="{$CONST.SAVE}" class="serendipityPrettyButton input_button" />
        </div>

    </div>
</div>


{staticpage_input_finish}

<br style="clear: both" />
<div style="margin: 10px auto; text-align: center">
    <input type="submit" name="serendipity[SAVECONF]" value="{$CONST.SAVE}" class="serendipityPrettyButton input_button" />
</div>

