<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBooky - Déconnexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet"></head>
</head>
<body class="d-flex flex-column h-100">

    <?php include_once('nav-bar.php'); 

    if(empty($_SESSION)){

    header('location: index.php');

    } else { ?>

    <div class="container w-50 text-center">
        <form method="post" class="mt-5">
                <h3>Merci <?php echo(ucwords($_SESSION['login']));?> de votre visite !</h3>
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

    <?php include_once('footer.php'); ?>


</body>
</html>

<?php } ?>