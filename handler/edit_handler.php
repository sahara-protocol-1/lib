<?php
session_start();
require "./function.php";


$book_id = "";
if(isset($_SESSION['id'])) {
    $book_id = $_SESSION['id'];
    unset($_SESSION['id']);
}

$book_name = $_POST['book_name'];
$publishing_year = $_POST['publishing_year'];
$author = $_POST['author'];
$annotation = $_POST['annotation'];

if(data_fields_empty($book_name, $publishing_year, $author, $annotation)) {
    set_flash_message("danger", "заполните все поля");
    redirect_to("../edit.php?id=$book_id");
    exit;
};

update_book($book_id, $book_name, $publishing_year, $author, $annotation);

set_flash_message('success', 'Поправки успешно внесены');
redirect_to("../edit.php?id=$book_id");


?>