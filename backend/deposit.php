<?php
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
 ?>
