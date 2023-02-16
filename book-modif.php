<?php 

$title="MyBooky - Modifier le livre";

require('head.php');

?>

<?php 

include_once('nav-bar.php'); 

if(empty($_SESSION)){

    header('location:index.php');

} else {

    include_once('functions.php');

    if(!empty($_GET['id'])){

        $id = testInput($_GET['id']);
    
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

                if(($_POST['birthyear']) && ($_POST['deathyear']) && ($_POST['birthyear'] > $_POST['deathyear'])){

                    $errorMessage = "L'année de naissance doit être inférieure à l'année de mort.";

                }

                if(empty($_POST['bookName']) || empty($_POST['bookPrice']) || empty($_POST['authorLastname'])){

                    $errorMessage = "Le nom du livre, le prix et le nom de l'auteur sont obligatoires.";

                }

                if(testInput($_POST['authorLastname']) !== $book['lastname']) {

                $queryAuthorLastname = 'SELECT lastname FROM author WHERE lastname LIKE \'%' . testInput($_POST['authorLastname']) . '%\'';
                $statementAuthorLastname = $pdo->query($queryAuthorLastname);
                $authorLastnameMatch = $statementAuthorLastname->fetch();

                    if($authorLastnameMatch) {

                        $errorMessage = 'Livre existant';

                    }
                }

                if(testInput($_POST['bookName']) !== $book['name']) {
    
                    $queryTitleBook = 'SELECT name FROM book WHERE name LIKE \'%' . testInput($_POST['bookName']) . '%\'';
                    $statementTitleBook = $pdo->query($queryTitleBook);
                    $titleBookMatch = $statementTitleBook->fetch();
    
                    if($titleBookMatch) {
    
                        $errorMessage = 'Livre existant';
    
                    }
                }

                /* insertion modifications */
                $lastname = testInput($_POST['authorLastname']);
                $firstname = testInput($_POST['authorFirstname']);
                $birthyear = intval(testInput($_POST['birthyear']));
                $deathyear = intval(testInput($_POST['deathyear']));
                $bookName = testBookName($_POST['bookName']);
                $bookPrice = floatval(testInput($_POST['bookPrice']));
                $bookSumup = testInputNotLowerCase($_POST['bookSumup']);
                $bookYear = intval(testInput($_POST['release_year']));

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
            

                if($errorMessage === ''){

                header('location: book-personal-space.php');
                exit();
                
                var_dump($errorMessage); die;
                }   
    
        }
    } else {
        header('location: book-modif-forbidden.php');

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
                        <input type="number" step="0.01" id="bookPrice" name="bookPrice" class="form-control" value="<?php echo number_format($book['price_book'], 2, '.', ' ') ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="release_year" class="text-secondary">Date de parution</label>
                        <input type="text" id="release_year" name="release_year" class="form-control" value="<?php echo $book['release_year']?>">
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
                        Année de naissance <input type="text" id="birthyear" name="birthyear" class="author-birth-year" value="<?php echo $book['birthyear']?>"></input>
                        Année de mort <input type="text" id="deathyear" name="deathyear" class="author-death-year" value="<?php echo $book['deathyear']?>"></input>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary mt-2" value="">Modifiez le livre</button>
                    </div>
                </form>
                <div class="pt-2"><a href="book-delete.php?id=<?php echo $book['id'] ?>" >Supprimer le livre</a></div>
                <div class="errorMessage">
                    <?php if (!empty($errorMessage)) echo $errorMessage ; ?>
                </div>
            </div>
        </div>


        <?php 
        } else { ?>
            <div class="container w-50 text-center">
                <h3 class="text-center text-primary mt-5">Page inexistante</h3>
                <a href="book-personal-space.php" class="text-center">Retour à votre espace</a>
            </div>';
        <?php }

    } else {?>
            <div class="container w-50 text-center">
                <h3 class="text-center text-primary mt-5">Page inexistante</h3>
                <a href="book-personal-space.php" class="text-center">Retour à votre espace</a>
            </div>
    <?php } ?>


<?php } ?>

<?php include_once('footer.php'); ?>

</body>
</html>
