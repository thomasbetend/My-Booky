<?php


if($_SERVER['REQUEST_METHOD'] === 'POST'){

$pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

$query = 'DELETE FROM book WHERE id= ' . $_GET['id'];
$stmt= $pdo->prepare($query);
$stmt->execute();


header('location: index.php');
exit();
}

?>

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
                <button type="submit" class="form-control btn-secondary">Validez la suppression</button>
        </form>
    </div>


    <?php include_once('footer.php'); ?>


</body>
</html>

