<?php

require_once 'Database.class.php';

class User {
  private $conn;

  public function __construct() {
    $dbInstance = Database::getInstance();
    $this->conn = $dbInstance->getConnection();
  }

  public function getConnection() {
    return $this->conn;
  }

  public function getID() {
    if($this->loggedIn()) {
      $query = "SELECT user_id FROM users WHERE user_id=:id LIMIT 0,1";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array(':id'=>$_SESSION['user_session']));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $id = $row['user_id'];
      return $id;
    }
  }

  public function signUp($user, $email, $pass) {
    try {
      $query = "INSERT INTO users SET user_name=:user, user_email=:email, user_pass=:pass";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array(':user'=>$user, ':email'=>$email, ':pass'=>$pass));
    } catch (PDOException $e) {
      echo 'The sign up process failed. Error: ' . $e->getMessage();
    }
  }

  public function logIn($user_email, $pass) {
    try {
      $query = "SELECT user_id, user_name, user_email, user_pass FROM users WHERE user_name=:user_email OR user_email=:user_email LIMIT 0,1";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array(':user_email'=>$user_email));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $numRows = $stmt->rowCount();
      $process = [];


      // if the user/email exists in db
      if ($numRows == 1) {
       if (password_verify($pass, $row['user_pass'])) {
         $_SESSION['user_session'] = $row['user_id'];
         $process[0] = 'true';
         return $process;
       } else {
         $process[0] = 'false';
         $process[1] = 'Incorrect Username/Email or Password';
         return $process;
       }
      }

      $process[0] = 'false';
      $process[1] = 'Incorrect Username/Email or Password';
      return $process;

    } catch (PDOException $e) {
      die('There is something wrong. Please contact the administrator.' . $e->getMessage());
    }
  }

  public function loggedIn() {
    if (isset($_SESSION['user_session'])) return true;

    return false;
  }

  public function logOut() {
    session_destroy();
    unset($_SESSION['user_session']);
    return true;
  }
}