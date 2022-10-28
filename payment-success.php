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

                <h1 class="mt-5">Paiement réussi !</h1>
                    <h2>Merci d'avoir acheté chez nous.</h2>
                    <a class="btn btn-primary mt-2" href="index.php" role="button">Retourner au catalogue</a>
                </div>

    </main> 
    <?php 
        
    if(isset($_POST['buttonPayment'])){
    
    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');


    $queryOrder = 'INSERT INTO orders (user_id, total_price, total_number) VALUES (:user_id, :total_price, :total_number)';
    $statementOrder = $pdo->prepare($queryOrder);

    $statementOrder->bindValue(':user_id', $_SESSION['id'], \PDO::PARAM_STR );
    $statementOrder->bindValue(':total_price', array_sum($_SESSION['cart']['price']), \PDO::PARAM_STR );
    $statementOrder->bindValue(':total_number', array_sum($_SESSION['cart']['quantity']), \PDO::PARAM_STR );

    $statementOrder->execute();

    $_SESSION['cart'] = array();
    $_SESSION['cart']['book']=array();
    $_SESSION['cart']['quantity']=array();
    $_SESSION['cart']['price']=array();

    for($i=0; $i<1000; $i++){
        $_SESSION['cart']['quantity'][$i]=0;
        $_SESSION['cart']['price'][$i]=0;
    }

    } ?></body>
</html>