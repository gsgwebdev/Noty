<?php
  require_once 'processing/signupProcessing.php';
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
                  $errors = $form->getFieldsErr();
                  $nameErr = $errors['username'];
                  $emailErr = $errors['email'];
                  $passErr = $errors['password'];
                  $passConfErr = $errors['passwordConf'];

                  $valids = $form->getValidFields();
                  $validUser = $valids['username'];
                  $validEmail = $valids['email'];

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