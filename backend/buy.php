<?php
// extract the data from database
$do = new DatabaseObject($_SESSION['sess_id']);
$user_data = $do->getUserData();
// user submitted buy request for $shares shares of a stock
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  // get argumnents from the request
  $symbol = $_POST['symbol'];
  $shares = (int) $_POST['shares'];
  // connect to the api
  $url = sprintf($api_url, $symbol);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_HTTPGET,TRUE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch, CURLOPT_SSL_ENABLE_ALPN,FALSE);
  curl_setopt($ch, CURLOPT_SSL_ENABLE_NPN,FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYSTATUS,FALSE);
  $json = curl_exec($ch);
  // if response is null, error connecting to API
  if (!$json) {
    array_push($alerts, array("message" => "Could not connect to IEX to get live stock information! Try again later.", "type" => "danger"));
  }
  else {
    $quote = json_decode($json);
    // if response is empty, stock does not exist
    if (!$quote) {
      array_push($alerts, array("message" => "Stock does not exist!", "type" => "warning"));
    }
    else {
      $buy_price = (float) $quote->latestPrice * (int) $shares;
      // user does not have enough cash to buy stocks
      if ($buy_price > $user_data['cash']) {
        $alert = "Not enough cash! Buy price for ".$shares." shares of ".$quote->companyName." stock is $".number_format((float)$buy_price, 2).". You have $".number_format((float)$user_data['cash'], 2, '.', '');
        array_push($alerts, array("message" => $alert, "type" => "warning"));
      }
      else
      {
        $user_stk_data = $do->getStockData($symbol);
        // user made a appropriate buy request
        // add new or update existing stock information into the stocks table
        $do->buyStock($symbol, $shares);
        // update user's balance after transaction
        $do->updateCash(-$buy_price);
        // add record in transaction history
        $do->addTransaction($symbol, (float)$quote->latestPrice, $shares, DatabaseObject::IS_BUY);
        if($shares == 1){
          $alert = $shares." share of ".$quote->companyName." bought at $".number_format((float)$quote->latestPrice,2)."!";
        }
        else{
          $alert = $shares." shares of ".$quote->companyName." bought at $".number_format((float)$quote->latestPrice,2)." per share for a total of $".$buy_price."!";
        }
        // alert user after success
        array_push($alerts, array("message" => $alert, "type" => "success"));
        $new_shares = $shares;
        // calculate total shares owned for stock
        if ($user_stk_data['numRows'] == 1) {
          $new_shares += (int)$user_stk_data['result'][0]['shares'];
        }
        // alert user about share holding
        if ($new_shares == 1){
          $alert = " You now own 1 share of this stock.";
        } else{
          $alert = " You now own ".$new_shares." shares of this stock at a total value of $".number_format((float) $quote->latestPrice * $new_shares, 2);
        }
        array_push($alerts, array("message" => $alert, "type" => "info"));
      }
    }
  }
}
$symbol = "";
if(isset($_GET['symbol'])){
  $symbol = $_GET['symbol'];
}
echo $twig->render('buy.twig',['title' => 'Buy',
                            'session' => 'start',
                            'username' => $user_data['username'],
                            'cash' => $user_data['cash'],
                            'symbol' => $symbol,
                            'alerts' => $alerts]);
$alerts = array();
$routing = FALSE;
 ?>
