<?php 

session_start();

if(isset($_SESSION['login'])){
  $nameUser = $_SESSION['login'];
} else {
  $nameUser = '';
}

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top" aria-label="Tenth navbar example">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
        <ul class="navbar-nav">

          <?php if(!isset($_SESSION['login'])){ ?>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php"> </a>
            </li>
        <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">The Library Factory</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="book-add.php">Vendre un livre</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="cart.php">Panier</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="signout.php">Déconnexion</a>
            </li>

          <?php } ?>
        </ul>
      </div>
    </div>
</nav>
<?php if(isset($_SESSION['login'])){ ?><p class="text-white text-capitalize text-center bg-primary" href="#"><small><?php echo 'Bienvenue ' . $nameUser ?></small></p><?php } ?>


