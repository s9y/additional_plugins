<br />

<script type="text/javascript">
    var img_plus  = '{serendipity_getFile file="img/plus.png"}';
    var img_minus = '{serendipity_getFile file="img/minus.png"}';
    var state     = '';
{literal}
    function showConfig(id) {
        if (document.getElementById) {
            el = document.getElementById(id);
            if (el.style.display == 'none') {
                document.getElementById('option' + id).src = img_minus;
                el.style.display = '';
            } else {
                document.getElementById('option' + id).src = img_plus;
                el.style.display = 'none';
            }
        }
    }

    function showConfigAll(count) {
        if (document.getElementById) {
            for (i = 1; i <= count; i++) {
                document.getElementById('el' + i).style.display = state;
                document.getElementById('optionel' + i).src = (state == '' ? img_minus : img_plus);
            }

            if (state == '') {
                document.getElementById('optionall').src = img_minus;
                state = 'none';
            } else {
                document.getElementById('optionall').src = img_plus;
                state = '';
            }
        }
    }
{/literal}
</script>

<div id="backend_sp_simple" class="default_staticpage">

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

            {if $showmeta}
            <div class="sp_sect">
                {$CONST.STATICPAGES_CUSTOM_META_SHOW}
                <p id="sp_toggle_optionall"><a style="border:0; text-decoration: none;" href="#" onClick="showConfig('el1'); return false" title="{$CONST.TOGGLE_OPTION}"><img src="{serendipity_getFile file="img/plus.png"}" id="optionel1" alt="+/-" border="0">&nbsp;{$CONST.TOGGLE_ALL}</a></p>
            </div>

            <div id="el1">
              <div class="sp_sect">
                <label class="sp_label" title="Custom Title Element">{$CONST.STATICPAGES_CUSTOM_META_TITLE}</label>
                    <input class="input_textbox" type="text" name="serendipity[plugin][custom][title_element]" value="{$form_values.custom.title_element|@default:''}">
              </div>

              <div class="sp_sect">
                <label class="sp_label" title="Custom META Description">{$CONST.STATICPAGES_CUSTOM_META_DESC}</label>
                    <input class="input_textbox" type="text" name="serendipity[plugin][custom][meta_description]" value="{$form_values.custom.meta_description|@default:''}">
              </div>

              <div class="sp_sect">
                <label class="sp_label" title="Custom META Keywords">{$CONST.STATICPAGES_CUSTOM_META_KEYS}</label>
                    <input class="input_textbox" type="text" name="serendipity[plugin][custom][meta_keywords]" value="{$form_values.custom.meta_keywords|@default:''}">
              </div>
              <div id="helper_note"><span title="{literal}
Replace this part in the head of you templates index.tpl file:&#013;&#013;
<title>{$head_title|@default:$blogTitle}{if $head_subtitle} - {$head_subtitle}{/if}</title>&#013;
&#013;with&#013;&#013;
{if $staticpage_custom.title_element}&#013;
&#009;<title>{$staticpage_custom.title_element|escape:htmlall}</title>&#013;
{else}&#013;
&#009;<title>{$head_title|@default:$blogTitle}{if $head_subtitle} - {$head_subtitle}{/if}</title>&#013;
{/if}&#013;
{if $startpage}&#013;
&#009;<meta name='description' content='{* YOUR DESCRIPTION FOR THE STARTPAGE *}'>&#013;
&#009;<meta name='keywords' content='{* YOUR KEYWORDS FOR THE STARTPAGE *}'>&#013;
&#009;<meta name='author' content='{* YOUR AUTHOR DESC FOR THE STARTPAGE *}'>&#013;
{/if}&#013;
{if $staticpage_custom.meta_description}&#013;
&#009;<meta name='description' content='{$staticpage_custom.meta_description|escape:htmlall}'>&#013;
{/if}&#013;
{if $staticpage_custom.meta_keywords}&#013;
&#009;<meta name='keywords' content='{$staticpage_custom.meta_keywords|escape:htmlall}'>&#013;
{/if}&#013;{/literal}">{$CONST.STATICPAGE_SHOWMETA_DEFAULT_METANOTE},<br>or view <a href="http://board.s9y.org/viewtopic.php?f=4&p=10432412#p10432412" target="_blank" style="background-color: lightblue;">this forum post</a>.</span>
              </div>
            </div>
            <script type="text/javascript" language="JavaScript">document.getElementById("el1").style.display = "none";</script>
            {/if}
        </fieldset>

        <fieldset class="sect_struct">
            <legend>{$CONST.STATICPAGE_SECTION_STRUCT}</legend>
            <div class="sp_sect">
                {$CONST.STATICPAGES_CUSTOM_STRUCTURE_SHOW}
                <p id="sp_toggle_optionall"><a style="border:0; text-decoration: none;" href="#" onClick="showConfig('el2'); return false" title="{$CONST.TOGGLE_OPTION}"><img src="{serendipity_getFile file="img/plus.png"}" id="optionel2" alt="+/-" border="0">&nbsp;{$CONST.TOGGLE_ALL}</a></p>
            </div>

            <div id="el2">
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
                    <label class="sp_label" title="{staticpage_input item="show_breadcrumb" what="desc"|escape:js}">{staticpage_input item="show_breadcrumb" what="name"|escape:js}</label><br />
                        {staticpage_input item="show_breadcrumb"}
                </div>

                <div class="sp_sect">
                    <label class="sp_label" title="{staticpage_input item="pre_content" what="desc"|escape:js}">{staticpage_input item="pre_content" what="name"|escape:js}</label><br />
                        {staticpage_input item="pre_content"}
                </div>

            </div>
            <script type="text/javascript" language="JavaScript">document.getElementById("el2").style.display = "none";</script>
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

           <div class="sp_sect">
                <label class="sp_label" title="{staticpage_input item="timestamp" what="desc"|escape:js}">{staticpage_input item="timestamp" what="name"|escape:js}</label><br />
                    {staticpage_input item="timestamp"}
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

