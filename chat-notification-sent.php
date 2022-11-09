<?php 

$title="ChatBooky";

require('head.php');

?>

<?php 

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

<?php } ?>

<?php include_once('footer.php'); ?>

</body>
</html>

