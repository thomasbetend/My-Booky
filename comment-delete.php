<?php 

$title="MyBooky";

require('head.php');

?>

<?php

session_start();

if(empty($_SESSION)){

    header('location: index.php');

} else {

    include_once('functions.php');

    $id = testInput($_GET['id']);

    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

    /* verifying if comment exists */

    $queryExistingComment = 'SELECT id, book_id FROM comment WHERE id = :id';
    $statementExistingComment = $pdo->prepare($queryExistingComment);
    $statementExistingComment->bindValue(':id', $id, PDO::PARAM_INT);
    $statementExistingComment->execute();
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

<?php } ?>

</body>
</html>