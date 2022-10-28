<?php
include_once('functions.php');

$id = testInput($_GET['id']);

$pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

$querySelect = 'SELECT author_id a_id, firstname, lastname, price_book, book.id id, sumup, name FROM book LEFT JOIN author ON author.id=book.author_id where book.id = ' . $id;
$statement = $pdo->query($querySelect);
$book = $statement->fetch();

if($book){

        $errorMessage = '';

        $querySelect = 'SELECT author_id a_id, firstname, lastname, price_book, book.id id, sumup, name FROM book LEFT JOIN author ON author.id=book.author_id ORDER BY id DESC';
        $statement = $pdo->query($querySelect);
        $books = $statement->fetchAll();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $lastname = testInput($_POST['authorLastname']);
            $firstname = testInput($_POST['authorFirstname']);
            $bookName = testInput($_POST['bookName']);
            $bookPrice = floatval(testInput($_POST['bookPrice']));
            $bookSumup = testInput($_POST['bookSumup']);

            $queryUdateAuthor = 'UPDATE author SET firstname = :firstname, lastname = :lastname WHERE id = ' . $book['a_id'];

            $stmtUpdateAuthor= $pdo->prepare($queryUdateAuthor);
            $stmtUpdateAuthor->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
            $stmtUpdateAuthor->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
            $stmtUpdateAuthor->execute();

            $queryUdateBook = 'UPDATE book SET name = :name, sumup = :sumup, price_book = :price_book WHERE id = ' . $book['id'];

            $stmtUpdateBook= $pdo->prepare($queryUdateBook);
            $stmtUpdateBook->bindValue(':name', $bookName, \PDO::PARAM_STR);
            $stmtUpdateBook->bindValue(':sumup', $bookSumup, \PDO::PARAM_STR);
            $stmtUpdateBook->bindValue(':price_book', $bookPrice, \PDO::PARAM_STR);
            $stmtUpdateBook->execute();  
            
            header('location: book-personal-space.php');
            exit();
                                
        }

?>

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

            <div class="container w-50 ">
                <div class="mt-5"></div>
                    <h3 class="text-center">Modifiez le livre</h3>
                    <form action="" method="post" class="mt-3">
                        <div class="form-group mb-2">
                            <label for="bookName">Titre du livre (obligatoire)</label>
                            <input type="text" id="bookName" name="bookName" value="<?php echo ucwords($book['name']) ?>" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="bookPrice" >Prix (obligatoire)</label>
                            <input type="text" id="bookPrice" name="bookPrice" class="form-control" value="<?php echo number_format($book['price_book'], 2, ',', ' ') ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="bookSumup">Résumé</label>
                            <textarea id="bookSumup" name="bookSumup" class="form-control"><?php echo ucfirst($book['sumup']) ?></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="authorLastname">Nom de l'auteur (obligatoire)</label>
                            <input type="text" id="authorLastname" name="authorLastname" class="form-control" value="<?php echo ucwords($book['lastname']) ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="authorFirstname">Prénom de l'auteur</label>
                            <input type="text" id="authorFirstname" name="authorFirstname" class="form-control" value="<?php echo ucwords($book['firstname']) ?>">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary mt-2" value="">Modifiez le livre</button>
                        </div>
                    </form>
                    <div class="pt-2"><a href="book-delete.php?id=<?php echo $book['id'] ?>" >Suprrimer le livre</a></div>
                    <div>
                        <?php if (!empty($errorMessage)) echo $errorMessage ; ?>
                    </div>
                </div>
            </div>

    <?php include_once('footer.php'); ?>
</body>
</html>

<?php } else {?>
    
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

            <div class="container w-50">
                <div class="card text-center mt-4">
                    <h3 class="p-2 mb-1 bg-primary text-white">Page inexistante</h3>
                </div>
            </div>
            <?php } ?>
<?php include_once('footer.php'); ?>


</body>
</html>

