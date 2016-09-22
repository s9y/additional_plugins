<?php
/* 
   This file is free for anyone to use or modify as they wish. 
   Author: Simon Willison, July 2002
   See http://scripts.incutio.com/
*/

// Currently only handles 'lite' queries on 'books'
class AmazonSearchEngine {
    var $server = 'xml.amazon.com';
    var $search;
    var $dev_token;
    var $associates_id;
    var $type = 'lite';
    var $results;  // Array of results
    var $_parser;   // The XML parser
    var $_currentResult;
    var $_grabtags; // Tags to grab the contents of
    var $_currentTagContents;
    function AmazonSearchEngine($dev_token, $associates_id = 'none') {
        $this->dev_token = $dev_token;
        $this->associates_id = $associates_id;
        $this->_parser = xml_parser_create();
        $this->results = array();
        xml_parser_set_option($this->_parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_object($this->_parser, $this);
        xml_set_element_handler($this->_parser, 'tag_open', 'tag_close');
        xml_set_character_data_handler($this->_parser, 'cdata');
        $this->_grabtags = array(
            'Asin', 'ProductName', 'Catalog', 'ErrorMsg',
            'Description', 'ReleaseDate', 'Manufacturer', 'ImageUrlSmall',
            'ImageUrlMedium', 'ImageUrlLarge', 'ListPrice', 'OurPrice',
            'UsedPrice', 'Author', 'Artist'
        );
    }
    function doSearch($url) {
        if (function_exists('serendipity_request_url')) {
            $contents = serendipity_request_url($url);
        } else {
            $req = new HTTP_Request($url);
            $req->sendRequest();
            $contents = $req->getResponseBody();
        }

        if (!xml_parse($this->_parser, $contents)) {
            die(sprintf('XML error: %s at line %d',
                xml_error_string(xml_get_error_code($this->_parser)),
                xml_get_current_line_number($this->_parser)));
        }
        xml_parser_free($this->_parser);
    }
    function searchTerm($term, $mode = 'music') {
        $url = "http://{$this->server}/onca/xml3?t={$this->associates_id}&KeywordSearch=$term&mode=$mode";
        $url .= "&f=xml&type={$this->type}&dev-t={$this->dev_token}";
        $this->doSearch($url);
    }
    function searchISBN($isbn) {
        $url = "http://{$this->server}/onca/xml?v=1.0&t={$this->associates_id}&dev-t={$this->dev_token}&AsinSearch=$isbn&type={$this->type}&f=xml";
        $this->doSearch($url);
    }
    function searchAuthor($author) {
        $url = "http://{$this->server}/onca/xml?v=1.0&t={$this->associates_id}&dev-t={$this->dev_token}&AuthorSearch=$author&mode=books&type={$this->type}&f=xml";
        $this->doSearch($url);
    }
    function searchRelated($asin) {
        $url = "http://{$this->server}/onca/xml?v=1.0&t={$this->associates_id}&dev-t={$this->dev_token}&SimilaritySearch=$asin&type={$this->type}&f=xml";
        $this->doSearch($url);
    }
    function tag_open($parser, $tag, $attributes)
    { 
        if ($tag == 'Details') {
            // We've hit a new result
            $this->_currentResult = new AmazonProduct;
            $this->_currentResult->url = $attributes['url'];
        }
        if (in_array($tag, $this->_grabtags)) {
            $this->_currentTag = $tag;
        } else {
            $this->_currentTag = '';
        }
    }
    function cdata($parser, $cdata)
    {
        if ($this->_currentTag) {
            $this->_currentTagContents = trim($cdata);
        }
    }
    function tag_close($parser, $tag)
    {
        switch ($tag) {
            case 'Details':
                // We've hit the end of the result
                $this->results[] = $this->_currentResult;
                break;
            case 'Author':
                $this->_currentResult->Authors[] = $this->_currentTagContents;
                break;
            case 'Artist':
                $this->_currentResult->Artists[] = $this->_currentTagContents;
                break;
            default:
                if (in_array($tag, $this->_grabtags)) {
                    $this->_currentResult->$tag = $this->_currentTagContents;
                }
        }
    }
}
?>