<?php
session_start();
require './function.php';

$sql = "SELECT * FROM books WHERE ";



$words = search_validation($_POST['search']);

foreach($words as $key =>$value) {
    if($key != NULL && $key != "") {
        $sql .= "OR ";
    }

    $sql .= "CONCAT(`book_name`, `publishing_year`, `annotation`, `author`) LIKE '%$value%'";
}   




$pdo = connecting();
$statement = $pdo->prepare($sql);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if(empty($result)) {
    set_flash_message("danger", "по запросу ни чего не найдено");
    redirect_to('../books.php');
    exit;
} else {
    $_SESSION['search_result'] = $result;
    redirect_to('../books.php');
}



