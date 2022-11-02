<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookyMe - Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5474cfcdca.js" crossorigin="anonymous"></script>
</head>
<style>
    h1, h2, h3, h4, h5, h6 {
        font-weight: 300;
    }

    h1 {
        font-size: 2.7rem;
    }
    h5 {
        font-size: 1.5em;
    }
</style>
<body class="d-flex flex-column h-100">

<?php 

  include_once('nav-bar.php'); 

  if(empty($_SESSION)){
    header('location:index.php');
  } else {

  $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

  $queryOrders = 'SELECT o.user_id, o.id, o.total_price, book_id, orders_id, name FROM orders_book as ob JOIN book as b ON b.id=ob.book_id RIGHT JOIN orders as o ON o.id=ob.orders_id WHERE o.user_id = ' . $_SESSION['id'];
  $statementOrders = $pdo->query($queryOrders);
  $orders = $statementOrders->fetchAll();

  
?>

<div class="container w-50 text-center">
  <h1 class="text-center mt-5">Mes commandes</h1>
</div>

<section class="h-100 h-custom" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-lg-7">
                <hr>
                <!-- display each order -->
                <?php 
                  if($orders){
                  foreach($orders as $order){ ?>

                  <div class="card mb-3">
                    <div class="card-body">
                      <a href="" class="">
                        <div class="d-flex justify-content-between">
                          <div class="d-flex flex-row align-items-center">
                            <div>
                              <i class="fa-sharp fa-solid fa-book"></i>
                            </div>
                            <div class="ms-3">
                              <h5>Commande n° <?php echo $order['id']; ?></h5>
                            </div>
                          </div>
                          <div class="d-flex flex-row align-items-center">
                            <div style="width: 80px;">
                              <h6 class="mb-0"><?php echo $order['total_price'].' €'; ?></h5>
                            </div>
                            <div style="width: 50px;">
                            </div>
                            <div>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                  <?php 
                }} else { ?>
                <p> pas de commandes </p>
                <?php } ?>

              </div>

              

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<?php include_once('footer.php'); ?>

</body>
</html>

<?php } ?>