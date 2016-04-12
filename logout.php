<?php
require_once 'includes/init.php';

if($user->loggedIn()) {
  $user->logOut();
  header("Location: index.php");
}