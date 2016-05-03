<?php require_once '_partials/_head.php' ?>

<div class="wrapper-signup">
  <?php require_once '_partials/headers/_registerHeader.php' ?>

  <main class="main-signup">
    <h1>Create a new account</h1>

    <form id="form-signup" method="POST">
      <label>
        <!-- PHP ATTRIBUTES INJECTION -->
        <input type="text" placeholder="Username" name="username" id="username" <?php if ($data['validUser']) echo "value='{$data['userValue']}'" ?> >
        <!-- DISPLAY ERROR IF IT EXISTS -->
        <span class="error"> <?php echo $data['nameErr'] ?> </span>
      </label>

      <label for="email">
        <input type="text" placeholder="Email" name="email" id="email" <?php if ($data['validEmail']) echo "value='{$data['emailValue']}'" ?> >
        <span class="error"> <?php echo $data['emailErr'] ?> </span>
      </label>

      <label for="password">
        <input type="password" placeholder="Password" name="password" id="password">
        <span class="error"> <?php echo $data['passErr'] ?> </span>
      </label>

      <label for="password-confirm">
        <input type="password" placeholder="Repeat Password" name="password-confirm" id="password-confirm">
        <span class="error"> <?php echo $data['passConfErr'] ?> </span>
      </label>

      <label>
        <input class="btn cta" type="submit" value="Sign Up" name="signUp">
      </label>
    </form>
  </main>
</div> <!-- END wrapper -->

<?php require_once '_partials/_footer.php' ?>