<?php
require_once 'includes/init.php';

$nameErr = $emailErr = $passErr = $passConfErr = '';
$validUser =  $validEmail = '';


if (isset($_POST['signUp'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $passwordConf = $_POST['password-confirm'];

  $userOK = $emailOK = $passOK = $passConfOK = false;
  $validUser = $validEmail = false;

  if (empty($username)) {
    $nameErr = 'Please select a username.';
  } else if (strlen($username) < 3) {
    $nameErr = 'The name should have at least 3 characters.';
  } else {
    $username = htmlspecialchars(strip_tags($username));
    $validUser = $_POST['username'];
    $userOK = true;
  }

  if (empty($email)) {
    $emailErr = 'Please type your email.';
  } else {
    $email = htmlspecialchars(strip_tags($email));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = 'Invalid email format.';
    } else {
      $validEmail = $_POST['email'];
      $emailOK = true;
    }
  }

  if (empty($password)) {
    $passErr = 'Please select a password';
  } else if (strlen($password) < 6) {
    $passErr = 'The password should be longer than 6 characters.';
  } else {
    $password = htmlspecialchars(strip_tags($password));
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $passOK = true;
  }


  if (empty($passwordConf)) {
    $passConfErr = 'Please retype your password';
  } else if ($passwordConf != $password) {
    $passConfErr = 'The password does not match.';
  } else {
    $passConfOK = true;
  }

  $newUser = new User();

  if ($userOK && $passOK && $passConfOK && $emailOK) {
    try {
      $query = "SELECT user_name, user_email FROM users WHERE user_name=:user OR user_email=:email";
      $stmt = $newUser->getConnection()->prepare($query);
      $stmt->execute(array(':user'=>$username, ':email'=>$email));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($row['user_name'] == $username) {
        $error[] = "Username already exists.";
      } else if ($row['user_email'] == $email) {
        $error[] = "Email already exists.";
      } else {
        $newUser->signUp($username, $email, $passwordHash);
      }
    } catch (PDOException $e) {
        die("The register has failed. Error: " . $e->getMessage());
    }
    header("Location: login.php");
  }
}



?>

<?php
  require_once '_partials/_head.html';
?>

<div class="wrapper-signup">
  <header>
    <div class="logo-wrapper">
      <div class="logo"></div>
     <a class="logo-txt" href="index.php">Noty</a>
    </div>
    <div class="action-wrapper">
      <h4>Already a member?</h4>
      <a class="btn" href="login.php">Log In</a>
    </div>
  </header>

  <main class="main-signup">
    <h1>Create a new account</h1>

    <form id="form-signup" action="sign_up.php" method="POST">
      <label for="username">
        <input type="text" placeholder="Username" name="username" id="username"
               <?php
                  if ($validUser) echo "value='$validUser'";
               ?>
        />
        <span class="error"> <?php echo $nameErr; ?> </span>
      </label>
      <label for="email">
        <input type="text" placeholder="Email" name="email" id="email"
         <?php
            if ($validEmail) echo "value='$validEmail'";
         ?>
          />
        <span class="error"> <?php echo $emailErr; ?> </span>
      </label>
      <label for="password">
        <input type="password" placeholder="Password" name="password" id="password"/>
        <span class="error"> <?php echo $passErr; ?> </span>
      </label>
      <label for="password-confirm">
        <input type="password" placeholder="Repeat Password" name="password-confirm" id="password-confirm"/>
        <span class="error"> <?php echo $passConfErr; ?> </span>
      </label>
      <label>
        <input class="btn cta" type="submit" value="Sign Up" name="signUp"/>
      </label>
    </form>
  </main>
</div>

<?php
  require_once '_partials/_footer.html';
?>