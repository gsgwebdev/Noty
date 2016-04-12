<?php
require_once 'includes/init.php';

$homeLink = $user->loggedIn() ? "library.php" : "index.php";

$userID = $user->getID();
?>

<?php
  require_once '_partials/_head.html'
?>

<div class="wrapper-library">
  <header>
    <div class="logo-wrapper">
      <div class="logo"></div>
      <?php
        echo "<a class='logo-txt' href='". $homeLink . "'>Noty</a>";
      ?>
    </div>
    <div class="action-wrapper">
      <?php
        if ($user->loggedIn()) {
      ?>
        <a class="btn btn-l" href="new.php">New note</a>
        <a class="btn btn-l" href="library.php">Library</a>
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
      $stmt = $note->userNotes($userID);

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo <<< EOF
         <section class="unit-wrap">
           <a href="#">
           <img src="{$row['book_cover']}" alt="Cover"/>
           </a>
           <a href="http://localhost:81/Noty/note.php?book_isbn={$row['book_isbn']}" class="book-title">{$row['book_title']}</a>
           <span class="book-details">ISBN: {$row['book_isbn']}</span>
           <span class="book-details">Author: {$row['book_author']}</span>
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
    ?>
  </main>
</div>

<?php
  require_once '_partials/_footer.html';
?>