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


        $queryNotificationAlreadySent = 'SELECT n.id FROM notification n WHERE source_user_id = ' . $_SESSION['id'] . ' AND user_id = ' . $userId . ' AND accepted_by_source_user_id=true';
        $stmtNotificationAlreadySent = $pdo->query($queryNotificationAlreadySent);
        $notificationAlreadySent = $stmtNotificationAlreadySent->fetch(); 

        if($notificationAlreadySent){ ?>

            <div class="container w-50 text-center">
                <h3 class="text-center mt-5">Notification déjà envoyée</h3>
                <a href="chat-booky.php" class="text-center">Retour à ChatBooky</a>
            </div>
            
        <?php } else {

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

        include_once('functions.php');

        $queryUpdateNotification = 'INSERT INTO notification (user_id, type, source_user_id, accepted_by_source_user_id, accepted_by_user_id) VALUES (:user_id, :type, :source_user_id, :accepted_by_source_user_id, :accepted_by_user_id)';
        $statementUpdateNotification = $pdo->prepare($queryUpdateNotification);
        $statementUpdateNotification->bindValue(':user_id', testInput($_POST['select-chat-user-id']), PDO::PARAM_INT);
        $statementUpdateNotification->bindValue(':source_user_id', $_SESSION['id'], PDO::PARAM_INT);
        $statementUpdateNotification->bindValue(':type', 'invitation', PDO::PARAM_STR);
        $statementUpdateNotification->bindValue(':accepted_by_source_user_id', true, PDO::PARAM_BOOL);
        $statementUpdateNotification->bindValue(':accepted_by_user_id', false, PDO::PARAM_BOOL);
        $statementUpdateNotification->execute();
        
    }


        
    } else {
        header('location:chat-booky.php');
    }

    ?>

    <?php include_once('footer.php'); ?>


</body>
</html>

<?php } ?>