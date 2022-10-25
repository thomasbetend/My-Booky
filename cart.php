<?php
$pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
$query = 'SELECT price_book, book.id id, name FROM book LEFT JOIN author ON author.id=book.author_id';
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
    include_once('functions.php');
    ?>

    <div class="container w-50 text-center">

    <h1 class="text-center mt-5">Votre panier</h1>
    <?php foreach ($books as $book){ ?>
        <?php if(!empty($_GET)){
            if ($_GET['id'] == $book['id']) { ?>
            <p><?php echo 'Vous avez ajouté ' . $_SESSION['cart']['book'][$_GET['id']] . ' livre du ' . $book['name'];?></p>
            <?php }
        }} ?>

    </div>

    <section class="h-100 h-custom" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card">
                <div class="card-body p-4">

                    <div class="row">

                    <div class="col-lg-7">
                        <h5 class="mb-3"><a href="#!" class="text-body"><i
                            class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping</a></h5>
                        <hr>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <p class="mb-1">Shopping cart</p>
                            <p class="mb-0">You have 4 items in your cart</p>
                        </div>
                        <div>
                            <p class="mb-0"><span class="text-muted">Sort by:</span> <a href="#!"
                                class="text-body">price <i class="fas fa-angle-down mt-1"></i></a></p>
                        </div>
                        </div>

                        <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center">
                                <div>
                                <img
                                    src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-shopping-carts/img1.webp"
                                    class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                                </div>
                                <div class="ms-3">
                                <h5>Iphone 11 pro</h5>
                                <p class="small mb-0">256GB, Navy Blue</p>
                                </div>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                                <div style="width: 50px;">
                                <h5 class="fw-normal mb-0">2</h5>
                                </div>
                                <div style="width: 80px;">
                                <h5 class="mb-0">$900</h5>
                                </div>
                                <a href="#!" style="color: #cecece;"><i class="fas fa-trash-alt"></i></a>
                            </div>
                            </div>
                        </div>
                        </div>

                    </div>
                    <div class="col-lg-5">

                        <div class="card bg-primary text-white rounded-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Prix total</h5>
                            </div>


                            <div class="d-flex justify-content-between mb-4">
                            <p class="mb-2">Total(Incl. taxes)</p>
                            <p class="mb-2">$4818.00</p>
                            </div>

                            <button type="button" class="btn btn-info btn-block btn-lg">
                            <div class="d-flex justify-content-between">
                                <span>$4818.00</span>
                            </div>
                            </button>

                        </div>
                        </div>

                    </div>

                    </div>

                </div>
                </div>
            </div>
            </div>
        </div>
    </section>


</body>
</html>