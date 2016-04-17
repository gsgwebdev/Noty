<?php
// Include site wide variables and other configurations
require_once 'init.php';

$initalValues = array('username'=>'', 'email'=>'', 'password'=>'', 'passwordConf'=>'');
$form = new Form($initalValues);
$form->setErrors($initalValues);
$form->setValid($initalValues);

if (isset($_POST['signUp'])) {
  $form->setField('username', $_POST['username']);
  $form->setField('email', $_POST['email']);
  $form->setField('password', $_POST['password']);
  $form->setField('passwordConf', $_POST['password-confirm']);

  $form->strValidation(3, 50, 'username');
  $form->emailValidation('email');
  $passwordHash = $form->passwordVerification('password');
  $form->passwordConfirmation('passwordConf');


  $allFieldsOK = $form->allFieldsOK();
  $username = $form->getFields()['username'];
  $email = $form->getFields()['email'];
  if ($allFieldsOK) {
    try {
      $query = "SELECT user_name, user_email FROM users WHERE user_name=:user OR user_email=:email";
      $stmt = $user->getConnection()->prepare($query);
      $stmt->execute(array(':user'=>$username, ':email'=>$email));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($row['user_name'] == $username) {
        $error[] = 'Username already exists.';
      } else if ($row['user_email'] == $email) {
        $error[] = 'Email already exists.';
      } else {
        $user->signUp($username, $email, $passwordHash);
      }
    } catch (PDOException $e) {
      die('The register has failed. Error: ' . $e->getMessage());
    }
    header('Location: login.php');
  }
}