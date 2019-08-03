<?php
// get data from database
$do = new DatabaseObject($_SESSION['sess_id']);
$user_data = $do->getUserData();
$user_stocks = $do->getStocks();

// get user owned stocks to display
$stocks = array();
foreach ($user_stocks['result'] as $row){
  array_push($stocks, $row['symbol']);
}

// user submitted sale request via post
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  // extract arguments from request
  $symbol = $_POST['symbol'];
  $shares = (int)$_POST['shares'];

  // connect to API to extract relevant stock information using cURL
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
  // incomplete request transfer with API
  if (!$json) {
    array_push($alerts, array("message" => "Could not connect to IEX to get live stock information! Try again later.", "type" => "danger"));
  }
  else {
    $quote = json_decode($json);
    // queried stock does not exist
    if (!$quote) {
      array_push($alerts, array("message" => "Stock does not exist!", "type" => "warning"));
    }
    else {
      // check user shares for request
      $user_stk_data = $do->getStockData($symbol);
      $rem_shares = (int)$user_stk_data['result'][0]['shares'] - (int)$shares;
      // user does not have enough shares
      if ($rem_shares < 0) {
        array_push($alerts, array("message" => "Cannot sell ".$shares." ".$quote->companyName." shares from your ".$user_stk_data['result'][0]['shares']." shares!", "type" => "warning"));
      }
      else {
        // user made an appropriate sale request
        // update or remove existing information for stock in stocks
        $do->sellStock($symbol, $shares);
        // update user cash
        $earning = ((float)$quote->latestPrice * (float)$shares);
        $do->updateCash($earning);
        // add record in transaction history
        // alert user after success
        $do->addTransaction($symbol, (float)$quote->latestPrice, $shares,DatabaseObject::IS_SALE);
        if ($shares == 1){
          $alert = $shares." share of ".$quote->companyName." sold at $".number_format((float)$quote->latestPrice,2);
        } else {
          $alert = $shares." shares of ".$quote->companyName." sold at $".number_format((float)$quote->latestPrice,2)." per share for a total of $".$earning."!";
        }
        array_push($alerts, array("message" => $alert, "type" => "success"));
        // update user about current share holding
        if ($rem_shares == 0){
          $alert = " You now do not own any shares of this stock.";
        } else if ($rem_shares == 1){
          $alert = " You now own 1 share of this stock ";
          $alert .= "at a total value of $".number_format((float)$quote->latestPrice * $rem_shares,2);
        } else{
          $alert = " You now own ".number_format($rem_shares)." shares of this stock ";
          $alert .= "at a total value of $".number_format((float)$quote->latestPrice * $rem_shares,2);
        }

        array_push($alerts, array("message" => $alert, "type" => "info"));
        $user_stocks = $do->getStocks();
        $stocks = array();
        foreach ($user_stocks['result'] as $row){
          array_push($stocks, $row['symbol']);
        }
      }
    }
  }
}

// if default value for stock symbol input field available in get request
$symbol = "";
if(isset($_GET['symbol'])){
  if(in_array($_GET['symbol'],$stocks)){
    $symbol = $_GET['symbol'];
  }
}
echo $twig->render('sell.twig',['title' => 'Sell',
                              'session' => 'start',
                              'username' => $user_data['username'],
                              'cash' => $user_data['cash'],
                              'symbol' => $symbol,
                              'stocks' => $stocks,
                              'alerts' => $alerts]);
$alerts = array();
$routing = FALSE;
 ?>
