<?php

if(empty($_SESSION)){
    session_start();
    $pdo = new PDO('mysql:host=localhost; dbname=the_library_factory', 'root', '');
}
?>

<a class="nav-link" href="chat-booky.php">ChatBooky 
    <?php 
    $queryNotifMessages = 'SELECT * FROM message WHERE user_destination_id = ' . $_SESSION['id'] . ' AND  seen_by_user_destination=false';
    $statementNotifMessages = $pdo->query($queryNotifMessages);
    $notifMessages = $statementNotifMessages->fetchAll();

    $queryNotifInvits = 'SELECT * FROM notification WHERE user_id = ' . $_SESSION['id'] . ' AND accepted_by_source_user_id=true AND accepted_by_user_id=false AND type = \'invitation\'';
    $statementNotifInvits = $pdo->query($queryNotifInvits);
    $notifInvits = $statementNotifInvits->fetchAll();


    if(!empty($notifMessages) || !empty($notifInvits)){ ?> <i class="fa-solid fa-circle small-red"></i><?php } ?>
</a>