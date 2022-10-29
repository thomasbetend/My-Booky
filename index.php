<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookyMe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">

</head>
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
                    <h5 class="text-center mt-2 mb6 text-secondary">Vendez et achetez vos livres au meilleur prix</h5>
                    <form action="index-search.php">
                        <div class="button-search">
                            <button type="submit" class="text-center btn btn-outline-primary small mt-2 mb-2 pl-4">Recherchez un livre</button>
                        </div>
                    </form>
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
                                            <h5 class="p-2 mb-1 bg-primary text-white"><?php echo ucwords(stripslashes($book['name'])) ?></h5>
                                            <h5 class="pt-2 text-primary"><?php echo ucwords($book['firstname']) . ' ' . ucwords($book['lastname']) ?></h5>
                                            <a href="book-info.php?id=<?php echo $book['id'] ?>" class="mt-0 mb-2">Détails</a>
                                            <p class="p-1 mb-0 text-black"><strong><?php echo 'Prix : ' . number_format($book['price_book'], 2, ',', ' ') . '€'?></strong></p>
                                            <?php if($book['user_id'] !== $_SESSION['id']) {?>
                                                        <form name="<?php echo $book['id']?>" method="post" action="cart.php"><button type="submit" name="buttonCart" value='<?php echo $book['id']; ?>' class='btn btn-dark mt-2 mb-3'>Ajouter au panier</button></form>
                                                        <?php }  else { ?>
                                                        <form name="<?php echo $book['id']?>" method="post" action="book-personal-space.php"><button type="submit" name="buttonCart" value='<?php echo $book['id']; ?>' class='btn btn-outline-secondary mt-2 mb-3'>Mon livre</button></form>
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