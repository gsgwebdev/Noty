<?php
  require_once 'init.php';
?>

<?php
  require_once '_head.html';
?>

<div class="wrapper-library">
  <header>
    <div class="logo-wrapper">
      <div class="logo"></div>
      <?php
      require_once 'head_link.php'
      ?>
    </div>
    <div class="action-wrapper">
      <?php
        if ($user->loggedIn()) {
      ?>
        <a class="btn btn-l cta" href="new.php">New note</a>
        <a class="btn btn-l" href="my_notes.php">My notes</a>
        <a class="btn" href="logout.php">Log Out</a>
      <?php
        } else {
      ?>
        <h4>Not a member?</h4>
        <a class="btn" href="sign_up.php">Sign Up</a>
      <?php
        }
      ?>
    </div>
  </header>

  <main class="main-library">
    <?php
      // For every note create a new section
      $stmt = $note->allNotes();

      if($stmt->execute()) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo <<< EOF
              <section class="unit-wrap">
                <a href="note.php?book_isbn={$row['book_isbn']}">
                  <img src="{$row['book_cover']}" alt="Cover"/>
                </a>
                <a href="note.php?book_isbn={$row['book_isbn']}" class="book-title">{$row['book_title']}</a>
                <span class="book-details">Author: {$row['book_author']}</span>
                <span class="book-details">ISBN: {$row['book_isbn']}</span>
                <span class="book-details">Rate: {$row['book_rate']}/10</span>
                <span class="book-details"><a href="{$row['book_link']}">Buy the book</a></span>
                <span class="intro">{$row['book_intro']}</span>
EOF;

        if ($row['book_userID'] == $userID){
          echo <<< EOF
              <div class="controllers-wrapper">
                <span class="book-details"><a href="edit.php?isbn={$row['book_isbn']}">edit</a></span>
                <span class="book-details"><a class="delete" href="delete.php?isbn={$row['book_isbn']}">delete</a></span>
              </div>
EOF;
          }
            echo "</section>";
        }
      }
    ?>
  </main>
</div>
<?php
  require_once '_footer.html';
?>