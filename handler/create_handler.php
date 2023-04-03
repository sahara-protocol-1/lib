<?php
session_start();
require 'function.php';

$book_name = $_POST['book_name'];
$publishing_year = $_POST['publishing_year'];
$author = $_POST['author'];
$annotation = $_POST['annotation'];



if(data_fields_empty($book_name, $publishing_year, $author, $annotation)) {
    set_flash_message("danger", "заполните все поля");
    redirect_to('../create_book.php');
    exit;
};


create_new_book($book_name, $publishing_year, $author, $annotation);

set_flash_message('success', "книга успешно добавлена");

redirect_to('../create_book.php');

?>