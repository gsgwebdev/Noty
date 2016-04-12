<?php
require_once 'includes/init.php';

if (!$user->loggedIn()) header("Location: wall.php");

$homeLink = $user->loggedIn() ? "library.php" : "index.php";

$titleErr = $authErr = $isbnErr = $rateErr = $linkErr = $coverErr = $introErr = $bodyErr = '';
$titleOK = $authOK = $isbnOK = $rateOK = $linkOK = $coverOK = $introOK = $bodyOK = false;
$validTitle = $validAuth = $validISBN = $validRate = $validLink = $validCover = $validIntro = $validBody = false;

if (isset($_POST['new'])) {

  $title = $_POST['title'];
  $author = $_POST['author'];
  $isbn = $_POST['isbn'];
  $rate = $_POST['rate'];
  $link = $_POST['link'];
  $cover = $_POST['cover'];
  $intro = $_POST['intro'];
  $body = $_POST['body'];

  if (empty($title)) {
    $titleErr = 'Please insert an author.';
  } else if (strlen($title) < 3) {
    $titleErr = 'The title should be longer than 3 characters.';
  } else if (strlen($title) > 256) {
    $titleErr = 'The title should should be shorter than 256 characters.';
  } else {
    $title = htmlspecialchars(strip_tags($_POST['title']));
    $titleOK = true;
    $validTitle = $_POST['title'];
  }

  if (empty($author)) {
    $authErr = 'Please insert an author.';
  } else if (strlen($author) < 3) {
    $authErr = 'The author should be longer than 3 characters.';
  } else if (strlen($author) > 76) {
    $authErr = 'The title should should be shorter than 76 characters.';
  } else {
    $author = htmlspecialchars(strip_tags($_POST['author']));
    $authOK = true;
    $validAuth = $_POST['author'];
  }

  if (empty($intro)) {
    $introErr = 'Please insert an introduction.';
  } else if (strlen($intro) < 51) {
    $introErr = 'The introduction should be longer than 50 characters.';
  } else if (strlen($intro) > 501) {
    $introErr = 'The introduction should should be shorter than 501 characters.';
  } else {
    $intro = htmlspecialchars(strip_tags($_POST['intro']));
    $introOK = true;
    $validIntro = $_POST['intro'];
  }

  if (empty($body)) {
    $bodyErr = 'Please insert the body of the note.';
  } else if (strlen($body) < 250) {
    $bodyErr = 'The body of the note should be longer than 250 characters.';
  } else {
    $body = htmlspecialchars(strip_tags($_POST['body']));
    $bodyOK = true;
    $validBody = $_POST['body'];
  }

  if (empty($isbn)) {
    $isbnErr = 'Please insert an ISBN.';
  } else if (strlen($isbn) != 10) {
    $isbnErr = 'The ISBN should contains 10 characters.';
  } else {
    $isbn = htmlspecialchars(strip_tags($_POST['isbn']));
    $isbnOK = true;
    $validISBN = $_POST['isbn'];
  }

  if (empty($rate)) {
    $rateErr = 'Please insert a rate.';
  } else if ($rate < 1 || $rate > 10) {
    $rateErr = 'The rate should be a number between 1 and 10.';
  } else {
    $rate = htmlspecialchars(strip_tags($_POST['rate']));
    $rateOK = true;
    $validRate = $_POST['rate'];
  }



  $regex = '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;\':<]|\.\s|$)#i';

  if (empty($link)) {
    $linkErr = 'Please insert an Amazon Link.';
  } else if(preg_match($regex, $link)) {
    $link = htmlspecialchars(strip_tags($_POST['link']));
    $linkOK = true;
    $validLink = $_POST['link'];
  }

  if (empty($cover)) {
    $coverErr = 'Please insert a Cover Link.';
  } else if(preg_match($regex, $cover)) {
    $cover = htmlspecialchars(strip_tags($_POST['cover']));
    $coverOK = true;
    $validCover = $_POST['cover'];
  } else {
    $coverErr = "There is a fucking error.";
  }

  if ($titleOK && $authOK && $isbnOK && $rateOK && $linkOK && $coverOK && $introOK && $bodyOK) {
    $userID = $user->getID();
    $note->addNote($userID, $title, $author, $isbn, $rate, $link, $cover, $intro, $body);
    header("Location: library.php");
  }
}



?>

<?php
  require_once '_partials/_head.html';
?>

<div class="wrapper-login">
  <header>
    <div class="logo-wrapper">
      <div class="logo"></div>
      <?php
        echo "<a class='logo-txt' href='". $homeLink . "'>Noty</a>";
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