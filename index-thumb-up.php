<?php

session_start();

if(empty($_SESSION)){

    header('location: index.php');

} else {
    
    include_once('functions.php');

    $id= testInput($_GET['id']);

    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

    /* increment total of likes */

    /* verify likes_id and user_id in likes_user for this book */

    $queryVerifyLikesUser = 'SELECT book_id, likes_id, user_id, total FROM likes_user lu LEFT JOIN likes ON likes.id = lu.likes_id WHERE book_id = ' . $id . ' AND user_id = ' . $_SESSION['id'];
    $statementVerifyLikesUser = $pdo->query($queryVerifyLikesUser);
    $verifyLikesUser= $statementVerifyLikesUser->fetch();

    /* if existing likes_id and likes_user, do nothing */

    /* if not existing */

    if(empty($verifyLikesUser)){

        /* get total likes */

        $queryThumbup = 'SELECT id, total FROM likes WHERE book_id = ' . $id;
        $statementThumbup = $pdo->query($queryThumbup);
        $thumbup = $statementThumbup->fetch();

        /* add a like */

        $thumbup['total'] += 1;

        /* insert new likes_id and user_id in likes_user */

        $queryLikesUser = 'INSERT INTO likes_user (likes_id, user_id) VALUES(:likesid, :userid)';
        $statementLikesUser = $pdo->prepare($queryLikesUser);
        $statementLikesUser->bindValue(':likesid', $thumbup['id'], \PDO::PARAM_INT);
        $statementLikesUser->bindValue(':userid', $_SESSION['id'], \PDO::PARAM_INT);
        $statementLikesUser->execute();

        /* insert new total ok likes */

        $insertThumbup = 'UPDATE likes SET total = :total WHERE book_id = ' .$id;
        $statementInsertThumbup = $pdo->prepare($insertThumbup);
        $statementInsertThumbup->bindValue(':total', $thumbup['total'], \PDO::PARAM_INT);
        $statementInsertThumbup->execute();

    }
    
    header('location: index.php');
    exit();
}

