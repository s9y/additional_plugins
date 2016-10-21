<div id="sp_simple" class="staticpage_simple">
    <section class="staticpage_basic">
        <h4>{$CONST.STATICPAGE_SECTION_BASIC}</h4>

        <div class="form_field">
            <label title="{staticpage_input item="headline" what="desc"|escape:js}">{staticpage_input item="headline" what="name"|escape:js}</label>
            {staticpage_input item="headline"}
        </div>

        <div class="form_field">
            <label title="{staticpage_input item="articleformattitle" what="desc"|escape:js}">{staticpage_input item="articleformattitle" what="name"|escape:js}</label>
            {staticpage_input item="articleformattitle"}
        </div>

        <div class="form_field">
            <label title="{staticpage_input item="content" what="desc"|escape:js}">{staticpage_input item="content" what="name"|escape:js}</label>
            {staticpage_input item="content"}
        </div>

        <div class="form_field">
            <label title="{staticpage_input item="pre_content" what="desc"|escape:js}">{staticpage_input item="pre_content" what="name"|escape:js}</label>
            {staticpage_input item="pre_content"}
        </div>
    </section>

    <div class="form_buttons staticpage_save">
        <input type="submit" name="serendipity[SAVECONF]" value="{$CONST.SAVE}">
    </div>

    <div class="staticpage_container">
        <section class="staticpage_section staticpage_structure">
            <div class="equal_heights">
                <h4>{$CONST.STATICPAGE_SECTION_STRUCT}</h4>

                <div class="form_field">
                    <label title="{staticpage_input item="pagetitle" what="desc"|escape:js}">{staticpage_input item="pagetitle" what="name"|escape:js}</label>
                    {staticpage_input item="pagetitle"}
                </div>

                <div class="form_field">
                    <label title="{staticpage_input item="permalink" what="desc"|escape:js}">{staticpage_input item="permalink" what="name"|escape:js}</label>
                    {staticpage_input item="permalink"}
                </div>

                <div class="form_select">
                    <label title="{staticpage_input item="publishstatus" what="desc"|escape:js}">{staticpage_input item="publishstatus" what="name"|escape:js}</label>
                    {staticpage_input item="publishstatus"}
                </div>

                <div class="form_select">
                    <label title="{staticpage_input item="articletype" what="desc"|escape:js}">{staticpage_input item="articletype" what="name"|escape:js}</label>
                    {staticpage_input item="articletype"}
                </div>

                <div class="form_select">
                    <label title="{staticpage_input item="language" what="desc"|escape:js}">{staticpage_input item="language" what="name"|escape:js}</label>
                    {staticpage_input item="language"}
                </div>

                <div class="form_select">
                    <label title="{staticpage_input item="related_category_id" what="desc"|escape:js}">{staticpage_input item="related_category_id" what="name"|escape:js}</label>
                    {staticpage_input item="related_category_id"}
                </div>
            </div>
        </section>

        <section class="staticpage_section staticpage_access">
            <div class="equal_heights">
                <h4>{$CONST.STATICPAGE_SECTION_ACCESS}</h4>

                <div class="form_field">
                    <label title="{staticpage_input item="pass" what="desc"|escape:js}">{staticpage_input item="pass" what="name"|escape:js}</label>
                    {staticpage_input item="pass"}
                </div>

                <div class="form_select">
                    <label title="{staticpage_input item="parent_id" what="desc"|escape:js}">{staticpage_input item="parent_id" what="name"|escape:js}</label>
                    {staticpage_input item="parent_id"}
                </div>

                <fieldset class="clearfix">
                    <span class="wrap_legend"><legend title="{staticpage_input item="show_childpages" what="desc"|escape:js}">{staticpage_input item="show_childpages" what="name"|escape:js}</legend></span>
                    {staticpage_input item="show_childpages"}
                </fieldset>

                <fieldset class="clearfix">
                    <span class="wrap_legend"><legend title="{staticpage_input item="shownavi" what="desc"|escape:js}">{staticpage_input item="shownavi" what="name"|escape:js}</legend></span>
                    {staticpage_input item="shownavi"}
                </fieldset>

                <fieldset class="clearfix">
                    <span class="wrap_legend"><legend title="{staticpage_input item="showonnavi" what="desc"|escape:js}">{staticpage_input item="showonnavi" what="name"|escape:js}</legend></span>
                    {staticpage_input item="showonnavi"}
                </fieldset>

                <fieldset class="clearfix">
                    <span class="wrap_legend"><legend title="{staticpage_input item="show_breadcrumb" what="desc"|escape:js}">{staticpage_input item="show_breadcrumb" what="name"|escape:js}</legend></span>
                    {staticpage_input item="show_breadcrumb"}
                </fieldset>
            </div>
        </section>

        <section class="staticpage_section staticpage_meta">
            <div class="equal_heights">
                <h4>{$CONST.STATICPAGE_SECTION_META}</h4>

                <div class="form_field">
                    <label title="{staticpage_input item="timestamp" what="desc"|escape:js}">{staticpage_input item="timestamp" what="name"|escape:js}</label>
                    {staticpage_input item="timestamp"}
                </div>

                <div class="form_select">
                    <label title="{staticpage_input item="authorid" what="desc"|escape:js}">{staticpage_input item="authorid" what="name"|escape:js}</label>
                    {staticpage_input item="authorid"}
                </div>

                <div class="form_field">
                    <label title="{staticpage_input item="title_element" what="desc"|escape:js}">{staticpage_input item="title_element" what="name"|escape:js}</label>
                    {staticpage_input item="title_element"}
                </div>

                <div class="form_field">
                    <label title="{staticpage_input item="meta_description" what="desc"|escape:js}">{staticpage_input item="meta_description" what="name"|escape:js}</label>
                    {staticpage_input item="meta_description"}
                </div>

                <div class="form_field">
                    <label title="{staticpage_input item="meta_keywords" what="desc"|escape:js}">{staticpage_input item="meta_keywords" what="name"|escape:js}</label>
                    {staticpage_input item="meta_keywords"}
                </div>
            </div>
        </section>

        <section class="staticpage_section staticpage_options">
            <div class="equal_heights">
                <h4>{$CONST.STATICPAGE_SECTION_OPT}</h4>

                <fieldset class="clearfix">
                    <span class="wrap_legend"><legend title="{staticpage_input item="is_startpage" what="desc"|escape:js}">{staticpage_input item="is_startpage" what="name"|escape:js}</legend></span>
                    {staticpage_input item="is_startpage"}
                </fieldset>

                <fieldset class="clearfix">
                    <span class="wrap_legend"><legend title="{staticpage_input item="is_404_page" what="desc"|escape:js}">{staticpage_input item="is_404_page" what="name"|escape:js}</legend></span>
                    {staticpage_input item="is_404_page"}
                </fieldset>

                <fieldset class="clearfix">
                    <span class="wrap_legend"><legend title="{staticpage_input item="markup" what="desc"|escape:js}">{staticpage_input item="markup" what="name"|escape:js}</legend></span>
                    {staticpage_input item="markup"}
                </fieldset>

                <fieldset class="clearfix">
                    <span class="wrap_legend"><legend title="{staticpage_input item="articleformat" what="desc"|escape:js}">{staticpage_input item="articleformat" what="name"|escape:js}</legend></span>
                    {staticpage_input item="articleformat"}
                </fieldset>
            </div>
        </section>
    </div>

