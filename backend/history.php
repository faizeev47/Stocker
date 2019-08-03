<?php
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
 ?>
