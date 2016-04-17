<?php
require_once 'processing/editProcessing.php'
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
      <h1>Edit the note</h1>
      <form action="edit.php" method="POST">

        <?php
          $stmt = $note->getNote($initISBN);
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          $errors = $form->getFieldsErr();
          $titleErr = $errors['title'];
          $authErr = $errors['author'];
          $isbnErr = $errors['isbn'];
          $rateErr = $errors['rate'];
          $linkErr = $errors['link'];
          $coverErr = $errors['cover'];
          $introErr = $errors['intro'];
          $bodyErr = $errors['body'];


          echo <<<EOT
            <label>
              <input type="text" placeholder="Title" name="title" value="{$row['book_title']}"/>
              <span class="error">$titleErr</span>
            </label>

            <label>
              <input type="text" placeholder="Author" name="author" value="{$row['book_author']}"/>
              <span class="error">$authErr</span>
            </label>

            <label>
              <input type="text" placeholder="ISBN" name="isbn" value="{$row['book_isbn']}"/>
              <span class="error">$isbnErr</span>
            </label>

            <label>
              <input type="text" placeholder="Rate" name="rate" value="{$row['book_rate']}"/>
              <span class="error">$rateErr</span>
            </label>

            <label>
              <input type="text" placeholder="Amazon Link" name="link" value="{$row['book_link']}"/>
              <span class="error">$linkErr</span>
            </label>

            <label>
              <input type="text" placeholder="Cover Link" name="cover" value="{$row['book_cover']}"/>
              <span class="error">$coverErr</span>
            </label>

            <label>
              <textarea name="intro" placeholder="Intro">{$row['book_intro']}</textarea>
              <span class="error"$introErr</span>
            </label>

            <label>
              <textarea name="body" placeholder="Note's Body">{$row['book_body']}</textarea>
              <span class="error">$bodyErr</span>
            </label>
EOT;
        ?>

        <label>
          <input class="btn cta" type="submit" value="Submit the edit" name="edit"/>
        </label>
      </form>
    </main>
  </div>

<?php
  require_once '_partials/_footer.html';
?>