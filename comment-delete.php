<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBooky - Info sur le livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5474cfcdca.js" crossorigin="anonymous"></script>
</head>

<body class="d-flex flex-column h-100">


<?php

session_start();

if(empty($_SESSION)){

    header('location: index.php');

} else {

    include_once('functions.php');

    $id = testInput($_GET['id']);

    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

    /* verifying if comment exists */

    $queryExistingComment = 'SELECT id, book_id FROM comment WHERE id = ' . $id;
    $statementExistingComment = $pdo->query($queryExistingComment);
    $existingComment = $statementExistingComment->fetch();

    if($existingComment){

        $queryDeleteComment = 'DELETE FROM comment WHERE id = ' . $existingComment['id'];
        $statementDeleteComment = $pdo->prepare($queryDeleteComment);
        $statementDeleteComment->execute();
    
        header('location:book-info.php?id=' . $existingComment['book_id']);
        exit();

    } else { ?>     
     
        <div class="container w-50 text-center">
            <h3 class="text-center text-primary mt-5">Page inexistante</h3>
            <a href="index.php" class="text-center">Retour au catalogue</a>
        </div>

    <?php } ?>
    
</body>
</html>

<?php } ?>