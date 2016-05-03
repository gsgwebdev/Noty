<?php

class Database {
  /*
   * Singleton Pattern - this class
   * should have just one instance
   * and only one.
   */
  private static $instance = null;

  public static function getInstance() {
    if (!self::$instance) {
      // Credentials
      $server = 'localhost';
      $dbName = 'Noty';
      $username = 'root';
      $password = '';

      try {
        self::$instance = new PDO("mysql:host=$server;dbname=$dbName", $username, $password);
        self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        throw new Exception("Connection Database Error: " . $e->getMessage());
      }
    }

    return self::$instance;
  }

  private function __construct() {}
  private function __clone() {}
}