<script type="text/javascript" src="plugins/serendipity_event_microformats/tabber-minimized.js"></script>
<script type="text/javascript">
var tabberOptions =
{
    'onClick':function(argsObj){
        var t = argsObj.tabber; /* Tabber object */
        var id = t.id; /* ID of the main tabber DIV */
        var i = argsObj.index; /* Which tab was clicked (0 is the first tab) */
        var e = argsObj.event; /* Event object */

        if (id == 'tab1') {
          document.forms[0].elements["serendipity[properties][mf_type][]"].value = t.tabs[i].headingText;
        }
    }
};

function check_mf() {
    var counter = 0;
    var mfs = new Array('hReview_use', 'hCalendar_use');
    for (var i = 0; i <= 1; i++)
        if (document.getElementById(mfs[i]).checked == true) counter++;
    if (counter > 0) document.getElementById('mf_tab').style.display = 'block';
    else document.getElementById('mf_tab').style.display = 'none';
}
</script>

<fieldset>
<a name="microformatsAnchor"></a>
        <legend><?php echo PLUGIN_EVENT_MICROFORMATS_TITLE; ?></legend>
Select one or more (unchecking deletes mf after submit!)
<label for="hReview_use">hReview</label><input id="hReview_use" type="checkbox" name="serendipity[properties][mf_type][]" value="hReview" onchange="check_mf();"<?php echo ($mf_exist['hReview'] == true)?' checked="checked"':' ';?>/>
<label for="hCalendar_use">hCalendar</label><input id="hCalendar_use" type="checkbox" name="serendipity[properties][mf_type][]" value="hCalendar" onchange="check_mf();"<?php echo ($mf_exist['hCalendar'])?' checked="checked"':' ';?>/>


<div class="tabber" id="mf_tab" style="display:<?php echo (count($mf_exist)>0)?'block':'none';?>">
<!--<input type="hidden" name="serendipity[properties][mf_type]" id="mf_type" value="hReview" />-->

<div class="tabbertab" title="hReview">
    <fieldset>
        <div class="field">
			<label for="hReview_name">Name of reviewed item*</label>
			<input type="text" id="hReview_name" name="serendipity[properties][hReview_name]" value="<?php echo $eventData['properties']['mf_hReview_name']?>" />
            <br/>
			<label for="hReview_type">Type of reviewed item</label>
			<select id="hReview_type" name="serendipity[properties][hReview_type]">
				<optgroup label="Select review type">
<?php
		    foreach ($itemtypes['hReview'] as $itemtype) {
			    $selected = ($itemtype == $eventData['properties']['mf_hReview_type']) ? ' selected="selected"' : '';
			    echo '<option'.$selected.'>'.$itemtype.'</option>';
		    }
?>
            </optgroup>
            </select>
            <br/>
<!--
		<div class="field vcardextended">
			<label for="street" >street</label>
			<input type="text" id="street" />
		</div>

		<div class="field vcardextended">
			<label for="city">city</label>
			<input type="text" id="city" />
			<label for="state">state</label>
			<input type="text" id="state" />
			<label for="zip">zip</label>
			<input type="text" id="zip" />
		</div>

		<div class="field vcardextended">
			<label for="phone">phone</label>
			<input type="text" id="phone" />
		</div>
-->
			<label for="hReview_url">URL of review item</label>
			<input type="text" id="hReview_url" name="serendipity[properties][hReview_url]" value="<?php echo $eventData['properties']['mf_hReview_url']?>" />
            <br/>
			<label for="hReview_image">URL of item image</label>
			<input type="text" id="hReview_image" name="serendipity[properties][hReview_image]" value="<?php echo $eventData['properties']['mf_hReview_image']?>" />
            <br/>
		</div>

    	<div class="field">
		<label for="hReview_rating">rating</label>
		<select id="hReview_rating" name="serendipity[properties][hReview_rating]">
			<option></option>
<?php
		foreach ($ratings['hReview'] as $rating) {
			$selected = ($rating == $eventData['properties']['mf_hReview_rating']) ? ' selected="selected"' : '';
			echo '<option'.$selected.'>'.$rating.'</option>';
		}
