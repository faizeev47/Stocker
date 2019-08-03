<?php
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
      // routing towards login will sign user in due to form submission
      echo $twig->render('login.twig',['title' => 'Login',
                                  'alerts' => $alerts]);
      $alerts = array();
      $routing = FALSE;
    }
  }
}
if ($routing) {
  echo $twig->render('register.twig',['title' => 'Register',
                                    'alerts' => $alerts]);
  $alerts = array();
  $routing = FALSE;
}
 ?>
