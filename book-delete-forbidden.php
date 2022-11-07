<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBooky - Suppression interdite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet"></head>

</head>
<body class="d-flex flex-column h-100">

<?php include_once('nav-bar.php'); 

if(empty($_SESSION)){

    header('location:index.php');

} else { ?>

    <div class="container w-50 text-center">
        <h3 class="text-center text-primary mt-5">Vous ne pouvez supprimer ce livre</h3>
        <a href="book-personal-space.php" class="text-center">Retour à votre espace</a>
    </div>

    <?php include_once('footer.php'); ?>


</body>
</html>

<?php } ?>