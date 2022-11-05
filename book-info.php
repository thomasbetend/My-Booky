<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBooky - Info sur le livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5474cfcdca.js" crossorigin="anonymous"></script>
    <link href="styles.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

    <?php

    include_once('nav-bar.php');

    if (empty($_SESSION)) {
        header('location:index.php');
    } else {

        include_once('functions.php');
        $id = testInput($_GET['id']);

        $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory', 'root', '');
        $queryBook = 'SELECT firstname, lastname, price_book, user_id, book.id id, name, sumup, release_year, birthyear, deathyear FROM book LEFT JOIN author ON author.id=book.author_id WHERE book.id=' . $id;
        $statementBook = $pdo->query($queryBook);
        $book = $statementBook->fetch();

        $queryUser = 'SELECT user.id, firstname, lastname, book.id FROM user LEFT JOIN book ON user.id=book.user_id WHERE book.id=' . $id;
        $statementUser = $pdo->query($queryUser);
        $user = $statementUser->fetch();

        if ($book) { ?>
            <div class="container w-50">
                <div class="card text-center mt-4">
                    <h3 class="p-2 mb-2 bg-primary text-white">
                        <?php echo ucwords(stripslashes(($book['name']))) ?>
                        <?php if($book['release_year']) { 
                            echo '<br><span class="release-year">paru en ' . $book['release_year']; ?></span>
                        <?php } ?>
                    </h3>
                    <h5 class="p-2 text-primary">
                        <?php echo ucwords($book['firstname']) . ' ' . ucwords($book['lastname'] . ' ');
                        if($book['birthyear'] || $book['birthyear']) { 
                            if((empty($book['birthyear'])) || ($book['birthyear'] === 0)){$book['birthyear']=' ';}
                            if((empty($book['deathyear'])) || ($book['deathyear'] === 0)){$book['deathyear']=' ';}
                            echo "(" . $book['birthyear'] . " - " . $book['deathyear'] . ")";
                        }?>
                    </h5>
                    <h4 class="p-2 text-black">Résumé</h4>
                    <p class="p-4 mb-0 text-black"><?php echo ucfirst(stripslashes($book['sumup'])) ?></p>
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
                    <p class="legend-italic-right small text-right">Proposé par <?php echo ucwords($user['firstname'] . ' ' . $user['lastname']); ?> </p>
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
        <?php } ?>

        <?php include_once('footer.php'); ?>

</body>
</html>

<?php } ?>