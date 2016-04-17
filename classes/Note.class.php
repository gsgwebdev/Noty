<?php
require_once 'Database.class.php';
require_once  'User.class.php';

class Note {
  private $conn;

  public function __construct() {
    $db = Database::getInstance();
    $this->conn = $db->getConnection();
  }

  public function allNotes() {
    try {
      $query = "SELECT * FROM notes";
      $stmt = $this->conn->prepare($query);
      return $stmt;
    } catch (PDOException $e) {
      die("The notes cannot be fetched. Error: " . $e->getMessage());
    }
  }

  public function userNotes($userID) {
    $query = "SELECT * FROM notes WHERE book_userID=:userID";
    $stmt = $this->conn->prepare($query);
    $stmt->execute(array(':userID'=>$userID));
    return $stmt;
  }

  public function addNote($username, $title, $author, $isbn, $rate, $link, $cover, $intro, $body){
    try{
      $query = "INSERT INTO notes SET book_userID=:user, book_title=:title, book_author=:author, book_isbn=:isbn, book_rate=:rate, book_link=:link, book_cover=:cover, book_intro=:intro, book_body=:body";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array(':user'=>$username, ':title'=>$title, ':author'=>$author, ':isbn'=>$isbn, ':rate'=>$rate, ':link'=>$link, ':cover'=>$cover, ':intro'=>$intro, ':body'=>$body));
    } catch (PDOException $e) {
      die("The note cannot be added. Error: " . $e->getMessage());
    }
  }

  public function getNote($isbn){
    try{
      $query = "SELECT * FROM notes WHERE book_isbn=:isbn LIMIT 0,1";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array(':isbn'=>$isbn));
      return $stmt;
    } catch (PDOException $e) {
      die("The note cannot be fetched. Error: " . $e->getMessage());
    }
  }

  public function updateNote($initISBN, $title, $author, $isbn, $rate, $link, $cover, $intro, $body) {
    try {
      $query = "UPDATE notes SET book_title=:title, book_author=:author, book_isbn=:isbn, book_rate=:rate, book_link=:link, book_cover=:cover, book_intro=:intro, book_body=:body WHERE book_isbn=:initISBN";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array(':initISBN'=>$initISBN, ':title'=>$title, ':author'=>$author, ':isbn'=>$isbn, ':rate'=>$rate, ':link'=>$link, ':cover'=>$cover, ':intro'=>$intro, ':body'=>$body));
    } catch (PDOException $e) {
      die("The note cannot be updated. Error: " . $e->getMessage());
    }
  }

  public function deleteNote($isbn) {
    try {
      $query = "DELETE FROM notes WHERE book_isbn=:isbn";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array(':isbn'=>$isbn));
    } catch (PDOException $e) {
      die("The note cannot be deleted. Error: " . $e->getMessage());
    }
  }



}