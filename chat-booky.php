<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBooky - ChatBooky</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5474cfcdca.js" crossorigin="anonymous"></script>
    <link href="styles.css" rel="stylesheet"></head>
</head>

<body class="d-flex flex-column h-100">

<?php 

  include_once('nav-bar.php'); 

  if(empty($_SESSION)){

    header('location:index.php');

  } else {

    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
    
    ?>

    <div class="container w-50 text-center">
      <h2 class="text-center mt-5">ChatBooky</h2>
    </div>

      <section class="h-100 h-custom" style="background-color: #eee;">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
              <div class="card mb-10">
                <div class="card-body p-4">
                  <div class="notif-invitations">
                    <h3>Commencez une nouvelle conversation</h3>
                  </div>
                  <div class="">
                    <form method="post" action="chat-notification-sent.php" class="chat-booky-form">
                      <select name="select-chat-user-id" id="select-user-chat" class="form-select chat-select-user">
                        <option value="">Choisissez utilisateur</option>
                        <?php 
                        
                        /* all users */
                            $queryAllUsers = 'SELECT id, firstname, lastname FROM user ORDER BY lastname';
                            $statementAllUsers = $pdo->query($queryAllUsers);
                            $allUsers = $statementAllUsers->fetchAll(); 
                            foreach($allUsers as $user){ ?>
                              <option value="<?php echo $user['id'] ?> " 
                                    <?php 
                                    if(!empty($_POST['select-chat-user-id']) && $_POST['select-chat-user-id'] == $user['id']){
                                      echo "selected";
                                    } ?> >
                                    <?php echo ucwords($user['firstname'] . ' ' . $user['lastname']) ;?></option>
                        <?php } ?>
                      </select>
                      <button type="submit" class="btn btn-primary">Envoyez une invitation</button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body p-4">
                    <h3><a href="chat-messages.php" class="chat-option-button">Messages</a></h3>                  
                </div>
              </div>
              <div class="card">
                <div class="card-body p-4">
                  <div class="notif-invitations">
                    <h3><a href="" class="chat-option-button">Invitations reçues</a></h3> 
                    <p class="chat-count-invitations">
                    <?php
                    /* all notifications */
                    $queryNotif = 'SELECT * FROM notification n WHERE user_id = ' . $_SESSION['id'] . ' AND type = \'invitation\'';
                    $statementNotif = $pdo->query($queryNotif);
                    $notifs = $statementNotif->fetchAll();
                    echo count($notifs);?>
                    </p>
                  </div>
                                    
                </div>
              </div>
          </div>
        </div>
      </section>
    


    <?php include_once('footer.php'); ?>

    </body>
    </html>

<?php } ?>