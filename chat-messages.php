<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBooky - Info sur le livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5474cfcdca.js" crossorigin="anonymous"></script>
    <link href="styles.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

    <?php

    include_once('nav-bar.php');

    if (empty($_SESSION)) {

        header('location:index.php');
        
    } else {

        include_once('functions.php');

        $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

        $queryConversations = 'SELECT source_user_id sud, user_id ud FROM notification JOIN user ON user.id=notification.user_id WHERE accepted_by_user_id = true AND accepted_by_source_user_id=true AND (user.id = ' . $_SESSION['id'] . ' OR source_user_id = ' . $_SESSION['id'] . ') ';
        $statementConversations = $pdo->query($queryConversations);
        $conversations = $statementConversations->fetchAll();

        
        ?>
        
            <div class="container w-50">
                <h2 class="text-center mt-5">Mes messages</h2>
                <?php foreach($conversations as $conversation){

                    if($conversation['sud'] === $_SESSION['id']){

                        $queryConverser = 'SELECT id, firstname, lastname FROM user WHERE id = ' . $conversation['ud'];
                        $statementConverser = $pdo->query($queryConverser);
                        $converser = $statementConverser->fetch();

                        ?>
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="notif-invitations">
                                    <a href="chat-conversation.php?id=<?php echo $converser['id'];?>">
                                        <div class="card text-center mt-4">
                                            <h5 class="p-2 text-black title-sumup"><?php echo ucwords($converser['firstname'] . ' ' . $converser['lastname']) ; ?></h5>
                                        </div>
                                    </a>
                                    <p class="chat-count-invitations">
                                    <?php
                                    /* all notifications */
                                    $queryNotifMessages = 'SELECT * FROM message WHERE user_destination_id = ' . $_SESSION['id'] . ' AND user_id = ' . $converser['id'] . ' AND  seen_by_user_destination=false';
                                    $statementNotifMessages = $pdo->query($queryNotifMessages);
                                    $notifMessages = $statementNotifMessages->fetchAll();
                                    echo count($notifMessages);?>
                                    </p>   
                                </div> 
                            </div>
                        </div>
                <?php } else { 

                        $queryConverser = 'SELECT id, firstname, lastname FROM user WHERE id = ' . $conversation['sud'];
                        $statementConverser = $pdo->query($queryConverser);
                        $converser = $statementConverser->fetch();

                        ?>
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="notif-invitations">
                                    <a href="chat-conversation.php?id=<?php echo $converser['id'];?>">
                                        <div class="card text-center mt-4">
                                            <h5 class="p-2 text-black title-sumup"><?php echo ucwords($converser['firstname'] . ' ' . $converser['lastname']) ; ?></h5>
                                        </div>
                                    </a>
                                    <p class="chat-count-invitations">
                                    <?php
                                    /* all notifications */
                                    $queryNotifMessages = 'SELECT * FROM message WHERE user_destination_id = ' . $_SESSION['id'] . ' AND user_id = ' . $converser['id'] . ' AND  seen_by_user_destination=false';
                                    $statementNotifMessages = $pdo->query($queryNotifMessages);
                                    $notifMessages = $statementNotifMessages->fetchAll();
                                    echo count($notifMessages);?>
                                    </p>   
                                </div>
                            </div>
                        </div>
                <?php }} ?>

            </div>

        <?php include_once('footer.php'); ?>

</body>
</html>

<?php } ?>