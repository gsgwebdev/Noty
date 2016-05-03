<?php require_once '_partials/_head.php' ?>

<div class="wrapper-library">
  <?php require_once '_partials/headers/_alternateHeader.php' ?>

  <main class="main-library">
      <?php
      $stmt = $data['userNotes'];
      require_once '_partials/_books.php';
    ?>
  </main>
</div> <!-- END wrapper -->

<?php require_once '_partials/_footer.php' ?>