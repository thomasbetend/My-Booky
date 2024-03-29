<?php 

$title="MyBooky - Connexion";

require('head.php');

?>

<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    /* Errors */

    /* fields empty */

    $errorMessage = '';

    if(empty($_POST['user_password']) || empty($_POST['user_lastname']) || empty($_POST['user_firstname']) || empty($_POST['user_email'])){

        $errorMessage = 'Remplissez tous les champs';
        
    }

    /* verifying profile */

    include_once('functions.php');

    $lastname = testInput($_POST['user_lastname']);
    $firstname = testInput($_POST['user_firstname']);
    $email = testInput($_POST['user_email']);
    $passUser = $_POST['user_password'];

    $query = 'SELECT * FROM user';
    $statement = $pdo->query($query);
    $users = $statement->fetchAll();


    if($users){
        foreach ($users as $user) {
            if (($user['lastname'] === $lastname) && ($user['firstname'] === $firstname) && ($user['email_user'] === $email) && (password_verify($passUser, $user['pass_user']))){

                session_start();
                
                $_SESSION['login'] = $user['pseudo'];

                /* creating variable session id */                

                $queryUserId = 'SELECT id FROM user WHERE email_user = \'' . $_POST['user_email'] . '\'';
                $statementUserId = $pdo->query($queryUserId);
                $userId = $statementUserId->fetch();

                $_SESSION['id'] = $userId['id'];

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
} ?>

<div class="container w-50">
    <div class="mt-5"></div>
        <h5 class="text-secondary">MyBooky</h5>
        <h3>Identifiez-vous</h3>
        <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="mt-3">
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