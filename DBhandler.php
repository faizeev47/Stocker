<?php class DatabaseObject{
  private $connection;
  private $user_id;
  public $error;

  const CONNECTION_PROBLEM = -1;
  const UNKNOWN_DATA = -2;

  const USER_EXISTS = -3;
  const USER_UNIQUE = 1;

  const IS_BUY = 1;
  const IS_SALE = 0;

  function __construct($user_id){
    $this->connection = new mysqli('localhost','root','toor', 'finance');
    $this->user_id = (int)$user_id;
    $error = $this->connection->connect_error;
  }

  public static function addUser($username,$password){
    $conn = new mysqli('localhost','root','toor','finance');
    if(!$conn || $conn->connect_error){
      return DatabaseObject::CONNECTION_PROBLEM;
    }
    $username = mysqli_real_escape_string($conn,$username);
    $password = mysqli_real_escape_string($conn,$password);
    $sql = sprintf("INSERT INTO users
                    (username,password,cash)
                    VALUES ('%s','%s',10000.00)",
                    $username,$password);
    $result = $conn->query($sql);
    $conn->close();
    return 0;
  }

  public static function authUser($username, $password){
    $conn = new mysqli('localhost','root','toor', 'finance');
    if(!$conn || $conn->connect_error){
      return DatabaseObject::CONNECTION_PROBLEM;
    }
    $username = mysqli_real_escape_string($conn,$username);
    $password = mysqli_real_escape_string($conn,$password);
    $sql= sprintf("SELECT * FROM users
                  WHERE username='%s'
                  AND password='%s'",
                   $username, $password);
    $result = $conn->query($sql);
    $conn->close();
    if(!$result){
      return DatabaseObject::UNKNOWN_DATA;
    }
    else if($result->num_rows == 0){
      return DatabaseObject::UNKNOWN_DATA;
    }
    else{
      return $result->fetch_assoc()['id'];
    }
  }

  public static function checkUsername($username){
    $conn = new mysqli('localhost','root','toor', 'finance');
    if(!$conn || $conn->connect_error){
      return DatabaseObject::CONNECTION_PROBLEM;
    }
    $username = mysqli_real_escape_string($conn,$username);
    $sql= sprintf("SELECT * FROM users
                  WHERE username='%s'",
                   $username);
    $result = $conn->query($sql);
    $conn->close();
    if(!$result || $result->num_rows < 1){
      return DatabaseObject::USER_UNIQUE;
    }
    else{
      return DatabaseObject::USER_EXISTS;
    }
  }

  public function addTransaction($symbol, $trans_price, $shares, $trans_type){
    $symbol = mysqli_real_escape_string($this->connection,$symbol);
    $sql = sprintf("INSERT INTO transactions
                    (user_id,symbol,price,is_purchase,shares)
                    VALUES (%d,'%s',%.2f,%d,%d)",
                    $this->user_id,$symbol,(float)$trans_price,(int)$trans_type,(int)$shares);
    $this->connection->query($sql);
  }

  public function updateCash($amount){
    $user_data = $this->getUserData();
    $amount = (float)$amount + (float)$user_data['cash'];
     $sql = sprintf("UPDATE users
                    SET cash=%.2f
                    WHERE id=%d",
                    $amount,$this->user_id);
    $this->connection->query($sql);
  }

  public function getUserData(){
    $sql= sprintf("SELECT * FROM users
                    WHERE id=%d",
                    $this->user_id);
    $result = $this->connection->query($sql);
    $user_data = $result->fetch_assoc();
    return $user_data;
  }

  public function getStockData($symbol){
    $symbol = mysqli_real_escape_string($this->connection,$symbol);
    $sql = sprintf("SELECT * FROM stocks
                    WHERE user_id=%d AND symbol='%s'"
                    , $this->user_id, $symbol);
    $stock_data = $this->connection->query($sql);
    if(!$stock_data){
      return $stock_data;
    }
    else{
      return $stock_data->fetch_assoc();
    }
  }

  public function getStocks(){
    $sql= sprintf("SELECT * FROM stocks
                    WHERE user_id=%d",
                     $this->user_id);
    $stock_data = $this->connection->query($sql);
    return  $stock_data;
  }

  public function getHistory(){
    $sql = sprintf("SELECT trans_id,shares,user_id,symbol,price, DATE(made_on),TIME(made_on),
                      CASE is_purchase
                      WHEN 1 THEN 'purchase'
                      ELSE 'sale' END AS 'transaction' FROM transactions WHERE user_id=%d;",$this->user_id);
    $history = $this->connection->query($sql);
    return  $history;
  }

  public function buyStock($symbol, $shares_bought){
    $symbol = mysqli_real_escape_string($this->connection,$symbol);
    $user_stock = $this->getStockData($symbol);
    if(!$user_stock){
      $sql= sprintf("INSERT INTO stocks
                    (user_id,symbol,shares)
                    VALUES (%d,'%s',%d)",
                     $this->user_id, $symbol, $shares_bought);
    }
    else{
      $new_shares = (int)$shares_bought + (int)$user_stock['shares'];
      $sql = sprintf("UPDATE stocks
                      SET shares=%d
                      WHERE user_id=%d AND symbol='%s'",
                      (int)$new_shares, $this->user_id, $symbol);
    }
    $this->connection->query($sql);
  }

  public function sellStock($symbol, $remaining_shares){
    $symbol = mysqli_real_escape_string($this->connection,$symbol);
    if($remaining_shares == 0){
      $sql = sprintf("DELETE FROM stocks
                      WHERE user_id=%d AND symbol='%s'",
                      $this->user_id, $symbol);
    }
    else{
      $sql = sprintf("UPDATE stocks
                      SET shares=%d
                      WHERE user_id=%d AND symbol='%s'",
                      (int)$remaining_shares,$this->user_id, $symbol);
    }
    $this->connection->query($sql);
  }

  public function open(){
    $this->connection = new mysqli('localhost','root','toor', 'finance');
  }

  public function close(){
    $this->connection->close();
  }
}?>
