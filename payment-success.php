<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBooky - Paiement réussi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet"></head>
</head>
<body class="d-flex flex-column h-100">
    <main class="text-center">
            <?php include_once('nav-bar.php'); 

            if(empty($_SESSION)){

                header('location: index.php');

            } else {

                if(!empty($_SESSION['cart']['book'])){ ?>

                    <h2 class="mt-5">Paiement réussi !</h2>
                    <h3 class="text-secondary">Merci d'avoir acheté chez nous.</h3>

                    <?php if(isset($_POST['buttonPayment'])){

                            
                            $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

                            require_once('functions.php');
                        
                            /* insert infos into orders */

                            $queryOrder = 'INSERT INTO orders (user_id, total_price, total_number) VALUES (:user_id, :total_price, :total_number)';
                            $statementOrder = $pdo->prepare($queryOrder);
                        
                            $statementOrder->bindValue(':user_id', $_SESSION['id'], \PDO::PARAM_STR );
                            $statementOrder->bindValue(':total_price', array_sum($_SESSION['cart']['price']), \PDO::PARAM_STR );
                            $statementOrder->bindValue(':total_number', array_sum($_SESSION['cart']['quantity']), \PDO::PARAM_STR );
                        
                            $statementOrder->execute();

                            /* get info from orders */

                            $getOrder = 'SELECT * FROM orders WHERE user_id = ' . $_SESSION['id'] . ' ORDER by id DESC';
                            $statementGetOrder = $pdo->query($getOrder);
                            $lastOrder = $statementGetOrder->fetch();

                            /* insert info into orders_book */

                            foreach ($_SESSION['cart']['book'] as $key=>$book){

                                /* get info from book */


                                $getBook = 'SELECT id, price_book FROM book WHERE name = \'' . $_SESSION['cart']['book'][$key] . '\' ORDER by id DESC';
                                $statementGetBook = $pdo->query($getBook);
                                $lastBook = $statementGetBook->fetch();

                                /* insert */

                                $queryOrdersBook = 'INSERT INTO orders_book (orders_id, book_id, total_price, total_number, name_book, author) VALUES (:orders_id, :book_id, :total_price, :total_number, :name_book, :author)';
                                $statementOrdersBook = $pdo->prepare($queryOrdersBook);
                                $statementOrdersBook->bindValue(':orders_id', $lastOrder['id'], \PDO::PARAM_INT );
                                $statementOrdersBook->bindValue(':book_id', $lastBook['id'], \PDO::PARAM_INT );
                                $statementOrdersBook->bindValue(':total_price', ($_SESSION['cart']['quantity'][$lastBook['id']] * $lastBook['price_book']), \PDO::PARAM_STR );
                                $statementOrdersBook->bindValue(':total_number', $_SESSION['cart']['quantity'][$lastBook['id']], \PDO::PARAM_INT );
                                $statementOrdersBook->bindValue(':name_book', $_SESSION['cart']['book'][$lastBook['id']], \PDO::PARAM_STR );
                                $statementOrdersBook->bindValue(':author', $_SESSION['cart']['author'][$lastBook['id']], \PDO::PARAM_STR );
                                $statementOrdersBook->execute();
                        }

                    ?>  

                    <div class="album bg-light">
                        <div class="container w-50 mt-5 p-5">
                                    <div class="card shadow-sm p-3">

                                        <div class="card-body text-center">
                                            <h5 class="p-2 mb-1 bg-primary text-white">Commande n°<?php echo ($lastOrder['id']) ?></h5>
                                            <h5 class="mt-2"><?php echo ucwords($_SESSION['login']) ?></h5>
                                            <h5 class="pt-2 text-primary mb-3"> Prix total : <?php echo number_format($lastOrder['total_price'], 2, ',', ' ') . '€' ?></h5>
                                            <?php foreach ($_SESSION['cart']['book'] as $key=>$book){ ?>
                                                <h6> <?php echo $_SESSION['cart']['book'][$key] . '  //  ' . $_SESSION['cart']['author'][$key] . '       // Qté : ' . $_SESSION['cart']['quantity'][$key]; ?></h6>
                                                <?php } ?>
                                        </div>
                                    </div>
                        </div>
                        
                    </div>

                    <?php 

                    /* reinitialize carter */

                    $_SESSION['cart'] = array();
                    $_SESSION['cart']['book']=array();
                    $_SESSION['cart']['author']=array();
                    $_SESSION['cart']['quantity']=array();
                    $_SESSION['cart']['price']=array();
                
                    for($i=0; $i<1000; $i++){
                        $_SESSION['cart']['quantity'][$i]=0;
                        $_SESSION['cart']['price'][$i]=0;
                    }

                }} else {
                    echo "Commande non valable.";
                } ?>
        
    <div>
        <a class="btn btn-primary mt-2" href="index.php" role="button">Retourner au catalogue</a>
    </div>
    </main> 
    <?php include_once('footer.php'); ?>

</body>
</html>

<?php } ?>