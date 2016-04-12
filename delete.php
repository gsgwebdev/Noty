<?php
require_once 'includes/init.php';

if ($user->loggedIn()) {
  $note->deleteNote($_GET['isbn']);
  header("Location: library.php");
} else {
  header("Location: wall.php");
}