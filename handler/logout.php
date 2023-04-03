<?php
session_start();
require 'function.php';

unset($_SESSION['user']);
redirect_to('../index.php');


?>