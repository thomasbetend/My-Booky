<?php 

$title="MyBooky - Espace personnel";

require('head.php');

?>

<?php

if(empty($_SESSION)) { 

    header('location: index.php');
    
} else {

$queryUserBook = 'SELECT name, author.firstname, author.lastname, book.id as b_id, price_book, user.id as u_id FROM book JOIN author ON author.id=book.author_id JOIN user ON user.id= book.user_id WHERE user_id = ' . $_SESSION['id'] . ' ORDER BY book.id DESC'; 
$statementUserBook = $pdo->query($queryUserBook);
$userBooks = $statementUserBook->fetchAll();

?>

<main>

    <section class="py-5 text-center container">
        <div class="row py-lg-1">
            <div class="col-lg-6 col-md-8 mx-auto">
                    <h2 class="mt-0">Mon espace</h2>
                    <h5 class="text-center mt-2 mb6 text-secondary">Gérez vos livres</h5>
                    <p class="mt-4 text-center"><a href="book-add.php" class="text-center btn btn-secondary">Vendre un livre</a></p>
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

                                    <!-- number of likes -->
                                    <p class="thumb-in-grey mt-2"><?php 
                                    $queryThumbup = 'SELECT total FROM likes WHERE book_id = ' . $userBook['b_id'];
                                    $statementThumbup = $pdo->query($queryThumbup);
                                    $thumbup = $statementThumbup->fetch();

                                    echo $thumbup['total']?><i class="fa fa-thumbs-up" style="margin-left: 5px;" aria-hidden="true"></i>
                                    </p>

                                </div>
                            </div>
                        </div>                       
                    <?php } ?>
                </div>
            </div>
        </div>                               
    </section>

    <?php } ?>

</main>

<?php include_once('footer.php'); ?>

<body>
</html>

