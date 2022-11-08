<?php 

$title="MyBooky - Vendre un livre";

require('head.php');

?>

<?php 

if(empty($_SESSION)){

    header('location:index.php');

} else { ?>

    <div class="container w-50 text-center">
        <h3 class="text-center text-primary mt-5">Vous ne pouvez supprimer ce livre</h3>
        <a href="book-personal-space.php" class="text-center">Retour à votre espace</a>
    </div>

<?php } ?>

<?php include_once('footer.php'); ?>

</body>
</html>

