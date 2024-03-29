<?php 

$title="MyBooky - Info sur le livre";

require('head.php');

?>

<?php

include_once('nav-bar.php');

if (empty($_SESSION)) {

    header('location:index.php');
    
} else {

    include_once('functions.php');

    if(!empty($_GET['id'])){

        $id = testInput($_GET['id']);
        
        /* binding and securizing id */
        $queryBook = 'SELECT author_id a_id, user_id, firstname, lastname, price_book, book.id id, sumup, name, birthyear, deathyear, release_year FROM book LEFT JOIN author ON author.id=book.author_id where book.id = :id';
        $statementBook = $pdo->prepare($queryBook);
        $statementBook->bindValue(':id', $id, PDO::PARAM_INT);
        $statementBook->execute();
        $book = $statementBook->fetch();

        $queryUser = 'SELECT user.id, firstname, lastname, book.id FROM user LEFT JOIN book ON user.id=book.user_id WHERE book.id=' . $id;
        $statementUser = $pdo->query($queryUser);
        $user = $statementUser->fetch();

        if ($book) { ?>
            <div class="container w-50">
                <div class="card text-center mt-4">
                    <h4 class="p-2 mb-2 bg-primary text-white">
                        <span class="title-book-info"><?php echo ucfirst(stripslashes(($book['name']))) ?></span>
                        <?php if($book['release_year']) { 
                            echo '<br><span class="release-year">Paru en ' . $book['release_year']; ?></span>
                        <?php } ?>
                    </h4>
                    <h5 class="p-2 text-primary">
                        <?php echo ucwords($book['firstname']) . ' ' . ucwords($book['lastname'] . ' ');
                        if($book['birthyear'] || $book['birthyear']) { 
                            if((empty($book['birthyear'])) || ($book['birthyear'] === 0)){$book['birthyear']=' ';}
                            if((empty($book['deathyear'])) || ($book['deathyear'] === 0)){$book['deathyear']=' ';}
                            echo "(" . $book['birthyear'] . " - " . $book['deathyear'] . ")";
                        }?>
                    </h5>
                    <h4 class="p-2 text-black title-sumup"><?php if($book['sumup'] !== ''){ echo "Résumé" ;} ?></h4>
                    
                    <p class="p-4 pt-0 mb-0 text-black"><?php echo ucfirst(stripslashes($book['sumup'])); ?></p>
                    <p class="p-1 mb-0 text-black"><strong><?php echo 'Prix : ' . number_format($book['price_book'], 2, ',', ' ') . '€' ?></strong></p>
                    <?php if ($book['user_id'] !== $_SESSION['id']) { ?>
                        <form name="<?php echo $book['id'] ?>" method="post" action="cart.php"><button type="submit" name="buttonCart" value='<?php echo $book['id']; ?>' class='btn btn-dark mt-2 mb-3'>Ajouter au panier</button></form>
                    <?php } ?>
                    <a href="index.php" class="btn2 mb-4 mt-2 text-center">Retour à la liste</a>

                    <!-- number of likes -->
                    <p class="thumb-in-grey"><?php
                        $queryThumbup = 'SELECT total FROM likes WHERE book_id = ' . $book['id'];
                        $statementThumbup = $pdo->query($queryThumbup);
                        $thumbup = $statementThumbup->fetch();

                        echo $thumbup['total'] ?><i class="fa fa-thumbs-up" style="margin-left: 5px;" aria-hidden="true"></i>
                    </p>
                    <p class="legend-italic-right small text-right">Vendeur : <?php echo ucwords($user['firstname'] . ' ' . $user['lastname']); ?> </p>
                </div>
                
                <!-- comments -->
                <?php
                    require_once('comment.php')
                ?>

            </div>
        <?php } else { ?>
            <div class="container w-50 text-center">
                <h3 class="text-center text-primary mt-5">Page inexistante</h3>
                <a href="index.php" class="text-center">Retour au catalogue</a>
            </div>
        <?php } 
    } else { ?>
        <div class="container w-50 text-center">
            <h3 class="text-center text-primary mt-5">Page inexistante</h3>
            <a href="index.php" class="text-center">Retour au catalogue</a>
        </div>
    <?php }?>
    
 <?php } ?>

<?php include_once('footer.php'); ?>

</body>
</html>

