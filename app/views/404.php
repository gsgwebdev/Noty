<?php require_once '_partials/_head.php' ?>

<main class="main-404">
  <h1>Sorry.</h1>
  <h2>This page does not exist or you do not have access to it.</h2>
  <!-- Set the link to respect controller/method routing -->
  <a href="<?= setLink('auth', 'login') ?>">Login</a>
</main>

<?php require_once '_partials/_footer.php' ?>