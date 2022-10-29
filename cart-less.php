<?php

session_start();

if(empty($_SESSION)){

    header('location: index.php');

} else {

include_once('functions.php');

$id= testInput($_GET['id']);

$pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

$queryBook = 'SELECT price_book, book.id id, firstname, lastname, name FROM book LEFT JOIN author ON author.id=book.author_id WHERE book.id = ' .$id;
$statementBook = $pdo->query($queryBook);
$book = $statementBook->fetch();

if($_SESSION['cart']['quantity'][$id] > 0){$_SESSION['cart']['quantity'][$_GET['id']]-=1;};
if($_SESSION['cart']['price'][$id] > 0){$_SESSION['cart']['price'][$_GET['id']]-=$book['price_book'];};

header('location: cart.php');
exit();

}
