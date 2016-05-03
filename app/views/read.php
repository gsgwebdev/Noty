<?php require_once '_partials/_head.php' ?>

<div class="wrapper-note">
  <?php require_once '_partials/headers/_alternateHeader.php' ?>

  <main class="main-note">
    <img src="<?= $data['bookCover'] ?>">
    <h1><?= $data['bookTitle'] ?></h1>
    <span>Author: <?= $data['bookAuth'] ?></span>
    <span>ISBN: <?= $data['bookISBN'] ?></span>
    <span>Rate: <?= $data['bookRate'] ?></span>
    <h2>Notes</h2>
    <div class="body"><?= $data['bookBody'] ?></div>
  </main>
</div> <!-- END wrapper -->

<?php require_once '_partials/_footer.php' ?>
