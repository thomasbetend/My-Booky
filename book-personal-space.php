<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookyMe - Espace personnel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="d-flex flex-column h-100">


<?php include_once('nav-bar.php'); ?>


<?php

if(empty($_SESSION)) { 
    header('location: index.php');
} else {

$pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

$queryUserBook = 'SELECT name, author.firstname, author.lastname, book.id as b_id, price_book, user.id as u_id FROM book JOIN author ON author.id=book.author_id JOIN user ON user.id= book.user_id WHERE user_id = ' . $_SESSION['id'] . ' ORDER BY book.id DESC'; 
$statementUserBook = $pdo->query($queryUserBook);
$userBooks = $statementUserBook->fetchAll();

?>

<main>

    <section class="py-5 text-center container">
        <div class="row py-lg-1">
            <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="mt-0">Mon espace</h1>
                    <h5 class="text-center mt-2 mb6 text-secondary">Gérez vos livres</h5>
                    <p class="mt-4 text-center"><a href="book-add.php" class="text-center btn btn-secondary">Ajouter un livre</a></p>
                    <a href="index.php" class = "text-secondary small pb-2" id="closeSearch">Retour au catalogue</a>
            </div>
        </div>
    </section>
    <section>
        <div class="album bg-light">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <?php foreach($userBooks as $userBook){ ?>
                        <div class="col">
                            <div class="card shadow-sm">
                                <div class="card-body text-center">
                                    <h5 class="p-2 mb-1 bg-primary text-white"><?php echo ucfirst(stripslashes($userBook['name'])) ?></h5>
                                    <h5 class="pt-2 text-primary"><?php echo ucwords($userBook['firstname']) . ' ' . ucwords($userBook['lastname']) ?></h5>
                                    <a href="book-info.php?id=<?php echo $userBook['b_id'] ?>" class="mt-0 mb-2">Détails</a>
                                    <p class="p-1 mb-0 text-black"><strong><?php echo 'Prix : ' . number_format($userBook['price_book'], 2, ',', ' ') . '€'?></strong></p>
                                    <a href="book-modif.php?id=<?php echo $userBook['b_id']?>" class="text-secondary">Modifier livre</a>
                                    
                                </div>
                            </div>
                        </div>                       
                    <?php } ?>
                </div>
            </div>
        </div>                               
    </section>

    <?php include_once('footer.php'); ?>
</main>

<body>
</html>

<?php } ?>