<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBooky - Info sur le livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5474cfcdca.js" crossorigin="anonymous"></script>
    <link href="styles.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

    <?php

    include_once('nav-bar.php');

    if (empty($_SESSION)) {

        header('location:index.php');
        
    } else {

        include_once('functions.php');

        $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

        $queryUser = 'SELECT user.id, firstname, lastname, book.id FROM user LEFT JOIN book ON user.id=book.user_id';
        $statementUser = $pdo->query($queryUser);
        $user = $statementUser->fetch();
        ?>
        
            <div class="container w-50">
                <h2 class="text-center mt-5">Mes messages</h2>

                <div class="card text-center mt-4">
                    <h5 class="p-2 text-primary"></h5>
                    <h4 class="p-2 text-black title-sumup"><?php if($book['sumup'] !== ''){ echo "Résumé" ;} ?></h4>
                    
                    <p class="p-4 pt-0 mb-0 text-black"><?php echo ucfirst(stripslashes($book['sumup'])); ?></p>
                    
                </div>
                
                <!-- comments -->
                <?php
                    require_once('comment.php')
                ?>

            </div>

        <?php include_once('footer.php'); ?>

</body>
</html>

<?php } ?>