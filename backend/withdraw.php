<?php
// user submitted withdraw request using post
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  // extract data from database
  $do = new DatabaseObject($_SESSION['sess_id']);
  $user_data = $do->getUserData();
  $amount = $_POST['amount'];
  if ($amount <= $user_data['cash'] && $amount != 0){
    // update user cash in database
    $do->updateCash(-$amount);
    $alert = "$".number_format((float)$amount, 2)." withdrawn from your account! You now have $".number_format((float)$user_data['cash'], 2, '.', '');
    array_push($alerts, array("message" => $alert, "type" => "secondary"));
  }
  else if($amount == 0){
    array_push($alerts, array("message" => "Your current balance is zero!", "type" => "warning"));
  }
  else {
    array_push($alerts, array("message" => "Amount exceeding current available balance!", "type" => "warning"));
  }
}
$route = 'home';
 ?>
