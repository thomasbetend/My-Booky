<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookyMe - Paiement réussi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">
    <main class="text-center">
            <?php include_once('nav-bar.php'); ?>

                <h2 class="mt-5">Paiement réussi !</h2>
                <h3 class="text-secondary">Merci d'avoir acheté chez nous.</h3>

                <?php if(isset($_POST['buttonPayment'])){
                        
                        $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
                    
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


                ?>  

                <div class="album bg-light">
                    <div class="container w-50 mt-5 p-5">
                                <div class="card shadow-sm p-3">

                                    <div class="card-body text-center">
                                        <h5 class="p-2 mb-1 bg-primary text-white">Commande n°<?php echo ($lastOrder['id']) ?></h5>
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

            }
                ?>
        
    <div>
        <a class="btn btn-primary mt-2" href="index.php" role="button">Retourner au catalogue</a>
    </div>
    </main> 
    <?php include_once('footer.php'); ?>

</body>
</html>