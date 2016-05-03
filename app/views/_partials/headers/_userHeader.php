<header>
  <div class="logo-wrapper">
    <!-- ACCESS FORBIDDEN FOR GUESTS -->
    <?php if (!$data['loggedIn']) header('Location:' . setLink('errors')) ?>
    <!-- Set the link to respect controller/method routing -->
    <a class="logo-txt" href="<?= setLink($data['homeLink']) ?>">Noty</a>
  </div> <!-- END logo-wrapper -->

  <div class="action-wrapper">
    <a class="btn btn-l" href="<?= setLink('library') ?>">Library</a>
    <a class="btn btn-l" href="<?= setLink('library', 'myNotes') ?>">My notes</a>
    <a class="btn" href="<?= setLink('auth', 'logout') ?>">Log Out</a>
  </div> <!-- END action-wrapper -->
</header>