<?php 



		global $gnfinal_token;
		global $tg_base_url;  
		global $tg_client_secret;
		global $tg_client_id;
  		$gnfinal_token = lightspeed_generate_token_while_synching();
  		$tg_base_url = "https://cloud.merchantos.com/oauth/access_token.php";
  		$tg_client_secret = "{add client secret here }";
  		$tg_client_id = "{ add client id here }";

		  /*new token generation function while synching*/
			function lightspeed_generate_token_while_synching(){
			  global $tg_refresh_token;
			  global $tg_client_secret;
			  global $tg_client_id;
			  global $tg_base_url;
			  $generatedToken = '';
			  

			  $httpPostData = array(
			    'refresh_token' => $tg_refresh_token,
			    'client_secret' => "Add here client secret",
			    'client_id' => "Add here client Id",
			    'grant_type' => 'refresh_token'
			  );

			  $httpRequest = curl_init();
			  curl_setopt($httpRequest, CURLOPT_URL, $tg_base_url);
			  curl_setopt($httpRequest, CURLOPT_RETURNTRANSFER, true);
			  curl_setopt($httpRequest,CURLOPT_POSTFIELDS, $httpPostData);
			  $response = curl_exec($httpRequest);
			  if ($response === FALSE){
			      die(curl_error($httpRequest));
			  }
			  curl_close($httpRequest);
			  $tg_arr = json_decode($response);
			  $generatedToken = $tg_arr->access_token;

			  update_option( 'tg_final_token', $generatedToken );
			  $final_token = get_option('tg_final_token');
			  return($final_token);
			}

			$api_product_url = 'https://api.merchantos.com/API/Account/{account id}/Item.json';

			//To fetch product 

		  $httpRequest4 = curl_init();
		  curl_setopt($httpRequest4, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $gnfinal_token, 'Content-Type: application/json'));
		  curl_setopt($httpRequest4, CURLOPT_URL, $api_product_url);
		  curl_setopt($httpRequest4, CURLOPT_RETURNTRANSFER, true);
		  $response4 = curl_exec($httpRequest4);
		  if ($response4 === FALSE){
		      die(curl_error($httpRequest4));
		  }
		  curl_close($httpRequest4);
		  $product_array = json_decode($response4);