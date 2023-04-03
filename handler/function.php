<?php
function dd($a) {
    echo "<pre>";
    var_dump($a);
    exit;
}

$setting = [
    'host' => '127.0.0.1:3306',
    'database' => 'library',
    'username' => 'root',
    'password' => '',
];

function connecting() {
    global $setting;
    return new PDO("mysql:host=". $setting['host'] ."; dbname=". $setting['database'], $setting['username'], $setting['password']);
}

function redirect_to($path) {
    header("Location: $path");
    exit;
};

function get_user_by_username($username) { 
    $pdo = connecting();
    $sql = 'SELECT * FROM users WHERE username=:hohoho';
    $statement = $pdo->prepare($sql);
    $statement->execute(['hohoho' => $username]);
    return $statement->fetch(PDO::FETCH_ASSOC);
};

function get_book_by_id($id) { 
    $pdo = connecting();
    $sql = 'SELECT * FROM books WHERE id=:hohoho';
    $statement = $pdo->prepare($sql);
    $statement->execute(['hohoho' => $id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
};

function get_books($limit, $offset) { 
    $pdo = connecting();
    $sql = "SELECT * FROM `books` ORDER BY `book_name` ASC LIMIT $limit OFFSET $offset";
    $statement = $pdo->query($sql);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
};

function delete_book($id) { 
    $pdo = connecting();
    $sql = "DELETE FROM books WHERE id=:hohoho";
    $statement = $pdo->prepare($sql);
    $statement->execute(['hohoho' => $id]);
};

function create_new_book($book_name, $publishing_year, $author, $annotation) { 
    $pdo = connecting();
    $sql = 'INSERT INTO books (book_name, publishing_year, author, annotation) VALUE (:book_name, :publishing_year, :author, :annotation)';
    $statement = $pdo->prepare($sql);
    $statement->execute(['book_name' => $book_name, 'publishing_year' => $publishing_year, 'author' => $author, 'annotation' => $annotation]);

    return $pdo->lastInsertId();
};

function update_book($book_id, $book_name, $publishing_year, $author, $annotation) { 
    $pdo = connecting();
    $sql = 'UPDATE books SET book_name=(:book_name), publishing_year=(:publishing_year), author=(:author), annotation=(:annotation) WHERE id=:id';
    $statement = $pdo->prepare($sql);
    $statement->execute(['book_name' => $book_name, 'publishing_year' => $publishing_year, 'author' => $author, 'annotation' => $annotation, 'id' => $book_id]);
};

function set_flash_message($error, $message){ 
    $_SESSION[$error] = $message;
};

function display_flash_message($name) { 
    if(isset($_SESSION[$name])) {
    echo "<div class='alert alert-{$name} text-dark' role='alert'>
            <strong>{$_SESSION[$name]}</strong>
            </div>" ;
            unset($_SESSION[$name]);
        }; 
};

function is_logged_in() { 
    if(isset($_SESSION['user'])){
        return true;
    }

    return false;
};

function is_not_logged_in() { 
    return !is_logged_in();
};

function data_fields_empty($book_name, $publishing_year, $author, $annotation) { 
    if(empty($book_name) || empty($publishing_year) || empty($author) || empty($annotation)) {
        return true;
    };
}

function count_row($table) { 
    $pdo = connecting();
    $sql = "SELECT COUNT(*) FROM $table"; 
    $statement = $pdo->prepare($sql);
    $statement->execute();
    return $statement->fetchColumn();
}

function get_data_protect($page, $total_pages) { 
    if($page > $total_pages) { 
        $page = floatval(1);
        redirect_to('./books.php');
    } 
}

function search_validation($data) { 
    if(empty($data)){
        set_flash_message("danger", "заполните поле поиска");
        redirect_to('../books.php');
    } else {
        $words = trim($data);
        $words = preg_replace('/[^\p{L}\p{N}\s]/u', '', $words);
        $words = explode(" ", $words);
        $words = array_filter($words, function($value) {
            return !empty($value);
        });
        if (empty($words)) {
            set_flash_message("danger", "заполните поле поиска");
            redirect_to('../books.php');
            exit;
        }
        return $words;
    }
}

?>


