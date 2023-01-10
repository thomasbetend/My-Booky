<?php 

$title="ChatBooky - Messages";

require('head.php');

?>



<?php


if (empty($_SESSION)) {

    header('location:index.php');
    
} else {

    include_once('functions.php');

    $queryConversations = 'SELECT source_user_id sud, user_id ud FROM notification JOIN user ON user.id=notification.user_id WHERE accepted_by_user_id = true AND accepted_by_source_user_id=true AND (user.id = ' . $_SESSION['id'] . ' OR source_user_id = ' . $_SESSION['id'] . ') ';
    $statementConversations = $pdo->query($queryConversations);
    $conversations = $statementConversations->fetchAll();

    ?>
    
        <div class="container w-50">
            <h2 class="text-center mt-5">Mes messages</h2>
            
            <?php foreach($conversations as $conversation){

                /* checking if sender is source_user_id or user_id - in other words : who is the source of the first invitation ? */

                if($conversation['sud'] === $_SESSION['id']){

                    $queryConverser = 'SELECT id, firstname, lastname, pseudo FROM user WHERE id = ' . $conversation['ud'];
                    $statementConverser = $pdo->query($queryConverser);
                    $converser = $statementConverser->fetch();
                    
                    ?>

                    <div class="card text-white bg-primary mb-4">
                        <div class="notif-message">
                            <a href="chat-message-conversation.php?id=<?php echo $converser['id'];?>" class="text-decoration-none text-white text-center link-message">
                                <h5 class="p-2 text-black"><?php echo ucwords($converser['pseudo']) ; ?></h5>
                            </a>
                        </div>
                        <div class="notif-message2">
                            <?php
                            /* messages notifications */
                            $queryNotifMessages = 'SELECT * FROM message WHERE user_destination_id = ' . $_SESSION['id'] . ' AND user_id = ' . $converser['id'] . ' AND  seen_by_user_destination=false';
                            $statementNotifMessages = $pdo->query($queryNotifMessages);
                            $notifMessages = $statementNotifMessages->fetchAll(); 
                            
                            if(!empty($notifMessages)){?>
                                <p class="chat-count-notif-1">
                                    <?php echo count($notifMessages);?>
                                </p>   
                            <?php } ?> 
                        </div>
                    </div>

            <?php } else { 

                    $queryConverser = 'SELECT id, firstname, lastname, pseudo FROM user WHERE id = ' . $conversation['sud'];
                    $statementConverser = $pdo->query($queryConverser);
                    $converser = $statementConverser->fetch();

            ?>
                    <div class="card bg-primary text-white mb-4">
                        <div class="notif-message">
                            <a href="chat-message-conversation.php?id=<?php echo $converser['id'];?>" class="text-decoration-none text-white text-center link-message">
                                <h5 class="p-2 text-black"><?php echo ucwords($converser['pseudo']) ; ?></h5>
                            </a>
                        </div>
                        <div class="notif-message2">
                            <?php
                            /* messages notifications */
                            $queryNotifMessages = 'SELECT * FROM message WHERE user_destination_id = ' . $_SESSION['id'] . ' AND user_id = ' . $converser['id'] . ' AND  seen_by_user_destination=false';
                            $statementNotifMessages = $pdo->query($queryNotifMessages);
                            $notifMessages = $statementNotifMessages->fetchAll(); 
                            
                            if(!empty($notifMessages)){?>
                                <p class="chat-count-notif-1">
                                    <?php echo count($notifMessages);?>
                                </p>   
                            <?php } ?> 
                        </div>
                    </div>
            <?php }} ?>

        </div>

<?php } ?>

<?php include_once('footer.php'); ?>

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">

$(document).ready(function domReady() {
    setInterval(function refreshPage() {
        $.ajax({
            method: 'GET',
            url: "chat-messages.php",
            success: function() {
                location.reload();
            }
        });
    }, 3000) 
});

</script>

</body>
</html>

