<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Library Factory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('nav-bar.php'); ?>

    <div class="container w-50">
        <?php  
            if (isset($_SESSION['login'])) {?>
                <h1 class="text-center text-primary mt-5">Liste des livres</h1>
                <div class="card text-center">
                    <h6 class="p-2 mb-2 bg-primary text-white">Livre 1</h6>
                </div>
        <?php } else { ?>
                <div class="text-center">
                    <h1 class="mt-5">The Library Factory</h1>
                    <h2>Welcome !!!</h2>
                    <h6 class="mt-3">Pour voir la liste des livres, authentifiez-vous</h6>
                    <a class="btn btn-primary mt-2" href="login.php" role="button">Authentification</a>
                </div>
        <?php } ?>
    </div>

</body>
</html>