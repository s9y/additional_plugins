<?php

include_once ('curl.inc');

function xml2array($text) {
		  //very simple XML to array parser.
		  
		  $reg_exp = '/<(\w+)[^>]*>(.*?)<\/\\1>/s';
		  preg_match_all($reg_exp, $text, $match);
		  foreach ($match[1] as $key=>$val) {
					 if ( preg_match($reg_exp, $match[2][$key]) ) {
								$array[$val][] = xml2array($match[2][$key]);
					 } else {
								$array[$val] = $match[2][$key];
					 }
		  }
		  return $array;
}


function find_best_image ($search,$section="Books",$locale='US'){
		  
		  //this is a curl wrapper class that I wrote a while back and is quite usefull for these
		  //kinds of applications.
		  
		  $curl = new curl_inc_1_0;
		  
		  switch ($locale) {

			case 'DE': $url = "http://webservices.amazon.de/onca/xml";break;
			case 'CA': $url = "http://webservices.amazon.ca/onca/xml";break;
			case 'FR': $url = "http://webservices.amazon.fr/onca/xml";break;
			case 'JP': $url = "http://webservices.amazon.co.jp/onca/xml";break;
			case 'UK': $url = "http://webservices.amazon.co.uk/onca/xml";break;
			case 'US':
			default: $url = "http://webservices.amazon.com/onca/xml";break;

		  }//switch;
		  
		  // You need to leave the following alone for the most part. You <i>CAN</i> change the SubscriptionID
		  // But i'd appreciate it if you just left it set to mine. :)
		  
		  $form_data = array ("Service"=>"AWSECommerceService",
		  							 "SubscriptionId"=>"05T5C0DJ53HFGKJCK4G2",
									 "AssociateTag"=>"dh0net-20",
									 "Operation"=>"ItemSearch",
									 "Keywords"=>$search,
									 "SearchIndex"=>$section,
									 "ResponseGroup"=>"Medium" );
									 
		  $response_array = $curl->curl_fetch_array($url,$form_data);
	
	//	 print ("<!-- Hitting amazon for $search >> $section in the $locale");
	//		print_r($response_array);
	  $results = xml2array($response_array[body]);
	//		print_r($results);
			//yikes, hard coded values are bad and all, but its easy enough to change if it stops working
			//the [Item][0] index's just mean the first record returned (since a query always returns 10 records (0-9)
		  
	//	 	print ("-->");
		  if (is_array($results['ItemSearchResponse'][0]['Items'][0]['Item'][0] ) ) {
				return (array("Image"=>$results['ItemSearchResponse'][0]['Items'][0]['Item'][0]['ImageSets'][0]['ImageSet'][0]['SmallImage'][0][URL],
								  "Height"=>$results['ItemSearchResponse'][0]['Items'][0]['Item'][0]['ImageSets'][0]['ImageSet'][0]['SmallImage'][0][Height],
								  "Width"=>$results['ItemSearchResponse'][0]['Items'][0]['Item'][0]['ImageSets'][0]['ImageSet'][0]['SmallImage'][0][Width],
								  "Detail"=>$results['ItemSearchResponse'][0]['Items'][0]['Item'][0]['DetailPageURL']));
		  }else return(false);

}//find_image


?>
