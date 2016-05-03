<?php require_once '_partials/_head.php'; ?>

<main class="main-index">
  <div class="wrap-index">
    <p class="tagline">Do you want to read <span class="b">ONLY</span> the important information from a book?</p>
    <!-- Set the link to respect controller/method routing -->
    <a href="<?= setLink('library') ?>" class="btn">Browse</a>
    <a href="<?= setLink('auth', 'register') ?>" class="btn cta">Sign Up</a>
    <a href="<?= setLink('auth', 'login') ?>" class="implicit">Do you already have an account?</a>
  </div> <!-- END wrapper -->
</main>

<?php require_once '_partials/_footer.php' ?>