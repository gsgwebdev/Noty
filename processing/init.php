<?php
error_reporting(E_ALL);

require_once 'classes/User.class.php';
require_once 'classes/Note.class.php';
require_once 'classes/Form.class.php';

session_start();

// Create user, form and note objects
$user = new User();
$note = new Note();

// Get the ID of the user
$userID = $user->getID();



