<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBooky - Validation suppression</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<?php include_once('nav-bar.php');

if(empty($_SESSION)){

    header('location:index.php');

} else {

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    include_once('functions.php');

    $id = testInput($_GET['id']);

    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

    /* binding and securizing id */
    $querySelect = 'SELECT author_id a_id, user_id, firstname, lastname, price_book, book.id id, sumup, name FROM book LEFT JOIN author ON author.id=book.author_id where book.id = :id';
    $statement = $pdo->prepare($querySelect);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $book = $statement->fetch();

    if($book['user_id'] === $_SESSION['id']){

        /* delete books */

        $queryDeleteBookId = 'SELECT  SET book_id = NULL WHERE book_id =' . $id;
        $queryDeleteBookId = 'UPDATE likes SET book_id = NULL WHERE book_id =' . $id;
        $stmtDeleteBookId= $pdo->prepare($queryDeleteBookId);
        $stmtDeleteBookId->execute();

        $querySuppBook = 'DELETE FROM book WHERE id= ' . $id;
        $stmt= $pdo->prepare($querySuppBook);
        $stmt->execute();

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

<?php } ?>


