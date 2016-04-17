<?php
  require_once 'processing/loginProcessing.php';
?>

<?php
  require_once '_partials/_head.html';
?>

<div class="wrapper-login">
  <header>
    <div class="logo-wrapper">
      <div class="logo"></div>
      <a class="logo-txt" href="index.php">Noty</a>
    </div>
    <div class="action-wrapper">
      <h4>Not a member?</h4>
      <a class="btn" href="sign_up.php">Sign Up</a>
    </div>
  </header>

  <main class="main-login">
    <h1>Member Login</h1>
    <form action="login.php" method="POST">

      <span class="error"> <?php echo $err; ?> </span>

      <label>
        <input type="text" placeholder="Username/Email" name="user_email"/>
      </label>
      <label>
        <input type="password" placeholder="Password" name="password"/>
      </label>
      <label>
        <input class="btn cta" type="submit" value="Login" name="login"/>
      </label>
    </form>
  </main>
</div>

<?php
  require_once '_partials/_footer.html';
?>