<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookyMe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5474cfcdca.js" crossorigin="anonymous"></script>

</head>

<style>
    .thumb-in-black a {
        text-decoration: none;
        color: black;
    }

    .thumb-in-blue {
        color: #1263c4;
    }

    .small-button {
        min-width: 80px;
        font-size: 0.9rem;
    }

    .button-new{
        margin-right: 10px;
        min-width : 150px;;
    }

    h1, h2, h3, h4, h5, h6 {
        font-weight: 300;
    }

    h1 {
        font-size: 3rem;
    }
    h4 {
        font-size: 1.5rem;
    }
    h5 {
        font-size: 1.3em;
    }

</style>

<body class="d-flex flex-column h-100">

    <?php include_once('nav-bar.php'); 
    
    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
    $queryTotal = 'SELECT author_id a_id, firstname, lastname, price_book, user_id, book.id id, name FROM book LEFT JOIN author ON author.id=book.author_id ORDER BY book.id DESC';
    $statement = $pdo->query($queryTotal);
    $books = $statement->fetchAll();
    ?>

    <main>
        <section class="py-5 text-center container">
            <div class="row py-lg-1">
                <div class="col-lg-6 col-md-8 mx-auto">

            <!-- with login session -->

                    <?php if (isset($_SESSION['login'])) {?>
                    <h1 class="mt-0">BookyMe</h1>
                    <h4 class="text-center mt-2 mb6 text-secondary">Vendez et achetez vos livres au meilleur prix</h4>

                        <div>
                            <a href="index-search.php"><button type="submit" class="text-center btn btn-outline-primary small mt-2 mb-2 pl-4 button-new">Rechercher un livre</button></a>
                            <a href="book-add.php"><button type="submit" class="text-center btn btn-outline-primary small mt-2 ml-4 mb-2 pl-4 button-new">Vendre un livre</button></a>
                        </div>
                </div>
            </div>
        </section>

            <div class="album bg-light">
                    <div class="container">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        <?php foreach($books as $book){ ?>
                                <div class="col">
                                    <div class="card shadow-sm">

                                        <div class="card-body text-center">
                                            <h5 class="p-2 mb-1 bg-primary text-white"><?php echo ucfirst(stripslashes($book['name'])) ?></h5>
                                            <h5 class="pt-2 text-primary"><?php echo ucwords($book['firstname']) . ' ' . ucwords($book['lastname']) ?></h5>
                                            <a href="book-info.php?id=<?php echo $book['id'] ?>" class="mt-0 mb-2">Détails</a>
                                            <p class="p-1 mb-0 text-black"><strong><?php echo 'Prix : ' . number_format($book['price_book'], 2, ',', ' ') . '€'?></strong></p>
                                            
                                            <!-- if book has been added by session['id'], can't be put in cart -->

                                            <?php if($book['user_id'] !== $_SESSION['id']) {?>
                                                        <form name="<?php echo $book['id']?>" method="post" action="cart.php"><button type="submit" name="buttonCart" value='<?php echo $book['id']; ?>' class='btn btn-dark mt-2 mb-3'>Ajouter au panier</button></form>
                                                        <?php }  else { ?>
                                                        <form name="<?php echo $book['id']?>" method="post" action="book-personal-space.php"><button type="submit" name="buttonCart" value='<?php echo $book['id']; ?>' class='btn btn-outline-secondary mt-2 mb-3 small-button'>Accéder à mon espace</button></form>
                                            <?php }

                                        /* number of likes */

                                            /* get total likes */

                                            $queryThumbup = 'SELECT id, total FROM likes WHERE book_id = ' .$book['id'];
                                            $statementThumbup = $pdo->query($queryThumbup);
                                            $thumbup = $statementThumbup->fetch();

                                            /* get total per likes && user : 0 or 1  */

                                            /* Verifying if existing likes_id and likes_user */


                                            $queryVerifyLikesUser = 'SELECT book_id, likes_id, likes_user.total l_u_t, user_id, likes.total FROM likes_user LEFT JOIN likes ON likes.id = likes_user.likes_id WHERE book_id = ' . $book['id'] . ' AND user_id = ' . $_SESSION['id'];
                                            $statementVerifyLikesUser = $pdo->query($queryVerifyLikesUser);
                                            $verifyLikesUser= $statementVerifyLikesUser->fetch();
                                            
                                            /* if not existing, create it and initialize total to 0 */

                                            if(empty($verifyLikesUser)){

                                                $queryLikesUser = 'INSERT INTO likes_user (likes_id, user_id, total) VALUES(:likesid, :userid, :total)';
                                                $statementLikesUser = $pdo->prepare($queryLikesUser);
                                                $statementLikesUser->bindValue(':likesid', $thumbup['id'], \PDO::PARAM_INT);
                                                $statementLikesUser->bindValue(':userid', $_SESSION['id'], \PDO::PARAM_INT);
                                                $statementLikesUser->bindValue(':total', 0, \PDO::PARAM_INT);
                                                $statementLikesUser->execute(); ?>

                                                <p class="thumb-in-black"><?php echo $thumbup['total']?><a href="index-thumb-up.php?id=<?php echo $book['id']?>"><i class="fa fa-thumbs-up" style="margin-left: 5px;" aria-hidden="true"></i></a></p>
                                            
                                            <!-- if 0 color the thumb in black, if 1 color thumb in blue -->

                                            <?php } else if($verifyLikesUser['l_u_t'] === 0){ ?>
                                            <p class="thumb-in-black"><?php echo $thumbup['total']?><a href="index-thumb-up.php?id=<?php echo $book['id']?>"><i class="fa fa-thumbs-up" style="margin-left: 5px;" aria-hidden="true"></i></a></p>

                                            <?php } else if (($verifyLikesUser['l_u_t'] === 1)){ ?>
                                            <p class="thumb-in-blue"><?php echo $thumbup['total']?><a href="index-thumb-up.php?id=<?php echo $book['id']?>"><i class="fa fa-thumbs-up" style="margin-left: 5px;" aria-hidden="true"></i></a></p>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>                       
                            <?php } ?>
                        </div>
                    </div>
                </div>                
            <!-- without login session -->

            <?php } else { ?>
                <div class="text-center">
                    <h1 class="mt-5">BookyMe</h1>
                    <h2>Welcome !!!</h2>
                    <h6 class="mt-3">Pour vendre ou acheter des livres, authentifiez-vous</h6>
                    <a class="btn btn-primary mt-2" href="signin.php" role="button">Connexion</a>
                </div>
            <?php } ?>

    </main> 

    <?php include_once('footer.php'); ?>

</body>
</html>