<?php

  class DB extends SQLite3{
    function __construct(){
      $this->open('finance.db');
    }
    function __destruct(){
      $this->close();
    }
  }

  class DatabaseObject{
    private $db;
    private $user_id;

    const UNKNOWN_DATA = -2;

    const USER_EXISTS = -3;
    const USER_UNIQUE = 1;

    const IS_BUY = 1;
    const IS_SALE = 0;

    function __construct($user_id){
      $this->db = new DB();
      $this->user_id = $user_id;
    }

    public function getUserData(){
      return $this->select('users', ['id'], [$this->user_id])['result'][0];
    }

    public function getStockData($symbol){
      return $this->select('stocks',['user_id','symbol'],[$this->user_id, $symbol]);
    }

    public function getStocks(){
      return $this->select('stocks',['user_id'],[$this->user_id]);
    }

    public function getHistory(){
      $res = $this->select('transactions',['user_id'],[$this->user_id],
      ['trans_id', 'shares', 'user_id', 'symbol', 'price', 'DATE(made_on)', 'TIME(made_on)',
      "CASE is_purchase WHEN 1 THEN 'purchase' ELSE 'sale' END AS 'transaction'"]);
      return $res;
    }

    public function buyStock($symbol, $shares_bought){
      $user_stock = $this->getStockData($symbol);
      if($user_stock['numRows'] == 0){
        $this->insert('stocks', ['user_id', 'symbol', 'shares'], [$this->user_id, strtoupper($symbol), $shares_bought]);
      } else {
        $user_shares = $user_stock['result'][0]['shares'];
        $new_shares = (int)$user_shares + (int)$shares_bought;
        $this->update('stocks', ['shares'], [$new_shares], ['user_id','symbol'], [$this->user_id, strtoupper($symbol)]);
      }
    }

    public function sellStock($symbol, $shares_sold){
      $user_stock = $this->getStockData($symbol);
      if($user_stock['numRows'] > 0){
        $user_shares = $user_stock['result'][0]['shares'];
        $new_shares = (int)$user_shares - (int)$shares_sold;
        if($new_shares <= 0){
          $this->delete('stocks', ['user_id', 'symbol'], [$this->user_id, $symbol]);
        } else {
          $this->update('stocks', ['shares'], [$new_shares], ['user_id', 'symbol'], [$this->user_id, $symbol]);
        }
      }
    }

    public function addTransaction($symbol, $trans_price, $shares, $trans_type){
      $this->insert('transactions',
      ['user_id', 'symbol', 'price', 'is_purchase', 'shares'],
      [$this->user_id, strtoupper($symbol), round((float)$trans_price,2), $trans_type, $shares]);
    }

    public function updateCash($change_amount){
      $user_data = $this->getUserData();
      $new_amount = round((float)$user_data['cash'] + (float)$change_amount, 2);
      $this->update("users",['cash'],[$new_amount],['id'],[$this->user_id]);
    }

    private function select($table, $fields = [], $values = [], $cols = []){
      $l = count($fields);
      $m = count($cols);
      $sql = "SELECT ";
      if($m > 0){
        for($i = 0; $i < $m; $i++){
          $sql .= $cols[$i];
          if($i + 1 < $m){
            $sql .= ", ";
          }
        }
      } else {
        $sql .= " * ";
      }
      $sql .= " FROM ".$table;
      if($l > 0){
        $sql .= " WHERE ";
        for($i = 0; $i < $l; $i++){
          $sql .= $fields[$i]." = :v".$i;
          if($i + 1 < $l){
            $sql .= " AND ";
          }
        }
      }
      $stmt = $this->db->prepare($sql);
      for($i = 0 ; $i < $l; $i++){
        $stmt->bindParam(':v'.$i, $values[$i]);
      }

      $res = $stmt->execute();
      $res_arr = array();
      while($row = $res->fetchArray(SQLITE3_BOTH)){
        array_push($res_arr,$row);
      }
      return array('result'=>$res_arr, 'numColumns' => $res->numColumns(), 'numRows' => count($res_arr));
    }

    private function insert($table, $fields = [], $values = []){
      $l = count($fields);
      $sql = "INSERT INTO ".$table;
      $sql .= " (";
      for($i = 0; $i < $l; $i++){
        $sql .= $fields[$i];
        if($i + 1 < $l){
          $sql .= ", ";
        }
      }
      $sql .= ") VALUES (";

      for($i = 0; $i < $l; $i++){
        $sql .= ":v".$i;
        if($i + 1 < $l){
          $sql .= ", ";
        }
      }
      $sql .= ")";
      $stmt = $this->db->prepare($sql);
      for($i = 0; $i < $l; $i++){
        $stmt->bindParam(':v'.$i, $values[$i]);
      }

      $stmt->execute();
    }

    private function update($table, $cols = [], $changes = [], $fields = [], $values = []){
      $l = count($fields);
      $c = count($cols);

      $sql = "UPDATE ".$table. " SET ";
      for($i = 0; $i < $c; $i++){
        $sql .= $cols[$i]." = :sv".$i;
        if ($i + 1 < $c){
          $sql .= " AND ";
        }
      }
      $sql .= " WHERE ";
      for($i = 0; $i < $l; $i++){
        $sql .= $fields[$i]." = :wv".$i;
        if ($i + 1 < $l){
          $sql .= " AND ";
        }
      }
      $stmt = $this->db->prepare($sql);
      for($i = 0; $i < $c; $i++){
        $stmt->bindParam(':sv'.$i, $changes[$i]);
      }
      for($i = 0; $i < $l; $i++){
        $stmt->bindParam(':wv'.$i, $values[$i]);
      }

      $stmt->execute();
    }

    private function delete($table, $fields = [], $values = []){
      $l = count($fields);
      if($l == 0){
        return;
      }
      $sql = "DELETE FROM ".$table." WHERE ";
      for($i = 0; $i < $l; $i++){
        $sql .= $fields[$i]." = :v".$i;
        if($i + 1 < $l){
          $sql .= " AND ";
        }
      }
      $stmt = $this->db->prepare($sql);
      for($i = 0 ; $i < $l; $i++){
        $stmt->bindParam(':v'.$i, $values[$i]);
      }

      $res = $stmt->execute();
    }

    public static function authUser($username, $password){
      $db = new DB();
      $stmt = $db->prepare('SELECT *
                            FROM users
                            WHERE username=:username AND password=:password;');
      $stmt->bindParam(":username", $username);
      $stmt->bindParam(":password", $password);
      $res = $stmt->execute();
      if( !($row = $res->fetchArray(SQLITE3_BOTH))){
        return DatabaseObject::UNKNOWN_DATA;
      } else {
        return $row['id'];
      }
    }

    public static function checkUsername($username){
      $db = new DB();
      $stmt = $db->prepare('SELECT *
                            FROM users
                            WHERE username=:username;');
      $stmt->bindParam(":username", $username);
      $res = $stmt->execute();
      if( !($row = $res->fetchArray(SQLITE3_BOTH))){
        return DatabaseObject::USER_UNIQUE;
      } else {
        return DatabaseObject::USER_EXISTS;
      }
    }

    public static function addUser($username, $password){
      $db = new DB();
      $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':password', $password);
      $stmt->execute();
    }
  }

 ?>
