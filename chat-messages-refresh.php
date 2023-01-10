<?php 

require_once('functions.php');

if(empty($_SESSION)) {
    session_start();
    $id=$_SESSION['id_message'];
    $pdo = new PDO('mysql:host=localhost; dbname=the_library_factory', 'root', '');
}


$queryMessages = 'SELECT id, user_id, user_destination_id, content_message, date_message, time_message FROM message WHERE (user_id = :id AND user_destination_id = ' . $_SESSION['id'] . ') OR (user_id = ' . $_SESSION['id']. ' AND user_destination_id = :id) ORDER by time_message DESC LIMIT 0, 20';
$statementMessages = $pdo->prepare($queryMessages);
$statementMessages->bindValue(':id', $id, PDO::PARAM_INT);
$statementMessages->execute();
$messages = $statementMessages->fetchAll();

if($messages){

    foreach($messages as $message){?>
        <div class="card mt-4 pt-2 pb-0 <?php if($message['user_id'] === $_SESSION['id']) {echo "message-bg-colored";} else {echo "message-bg-white";} ?>">
            <p><?php echo $message['content_message'] ?></p>

            <!-- get message sender -->

            <?php $querySenderUser = 'SELECT user.id, firstname, lastname, pseudo FROM user JOIN message ON user.id = message.user_id WHERE user.id = ' . $message['user_id'];
            $statementSenderUser = $pdo->query($querySenderUser);
            $senderUser = $statementSenderUser->fetch();
            ?>
                                        
            <div class="comment-options">

                <!-- delete message only for user who posted the comment -->

                <?php  if($_SESSION['id'] === $senderUser['id']){ ?>
                        <a href="chat-message-delete.php?id=<?php echo $message['id'];?>" class="delete-comment">Supprimer votre message</a>
                <?php } else { ?>
                        <p> </p>
                <?php }  ?>

                <!-- message sender -->
                
                
                <p class="legend-italic-right">Envoyé par <?php echo ucwords($senderUser['pseudo']);?> le <?php echo (new DateTime($message['time_message']))->format("d/m/Y H:i:s"); ?></p>

            </div>

        </div>
<?php }

} ?>
