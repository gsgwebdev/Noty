<?php

class Auth extends Controller {
  protected $user;
  protected $note;

  public function __construct() {
    // Create new instances
    $this->user = $this->model('User');
    $this->note = $this->model('Note');
  }

  public function index() {
    // Default method is login
    $this->login();
  }

  public function login() {
    $err = '';

    if (isset($_POST['login'])) {
      $user_email = htmlspecialchars(strip_tags($_POST['user_email']));
      $password = htmlspecialchars(strip_tags($_POST['password']));
      $tryLogin = $this->user->logIn($user_email, $password);

      if (count($tryLogin) == 1) {
        header('Location:' . setLink('library'));
      } else {
        $err = $tryLogin[1];
      }
    }

    $this->view('login', ['err'=>$err]);
  }

  public function register() {
    $initialValues = array('username'=>'', 'email'=>'', 'password'=>'', 'passwordConf'=>'');
    $form = $this->model('Form', $initialValues);

    /*
     * Set the fields and then retrieve
     * retrieve their values
    */
    $vals = $this->setRegisterFields($form);

    /*
     * If the values are in a valid format,
     * Try to register a new user
     */
    if ($vals['allFieldsOK']) {
      try {
        $query = "SELECT user_name, user_email FROM users WHERE user_name=:user OR user_email=:email";
        $stmt = $this->user->getConnection()->prepare($query);
        $stmt->execute(array(':user'=>$vals['username'], ':email'=>$vals['email']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['user_name'] == $vals['username']) {
          $error[] = 'Username already exists.';
        } else if ($row['user_email'] == $vals['username']) {
          $error[] = 'Email already exists.';
        } else {
          $this->user->signUp($vals['username'], $vals['email'], $vals['passwordHash']);
        }
      } catch (PDOException $e) {
        die('The register has failed. Error: ' . $e->getMessage());
      }

      // After registration, go to login page
      header('Location:' . setLink('auth'));
    }

    /*
     * Retrieve the values for the possible errors
     * and user/email
    */
    $data = $this->setRegisterData($form);

    $this->view('register', $data);
  }

  public function logout() {
    if($this->user->loggedIn()) {
      $this->user->logOut();
      header('Location:' . setLink('index'));
    }
  }

  protected function setRegisterFields($form) {
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

      return $data = ['passwordHash'=>$passwordHash, 'allFieldsOK'=>$allFieldsOK, 'username'=>$username, 'email'=>$email];
    }
  }

  protected function setRegisterData($form) {
    $values = $form->getFields();
    $userValue = $values['username'];
    $emailValue = $values['email'];

    $errors = $form->getFieldsErr();
    $nameErr = $errors['username'];
    $emailErr = $errors['email'];
    $passErr = $errors['password'];
    $passConfErr = $errors['passwordConf'];

    $valids = $form->getValidFields();
    $validUser = $valids['username'];
    $validEmail = $valids['email'];

    return $data = ['userValue'=>$userValue, 'emailValue'=>$emailValue, 'nameErr'=>$nameErr, 'emailErr'=>$emailErr,
             'passErr'=>$passErr, 'passConfErr'=>$passConfErr, 'validUser'=>$validUser, 'validEmail'=>$validEmail];

  }
}