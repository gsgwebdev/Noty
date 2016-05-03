<?php require_once '_partials/_head.php' ?>

<div class="wrapper-login">
  <?php require_once '_partials/headers/_userHeader.php' ?>

  <main class="main-new">
    <h1>Edit the note</h1>

    <form method="POST">
      <label>
        <!-- PHP ATTRIBUTES INJECTION -->
        <input type="text" placeholder="Title" name="title" value="<?= $data['bookTitle'] ?>">
        <!-- DISPLAY ERROR IF IT EXISTS -->
        <span class="error"><?= $data['titleErr'] ?></span>
      </label>

      <label>
        <input type="text" placeholder="Author" name="author" value="<?= $data['bookAuth'] ?>">
        <span class="error"><?= $data['authErr'] ?></span>
      </label>

      <label>
        <input type="text" placeholder="ISBN" name="isbn" value="<?= $data['bookISBN'] ?>">
        <span class="error"><?= $data['isbnErr'] ?></span>
      </label>

      <label>
        <input type="text" placeholder="Rate" name="rate" value="<?= $data['bookRate'] ?>">
        <span class="error"><?= $data['rateErr'] ?></span>
      </label>

      <label>
        <input type="text" placeholder="Amazon Link" name="link" value="<?= $data['bookLink'] ?>">
        <span class="error"><?= $data['linkErr'] ?></span>
      </label>

      <label>
        <input type="text" placeholder="Cover Link" name="cover" value="<?= $data['bookCover'] ?>">
        <span class="error"><?= $data['coverErr'] ?></span>
      </label>

      <label>
        <textarea name="intro" placeholder="Intro"><?= $data['bookIntro'] ?></textarea>
        <span class="error"><?= $data['introErr'] ?></span>
      </label>

      <label>
        <textarea name="body" placeholder="Note's Body"><?= $data['bookBody'] ?></textarea>
        <span class="error"><?= $data['bodyErr'] ?></span>
      </label>

      <label>
        <input class="btn cta" type="submit" value="Submit the edit" name="edit">
      </label>
    </form>
  </main>
</div> <!-- END wrapper -->

<?php require_once '_partials/_footer.php' ?>