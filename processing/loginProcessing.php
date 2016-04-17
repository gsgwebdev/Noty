<?php
// Include site wide variables and other configurations
require_once 'init.php';

$err = '';

if (isset($_POST['login'])) {
  $user = new User();

  $user_email = htmlspecialchars(strip_tags($_POST['user_email']));
  $password = htmlspecialchars(strip_tags($_POST['password']));

  $tryLogin = $user->logIn($user_email, $password);

  if (count($tryLogin) == 1) {
    header('Location: library.php');
  } else {
    $err = $tryLogin[1];
  }
}