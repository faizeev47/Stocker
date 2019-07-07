<?php
  require 'vendor/autoload.php';
  include "DBHandler.php";
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader, []);

  $path = ltrim($_SERVER['REQUEST_URI'], '/');
  $elements = explode('/', $path);
  if(empty($elements[0])) {
    $route = 'home';
  }
  else if(count($elements) > 1 && explode('=',$elements[1])[0] != '?symbol'){
    $route = 'error';
  }
  else
  {
    $route = $elements[0];
  }
  session_start();

  $routing = TRUE;
  $routing_error = FALSE;
  $error = array("header" => NULL, "code" => NULL, "message" => NULL);
  $alert = "";
  $type = "";

  while($routing){
    switch($route) {

      case 'login':
        if(isset($_SESSION['sess_id'])){
          $alert = "User already logged in!";
          $type = "info";
          $route = 'home';
          break;
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $id_check = DatabaseObject::authUser($_POST['username'],$_POST['password']);
          if($id_check > 0){
            $_SESSION['sess_id'] = $id_check;
            $alert = "User successfully logged in!";
            $type = "info";
            $route = 'home';
            break;
          }
          else if($id_check == DatabaseObject::CONNECTION_PROBLEM){
            $error['header'] = 'HTTP/1.0 501 Internal Server Error';
            $error['code'] = 501;
            $error['message'] = 'Internal Server Error: Database not connected!';
            $route = 'error';
            $routing_error = TRUE;
            break;
          }
          else if($id_check == DatabaseObject::UNKNOWN_DATA){
            $alert = "Username or password incorrect!";
            $type = "warning";
          }
          else{
            $error['header'] = 'HTTP/1.0 501 Internal Server Error';
            $error['code'] = 501;
            $error['message'] = 'Internal Server Error: Incorrect database query!';
            $route = 'error';
            $routing_error = TRUE;
            break;
          }
        }
        echo $twig->render('login.twig',['title' => 'Login',
                                    'alert' => $alert,
                                    'type' => $type]);
        $alert = "";
        $type = "";
        $routing = FALSE;
        break;

      case 'logout':
        session_destroy();
        $alert = "User logged out!";
        $type = "info";
        echo $twig->render('login.twig',['title' => 'Login',
                                    'alert' => $alert,
                                    'type' => $type]);
        $alert = "";
        $type = "";
        $routing = FALSE;
        break;

      case 'register':
        if(isset($_SESSION['sess_id'])){
          $route = 'home';
          break;
        }
        $alert = "";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $username = $_POST['username'];
          $pass = $_POST['password'];
          $conf = $_POST['confirm'];
          $available = DatabaseObject::checkUsername($username);
          if($available == DatabaseObject::USER_UNIQUE && $pass == $conf){
            $insertion_check = DatabaseObject::addUser($username,$conf);
            if($insertion_check != DatabaseObject::CONNECTION_PROBLEM){
              $alert = "Account created!";
              $type = "success";
              echo $twig->render('login.twig',['title' => 'Login',
                                          'alert' => $alert,
                                          'type' => $type]);
              $alert = "";
              $type = "";
              $routing = FALSE;
              break;
            }
            else {
              $error['header'] = 'HTTP/1.0 501 Internal Server Error';
              $error['code'] = 501;
              $error['message'] = 'Internal Server Error: Problem during record insertion!';
              $route = 'error';
              $routing_error = TRUE;
              break;
            }
          }
          else{
            if ($pass != $conf){
              $alert = "Passwords do not match!";
              $type = "warning";
            }
            else if ($available == DatabaseObject::USER_EXISTS){
              $alert = "Username already exists!";
              $type = "warning";
            }
            else if ($available == DatabaseObject::CONNECTION_PROBLEM){
              $error['header'] = 'HTTP/1.0 501 Internal Server Error';
              $error['code'] = 501;
              $error['message'] = 'Internal Server Error: Database not connected!';
              $route = 'error';
              $routing_error = TRUE;
              break;
            }
          }
        }
        echo $twig->render('register.twig',['title' => 'Register',
                                          'alert' => $alert,
                                          'type' => $type]);
        $alert = "";
        $type = "";
        $routing = FALSE;
        break;

      case 'home':
        if(!isset($_SESSION['sess_id']))
        {
          $route = 'login';
          break;
        }
        $do = new DatabaseObject($_SESSION['sess_id']);
        if(!$do->error){
          $user_data = $do->getUserData();
          $stock_data = $do->getStocks();
          $do->close();
          $total_holdings = $user_data['cash'];
          $stocks = array();
          while($row = $stock_data->fetch_assoc()){
            $url = sprintf("https://api.iextrading.com/1.0/stock/%s/quote",$row['symbol']);
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_HTTPGET,TRUE);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_SSL_ENABLE_ALPN,FALSE);
            curl_setopt($ch,CURLOPT_SSL_ENABLE_NPN,FALSE);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
            curl_setopt($ch,CURLOPT_SSL_VERIFYSTATUS,FALSE);

            $json = curl_exec($ch);
            if(!$json){
              $alert = "Could not connect to IEX to get live stock information! Try again later.";
              $type = "danger";
            }
            curl_close($ch);
            $quote = json_decode($json);
            $stock_owned = (float)$row['shares'] * (float)$quote->latestPrice;
            $total_holdings += $stock_owned;
            array_push($stocks, array('symbol' => $row['symbol'],
                                      'name' => $quote->companyName,
                                      'shares' => $row['shares'],
                                      'price' =>  number_format((float)$quote->latestPrice, 2, '.', ''),
                                      'total' => number_format((float)$stock_owned, 2, '.', '')));
          }
        }
        else{
          $error['header'] = 'HTTP/1.0 501 Internal Server Error';
          $error['code'] = 501;
          $error['message'] = 'Internal Server Error: Database not connected!';
          $route = 'error';
          $routing_error = TRUE;
          break;
        }
        echo $twig->render('dashboard.twig',['title' => 'Dashboard',
                                            'session' => 'start',
                                            'username' => $user_data['username'],
                                            'stocks' => $stocks, 'alert' => $alert, 'type' => $type,
                                            'cash' => number_format((float)$user_data['cash'], 2, '.', ''),
                                            'total' => number_format((float)$total_holdings, 2, '.', '') ]);
        $alert = "";
        $type = "";
        $routing = FALSE;
        break;

      case 'buy':
        if(!isset($_SESSION['sess_id'])){
          $route = 'login';
          break;
        }
        $do = new DatabaseObject($_SESSION['sess_id']);
        if (!$do->error){
          $user_data = $do->getUserData();
          if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $symbol = $_POST['symbol'];
            $shares = (int) $_POST['shares'];
            $url = sprintf("https://api.iextrading.com/1.0/stock/%s/quote", $symbol);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_HTTPGET,TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_SSL_ENABLE_ALPN,FALSE);
            curl_setopt($ch, CURLOPT_SSL_ENABLE_NPN,FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYSTATUS,FALSE);

            $json = curl_exec($ch);
            if ($json){
              $quote = json_decode($json);
              if ($quote){
                $buy_price = (float) $quote->latestPrice * (int) $shares;
                if ($buy_price <= $user_data['cash']){
                  $do->buyStock($symbol, $shares);
                  $do->updateCash(-$buy_price);
                  $do->addTransaction($symbol, (float)$quote->latestPrice, $shares, DatabaseObject::IS_BUY);
                  $do->close();
                  if($shares == 1){
                    $alert = $shares." share of ".$quote->companyName." bought!";
                  }
                  else{
                    $alert = $shares." shares of ".$quote->companyName." bought!";
                  }
                  $type = "success";
                  $route = 'home';
                  break;
                }
                else{
                  $alert = "Not enough cash! Buy price for ".$shares." shares of ".$quote->companyName." stock is $".number_format((float)$buy_price, 2, '.', '').". You have $".number_format((float)$user_data['cash'], 2, '.', '');
                  $type = "warning";
                }
              }
              else{
                $alert = "Stock does not exist!";
                $type = "warning";
              }
            }
            else{
              $alert = "Could not connect to IEX to get live stock information! Try again later.";
              $type = "danger";
            }
          }
        }
        else{
          $error['header'] = 'HTTP/1.0 501 Internal Server Error';
          $error['code'] = 501;
          $error['message'] = 'Internal Server Error: Database not connected!';
          $route = 'error';
          $routing_error = TRUE;
          break;
        }
        $symbol = "";
        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['symbol'])){
          $symbol = $_GET['symbol'];
        }
        echo $twig->render('buy.twig',['title' => 'Buy',
                                    'session' => 'start',
                                    'username' => $user_data['username'],
                                    'cash' => $user_data['cash'],
                                    'symbol' => $symbol,
                                    'alert' => $alert,'type' => $type]);

        $alert = "";
        $type = "";
        $routing = FALSE;
        break;

      case 'sell':
        if (!isset($_SESSION['sess_id'])){
          $route = 'login';
          break;
        }
        $do = new DatabaseObject($_SESSION['sess_id']);
        if (!$do->error){
          $user_data = $do->getUserData();
          $stock_data = $do->getStocks();
          $stocks_owned = array();
          while ($row = $stock_data->fetch_assoc()){
            array_push($stocks_owned, $row['symbol']);
          }
          if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $symbol = $_POST['symbol'];
            $shares = (int)$_POST['shares'];
            $url = sprintf("https://api.iextrading.com/1.0/stock/%s/quote",$symbol);
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_HTTPGET,TRUE);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_SSL_ENABLE_ALPN,FALSE);
            curl_setopt($ch,CURLOPT_SSL_ENABLE_NPN,FALSE);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
            curl_setopt($ch,CURLOPT_SSL_VERIFYSTATUS,FALSE);

            $json = curl_exec($ch);
            if($json){
              $quote = json_decode($json);
              if($quote){
                $user_stock = $do->getStockData($symbol);
                $rem_shares = (int)$user_stock['shares'] - (int)$shares;
                if($rem_shares >= 0){
                  $do->sellStock($symbol,$rem_shares);
                  $earning = ((float)$quote->latestPrice * (float)$shares);
                  $do->updateCash($earning);
                  $do->addTransaction($symbol, (float)$quote->latestPrice, $shares,DatabaseObject::IS_SALE);
                  $do->close();
                  if ($shares == 1){
                    $alert = $shares." share of ".$quote->companyName." sold!";
                  } else {
                    $alert = $shares." shares of ".$quote->companyName." sold!";
                  }

                  if ($rem_shares == 0){
                    $alert = $alert." You now do not own any shares of this stock.";
                  } else if ($rem_shares == 1){
                    $alert = $alert." You now own 1 share of this stock.";
                  } else{
                    $alert = $alert." You now own ".$rem_shares." shares of this stock.";
                  }
                  $type = "success";
                  $route = 'home';
                  break;
                }
                else{
                  $alert = "You do not own ".$shares." ".$quote->companyName." stocks";
                  $type = "warning";
                }

              }
              else {
                $alert = "Stock does not exist!";
                $type = "warning";
              }
            }
            else {
              $alert = "Could not connect to IEX to get live stock information! Try again later.";
              $type = "danger";
            }
          }
        }
        else{
          $error['header'] = 'HTTP/1.0 501 Internal Server Error';
          $error['code'] = 501;
          $error['message'] = 'Internal Server Error: Database not connected!';
          $route = 'error';
          $routing_error = TRUE;
          break;
        }
        $symbol = "";
        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['symbol'])){
          if(in_array($_GET['symbol'],$stocks_owned)){
            $symbol = $_GET['symbol'];
          }
        }
        echo $twig->render('sell.twig',['title' => 'Sell',
                                      'session' => 'start',
                                      'username' => $user_data['username'],
                                      'cash' => $user_data['cash'],
                                      'symbol' => $symbol,
                                      'stocks_owned' => $stocks_owned,
                                      'alert' => $alert, 'type' => $type]);
        $alert = "";
        $type = "";
        $routing = FALSE;
        break;

      case 'history':
        if(!isset($_SESSION['sess_id']))
        {
          $route = 'login';
          break;
        }
        $do = new DatabaseObject($_SESSION['sess_id']);
        if(!$do->error){
          $user_data = $do->getUserData();
          $rows = $do->getHistory();
          $do->close();
          $history = array();
          while($row = $rows->fetch_assoc()){
            array_push($history, array('trans_id' => $row['trans_id'],
                        'symbol' => $row['symbol'],
                        'shares' => $row['shares'],
                        'price' => $row['price'],
                        'date' => $row['DATE(made_on)'],
                        'time' => $row['TIME(made_on)'],
                        'type' => $row['transaction']));
          }
        }
        else{
          $error['header'] = 'HTTP/1.0 501 Internal Server Error';
          $error['code'] = 501;
          $error['message'] = 'Internal Server Error: Database not connected!';
          $route = 'error';
          $routing_error = TRUE;
          break;
        }
        echo $twig->render('history.twig',['title' => 'History',
                                        'session' => 'start',
                                        'username' => $user_data['username'],
                                        'cash' => $user_data['cash'],
                                        'history' => $history]);
        $routing = FALSE;
        break;

      case 'quote':
        if(!isset($_SESSION['sess_id'])){
          $route = 'login';
          break;
        }
        $do = new DatabaseObject($_SESSION['sess_id']);
        if (!$do->error){
          $user_data = $do->getUserData();
          $do->close();
          $quoted = FALSE;
          if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            echo $twig->render('quote.twig',['title' => 'Quote',
                                        'session' => 'start',
                                        'username' => $user_data['username'],
                                        'cash' => $user_data['cash']]);
            $routing = FALSE;
            break;
          }
          else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $symbol = $_POST['symbol'];
            $url = sprintf("https://api.iextrading.com/1.0/stock/%s/quote",$symbol);
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_HTTPGET,TRUE);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_SSL_ENABLE_ALPN,FALSE);
            curl_setopt($ch,CURLOPT_SSL_ENABLE_NPN,FALSE);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
            curl_setopt($ch,CURLOPT_SSL_VERIFYSTATUS,FALSE);

            $json = curl_exec($ch);
            if($json){
              curl_close($ch);
              $quote = json_decode($json);
              if($quote){
                $quoted = TRUE;
              }else {
                $alert = "Stock does not exist!";
                $type = "warning";
              }
            }
            else{
              $alert = 'Could not connect to IEX to get live stock information! Try again later.';
              $type = "danger";
            }
          }
        }
        else{
          $error['header'] = 'HTTP/1.0 501 Internal Server Error';
          $error['code'] = 501;
          $error['message'] = 'Internal Server Error: Database not connected!';
          $route = 'error';
          $routing_error = TRUE;
          break;
        }
        echo $twig->render('quote.twig',['title' => 'Quote',
                                    'session' => 'start',
                                    'username' => $user_data['username'],
                                    'quoted' => $quoted,
                                    'symbol' => $quote->symbol,
                                    'company' => $quote->companyName,
                                    'price' => $quote->latestPrice,
                                    'alert' => $alert,
                                    'type' => $type]);
        $alert = "";
        $type = "";
        $routing = FALSE;
        break;

      case 'stockDetails':
        if(!isset($_SESSION['sess_id'])){
          $route = 'login';
          break;
        }
        $symbol = $_GET['symbol'];
        $do=new DatabaseObject($_SESSION['sess_id']);
        if(!$do->error){
          $user_data=$do->getUserData();
          $stock_data=$do->getStockData($symbol);
          $shares = 0;
          if($stock_data){
            $shares = $stock_data['shares'];
          }
          echo $twig->render('stockDetails.twig',['title' => 'Stock Details',
                                      'session' => 'start',
                                      'username' => $user_data['username'],
                                      'cash' => $user_data['cash'],
                                      'shares' => $shares,
                                      'symbol' => $symbol]);

          $routing=FALSE;
        }
        else{
          header('HTTP/1.0 500 Internal Server Error');
          echo $twig->render('error.twig',['title' => 'Error',
                                        'code' => 500,
                                        'error' => 'Could not connect to database!']);
          $routing = FALSE;

        }
        break;

      case 'deposit':
        if(!isset($_SESSION['sess_id'])){
          $route = 'login';
          break;
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $do = new DatabaseObject($_SESSION['sess_id']);
          if (!$do->error){
            $user_data = $do->getUserData();
            $amount = $_POST['amount'];
            if ($amount >= 0){
              $do->updateCash($amount);
              $do->close();
              $alert = "$".number_format((float)$amount, 2, '.', '')." deposited into your account! You now have $".number_format((float)$user_data['cash'], 2, '.', '');
              $type = "success";
              $route = 'home';
              break;
            }
          }
          else{
            $error['header'] = 'HTTP/1.0 501 Internal Server Error';
            $error['code'] = 501;
            $error['message'] = 'Internal Server Error: Database not connected!';
            $route = 'error';
            $routing_error = TRUE;
            break;
          }

        }
        break;

      case 'withdraw':
        if(!isset($_SESSION['sess_id'])){
          $route = 'login';
          break;
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $do = new DatabaseObject($_SESSION['sess_id']);
          if (!$do->error){
            $user_data = $do->getUserData();
            $amount = $_POST['amount'];
            if ($amount <= $user_data['cash']){
              $do->updateCash(-$amount);
              $do->close();
              $alert = "$".number_format((float)$amount, 2, '.', '')." withdrawn from your account! You now have $".number_format((float)$user_data['cash'], 2, '.', '');
              $type = "secondary";
              $route = 'home';
              break;
            }
          }
          else{
            $error['header'] = 'HTTP/1.0 501 Internal Server Error';
            $error['code'] = 501;
            $error['message'] = 'Internal Server Error: Database not connected!';
            $route = 'error';
            $routing_error = TRUE;
            break;
          }

        }
        break;

      default:
        if($routing_error){
          header($error['header']);
          echo $twig->render('error.twig',['title' => 'Error',
                                        'code' => $error['code'],
                                        'error' => $error['message']]);
          $routing_error = FALSE;
        }
        else{
          header('HTTP/1.0 404 Not Found');
          echo $twig->render('error.twig',['title' => 'Error',
                                            'code' => '404',
                                            'error' => 'Not Found']);
        }
        $routing = FALSE;
        break;
    }
  }


?>
