<?php

class Library extends Controller {
  protected $user;
  protected $note;

  protected $homeLink;
  protected $loggedIn;
  protected $userID;

  public function __construct() {
    // Instantiate the objects
    $this->user = $this->model('User');
    $this->note = $this->model('Note');

    // Set wide config vars
    $this->homeLink = $this->user->getHomeLink();
    $this->loggedIn = $this->user->loggedIn();
    $this->userID = $this->user->getID();
  }

  public function index() {
    $allNotes = $this->note->allNotes();

    $data = ['user'=>$this->user, 'note'=>$this->note, 'homeLink'=>$this->homeLink, 'userID'=>$this->userID,
      'loggedIn'=>$this->loggedIn, 'allNotes'=>$allNotes];

    $this->view('library', $data);
  }

  public function create() {
    /* Initialize the form object,
     * as blanks - at the beginning, we do not have any values
    */
    $initialValues = ['title'=>'', 'author'=>'', 'isbn'=>'', 'rate'=>'', 'link'=>'', 'cover'=>'', 'intro'=>'', 'body'=>''];
    $form = $this->model('Form', $initialValues);

    if (isset($_POST['new'])) {
      $allFieldsOK = $this->fieldsInValidFormat($form);

      if ($allFieldsOK) {
        $fields = $form->getFields();
        $this->note->addNote($this->userID, $fields['title'], $fields['author'], $fields['isbn'], $fields['rate'], $fields['link'], $fields['cover'], $fields['intro'], $fields['body']);
        header('Location:' . setLink('library'));
      }
    }

    $data = $this->retrieveFieldsValues($form);
    $data['loggedIn'] = $this->loggedIn;

    $this->view('create', $data);
  }

  public function myNotes() {
    $userNotes = $this->note->userNotes($this->userID);

    $data = ['userNotes'=>$userNotes, 'userID'=>$this->userID, 'loggedIn'=>$this->loggedIn, 'homeLink'=>$this->homeLink];

    $this->view('myNotes', $data);
  }

  public function read($isbn=0) {
    if ($isbn) {
      $stmt = $this->note->getNote($isbn);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $bookCover = $row['book_cover'];
      $bookTitle = $row['book_title'];
      $bookAuth = $row['book_author'];
      $bookISBN = $row['book_isbn'];
      $bookRate = $row['book_rate'];
      $bookBody = nl2br($row['book_body']);

      $data = ['bookCover'=>$bookCover, 'bookTitle'=>$bookTitle, 'bookAuth'=>$bookAuth,
        'bookISBN'=>$bookISBN, 'bookRate'=>$bookRate, 'bookBody'=>$bookBody,
        'loggedIn'=>$this->loggedIn, 'homeLink'=>$this->homeLink];

      $this->view('read', $data);
    } else {
      header('Location:' . setLink('library'));
    }
  }

  public function edit($isbn) {
    /* Initialize the form object, the errors and validFields arrays
     * as blanks - at the beginning, we do not have any values
    */
    $initialValues = ['title'=>'', 'author'=>'', 'isbn'=>'', 'rate'=>'', 'link'=>'', 'cover'=>'', 'intro'=>'', 'body'=>''];
    $form = $this->model('Form', $initialValues);

    if (isset($_POST['edit'])) {
      // Set the fields and check if their validity
      $allFieldsOK = $this->fieldsInValidFormat($form);

      if ($allFieldsOK) {
        $fields = $form->getFields();
        $this->note->updateNote($isbn, $fields['title'], $fields['author'], $fields['isbn'], $fields['rate'], $fields['link'], $fields['cover'], $fields['intro'], $fields['body']);
        header('Location:' . setLink('library'));
      }
    }

    $stmt = $this->note->getNote($isbn);
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

    $bookTitle = $row['book_title'];
    $bookAuth = $row['book_author'];
    $bookISBN = $row['book_isbn'];
    $bookRate = $row['book_rate'];
    $bookCover = $row['book_cover'];
    $bookLink = $row['book_link'];
    $bookIntro = $row['book_intro'];
    $bookBody = $row['book_body'];


    $data = ['titleErr'=>$titleErr, 'authErr'=>$authErr, 'isbnErr'=>$isbnErr, 'rateErr'=>$rateErr,
      'linkErr'=>$linkErr, 'coverErr'=>$coverErr, 'introErr'=>$introErr, 'bodyErr'=>$bodyErr,
      'bookTitle'=>$bookTitle, 'bookAuth'=>$bookAuth, 'bookISBN'=>$bookISBN, 'bookRate'=>$bookRate,
      'bookCover'=>$bookCover, 'bookLink'=>$bookLink, 'bookIntro'=>$bookIntro, 'bookBody'=>$bookBody,
      'loggedIn'=>$this->loggedIn, 'homeLink'=>$this->homeLink, 'loggedIn'=>$this->loggedIn];

    $this->view('edit', $data);
  }

  public function delete($isbn) {
    if ($this->loggedIn) {
      $this->note->deleteNote($isbn);
      header('Location:' . setLink('library'));
    } else {
      header('Location:' . setLink('errors'));
    }
  }

  protected function fieldsInValidFormat($form) {
    // Set the field from '' to new values
    $form->setField('title', $_POST['title']);
    $form->setField('author', $_POST['author']);
    $form->setField('isbn', $_POST['isbn']);
    $form->setField('rate', $_POST['rate']);
    $form->setField('link', $_POST['link']);
    $form->setField('cover', $_POST['cover']);
    $form->setField('intro', $_POST['intro']);
    $form->setField('body', $_POST['body']);

    // Testing the string
    $form->strValidation(3, 255, 'title');
    $form->strValidation(3, 75, 'author');
    $form->strValidation(50, 500, 'intro');
    $form->strValidation(500, 25000, 'body');

    /* Testing the numbers
    if the fourth argument is true,
    it refers to the length of the value;
    otherwise, it refers to a range
    */
    $form->numValidation(false, 10, 'isbn', true);
    $form->numValidation(1, 10, 'rate', false);

    // Testing the links
    $form->linkValidation('link');
    $form->linkValidation('cover');

    // If all the fields are valid, then sent to DB
    return $allFieldsOK = $form->allFieldsOK();
  }

  protected function retrieveFieldsValues($form) {
    // Get errors and store them into vars
    $errors = $form->getFieldsErr();
    $titleErr = $errors['title'];
    $authErr = $errors['author'];
    $isbnErr = $errors['isbn'];
    $rateErr = $errors['rate'];
    $linkErr = $errors['link'];
    $coverErr = $errors['cover'];
    $introErr = $errors['intro'];
    $bodyErr = $errors['body'];

    // Get the valid values and store them into vars
    $valids = $form->getValidFields();
    $validTitle = $valids['title'];
    $validAuth = $valids['author'];
    $validISBN = $valids['isbn'];
    $validRate = $valids['rate'];
    $validLink = $valids['link'];
    $validCover = $valids['cover'];
    $validIntro = $valids['intro'];
    $validBody = $valids['body'];

    return $data = ['titleErr'=>$titleErr, 'authErr'=>$authErr, 'isbnErr'=>$isbnErr, 'rateErr'=>$rateErr, 'linkErr'=>$linkErr,
      'coverErr'=>$coverErr, 'introErr'=>$introErr, 'bodyErr'=>$bodyErr, 'validTitle'=>$validTitle,
      'validAuth'=>$validAuth, 'validISBN'=>$validISBN, 'validRate'=>$validRate, 'validLink'=>$validLink,
      'validCover'=>$validCover, 'validIntro'=>$validIntro, 'validBody'=>$validBody, 'homeLink'=>$this->homeLink];
  }
}