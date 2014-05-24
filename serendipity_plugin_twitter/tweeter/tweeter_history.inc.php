<?php
if (IN_serendipity !== true) {
    die ("Don't hack!");
}
?>

<ul id="serendipity_admin_tweeter_statuses">
<?php echo $buffer; ?>
</ul>
<?php
    if ($GLOBALS['serendipity']['version'][0] == '1') {
        echo '<div class="tweeter_clearfix"></div>';
    }
?>
