<?php 

$title="MyBooky - Panier";

require('head.php');

?>


<?php

if(empty($_SESSION)){

    header('location: index.php');

} else {

    if(!empty($_GET['id'])){

        include_once('functions.php');

        $id= testInput($_GET['id']);

        $_SESSION['cart']['quantity'][$id]=0;
        $_SESSION['cart']['price'][$id]=0;

        header('location: cart.php');
        exit();

    } else {?>

        <div class="container w-50 text-center">
            <h3 class="text-center text-primary mt-5">Page inexistante</h3>
            <a href="book-personal-space.php" class="text-center">Retour à votre espace</a>
        </div>

<?php }

} ?>

<?php include_once('footer.php'); ?>

</body>
</html>
