<?php
// Include site wide variables and other configurations
require_once 'init.php';

/* Initialize the form object, the errors and validFields arrays
as blanks - at the beginning, we do not have any values
*/
$initialValues = ['title'=>'', 'author'=>'', 'isbn'=>'', 'rate'=>'', 'link'=>'', 'cover'=>'', 'intro'=>'', 'body'=>''];
$form = new Form($initialValues);
$form->setErrors($initialValues);
$form->setValid($initialValues);

// Get the initial ISBN code
$initISBN = $_REQUEST['isbn'];


if (isset($_POST['edit'])) {
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
  $allFieldsOK = $form->allFieldsOK();
  if ($allFieldsOK) {
  $fields = $form->getFields();
  $note->updateNote($initISBN, $fields['title'], $fields['author'], $fields['isbn'], $fields['rate'], $fields['link'], $fields['cover'], $fields['intro'], $fields['body']);
  header('Location: library.php');
  }
}