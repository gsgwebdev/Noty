<?php
  require_once 'processing/newProcessing.php';
?>

<?php
  require_once '_partials/_head.html';
?>

<div class="wrapper-login">
  <header>
    <div class="logo-wrapper">
      <div class="logo"></div>
      <?php
        if (!$user->loggedIn()) header('Location: 404.php');
      require_once '_partials/head_link.php'
      ?>
    </div>
    <div class="action-wrapper">
      <a class="btn btn-l" href="library.php">Library</a>
      <a class="btn btn-l" href="my_notes.php">My notes</a>
      <a class="btn" href="logout.php">Log Out</a>
    </div>
  </header>

  <main class="main-new">
    <h1>Create a new note</h1>
    <form action="new.php" method="POST">
      <label>
        <input type="text" placeholder="Title" name="title"
          <?php
            if ($validTitle) echo "value='$validTitle'";
          ?>
          />
        <span class="error"> <?php echo $titleErr; ?> </span>
      </label>
      <label>
        <input type="text" placeholder="Author" name="author"
        <?php
          if ($validAuth) echo "value='$validAuth'";
        ?>
        />
        <span class="error"> <?php echo $authErr; ?> </span>
      </label>
      <label>
        <input type="text" placeholder="ISBN" name="isbn"
        <?php
          if ($validISBN) echo "value='$validISBN'";
        ?>
        />
        <span class="error"> <?php echo $isbnErr; ?> </span>
      </label>
      <label>
        <input type="text" placeholder="Rate" name="rate"
        <?php
          if ($validRate) echo "value='$validRate'";
        ?>
        />
        <span class="error"> <?php echo $rateErr; ?> </span>
      </label>
      <label>
        <input type="text" placeholder="Amazon Link" name="link"
        <?php
         if ($validLink) echo "value='$validLink'";
        ?>
        />
        <span class="error"> <?php echo $linkErr; ?> </span>
      </label>
      <label>
        <input type="text" placeholder="Cover Link" name="cover"
        <?php
          if ($validCover) echo "value='$validCover'";
        ?>
        />
        <span class="error"> <?php echo $coverErr; ?> </span>
      </label>
      <label>
        <textarea name="intro" placeholder="Intro"><?php if ($validIntro) echo $validIntro; ?></textarea> <!-- Space between tags = WHITE SPACE -->
        <span class="error"> <?php echo $introErr; ?> </span>
      </label>
      <label>
        <textarea name="body" placeholder="Note's Body"><?php if ($validBody) echo $validBody; ?></textarea> <!-- Space between tags = WHITE SPACE --></textarea>
        <span class="error"> <?php echo $bodyErr; ?> </span>
      </label>
      <label>
        <input class="btn cta" type="submit" value="Create a new note" name="new"/>
      </label>
    </form>
  </main>
</div>

<?php
  require_once '_partials/_footer.html';
?>