{* EXAMPLE FOR CUSTOM STATICPAGE PROPERTIES

<section class="staticpage_section staticpage_custom">
    <div class="equal_heights">
        <h4>Custom</h4>

        <div class="form_select">
            <label title="Choose the main sidebar that should be shown when this staticpage is evaluated">Sidebars</label>
            <select name="serendipity[plugin][custom][sidebars][]" multiple="multiple">
                <option {if (@in_array('left', $form_values.custom.sidebars))}selected="selected"{/if} value="left">Left</option>
                <option {if (@in_array('right', $form_values.custom.sidebars))}selected="selected"{/if} value="right">Right</option>
                <option {if (@in_array('hidden', $form_values.custom.sidebars))}selected="selected"{/if} value="hidden">Hidden</option>
            </select>
        </div>

        <div class="form_field">
            <label title="CSS class of the main page body that should be associated">Main CSS class</label>
            <input type="text" name="serendipity[plugin][custom][css_class]" value="{$form_values.custom.css_class|@default:'None'}">
        </div>
    </div>
</section>
 END OF EXAMPLE FOR CUSTOM STATICPAGE PROPERTIES *}
</div>

{staticpage_input_finish}

<div class="form_buttons staticpage_save">
    <input type="submit" name="serendipity[SAVECONF]" value="{$CONST.SAVE}">
</div>