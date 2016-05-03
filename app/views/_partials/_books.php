<?php

// For every note create a new section
if($stmt) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Set the links properly: controller/method/isbn
    $isbnReadLink = setLink('library', 'read') . '/' . $row['book_isbn'];
    $isbnEditLink = setLink('library', 'edit') . '/' . $row['book_isbn'];
    $isbnDeleteLink = setLink('library', 'delete') . '/' . $row['book_isbn'];

    echo <<< EOF
      <section class="unit-wrap">
        <img src="{$row['book_cover']}" alt="Cover"/>
        <a href="{$isbnReadLink}" class="book-title">{$row['book_title']}</a>
        <span class="book-details">Author: {$row['book_author']}</span>
        <span class="book-details">ISBN: {$row['book_isbn']}</span>
        <span class="book-details">Rate: {$row['book_rate']}/10</span>
        <span class="book-details"><a href="{$row['book_link']}">Buy the book</a></span>
        <span class="intro">{$row['book_intro']}</span>
EOF;

    if ($row['book_userID'] == $data['userID']){
      echo <<< EOF
        <div class="controllers-wrapper">
          <span class="book-details"><a href="{$isbnEditLink}">edit</a></span>
          <span class="book-details"><a class="delete" href="{$isbnDeleteLink}">delete</a></span>
        </div>
EOF;
    }
    echo "</section>";
  }
}



