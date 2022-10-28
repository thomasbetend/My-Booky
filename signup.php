<?php 

if($_POST){

    $errorMessage = '';
    
    $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');

    $query = 'INSERT INTO user (lastname, firstname, pass_user, email_user) VALUES (:lastname, :firstname, :pass_user, :email_user)';
    
    
    if(!empty($_POST['user_lastname']) && !empty($_POST['user_firstname']) && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)){
                
                $queryUserExisting = 'SELECT * FROM user WHERE email_user = \'' . $_POST['user_email'] . '\'';
                $statementUserExisting = $pdo->query($queryUserExisting);
                $userExisting = $statementUserExisting->fetch();

                if ($userExisting) {
                    $errorMessage = 'Mail déjà utilisé';
                } else {

                if (preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[a-zA-Z0-9@&\"\'(§è!çà)-_?,.;\/:+=ù%£`$*#°]{8,50}$/", ($_POST['user_password']))) {

                    include_once('functions.php');

                    $lastname = testInput($_POST['user_lastname']);
                    $firstname = testInput($_POST['user_firstname']);
                    $email = testInput($_POST['user_email']);
                    $passUser = password_hash($_POST['user_password'], PASSWORD_DEFAULT);

                    
                    $statement = $pdo->prepare($query);
                
                    $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
                    $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
                    $statement->bindValue(':pass_user', $passUser, \PDO::PARAM_STR);
                    $statement->bindValue(':email_user', $email, \PDO::PARAM_STR);

                    $statement->execute();

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
                    $_SESSION['cart']['quantity']=array();
                    $_SESSION['cart']['price']=array();
                    
                    for($i=0; $i<1000; $i++){
                        $_SESSION['cart']['quantity'][$i]=0;
                        $_SESSION['cart']['price'][$i]=0;
                    }

                    header('location: index.php');
                    exit();
                } else {
                    $errorMessage = 'Mot de passe incorrect';
                }}
            
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
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">

    <?php include_once('nav-bar.php'); ?>

    <div class="container w-50">
        <div class="mt-5"></div>
            <h5 class="text-secondary">The Library Factory</h5>
            <h3>Créez votre compte</h3>
            <form method="post" class="mt-3">
                <div class="form-group mb-2">
                    <label for="firstname">Prénom</label>
                    <input type="text" id="firstname" name="user_firstname" class="form-control">
                </div>
                <div class="form-group mb-2">
                    <label for="lastname">Nom</label>
                    <input type="text" id="lastname" name="user_lastname" class="form-control">
                </div>
                <div class="form-group mb-2">
                    <label for="user_email">Email</label>
                    <input type="email" id="email" name="user_email" class="form-control">
                </div>
                <div class="form-group mb-2 mt-2">
                    <label for="user_password">Mot de passe</label>
                    <input type="password" id="password" name="user_password" class="form-control">
                    <p class='text-secondary'>Le mot de passe doit contenir 8 caractères minimum dont : <br/> 1 majuscule, 1 minuscule et 1 chiffre</p>
                </div>
                <div>
                    <?php if (!empty($errorMessage)) echo $errorMessage ; ?>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-2">Signup</button>
                </div>
            </form>
            <p class="mt-4 text-secondary"><a href="signin.php">Déjà inscrit ? Connectez-vous.</a></p>
        </div>
    </div>
    
    <?php include_once('footer.php'); ?>

</body>
</html>