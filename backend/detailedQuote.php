<?php
$quoted = FALSE;

if(isset($_GET['symbol'])){
  // get argument from get request
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
}

// extract user data from database
$do = new DatabaseObject($_SESSION['sess_id']);
$user_data = $do->getUserData();
$user_stk_data = $do->getStockData($symbol);
$shares = 0;
if ($user_stk_data['numRows'] == 1) {
  $shares = $user_stk_data['result'][0]['shares'];
}
echo $twig->render('detailedQuote.twig',['title' => 'Detailed Quote',
                            'session' => 'start',
                            'username' => $user_data['username'], 'b' => $b, 't' => $t,
                            'cash' => $user_data['cash'],
                            'shares' => $shares,
                            'symbol' => $symbol,
                            'alerts' => $alerts,
                            'quoted' => $quoted]);
$alerts = array();
$routing=FALSE;
 ?>
