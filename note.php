<?php
require_once 'includes/init.php';

$homeLink = $user->loggedIn() ? "library.php" : "index.php";
?>

<?php
  require_once '_partials/_head.html';
?>

<div class="wrapper-note">
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

    <?php
      // For every note create a new section
      if (isset($_GET['book_isbn'])) {
        $noteStmt = $note->getNote($_GET['book_isbn']);
        while ($row = $noteStmt->fetch(PDO::FETCH_ASSOC)) {
          $body = nl2br($row['book_body']);
          echo <<< EOF
            <main class="main-note">

                <img src="{$row['book_cover']}">
                <h1>{$row['book_title']}</h1>
                <span>Author: {$row['book_author']}</span>
                <span>ISBN: {$row['book_isbn']}</span>
                <span>Rate: {$row['book_rate']}</span>
                <h2>Notes</h2>
                <div class="body">{$body}</div>

            </main>
EOF;
        }
      }
    ?>
</div>

<?php
  require_once '_partials/_footer.html';
?>