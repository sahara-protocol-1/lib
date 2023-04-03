<?php
session_start();
require './handler/function.php';

if(is_not_logged_in()) {
    redirect_to('./index.php');
}

$page = "";

if(empty($_GET['page']) || $_GET['page'] < 1) { // ДОДЕЛАТЬ ПРОВЕРКУ НА БУКВЫ И ЕСЛИ БОЛЬШЕ $total_pages
    $page = 1;
} else {
    $page = $_GET['page'];
}
if(ctype_digit($page) === false) { // проверка, если отправили текст или символы в get запрос
    $page = 1;
}

$limit = 5; // сколько мы будет выводить записей на страницу
$offset = $limit * ($page - 1); // отнимаем 1, потому что если не отнять, то переходя на 1ю страницу, мы всегда будет попадать на 2ю.
$total_database_rows = count_row('books');
$total_pages = ceil($total_database_rows / $limit); // получаем количество страниц пагинации, и десятичное значение после деления округляем в ближайшую сторону.
$page = floatval($page);

get_data_protect($page, $total_pages);

$books = "";

if(!empty($_SESSION['search_result'])) {
    $books = $_SESSION['search_result'];
} else {
    $books = get_books($limit, $offset);
}


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-4dF/hyG4a4xPpW+P5o/aG5O5O5fS8eM5Q2VeQ6yjKfRftc6JzlU6ZphLdyZIzxtOSDYn3M8InyKf71yFYb+g4A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
    <body class="mod-bg-1 mod-nav-link">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
            <a class="navbar-brand d-flex align-items-center fw-500" href="#"><img alt="logo" class="d-inline-block align-top mr-2" src="img/logo.png"> Библиотека </a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarColor02">
                
                <ul class="navbar-nav ml-auto">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="./handler/logout.php">Выйти</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main id="js-page-content" role="main" class="page-content mt-3">
            
            <div class="subheader">
                <h1 class="subheader-title">
                    Список книг
                </h1>
            </div>

            
            <?php if (isset($_SESSION['danger'])) {
                                display_flash_message("danger");
                            } elseif (isset($_SESSION['success'])) {
                                display_flash_message("success");
                            }
            ?>
                                   
            <div class="row">
                <div class="col-xl-12">
                    <a class="btn btn-success btn-lg" href="create_book.php">Добавить книгу</a>

                    <?php  if(!empty($_SESSION['search_result'])):?>
                
                    <a class="btn btn-info btn-lg" href="./handler/search_reset.php">Показать весь список книг</a>
                    
            <?php endif;?>

                    <div class="border-faded bg-faded p-3 mb-g d-flex mt-3">
                        <form class="form-inline w-100" action="./handler/search.php" method="post">
                            <div class="d-flex w-100">
                                <div class="flex-grow-1">
                                    <input type="text" name="search" class="form-control shadow-inset-2 form-control-lg w-100" placeholder="Найти книгу">
                                </div>
                                <div>
                                    <button class="btn btn-success btn-lg">Поиск</button>
                                </div>
                            </div>
                        </form>
                        <div class="btn-group btn-group-lg btn-group-toggle hidden-lg-down ml-3" data-toggle="buttons">
                            <label class="btn btn-default active">
                                <input type="radio" name="contactview" id="grid" checked="" value="grid"><i class="fas fa-table"></i>
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="contactview" id="table" value="table"><i class="fas fa-th-list"></i>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="js-contacts">

            <?php foreach($books as $book): ?>
                <div class="col-xl-4">
                    <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="oliver kopyov">
                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                            <div class="d-flex flex-row align-items-center">

                                    <div class="rounded-circle profile-image d-block mr-2" style="background-image:url('img/book.png'); background-size: cover;"></div>

                                <div class="info-card-text flex-1">
                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                    <?php echo $book['book_name'];?>
                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="edit.php?id=<?php echo $book['id'];?>">
                                            <i class="fa fa-edit"></i>
                                        Редактировать</a>
                                        <a href="./handler/del_handler.php?id=<?php echo $book['id'];?>" class="dropdown-item" onclick="return confirm('are you sure?');">
                                            <i class="fa fa-window-close"></i>
                                            Удалить
                                        </a>
                                    </div>
                                    
                                </div>
                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_1 > .card-body + .card-body" aria-expanded="false">
                                    <span class="collapsed-hidden">+</span>
                                    <span class="collapsed-reveal">-</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0 collapse show">
                            <div class="p-3">
                                <div class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fa-regular fa-calendar"></i> Год издания: <?php echo $book['publishing_year'];?>
                                </div>
                                <div class="mt-1 d-block fs-sm fw-400 text-dark">
                                    Автор: <?php echo $book['author'];?>
                                </div>
                                <div class="fs-sm fw-400 mt-4 text-muted">
                                    <i class="fas fa-map-pin mr-2"></i> <?php echo $book['annotation'];?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
                
            </div>

            <div>
                <?php include("./pagination.php");?>
            </div>
        </main>
     
        <!-- BEGIN Page Footer -->
        <footer class="page-footer" role="contentinfo">
            <div class="d-flex align-items-center flex-1 text-muted">
                <span class="hidden-md-down fw-700">Библиотека</span>
            </div>
            <div>
                <ul class="list-table m-0">
                    <li class="pl-3"><a href="#" class="text-secondary fw-700">About</a></li>
                </ul>
            </div>
        </footer>
        
    </body>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

            $('input[type=radio][name=contactview]').change(function()
                {
                    if (this.value == 'grid')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                        $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                        $('#js-contacts .js-expand-btn').addClass('d-none');
                        $('#js-contacts .card-body + .card-body').addClass('show');

                    }
                    else if (this.value == 'table')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                        $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                        $('#js-contacts .js-expand-btn').removeClass('d-none');
                        $('#js-contacts .card-body + .card-body').removeClass('show');
                    }

                });

                //initialize filter
                initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
        });

    </script>
</html>