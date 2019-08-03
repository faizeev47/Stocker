<?php
// user submitted login request via post
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  // authenticate given user credentials
  $auth_code = DatabaseObject::authUser($_POST['username'], $_POST['password']);
  // positive authentication code identifies as user id in database
  if($auth_code > 0) {
    // add user id into the current session
    $_SESSION['sess_id'] = $auth_code;
    header("location:/home");
    $routing = FALSE;
  }
  // user does not exist in the database: indicate so
  else if($auth_code == DatabaseObject::UNKNOWN_DATA) {
    array_push($alerts, array("message" => "Username or password incorrect!", "type" => "warning"));
  }
  // DANGER ZONE: the server or the code is buggy
  else {
    $error = array("isRouting"=> TRUE, "message" => "Internal Server Error: Incorrect database query!");
    $route = 'error';
  }
}
// render the login template after processing request
echo $twig->render('login.twig',['title' => 'Login',
                            'alerts' => $alerts]);
// reinitialize alert messages to blank
$alerts = array();
// disable routing
$routing = FALSE;
 ?>
