<?php

        $errorMessage = '';

        $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            $queryUdateAuthor = 'UPDATE author SET firstname = :firstname, lastname = :lastname';
            $queryUdateBook = 'UPDATE book SET name = :name, sumup = :sumup, price_book = :price_book';

            $stmtupdateAuthor= $pdo->prepare($queryUdateAuthor);
            $stmtupdateAuthor->execute([$_POST['authorLastname'], $_POST['authorFirstname']]);

            $stmtUpdateBook= $pdo->prepare($queryUdateBook);
            $stmtUpdateBook->execute([$_POST['bookName'], $_POST['bookSumup'], $_POST['bookPrice']]);
        }

        $querySelect = 'SELECT author_id a_id, firstname, lastname, price_book, book.id id, sumup, name FROM book LEFT JOIN author ON author.id=book.author_id ORDER BY id DESC';
        $statement = $pdo->query($querySelect);
        $books = $statement->fetchAll();

        

/*         header('location: index.php');
        exit(); */


?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Library Factory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">

    <?php include_once('nav-bar.php'); ?>

    <?php foreach($books as $book) {
        if($book['id'] == $_GET['id']){ ?>

    <div class="container w-50 ">
        <div class="mt-5"></div>
            <h3 class="text-center">Modifiez le livre</h3>
            <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="mt-3">
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
                    <textarea id="bookSumup" name="bookSumup" class="form-control" value="<?php echo ucfirst($book['sumup']) ?>"></textarea>
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
                    <button type="submit" class="btn btn-primary mt-2">Modifiez le livre</button>
                </div>
            </form>
        <?php }}?>
            <div>
                <?php if (!empty($errorMessage)) echo $errorMessage ; ?>
            </div>
        </div>
    </div>

    <?php include_once('footer.php'); ?>

</body>
</html>