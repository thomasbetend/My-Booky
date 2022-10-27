<?php
$pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
$query = 'SELECT author_id a_id,firstname, lastname, price_book, book.id id, name FROM book LEFT JOIN author ON author.id=book.author_id ORDER BY id DESC';
$statement = $pdo->query($query);
$books = $statement->fetchAll();
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

    <main>
        <section class="py-5 text-center container">
            <div class="row py-lg-1">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <?php if (isset($_SESSION['login'])) {?>

                        <h1 class="mt-0">The Library Factory</h1>
                        <h5 class="text-center mt-2 mb6 text-secondary">Vendez et achetez vos livres au meilleur prix</h5>
                </div>
            </div>

            <!-- search -->
            <form method="POST" action="index.php" class="text-center mt-2 small">
                <div>   
                    Prix Min <input type="text" name="minPrice">
                    Prix Max <input type="text" name="maxPrice">
                    <select name="author_id" id="">
                        <option value="">Nom de l'auteur</option>
                        <?php foreach($books as $book) { ?>
                        <option value="<?php echo $book['a_id']?>"><?php echo ucfirst($book['lastname'])?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" class="btn btn-secondary small mt-2 mb-2">Recherchez</button>
                </div> 
            </form>
            <a href="index.php">Réactualiser la recherche</a>

            <?php 
                if(empty($_POST['minPrice'])){$_POST['minPrice'] = 0;};
                if(empty($_POST['maxPrice'])){$_POST['maxPrice'] = 100000000;};
                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    if(!empty($_POST['author_id'])){
                    $querySearchBook = 'SELECT author_id, firstname, lastname, price_book, book.id id, name FROM book LEFT JOIN author ON author.id=book.author_id WHERE price_book >= ' . $_POST['minPrice'] . ' AND price_book <= ' . $_POST['maxPrice'] . ' AND author_id = '. $_POST['author_id'] . ' ORDER BY id DESC';
                    } else {
                    $querySearchBook = 'SELECT author_id, firstname, lastname, price_book, book.id id, name FROM book LEFT JOIN author ON author.id=book.author_id WHERE price_book >= ' . $_POST['minPrice'] . ' AND price_book <= ' . $_POST['maxPrice'] . ' ORDER BY id DESC';
                    }
                    $statementSearchBook = $pdo->query($querySearchBook);
                    $searchBooks = $statementSearchBook->fetchAll();
                    ?>

                
         </section>

                    <div class="album bg-light">
                        <div class="container">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                            <?php foreach($searchBooks as $searchBook){ ?>
                                    <div class="col">
                                        <div class="card shadow-sm">

                                            <div class="card-body text-center">
                                                <h5 class="p-2 mb-1 bg-primary text-white"><?php echo ucwords(stripslashes($searchBook['name'])) ?></h5>
                                                <h5 class="pt-2 text-primary"><?php echo ucwords($searchBook['firstname']) . ' ' . ucwords($searchBook['lastname']) ?></h5>
                                                <a href="book-info.php?id=<?php echo $searchBook['id'] ?>" class="mt-0 mb-2">En savoir plus</a>
                                                <p class="p-1 mb-0 text-black"><strong><?php echo 'Prix : ' . number_format($searchBook['price_book'], 2, ',', ' ') . '€'?></strong></p>
                                                <form name="<?php echo $searchBook['id']?>" method="post" action="cart.php"><button type="submit" name="buttonCart" value='<?php echo $searchBook['id']; ?>' class='btn btn-dark mt-2 mb-3'>ajouter au panier</button></form>
                                                <a href="book-modif.php?id=<?php echo $searchBook['id']?>" class="text-secondary">Modifier livre</a>
                                                
                                            </div>
                                        </div>
                                    </div>                       
                                 <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    

<!-- SECTION TEST -->

        <p class="mt-4 text-center"><a href="add-book.php" class="text-center">Pour vendre votre livre, ajoutez-le au catalogue.</a></p>
        
        <?php include_once('footer.php');

            } else { ?>
                <div class="text-center">
                    <h1 class="mt-5">The Library Factory</h1>
                    <h2>Welcome !!!</h2>
                    <h6 class="mt-3">Pour vendre ou acheter des livres, authentifiez-vous</h6>
                    <a class="btn btn-primary mt-2" href="signin.php" role="button">Signin</a>
                </div>
        <?php } ?>

    </main> 
</body>
</html>