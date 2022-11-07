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

} else {

    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

    if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['select-chat-user-id'])){

        require_once('functions.php');

        $userId = testInput($_POST['select-chat-user-id']);

        $queryUser = 'SELECT id, firstname, lastname FROM user WHERE id = ' . $userId . ' ORDER BY lastname';
        $statementUser = $pdo->query($queryUser);
        $user = $statementUser->fetch(); 

        ?>

        <div class="container w-50 text-center">
            <h3 class="text-center mt-5">Notification envoyée à <?php echo ucwords($user['firstname'] . ' ' . $user['lastname']); ?></h3>
            <a href="chat-booky.php" class="text-center">Retour à ChatBooky</a>
        </div>


        <!-- insertion of notification, type invitation -->

        <?php 
        $queryInsertUserIdInNotification = 'INSERT INTO notification (user_id, type, seen, source_user_id) VALUES (:user_id, :type, :seen, :source_user_id)';
        $stmtInsertUserIdInNotification = $pdo->prepare($queryInsertUserIdInNotification);
        $stmtInsertUserIdInNotification->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmtInsertUserIdInNotification->bindValue(':source_user_id', $_SESSION['id'], \PDO::PARAM_INT);
        $stmtInsertUserIdInNotification->bindValue(':type', "invitation", \PDO::PARAM_STR);
        $stmtInsertUserIdInNotification->bindValue(':seen', false, \PDO::PARAM_BOOL);
        $stmtInsertUserIdInNotification->execute();

        
    } else {
        header('location:chat-booky.php');
    }

    ?>

    <?php include_once('footer.php'); ?>


</body>
</html>

<?php } ?>