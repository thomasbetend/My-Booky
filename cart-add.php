<?php

session_start();

if(empty($_SESSION)){

    header('location: index.php');

} else {
    
    include_once('functions.php');

    $id= testInput($_GET['id']);

    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory', 'root', '');
    
    /* binding and securizing id */
    $queryBook = 'SELECT price_book, book.id id, firstname, lastname, name FROM book LEFT JOIN author ON author.id=book.author_id where book.id = :id';
    $statementBook = $pdo->prepare($queryBook);
    $statementBook->bindValue(':id', $id, PDO::PARAM_INT);
    $statementBook->execute();
    $book = $statementBook->fetch();
    
    $_SESSION['cart']['quantity'][$id]+=1;
    $_SESSION['cart']['price'][$id]+=$book['price_book'];
    
    
    header('location: cart.php');
    exit();
}

