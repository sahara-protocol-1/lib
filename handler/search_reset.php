<?php
session_start();
require 'function.php';

if(!empty($_SESSION['search_result'])) {
    unset($_SESSION['search_result']);
}

redirect_to('../books.php');