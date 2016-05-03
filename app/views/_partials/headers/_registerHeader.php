<header>
  <div class="logo-wrapper">
    <!-- Set the link to respect controller/method routing -->
    <a class="logo-txt" href="<?= setLink('index') ?>">Noty</a>
  </div> <!-- END logo-wrapper -->

  <div class="action-wrapper">
    <h4>Already a member?</h4>
    <a class="btn" href="<?= setLink('auth', 'login') ?>">Log In</a>
  </div> <!-- END action-wrapper -->
</header>