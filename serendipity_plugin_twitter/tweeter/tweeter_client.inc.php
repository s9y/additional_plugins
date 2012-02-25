<?php
if (IN_serendipity !== true) {
    die ("Don't hack!");
}
?>
<script type="text/javascript">
var twitter_http_length_str = '<?php echo $http_length_str?>';
var twitter_https_length_str = '<?php echo $https_length_str?>';
</script>

<div id="serendipity_admin_tweeter">
<form action="serendipity_admin.php" method="post">
<?php if ($tweeter_in_sidbar) { ?>
 <input type="hidden" name="serendipity[adminModule]" value="event_display" />
 <input type="hidden" name="serendipity[adminAction]" value="tweeter" />
<?php } ?>
<label for="tweeter_account"><?php echo PLUGIN_EVENT_TWITTER_IDENTITY;?> </label>
    <select id="tweeter_account" name="tweeter_account" onchange="accountChanged()"><?php foreach($identities as $idkey =>$idtext) {?>
        <option value="<?php echo $idkey; ?>" <?php if ($idkey==$val_identitiy) echo 'SELECTED';?>><?php echo $idtext; ?></option>
<?php } ?></select><?php if ($tweeter_has_timeline) { ?><br />
<label for="tweeter_timeline"><?php echo PLUGIN_EVENT_TWITTER_TIMELINE;?> </label>
    <select id="tweeter_timeline" name="tweeter_timeline"><?php foreach($status_timeline as $timeline) {?>
        <option value="<?php echo $timeline; ?>" <?php if ($timeline==$pstatus_timeline) echo 'SELECTED';?>><?php echo $timeline; ?></option>
<?php } ?></select><?php } ?>
<input id="tweeter_change_identity" name="tweeter_change_identity" value="change" type="submit" /><br/>
<?php echo PLUGIN_EVENT_TWITTER_TWEETER_FORM; ?><span id="tweeeter_charcount">140</span> <?php echo PLUGIN_EVENT_TWITTER_TWEETER_CHARSLEFT; ?>
 <textarea id="tweeter_tweet" rows="3" cols="40" id="tweet" name="tweet" onfocus="tweeter_char_count()" onkeydown="tweeter_char_count()" onkeyup="tweeter_char_count()" onkeypress="tweeter_char_count()"><?php if(isset($val_tweet)){ echo $val_tweet; } ?></textarea><br />
 <label for="shorturl"><?php echo PLUGIN_EVENT_TWITTER_TWEETER_SHORTEN; ?>: </label><input type="text" id="shorturl" value="<?php echo empty($val_short) ? 'http://' : $val_short; ?>" name="shorturl"/><br />
 <input id="tweeter_submit" name="tweeter_submit" value="<?php echo PLUGIN_EVENT_TWITTER_TWEETER_SHORTEN; ?> / Update" type="submit" />
</form>
<?php if(isset($notice)) echo $notice; ?>
<script type="text/javascript">
// If we shortened a link, recount chars.
tweeter_char_count();
</script>
</div>
