<?php 

$title="MyBooky - Inscription";

require('head.php');

?>

<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $errorMessage = '';
    
    $query = 'INSERT INTO user (lastname, firstname, pseudo, pass_user, email_user) VALUES (:lastname, :firstname, :pseudo, :pass_user, :email_user)';
    
    /* Errors */

    /* Mail existing already */

    $queryUserExisting = 'SELECT * FROM user WHERE email_user = \'' . $_POST['user_email'] . '\'';
    $statementUserExisting = $pdo->query($queryUserExisting);
    $userExisting = $statementUserExisting->fetch();

    if ($userExisting) {

        $errorMessage = 'Mail déjà utilisé';

    }

    /* Password pattern */

    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[a-zA-Z0-9@&\"\'(§è!çà)-_?,.;\/:+=ù%£`$*#°]{8,50}$/", ($_POST['user_password']))){

        $errorMessage = 'Mot de passe incorrect';

    }

    /* mail security */

    if(filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL) === false){

        $errorMessage = 'Mail incorrect';

    }

    /* Empty fields */

    if(empty($_POST['user_lastname']) || empty($_POST['user_firstname'] || empty($_POST['pseudo']))){

        $errorMessage = 'Remplissez tous les champs';

    }


    if($errorMessage === '') {

        /* creating profile */

        include_once('functions.php');

        $pseudo = testInput($_POST['pseudo']);
        $lastname = testInput($_POST['user_lastname']);
        $firstname = testInput($_POST['user_firstname']);
        $email = testInput($_POST['user_email']);
        $passUser = password_hash($_POST['user_password'], PASSWORD_DEFAULT);

        
        $statement = $pdo->prepare($query);

        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
        $statement->bindValue(':pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->bindValue(':pass_user', $passUser, \PDO::PARAM_STR);
        $statement->bindValue(':email_user', $email, \PDO::PARAM_STR);

        $statement->execute();

        session_start();
        $_SESSION['login'] = $pseudo;

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

    }
}

?>

<div class="container w-50">
    <div class="mt-5"></div>
        <h5 class="text-secondary">MyBooky</h5>
        <h3>Créez votre compte</h3>
        <form method="post" class="mt-3">
            <div class="form-group2">
                <label for="pseudo"></label> 
                <input type="text" id="pseudo" name="pseudo" class="form-control" placeholder="Pseudo *" value="<?php if($_POST){echo $_POST['pseudo'];} ?>">
            </div>
            <div class="form-group2">
                <label for="user_firstname"></label> 
                <input type="text" id="firstname" name="user_firstname" class="form-control" placeholder="Prénom *" value="<?php if($_POST){echo $_POST['user_firstname'];} ?>">
            </div>
            <div class="form-group">
                <label for="user_lastname"></label>
                <input type="text" id="lastname" name="user_lastname" class="form-control" placeholder="Nom *" value="<?php if($_POST){echo $_POST['user_lastname'];} ?>">
            </div>
            <div class="form-group">
                <label for="user_email"></label>
                <input type="email" id="email" name="user_email" class="form-control" placeholder="Email *" value="<?php if($_POST){echo $_POST['user_email'];} ?>">
            </div>
            <div class="form-group mb-2 mt-1">
                <label for="user_password"></label>
                <input type="password" id="password" name="user_password" class="form-control" placeholder="Mot de passe *" value="<?php if($_POST){echo $_POST['user_password'];} ?>">
                <p class='text-secondary mt-3'>Le mot de passe doit contenir 8 caractères minimum dont : <br/> 1 majuscule, 1 minuscule et 1 chiffre</p>
            </div>
            <div  class="errorMessage">
                <?php if (!empty($errorMessage)) echo $errorMessage ; ?>
            </div>
            <div>
                <button type="submit" class="btn btn-primary mt-2">Créez votre compte</button>
            </div>
        </form>
        <p class="mt-4 text-secondary"><a href="signin.php">Déjà inscrit ? Connectez-vous.</a></p>
    </div>
</div>

<?php include_once('footer.php'); ?>

</body>
</html>