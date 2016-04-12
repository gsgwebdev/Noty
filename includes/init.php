<?php
error_reporting(E_ALL);

require_once '../classes/User.class.php';
require_once  '../classes/Note.class.php';

session_start();

// Create user and note objects
$user = new User();
$note = new Note();


