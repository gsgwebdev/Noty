<?php
// Select the proper link if the user is guest or not
$homeLink = $user->loggedIn() ? 'library.php' : 'index.php';

echo "<a class='logo-txt' href='". $homeLink . "'>Noty</a>";