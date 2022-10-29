<?php

session_start();

if(empty($_SESSION)){

    header('location: index.php');

} else {
    
    include_once('functions.php');

    $id= testInput($_GET['id']);

    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

    $queryThumbup = 'SELECT like_book FROM book WHERE book.id = ' .$id;
    $statementGetThumbup = $pdo->query($queryThumbup);
    $getThumbup= $statementGetThumbup->fetch();
    
    $getThumbup['like_book']+=1;    

    var_dump($getThumbup['like_book']);

    $insertThumbup = 'UPDATE book SET like_book = :like_book WHERE id = ' . $id;
    $statementInsertThumbup = $pdo->prepare($insertThumbup);
    $statementInsertThumbup->bindValue(':like_book', $getThumbup['like_book'], \PDO::PARAM_STR);
    $statementInsertThumbup->execute();
    
    header('location: index.php');
    exit();
}

