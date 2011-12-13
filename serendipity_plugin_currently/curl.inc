<?php

class curl_inc_1_0 {

		  var $conn_timeout = 30;
		  var $conn;


		  //this function is included for backward compatibility.

		  function return_code_string () {

					 return (curl_error($this->conn));

		  }//function return_code_string



		  function curl_fetch_file ($url,$form_data,$username='',$password=''){

					 $this->conn = curl_init();

					 curl_setopt($this->conn,CURLOPT_URL,$url);
					 curl_setopt($this->conn,CURLOPT_HEADER,true);
					 curl_setopt($this->conn,CURLOPT_USERAGENT,"SigmaTrak");
					 curl_setopt($this->conn,CURLOPT_TIMEOUT,$this->conn_timeout);
					 curl_setopt($this->conn,CURLOPT_POST,true);
					 curl_setopt($this->conn,CURLOPT_RETURNTRANSFER, false);
					 curl_setopt($this->conn,CURLOPT_BINARYTRANSFER, true);

					 if (!empty($username) && !empty($password)) curl_setopt($this->conn,CURLOPT_USERPWD,"$username:$password");
					 if (is_array($form_data)) curl_setopt($this->conn,CURLOPT_POSTFIELDS, $form_data);

					 $data_fn = tempnam('/tmp','download.');
					 $parsed_fn = tempnam('/tmp','parsed.');
					 $data_handle = fopen ($data_fn,'w+');

					 curl_setopt($this->conn,CURLOPT_FILE,$data_handle);


					 curl_exec($this->conn);

					 fclose ($data_handle);


					 $headers = $this->remove_headers($data_fn,$parsed_fn);
					// print ($headers);
					 unlink ($data_fn);

					 if ($error=curl_errno($this->conn)) {

								system ("rm -f $parsed_fn");
								return ($error);

					 } else {

								$toReturn = $this->parse_response($headers."\r\n\r\nDATA\r\n");
								$toReturn['body']=$parsed_fn;		
								return ($toReturn);

					 }


		  }//curl_fetch_exec;

		  function curl_fetch_array ($url,$form_data,$username='',$password=''){

					 $this->conn = curl_init();

					 curl_setopt($this->conn,CURLOPT_URL,$url);
					 curl_setopt($this->conn,CURLOPT_HEADER,true);
					 curl_setopt($this->conn,CURLOPT_USERAGENT,"SigmaTrak");
					 curl_setopt($this->conn,CURLOPT_TIMEOUT,$this->conn_timeout);
					 curl_setopt($this->conn,CURLOPT_POST,true);
					 curl_setopt($this->conn,CURLOPT_RETURNTRANSFER, true);
					 curl_setopt($this->conn,CURLOPT_BINARYTRANSFER, true);

					 if (!empty($username) && !empty($password)) curl_setopt($this->conn,CURLOPT_USERPWD,"$username:$password");
					 if (is_array($form_data)) curl_setopt($this->conn,CURLOPT_POSTFIELDS, $form_data);


					 $response = curl_exec($this->conn);


					 if ($error=curl_errno($this->conn)) {
								return ($error);
					 } else {

								return ($this->parse_response($response));

					 }


		  }//curl_fetch_exec;

		  function parse_response($response){
					 /*

					  ***returns an array in the following format which varies depending on headers returned

					  [response] => the HTTP error or response code such as 404
					  [headers] => Array
					  (
					  [Server] => Apache 1.3.31
					  ....
					  )
					  [body] => Response body (string)
					  */



					 list($response_headers,$response_body) = explode("\r\n\r\n",$response,2);
					 $response_header_lines = explode("\r\n",$response_headers);


					 // first line of headers is the HTTP response code
					 $http_response_line = array_shift($response_header_lines);
					 if (preg_match('@^HTTP/[0-9]\.[0-9] ([0-9]{3})@',$http_response_line,
													 $matches)) {
								$response_code = $matches[1];
					 }

					 // put the rest of the headers in an array
					 $response_header_array = array();
					 foreach ($response_header_lines as $header_line) {
								list($header,$value) = explode(': ',$header_line,2);
								$response_header_array[$header] = $value;
					 }

					 if ($response_code == '100') {

								//we have a continue...look deeper
								return ($this->parse_response($response_body));
					 }
					 return array('response'=>$response_code,'headers'=>$response_header_array,'body'=>$response_body);
		  } //parse


		  //remove headers strips the HTML headers up to the '\r\n\r\n' point where data begins, returns the headers in a string and 
		  //writes the rest of the file.

		  function remove_headers ($in_file,$out_file) {

					 $in = fopen ($in_file,'r+');
					 $out = fopen($out_file,'w+');

					 $headers = stream_get_line($in,4096,"\r\n\r\n");

					 fseek ($in,ftell($in)+4);

					 while (!feof($in)){
								fputs ($out,stream_get_line($in,4096,''));
					 }

					 fclose ($in);
					 fclose($out);
					 return($headers);
		  }//remove headers


}//class curl_class

?>
