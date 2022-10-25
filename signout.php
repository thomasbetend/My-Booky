<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">

    <?php include_once('nav-bar.php'); ?>

    <div class="container w-50 text-center">
        <form method="post" class="mt-5">
                <h2>Merci <?php echo(ucwords($_SESSION['login']));?> de votre visite !</h2>
                <h4>A bientôt</h4>
                <button name='button1' class="btn btn-primary mt-2">Signout</button>
            </div>
        </form>
    </div>

    <?php 
    if($_POST){
        $_SESSION = array();
        session_destroy();
        unset($_SESSION);
        header('location: index.php');
    }
    ?>

    <?php include_once('footer.php'); ?>


</body>
</html>