?>
		</select>
        <br/>
		<label for="hReview_summary" id="summaryLabel">summary</label>
		<input type="text" id="hReview_summary" name="serendipity[properties][hReview_summary]" value="<?php echo $eventData['properties']['mf_hReview_summary']?>" />
        <br/>
	</div>

	<div class="field">
		<label for="hReview_desc">Review:</label>
		<textarea id="hReview_desc" name="serendipity[properties][hReview_desc]" rows="15"><?php echo $eventData['properties']['mf_hReview_desc']?></textarea>
	</div>

	<div class="field">
        <br/>
		<label for="hReview_date" title="review date is required">review date*</label>
		<input type="text" id="hReview_date" name="serendipity[properties][hReview_date]" value="<?php echo date(DATE_FORMAT_2, serendipity_serverOffsetHour((isset($eventData['properties']['mf_hReview_date']) && $eventData['properties']['mf_hReview_date'] > 0) ? strtotime($eventData['properties']['mf_hReview_date']) : time()))?>" style="width:auto;" />
        <a href="#" onclick="document.getElementById('hReview_date').value = '<?php echo date(DATE_FORMAT_2, serendipity_serverOffsetHour(time()))?>'; return false;" title="<?php echo RESET_DATE_DESC?>"><img src="<?php echo serendipity_getTemplateFile('admin/img/clock.png')?>" style="border:none;vertical-align:text-top" alt="<?php echo RESET_DATE ?>" /></a>
	</div>
        <br/><input type="hidden" id="hReview_timezone" name="serendipity[properties][hReview_timezone]" value="<?php echo $this->get_config('timezone')?>" />
	<div class="field">
		<label for="hReview_reviewer" title="reviewer is required, though 'anonymous' is allowed">reviewer*</label>
		<input type="text" id="hReview_reviewer" name="serendipity[properties][hReview_reviewer]" value="<?php echo $eventData['properties']['mf_hReview_reviewer']?>" />
        <br/>
	</div>
	 *- denotes required fields.
</fieldset>
</div>

<div class="tabbertab" title="hCalendar">
<fieldset>
        <div class="field">
            <label for="hCalendar_summary">Summary/Title</label>
            <input type="text" id="hCalendar_summary" name="serendipity[properties][hCalendar_summary]" value="<?php echo $eventData['properties']['mf_hCalendar_summary']?>" />
            <br/>
            <label for="hCalendar_location">Location</label>
            <input type="text" id="hCalendar_location" name="serendipity[properties][hCalendar_location]" value="<?php echo $eventData['properties']['mf_hCalendar_location']?>" />
            <br/>
            <label for="hCalendar_url">URL</label>
            <input type="text" id="hCalendar_url" name="serendipity[properties][hCalendar_url]" value="<?php echo $eventData['properties']['mf_hCalendar_url']?>" />
            <br/>
        </div>

     <div class="field">
        <label for="hCalendar_startdate">Start date</label>
        <input type="text" id="hCalendar_startdate" name="serendipity[properties][hCalendar_startdate]" value="<?php echo date(DATE_FORMAT_2, serendipity_serverOffsetHour((isset($eventData['properties']['mf_hCalendar_startdate']) && $eventData['properties']['mf_hCalendar_startdate'] > 0) ? $eventData['properties']['mf_hCalendar_startdate'] : time()))?>" style="width:auto;" />
        <a href="#" onclick="document.getElementById('hCalendar_startdate').value = '<?php echo date(DATE_FORMAT_2, serendipity_serverOffsetHour(time()))?>'; return false;" title="<?php echo RESET_DATE_DESC?>" style="display:inline;"><img src="<?php echo serendipity_getTemplateFile('admin/img/clock.png')?>" style="border:none;vertical-align:text-top" alt="<?php echo RESET_DATE ?>" /></a>
        <br style="clear:both"/>
        <label for="hCalendar_enddate">End date</label>
        <input type="text" id="hCalendar_enddate" name="serendipity[properties][hCalendar_enddate]" value="<?php echo date(DATE_FORMAT_2, serendipity_serverOffsetHour((isset($eventData['properties']['mf_hCalendar_enddate']) && $eventData['properties']['mf_hCalendar_enddate'] > 0) ? $eventData['properties']['mf_hCalendar_enddate'] : time()))?>" style="width:auto;" />
        <a href="#" onclick="document.getElementById('hCalendar_enddate').value = '<?php echo date(DATE_FORMAT_2, serendipity_serverOffsetHour(time()))?>'; return false;" title="<?php echo RESET_DATE_DESC?>" style="display:inline;"><img src="<?php echo serendipity_getTemplateFile('admin/img/clock.png')?>" style="border:none;vertical-align:text-top" alt="<?php echo RESET_DATE ?>" /></a>
        <br style="clear:left"/>
        <br/>
    </div>
    <br/><input type="hidden" id="hCalendar_timezone" name="serendipity[properties][hCalendar_timezone]" value="<?php echo $this->get_config('timezone')?>" />
    <div class="field">
        <label for="hCalendar_desc">Description:</label>
        <textarea id="hCalendar_desc" name="serendipity[properties][hCalendar_desc]" rows="15"><?php echo $eventData['properties']['mf_hCalendar_desc']?></textarea>
    </div>
</div>
</div>
</fieldset>
