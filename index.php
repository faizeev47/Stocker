<?php
  require_once 'backend/encryption.php';
  require_once 'vendor/autoload.php';
  require_once "backend/databasehandler.php";
  // twig preloading
  global $loader;
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  global $twig;
  $twig = new \Twig\Environment($loader, []);

  // tokenizing path to extract and process route
  $path = ltrim($_SERVER['REQUEST_URI'], '/');
  $elements = explode('/', $path);
  // if no route, than set to homepage
  global $route;
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

  global $api_url;
  $api_url = $b."/stock/%s/quote?".$t."&displayPercent=true";

  // flag to check if routing continues after any iteration
  global $routing;
  $routing = TRUE;
  // associative array indicating error in routing
  global $error;
  $error = array("isRouting"=>FALSE);
  // blank array to contain alerts generated during web routing
  global $alerts;
  $alerts = array();

  while ($routing) {
    switch ($route) {
      case 'login':
        if (isset($_SESSION['sess_id'])) {
          array_push($alerts, array("message" => "User already logged in!", "type" => "info"));
          $route = 'home';
          break;
        }
        include_once "backend/login.php";
        break;

      case 'logout':
        if (!isset($_SESSION['sess_id'])) {
          array_push($alerts, array("message" => "Log in to get access!", "type" => "secondary"));
          $route = 'login';
          break;
        }
        include_once "backend/logout.php";
        break;

      case 'register':
        if (isset($_SESSION['sess_id'])) {
          array_push($alerts, array("message" => "User already logged in!", "type" => "info"));
          $route = 'home';
          break;
        }
        include_once "backend/register.php";
        break;

      case 'home':
        if(!isset($_SESSION['sess_id'])) {
          $route = 'login';
          break;
        }
        include_once "backend/home.php";
        break;

      case 'buy':
        // reroute to login if user not logged in
        if(!isset($_SESSION['sess_id'])){
          array_push($alerts, array("message" => "Log in to get access!", "type" => "secondary"));
          $route = 'login';
          break;
        }
        include_once "backend/buy.php";
        break;

      case 'sell':
        // reroute to login is user not logged in
        if (!isset($_SESSION['sess_id'])){
          array_push($alerts, array("message" => "Log in to get access!", "type" => "secondary"));
          $route = 'login';
          break;
        }
        include_once "backend/sell.php";
        break;

      case 'history':
        // reroute to login if user not logged in
        if(!isset($_SESSION['sess_id'])) {
          array_push($alerts, array("message" => "Log in to get access!", "type" => "secondary"));
          $route = 'login';
          break;
        }
        include_once "backend/history.php";
        break;

      case 'quote':
        // reroute to login if user not logged in
        if(!isset($_SESSION['sess_id'])){
          array_push($alerts, array("message" => "Log in to get access!", "type" => "secondary"));
          $route = 'login';
          break;
        }
        include_once "backend/quote.php";
        break;

      case 'detailedQuote':
        // reroute to login if user is not logged in
        if(!isset($_SESSION['sess_id'])){
          array_push($alerts, array("message" => "Log in to get access!", "type" => "secondary"));
          $route = 'login';
          break;
        }
        include_once "backend/detailedQuote.php";
        break;

      case 'deposit':
        // reroute to login if user not logged in
        if(!isset($_SESSION['sess_id'])){
          array_push($alerts, array("message" => "Log in to get access!", "type" => "secondary"));
          $route = 'login';
          break;
        }
        include_once  "backend/deposit.php";
        break;

      case 'withdraw':
        // reroute to login if user not logged in
        if(!isset($_SESSION['sess_id'])){
          $route = 'login';
          break;
        }
        include_once " backend/withdraw.php";
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
