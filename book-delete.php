<?php 

$title="MyBooky - Vendre un livre";

require('head.php');

?>

<?php

if(empty($_SESSION)){

    header('location:index.php');

} 

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    include_once('functions.php');

    $id = testInput($_GET['id']);

    /* binding and securizing id */
    $querySelect = 'SELECT author_id a_id, user_id, firstname, lastname, price_book, book.id id, sumup, name FROM book LEFT JOIN author ON author.id=book.author_id where book.id = :id';
    $statement = $pdo->prepare($querySelect);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $book = $statement->fetch();

    if($book['user_id'] === $_SESSION['id']){

        /* delete books */

        /* book_id must be null in likes table */

        $queryDeleteBookIdInLikes = 'UPDATE likes SET book_id = NULL WHERE book_id = :id';
        $stmtDeleteBookIdInLikes= $pdo->prepare($queryDeleteBookIdInLikes);
        $stmtDeleteBookIdInLikes->bindValue(':id', $id, PDO::PARAM_INT);
        $stmtDeleteBookIdInLikes->execute();

        /* book_id must be null in comment table */

        $queryDeleteBookIdInComment = 'UPDATE comment SET book_id = NULL WHERE book_id = :id';
        $stmtDeleteBookIdInComment= $pdo->prepare($queryDeleteBookIdInComment);
        $stmtDeleteBookIdInComment->bindValue(':id', $id, PDO::PARAM_INT);
        $stmtDeleteBookIdInComment->execute();

        /* delete books */

        $queryDeleteBook = 'DELETE FROM book WHERE id= :id';
        $stmtDeleteBook= $pdo->prepare($queryDeleteBook);
        $stmtDeleteBook->bindValue(':id', $id, PDO::PARAM_INT);
        $stmtDeleteBook->execute();

        /* delete authors without books */

        $querySuppAuthorWithoutBook = 'SELECT author.id a_id, book.author_id b_id, firstname, lastname FROM author LEFT JOIN book ON author.id=book.author_id WHERE book.author_id IS NULL';
        $stmt= $pdo->query($querySuppAuthorWithoutBook);
        $authorWithoutBook = $stmt->fetchAll();

        foreach($authorWithoutBook as $author){
            $querySuppAuthor = 'DELETE FROM author WHERE id = ' . $author['a_id'];
            $stmt= $pdo->prepare($querySuppAuthor);
            $stmt->execute();
        }

        header('location: book-personal-space.php');
        exit(); ?>

    <?php } else { 

        header('location: book-delete-forbidden.php');
        exit(); 

    }
}?>

<div class="container w-50 text-center">
    <form method="post" class="mt-5">
            <button type="submit" class="form-control btn-secondary">Validez la suppression</button>
    </form>
</div>

<?php include_once('footer.php'); ?>

</body>
</html>




