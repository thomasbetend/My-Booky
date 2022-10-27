<?php
session_start();

$pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

$queryExistingAuthors = 'SELECT firstname, lastname, author_id, book.id id, name, sumup FROM book LEFT JOIN author ON author.id=book.author_id';
$statementExistingAuthors = $pdo->query($queryExistingAuthors);
$authors = $statementExistingAuthors->fetchAll(); 

if(!empty(($_POST['authorLastname'])) && (!empty($_POST['bookPrice'])) && (((!empty($_POST['bookName']))) || !empty($_POST['author_id']))){

    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

    if(!empty($_POST['bookName']) && empty($_POST['author_id'])){

        $queryAuthor = 'INSERT INTO author (firstname, lastname) VALUES (:firstname, :lastname)';

        include_once('functions.php');

        $lastname = testInput($_POST['authorLastname']);
        $firstname = testInput($_POST['authorFirstname']);

        $statementAuthor = $pdo->prepare($queryAuthor);

        $statementAuthor->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statementAuthor->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

        $statementAuthor->execute();

        $queryIdAuthor = 'SELECT id FROM author ORDER BY id DESC';
        $statementIdAuthor = $pdo->query($queryIdAuthor);
        $authorId = $statementIdAuthor->fetch();

        $queryBook = 'INSERT INTO book (name, author_id, price_book, sumup) VALUES(:bookname, :bookauthorid, :bookprice, :sumup)';

        $statementBook = $pdo->prepare($queryBook);

        $statementBook->bindValue(':bookname', $bookName, \PDO::PARAM_STR);
        $statementBook->bindValue(':bookauthorid', $authorId[0], \PDO::PARAM_STR);
        $statementBook->bindValue(':bookprice', $bookPrice, \PDO::PARAM_STR);
        $statementBook->bindValue(':sumup', $bookSumup, \PDO::PARAM_STR);

        $statementBook->execute();

    }

    if(!empty($_POST['author_id']) && empty($_POST['bookName'])){

        $queryBook = 'INSERT INTO book (name, author_id, price_book, sumup) VALUES(:bookname, :bookauthorid, :bookprice, :sumup)';

        $statementBook = $pdo->prepare($queryBook);

        $statementBook->bindValue(':bookname', $bookName, \PDO::PARAM_STR);
        $statementBook->bindValue(':bookauthorid', $_POST['author_id'], \PDO::PARAM_STR);
        $statementBook->bindValue(':bookprice', $bookPrice, \PDO::PARAM_STR);
        $statementBook->bindValue(':sumup', $bookSumup, \PDO::PARAM_STR);

        $statementBook->execute();

    }

}

