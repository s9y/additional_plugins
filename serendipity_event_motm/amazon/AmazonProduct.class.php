<?php
/* This class does not handle shopping basket details */
class AmazonProduct {
    var $url;
    var $Asin;
    var $ProductName;
    var $Catalog;
    var $Authors = array();
    var $Artists = array();
    var $ErrorMsg;
    var $Description;
    var $ReleaseDate;
    var $Manufacturer;
    var $ImageUrlSmall;
    var $ImageUrlMedium;
    var $ImageUrlLarge;
    var $ListPrice;
    var $OurPrice;
    var $UsedPrice;
    function AmazonProduct() {
        // Does nothing for the moment
        return;
    }
    function getSaving() {
        // Returns Amazon saving, if any
        $difference = (float)substr($this->ListPrice, 1) - (float)substr($this->OurPrice, 1);
        if ($difference > 0) {
            $save = sprintf('%.2f', $difference);
        } else {
            $save = false;
        }
        return $save;
    }
}
?>