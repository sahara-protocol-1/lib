<?php
session_start();
require './handler/function.php';

if(is_not_logged_in()){
    redirect_to('./index.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-regular.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
        <a class="navbar-brand d-flex align-items-center fw-500" href="./books.php"><img alt="logo" class="d-inline-block align-top mr-2" src="img/logo.png"> Библиотека </a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./books.php">Главная <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                
                <li class="nav-item">
                    <a class="nav-link" href="./handler/logout.php">Выйти</a>
                </li>
            </ul>
        </div>
    </nav>

    <main id="js-page-content" role="main" class="page-content mt-3">
    <?php if (isset($_SESSION['danger'])) {
                                display_flash_message("danger");
                            } elseif (isset($_SESSION['success'])) {
                                display_flash_message("success");
                            }
                            ?>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-plus-circle'></i> Добавить книгу
            </h1>

        </div>
        <form action="./handler/create_handler.php" method="post">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-content">

                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Название книги</label>
                                    <input type="text" id="simpleinput" name="book_name" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Год издания</label>
                                    <input type="text" id="simpleinput" name="publishing_year" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Автор</label>
                                    <input type="text" id="simpleinput" name="author" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Аннотация</label>
                                    <textarea id="simpleinput" name="annotation" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="col-md-12 mt-3 d-flex ">
                                        <button class="btn btn-success">Добавить</button>
                </div>

                
            </div>
        </form>
    </main>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

          
        });

    </script>
</body>
</html>