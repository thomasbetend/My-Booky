
<?php

$title="ChatBooky - Conversation";

require('head.php');

?>

<?php

if (empty($_SESSION)) {

    header('location:index.php');
    
}

if(!empty($_GET['id'])){

    include_once('functions.php');

    $id = testInput($_GET['id']);

    /* initializing $_SESSION['id_message'] to get it in chat-messages-refresh.php. Because when it refreshes, variables are empty */

    $_SESSION['id_message'] = $id;

    /* authorization to see messages */

    $queryAuthorization = 'SELECT id FROM notification WHERE accepted_by_source_user_id=true AND ( user_id = ' . $_SESSION['id'] . ' AND source_user_id = :id ) OR ( user_id = :id AND source_user_id = ' . $_SESSION['id'] . ' )';
    $statementAuthorization = $pdo->prepare($queryAuthorization);
    $statementAuthorization->bindValue(':id', $id, PDO::PARAM_INT);
    $statementAuthorization->execute();
    $authorization = $statementAuthorization->fetch();

    if(!empty($authorization)){


        /* binding and securizing id */

        $queryUserConversation2 = 'SELECT id, firstname, lastname, pseudo FROM user where id = :id';
        $statementUserConversation2 = $pdo->prepare($queryUserConversation2);
        $statementUserConversation2->bindValue(':id', $id, PDO::PARAM_INT);
        $statementUserConversation2->execute();
        $userConversation2 = $statementUserConversation2->fetch();

        /* update notifications */

        $queryUpdateNotification = 'UPDATE notification SET accepted_by_user_id=true WHERE source_user_id = :id AND user_id = ' . $_SESSION['id'] . ' AND type=\'invitation\' AND accepted_by_source_user_id=true ' ;
        $statementUpdateNotification = $pdo->prepare($queryUpdateNotification);
        $statementUpdateNotification->bindValue(':id', $id, PDO::PARAM_INT);
        $statementUpdateNotification->execute();

        /* update message seen */

        $queryMessageSeen = 'UPDATE message SET seen_by_user_destination=true WHERE user_destination_id = ' . $_SESSION['id'] . ' AND user_id = :id';
        $statementMessageSeen = $pdo->prepare($queryMessageSeen);
        $statementMessageSeen->bindValue(':id', $id, PDO::PARAM_INT);
        $statementMessageSeen->execute();

        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])){

            /* insert message in database */

            $queryInsertMessage = 'INSERT INTO message (user_id, user_destination_id, content_message, date_message, time_message, seen_by_user_destination) VALUES (:user_id, :user_destination_id, :content_message, :date_message, :time_message, :seen)';
            $statementInsertMessage = $pdo->prepare($queryInsertMessage);
            $statementInsertMessage->bindValue(':user_id', $_SESSION['id'], \PDO::PARAM_INT);
            $statementInsertMessage->bindValue(':user_destination_id', $id, \PDO::PARAM_INT);
            $statementInsertMessage->bindValue(':content_message', $_POST['message'], \PDO::PARAM_STR);
            $statementInsertMessage->bindValue(':date_message', date( "Y-m-d", time()), \PDO::PARAM_STR);
            $statementInsertMessage->bindValue(':time_message', date( "Y-m-d H-i-s", time()), \PDO::PARAM_STR);
            $statementInsertMessage->bindValue(':seen', false, \PDO::PARAM_BOOL);
            $statementInsertMessage->execute();

            header('location:chat-message-conversation.php?id=' . $_GET['id']);
            exit;

        } ?>

        <div class="container w-75">
            
            <div>
                <h3 class="text-center mt-5">Conversation avec</h3>
                <h4 class="text-center"><?php echo ucwords($userConversation2['pseudo']); ?></h4>
            </div>

            <div class="text-center mt-4"> 
                <form action="" method="post">
                    <input type="text" placeholder="tapez votre message" class="form-control" name="message"></input>
                </form>
            </div>
            <div id="refresh-messages">
                <?php include_once('chat-messages-refresh.php'); ?>
            </div>

        </div>

    <?php } else { ?>

        <div class="container w-50 text-center">
            <h3 class="text-center text-primary mt-5">Page inexistante</h3>
            <a href="chat-booky.php" class="text-center">Retour à ChatBooky</a>
        </div>

    <?php }

} else { ?>

    <div class="container w-50 text-center">
        <h3 class="text-center text-primary mt-5">Page inexistante</h3>
        <a href="chat-booky.php" class="text-center">Retour à ChatBooky</a>
    </div>

<?php } ?>

<?php include_once('footer.php'); ?>

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">

$(document).ready(function domReady() {
    setInterval(function refreshMessages() {
        $.ajax({
            method: 'GET',
            url: "chat-messages-refresh.php",
            success: function(data) {
                $("#refresh-messages").html(data);
            }
        });
    }, 3000) 
});

</script>

</script>
</body>
</html>
