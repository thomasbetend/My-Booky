<?php 

$title="MyBooky - Commandes";

require('head.php');

?>

<?php 

  include_once('nav-bar.php'); 

  if(empty($_SESSION)){

    header('location:index.php');

  } else {

    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
    
    /* all orders */
    $queryAllOrders = 'SELECT id, user_id FROM orders WHERE user_id = '  . $_SESSION['id'] . ' ORDER BY id DESC';
    $statementAllOrders = $pdo->query($queryAllOrders);
    $allOrders = $statementAllOrders->fetchAll(); 
    
    ?>

    <div class="container w-50 text-center">
      <h2 class="text-center mt-5">Mes commandes</h2>
    </div>

    <section class="h-100 h-custom" style="background-color: #eee;">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col">
            <div class="card">
              <div class="card-body p-4">
                <div class="row">
                  <div class="col-lg-12">
                    <hr>
                    <!-- displays each order -->
                    <?php 
                      if($allOrders){
                      foreach($allOrders as $allOrder){ ?>
                      <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                              <div class="d-flex flex-row align-items-center">
                                <div>
                                  <i class="fa-sharp fa-solid fa-book"></i>
                                </div>
                                <div class="ms-3">
                                  <h5>Commande n° <?php echo $allOrder['id']; ?></h5>

                                  <?php 
                                  
                                  /* all books from order */

                                  $queryAllBooks = 'SELECT o.user_id, o.id, o.total_price, ob.orders_id, ob.name_book name, ob.author author, ob.total_number total_number FROM orders_book as ob JOIN orders as o ON o.id=ob.orders_id WHERE o.id = ' . $allOrder['id'] . ' ORDER BY name ASC';
                                  $statementallBooks = $pdo->query($queryAllBooks);
                                  $allBooks = $statementallBooks->fetchAll();

                                  foreach($allBooks as $allBook){ ?>
                                    <p class="small mb-0"><?php echo ucfirst($allBook['name'] . '   //   ' . $allBook['author'] . '   //   Qté : ' . $allBook['total_number']);?></p>
                                  <?php } ?>
                                </div>
                              </div>
                              <div class="d-flex flex-row align-items-center">
                                <div style="width: 80px;">
                                  <h6 class="mb-0"><?php echo number_format($allBook['total_price'], 2, ',', ' ').' €'; ?></h5>
                                </div>
                              </div>
                            </div>
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

<?php } ?>

<?php include_once('footer.php'); ?>

</body>
</html>

