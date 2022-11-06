<?php

session_start();

if(empty($_SESSION)){

    header('location: index.php');

} else {
    
    include_once('functions.php');

    $id= testInput($_GET['id']);

    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

/* increment total of likes */

    /* get total likes */

    $queryThumbup = 'SELECT id, total FROM likes WHERE book_id = :id';
    $statementThumbup = $pdo->prepare($queryThumbup);
    $statementThumbup->bindValue(':id', $id, PDO::PARAM_INT);
    $statementThumbup->execute();
    $thumbup = $statementThumbup->fetch();

    /* verify likes_id and user_id in likes_user for this book */

    $queryVerifyLikesUser = 'SELECT book_id, likes_id, likes_user.total lu_total, user_id, likes.total FROM likes_user LEFT JOIN likes ON likes.id = likes_user.likes_id WHERE book_id = :id AND user_id = ' . $_SESSION['id'];
    $statementVerifyLikesUser = $pdo->prepare($queryVerifyLikesUser);
    $statementVerifyLikesUser->bindValue(':id', $id, PDO::PARAM_INT);
    $statementVerifyLikesUser->execute();
    $verifyLikesUser = $statementVerifyLikesUser->fetch();

    /* if existing likes_id and likes_user, do nothing */

    /* if not existing */

    if(empty($verifyLikesUser)){

        /* add a like */

        $thumbup['total'] += 1;

        /* insert new likes_id, user_id and increment total in table likes_user */

        $queryLikesUser = 'INSERT INTO likes_user (likes_id, user_id, total) VALUES(:likesid, :userid, :total)';
        $statementLikesUser = $pdo->prepare($queryLikesUser);
        $statementLikesUser->bindValue(':likesid', $thumbup['id'], \PDO::PARAM_INT);
        $statementLikesUser->bindValue(':userid', $_SESSION['id'], \PDO::PARAM_INT);
        $statementLikesUser->bindValue(':total', 1, \PDO::PARAM_INT);
        $statementLikesUser->execute();

    } else if ($verifyLikesUser['lu_total'] === 0) {
        $thumbup['total'] += 1;

        $queryLikesUser = 'UPDATE likes_user SET total = :total WHERE likes_id = ' . $thumbup['id'] . ' AND user_id = ' . $_SESSION['id'];
        $statementLikesUser = $pdo->prepare($queryLikesUser);
        $statementLikesUser->bindValue(':total', 1, \PDO::PARAM_INT);
        $statementLikesUser->execute();

    } else if ($verifyLikesUser['lu_total'] === 1) {
        if($thumbup['total'] > 0){
            $thumbup['total'] -= 1;

            $queryLikesUser = 'UPDATE likes_user SET total = :total WHERE likes_id = ' . $thumbup['id'] . ' AND user_id = ' . $_SESSION['id'];
            $statementLikesUser = $pdo->prepare($queryLikesUser);
            $statementLikesUser->bindValue(':total', 0, \PDO::PARAM_INT);
            $statementLikesUser->execute();
        }
    }

    /* insert new total of likes */

    $insertThumbup = 'UPDATE likes SET total = :total WHERE book_id = ' .$id;
    $statementInsertThumbup = $pdo->prepare($insertThumbup);
    $statementInsertThumbup->bindValue(':total', $thumbup['total'], \PDO::PARAM_INT);
    $statementInsertThumbup->execute();

    header('location: index.php');
    exit();
}

