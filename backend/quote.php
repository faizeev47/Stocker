<?php
// extract data from database
$do = new DatabaseObject($_SESSION['sess_id']);
$user_data = $do->getUserData();

// variable to let twig template know upon succesful quote
$quoted = FALSE;
// user requested page to submit a get request
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
  echo $twig->render('quote.twig',['title' => 'Quote',
                              'session' => 'start',
                              'username' => $user_data['username'],
                              'cash' => $user_data['cash']]);
}
// user submitted quote request via post
else if($_SERVER['REQUEST_METHOD'] == 'POST') {
  // extract arguments from post request
  $symbol = $_GET['symbol'];

  // connect to API to get stock information
  $url = sprintf($api_url, $symbol);
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_HTTPGET,TRUE);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_SSL_ENABLE_ALPN,FALSE);
  curl_setopt($ch,CURLOPT_SSL_ENABLE_NPN,FALSE);
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
  curl_setopt($ch,CURLOPT_SSL_VERIFYSTATUS,FALSE);

  $json = curl_exec($ch);
  curl_close($ch);
  // incomplete request transfer between API
  if (!$json) {
    array_push($alerts, array("message" => "Could not connect to IEX to get live stock information! Try again later.", "type" => "danger"));
  }
  else {
    $quote = json_decode($json);
    // stock does not exist
    if (!$quote){
      array_push($alerts, array("message" => "Stock does not exist!", "type" => "warning"));
    }
    else {
      // indicate successfull quote
      $quoted = TRUE;
    }
  }

  // render quoteD templated
  echo $twig->render('quote.twig',['title' => 'Quote',
                              'session' => 'start',
                              'username' => $user_data['username'],
                              'cash' => $user_data['cash'],
                              'quoted' => $quoted,
                              'symbol' => $quote->symbol,
                              'company' => $quote->companyName,
                              'price' => $quote->latestPrice,
                              'alerts' => $alerts]);

}
$alerts = array();
$routing = FALSE;
 ?>
