<?php 

$title="MyBooky - Panier";

require('head.php');

?>

<?php 

  include_once('nav-bar.php'); 

  if(empty($_SESSION)){

    header('location:index.php');
    
  } else {

  $queryBook = 'SELECT price_book, book.id id, firstname, lastname, name FROM book LEFT JOIN author ON author.id=book.author_id';
  $statementBook = $pdo->query($queryBook);
  $books = $statementBook->fetchAll();
  include_once('functions.php');


  if(!empty($_POST['buttonCart'])) {

      $buttonCart = $_POST['buttonCart'];

      $_SESSION['cart']['quantity'][$buttonCart]+=1;
      foreach($books as $book){
        if($buttonCart == $book['id']){
          $_SESSION['cart']['price'][$buttonCart] = $_SESSION['cart']['quantity'][$buttonCart] * $book['price_book'];
        }
      }
  } 
 
?>

<div class="container w-50 text-center">
  <h2 class="text-center mt-5">Mon panier</h2>
</div>

<section class="h-100 h-custom" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-lg-7">
                <h5 class="mb-3"><a href="index.php" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Retourner au catalogue de livres</a></h5>
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div>
                    <p class="mb-0 text-primary">Vous avez <?php echo array_sum($_SESSION['cart']['quantity']);?> livres dans votre panier</p>
                  </div>
                </div>
                <!-- display each book -->
                <?php foreach($books as $book){
                if($_SESSION['cart']['quantity'][$book['id']]>0){  
                  $_SESSION['cart']['book'][$book['id']] = ucfirst($book['name']);
                  $_SESSION['cart']['author'][$book['id']] = ucwords($book['firstname'] . ' ' . $book['lastname']);
                  ?>


                  <div class="card mb-3">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                          <div>
                            <i class="fa-sharp fa-solid fa-book"></i>
                          </div>
                          <div class="ms-3">
                            <h5><?php echo stripslashes(ucfirst($book['name'])); ?></h5>
                            <p class="small mb-0"><?php echo stripslashes(ucwords($book['firstname'] . ' ' . $book['lastname'])); ?></p>
                          </div>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                          <div style="width: 80px;">
                            <h6 class="mb-0"><?php echo number_format($_SESSION['cart']['price'][$book['id']], 2, ',', ' ') .' €'; ?></h5>
                          </div>
                          <div style="width: 50px;">
                            <h6 class="fw-normal mb-0"><?php echo $_SESSION['cart']['quantity'][$book['id']] ?></h5>
                          </div>
                          <div>
                            <a href="cart-delete.php?id=<?php echo $book['id']?>" style="color: #7F7F7F;"><i class="fas fa-trash-alt"></i></a>
                            <a href="cart-add.php?id=<?php echo $book['id']?>" style="color: #7F7F7F;"><i class="fas fa-plus"></i></a>
                            <a href="cart-less.php?id=<?php echo $book['id']?>" style="color: #7F7F7F;"><i class="fas fa-minus"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php 
                }} ?>
                

              </div>

              <div class="col-lg-5">
                <div class="card bg-primary text-white rounded-3">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                      <h5 class="mb-0">Prix Total</h5>
                    </div>
                    <!-- display total price -->
                    <h4 class="mb-2"><?php  
                          echo number_format(array_sum($_SESSION['cart']['price']), 2, ',', ' ') . ' €'?>
                    </h4>
                    <form method="post" name="payment-form" action="payment-success.php">
                      <button type="submit" name="buttonPayment" class="btn btn-info mt-2 mb-2">Payer</button>
                    </form>
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

<?php } ?>

<?php include_once('footer.php'); ?>

</body>
</html>

