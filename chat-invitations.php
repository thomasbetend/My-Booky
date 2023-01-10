<?php 

$title="ChatBooky - Invitations";

require('head.php');

?>

<?php

if (empty($_SESSION)) {

    header('location:index.php');
    
} else {

    include_once('functions.php');

    $queryInvits = 'SELECT id, user_id, source_user_id, accepted_by_user_id FROM notification WHERE user_id = ' . $_SESSION['id'] . ' AND accepted_by_source_user_id=true AND accepted_by_user_id=false AND type = \'invitation\'';
    $statementInvits = $pdo->query($queryInvits);
    $invits = $statementInvits->fetchAll();

    ?>
    
    <div class="container w-50">
        <h2 class="text-center mt-5">Invitations reçues</h2>

        <?php

        if(!empty($invits)){
            foreach($invits as $invit) {
                if(!empty($invit['source_user_id'])){
                $querySender = 'SELECT id, firstname, lastname FROM user WHERE id = ' . $invit['source_user_id'] . ' ORDER by lastname';
                $statementSender = $pdo->query($querySender);
                $sender = $statementSender->fetch(); ?>

                <div class="card text-center mt-4">
                    <div class="accept-invitation">
                        <h5 class="p-2 text-primary">Invitation de 
                            <?php if(!empty($sender)){ echo ucwords($sender['firstname'] . ' ' . $sender['lastname']); } ?>
                        </h5>            
                        <div class="button-invitation">
                            <a href="chat-message-conversation.php?id=<?php echo $sender['id'];?>"><button type="submit" class="btn btn-primary">Accepter</button></a>
                            <button type="submit" class="btn btn-secondary">Refuser</button>
                        </div>
                    </div>
                </div>
        <?php }}} else { ?>
            <p class="text-center"><?php echo "Vous n'avez pas d'invitations"; ?></p>
        <?php } ?>

    </div>

<?php } ?>

<?php include_once('footer.php'); ?>

</body>
</html>
