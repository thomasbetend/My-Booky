<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    /* Errors */

    /* fields empty */

    $errorMessage = '';
    
    if(empty($_POST['user_password']) || empty($_POST['user_lastname']) || empty($_POST['user_firstname']) || empty($_POST['user_email'])){

        $errorMessage = 'Remplissez tous les champs';

    }

    /* verifying profile */

    if($errorMessage = ''){

        include_once('functions.php');

        $lastname = testInput($_POST['user_lastname']);
        $firstname = testInput($_POST['user_firstname']);
        $email = testInput($_POST['user_email']);
        $passUser = $_POST['user_password'];

        $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
        $query = 'SELECT * FROM user';
        $statement = $pdo->query($query);
        $users = $statement->fetchAll();

        foreach ($users as $user) {
            if (($user['lastname'] == $lastname) && ($user['firstname'] == $firstname) && ($user['email_user'] == $email) && (password_verify($passUser, $user['pass_user']))){

                session_start();
                
                $_SESSION['login'] = $firstname . ' ' . $lastname;

                /* creating variable session id */                

                $queryUserId = 'SELECT id FROM user WHERE email_user = \'' . $_POST['user_email'] . '\'';
                $statementUserId = $pdo->query($queryUserId);
                $userId = $statementUserId->fetch();

                $_SESSION['id']= $userId['id'];

                /* initializing cart */ 
                
                $_SESSION['cart']=array();
                $_SESSION['cart']['book']=array();
                $_SESSION['cart']['author']=array();
                $_SESSION['cart']['quantity']=array();
                $_SESSION['cart']['price']=array();
                
                for($i=0; $i<10000; $i++){
                    $_SESSION['cart']['quantity'][$i]=0;
                    $_SESSION['cart']['price'][$i]=0;
                    $_SESSION['thumbup']['book'][$i]=0;
                }
                
                header('location: index.php');
                exit();

            } else {

                $errorMessage = 'Renseignements incorrects';

            }
        }
    } 
}

?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBooky - Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet"></head>
</head>
<body class="d-flex flex-column h-100">

    <?php include_once('nav-bar.php'); ?>

    <div class="container w-50">
        <div class="mt-5"></div>
            <h5 class="text-secondary">MyBooky</h5>
            <h3>Identifiez-vous</h3>
            <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="mt-3">
                <div class="form-group2">
                    <label for="user_firstname"></label> 
                    <input type="text" id="firstname" name="user_firstname" class="form-control" placeholder="Prénom">
                </div>
                <div class="form-group">
                    <label for="user_lastname"></label>
                    <input type="text" id="lastname" name="user_lastname" class="form-control" placeholder="Nom">
                </div>
                <div class="form-group">
                    <label for="user_email"></label>
                    <input type="email" id="email" name="user_email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group mb-2 mt-1">
                    <label for="user_password"></label>
                    <input type="password" id="password" name="user_password" class="form-control" placeholder="Mot de passe">
                </div>
                <div class="errorMessage">
                    <?php if (!empty($errorMessage)) echo $errorMessage ;?>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-2">Connexion</button>
                </div>
            </form>
            <p class="mt-4 text-secondary"><a href="signup.php">Pas encore inscrit ? Créez un compte.</a></p>
        </div>
    </div>

    <?php include_once('footer.php'); ?>

</body>
</html>









<!-- old version -->


