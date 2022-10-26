<?php
$pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
$query = 'SELECT firstname, lastname, price_book, book.id id, name, sumup FROM book LEFT JOIN author ON author.id=book.author_id';
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

<?php 

include_once('nav-bar.php');

    foreach($books as $book){
        if($book['id'] == $_GET['id']){ ?>
            <div class="container w-50">
                <div class="card text-center mt-4">
                    <h3 class="p-2 mb-1 bg-primary text-white"><?php echo ucwords(stripslashes(($book['name']))) ?></h3>
                    <h5 class="p-2 text-primary"><?php echo ucwords($book['firstname']) . ' ' . ucwords($book['lastname']) ?></h5>
                    <h4 class="p-2 text-black">Résumé</h4>
                    <p class="p-4 mb-0 text-black"><?php echo ucfirst(stripslashes($book['sumup'])) ?></p>
                    <p class="p-1 mb-0 text-black"><strong><?php echo 'Prix : ' . number_format($book['price_book'], 2, ',', ' ') . '€'?></strong></p>
                    <form action="" method="post"><button type="button" class='btn btn-dark mt-2 mb-2' name='button-add-cart' value="">ajouter au panier</button></form>
                        <?php if($_POST){
                            $_SESSION['cart']['book']['book_c_id'] = $book['id'];
                        }?>
                                        <a href="index.php" class = "btn2 mb-4 mt-2 text-center">Retour à la liste</a>

                </div>
            </div>
        <?php }
        } ?>

    <?php include_once('footer.php'); ?>


</body>
</html>