<?php require_once '_partials/_head.php' ?>

<div class="wrapper-login">
  <?php require '_partials/headers/_loginHeader.php' ?>

  <main class="main-login">
    <h1>Member Login</h1>

    <form method="POST">
      <!-- DISPLAY ERROR IF IT EXISTS -->
      <span class="error"><?= $data['err'] ?></span>

      <label>
        <input type="text" placeholder="Username/Email" name="user_email">
      </label>

      <label>
        <input type="password" placeholder="Password" name="password">
      </label>

      <label>
        <input class="btn cta" type="submit" value="Login" name="login">
      </label>
    </form>
  </main>
</div> <!-- END wrapper -->

<?php require_once '_partials/_footer.php' ?>