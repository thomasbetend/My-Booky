<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookyMe - Modifier le livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    h1, h2, h3, h4, h5, h6 {
        font-weight: 300;
    }

    .author-years {
        color: #6c757d;
    }

    .author-birth-year {
        width: 70px;
        border: 1px solid #ced4da;
        border-radius: 3px;
        margin-right: 10px;
        color: black;
    }

    .author-birth-year .input-placeholder {
        color: black;
    }

    .author-death-year {
        width: 70px;
        border: 1px solid #ced4da;
        border-radius: 3px;
        margin-right: 10px;
        color: black;
    }
</style>
<body class="d-flex flex-column h-100">

    <?php 
    
    include_once('nav-bar.php'); 
    
    if(empty($_SESSION)){
        header('location:index.php');
    } else {

    include_once('functions.php');

    $id = testInput($_GET['id']);

    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
    
    /* binding and securizing id */
    $querySelect = 'SELECT author_id a_id, user_id, firstname, lastname, price_book, book.id id, sumup, name, birthyear, deathyear, release_year FROM book LEFT JOIN author ON author.id=book.author_id where book.id = :id';
    $statement = $pdo->prepare($querySelect);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $book = $statement->fetch();

    if($book){

            if($book['user_id'] === $_SESSION['id']){

            $errorMessage = '';

            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                /* insertion modifications */
                $lastname = testInput($_POST['authorLastname']);
                $firstname = testInput($_POST['authorFirstname']);
                $birthyear = testInput($_POST['birthyear']);
                $deathyear = testInput($_POST['deathyear']);
                $bookName = testInput($_POST['bookName']);
                $bookPrice = floatval(testInput($_POST['bookPrice']));
                $bookSumup = testInputNotLowerCase($_POST['bookSumup']);
                $bookYear = testInput($_POST['release_year']);

                $queryUdateAuthor = 'UPDATE author SET firstname = :firstname, lastname = :lastname, birthyear = :birthyear, deathyear = :deathyear WHERE id = ' . $book['a_id'];

                $stmtUpdateAuthor= $pdo->prepare($queryUdateAuthor);
                $stmtUpdateAuthor->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
                $stmtUpdateAuthor->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
                $stmtUpdateAuthor->bindValue(':birthyear', $birthyear, \PDO::PARAM_STR);
                $stmtUpdateAuthor->bindValue(':deathyear', $deathyear, \PDO::PARAM_STR);
                $stmtUpdateAuthor->execute();

                $queryUdateBook = 'UPDATE book SET name = :name, sumup = :sumup, price_book = :price_book, release_year = :release_year WHERE id = ' . $book['id'];

                $stmtUpdateBook= $pdo->prepare($queryUdateBook);
                $stmtUpdateBook->bindValue(':name', $bookName, \PDO::PARAM_STR);
                $stmtUpdateBook->bindValue(':sumup', $bookSumup, \PDO::PARAM_STR);
                $stmtUpdateBook->bindValue(':price_book', $bookPrice, \PDO::PARAM_STR);
                $stmtUpdateBook->bindValue(':release_year', $bookYear, \PDO::PARAM_STR);

                $stmtUpdateBook->execute();  
                
                header('location: book-personal-space.php');
                exit();
                                    
            }

    ?>

            <div class="container w-50 ">
                <div class="mt-5"></div>
                    <h2 class="text-center">Modifiez le livre</h2>
                    <form action="" method="post" class="mt-3">
                        <div class="form-group mb-2">
                            <label for="bookName" class="text-secondary">Titre du livre (obligatoire)</label>
                            <input type="text" id="bookName" name="bookName" value="<?php echo ucwords($book['name']) ?>" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="bookPrice" class="text-secondary">Prix (obligatoire)</label>
                            <input type="text" id="bookPrice" name="bookPrice" class="form-control" value="<?php echo number_format($book['price_book'], 2, ',', ' ') ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="release_year" class="text-secondary">Date de parution</label>
                            <input type="text" id="release_year" name="release_year" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="bookSumup" class="text-secondary">Résumé</label>
                            <textarea id="bookSumup" name="bookSumup" class="form-control"><?php echo ucfirst($book['sumup']) ?></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="authorLastname" class="text-secondary">Nom de l'auteur (obligatoire)</label>
                            <input type="text" id="authorLastname" name="authorLastname" class="form-control" value="<?php echo ucwords($book['lastname']) ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="authorFirstname" class="text-secondary">Prénom de l'auteur</label>
                            <input type="text" id="authorFirstname" name="authorFirstname" class="form-control" value="<?php echo ucwords($book['firstname']) ?>">
                        </div>
                        <div class="author-years">
                            Année de naissance <input type="text" id="birthyear" name="birthyear" class="author-birth-year"></input>
                            Année de mort <input type="text" id="deathyear" name="deathyear" class="author-death-year"></input>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary mt-2" value="">Modifiez le livre</button>
                        </div>
                    </form>
                    <div class="pt-2"><a href="book-delete.php?id=<?php echo $book['id'] ?>" >Supprimer le livre</a></div>
                    <div>
                        <?php if (!empty($errorMessage)) echo $errorMessage ; ?>
                    </div>
                </div>
            </div>

    <?php include_once('footer.php'); ?>
</body>
</html>

<?php 
} else {
echo '<div class="text-center"><h3 class="text-primary mt-5"> Vous n\'avez pas les droits pour modifier ce livre</h3><a href="book-personal-space.php">Retour à votre espace</a></div>';
}

} else {?>
    
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookyMe - Modifier le livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">

<?php include_once('nav-bar.php'); ?>

            <div class="container w-50 text-center">
                <h3 class="text-center text-primary mt-5">Page inexistante</h3>
                <a href="book-personal-space.php" class="text-center">Retour à votre espace</a>
            </div>
            <?php } ?>
<?php include_once('footer.php'); ?>


</body>
</html>

<?php } ?>
