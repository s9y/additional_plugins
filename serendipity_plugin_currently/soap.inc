<?php

function find_best_image ($search,$section="All",$locale='US', $associates_id, $id, $key) {
	
	$associates_id = empty($associates_id)?'dh0net-20':$associates_id;
	$id            = empty($id)?'1FVN639T3TXS5YERF5R2':$id;
	$key           = empty($key)?'jZ4WsNOHEiRaI7/McxBfkShBM9hI1r+d6TD1+3qd':$key;

	//---------------------------------------------------

	$wsdl = "http://ecs.amazonaws.com/AWSECommerceService/2009-10-01/$locale/AWSECommerceService.wsdl";

	//Generate DigSig for AWS
	$timeStamp = gmdate("Y-m-d\TH:i:s\Z");
	$string = 'ItemSearch'.$timeStamp;
	$signature = base64_encode(hash_hmac("sha256", $string, $key, True));
	

	$client = new SoapClient($wsdl);

	$params = array (
			"Service"=>"AWSECommerceService",
			"AssociateTag"=>$associates_id, 
			"AWSAccessKeyId"=>$id,
			"Timestamp"=>$timeStamp,
			"Signature"=>$signature,
			"Operation"=>"ItemSearch",
			"Keywords"=>$search,
			"SearchIndex"=>$section,
			"ResponseGroup"=>"Medium",
			);

	//print ("<pre>");print_r($params);print("</pre>");

	$itemSearch = new SoapVar($params, SOAP_ENC_OBJECT,'ItemSearch',$wsdl);
	$response = $client->ItemSearch($itemSearch);
	//print ("<pre>");print_r($response);print("</pre>");
	if (is_array($response->Items->Item) ) {
		$item = $response->Items->Item[0];
		$toReturn =	array(
				"Image"=>$item->SmallImage->URL,
				"Height"=>$item->SmallImage->Height,
				"Width"=>$item->SmallImage->Width,
				"Detail"=>$item->DetailPageURL,
				"Title"=>$item->ItemAttributes->Title,
				"Rating"=>$item->CustomerReviews->AverageRating,
				"Reviews"=>$item->CustomerReviews->TotalReviews,
				"Price"=>$item->OfferSummary->LowestNewPrice->FormattedPrice
				);
	}elseif (is_object($response->Items->Item) ) {
		$item=$response->Items->Item;
		$toReturn =	array(
				"Image"=>$item->SmallImage->URL,
				"Height"=>$item->SmallImage->Height,
				"Width"=>$item->SmallImage->Width,
				"Detail"=>$item->DetailPageURL,
				"Title"=>$item->ItemAttributes->Title,
				"Rating"=>$item->CustomerReviews->AverageRating,
				"Reviews"=>$item->CustomerReviews->TotalReviews,
				"Price"=>$item->OfferSummary->LowestNewPrice->FormattedPrice
				);
	}else {
		$toReturn = false;
	}
	
	//print ("<pre>");print_r($toReturn);print("</pre>");
	return ($toReturn);
}



?>
