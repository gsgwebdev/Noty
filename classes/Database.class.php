<?php

class Database {
  // Credentials
  private $server = 'localhost';
  private $username = 'root';
  private $password = '';
  private $db = 'noty';

  // The connection object is initially set to null
  private $conn = null;

  // A single instance of the class
  private static $instance;

  public static function getInstance() {
    if (!self::$instance) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  public function getConnection() {
    return $this->conn;
  }

  private function __construct() {
    try {
      $this->conn = new PDO("mysql:host={$this->server};dbname={$this->db}", $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo "Connection Database Error: " . $e->getMessage();
    }
  }

  private function __clone() {}
}