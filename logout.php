<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('nav-bar.php'); ?>

    <div class="container w-50 text-center">
        <form method="post" class="mt-5">
                <h1>Page de déconnexion</h1>
                <button name='button1' class="btn btn-primary mt-2">Se déconnecter</button>
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

</body>
</html>