<?php
if (IN_serendipity !== true) {
    die ("Don't hack!");
}
?>

<?php
    if ($GLOBALS['serendipity']['version'][0] == '1') {
        echo '<h2 class="serendipity_admin_tweeter_header">' . $buffer_header . '</h2>';
    } else {
        echo '<h3 class="serendipity_admin_tweeter_header">' . $buffer_header . '</h3>';
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
