<?php 

session_start();

$pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

if(isset($_SESSION['login'])){

  $nameUser = $_SESSION['login'];

} else {
  
  $nameUser = '';

}

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

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
              <a class="nav-link active logo-mybooky" aria-current="page" href="index.php">MyBooky</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="book-personal-space.php">Mon espace</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="orders.php">Mes commandes</a>
            </li>
            <li class="nav-item">
              <div class="notif-navbar" id="notif-navbar">
                <a class="nav-link" href="chat-booky.php">ChatBooky 
                  <?php 
                  $queryNotifMessages = 'SELECT * FROM message WHERE user_destination_id = ' . $_SESSION['id'] . ' AND  seen_by_user_destination=false';
                  $statementNotifMessages = $pdo->query($queryNotifMessages);
                  $notifMessages = $statementNotifMessages->fetchAll();

                  $queryNotifInvits = 'SELECT * FROM notification WHERE user_id = ' . $_SESSION['id'] . ' AND accepted_by_source_user_id=true AND accepted_by_user_id=false AND type = \'invitation\'';
                  $statementNotifInvits = $pdo->query($queryNotifInvits);
                  $notifInvits = $statementNotifInvits->fetchAll();


                  if(!empty($notifMessages) || !empty($notifInvits)){ ?> <i class="fa-solid fa-circle small-red"></i><?php } ?>
                </a>
              </div>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="cart.php">Mon panier</span></a>
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

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">

$(document).ready(function domReady() {
    setInterval(function refreshNotifsNavBar() {
        $.ajax({
            method: 'GET',
            url: "nav-bar-refresh-notifs.php",
            success: function(data) {
                $("#notif-navbar").html(data);
            }
        });
    }, 3000) 
});

</script>