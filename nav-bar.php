<?php 

session_start();

if(isset($_SESSION['login'])){
  $nameUser = $_SESSION['login'];
} else {
  $nameUser = '';
}

?>



<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
  <a class="navbar-brand" href="index.php">The Library Factory</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link text-capitalize" href="#">Bienvenue <?php echo $nameUser ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="signin.php">Signin</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Panier</span></a>
      </li>
    </ul>

  </div>
</nav>