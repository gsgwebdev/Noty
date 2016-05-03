<header>
  <div class="logo-wrapper">
    <!-- Set the link to respect controller/method routing -->
    <a class="logo-txt" href="<?= setLink($data['homeLink']) ?>">Noty</a>
  </div> <!-- END logo-wrapper -->

  <div class="action-wrapper">
    <!-- Different menu links for guests and users -->
    <?php if ($data['loggedIn']) { ?>
      <a class="btn btn-l cta" href="<?= setLink('library', 'create') ?>">New note</a>
      <a class="btn btn-l" href="<?= setLink('library', 'myNotes') ?>">My notes</a>
      <a class="btn" href="<?= setLink('auth', 'logout') ?>">Log Out</a>
    <?php } else { ?>
      <h4>Not a member?</h4>
      <a class="btn" href="<?= setLink('auth', 'register') ?>">Sign Up</a>
    <?php } ?>
  </div> <!-- END action-wrapper -->
</header>