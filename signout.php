<?php 

$title="MyBooky - Connexion";

require('head.php');

?> 

<?php

if(empty($_SESSION)){

    header('location: index.php');

} else { ?>

    <div class="container w-50 text-center">
        <form method="post" class="mt-5">
                <h3>Merci de votre visite,<br><?php echo(ucwords($_SESSION['login']));?> !</h3>
                <h4>A bientôt</h4>
                <button name='button1' class="btn btn-primary mt-2">Déconnexion</button>
            </div>
        </form>
    </div>

    <?php 

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $_SESSION = array();
        session_destroy();
        unset($_SESSION);
        header('location: index.php');
    }
    ?>

<?php } ?>

<?php include_once('footer.php'); ?>

</body>
</html>

