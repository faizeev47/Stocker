<?php
// get access to user identity in the database
$do = new DatabaseObject($_SESSION['sess_id']);

// extract user relevant information
$user_data = $do->getUserData();
$total_holdings = $user_data['cash'];

$user_stocks = $do->getStocks();

// array to be published on the webpage
$stocks = array();
// indicating whether API connection was complete
$api_error = FALSE;
foreach ($user_stocks['result'] as $row) {
  // curl request to connect to the API
  $url = sprintf($api_url, $row['symbol']);
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_HTTPGET,TRUE);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_SSL_ENABLE_ALPN,FALSE);
  curl_setopt($ch,CURLOPT_SSL_ENABLE_NPN,FALSE);
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
  curl_setopt($ch,CURLOPT_SSL_VERIFYSTATUS,FALSE);
  $json = curl_exec($ch);
  // response not recieved correctly thus API connection error occured
  if(!$json && !$api_error){
    $api_error = TRUE;
    array_push($alerts, array("message" => "Could not connect to IEX to get live stock information! Try again later.", "type" => "danger"));
  }
  curl_close($ch);

  // convert response to JSON
  $quote = json_decode($json);

  // calculate total share holding and equity using live stock price
  $share_holding = (float)$row['shares'] * (float)$quote->latestPrice;
  $total_holdings += $share_holding;
  array_push($stocks, array('symbol' => $row['symbol'],
                            'name' => $quote->companyName,
                            'shares' => $row['shares'],
                            'change' => $quote->change,
                            'changePercent' => $quote->changePercent,
                            'latestPrice' =>  number_format((float)$quote->latestPrice, 2),
                            'close' => $quote->close ? number_format((float)$quote->close, 2) : '-',
                            'total' => number_format((float)$share_holding, 2)));
}
echo $twig->render('home.twig',['title' => 'Dashboard',
                                    'session' => 'start',
                                    'username' => $user_data['username'],
                                    'stocks' => $stocks, 'alerts' => $alerts, 'api_error' => $api_error, 'b' => $b, 't' => $t,
                                    'cash' => number_format((float)$user_data['cash'], 2),
                                    'total' => number_format((float)$total_holdings, 2) ]);
$alerts = array();
$routing = FALSE;
 ?>
