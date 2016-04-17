<?php
require_once 'processing/init.php';

if ($user->loggedIn()) {
  $note->deleteNote($_GET['isbn']);
  header('Location: library.php');
} else {
  header('Location: 404.php');
}