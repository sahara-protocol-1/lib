<?php
session_start();
require "./function.php";

if(is_not_logged_in()) {
    redirect_to('./index.php');
}

$id = $_GET['id'];

delete_book($id);

set_flash_message('success', 'книга удалён');
redirect_to('../books.php');

?>