<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $errorMessage = '';
    
    if(!empty($_POST['user_password']) && !empty($_POST['user_lastname']) && !empty($_POST['user_firstname']) && !empty($_POST['user_email'])){

        include_once('functions.php');
    
        $lastname = testInput($_POST['user_lastname']);
        $firstname = testInput($_POST['user_firstname']);
        $email = testInput($_POST['user_email']);
        $passUser = $_POST['user_password'];

        $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
        $query = 'SELECT * FROM user';
        $statement = $pdo->query($query);
        $users = $statement->fetchAll();

        foreach ($users as $user) {
            if (($user['lastname'] == $lastname) && ($user['firstname'] == $firstname) && ($user['email_user'] == $email) && (password_verify($passUser, $user['pass_user']))){

                session_start();
                
                $_SESSION['login'] = $firstname . ' ' . $lastname;

                /* creating variable session id */                

                $queryUserId = 'SELECT id FROM user WHERE email_user = \'' . $_POST['user_email'] . '\'';
                $statementUserId = $pdo->query($queryUserId);
                $userId = $statementUserId->fetch();

                $_SESSION['id']= $userId['id'];

                /* initializing cart */ 
                
                $_SESSION['cart']=array();
                $_SESSION['cart']['book']=array();
                $_SESSION['cart']['author']=array();
                $_SESSION['cart']['quantity']=array();
                $_SESSION['cart']['price']=array();
                
                for($i=0; $i<10000; $i++){
                    $_SESSION['cart']['quantity'][$i]=0;
                    $_SESSION['cart']['price'][$i]=0;
                    $_SESSION['thumbup']['book'][$i]=0;
                }
                
                header('location: index.php');
                exit();
    
            } else {
                $errorMessage = 'Renseignements incorrects';
            }
        }


    } else {
        $errorMessage = 'Remplissez tous les champs';
    }
} 

?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBooky - Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet"></head>
</head>
<body class="d-flex flex-column h-100">

    <?php include_once('nav-bar.php'); ?>

    <div class="container w-50">
        <div class="mt-5"></div>
            <h5 class="text-secondary">MyBooky</h5>
            <h3>Identifiez-vous</h3>
            <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="mt-3">
                <div class="form-group2">
                    <label for="user_firstname"></label> 
                    <input type="text" id="firstname" name="user_firstname" class="form-control" placeholder="Prénom">
                </div>
                <div class="form-group">
                    <label for="user_lastname"></label>
                    <input type="text" id="lastname" name="user_lastname" class="form-control" placeholder="Nom">
                </div>
                <div class="form-group">
                    <label for="user_email"></label>
                    <input type="email" id="email" name="user_email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group mb-2 mt-1">
                    <label for="user_password"></label>
                    <input type="password" id="password" name="user_password" class="form-control" placeholder="Mot de passe">
                </div>
                <div class="errorMessage">
                    <?php if (!empty($errorMessage)) echo $errorMessage ;?>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-2">Connexion</button>
                </div>
            </form>
            <p class="mt-4 text-secondary"><a href="signup.php">Pas encore inscrit ? Créez un compte.</a></p>
        </div>
    </div>

    <?php include_once('footer.php'); ?>

</body>
</html>



<?php if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['author_id'])){
                            $queryAuthorChoice = 'SELECT id, firstname, lastname FROM author WHERE id = ' . $_POST['author_id'];
                            $statementAuthorChoice = $pdo->query($queryAuthorChoice);
                            $authorChoice = $statementAuthorChoice->fetch();?>

                            <!-- author of search -->

                            <option value="<?php echo $authorChoice['id']; ?>"><?php echo ucwords($authorChoice['lastname'] . ' ' . $authorChoice['firstname'])?></option>
                            <option value="">Auteur</option>

                            <?php

                            /* rest of authors */

                            $queryAuthor = 'SELECT id, firstname, lastname FROM author WHERE lastname NOT LIKE \'%' . $authorChoice['lastname'] . '%\' ORDER BY lastname';
                            $statementAuthor = $pdo->query($queryAuthor);
                            $authors = $statementAuthor->fetchAll();

                            foreach($authors as $author) { ?>
                                <option value="<?php echo $author['id']?>"><?php echo ucwords($author['lastname'] . ' ' . $author['firstname'])?></option>
                            <?php } ?>

                            <?php } else { ?>

                                <option value="">Auteur</option>
                                <?php 
                                $queryAuthor = 'SELECT id, firstname, lastname FROM author ORDER BY lastname';
                                $statementAuthor = $pdo->query($queryAuthor);
                                $authors = $statementAuthor->fetchAll();

                            foreach($authors as $author) { ?>
                                <option value="<?php echo $author['id']?>"><?php echo ucwords($author['lastname'] . ' ' . $author['firstname'])?></option>
                        <?php }}