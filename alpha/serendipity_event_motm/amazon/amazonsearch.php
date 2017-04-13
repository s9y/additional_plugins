<?php
function amazon_search($term,$associate_id,$dev_key)
{
    require_once('AmazonProduct.class.php');
    require_once('AmazonSearchEngine.class.php');
    require_once "HTTP/Request.php";
    
    $term = urlencode($term);
    
    /* Create a new AmazonSearchEngine instance, with your developer key and associates ID */
    $se = new AmazonSearchEngine($dev_key, $associate_id);
    
    if (isset($_GET['do']) && $_GET['do'] == 'related') {
        $se->searchRelated($term);
    } else {
        $se->searchTerm($term);
    }
    /* Call the search method with your search term */
    
    $counter = 0;
    if ($se->results[0])
        return $se->results[0];
    else
        return false;
}
?>