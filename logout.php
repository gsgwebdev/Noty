<?php
require_once 'processing/init.php';

if($user->loggedIn()) {
  $user->logOut();
  header('Location: index.php');
}