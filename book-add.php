<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookyMe - Ajouter un livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="book-add.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">

    <?php include_once('nav-bar.php'); ?>
    <?php

$pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $errorMessage = '';

    include_once('functions.php');

    /* verify existing book and author*/

    $queryAuthorLastname = 'SELECT lastname FROM author WHERE lastname = \'' . testInput($_POST['authorLastname']) . '\'';
    $statementAuthorLastname = $pdo->query($queryAuthorLastname);
    $authorLastnameMatch = $statementAuthorLastname->fetch();

    $queryAuthorFirstname = 'SELECT firstname FROM author WHERE firstname = \'' . testInput($_POST['authorFirstname']) . '\'';
    $statementAuthorFirstname = $pdo->query($queryAuthorFirstname);
    $authorFirstnameMatch = $statementAuthorFirstname->fetch();

    $queryTitleBook = 'SELECT name FROM book WHERE name = \'' . testInput($_POST['bookName']) . '\'';
    $statementTitleBook = $pdo->query($queryTitleBook);
    $titleBookMatch = $statementTitleBook->fetch();


    if($authorLastnameMatch || $titleBookMatch) {

        $errorMessage = 'Livre ou auteur déjà existant';

    } else {

        if(!empty(($_POST['bookName'])) && (!empty($_POST['bookPrice'])) && (((!empty($_POST['authorLastname']))) || !empty($_POST['author_id']))){

            $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
        
            if(!empty($_POST['authorLastname']) && (empty($_POST['author_id']))){
                

                    /* insert informations */
                    $queryAuthor = 'INSERT INTO author (firstname, lastname) VALUES (:firstname, :lastname)';
            
                    include_once('functions.php');
            
                    $lastname = testInput($_POST['authorLastname']);
                    $firstname = testInput($_POST['authorFirstname']);
                    $bookName = testInput($_POST['bookName']);
                    $bookPrice = floatval(testInput($_POST['bookPrice']));
                    $bookSumup = testInput($_POST['bookSumup']);
            
                    $statementAuthor = $pdo->prepare($queryAuthor);
            
                    $statementAuthor->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
                    $statementAuthor->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
            
                    $statementAuthor->execute();
            
                    $queryIdUser = 'SELECT id FROM user WHERE id = ' . $_SESSION['id'];
                    $statementIdUser = $pdo->query($queryIdUser);
                    $userId = $statementIdUser->fetch();

                    $queryIdAuthor = 'SELECT id FROM author ORDER BY id DESC';
                    $statementIdAuthor = $pdo->query($queryIdAuthor);
                    $authorId = $statementIdAuthor->fetch();
            
                    $queryBook = 'INSERT INTO book (name, author_id, user_id, price_book, sumup) VALUES(:bookname, :bookauthorid, :bookuserid, :bookprice, :sumup)';

                    $statementBook = $pdo->prepare($queryBook);
            
                    $statementBook->bindValue(':bookname', $bookName, \PDO::PARAM_STR);
                    $statementBook->bindValue(':bookauthorid', $authorId[0], \PDO::PARAM_STR);
                    $statementBook->bindValue(':bookuserid', $userId[0], \PDO::PARAM_STR);
                    $statementBook->bindValue(':bookprice', $bookPrice, \PDO::PARAM_STR);
                    $statementBook->bindValue(':sumup', $bookSumup, \PDO::PARAM_STR);
            
                    $statementBook->execute();

                    header('location: book-personal-space.php');
                    exit();
        
            }
        
            if((!empty($_POST['author_id'])) && (empty($_POST['authorLastname']))){
                
                    /* insert informations */

                    $queryBook = 'INSERT INTO book (name, author_id, user_id, price_book, sumup) VALUES(:bookname, :bookauthorid, :bookuserid, :bookprice, :sumup)';
                    
                    include_once('functions.php');

                    $queryIdUser = 'SELECT id FROM user WHERE id = ' . $_SESSION['id'];
                    $statementIdUser = $pdo->query($queryIdUser);
                    $userId = $statementIdUser->fetch();

                    $bookName = testInput($_POST['bookName']);
                    $bookPrice = floatval(testInput($_POST['bookPrice']));
                    $bookSumup = testInput($_POST['bookSumup']);

                    $statementBook = $pdo->prepare($queryBook);
            
                    $statementBook->bindValue(':bookname', $bookName, \PDO::PARAM_STR);
                    $statementBook->bindValue(':bookauthorid', $_POST['author_id'], \PDO::PARAM_STR);
                    $statementBook->bindValue(':bookuserid', $userId[0], \PDO::PARAM_STR);
                    $statementBook->bindValue(':bookprice', $bookPrice, \PDO::PARAM_STR);
                    $statementBook->bindValue(':sumup', $bookSumup, \PDO::PARAM_STR);
            
                    $statementBook->execute();
                    
                    header('location: book-personal-space.php');
                    exit();
            }

            header('location: book-personal-space.php');
            exit();
        
        } else { 
            $errorMessage = 'Renseignez au moins le nom du livre, son prix et le nom de l\'auteur';
    }}

}


?>

    <div class="container w-50 ">
        <div class="mt-5"></div>
            <h3 class="text-center">Vendez votre livre sur BookyMe</h3>
            <h5 class="text-center text-secondary">Ajoutez-le au catalogue</h5>
            <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="mt-3">
                <div class="form-group mb-2">
                    <label for="bookName">Titre du livre (obligatoire)</label>
                    <input type="text" id="bookName" name="bookName" class="form-control">
                </div>
                <div class="form-group mb-2">
                    <label for="bookPrice">Prix (obligatoire)</label>
                    <input type="text" id="bookPrice" name="bookPrice" class="form-control">
                </div>
                <div class="form-group mb-2">
                    <label for="bookSumup">Résumé</label>
                    <textarea id="bookSumup" name="bookSumup" class="form-control"></textarea>
                </div>
                <div class="form-group mb-2">
                    <label for="authorLastname"></label>
                    <select name="author_id" class="form-select select-add">
                        <option value="">Auteur existant</option>
                        <?php
                            $queryAuthor = 'SELECT id, firstname, lastname FROM author ORDER BY lastname';
                            $statementAuthor = $pdo->query($queryAuthor);
                            $authors = $statementAuthor->fetchAll();
                                                    
                            foreach($authors as $author){ ?> 
                            <option value="<?php echo $author['id'] ;?>"><?php echo ucwords($author['lastname'] . ' ' . $author['firstname']) ;?></option> 
                         <?php } ?>
                    </select>
                </div>
                <p class="text-primary mt-2">ou</p>
                <div class="form-group mb-2">
                    <label for="authorLastname">Nom du nouvel auteur (obligatoire)</label>
                    <input type="text" id="authorLastname" name="authorLastname" class="form-control">
                </div>
                <div class="form-group mb-2">
                    <label for="authorFirstname">Prénom du nouvel auteur</label>
                    <input type="text" id="authorFirstname" name="authorFirstname" class="form-control">
                </div>
                <div class="mt-2 text-primary">
                    <?php if (!empty($errorMessage)) echo $errorMessage ; ?>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-2">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <?php include_once('footer.php'); ?>

</body>
</html>