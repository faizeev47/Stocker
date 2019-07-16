<?php
  require_once 'encryption.php';
  require 'vendor/autoload.php';
  include "databasehandler.php";
  // twig preloading
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader, []);

  // tokenizing path to extract and process route
  $path = ltrim($_SERVER['REQUEST_URI'], '/');
  $elements = explode('/', $path);
  // if no route, than set to homepage
  if (empty($elements[0])) {
    $route = 'home';
  }
  // if more than 2 elements or an incorrect query
  else if(count($elements) > 1){
    $route = 'error';
  }
  // else route to specified path
  else {
    $route = explode('?',$elements[0])[0];
  }
  // start new session
  session_start();

  $api_url = $b."/stock/%s/quote?".$t;

  // flag to check if routing continues after any iteration
  $routing = TRUE;
  // associative array indicating error in routing
  $error = array("isRouting"=>FALSE);
  // blank array to contain alerts generated during web routing
  $alerts = array();

  while ($routing) {
    switch ($route) {
      case 'login':
        // reroute towards homepage if user already logged in
        if (isset($_SESSION['sess_id'])) {
          // append to existing alerts the following alert
          array_push($alerts, array("message" => "User already logged in!", "type" => "info"));
          $route = 'home';
          break;
        }
        // user submitted login request via post
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
          // authenticate given user credentials
          $auth_code = DatabaseObject::authUser($_POST['username'], $_POST['password']);
          // positive authentication code identifies as user id in database
          if($auth_code > 0) {
            // add user id into the current session
            $_SESSION['sess_id'] = $auth_code;
            array_push($alerts, array("message" => "User succesfully logged in!", "type" => "success"));
            // reroute to homepage as user logs in
            $route = 'home';
            break;
          }
          // user does not exist in the database: indicate so
          else if($auth_code == DatabaseObject::UNKNOWN_DATA) {
            array_push($alerts, array("message" => "Username or password incorrect!", "type" => "warning"));
          }
          // DANGER ZONE: the server or the code is buggy
          else {
            $error = array("isRouting"=> TRUE, "message" => "Internal Server Error: Incorrect database query!");
            $route = 'error';
            break;
          }
        }
        // render the login template after processing request
        echo $twig->render('login.twig',['title' => 'Login',
                                    'alerts' => $alerts]);
        // reinitialize alert messages to blank
        $alerts = array();
        // disable routing
        $routing = FALSE;
        break;

      case 'logout':
        // reroute to login page if user is not logged in
        if (!isset($_SESSION['sess_id'])) {
          array_push($alerts, array("message" => "No user currently logged in!", "type" => "info"));
          $route = 'login';
          break;
        }
        // if logged in, end the current browser session
        session_destroy();
        array_push($alerts, array("message" => "User logged out!", "type" => "info"));
        // render the login temlate
        echo $twig->render('login.twig',['title' => 'Login',
                                    'alerts' => $alerts,
                                    'type' => $type]);
        $alerts = array();
        $routing = FALSE;
        break;

      case 'register':
        // reroute to homepage if user is currently logged in
        if (isset($_SESSION['sess_id'])) {
          $route = 'home';
          break;
        }
        $alert = "";
        // user submitted registration request via post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          // extract submission arguments
          $username = $_POST['username'];
          $pass = $_POST['password'];
          $conf = $_POST['confirm'];
          // passwords do not match
          if ($pass != $conf) {
            array_push($alerts, array("message" => "Passwords do not match!", "type" => "warning"));
          }
          else {
            // username already exists in database
            if (DatabaseObject::checkUsername($username) == DatabaseObject::USER_EXISTS) {
              array_push($alerts, array("message" => "Username already exists!", "type" => "warning"));
            }
            else {
              // user credentials qualify for an account
              DatabaseObject::addUser($username,$conf);
              array_push($alerts, array("message" => "Account created. Welcome to Stocker ".$username."! Enter credentials to login.", "type" => "success"));
              echo $twig->render('login.twig',['title' => 'Login',
                                          'alerts' => $alerts,
                                          'type' => $type]);
              $alerts = array();
              $routing = FALSE;
              break;
            }
          }
        }
        echo $twig->render('register.twig',['title' => 'Register',
                                          'alerts' => $alerts]);
        $alerts = array();
        $routing = FALSE;
        break;

      case 'home':
        // reroute to login if user user is not logged in
        if(!isset($_SESSION['sess_id'])) {
          $route = 'login';
          break;
        }
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
                                    'price' =>  number_format((float)$quote->latestPrice, 2),
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
        break;

      case 'buy':
        // reroute to login if user not logged in
        if(!isset($_SESSION['sess_id'])){
          $route = 'login';
          break;
        }
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
                $alert = "Not enough cash! Buy price for ".$shares." shares of ".$quote->companyName." stock is $".number_format((float)$buy_price, 2, '.', '').". You have $".number_format((float)$user_data['cash'], 2, '.', '');
                array_push($alerts, array("message" => $alert, "type" => "warning"));
              }
              else
              {
                // user made a appropriate buy request
                // add new or update existing stock information into the stocks table
                $do->buyStock($symbol, $shares);
                // update user's balance after transaction
                $do->updateCash(-$buy_price);
                // add record in transaction history
                $do->addTransaction($symbol, (float)$quote->latestPrice, $shares, DatabaseObject::IS_BUY);
                if($shares == 1){
                  $alert = $shares." share of ".$quote->companyName." bought at $".(float)$quote->latestPrice."!";
                }
                else{
                  $alert = $shares." shares of ".$quote->companyName." bought at $".(float)$quote->latestPrice." per share for a total of $".$buy_price."!";
                }
                // alert user after success
                array_push($alerts, array("message" => $alert, "type" => "success"));

                // calculate total shares owned for stock
                $user_stk_data = $do->getStockData($symbol);
                $new_shares = $shares;
                if ($user_stk_data['numRows'] == 1) {
                  $new_shares += (int)$user_stk_data['result'][0]['shares'];
                }

                // alert user about share holding
                if ($new_shares == 1){
                  $alert = " You now own 1 share of this stock.";
                } else{
                  $alert = " You now own ".$new_shares." shares of this stock.";
                }
                array_push($alerts, array("message" => $alert, "type" => "info"));
                $route = 'home';
                break;
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
        break;

      case 'sell':
        // reroute to login is user not logged in
        if (!isset($_SESSION['sess_id'])){
          $route = 'login';
          break;
        }
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
                  $alert = $shares." share of ".$quote->companyName." sold at $".(float)$quote->latestPrice;
                } else {
                  $alert = $shares." shares of ".$quote->companyName." sold at $".(float)$quote->latestPrice." per share for a total of $".$earning."!";
                }
                array_push($alerts, array("message" => $alert, "type" => "success"));
                // update user about current share holding
                if ($rem_shares == 0){
                  $alert = " You now do not own any shares of this stock.";
                } else if ($rem_shares == 1){
                  $alert = " You now own 1 share of this stock.";
                } else{
                  $alert = " You now own ".$rem_shares." shares of this stock.";
                }

                array_push($alerts, array("message" => $alert, "type" => "info"));
                $route = 'home';
                break;
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
        break;

      case 'history':
        // reroute to login if user not logged in
        if(!isset($_SESSION['sess_id'])) {
          $route = 'login';
          break;
        }
        // extract data from database
        $do = new DatabaseObject($_SESSION['sess_id']);
        $user_data = $do->getUserData();
        $user_history = $do->getHistory();

        // history to be dsplayed
        $history = array();
        foreach($user_history['result'] as $row){
          array_push($history, array('trans_id' => $row['trans_id'],
                      'symbol' => $row['symbol'],
                      'shares' => $row['shares'],
                      'price' => number_format((float)$row['price'], 2) ,
                      'date' => $row['DATE(made_on)'],
                      'time' => $row['TIME(made_on)'],
                      'type' => $row['transaction']));
        }

        echo $twig->render('history.twig',['title' => 'History',
                                        'session' => 'start',
                                        'username' => $user_data['username'],
                                        'cash' => $user_data['cash'],
                                        'history' => $history]);
        $routing = FALSE;
        break;

      case 'quote':
        // reroute to login if user not logged in
        if(!isset($_SESSION['sess_id'])){
          $route = 'login';
          break;
        }
        // extract data from database
        $do = new DatabaseObject($_SESSION['sess_id']);
        $user_data = $do->getUserData();

        // variable to let twig template know upon succesful quote
        $quoted = FALSE;
        // user requested page to submit a get request
        if (!isset($_GET['symbol'])){
          echo $twig->render('quote.twig',['title' => 'Quote',
                                      'session' => 'start',
                                      'username' => $user_data['username'],
                                      'cash' => $user_data['cash']]);
          $routing = FALSE;
          break;
        }
        // user submitted quote request via post
        else {
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
        $alerts = array();
        $routing = FALSE;
        break;

      case 'detailedQuote':
        // reroute to login if user is not logged in
        if(!isset($_SESSION['sess_id'])){
          $route = 'login';
          break;
        }
        // get argument from get request
        $symbol = $_GET['symbol'];

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
                                    'symbol' => $symbol]);

        $routing=FALSE;
        break;

      case 'deposit':
        // reroute to login if user not logged in
        if(!isset($_SESSION['sess_id'])){
          $route = 'login';
          break;
        }
        // user submitted deposit request via post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          // extract user data from database
          $do = new DatabaseObject($_SESSION['sess_id']);
          $user_data = $do->getUserData();

          // extract amount to be submitted from request
          $amount = $_POST['amount'];
          if ($amount >= 0){
            // update user cash in database
            $do->updateCash($amount);
            $alert = "$".number_format((float)$amount, 2, '.', '')." deposited into your account! You now have $".number_format((float)$user_data['cash'], 2, '.', '');
            array_push($alerts, array("message" => $alert, "type" => "success"));
            $route = 'home';
            break;
          }

        }
        break;

      case 'withdraw':
        // reroute to login if user not logged in
        if(!isset($_SESSION['sess_id'])){
          $route = 'login';
          break;
        }
        // user submitted withdraw request using post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          // extract data from database
          $do = new DatabaseObject($_SESSION['sess_id']);
          $user_data = $do->getUserData();
          $amount = $_POST['amount'];
          if ($amount <= $user_data['cash']){
            // update user cash in database
            $do->updateCash(-$amount);
            $alert = "$".number_format((float)$amount, 2, '.', '')." withdrawn from your account! You now have $".number_format((float)$user_data['cash'], 2, '.', '');
            array_push($alerts, array("message" => $alert, "type" => "secondary"));
            $route = 'home';
            break;
          }
        }
        break;

      default:
        if($error['isRouting']){
          header('HTTP/1.0 500 Internal Server Error');
          echo $twig->render('error.twig',['title' => 'Error',
                                        'code' => 500,
                                        'error' => $error['message']]);
          $error = array("isRouting" => FALSE);
        }
        else{
          header('HTTP/1.0 404 Not Found');
          echo $twig->render('error.twig',['title' => 'Error',
                                            'code' => 404,
                                            'error' => 'Not Found']);
        }
        $routing = FALSE;
        break;
    }
  }


?>
