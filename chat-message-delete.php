<?php 

$title="ChatBooky";

require('head.php');

?>


<?php

if(empty($_SESSION)){

    header('location: index.php');

} else {

    include_once('functions.php');

    $id = testInput($_GET['id']);

    if(!empty($_GET['id'])) {

        /* verifying if message exists */

        $queryExistingMessage = 'SELECT id, user_destination_id FROM message WHERE id = :id AND user_id = ' . $_SESSION['id'];
        $statementExistingMessage = $pdo->prepare($queryExistingMessage);
        $statementExistingMessage->bindValue(':id', $id, PDO::PARAM_INT);
        $statementExistingMessage->execute();
        $existingMessage = $statementExistingMessage->fetch();

        if($existingMessage){

            $queryDeleteMessage = 'DELETE FROM message WHERE id = ' . $existingMessage['id'];
            $statementDeleteMessage = $pdo->prepare($queryDeleteMessage);
            $statementDeleteMessage->execute();
        
            header('location:chat-message-conversation.php?id=' . $existingMessage['user_destination_id']);
            exit();

        } else { ?>     
        
            <div class="container w-50 text-center">
                <h3 class="text-center text-primary mt-5">Page inexistante</h3>
                <a href="index.php" class="text-center">Retour au catalogue</a>
            </div>

        <?php }

    } else { ?>     
        
            <div class="container w-50 text-center">
                <h3 class="text-center text-primary mt-5">Page inexistante</h3>
                <a href="index.php" class="text-center">Retour au catalogue</a>
            </div>

    <?php } ?>

<?php } ?>
    
</body>
</html>

