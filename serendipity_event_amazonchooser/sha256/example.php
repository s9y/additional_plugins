<?php
	/* Nanolink SHA256 Class Example */

	// Include class, you may need to update the path to the class file
    require_once('sha256.inc.php');

    // Source string
    $input_str = $_GET['str'];

    // Verifying Source string
    if ($input_str == "")
    {
        echo "Error.";
        return;
    }

    // Timer function compatible with PHP4
    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());

        return (float)$usec + (float)$sec;
    }

	// Record time before hashing
    $time1 = microtime_float();

	// Perform hash
    echo sha256($input_str);

    // Record time after hashing
    $time2 = microtime_float();

	// Display difference
    echo "<br />\nRuntime: " . ($time2 - $time1) . " seconds.";

    return;
?>