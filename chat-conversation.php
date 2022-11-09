<?php 

$title="ChatBooky - Conversation";

require('head.php');

?>

<?php

if (empty($_SESSION)) {

    header('location:index.php');
    
} else {

    if(!empty($_GET['id'])){

        include_once('functions.php');

        $id = testInput($_GET['id']);

        /* authorization to see messages */

        $queryAuthorization = 'SELECT id FROM notification WHERE accepted_by_source_user_id=true AND ( user_id = ' . $_SESSION['id'] . ' AND source_user_id = :id ) OR ( user_id = :id AND source_user_id = ' . $_SESSION['id'] . ' )';
        $statementAuthorization = $pdo->prepare($queryAuthorization);
        $statementAuthorization->bindValue(':id', $id, PDO::PARAM_INT);
        $statementAuthorization->execute();
        $authorization = $statementAuthorization->fetch();

        if(!empty($authorization)){


            /* binding and securizing id */
            $queryUserConversation2 = 'SELECT id, firstname, lastname FROM user where id = :id';
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

                $queryInsertMessage = 'INSERT INTO message (user_id, user_destination_id, content_message, date_message, seen_by_user_destination) VALUES (:user_id, :user_destination_id, :content_message, :date_message, :seen)';
                $statementInsertMessage = $pdo->prepare($queryInsertMessage);
                $statementInsertMessage->bindValue(':user_id', $_SESSION['id'], \PDO::PARAM_INT);
                $statementInsertMessage->bindValue(':user_destination_id', $id, \PDO::PARAM_INT);
                $statementInsertMessage->bindValue(':content_message', $_POST['message'], \PDO::PARAM_STR);
                $statementInsertMessage->bindValue(':date_message', date( "Y-m-d", time()), \PDO::PARAM_STR);
                $statementInsertMessage->bindValue(':seen', false, \PDO::PARAM_BOOL);
                $statementInsertMessage->execute();

            } ?>

            <div class="container w-50">

                
                <div class="container w-50">
                    <h3 class="text-center mt-5">Conversation avec</h3>
                    <h5 class="text-center"><?php echo ucwords($userConversation2['firstname'] . ' ' . $userConversation2['lastname']); ?></h5>
                </div>

                <?php 
                
                $queryMessages = 'SELECT id, user_id, user_destination_id, content_message, date_message FROM message WHERE (user_id = ' . $id . ' AND user_destination_id = ' . $_SESSION['id'] . ') OR (user_id = ' . $_SESSION['id']. ' AND user_destination_id = ' . $id . ') ORDER by date_message DESC';
                $statementMessages = $pdo->query($queryMessages);
                $messages = $statementMessages->fetchAll();


                if($messages){
                
                    foreach($messages as $message){?>
                        <div class="card text-center mt-4 pt-2 pb-0">
                            <p><?php echo $message['content_message'] ?></p>

                            <!-- get message sender -->

                            <?php $querySenderUser = 'SELECT user.id, firstname, lastname FROM user JOIN message ON user.id = message.user_id WHERE user.id = ' . $message['user_id'];
                            $statementSenderUser = $pdo->query($querySenderUser);
                            $senderUser = $statementSenderUser->fetch();
                            
                            ?>
                            
                            <div class="comment-options">

                                <!-- delete message only for user who posted the comment -->

                                <?php  if($_SESSION['id'] === $senderUser['id']){ ?>
                                        <a href="chat-message-delete.php?id=<?php echo $message['id'];?>" class="delete-comment">Supprimer votre message</a>
                                <?php } else { ?>
                                        <p> </p>
                                <?php } ?>

                                <!-- message sender -->

                                <p class="legend-italic-right">Envoyé par <?php echo ucwords($senderUser['firstname'] . ' '. $senderUser['lastname']);?> le <?php echo (new DateTime($message['date_message']))->format("d/m/Y"); ?></p>

                            </div>

                        </div>

                <?php }} else {
                    echo "pas de messages.";
                } ?>

                <div class="card text-center mt-4"> 
                    <form action="" method="post">
                        <input type="text" placeholder="tapez votre message" class="form-control" name="message"></input>
                    </form>
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

<?php }

} ?>

<?php include_once('footer.php'); ?>

</body>
</html>
