<?php require_once '_partials/_head.php' ?>

<div class="wrapper-login">
  <?php require_once '_partials/headers/_userHeader.php' ?>

  <main class="main-new">
    <h1>Create a new note</h1>

    <form method="POST">
      <label>
        <!-- PHP ATTRIBUTES INJECTION -->
        <input type="text" placeholder="Title" name="title" <?php if ($data['validTitle']) echo "value='{$data['validTitle']}'" ?> >
        <!-- DISPLAY ERROR IF IT EXISTS -->
         <span class="error"> <?= $data['titleErr'] ?> </span>
      </label>

      <label>
        <input type="text" placeholder="Author" name="author" <?php if ($data['validAuth']) echo "value='{$data['validAuth']}'" ?> >
        <span class="error"> <?= $data['authErr']; ?> </span>
      </label>

      <label>
        <input type="text" placeholder="ISBN" name="isbn" <?php if ($data['validISBN']) echo "value='{$data['validISBN']}'" ?> >
        <span class="error"> <?= $data['isbnErr'] ?> </span>
      </label>

      <label>
        <input type="text" placeholder="Rate" name="rate" <?php if ($data['validRate']) echo "value='{$data['validRate']}'" ?> >
        <span class="error"> <?= $data['rateErr']; ?> </span>
      </label>

      <label>
        <input type="text" placeholder="Amazon Link" name="link" <?php if ($data['validLink']) echo "value='{$data['validLink']}'" ?> >
        <span class="error"> <?= $data['linkErr'] ?> </span>
      </label>

      <label>
        <input type="text" placeholder="Cover Link" name="cover" <?php if ($data['validCover']) echo "value='{$data['validCover']}'" ?> >
        <span class="error"> <?= $data['coverErr'] ?> </span>
      </label>

      <label>
        <textarea name="intro" placeholder="Intro"><?php if ($data['validIntro']) echo $data['validIntro'] ?></textarea> <!-- Space between tags = WHITE SPACE -->
        <span class="error"> <?= $data['introErr'] ?> </span>
      </label>

      <label>
        <textarea name="body" placeholder="Note's Body"><?php if ($data['validBody']) echo $data['validBody']; ?></textarea> <!-- Space between tags = WHITE SPACE --></textarea>
        <span class="error"> <?= $data['bodyErr'] ?> </span>
      </label>

      <label>
        <input class="btn cta" type="submit" value="Create a new note" name="new">
      </label>
    </form>
  </main>
</div> <!-- END wrapper -->

<?php require_once '_partials/_footer.php' ?>