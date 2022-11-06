<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBooky</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5474cfcdca.js" crossorigin="anonymous"></script>
    <link href="styles.css" rel="stylesheet"></head>

</head>

<body class="d-flex flex-column h-100">

    <?php include_once('nav-bar.php'); 
    
    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
    $queryTotal = 'SELECT author_id a_id, firstname, lastname, price_book, book.id id, name FROM book LEFT JOIN author ON author.id=book.author_id ORDER BY lastname';
    $statement = $pdo->query($queryTotal);
    $books = $statement->fetchAll();

    ?>

    <main>
        <section class="py-5 text-center container">
            <div class="row py-lg-1">
                <div class="col-lg-6 col-md-8 mx-auto">

            <!-- with login session -->

                    <?php if (isset($_SESSION['login'])) {?>
                        <h1 class="mt-0">MyBooky</h1>
                        <h5 class="text-center mt-2 mb6 text-secondary">Vendez et achetez vos livres au meilleur prix</h5>
                </div>
            </div>

            <!-- search -->
            <form method="POST" action="index-search.php" class="text-center mt-2 small" id="formSearch">
                <div class="form-group">  
                    <input type="number" id="minPrice" name="minPrice" class="form-line" placeholder="Prix Min" value="<?php if($_SERVER['REQUEST_METHOD'] === 'POST'){echo $_POST['minPrice'];}?>">€    
                    <input type="number" id="maxPrice" name="maxPrice" class="form-group" placeholder="Prix Max" value="<?php if($_SERVER['REQUEST_METHOD'] === 'POST'){echo $_POST['maxPrice'];}?>">€    
                    <select name="author_id" id="select-search">

                    <!-- keep author value in select while searching -->
                        <?php if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['author_id'])){
                            $queryAuthorChoice = 'SELECT id, firstname, lastname FROM author WHERE id = ' . $_POST['author_id'];
                            $statementAuthorChoice = $pdo->query($queryAuthorChoice);
                            $authorChoice = $statementAuthorChoice->fetch();?>

                            <!-- author of search -->

                            <option value="<?php echo $authorChoice['id']; ?>"><?php echo ucwords($authorChoice['lastname'] . ' ' . $authorChoice['firstname'])?></option>
                            
                            <?php

                            /* rest of authors */

                            $queryAuthor = 'SELECT id, firstname, lastname FROM author WHERE lastname NOT LIKE \'%' . $authorChoice['lastname'] . '%\' ORDER BY lastname';
                            $statementAuthor = $pdo->query($queryAuthor);
                            $authors = $statementAuthor->fetchAll();

                            foreach($authors as $author) { ?>
                                <option value="">Auteur</option>
                                <option value="<?php echo $author['id']?>"><?php echo ucwords($author['lastname'] . ' ' . $author['firstname'])?></option>
                            <?php } ?>

                            <?php } else { ?>

                                <option value="">Auteur</option>
                                <?php 
                                $queryAuthor = 'SELECT id, firstname, lastname FROM author ORDER BY lastname';
                                $statementAuthor = $pdo->query($queryAuthor);
                                $authors = $statementAuthor->fetchAll();

                            foreach($authors as $author) { ?>
                                <option value="<?php echo $author['id']?>"><?php echo ucwords($author['lastname'] . ' ' . $author['firstname'])?></option>
                        <?php }} ?>
                    </select>
                </div> 
                <div class="button-search-hidden">
                    <button type="submit" class="btn btn-primary small mt-3 mb-3 pl-4" id="buttonSearchHidden">Rechercher</button>
                </div>
            </form>
            <a href="index-search.php" id="initSearch">Réinitialiser la recherche</a><br/>
            <a href="index.php" class = "text-secondary small" id="closeSearch">Fermer la recherche</a>

            </section>

            <!-- conditions for search -->

            <?php 

                if($_SERVER['REQUEST_METHOD'] === 'POST'){

                    /* verifying answer to search */

                    include_once('functions.php');
                    $minPrice = intval(testInput($_POST['minPrice']));
                    $maxPrice = intval(testInput($_POST['maxPrice']));
                    $authorId = testInput($_POST['author_id']); 

                    if(empty($minPrice)){$minPrice = 0;};
                    if(empty($maxPrice)){$maxPrice = 100000000;};

                    if(!empty($_POST['author_id'])){
                        $querySearchBook = 'SELECT author_id, firstname, lastname, user_id, price_book, book.id id, name FROM book LEFT JOIN author ON author.id=book.author_id WHERE price_book >= ' . $minPrice . ' AND price_book <= ' . $maxPrice . ' AND author_id = '. $authorId . ' ORDER BY price_book';
                    } else {
                        $querySearchBook = 'SELECT author_id, firstname, lastname, user_id, price_book, book.id id, name FROM book LEFT JOIN author ON author.id=book.author_id WHERE price_book >= ' . $minPrice . ' AND price_book <= ' . $maxPrice . ' ORDER BY price_book';
                    }
                    $statementSearchBook = $pdo->query($querySearchBook);
                    $searchBooks = $statementSearchBook->fetchAll();

                    if(!empty($searchBooks)){ ?>

                    <!-- display search -->
            
                        <div class="album bg-light">
                            <div class="container">
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                                <?php foreach($searchBooks as $searchBook){ ?>
                                        <div class="col">
                                            <div class="card shadow-sm">

                                                <div class="card-body text-center">
                                                    <h5 class="p-2 mb-1 bg-primary text-white"><?php echo ucfirst(stripslashes($searchBook['name'])) ?></h5>
                                                    <h5 class="pt-2 text-primary"><?php echo ucwords($searchBook['firstname']) . ' ' . ucwords($searchBook['lastname']) ?></h5>
                                                    <a href="book-info.php?id=<?php echo $searchBook['id'] ?>" class="mt-0 mb-2">Détails</a>
                                                    <p class="p-1 mb-0 text-black"><strong><?php echo 'Prix : ' . number_format($searchBook['price_book'], 2, ',', ' ') . '€'?></strong></p>
                                                    <?php if($searchBook['user_id'] !== $_SESSION['id']) {?>
                                                        <form name="<?php echo $searchBook['id']?>" method="post" action="cart.php"><button type="submit" name="buttonCart" value='<?php echo $searchBook['id']; ?>' class='btn btn-dark mt-2 mb-3'>Ajouter au panier</button></form>
                                                        <?php }  else { ?>
                                                        <form name="<?php echo $searchBook['id']?>" method="post" action="book-personal-space.php"><button type="submit" name="buttonCart" value='<?php echo $searchBook['id']; ?>' class='btn btn-outline-secondary mt-2 mb-3 small-button'>Accéder à mon espace</button></form>
                                                    <?php } 

                                                /* number of likes */

                                                    /* get total likes */

                                                    $queryThumbup = 'SELECT total FROM likes WHERE book_id = ' .$searchBook['id'];
                                                    $statementThumbup = $pdo->query($queryThumbup);
                                                    $thumbup = $statementThumbup->fetch();

                                                    /* get total per likes && user : 0 or 1  */

                                                    $queryVerifyLikesUser = 'SELECT book_id, likes_id, likes_user.total l_u_t, user_id, likes.total FROM likes_user LEFT JOIN likes ON likes.id = likes_user.likes_id WHERE book_id = ' . $searchBook['id'] . ' AND user_id = ' . $_SESSION['id'];
                                                    $statementVerifyLikesUser = $pdo->query($queryVerifyLikesUser);
                                                    $verifyLikesUser= $statementVerifyLikesUser->fetch();

                                                    /* if 0 color the thumb in black, if 1 color thumb in blue */

                                                    if($verifyLikesUser['l_u_t'] === 0){ ?>
                                                        <p class="thumb-in-black"><?php echo $thumbup['total']?><a href="index-search-thumb-up.php?id=<?php echo $searchBook['id']?>"><i class="fa fa-thumbs-up" style="margin-left: 5px;" aria-hidden="true"></i></a></p>
                                                    <?php } else if (($verifyLikesUser['l_u_t'] === 1)){ ?>
                                                        <p class="thumb-in-blue"><?php echo $thumbup['total']?><a href="index-search-thumb-up.php?id=<?php echo $searchBook['id']?>"><i class="fa fa-thumbs-up" style="margin-left: 5px;" aria-hidden="true"></i></a></p>
                                                    <?php } ?>                             
                                                </div>
                                            </div>
                                        </div>                       
                                        <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        
                        <div class="text-center">
                            <h4 class="text-center text-primary">Pas de résultat</h4>
                        </div>


                <?php }} else { ?>
                               
        </section>

                    <!-- display all -->

                    <?php
                    $querySearchBook = 'SELECT author_id, user_id, firstname, lastname, price_book, book.id id, name FROM book LEFT JOIN author ON author.id=book.author_id ORDER BY book.id DESC';
                    $statementSearchBook = $pdo->query($querySearchBook);
                    $searchBooks = $statementSearchBook->fetchAll();
                    ?>

                    <div class="album bg-light">
                        <div class="container">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                            <?php foreach($searchBooks as $searchBook){ ?>
                                    <div class="col">
                                        <div class="card shadow-sm">

                                            <div class="card-body text-center">
                                                <h5 class="p-2 mb-1 bg-primary text-white"><?php echo ucfirst(stripslashes($searchBook['name'])) ?></h5>
                                                <h5 class="pt-2 text-primary"><?php echo ucwords($searchBook['firstname']) . ' ' . ucwords($searchBook['lastname']) ?></h5>
                                                <a href="book-info.php?id=<?php echo $searchBook['id'] ?>" class="mt-0 mb-2">Détails</a>
                                                <p class="p-1 mb-0 text-black"><strong><?php echo 'Prix : ' . number_format($searchBook['price_book'], 2, ',', ' ') . '€'?></strong></p>
                                                <?php if($searchBook['user_id'] !== $_SESSION['id']) {?>
                                                    <form name="<?php echo $searchBook['id']?>" method="post" action="cart.php"><button type="submit" name="buttonCart" value='<?php echo $searchBook['id']; ?>' class='btn btn-dark mt-2 mb-3'>Ajouter au panier</button></form>
                                                    <?php }  else { ?>
                                                    <form name="<?php echo $searchBook['id']?>" method="post" action="book-personal-space.php"><button type="submit" name="buttonCart" value='<?php echo $searchBook['id']; ?>' class='btn btn-outline-secondary mt-2 mb-3 small-button'>Accéder à mon espace</button></form>
                                                <?php } 

                                            /* number of likes */

                                                /* get total likes */

                                                $queryThumbup = 'SELECT total FROM likes WHERE book_id = ' .$searchBook['id'];
                                                $statementThumbup = $pdo->query($queryThumbup);
                                                $thumbup = $statementThumbup->fetch();

                                                /* get total per likes && user : 0 or 1  */

                                                $queryVerifyLikesUser = 'SELECT book_id, likes_id, likes_user.total l_u_t, user_id, likes.total FROM likes_user LEFT JOIN likes ON likes.id = likes_user.likes_id WHERE book_id = ' . $searchBook['id'] . ' AND user_id = ' . $_SESSION['id'];
                                                $statementVerifyLikesUser = $pdo->query($queryVerifyLikesUser);
                                                $verifyLikesUser= $statementVerifyLikesUser->fetch();

                                                /* if 0 color the thumb in black, if 1 color thumb in blue */

                                                if($verifyLikesUser['l_u_t'] === 0){ ?>
                                                    <p class="thumb-in-black"><?php echo $thumbup['total']?><a href="index-search-thumb-up.php?id=<?php echo $searchBook['id']?>"><i class="fa fa-thumbs-up" style="margin-left: 5px;" aria-hidden="true"></i></a></p>
                                                <?php } else if (($verifyLikesUser['l_u_t'] === 1)){ ?>
                                                    <p class="thumb-in-blue"><?php echo $thumbup['total']?><a href="index-search-thumb-up.php?id=<?php echo $searchBook['id']?>"><i class="fa fa-thumbs-up" style="margin-left: 5px;" aria-hidden="true"></i></a></p>
                                                <?php } ?> 
                                            </div>
                                        </div>
                                    </div>                       
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                
                <!-- without login session -->

                <?php } else { ?>
                    <div class="text-center">
                        <h1 class="mt-5">MyBooky</h1>
                        <h2>Welcome !!!</h2>
                        <h6 class="mt-3">Pour vendre ou acheter des livres, authentifiez-vous</h6>
                        <a class="btn btn-primary mt-2" href="signin.php" role="button">Connexion</a>
                    </div>
                <?php } ?>

    </main> 

    <?php include_once('footer.php'); ?>

    <script src="search.js"></script>

</body>
</html>